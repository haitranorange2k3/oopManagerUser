<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}
$data = [
    'pageTitle' => 'Trang Dashboard'
];

layouts('header', $data);
layouts('navbar');


// echo getSession('loginToken');

// Kiem tra trang thai dang nhap
if (!isLogin()) {
    redirect('?module=auth&&action=login');
}
?>

<div class="container ">
    <h1> <i class="fa-regular fa-newspaper"></i> DashBoard</h1>
</div>
<?php
layouts('footer');

?>