<?php
require_once '../../../config/database/db.php';

if (isset($_POST['e_lname'])) {
    try {
        $edit = "UPDATE employeetb SET EM_NAME = :EM_NAME, EM_LASTNAME = :EM_LASTNAME," .
            " EM_USERNAME = :EM_USERNAME, EM_DEPART = :EM_DEPART WHERE EM_ID = :ID";
        $queryEdit = $conn->prepare($edit);
        $queryEdit->bindParam(':EM_NAME', $_POST['e_fname'], PDO::PARAM_STR);
        $queryEdit->bindParam(':EM_LASTNAME', $_POST['e_lname'], PDO::PARAM_STR);
        $queryEdit->bindParam(':EM_USERNAME', $_POST['e_username'], PDO::PARAM_STR);
        $queryEdit->bindParam(':EM_DEPART', $_POST['e_status'], PDO::PARAM_STR);
        $queryEdit->bindParam(':ID', $_POST['e_user_id'], PDO::PARAM_STR);
        $queryEdit->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}