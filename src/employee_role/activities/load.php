<?php

//load.php

require_once '../../../config/database/db.php';

$data = array();
//SELECT id,CONCAT(ev.title,' : ',ev.By_status) as title ,start_event,end_event FROM events ev  ORDER BY id
$query = "SELECT id,title ,start_event,end_event FROM events ev  ORDER BY id";

$statement = $conn->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => $row["title"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}

echo json_encode($data);
