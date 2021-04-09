<?php

//update.php
require_once '../../../config/database/db.php';

if (isset($_POST["id"])) {
    $query = "
 UPDATE events 
 SET title=:title,By_status = :By_status, start_event=:start_event, end_event=:end_event 
 WHERE id=:id
 ";
    $statement = $conn->prepare($query);
    $statement->execute(
        array(
            'title'  => $_POST['title'],
            'By_status'  => $_POST['By_status'],
            'start_event' => $_POST['start'],
            'end_event' => $_POST['end'],
            'id'   => $_POST['id']
        )
    );
}
