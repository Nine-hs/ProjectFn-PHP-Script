<?php
require_once '../../../config/database/db.php';
session_start();
$year = date('Y');
$n = 1;
$sql = "SELECT FORM_ID, ST_NUMBER,CONCAT(F_NAME,'   ',L_NAME) ST_FULL,CONCAT(m.M_MAJOR,'',f.ST_GEN) MAJOR,REQ_STATUS FROM formtb f INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR WHERE f.FORM_ID !=0 AND f.AD_ID = :AD_ID AND YEAR(DATE_) = :YEARS";
$query = $conn->prepare($sql);
$query->execute(['AD_ID' => $_SESSION['Accout_id'], 'YEARS' => $year]);
$row = $query->fetchAll();
foreach ($row as $i) {
    echo "<tr>";
    echo  "<td>" . $n++ . "</td>";
    echo  "<td>" . $i['ST_NUMBER'] . "</td>";
    echo  "<td>" . $i['ST_FULL'] . "</td>";
    echo  "<td>" . $i['MAJOR'] . "</td>";
    echo  "<td>";
    if ($i['REQ_STATUS'] == 0) {
        echo '<i class="fa fa-history" style="color:#FFD700;" aria-hidden="true"></i>';
    } else {
        echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
    }
    echo  "</td>";
    echo  "<td><a href='consider.php?form=" . $i['FORM_ID'] . "' class='btn btn-success '><i class='fa fa-pencil-square-o margin-r-5' aria-hidden='true'></i>บันทึก</a></td>";
    echo "</tr>";
}
