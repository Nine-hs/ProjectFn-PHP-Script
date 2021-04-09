<?php

require_once './config/database/db.php';
if (isset($_POST['loging'])) {
    if (empty($_POST['email'])) {
        $err_email = "กรุณากรอกชื่อผู้ใช้";;
    }
    if (empty($_POST['password'])) {
        $err_pass = "กรุณากรอกรหัสผ่าน";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $Domain = explode("@", $email);
        if ($Domain[1] === "rmutr.ac.th" || $Domain[1] === "outlook.rmutr.ac.th") {
            $searchST = "SELECT ST_ID, ST_NUMBER, ST_FIRSTNAME, ST_LASTNAME, ST_USERNAME, ST_PASSWORD, st.S_STATUS as SSTATUS,st.S_STATUS_ENG as STENG FROM" .
                " studenttb s INNER JOIN statustb st ON s.ST_STATUS=st.STATUS_ID WHERE ST_USERNAME=:USER limit 1";
            $query = $conn->prepare($searchST);
            $query->bindParam(':USER', $email);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            if ($row['ST_USERNAME'] == $email) {
                $result = password_verify($password, $row['ST_PASSWORD']);
                if ($result) {
                    session_start();
                    $_SESSION['Accout_id'] = $row['ST_ID'];
                    $_SESSION['Student_id'] = $row['ST_NUMBER'];
                    $_SESSION['FirstName'] = $row['ST_FIRSTNAME'];
                    $_SESSION['LastName'] = $row['ST_LASTNAME'];
                    $_SESSION['STATUSENG'] = $row['STENG'];
                    $_SESSION['STATUS'] = $row['SSTATUS'];
                    $_SESSION['Login'] = true;
                    header('location: src/Student_role/');
                } else {
                    $err_pass = "รหัสผ่านผิด";
                }
            } else {
                $searchEM = "SELECT EM_ID, EM_NAME, EM_LASTNAME, EM_USERNAME, EM_PASSWORD,s.S_STATUS_ENG as ST, s.S_STATUS as ED," .
                    " ef.EMID_FROM_ as EF, m.ST_MAJOR as Major FROM employeetb et INNER JOIN em_from ef ON et.EM_FROM=ef.EMID_FROM INNER JOIN" .
                    " statustb s ON et.EM_DEPART=s.STATUS_ID INNER JOIN majors m ON et.Major= m.ID_MAJOR WHERE EM_USERNAME= :USER limit 1";
                $query = $conn->prepare($searchEM);
                $query->bindParam(':USER', $email);
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
                if ($row['EM_USERNAME'] == $email) {
                    $result = password_verify($password, $row['EM_PASSWORD']);
                    if ($result) {
                        session_start();
                        $_SESSION['Accout_id'] = $row['EM_ID'];
                        $_SESSION['FirstName'] = $row['EM_NAME'];
                        $_SESSION['LastName'] = $row['EM_LASTNAME'];
                        $_SESSION['STATUSENG'] = $row['ST'];
                        $_SESSION['STATUS'] = $row['ED'];
                        $_SESSION['From'] = $row['EF'];
                        $_SESSION['Major'] = $row['Major'];
                        $_SESSION['Login'] = true;
                        header('location: src/' . $row['ST'] . '_role/');
                    } else {
                        $err_pass = "รหัสผ่านผิด";
                    }
                } else {
                    $err_email = "ไม่พบบัญชีผู้ใช้";
                }
            }
        } else {
            $err_email = "กรุณาใช้ตรวจสอบ Email ผู้ใช้";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/css/index.css">
    <link rel="stylesheet" href="./asset/font/Trirong.css">
    <title>ระบบบริหารจัดการทุนการศึกษา BPC</title>
</head>

<body>
    <section class="wrap-contain">

        <div class="box-login">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="./public/images/logopage1.svg" class="logo" alt="">
                        <h4>ระบบบริหารจัดการทุนการศึกษา</h4>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <hr>
                </div>
                <form action="index.php" method="POST">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label label">ชื่อผู้ใช้</label>
                                <input type="email" name="email" class="form-control txt" placeholder="">
                                <p id="msg-user"><?php if (isset($err_email)) {
                                                        echo $err_email;
                                                    } ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label label">รหัสผ่าน</label>
                                <input type="password" name="password" class="form-control txt" placeholder="">
                                <p id="msg-pass"><?php if (isset($err_pass)) {
                                                        echo $err_pass;
                                                    } ?></p>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="mb-3">
                                <a href="reset.php">ลืมรหัสผ่าน ?</a>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <input type="submit" class="btn btn-primary btn-sm btn" name="loging" value="เข้าสู่ระบบ">
                </form>
                <a href="registration.php" class="btn btn-danger btn-sm btn">ลงทะเบียน</a>
            </div>
        </div>

        <div class="footer">
            <p>Rajamangala University of Technology Rattanakosin Bophit Phimuk Chakkrawat Campus.</p>
        </div>
        </div>
    </section>
</body>
<script src="./asset/js/bootstrap.min.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>

</html>