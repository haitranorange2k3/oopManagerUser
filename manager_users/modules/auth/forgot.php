<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

$data = [
    'pageTitle' => 'Quen mat khau'
];

layouts('header', $data);

// Kiem tra trang thai dang nhap
if (isLogin()) {
    redirect('?module=home&&action=dashboard');
}


if (isPost()) {
    $filterAll = filter();
    if (!empty($filterAll['email'])) {
        $email = $filterAll['email'];
        // echo $email;

        $queryUser = oneRaw("SELECT id, fullname FROM users WHERE email = '$email'");
        if (!empty($queryUser)) {
            $userId = $queryUser['id'];

            // Tao forgot token
            $forgotToken = sha1(uniqid() . time());
            $dataUpdate = [
                'forgotToken' => $forgotToken
            ];

            $updateStatus = update('users', $dataUpdate, "id = $userId");
            if ($updateStatus) {
                // tao link reset, khoi phuc mat khau
                $linkReset = _WEB_HOST . '?module=auth&&action=reset&token=' . $forgotToken;

                // Gui email cho nguoi dung
                // thiet lap gui mail
                $subject = $queryUser['fullname'] . ' ->>> Yeu cau khoi phuc tai khoan cua ban !';
                $content = 'Xin chao <b>' . $queryUser['fullname'] . '</b><br>';
                $content .= 'Chung toi nhan duoc yeu cau khoi phuc lai mat khau cau ban truoc do , ban hay click vao duong link duoi day : ' . '<br>';
                $content .= $linkReset . '<br>';
                $content .= 'Tran trong cam on ban nhieu !';

                $sendEmail = sendMail($email, $subject, $content);
                if ($sendEmail) {
                    setFlashData('smg', 'Vui long kiem tra lai email de xem huong dan dat lai mat khau cua ban !');
                    setFlashData('smg_type', 'success');
                } else {
                    setFlashData('smg', 'Loi he thong, vui long thu lai sau ! (email)');
                    setFlashData('smg_type', 'danger');
                }
            } else {
                setFlashData('smg', 'Loi he thong, vui long thu lai sau !');
                setFlashData('smg_type', 'danger');
            }
        } else {
            setFlashData('smg', 'Dia chi email khong ton tai trong he thong !');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Vui long nhap dia chi email !');
        setFlashData('smg_type', 'danger');
    }

    // redirect('?module=auth&&action=forgot');
}

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');

?>


<div class="row d-flex justify-content-center align-items-center mt-5 ">
    <div class="col-4 border border-primary p-4 ">
        <h2 class="text-center text-uppercase text-primary mb-4 ">Quen mat khau</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="" class="form-label ">Email </label>
                <input name="email" type="email" class="form-control " placeholder="Dia chi email">
            </div>
            <?php if (!empty($smg)) {
                getSmg($smg, $smg_type);
            } ?>
            <button type="submit" class="btn btn-primary">Xac nhan</button>
            <hr>
            <p class="text-sm-center "><a href="?module=auth&&action=login" class="btn-link ">Dang nhap</a></p>
            <p class="text-sm-center "><a href="?module=auth&&action=register" class="btn-link ">Dang ky mat khau ?</a></p>
        </form>
    </div>
</div>


<?php
layouts('footer');


?>