<?php
// Thong tin ket noi
const _HOST = 'localhost';
const _DB = 'qlsv';
const _USER = 'root';
const _PASS = '';

try {
    if (class_exists('PDO')) {
        $dsn = 'mysql:dbname='. _DB . ';host=' . _HOST;

        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // set utf8
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Tao thong bao ra ngoai le khi gap loi
        ];

        $conn = new PDO($dsn,_USER,_PASS);
        // if ($conn) {
        //     echo 'Connect susscessfully !!!';
        // }
    }
} catch (Exception $exception) {
    echo '<div style="color: red; padding:5px 15px; border: 1px solid red;">';
    echo $exception -> getMessage();
    echo '</div>';
    die();   
}