<?php

require_once '../../../config/database/db.php';

if (isset($_POST['status_comment'])) {
    $status = $_POST['status_comment'];
    $director = $_POST['director_id'];
    $formid = $_POST['form_id'];
    $date = $_POST['date_of_comment'];
    $message = $_POST['message'];
    $GradeScore = $_POST['gradeScore'];
    $IncomeFMLY = $_POST['incomeScore'];
    $FAMLY = $_POST['familyScore'];
    $PersonSC = $_POST['personScore'];
    $ActySC = $_POST['actyScore'];
    $num = ($GradeScore + $IncomeFMLY + $FAMLY + $PersonSC + $ActySC);
    $to_admin = 1;

    try {
        $sql = "UPDATE formtb SET DIRECTOR_ID = :DIRECTOR_ID ,REQ_STATUS_DIRECTOR = :REQ_STATUS_DIRECTOR ," .
            "GRADE_SC = :GRADE_SC ,IC_SC = :IC_SC ,FM_SC = :FM_SC ,PS_SC = :PS_SC , ACTY_SC = :ACTY_SC , TTAL_SC = :TTAL_SC, " .
            "DIRECTOR_DESCRIBE = :DIRECTOR_DESCRIBE  ,DCMT_DATE = :CMT_DATE ,TO_ADMIN = :TOADMIN WHERE FORM_ID = :FORM_ID";
        $query = $conn->prepare($sql);
        $query->bindParam(':DIRECTOR_ID', $director, PDO::PARAM_STR);
        $query->bindParam(':REQ_STATUS_DIRECTOR', $status, PDO::PARAM_STR);
        $query->bindParam(':DIRECTOR_DESCRIBE', $message, PDO::PARAM_STR);
        $query->bindParam(':CMT_DATE', $date, PDO::PARAM_STR);
        $query->bindParam(':FORM_ID', $formid, PDO::PARAM_STR);
        $query->bindParam(':GRADE_SC', $GradeScore, PDO::PARAM_INT);
        $query->bindParam(':IC_SC', $IncomeFMLY, PDO::PARAM_INT);
        $query->bindParam(':FM_SC', $FAMLY, PDO::PARAM_INT);
        $query->bindParam(':PS_SC', $PersonSC, PDO::PARAM_INT);
        $query->bindParam(':ACTY_SC', $ActySC, PDO::PARAM_INT);
        $query->bindParam(':TTAL_SC', $num, PDO::PARAM_INT);
        $query->bindParam(':TOADMIN', $to_admin, PDO::PARAM_INT);

        if ($query->execute()) {
            echo "บันทึกคำพิจารณาสำเร็จ";
        } else {
            echo "มีบางอย่างผิดพลาด";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
