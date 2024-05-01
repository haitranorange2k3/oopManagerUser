<?php
require_once 'connect.php';

$sql = "DELETE FROM hocsinh WHERE id = ?";
$id = 3;

try {
    $statement = $conn -> prepare($sql);

    $data = [$id];
    $deleteStatus = $statement -> execute($data);
    var_dump($deleteStatus);
    
} catch (Exception $e) {
    echo $e -> getMessage(). '<br>';
    echo 'File: ' . $e ->getFile() . '<br>'; 
    echo 'Line: ' . $e ->getLine() . '<br>'; 
}