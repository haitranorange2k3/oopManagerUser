<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

layouts('header');

$token = filter()['token'];

if (!empty($token)) {
    // Truy van de kiem tra token voi db
    $tokenQuery = oneRaw("SELECT id FROM users WHERE activeToken = '$token'");

    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];

        $updateStatus = update('users', $dataUpdate, "id = $userId");

        if ($updateStatus) {
            setFlashData('msg', 'Kich hoat tai khoan thanh cong, ban co the dang nhap ngay bay gio !');
            setFlashData('msq_type', 'success');
        } else {
            setFlashData('msg', 'Kich hoat tai khoan khong thanh cong, vui long lien he quan tri vien !');
            setFlashData('msq_type', 'danger');
            
        }
        redirect('?module=auth&&action=login');
    } else {
        getSmg('Lien ket khong ton tai, hoac da het han !', 'danger');
    }
}

?>
<h1>Active - Auth</h1>

<?php
layouts('footer');
?>