<?php
require_once '../../../config/database/db.php';

if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['newpassword'])) {
    $newPassword = $_POST['newpassword'];
}
if (isset($_POST['st_id'])) {
    $studentid = $_POST['st_id'];
}

try {
    if (isset($director) && isset($password)) {
        $sql = "SELECT ST_PASSWORD FROM studenttb WHERE ST_ID = :id limit 1";
        $query_pass = $conn->prepare($sql);
        $query_pass->bindParam(':id', $studentid, PDO::PARAM_STR);
        $query_pass->execute();
        $pass = $query_pass->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $pass['ST_PASSWORD'])) {
            $Hashing = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE employeetb SET ST_PASSWORD = :NewPass WHERE ST_ID = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':NewPass', $Hashing, PDO::PARAM_STR);
            $query->bindParam(':id', $studentid, PDO::PARAM_STR);
            if ($query->execute()) {
               header('location: /Student_role');
            }
        } else {
                header('location: /Student_role/setting.php');
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
