<?php
require('./config/database/db.php');
include('./src/smtp/index.php');

if (isset($_POST['submit'])) {
    if (empty($_POST['email'])) {
        $msg = "กรุณากรอกอีเมลล์";
    } else {
        $search = "SELECT ST_ID, CONCAT(ST_FIRSTNAME,' ',ST_LASTNAME) as Fullname, ST_USERNAME FROM studenttb WHERE ST_USERNAME = :Email limit 1";
        $query = $conn->prepare($search);
        $query->bindParam(':Email', $_POST['email'], PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            $search = "SELECT EM_ID, CONCAT(EM_NAME,' ',EM_LASTNAME) as Fullname, EM_USERNAME FROM employeetb WHERE EM_USERNAME = :Email limit 1";
            $query = $conn->prepare($search);
            $query->bindParam(':Email', $_POST['email'], PDO::PARAM_STR);
            $query->execute();
            $row2 = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($row2)) {
            } else {
                if (SwitchEm($row2['EM_USERNAME'], $row2['EM_ID'], $conn)) {
                    $msg = "ส่งเรื่องเรียบร้อยแล้ว <a href='/index.php'>คลิ๊กเพื่อกลับหน้าหลัก</a>";
                } else {
                    $msg = "มีบางอย่าผิดพลาด";
                }
            }
        } else {
            if (SwitchSTudents($row['ST_USERNAME'], $row['ST_ID'], $conn)) {
                $msg = "ส่งเรื่องเรียบร้อยแล้ว <a href='/index.php'>คลิ๊กเพื่อกลับหน้าหลัก</a>";
            } else {
                $msg = "มีบางอย่าผิดพลาด";
            };
        }
    }
}

function SwitchEm($to, $stid, $conn)
{

    $rand = rand(0, 2000);
    $html = "<h4>คลิ๊กลิ้งค์เพื่อตั้งรหัสผ่านใหม่</h4><br><a href='http://" . $_SERVER['HTTP_HOST'] . "/scholarship/newpassword.php?code=" . $rand . "' style='text-align: center;'>คลิ๊กเพื่อตั้งรหัสผ่านใหม่</a>";
    $Email = new Email();
    $done = $Email->smtp_mailer($to, 'reset รหัสผ่าน - ระบบบริหารจัดการกองทุน', $html);
    if ($done) {
        $insertCode = "UPDATE employeetb SET CODE =:CODE WHERE EM_ID = :ST_ID";
        $query = $conn->prepare($insertCode);
        $query->bindParam(':CODE', $rand, PDO::PARAM_INT);
        $query->bindParam(':ST_ID', $stid, PDO::PARAM_INT);
        $upCode = $query->execute();
        if ($upCode) {
            return true;
        }
    } else {
        return false;
    }
}

function SwitchSTudents($to, $stid, $conn)
{

    $rand = rand(0, 2000);
    $html = "<h4>คลิ๊กลิ้งค์เพื่อตั้งรหัสผ่านใหม่</h4><br><a href='http://" . $_SERVER['HTTP_HOST'] . "/scholarship/newpassword.php?code=" . $rand . "' style='text-align: center;'>คลิ๊กเพื่อตั้งรหัสผ่านใหม่</a>";
    $Email = new Email();
    $done = $Email->smtp_mailer($to, 'reset รหัสผ่าน - ระบบบริหารจัดการกองทุน', $html);
    if ($done) {
        $insertCode = "UPDATE studenttb SET CODE =:CODE WHERE ST_ID = :ST_ID";
        $query = $conn->prepare($insertCode);
        $query->bindParam(':CODE', $rand, PDO::PARAM_INT);
        $query->bindParam(':ST_ID', $stid, PDO::PARAM_INT);
        $upCode = $query->execute();
        if ($upCode) {
            return true;
        }
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="./asset/css/index.css">
    <link rel="stylesheet" href="./asset/font/Trirong.css">
    <title>Reset Password</title>
</head>

<body>
    <section class="wrap-contain">
        <div class="box-login">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <img src="./public/images/logopage1.svg" class="logo" alt="">
                        <h5>ระบบบริหารจัดการทุนการศึกษา</h5>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <hr>
                </div>
                <div class="row justify-content-center">
                    <form action="reset.php" method="POST">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title reset-title">รีเซ็ตรหัสผ่าน</h5>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label label">Email</label>
                                        <input type="email" name="email" class="form-control txt" placeholder="">
                                        <div id="emailHelp" class="form-text">รีเซ็ตรหัสผ่านโดยอีเมล</div>
                                    </div>
                                    <input type="submit" class="btn btn-success w-100 btn-sm btn-reset" value="ส่ง" name="submit">
                                    <a class="btn btn-loght w-100 btn-sm btn-reset" href='index.php'>กลับหน้าหลัก</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                if (isset($msg)) {
                    echo  '<div class="alert alert-success mt-3" role="alert">';
                    echo   $msg;
                    echo  '</div>';
                }
                ?>
                <div class="footer">
                    <p>Rajamangala University of Technology Rattanakosin Bophit Phimuk Chakkrawat Campus.</p>
                </div>
            </div>
    </section>
</body>

</html>