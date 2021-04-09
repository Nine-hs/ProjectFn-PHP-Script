<?php
require_once '../../../config/database/db.php';


if (isset($_POST['nameScholar'])) {
    $id = rand(1, 1000);
    $sql = "INSERT INTO scolartb(SCHOLAR_ID, SCHOLAR_NAME, SCOLAR_AMOUNTH, SCHOLAR_VALUE, CURR_AMOUNT, CURR_VALUE) VALUES" .
        " (:ID, :SCHOLAR_NAME, :SCOLAR_AMOUNTH, :SCHOLAR_VALUE, :CURR_AMOUNT, :CURR_VALUE)";
    $query = $conn->prepare($sql);
    $insert = $query->execute([
        'ID' => $id,
        'SCHOLAR_NAME' => $_POST['nameScholar'],
        'SCOLAR_AMOUNTH' => $_POST['amount_sholar'],
        'SCHOLAR_VALUE' => $_POST['total_scholar'],
        'CURR_AMOUNT' => $_POST['amount_sholar'],
        'CURR_VALUE' => $_POST['total_scholar'],
    ]);

    if ($insert) {
        if (isset($_POST['nameDonat'])) {
            $count = count($_POST['nameDonat']);
            $giver = "INSERT INTO givertb(GIVER_NAME, GIVER_PHONE, SCHOLAR_ID) VALUES" .
                " (:GIVER_NAME, :GIVER_PHONE, :SCHOLAR_ID)";
            $query_G = $conn->prepare($giver);
            for ($i = 0; $i < $count; $i++) {
                $insertDonat = $query_G->execute([
                    'GIVER_NAME' => $_POST['nameDonat'][$i],
                    'GIVER_PHONE' => $_POST['phone'][$i],
                    'SCHOLAR_ID' => $id,
                ]);
            }
            if ($insertDonat) {
                echo "เพิ่มข้อมูลผู้บริจาคสำเร็จ";
            } else {
                echo "เกิดข้อผิดพลานในการเพิ่มข้อมูลผู้บริจาค";
            }
        }
    }
}


if (isset($_POST['del_id'])) {
    $sql = "DELETE FROM scolartb WHERE SCHOLAR_ID = :ID";
    $query = $conn->prepare($sql);
    $query->bindParam(':ID', $_POST['del_id'], PDO::PARAM_INT);

    if ($query->execute()) {
        echo "ลบรายการสำเร็จ";
    } else {
        echo "ลบรายการผิดพลาด";
    }
}


if (isset($_POST['up_id'])) {
    $year = date('Y');
    $sql = "SELECT SCHOLAR_ID, SCHOLAR_NAME, SCOLAR_AMOUNTH, SCHOLAR_VALUE, CURR_AMOUNT, CURR_VALUE," .
        "(SELECT COUNT(R_ID) FROM req_scholarship WHERE R_ID = SCHOLAR_ID) as GIVED," .
        "(SELECT SUM(R_VALUE) FROM req_scholarship WHERE R_ID = SCHOLAR_ID) as VALUED " .
        " FROM scolartb WHERE SCHOLAR_ID = :ID AND YEAR(scolar_date) = :YEARS limit 1";
    $query = $conn->prepare($sql);
    $query->bindParam(':ID', $_POST['up_id'], PDO::PARAM_INT);
    $query->bindParam(':YEARS', $year, PDO::PARAM_STR);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
}

if (isset($_POST['new-id'])) {
    $sql = "UPDATE scolartb SET SCHOLAR_NAME = :SCHOLAR_NAME,SCOLAR_AMOUNTH = :SCOLAR_AMOUNTH" .
        ",SCHOLAR_VALUE =:SCHOLAR_VALUE,CURR_AMOUNT = :CURR_AMOUNT,CURR_VALUE = :CURR_VALUE WHERE SCHOLAR_ID = :ID";
    $query = $conn->prepare($sql);
    $query->bindParam(':SCHOLAR_NAME', $_POST['name'], PDO::PARAM_STR);
    $query->bindParam(':SCOLAR_AMOUNTH', $_POST['amount'], PDO::PARAM_INT);
    $query->bindParam(':SCHOLAR_VALUE', $_POST['value'], PDO::PARAM_INT);
    $query->bindParam(':CURR_AMOUNT', $_POST['curamount'], PDO::PARAM_INT);
    $query->bindParam(':CURR_VALUE', $_POST['curvalue'], PDO::PARAM_INT);
    $query->bindParam(':ID', $_POST['new-id'], PDO::PARAM_INT);
    if ($query->execute()) {
        echo "แก้ไขข้อมูลสำเร็จ";
    } else {
        echo "มีบางอย่างผิดพลาด";
    }
}

if (isset($_POST['find_edit'])) {
    $fedit = "SELECT EM_ID, EM_NAME, EM_LASTNAME, EM_USERNAME, EM_PASSWORD, EM_DEPART FROM employeetb WHERE EM_ID = :ID";
    $queryFED = $conn->prepare($fedit);
    $queryFED->bindParam(':ID', $_POST['find_edit'], PDO::PARAM_STR);
    $queryFED->execute();
    $rows = $queryFED->fetch(PDO::FETCH_ASSOC);
    echo json_encode($rows);
}


