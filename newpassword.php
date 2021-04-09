<?php
require_once './src/reset.php';
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
                    <form action="newpassword.php" method="POST">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title reset-title">รีเซ็ตรหัสผ่าน</h5>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label label">ตั้งรหัสผ่านใหม่</label>
                                        <input type="password" name="code" hidden class="form-control txt" value="<?php if (empty($_GET['code'])) {
                                                                                                                        echo "";
                                                                                                                    } else {
                                                                                                                        echo $_GET['code'];
                                                                                                                    } ?>">
                                        <input type="password" name="pwd" class="form-control txt" placeholder="">
                                    </div>
                                    <input type="submit" class="btn btn-primary w-100 btn-sm btn-reset" name="submit" value="ส่ง">
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