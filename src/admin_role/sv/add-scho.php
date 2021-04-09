<?php

require_once '../../../config/database/db.php';

if (isset($_POST['button_save'])) {
    $sql = "UPDATE req_scholarship SET FROM_ID = :FORM WHERE R_SCHOLAR_ID = :ID ";
    $query = $conn->prepare($sql);
    $query->bindParam(':FORM', $_POST['student'], PDO::PARAM_STR);
    $query->bindParam(':ID', $_POST['r_id'], PDO::PARAM_STR);

    if ($query->execute()) {
        echo "บันทึกข้อมูลสำเร็จ";
    } else {
        echo "มีบางอย่างผิดพลาด";
    }
}




if (isset($_POST['scholar'])) {
    $year = date('Y');
    $sql = "SELECT SCHOLAR_ID, SCHOLAR_NAME, SCOLAR_AMOUNTH, SCHOLAR_VALUE,CURR_AMOUNT,CURR_VALUE FROM" .
        " scolartb WHERE SCHOLAR_ID = :ID AND YEAR(scolar_date) = :YEARS";
    $query = $conn->prepare($sql);
    $query->bindParam(':ID', $_POST['scholar'], PDO::PARAM_INT);
    $query->bindParam(':YEARS', $year, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
}
?>



<?php
if (isset($_POST['major_id'])) {
    $year = date('Y');
    $major = "SELECT FORM_ID,CONCAT(f.F_NAME,' ',f.L_NAME,' - ',m.M_MAJOR,' ',f.ST_GEN) as NAMEST," .
        " IF((SELECT r.FROM_ID FROM req_scholarship r WHERE r.FROM_ID = f.FORM_ID),'ALREADY','YET') as ST_YET" .
        " FROM formtb f INNER JOIN majors m ON f.ST_MAJORS = m.ID_MAJOR WHERE m.ID_MAJOR = :MAJORID AND YEAR(f.DATE_) = :YEARS AND BY_ADMIN = 1";
    $queryMJ = $conn->prepare($major);
    $queryMJ->bindParam(':MAJORID', $_POST['major_id'], PDO::PARAM_INT);
    $queryMJ->bindParam(':YEARS', $year, PDO::PARAM_STR);
    $queryMJ->execute();
    $rows = $queryMJ->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $st) {
        if ($st['ST_YET'] == "ALREADY") {
        } else if ($st['ST_YET'] == "YET") {
?>
            <div class="checkbox">
                <div class="col-sm-12 col-md-3">
                    <label style="margin-bottom: 5px;">
                        <input type="checkbox" name="Student_id[]" id="Student_id" value="<?php echo $st['FORM_ID']; ?>">
                        <?php echo $st['NAMEST']; ?>
                    </label>
                </div>
            </div>
<?php
        }
    }
}
?>

<?php
if (isset($_POST['r_id'])) {
    $sql = "INSERT INTO req_scholarship(R_ID, FROM_ID,R_AMOUNT,R_VALUE) VALUES (:R_ID,:FROM_ID,:R_AMOUNT,:R_VALUE)";
    $query = $conn->prepare($sql);
    $count = count($_POST['Student_id']);
    for ($i = 0; $i < $count; $i++) {
        $insert = $query->execute([':ID' => $ST_ID, ':NAME' => $NOS[$i], ':YEAY' => $YOS[$i], ':CATE' => $COS[$i], ':PERTY' => $POS[$i], ':VALUE' => $VOS[$i]]);
    }
    $query->execute(['R_ID' => $_POST[''], 'FROM_ID' => $_POST[''], 'R_AMOUNT' => $_POST[''], 'R_VALUE' => $_POST['']]);

    if ($query->execute()) {
        echo "บันทึกข้อมูลสำเร็จ";
    } else {
        echo "มีบางอย่างผิดพลาด";
    }
}

?>

<?php
if (isset($_POST['findscholar'])) {
    $arr = array();
    $year = date('Y');
    $findscho = "SELECT SCHOLAR_ID, SCHOLAR_NAME, SCOLAR_AMOUNTH, SCHOLAR_VALUE, CURR_AMOUNT, CURR_VALUE" .
        " FROM scolartb WHERE SCHOLAR_ID = :ID AND YEAR(scolar_date) = :YEARS";
    $querySCHO = $conn->prepare($findscho);
    $querySCHO->bindParam(':ID', $_POST['findscholar']);
    $querySCHO->bindParam(':YEARS', $year);
    $querySCHO->execute();
    $rs = $querySCHO->fetch(PDO::FETCH_ASSOC);
    $sholar = round($rs['CURR_VALUE'] / $rs['CURR_AMOUNT']);
    $newscolarship = array($amout = 1, $sholar);
    $arr[] = $rs;
    $arr[] = $newscolarship;
    echo json_encode($arr);
}
?>