<?php
require_once '../../../config/database/db.php';


if (isset($_POST['lname'])) {
    try {
        $emailDomain = $_POST['username'];
        $Domain = explode("@", $emailDomain);
        if ($Domain[1] === "rmutr.ac.th" || $Domain[1] === "outlook.rmutr.ac.th") {
            try {
                $push = "INSERT INTO employeetb(EM_NAME, EM_LASTNAME, EM_USERNAME, EM_PASSWORD,EM_DEPART)" .
                    " VALUES (:EM_NAME,:EM_LASTNAME,:EM_USERNAME,:EM_PASSWORD,:EM_DEPART)";
                $querypush = $conn->prepare($push);
                $querypush->bindParam(':EM_NAME', $_POST['fname'], PDO::PARAM_STR);
                $querypush->bindParam(':EM_LASTNAME', $_POST['lname'], PDO::PARAM_STR);
                $querypush->bindParam(':EM_USERNAME', $emailDomain, PDO::PARAM_STR);
                $querypush->bindParam(':EM_PASSWORD', $_POST['password'], PDO::PARAM_STR);
                $querypush->bindParam(':EM_DEPART', $_POST['status'], PDO::PARAM_STR);
                if ($querypush->execute()) {
                    echo "ลงทะเบียนเข้าสู่ระบบสำเร็จ";
                } else {
                    echo "ลงทะเบียนเข้าสู่ระบบไม่สำเร็จ";
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else if ($Domain[1] !== "rmutr.ac.th" || $Domain[1] !== "outlook.rmutr.ac.th") {
            echo "กรุณาใช้ Email ของทางมหาวิทยาลัย";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST['del_user'])) {
    try {
        $del = "DELETE FROM employeetb WHERE EM_ID = :ID";
        $querydel = $conn->prepare($del);
        $querydel->bindParam(':ID', $_POST['del_user'], PDO::PARAM_INT);
        if ($querydel->execute()) {
            echo "ลบข้อมูลผู้ใช้สำเร็จ";
        } else {
            echo "ลบข้อมูลผู้ใช้ผิดพลาด";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
