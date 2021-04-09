<?php

//insert.php
require_once '../../../config/database/db.php';


if (isset($_POST["title"])) {

    $query = "
            INSERT INTO events 
            (title,	By_status, start_event, end_event) 
            VALUES (:title, :By_status, :start_event, :end_event)
            ";
    $statement = $conn->prepare($query);
    $statement->execute(
        array(
            ':title'  => $_POST['title'],
            ':By_status' => $_POST['by'],
            ':start_event' => $_POST['start'],
            ':end_event' => $_POST['end']
        )
    );
}
