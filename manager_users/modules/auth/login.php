<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

$data = [
    'pageTitle' => 'Dang nhap tai khoan'
];

layouts('header', $data);
// Kiem tra trang thai dang nhap

if (isLogin()) {
    redirect('?module=home&&action=dashboard');
}


if (isPost()) {
    $filterAll = filter();
    // print_r($filterAll);
    if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
        // kiem tra dang nhap
        $email = $filterAll['email'];
        $password = $filterAll['password'];

        // Truy van lay thong tin user theo email
        $userQuery = oneRaw("SELECT id, password FROM users WHERE email = '$email'");

        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];
            if (password_verify($password, $passwordHash)) {

                // Kiem tra nguoi dung da login chua
                $userLogin = getRows("SELECT * FROM tokenlogin WHERE user_id = '$userId'");
                if ($userLogin > 0) {
                    setFlashData('smg', 'Tai khoan dang dang nhap noi khac, vui long thu lai sau !');
                    setFlashData('smg_type', 'danger');
                    redirect('?module=auth&&action=login');
                } else {
                    // Tao token login
                    $tokenLogin =  sha1(uniqid() . time());

                    // Insert vao bang loginToken
                    $dataInsert = [
                        'user_id' => $userId,
                        'token' => $tokenLogin,
                        'create_at' => date("Y-m-d H:i:s")
                    ];

                    $insertStatus = insert('tokenlogin', $dataInsert);
                    if ($insertStatus) {
                        // Insert thanh cong


                        // Luu cai tokenLogin vao session
                        setSession('loginToken', $tokenLogin);
                        redirect('?module=home&&action=dashboard');
                    } else {
                        setFlashData('smg', 'Khong the dang nhap, vui long thu lai sau !');
                        setFlashData('smg_type', 'danger');
                    }
                }
            } else {
                setFlashData('smg', 'Vui long nhap lai mat khau, mat khau khong ton tai  !');
                setFlashData('smg_type', 'danger');
            }
        } else {
            setFlashData('smg', 'Vui long nhap lai email, email khong ton tai  !');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Vui long nhap email va tai khoan !');
        setFlashData('smg_type', 'danger');
        redirect('?module=auth&&action=login');
    }
    redirect('?module=auth&&action=login');
}

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

?>


<div class="row d-flex justify-content-center align-items-center mt-5 ">
    <div class="col-4 border border-primary p-4 ">
        <h2 class="text-center text-uppercase text-primary mb-4 ">Dang nhap quan ly User</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="" class="form-label ">Email </label>
                <input name="email" type="email" class="form-control " placeholder="Dia chi email">
            </div>
            <div class="form-group">
                <label for="" class="form-label ">Password </label>
                <input name="password" type="password" class="form-control " placeholder="May khau">
            </div>
            <?php if (!empty($smg)) {
                getSmg($smg, $smg_type);
            } ?>
            <button type="submit" class="btn btn-primary">Dang nhap</button>
            <hr>
            <p class="text-sm-center "><a href="?module=auth&&action=forgot" class="btn-link ">Quen mat khau ?</a></p>
            <p class="text-sm-center "><a href="?module=auth&&action=register" class="btn-link ">Dang ky mat khau ?</a></p>
        </form>
    </div>
</div>


<?php
layouts('footer');


?>