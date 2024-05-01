<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

$data = [
    'pageTitle' => 'Dat lai mat khau'
];

layouts('header', $data);
// Kiem tra trang thai dang nhap

if (isLogin()) {
    redirect('?module=home&&action=dashboard');
}



$token = filter()['token'];
if (!empty($token)) {
    // Truy van db de kiem tra token
    $tokenQuery = oneRaw("SELECT id, fullname, email FROM users WHERE forgotToken = '$token'");
    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        if (isPost()) {
            $filterAll = filter();
            $errors = []; // mang chua cac loi validate

            // Validate password : bat buoc phai nhap, >= 8 ky tu
            if (empty($filterAll['password'])) {
                $errors['password']['require'] = 'Mat khau bat buoc phai nhap !';
            } else {
                if (strlen($filterAll['password']) < 8) {
                    $errors['password']['min'] = 'Mat khau phai co it nhat 8 ky tu !';
                }
            }

            // validate password_confirm : bat buoc phai nhap , giong password
            if (empty($filterAll['password_confirm'])) {
                $errors['password_confirm']['require'] = 'Ban phai nhap lai mat khau !';
            } else {
                if ($filterAll['password_confirm'] != $filterAll['password']) {
                    $errors['password_confirm']['match'] = 'Mat khau nhap lai khong dung !';
                }
            }

            if (empty($errors)) {
                // Xu ly update mat khau
                $passwordHash = password_hash($filterAll['password'], PASSWORD_DEFAULT);
                $dataUpdate = [
                    'password' => $passwordHash,
                    'forgotToken' => null,
                    'update_at' => date('Y-m-d H:i:s')
                ];

                $updateStatus = update('users', $dataUpdate, "id = '$userId'");

                print_r($updateStatus);
                die();

                if ($updateStatus) {
                    setFlashData('smg', 'Thay doi mat khau thanh cong !');
                    setFlashData('smg_type', 'success');
                    redirect('?module=auth&&action=login');
                } else {
                    setFlashData('smg', 'Loi he thong, vui long kiem tra lai sau ! (email reset)');
                    setFlashData('smg_type', 'danger');
                }
            } else {
                setFlashData('smg', 'Loi he thong, vui long kiem tra lai sau !');
                setFlashData('smg_type', 'danger');
                setFlashData('errors', $errors);
                redirect('?module=auth&&action=reset&token' . $token);
            }
        }

        $smg = getFlashData('smg');
        $smg_type = getFlashData('smg_type');
        $errors = getFlashData('errors');
?>
        <!-- FORM dat lai mat khau -->
        <div class="row d-flex justify-content-center align-items-center mt-5 ">
            <div class="col-4 border border-primary p-4 ">
                <h2 class="text-center text-uppercase text-primary mb-4 ">Dat lai mat khau</h2>

                <form action="" method="post" class="was-validated ">
                    <div class="form-group">
                        <?php if (!empty($smg)) {
                            getSmg($smg, $smg_type);
                        } ?>

                        <label for="" class="form-label ">Password </label>
                        <input name="password" type="password" class="form-control " placeholder="Mat khau">
                        <?php
                        echo form_error('password', '<span class="valid-feedback text-danger">', '</span>', $errors);
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label ">Comfirm Pass </label>
                        <input name="password_confirm" type="password" class="form-control " placeholder="Nhap lai mat khau">
                        <?php
                        echo form_error('password_confirm', '<span class="valid-feedback text-danger">', '</span>', $errors);
                        ?>
                    </div>
                    <input type="hidden" name="token">

                    <button type="submit" class="btn btn-primary">Dat lai</button>
                    <hr>
                    <p class="text-sm-center "><a href="?module=auth&&action=login" class="btn-link ">Dang nhap tai khoan !</a></p>
                </form>
            </div>
        </div>
<?php
    } else {
        getSmg('Lien ket khong ton tai hoac da het han !', 'danger');
    }
} else {
    getSmg('Lien ket khong ton tai hoac da het han !', 'danger');
}
?>


<?php
layouts('footer');

?>