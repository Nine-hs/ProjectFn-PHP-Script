<?php

require_once '../../../config/database/db.php';

if(isset($_POST["id"]))
{
 $query = "DELETE from events WHERE id=:id";
 $statement = $conn->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}

?>
