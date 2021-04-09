<?php
require_once './config/database/db.php';

if (isset($_REQUEST['btn-register'])) {

    if (empty($_POST['firstname'])) {
        $err_msg_name = "กรุณากรอกชื่อ";
    }
    if (empty($_POST['lastname'])) {
        $err_msg_lname = "กรุณากรอกนามสกุล";
    }
    if (empty($_POST['studentid'])) {
        $err_msg_id = "กรุณากรอกรหัสนักศึกษา";
    }
    if (empty($_POST['email'])) {
        $err_msg_email = "กรุณากรอก E-mail";
    }
    if (empty($_POST['password'])) {
        $err_msg_pass = "กรุณากรอกรหัสผ่าน";
    }
    if (empty($_POST['confirmpassword'])) {
        $err_msg_cfpass = "กรุณายืนยันรหัสผ่าน";
    } else {
        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $stid = $_POST['studentid'];
        $password = $_POST['password'];
        $cfpassword = $_POST['confirmpassword'];
        $emailDomain = $_POST['email'];
        $Domain = explode("@", $emailDomain);

        if ($Domain[1] === "rmutr.ac.th" || $Domain[1] === "outlook.rmutr.ac.th") {
            if ($password == $cfpassword) {
                try {
                    $searchID = "SELECT ST_NUMBER FROM studenttb WHERE ST_NUMBER = :ID";
                    $query = $conn->prepare($searchID);
                    $query->bindParam(':ID', $stid);
                    $query->execute();
                    $row = $query->fetch(PDO::FETCH_ASSOC);
                    if ($row['ST_NUMBER'] == $stid) {
                        $err_msg_id = "รหัสนักศึกษาซ้ำ";
                    } else {
                        $sql = "INSERT INTO studenttb(ST_NUMBER, ST_FIRSTNAME, ST_LASTNAME, ST_USERNAME, ST_PASSWORD)" .
                            " VALUES (:ST_NUMBER,:ST_FIRSTNAME,:ST_LASTNAME,:ST_USERNAME,:ST_PASSWORD)";
                        $pwd_hashed = password_hash($cfpassword, PASSWORD_DEFAULT);
                        $query = $conn->prepare($sql);
                        $query->bindParam(':ST_NUMBER', $stid);
                        $query->bindParam(':ST_FIRSTNAME', $fname);
                        $query->bindParam(':ST_LASTNAME', $lname);
                        $query->bindParam(':ST_USERNAME', $emailDomain);
                        $query->bindParam(':ST_PASSWORD', $pwd_hashed);
                        if ($query->execute()) {
                            echo "<script>alert('ลงทะเบียนเข้าสู่ระบบสำเร็จ'); window.location = 'index.php'</script>";
                        }
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            } else {
                $err_msg_cfpass = 'รหัสผ่านไม่ตรงกัน';
            }
        } else if ($Domain[1] !== "rmutr.ac.th" || $Domain[1] !== "outlook.rmutr.ac.th") {
            $err_msg_email = "กรุณาใช้ Email ของทางมหาวิทยาลัย";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset//css/registration.css">
    <link rel="stylesheet" href="./asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="./asset/font/Trirong.css">
    <title>ลงทะเบียนเข้าสู่ระบบ</title>
</head>

<body>


    <div class="card card-box">
        <img src="./public/images/branner.svg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">ลงทะเบียนเข้าใช้ระบบบริหารจัดการกองทุนฯ</h5>

        </div>
        <form action="registration.php" method="POST">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-21 ">
                        <br>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-6 ">
                        <div class="mb-12">
                            <label for="exampleInputEmail1" class="form-label label">ชื่อ</label>
                            <input type="text" name="firstname" class="form-control col-sm-w-70" id="firstname">
                            <p id="msg-fn"><?php if (isset($err_msg_name)) {
                                                echo $err_msg_name;
                                            } ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 ">
                        <div class="mb-12">
                            <label for="exampleInputEmail1" class="form-label label">นามสกุล</label>
                            <input type="text" name="lastname" class="form-control col-sm-w-70" id="lastname">
                            <p id="msg-ln"><?php if (isset($err_msg_lname)) {
                                                echo $err_msg_lname;
                                            } ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 ">
                        <div class="mb-12">
                            <label for="exampleInputEmail1" class="form-label label">รหัสนักศึกษา</label>
                            <input type="text" name="studentid" class="form-control col-sm-w-70" id="studentNumber">
                            <p id="msg-ln"><?php if (isset($err_msg_id)) {
                                                echo $err_msg_id;
                                            } ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 ">
                        <div class="mb-12">
                            <label for="exampleInputEmail1" class="form-label label">อีเมลล์</label>
                            <input type="email" name="email" class="form-control col-sm-w-70" id="email">
                            <p id="msg-ln"><?php if (isset($err_msg_email)) {
                                                echo $err_msg_email;
                                            } ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 ">
                        <div class="mb-12">
                            <label for="exampleInputEmail1" class="form-label label">รหัสผ่าน</label>
                            <input type="password" name="password" class="form-control col-sm-w-70" id="password">
                            <p id="msg-ln"><?php if (isset($err_msg_pass)) {
                                                echo $err_msg_pass;
                                            } ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 ">
                        <div class="mb-12">
                            <label for="exampleInputEmail1" class="form-label label">ยืนยันรหัสผ่าน</label>
                            <input type="password" name="confirmpassword" class="form-control col-sm-w-70">
                            <p id="msg-ln"><?php if (isset($err_msg_cfpass)) {
                                                echo $err_msg_cfpass;
                                            } ?></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 ">
                        <button type="submit" name="btn-register" class="btn btn-primary btn-sm btn">บันทึก</button>
                        <a class="btn btn-danger btn-sm btn" href="index.php" role="button">หน้าหลัก</a>
                    </div>
                </div>
        </form>
    </div>

</body>
</html>