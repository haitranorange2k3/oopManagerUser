<?php
require_once 'connect.php';

// Truy van tat ca dta
// $sql = "SELECT * FROM hocsinh";

// try {
//     $statement = $conn -> prepare($sql);
//     $statement  -> execute();

//     // $data = $statement -> fetchAll(PDO::FETCH_NUM);
//     $data = $statement -> fetchAll(PDO::FETCH_ASSOC);

//     echo '<pre>';
//     print_r($data);
//     echo '</pre>';

// } catch (Exception $e) {
//     echo $e -> getMessage(). '<br>';
//     echo 'File: ' . $e ->getFile() . '<br>'; 
//     echo 'Line: ' . $e ->getLine() . '<br>'; 
// }


// Truy van 1 dong du lieu
$sql = "SELECT * FROM hocsinh WHERE id = ?";
// $id = 1;

try {
    $statement = $conn -> prepare($sql);

    $statement  -> execute([2]);

    // $arr = [$id];
    // $statement  -> execute($arr);

    // $data = $statement -> fetchAll(PDO::FETCH_NUM);
    $data = $statement -> fetch(PDO::FETCH_ASSOC);

    echo '<pre>';
    print_r($data);
    echo '</pre>';

} catch (Exception $e) {
    echo $e -> getMessage(). '<br>';
    echo 'File: ' . $e ->getFile() . '<br>'; 
    echo 'Line: ' . $e ->getLine() . '<br>'; 
}