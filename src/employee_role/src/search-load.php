<?php
require_once '../../../config/database/db.php';


if (isset($_POST['search'])) {

  $year = date('Y');
  $sql = "SELECT FORM_ID, CONCAT(f.F_NAME,' ',f.L_NAME) as FN,CONCAT(m.M_MAJOR,' ',f.ST_GEN) as MJ ," .
    " TTAL_SC, f.TO_ADMIN as ST,IF(f.BY_ADMIN = 1,'เลือก',CONCAT('คัดออก',' : ',f.COMMENT_HEAD)) as comment_head," .
    " REQ_STATUS_DIRECTOR,BY_ADMIN FROM formtb f " .
    "INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR INNER JOIN employeetb e ON f.DIRECTOR_ID=e.EM_ID WHERE e.EM_ID = :ID " .
    "AND YEAR(f.DATE_) = :YEARS ORDER BY f.TTAL_SC DESC";
  $query = $conn->prepare($sql);
  $query->execute(['ID' => $_POST['search'], 'YEARS' => $year]);
  $rows = $query->fetchAll(PDO::FETCH_ASSOC);
  $n = 1;
  foreach ($rows as $i) {
    echo "<tr>";
    echo "<th scope='row'>" . $n++ . "</th>";
    echo "<td>" . $i['FN'] . "</td>";
    echo "<td>" . $i['MJ'] . "</td>";
    echo "<td align='center'>";
    if ($i['REQ_STATUS_DIRECTOR'] == 0) {
      echo '<i class="fa fa-history" style="color:#FFD700;" aria-hidden="true"></i>';
    } else {
      echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
    }
    echo "</td>";
    echo "<td><a href='#' id='" . $i['FORM_ID'] . "' class='btnshow'>" . $i['TTAL_SC'] . " คะแนน</a></td>";
    echo "<td align='center'>";
    if ($i['BY_ADMIN'] == 0) {
      echo '<i class="fa fa-history" style="color:#FFD700;" aria-hidden="true"></i>';
    } else {
      echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
    }
    echo "</td>";
    echo "<td>" . $i['comment_head'] . "</td>";
    echo "</tr>";
  }
}
if (isset($_POST['find'])) {
  $year = date('Y');
  $f = "SELECT GRADE_SC, IC_SC, FM_SC, PS_SC, ACTY_SC, TTAL_SC, TO_ADMIN FROM formtb WHERE FORM_ID = :FIND AND YEAR(DATE_) = :YEARS";
  $query = $conn->prepare($f);
  $query->bindParam(':FIND', $_POST['find'], PDO::PARAM_INT);
  $query->bindParam(':YEARS', $year, PDO::PARAM_INT);
  $query->execute();
  $row = $query->fetch(PDO::FETCH_ASSOC);
  echo json_encode($row);
}
