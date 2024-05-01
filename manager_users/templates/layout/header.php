<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($data['pageTitle']) ? $data['pageTitle'] : 'Quan ly nguoi dung';; ?></title>
    <link rel="stylesheet" href="<?= _WEB_HOST_TEMPLATES; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= _WEB_HOST_TEMPLATES; ?>/css/style.css?ver=<?= rand(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>