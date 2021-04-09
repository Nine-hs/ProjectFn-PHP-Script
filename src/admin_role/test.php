<?php
require_once '../../config/database/db.php';

if (isset($_POST['r_id'])) {
    if ($_POST['r_id'] == 0) {
        echo "<script>alert('ยังไม่ได้เลือกทุนฯ');window.location.href = './scholarship.php'</script>";
    } else {
        if (empty($_POST['Student_id'])) {
            echo "<script>alert('ยังไม่ได้เลือกนักศึกษา');window.location.href = './scholarship.php'</script>";
        } else {
            $count = count($_POST['Student_id']);
            if ($count > $_POST['txtcur_amount']) {
                echo "<script>alert('จำนวนทุนมีไม่เพียงพอ');window.location.href = './scholarship.php'</script>";
            } else {
                $sql = "INSERT INTO req_scholarship(R_ID, FROM_ID,R_AMOUNT,R_VALUE) VALUES (:R_ID,:FROM_ID,:R_AMOUNT,:R_VALUE)";
                $query = $conn->prepare($sql);
                if ($count == 1) {
                }
                $sholar = round($_POST['txtcur_total'] / $_POST['txtcur_amount']);
                $amount = 1;
                for ($i = 0; $i < $count; $i++) {
                    $insert = $query->execute(['R_ID' => $_POST['r_id'], 'FROM_ID' => $_POST['Student_id'][$i], 'R_AMOUNT' => $amount, 'R_VALUE' => $sholar]);
                }
                if ($insert) {
                    echo "<script>alert('บันทึกข้อมูลสำเร็จ');window.location.href = './scholarship.php'</script>";
                } else {
                    echo "<script>alert('มีบางอย่างผิดพลาด');window.location.href = './scholarship.php'</script>";
                }
            }
        }
    }
}
