<?php
require_once './config/database/db.php';

if (isset($_POST['submit'])) {
    if (empty($_POST['pwd'])) {
        $msg = "กรุณากรอกอีเมลล์";
    } else {
        $search = "SELECT ST_ID FROM studenttb WHERE CODE = :CODE limit 1";
        $query = $conn->prepare($search);
        $query->bindParam(':CODE', $_POST['code']);
        $query->execute();
        $row = $query->fetch();
        if (empty($row)) {
            $searchEm = "SELECT EM_ID FROM employeetb WHERE CODE = :CODE limit 1";
            $query = $conn->prepare($searchEm);
            $query->bindParam(':CODE', $_POST['code']);
            $query->execute();
            $rowEm = $query->fetch();
            if (empty($rowEm)) {
                $msg = "ไม่พบข้อมูลผู้ใช้";
            } else {
                $default = 0;
                $hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
                $EMPWD = "UPDATE employeetb SET EM_ID = :PWD, CODE = :CODE WHERE EM_ID = :EM_ID";
                $query = $conn->prepare($EMPWD);
                $query->bindParam(':PWD', $hash);
                $query->bindParam(':CODE', $default, PDO::PARAM_INT);
                $query->bindParam(':EM_ID', $rowEm['EM_ID']);
                if ($query->execute()) {
                    $msg = "เปลี่ยนรหัสผ่านสำเร็จ <a href='/index.php'>คลิ๊กเพื่อกลับหน้าหลัก</a>";
                } else {
                    $msg = "มีบางอย่างผิดพลาด";
                }
            }
        } else {
            $default = 0;
            $hash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
            $STPWD = "UPDATE studenttb SET ST_PASSWORD = :PWD, CODE = :CODE WHERE ST_ID = :ST_ID";
            $query = $conn->prepare($STPWD);
            $query->bindParam(':PWD', $hash);
            $query->bindParam(':CODE', $default, PDO::PARAM_INT);
            $query->bindParam(':ST_ID', $row['ST_ID']);
            if ($query->execute()) {
                $msg = "เปลี่ยนรหัสผ่านสำเร็จ <a href='/index.php'>คลิ๊กเพื่อกลับหน้าหลัก</a>";
            } else {
                $msg = "มีบางอย่างผิดพลาด";
            }
        }
    }
}
