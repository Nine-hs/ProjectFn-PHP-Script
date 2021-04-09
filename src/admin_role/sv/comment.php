<?php

require_once '../../../config/database/db.php';

if(isset($_POST['status_comment'])){
    $status = $_POST['status_comment'];
}
if(isset($_POST['director_id'])){
    $director = $_POST['director_id'];
}
if(isset($_POST['form_id'])){
    $formid = $_POST['form_id'];
}
if(isset($_POST['date_of_comment'])){
    $date = $_POST['date_of_comment'];
}
if(isset($_POST['message'])){
    $message = $_POST['message'];
}

try{
    $sql = "UPDATE formtb SET DIRECTOR_ID = :DIRECTOR_ID ,REQ_STATUS_DIRECTOR = :REQ_STATUS_DIRECTOR ,".
            "DIRECTOR_DESCRIBE = :DIRECTOR_DESCRIBE "." ,DCMT_DATE = :CMT_DATE WHERE ".
            "FORM_ID = :FORM_ID";
    $query = $conn->prepare($sql);
    $query->bindParam(':DIRECTOR_ID',$director,PDO::PARAM_STR);
    $query->bindParam(':REQ_STATUS_DIRECTOR',$status,PDO::PARAM_STR);
    $query->bindParam(':DIRECTOR_DESCRIBE',$message,PDO::PARAM_STR);
    $query->bindParam(':CMT_DATE',$date,PDO::PARAM_STR);
    $query->bindParam(':FORM_ID',$formid,PDO::PARAM_STR);
    
    if($query->execute()){
        echo "<script> alert('พิจารณาผลการรับทุนเรียบร้อยแล้ว'); window.location='../index.php';</script>";
    }
}
catch(PDOException $e){
    echo $e->getMessage();
}



