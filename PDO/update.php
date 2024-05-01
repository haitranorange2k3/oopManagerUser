<?php
require_once 'connect.php';

$sql = "UPDATE hocsinh SET fullname = :fullname, age = :age WHERE id = :id";
// data 
$fullname = 'Tran Minh Hieu';
$age = 21;
$id = 2;
try {
    $statement = $conn -> prepare($sql);

    // Cach 1 : 
    // $statement ->bindParam(':fullname', $fullname);
    // $statement ->bindParam(':age', $age);
    // $statement ->bindParam(':id', $id);

    // Cach 2 :
    $data = [
        'fullname' => $fullname,
        'age' => $age,
        'id' => $id
    ];
    
    // $updateStatus = $statement -> execute();
    $updateStatus = $statement -> execute($data);
    
    if ($updateStatus) {
        echo 'Update thanh cong !';
    }
    
    
} catch (Exception $e) {
    echo $e -> getMessage(). '<br>';
    echo 'File: ' . $e ->getFile() . '<br>'; 
    echo 'Line: ' . $e ->getLine() . '<br>'; 
}