<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

// Kiem tra id trng db -> ton tai -> tien hanh xoa
// Xoa du lieu bang Login Token -> Xoa dl bang users

$filterAll = filter();
if (!empty($filterAll['id'])) {
    $userId = $filterAll['id'];
    $userDetail = getRows("SELECT * FROM users WHERE id = '$userId'");
    if ($userDetail > 0) {
        // Thuc hien xoa
        $deleteToken = delete('tokenlogin', "user_id = '$userId'");
        if ($deleteToken) {
            // Xoa user
            $deleteUSer = delete('users', "id = '$userId'");
            if ($deleteUSer) {
                setFlashData('smg', 'Xoa nguoi dung thanh cong !');
                setFlashData('smg_type', 'danger');
            } else {
                setFlashData('smg', 'Loi he thong, Xoa nguoi dung khong thanh cong !');
                setFlashData('smg_type', 'danger');
            }
        }
    } else {
        setFlashData('smg', 'Lien ket khong ton tai !');
        setFlashData('smg_type', 'danger');
    }
} else {
    setFlashData('smg', 'Lien ket khong ton tai !');
    setFlashData('smg_type', 'danger');
}


redirect('?module=users&action=list');
