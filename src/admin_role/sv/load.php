<?php

require_once '../../../config/database/db.php';

if (isset($_POST['search'])) {
  $year = date('Y');
  $sql = "SELECT FORM_ID,f.ST_NUMBER as NUMBERST, CONCAT(f.F_NAME,' ',f.L_NAME) as FN,CONCAT(m.M_MAJOR,' ',f.ST_GEN) as MJ , TTAL_SC,BY_ADMIN FROM" .
    " formtb f INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR INNER JOIN employeetb e ON f.DIRECTOR_ID=e.EM_ID  WHERE" .
    " e.EM_ID = :ID AND YEAR(f.DATE_) = :YEARS  ORDER BY f.TTAL_SC DESC";
  $query = $conn->prepare($sql);
  $query->execute(['ID' => $_POST['search'], 'YEARS' => $year]);
  $row = $query->fetchAll();
  $n = 1;
  foreach ($row as $i) {
    echo "<tr>";
    echo "<th scope='row'>" . $n++ . "</th>";
    echo "<td>" . $i['NUMBERST'] . "</td>";
    echo "<td>" . $i['FN'] . "</td>";
    echo "<td>" . $i['MJ'] . "</td>";
    echo "<td>" . $i['TTAL_SC'] . "</td>";
    echo  "<td colspan='2'>";
    if ($i['BY_ADMIN'] > 0) {
      echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
    } else {
      echo "<button type='button' id='" . $i['FORM_ID'] . "' class='btn btn-success btn-sm btn-id'>เลือก</button>";
      echo "<button type='button' id='" . $i['FORM_ID'] . "' class='btn btn-warning btn-del btn-sm'>คัดออก</button>";
    }


    echo "<a href='consider.php?form=" . $i['FORM_ID'] . "' class='btn btn-light btn-sm'>ดูประวัติ</a></td>";
    echo "</tr>";
  }
}
