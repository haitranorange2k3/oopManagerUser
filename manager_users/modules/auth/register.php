<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

$data = [
    'pageTitle' => 'Dang ky tai khoan'
];

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
        $sql = "SELECT id FROM users WHERE email = '$email'";
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

        $activeToken = sha1(uniqid() . time());
        $dataInsert = [
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'create_at' => date("Y-m-d H:i:s")

        ];

        $insertStatus = insert('users', $dataInsert);
        // echo '<pre>';
        // print_r($insertStatus);
        if ($insertStatus) {
            setFlashData('smg', 'Dang ky tai khoan thanh cong !');
            setFlashData('smg_type', 'success');

            // Tao link kich hoat
            $linkActive = _WEB_HOST . '?module=auth&action=active&token=' . $activeToken;

            // thiet lap gui mail
            $subject = $filterAll['fullname'] . ' ->>> Vui long kich hoat tai khoan cua ban !';
            $content = 'Xin chao <b>' . $filterAll['fullname'] . '</b><br>';
            $content .= 'Vui long hay kich hoat tai khoan cua ban de dang nhap, bang cach click vao duong link duoi day : ' . '<br>';
            $content .= $linkActive . '<br>';
            $content .= 'Tran trong cam on ban nhieu !';

            // Tien hanh gui Mail
            $sendMail = sendMail($filterAll['email'], $subject, $content);
            // if ($sendMail) {
            //     setFlashData('smg', 'Dang ky tai khoan thanh cong, Vui long kiem tra email cua ban de kich hoat tai khoan !');
            //     setFlashData('smg_type', 'success');
            // } else {
            //     setFlashData('smg', 'Dang ky tai khoan that bai, Vui long thu lai !');
            //     setFlashData('smg_type', 'danger');
            // }
        } else {
            setFlashData('smg', 'Dang ky tai khoan Khong thanh cong !');
            setFlashData('smg_type', 'danger');
        }
        redirect('?module=auth&&action=register');
    } else {
        setFlashData('smg', 'Vui long kiem tra lai du lieu nhap vao !');
        setFlashData('smg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
        redirect('?module=auth&&action=register');
    }


    // echo '<pre>';
    // print_r($errors);
}



layouts('header', $data);

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');

?>

<div class="row d-flex justify-content-center align-items-center mt-5 ">
    <div class="col-4 border border-primary p-4 ">
        <h2 class="text-center text-uppercase text-primary mb-4 ">Dang ky tai khoan User</h2>
        <?php if (!empty($smg)) {
            getSmg($smg, $smg_type);
        } ?>

        <form action="" method="post" class="was-validated ">
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
                <input name="email" type="email" class="form-control " placeholder="Email" value="
                <?php echo old('email', $old); ?>">
                <?php
                echo form_error('email', '<span class="valid-feedback text-danger">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group">
                <label for="" class="form-label ">Phone </label>
                <input name="phone" type="text" class="form-control " placeholder="number phone" value="
                <?php echo old('phone', $old); ?>">
                <?php
                echo form_error('phone', '<span class="valid-feedback text-danger">', '</span>', $errors);
                ?>
            </div>
            <div class="form-group">
                <label for="" class="form-label ">Password </label>
                <input name="password" type="password" class="form-control " placeholder="Mat khau" value="
                <?php echo old('password', $old); ?>">
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

            <button type="submit" class="btn btn-primary">Dang ky</button>
            <hr>
            <p class="text-sm-center "><a href="?module=auth&&action=login" class="btn-link ">Dang nhap tai khoan !</a></p>
        </form>
    </div>
</div>

<?php
layouts('footer');


?>