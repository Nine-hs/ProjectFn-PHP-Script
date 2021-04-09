<?php
require_once '../../../config/database/db.php';

if (isset($_POST['findBYID'])) {
    $year = date('Y');
    $sql = "SELECT FORM_ID,CONCAT(fb.F_NAME,' ',fb.L_NAME) as FULLST ,CONCAT(m.M_MAJOR,' ',fb.ST_GEN) as MAJORS," .
        "rs.REQ_STATUS as RE_STATUS,fb.REQ_STATUS as REQ_STATUS,DIRECTOR_ID FROM formtb fb INNER JOIN majors m ON fb.ST_MAJORS=m.ID_MAJOR" .
        " INNER JOIN  req_status rs ON fb.REQ_STATUS=rs.REQSTATUS_ID WHERE FORM_ID LIKE CONCAT('%', :ID, '%')".
        " AND YEAR(fb.DATE_) = :YEARS AND fb.REQ_STATUS !=0 AND fb.FORM_ID !=0 ORDER BY fb.DATE_ DESC";
    $query = $conn->prepare($sql);
    $query->bindParam(':ID', $_POST['findBYID'], PDO::PARAM_STR);
    $query->bindParam(':ID', $_POST['findBYID'], PDO::PARAM_STR);
    $query->bindParam(':YEARS', $year, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetchAll();
    $n = 1;
    foreach ($row as $i) {
        if ($i['REQ_STATUS'] === "1") {
            $msg = "success";
        } else {
            $msg = "danger";
        }
        echo "<form id='form'>";
        echo "<tr>";
        echo "<th scope='row'>" . $n++ . "</th>";
        echo "<input type='hidden' name='formid' value='" . $i['FORM_ID'] . "'>";
        echo "<td>" . $i['FULLST'] . "</td>";
        echo "<td>" . $i['MAJORS'] . "</td>";
        echo "<td><span class='badge bg-" . $msg . "'>" . $i['RE_STATUS'] . "</span></td>";
        echo "<td>";
        if ($i['DIRECTOR_ID'] == 0) {
            echo "<select class='form-select form-select-sm' name='director' aria-label='form-select-sm example'>";
            $seachDirector = "SELECT EM_ID,CONCAT(EM_NAME,' ',EM_LASTNAME) as Director FROM employeetb";
            $query = $conn->query($seachDirector);
            $row = $query->fetchAll();
            foreach ($row as $d) {
                echo "<option value='" . $d['EM_ID'] . "'>" . $d['Director'] . "</option>";
            }
            echo "</select>";
        } else {
            echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
        }
        echo "</td>";
        echo "<td>";
        if ($i['DIRECTOR_ID'] == 0) {
            echo "<button type='submit' class='btn btn-success btn-sm'>เลือก</button>";
        } else {
            echo '<a href="info.php?form=' . $i['FORM_ID'] . '">ข้อมูลเพิ่มเติม</a>';
        }
        echo "</td>";
        echo "</tr>";
        echo "</form>";
    }
} else {
    echo "";
}
