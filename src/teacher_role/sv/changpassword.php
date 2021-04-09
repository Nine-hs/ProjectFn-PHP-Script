<?php
require_once '../../../config/database/db.php';

if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['newpassword'])) {
    $newPassword = $_POST['newpassword'];
}
if (isset($_POST['ad_id'])) {
    $director = $_POST['ad_id'];
}

try {
    if (isset($director) && isset($password)) {
        $sql = "SELECT EM_PASSWORD FROM employeetb WHERE EM_ID = :id limit 1";
        $query_pass = $conn->prepare($sql);
        $query_pass->bindParam(':id', $director, PDO::PARAM_STR);
        $query_pass->execute();
        $pass = $query_pass->fetch(PDO::FETCH_ASSOC);

        if ($pass['EM_PASSWORD'] !== $password) {
            echo "<script> alert('รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบดูอีกครั้ง'); window.location='../setting.php';</script>";
        } else {
            $sql = "UPDATE employeetb SET EM_PASSWORD = :NewPass WHERE EM_ID = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':NewPass', $newPassword, PDO::PARAM_STR);
            $query->bindParam(':id', $director, PDO::PARAM_STR);
            if ($query->execute()) {
                echo "<script>window.location=' ../index.php'</script>";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
