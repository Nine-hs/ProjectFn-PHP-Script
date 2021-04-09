<?php
require_once '../../../config/database/db.php';

if (isset($_POST['form_id'])) {
    $select = 1;
    $st = 2;
    $sql = "UPDATE formtb SET BY_ADMIN = :MARK, TO_ADMIN = :TAD WHERE FORM_ID = :ID";
    $query = $conn->prepare($sql);
    $query->bindParam(':MARK', $select, PDO::PARAM_INT);
    $query->bindParam(':TAD', $st, PDO::PARAM_INT);
    $query->bindParam(':ID', $_POST['form_id'], PDO::PARAM_INT);

    if ($query->execute()) {
        echo "บันทึกผลเรียบร้อย";
    } else {
        echo "มีบางอย่างผิดพลาด";
    }
}


if (isset($_POST['btn_del'])) {
    $st = 2;
    $del = 2;
    $sql = "UPDATE formtb SET BY_ADMIN = :MARK, TO_ADMIN = :TAD,COMMENT_HEAD = :COMMENT_HEAD WHERE FORM_ID = :ID";
    $query = $conn->prepare($sql);
    $query->bindParam(':MARK', $del, PDO::PARAM_INT);
    $query->bindParam(':TAD', $st, PDO::PARAM_INT);
    $query->bindParam(':COMMENT_HEAD', $_POST['msg'], PDO::PARAM_STR);
    $query->bindParam(':ID', $_POST['btn_del'], PDO::PARAM_INT);

    if ($query->execute()) {
        echo "บันทึกผลเรียบร้อย";
    } else {
        echo "มีบางอย่างผิดพลาด";
    }
}


if (isset($_POST['edit_id'])) {
    $year = date('Y');
    $sql_edit = "SELECT R_SCHOLAR_ID,s.SCHOLAR_NAME as scholar_name,rq.R_AMOUNT as amount,rq.R_VALUE as values_scholar" .
        ",CONCAT(f.F_NAME,' ',f.L_NAME) student,CONCAT(m.M_MAJOR,' ',f.ST_GEN) as MAJOR ,R_ID " .
        " FROM req_scholarship rq INNER JOIN scolartb s ON rq.R_ID=s.SCHOLAR_ID INNER JOIN formtb f ON rq.FROM_ID=f.FORM_ID " .
        " INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR WHERE rq.R_SCHOLAR_ID != 0 AND YEAR(rq.DATE_GIVE) = :YEARS AND R_SCHOLAR_ID = :ID";
    $queryEdit = $conn->prepare($sql_edit);
    $queryEdit->bindParam(':ID', $_POST['edit_id'], PDO::PARAM_INT);
    $queryEdit->bindParam(':YEARS', $year, PDO::PARAM_STR);
    $queryEdit->execute();
    $row_edit = $queryEdit->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row_edit);
}
