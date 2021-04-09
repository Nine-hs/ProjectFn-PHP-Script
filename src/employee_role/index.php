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
/*
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
}*/
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
          <a class="list-group-item list-group-item-action active" href="index.php" role="tab" aria-controls="home">หน้าหลัก</a>
          <a class="list-group-item list-group-item-action" href="reportbydirector.php">ผลพิจารณาจากกรรมการ</a>
          <a class="list-group-item list-group-item-action" href="report.php">รายชื่อผู้ได้รับทุน</a>
          <a class="list-group-item list-group-item-action" href="events.php">กำหนดปฏิทินกิจกรรม</a>
          <a class="list-group-item list-group-item-action" href="users.php">จัดการข้อมูลผู้ใช้</a>
          <a class="list-group-item list-group-item-action" href="scholarships.php">จัดการข้อมูลทุนฯ</a>
        </div>
      </div>
      <div class="col-sm-12 col-md-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="card " style="height: 600px;" id="list-profile">
            <h6 class="card-header">รายชื่อผู้สมัครขอรับทุนฯประจำปีการศึกษา <span id="year"></span></h6>
            <div class="card-body table-responsive ">
              <div class="container mt-4">
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">ค้นหาข้อมูลนักศึกษา</label>
                      <input type="email" class="form-control" id="search_student" aria-describedby="emailHelp">
                      <hr>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-12">
                    <table class="table tb">
                      <thead>
                        <tr>
                          <th scope="col">ลำดับ</th>
                          <th scope="col">ชื่อ-นามสกุล</th>
                          <th scope="col">ชั้นปี</th>
                          <th scope="col">ความเห็น</th>
                          <th scope="col">สถานะ</th>
                          <th scope="col" colspan="2">เลือกกรรมการ</th>
                        </tr>
                      </thead>
                      <tbody id="tbody_students">
                        <?php
                        $year = date('Y');
                        $sql = "SELECT FORM_ID,CONCAT(fb.F_NAME,' ',fb.L_NAME) as FULLST ,CONCAT(m.M_MAJOR,' ',fb.ST_GEN) as MAJORS," .
                          "rs.REQ_STATUS as RE_STATUS,fb.REQ_STATUS as REQ_STATUS,DIRECTOR_ID FROM formtb fb INNER JOIN majors m ON fb.ST_MAJORS=m.ID_MAJOR" .
                          " INNER JOIN  req_status rs ON fb.REQ_STATUS=rs.REQSTATUS_ID WHERE YEAR(fb.DATE_) = :YEARS AND fb.REQ_STATUS !=0 AND fb.FORM_ID !=0 ORDER BY fb.DATE_ DESC";
                        $query = $conn->prepare($sql);
                        $query->execute(['YEARS' => $year]);
                        $row = $query->fetchAll();
                        $n = 1;
                        foreach ($row as $i) {
                          if ($i['REQ_STATUS'] === "1") {
                            $msg = "success";
                          } else {
                            $msg = "danger";
                          }
                          echo "<form id='form'>";
                          echo "<tr>";
                          echo "<th scope='row'>" . $n++ . "</th>";
                          echo "<input type='hidden' name='formid' value='" . $i['FORM_ID'] . "'>";
                          echo "<td>" . $i['FULLST'] . "</td>";
                          echo "<td>" . $i['MAJORS'] . "</td>";
                          echo "<td><span class='badge bg-" . $msg . "'>" . $i['RE_STATUS'] . "</span></td>";
                          echo "<td>";
                          if ($i['DIRECTOR_ID'] == 0) {
                            echo "<select class='form-select form-select-sm' name='director' aria-label='form-select-sm example'>";
                            $seachDirector = "SELECT EM_ID,CONCAT(EM_NAME,' ',EM_LASTNAME) as Director FROM employeetb";
                            $query = $conn->query($seachDirector);
                            $row = $query->fetchAll();
                            foreach ($row as $d) {
                              echo "<option value='" . $d['EM_ID'] . "'>" . $d['Director'] . "</option>";
                            }
                            echo "</select>";
                          } else {
                            echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
                          }
                          echo "</td>";
                          echo "<td>";
                          if ($i['DIRECTOR_ID'] == 0) {
                            echo "<button type='submit' class='btn btn-success btn-sm'>เลือก</button>";
                          } else {
                            echo '<a href="info.php?form=' . $i['FORM_ID'] . '">ข้อมูลเพิ่มเติม</a>';
                          }
                          echo "</td>";
                          echo "</tr>";
                          echo "</form>";
                        }
                        ?>
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
  </div>
</body>
<script src="../../asset/js/bootstrap.min.js"></script>
<script src="../../asset/js/jquery-3.2.1.min.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>
<script>
  $(document).ready(function() {
    $('#form').submit(function(e) {
      $.ajax({
        url: "src/add-drirector.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(res) {
          if (res === "เพิ่มข้อมูลสำเร็จ") {
            alert(res)
            location.reload()
          } else {
            alert(res)
          }
        }
      })
      e.preventDefault()
    })

    $('#search_student').keyup(function() {

        $.ajax({
          url: "src/search_student.php",
          type: "POST",
          data: {
            findBYID: $(this).val()
          },
          success: function(res) {
            $('#tbody_students').html(res)
          }
        })
      
    })

  });
</script>
<script>
  const year = new Date().getFullYear() + 543;
  document.getElementById('year').textContent = year;
</script>

</html>