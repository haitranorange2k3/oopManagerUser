<?php
require_once 'connect.php';
$sql = "INSERT INTO hocsinh(fullname, age) VALUES (:fullname, :age)";

try {
    $statement = $conn -> prepare($sql);
    
    $fullname = 'Tran Van Hieu';
    $age = '10';
    // Cach 1 : 
    // $statement ->bindParam(':fullname', $fullname);
    // $statement ->bindParam(':age', $age);

    // Cach 2 :
    $data = [
        'fullname' => $fullname,
        'age' => $age
    ];
    
    // $insertStatus = $statement -> execute();
    $insertStatus = $statement -> execute($data);
    
    var_dump($insertStatus);
    
} catch (Exception $e) {
    echo $e -> getMessage(). '<br>';
    echo 'File: ' . $e ->getFile() . '<br>'; 
    echo 'Line: ' . $e ->getLine() . '<br>'; 
}