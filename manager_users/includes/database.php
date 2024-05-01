<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

function query($sql, $data = [], $check = false)
{
    global $conn;
    $ketqua = false;
    // echo $sql; 
    // die();
    try {
        $statement = $conn->prepare($sql);

        if (!empty($data)) {
            $ketqua = $statement->execute($data);
        } else {
            $ketqua = $statement->execute();
        }
    } catch (Exception $e) {
        echo $e->getMessage() . '<br>';
        echo 'File: ' . $e->getFile() . '<br>';
        echo 'Line: ' . $e->getLine() . '<br>';
        die();
    }
    if ($check) {
        return $statement;
    }
    return $ketqua;
}

// Ham insert vao data
function insert($table, $data)
{
    $key = array_keys($data);
    $truong = implode(',', $key);
    $valuetb = ':' . implode(',:', $key);

    $sql = "INSERT INTO $table ($truong) VALUES ($valuetb)";
    $kq = query($sql, $data);
    return $kq;
}

// Ham insert vao data : sau khi len GPT
// function insert($table, $data) {
//     $keys = array_keys($data);
//     $fields = implode(',', $keys);
//     $placeholders = ':' . implode(',:', $keys);

//     $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";

//     $kq = query($sql, $data);
//     return $kq;
// }

// Ham update
function update($table, $data, $condition = '')
{
    $update = '';
    foreach ($data as $key => $value) {
        $update .= $key . '= :' . $key . ',';
    }
    $update = trim($update, ',');

    if (!empty($condition)) {
        $sql = "UPDATE $table SET $update WHERE $condition";
    } else {
        $sql = "UPDATE $table SET $update ";
    }
    $kq = query($sql, $data);
    return $kq;
}

// Ham delete 
function delete($table, $condition = '')
{
    if (!empty($condition)) {
        $sql = "DELETE FROM $table WHERE $condition";
    } else {
        $sql = "DELETE FROM $table";
    }

    $kq = query($sql);
    return $kq;
}

// Ham lay nhieu dong du lieu
function getRaw($sql) {
    $kq = query($sql, '', true);
    if (is_object($kq)) {
        $dataFetch = $kq -> fetchAll(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// Ham lay 1 dong du lieu
function oneRaw($sql) {
    $kq = query($sql, '', true);
    if (is_object($kq)) {
        $dataFetch = $kq -> fetch(PDO::FETCH_ASSOC);
    }
    return $dataFetch;
}

// Ham Dem so dong du lieu
function getRows($sql) {
    $kq = query($sql, '', true);
    if (!empty($kq)) {
        return $kq -> rowCount();
    }
}

