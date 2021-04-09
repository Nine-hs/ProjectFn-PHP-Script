<?php
require_once '../../../config/database/db.php';

if (isset($_POST['director'])) {
    $direcotr = $_POST['director'];
    $formid = $_POST['formid'];
    $sql = "UPDATE formtb SET DIRECTOR_ID = :DIRECTOR WHERE FORM_ID = :ID";
    $query = $conn->prepare($sql);
    $query->bindParam(':DIRECTOR', $direcotr, PDO::PARAM_STR);
    $query->bindParam(':ID', $formid, PDO::PARAM_STR);
    
    if($query->execute()){
        echo "เพิ่มข้อมูลสำเร็จ";
    }else{
        echo "ผิดพลาด";
    }
}
