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

if (isset($_POST['director'])) {
  $direcotr = $_POST['director'];
  $formid = $_POST['formid'];
  $sql = "UPDATE formtb SET DIRECTOR_ID = :DIRECTOR WHERE FORM_ID = :ID";
  $query = $conn->prepare($sql);
  $query->bindParam(':DIRECTOR', $direcotr, PDO::PARAM_STR);
  $query->bindParam(':ID', $formid, PDO::PARAM_STR);

  if ($query->execute()) {
    echo "<script>alert('เพิ่มข้อมูลสำเร็จ')</script>";
  }
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
    @media only screen and (max-width: 768px) {
      .tb {
        width: 300%;
      }
    }
  </style>
  <title>Document</title>
</head>

<body>
  <?php
  require('./css/component/header.php');
  ?>

  <div class="container mt-4">
    <div class="row">
      <div class="col-sm-12 col-md-2">
        <div class="list-group group-list" id="list-tab" role="tablist">
          <div href="#" class="list-group-item " aria-current="true">
            <div class="d-flex w-100 justify-content-between">
              <h6 class="mb-1">ข้อมูลผู้ใช้</h6>
            </div>
            <small>ชื่อ: <?php echo $_SESSION['FirstName'] . '  ' . $_SESSION['LastName']; ?></small><br>
            <small>สถานะ: <?php echo $_SESSION['STATUS']; ?></small>
          </div>
          <a class="list-group-item list-group-item-action " href="index.php" role="tab" aria-controls="home">หน้าหลัก</a>
          <a class="list-group-item list-group-item-action active" href="reportbydirector.php">ผลพิจารณาจากกรรมการ</a>
          <a class="list-group-item list-group-item-action " href="report.php">รายชื่อผู้ได้รับทุน</a>
          <a class="list-group-item list-group-item-action " href="events.php">กำหนดปฏิทินกิจกรรม</a>
          <a class="list-group-item list-group-item-action" href="users.php">จัดการข้อมูลผู้ใช้</a>
          <a class="list-group-item list-group-item-action" href="scholarships.php">จัดการข้อมูลทุนฯ</a>
        </div>
      </div>
      <div class="col-sm-12 col-md-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="card " style="height: 540px; max-height: 540px;" id="list-profile">
            <h6 class="card-header">ผลพิจารณาโดยกรรมการ</h6>
            <div class="card-body table-responsive ">
              <div class="container">
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">ดูข้อมูลคะแนนพิจารณากรรมการ</label>
                      <select class="form-select" id="dt">
                        <option selected>-</option>
                        <?php
                        $dt = "SELECT EM_ID,CONCAT(EM_NAME,' ',EM_LASTNAME) as DT  FROM employeetb WHERE EM_DEPART = '2'";
                        $query = $conn->query($dt);
                        $row = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($row as $i) {
                          echo "<option value='" . $i['EM_ID'] . "'>" . $i['DT'] . "</option>";
                        }
                        ?>
                      </select>
                      <div id="emailHelp" class="form-text"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <table class="table tb">
                      <thead>
                        <tr class="title-score">
                          <th scope="col">ลำดับ</th>
                          <th scope="col">ชื่อ-นามสกุล</th>
                          <th scope="col">ชั้นปี</th>
                          <th scope="col">สถานะจากกรรมการ</th>
                          <th scope="col">คะแนนพิจารณารวม</th>
                          <th scope="col">สถานะจากหัวหน้าฝ่ายกองทุนฯ</th>
                          <th scope="col">ผลพิจารณา</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">รายละเอียดคะแนน</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  เกรดเฉลี่ย
                </div>
                <div class="col-sm-12 col-md-6">
                  <p id="grade"></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  รายได้ต่อครอบครัว
                </div>
                <div class="col-sm-12 col-md-6">
                  <p id="is_sc"></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  สถานภาพครอบครัว
                </div>
                <div class="col-sm-12 col-md-6">
                  <p id="fm_sc"></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  การแต่งกายและความประพฤติ
                </div>
                <div class="col-sm-12 col-md-6">
                  <p id="ps_sc"></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  จิตอาสาและการมีส่วนร่วม
                </div>
                <div class="col-sm-12 col-md-6">
                  <p id="acty_sv"></p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  เกณฑ์คะแนนรวม
                </div>
                <div class="col-sm-12 col-md-6">
                  <p id="tt_sc"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-body fade">
      <h5>Popover in a modal</h5>
      <p>This <a href="#" role="button" class="btn btn-secondary popover-test" title="Popover title" data-bs-content="Popover body content is set in this attribute.">button</a> triggers a popover on click.</p>
      <hr>
      <h5>Tooltips in a modal</h5>
      <p><a href="#" class="tooltip-test" title="Tooltip">This link</a> and <a href="#" class="tooltip-test" title="Tooltip">that link</a> have tooltips on hover.</p>
    </div>

  </div>

</body>
<script src="../../asset/js/bootstrap.min.js"></script>
<script src="../../asset/js/jquery-3.2.1.min.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>
<script src="./js/scholar-peryear.js"></script>
<script>
  const year = new Date().getFullYear() + 543;
  document.getElementById('year').textContent = year;
</script>

</html>