<?php
require_once '../../../config/database/db.php';
$year = date('Y');
$sql = "SELECT ST_NUMBER, CONCAT(f.F_NAME,' ',f.L_NAME) as FULLNAME, CONCAT(m.M_MAJOR,' ',f.ST_GEN) as class FROM formtb f INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR WHERE YEAR(DATE_) = :YEAD AND REQ_STATUS != 0 AND REQ_STATUS_DIRECTOR != 0 AND BY_ADMIN = 1  ORDER BY CONCAT(M_MAJOR,' ',ST_GEN) , BY_ADMIN ASC";
$query = $conn->prepare($sql);
$query->execute([':YEAD' => $year]);
$row = $query->fetchAll();
$n = 1;
foreach ($row as $i) {
    echo  "<tr>";
    echo     "<td>" . $n++ . "</td>";
    echo     "<td>" . $i['ST_NUMBER'] . "</td>";
    echo     "<td>" . $i['FULLNAME'] . "</td>";
    echo     "<td>" . $i['class'] . "</td>";
    echo  "</tr>";
}
