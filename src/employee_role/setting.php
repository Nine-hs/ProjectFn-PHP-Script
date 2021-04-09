<?php
require_once '../../config/database/db.php';
session_start();
if (empty($_SESSION['Login'])) {
    header('location: /');
    exit;
}
if ($_SESSION['STATUS'] != "พนักงาน") {
    header('location: /src/' . $_SESSION['STATUSENG'] . '_role');
    exit;
}


if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
if (isset($_POST['newpassword'])) {
    $newPassword = $_POST['newpassword'];
}
if (isset($_POST['em_id'])) {
    $employee = $_POST['em_id'];
}

try {
    if (isset($employee) && isset($password)) {
        $sql = "SELECT EM_PASSWORD FROM employeetb WHERE EM_ID = :id limit 1";
        $query_pass = $conn->prepare($sql);
        $query_pass->bindParam(':id', $employee, PDO::PARAM_STR);
        $query_pass->execute();
        $pass = $query_pass->fetch(PDO::FETCH_ASSOC);
        $compare = password_verify($password, $pass['EM_PASSWORD']);
        if (empty($compare)) {
            echo "<script>alert('กรอกรหัสเก่าให้ถูกต้อง');</script>";
        } else {
            $Hashing = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE employeetb SET EM_PASSWORD = :NewPass WHERE EM_ID = :id";
            $query = $conn->prepare($sql);
            $query->bindParam(':NewPass', $Hashing, PDO::PARAM_STR);
            $query->bindParam(':id', $employee, PDO::PARAM_STR);
            if ($query->execute()) {
                echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ');window.location.href = 'index.php'</script>";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../asset/font/Trirong.css">
    <link rel="stylesheet" href="./css/employee.css">
    <style>
        .register-box {
            margin: 0 auto;
            width: 400px;
            margin-top: 70px;
        }

        @media only screen and (max-width: 768px) {
            .register-box {
                margin: 0 auto;
                width: 280px;
                padding: 3%;
            }

            .btn-save {
                font-size: 12px;
            }
        }
    </style>
    <title>Document</title>
</head>

<body>
    <?php
    require('./css/component/header.php');
    ?>


    <div class="register-box">
        <div class="register-box-body">
            <p class="login-box-msg">เปลี่ยนรหัสผ่าน</p>
            <form action="setting.php" method="post">
                <div class="form-group has-feedback">
                    <input type="hidden" name="em_id" class="form-control" value="<?php echo $_SESSION['Accout_id']; ?>">
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" required placeholder="Password">
                        <span class="input-group-text" id="basic-addon2">เดิม</span>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="newpassword" required placeholder="Retype password">
                        <span class="input-group-text" id="basic-addon2">ใหม่</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-success btn-block btn-flat btn-save">บันทึก</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</body>
<script src="../../asset/js/bootstrap.min.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>
<script>
    const year = new Date().getFullYear() + 543;
    document.getElementById('year').textContent = year;
</script>

</html>