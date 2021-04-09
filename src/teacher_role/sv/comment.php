<?php

require_once '../../../config/database/db.php';

if(isset($_POST['status_comment'])){
    $status = $_POST['status_comment'];
}
if(isset($_POST['aivisor_id'])){
    $aivisor = $_POST['aivisor_id'];
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
    $sql = "UPDATE formtb SET ADVISOR_ID = :ADVISOR_ID ,REQ_STATUS = :REQ_STATUS ,".
            "ADVISOR_DESCRIBE = :ADVISOR_DESCRIBE "." ,CMT_DATE = :CMT_DATE WHERE ".
            "FORM_ID = :FORM_ID";
    $query = $conn->prepare($sql);
    $query->bindParam(':ADVISOR_ID',$aivisor,PDO::PARAM_STR);
    $query->bindParam(':REQ_STATUS',$status,PDO::PARAM_STR);
    $query->bindParam(':ADVISOR_DESCRIBE',$message,PDO::PARAM_STR);
    $query->bindParam(':CMT_DATE',$date,PDO::PARAM_STR);
    $query->bindParam(':FORM_ID',$formid,PDO::PARAM_STR);
    
    if($query->execute()){
        header('location: ../index.php');
    }
}
catch(PDOException $e){
    echo $e->getMessage();
}



