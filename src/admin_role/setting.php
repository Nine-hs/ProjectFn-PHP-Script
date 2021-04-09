<?php
session_start();
require_once '../../config/database/db.php';
if (empty($_SESSION['Login'])) {
  header('location: /');
  exit;
}
if ($_SESSION['STATUS'] != "หัวหน้าฝ่ายกองทุน") {
  header('location: /src/' . $_SESSION['STATUSENG'] . '_role');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../../asset/css/material-icons.css" rel="stylesheet">
  <link href="../../asset/css/material.indigo-pink.min.css" rel="stylesheet">
  <link href="../../asset/css/bootstrap.minn.css" rel="stylesheet">
  <link href="../../asset/css/AdminLTE.min.css" rel="stylesheet">
  <link href="./css/admin.css" rel="stylesheet">
  <title>ระบบบริหารจัดการทุนการศึกษา</title>
</head>

<body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
      <div class="mdl-layout__header-row">
        <span class="mdl-layout-title"></span>
        <div class="mdl-layout-spacer"></div>
        <nav class="mdl-navigation mdl-layout--large-screen-only">
          <a class="mdl-navigation__link" href="index.php"><i class="fa fa-home margin-r-5" aria-hidden="true"></i>หน้าหลัก</a>
          <a class="mdl-navigation__link" href="scholarship.php"><i class="fa fa-graduation-cap margin-r-5" aria-hidden="true"></i>บันทึกข้อมูลนักศึกษา</a>
          <a class="mdl-navigation__link" href="list.php"><i class="fa fa-list-alt margin-r-5" aria-hidden="true"></i>ข้อมูลนักศึกษา</a>
          <a class="mdl-navigation__link" href="setting.php"><i class="fa fa-key margin-r-5" aria-hidden="true"></i>เปลียนรหัสผ่าน</a>
        </nav>
      </div>
    </header>
    <div class="mdl-layout__drawer">
      <span class="mdl-layout-title"></span>
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php"><i class="fa fa-home margin-r-5" aria-hidden="true"></i>หน้าหลัก</a>
        <a class="mdl-navigation__link" href="scholarship.php"><i class="fa fa-graduation-cap margin-r-5" aria-hidden="true"></i>บันทึกข้อมูลนักศึกษา</a>
        <a class="mdl-navigation__link" href="list.php"><i class="fa fa-list-alt margin-r-5" aria-hidden="true"></i>ข้อมูลนักศึกษา</a>
        <a class="mdl-navigation__link" href="setting.php"><i class="fa fa-key margin-r-5" aria-hidden="true"></i>เปลียนรหัสผ่าน</a>
        <a class="mdl-navigation__link" href="../logout.php"><i class="fa fa-sign-out margin-r-5" aria-hidden="true"></i>ออกจากระบบ</a>
      </nav>
    </div>
    <main class="mdl-layout__content">
      <div class="register-box ">
        <div class="register-box-body">
          <p class="login-box-msg">เปลี่ยนรหัสผ่าน</p>
          <form action="setting.php" method="post">
            <div class="form-group has-feedback">
              <input type="hidden" name="dt_id" class="form-control" value="<?php echo $_SESSION['Accout_id']; ?>">
              <input type="password" name="password" class="form-control" required placeholder="Password">
              <span class="glyphicon  form-control-feedback">เดิม</span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" name="newpassword" class="form-control" required placeholder="Retype password">
              <span class="glyphicon form-control-feedback">ใหม่</span>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <div class="checkbox icheck">
                </div>
              </div>
              <div class="col-xs-4">
                <button type="submit" class="btn btn-success btn-block btn-flat">Register</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</body>
<script src="../../asset/js/material.min.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>
</html>
</body>
<?php


if (isset($_POST['password'])) {
  $password = $_POST['password'];
}
if (isset($_POST['newpassword'])) {
  $newPassword = $_POST['newpassword'];
}
if (isset($_POST['dt_id'])) {
  $director = $_POST['dt_id'];
}

try {
  if (isset($director) && isset($password)) {
    $sql = "SELECT EM_PASSWORD FROM employeetb WHERE EM_ID = :id limit 1";
    $query_pass = $conn->prepare($sql);
    $query_pass->bindParam(':id', $director, PDO::PARAM_STR);
    $query_pass->execute();
    $pass = $query_pass->fetch(PDO::FETCH_ASSOC);
    $compare = password_verify($password, $pass['ST_PASSWORD']);
    if (empty($compare)) {
      echo "<script>alert('มีบางอย่างผิดพลาด');window.location.href = 'setting.php'</script>";
    } else {
      $Hashing = password_hash($newPassword, PASSWORD_DEFAULT);
      $sql = "UPDATE employeetb SET EM_PASSWORD = :NewPass WHERE EM_ID = :id";
      $query = $conn->prepare($sql);
      $query->bindParam(':NewPass', $Hashing, PDO::PARAM_STR);
      $query->bindParam(':id', $director, PDO::PARAM_STR);
      if ($query->execute()) {
        echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ');window.location.href = 'index.php'</script>";
      }
    }
  }
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>

</html>