<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

$data = [
    'pageTitle' => 'Sua thong tin nguoi dung'
];

$filterAll = filter();
if (!empty($filterAll['id'])) {
    $userId = $filterAll['id'];
    // Kiem tra xem userID co ton tai trong db hay khong
    // Neu ton tai => Lay ra thong tin nguoi dung
    // Neu khong ton tai => Chuyen huong ve trang list

    $userDetail = oneRaw("SELECT * FROM users WHERE id = '$userId'");
    if (!empty($userDetail)) {
        // Ton tai
        setFlashData('user-detail', $userDetail);
    } else {
        redirect('?module=users&action=list');
    }
}


if (isPost()) {
    $filterAll = filter();
    $errors = []; // mang chua cac loi

    // Validate fullname : bat buoc phai nhap, min la 5 ky tu
    if (empty($filterAll['fullname'])) {
        $errors['fullname']['require'] = 'Ho ten bat buoc phai nhap !';
    } else {
        if (strlen($filterAll['fullname']) < 5) {
            $errors['fullname']['min'] = 'Ho ten phai co it nhat 5 ky tu !';
        }
    }
    // Email Validate : bat buoc phai nhap, sung dinh dang email, kiem tra xem da ton tai trong csdl chua
    if (empty($filterAll['email'])) {
        $errors['email']['require'] = 'Email bat buoc phai nhap !';
    } else {
        $email = $filterAll['email'];
        $sql = "SELECT id FROM users WHERE email = '$email' AND id <> '$userId'";
        if (getRows($sql) > 0) {
            $errors['email']['unique'] = 'Email da ton tai !';
        }
    }

    // Validate so dien thoai : bat buoc phai nhap, so co dung dinh dang khong
    if (empty($filterAll['phone'])) {
        $errors['phone']['require'] = 'So dien thoai bat buoc phai nhap !';
    } else {
        if (!isPhone($filterAll['phone'])) {
            $errors['phone']['isPhone'] = "So dien thoai khong hop le !";
        }
    }




    // Trong truong hop pass co du lieu thi moi validate , mac dinh sua mk thi k can nhap
    if (!empty($filterAll['password'])) {
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
    }


    if (empty($errors)) {

        $activeToken = sha1(uniqid() . time());
        $dataUpdate = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'status' => $filterAll['status'],
            'create_at' => date("Y-m-d H:i:s")

        ];

        if (!empty($filterAll['password'])) {
            $dataUpdate['password'] = password_hash($filterAll['password'], PASSWORD_DEFAULT);
        }

        $condition = "id = '$userId'";
        $updateStatus = update('users', $dataUpdate, $condition);

        if ($updateStatus) {
            setFlashData('smg', 'Sua nguoi dung moi thanh cong !');
            setFlashData('smg_type', 'success');
        } else {
            setFlashData('smg', 'Sua nguoi dung moi that bai, he thong gap loi !');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Vui long kiem tra lai du lieu nhap vao !');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
    }

    redirect('?module=users&&action=edit&id=' . $userId);
}



layouts('header', $data);

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
$userOne = getFlashData('user-detail');
if (!empty($userOne)) {
    $old = $userOne;
}

?>

<!-- <div class="row d-flex justify-content-center align-items-center mt-5 "> -->
<div class="container ">
    <!-- <div class="col-4 border border-primary p-4 "> -->
    <div class="row"></div>
    <h2 class="text-center text-uppercase text-primary my-4  ">Sua nguoi dung </h2>
    <?php if (!empty($smg)) {
        getSmg($smg, $smg_type);
    } ?>

    <form action="" method="post" class="was-validated ">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="" class="form-label ">Fullname </label>
                    <input name="fullname" type="fullname" class="form-control " placeholder="Ho ten" value="
                <?php echo old('fullname', $old); ?>">
                    <?php
                    echo form_error('fullname', '<span class="valid-feedback text-danger">', '</span>', $errors);
                    ?>

                </div>
                <div class="form-group">
                    <label for="" class="form-label ">Email </label>
                    <input name="email" type="email" class="form-control " placeholder="Dia chi email" value="
                <?php echo old('email', $old); ?>">
                    <?php
                    echo form_error('email', '<span class="valid-feedback text-danger">', '</span>', $errors);
                    ?>
                </div>
                <div class="form-group">
                    <label for="" class="form-label ">Phone </label>
                    <input name="phone" type="text" class="form-control " placeholder="number phone" value="
                <?php echo old('phone', $old);  ?>">
                    <?php
                    echo form_error('phone', '<span class="valid-feedback text-danger">', '</span>', $errors);
                    ?>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="" class="form-label ">Password </label>
                    <input name="password" type="password" class="form-control " placeholder="Mat khau (neu khong muon thay doi thi khong can nhap)">
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

                <div class="form-group">
                    <label for="" class="form-label ">Status</label>
                    <select name="status" id="" class="form-control ">
                        <option value="0" <?php echo old('status', $old) == 0 ? 'selected' : false; ?>>Un-Active</option>
                        <option value="1" <?php echo old('status', $old) == 1 ? 'selected' : false; ?>>Active</option>
                    </select>
                </div>
            </div>
        </div>

        <input type="hidden" name="id" value="<?php echo $userId; ?>">

        <button type="submit" class="btn btn-success  w-25 ">Sua nguoi dung</button>
        <hr>
        <a href="?module=users&action=list" class="btn btn-dark ">Return List</a>
    </form>
</div>
</div>

<?php
layouts('footer');


?>