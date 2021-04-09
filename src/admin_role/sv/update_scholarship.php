<?php
require_once '../../../config/database/db.php';

if (isset($_POST['req_id'])) {
    try {
        $update_req = "UPDATE req_scholarship SET R_ID= :R_ID ,R_AMOUNT=:R_AMOUNT ,R_VALUE=:R_VALUE WHERE R_SCHOLAR_ID = :ID";
        $query = $conn->prepare($update_req);
        $query->bindParam(':R_ID', $_POST['schoname'], PDO::PARAM_STR);
        $query->bindParam(':R_AMOUNT', $_POST['util'], PDO::PARAM_STR);
        $query->bindParam(':R_VALUE', $_POST['value'], PDO::PARAM_STR);
        $query->bindParam(':ID', $_POST['req_id'], PDO::PARAM_STR);
        if ($query->execute()) {
            $find = "SELECT CURR_AMOUNT, CURR_VALUE FROM scolartb WHERE SCHOLAR_ID = :ID";
            $queryfind = $conn->prepare($find);
            $queryfind->bindParam(':ID', $_POST['oldscho_id'], PDO::PARAM_STR);
            $queryfind->execute();
            $rs = $queryfind->fetch(PDO::FETCH_ASSOC);
            if (isset($rs)) {
                $CurrAMOUNT = $rs['CURR_AMOUNT'] + $_POST['oldutil'];
                $CurrVALUE = $rs['CURR_VALUE'] + $_POST['oldvalue'];
                $update_scho = "UPDATE scolartb SET CURR_AMOUNT=:CURR_AMOUNT, CURR_VALUE=:CURR_VALUE WHERE SCHOLAR_ID =:OLDID";
                $queryscho = $conn->prepare($update_scho);
                $queryscho->bindParam(':CURR_AMOUNT', $CurrAMOUNT, PDO::PARAM_STR);
                $queryscho->bindParam(':CURR_VALUE', $CurrVALUE, PDO::PARAM_STR);
                $queryscho->bindParam(':OLDID', $_POST['oldscho_id'], PDO::PARAM_STR);
                if ($queryscho->execute()) {
                    $new = "SELECT CURR_AMOUNT, CURR_VALUE FROM scolartb WHERE SCHOLAR_ID = :IDNEW";
                    $querynew = $conn->prepare($new);
                    $querynew->bindParam(':IDNEW', $_POST['schoname'], PDO::PARAM_STR);
                    $querynew->execute();
                    $reslut = $querynew->fetch(PDO::FETCH_ASSOC);
                    if (isset($reslut)) {
                        $CurrAMOUNTNew = $reslut['CURR_AMOUNT'] - $_POST['util'];
                        $CurrVALUENew = $reslut['CURR_VALUE'] - $_POST['value'];
                        $update_scho_New = "UPDATE scolartb SET CURR_AMOUNT=:CURR_AMOUNT, CURR_VALUE=:CURR_VALUE WHERE SCHOLAR_ID =:NeID";
                        $queryscho = $conn->prepare($update_scho_New);
                        $queryscho->bindParam(':CURR_AMOUNT', $CurrAMOUNTNew, PDO::PARAM_STR);
                        $queryscho->bindParam(':CURR_VALUE', $CurrVALUENew, PDO::PARAM_STR);
                        $queryscho->bindParam(':NeID', $_POST['schoname'], PDO::PARAM_STR);
                        if ($queryscho->execute()) {
                            echo "<script>window.location.href = '../list.php'</script>";
                        }
                    }
                } else {
                    echo "มีบางอย่างผิดพลาด";
                }
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
