<?php
session_start();
if (empty($_SESSION['Login'])) {
  header('location: /');
  exit;
}
if ($_SESSION['STATUS'] != "นักศึกษา") {
  header('location: /src/' . $_SESSION['STATUSENG'] . '_role');
  exit;
}
require_once '../../config/database/db.php';
$sql = "SELECT title, By_status, start_event, end_event,active FROM events WHERE By_status LIKE CONCAT('%',:BY_STATUS,'%')" .
  " AND YEAR(start_event) = :YEARS";
$query = $conn->prepare($sql);
$query->execute(['BY_STATUS' => $_SESSION['STATUS'], 'YEARS' => date('Y')]);
$row = $query->fetch();
$_SESSION['START'] = $row['start_event'];
$_SESSION['END'] = $row['end_event'];
$_SESSION['ACTIVE'] = $row['active'];
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
  <link rel="stylesheet" href="../../asset/font/Trirong.css">
  <link href="./css/student.css" rel="stylesheet">
  <title>HomePage</title>
</head>

<body>
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
      <div class="mdl-layout__header-row">
        <span class="mdl-layout-title"></span>
        <div class="mdl-layout-spacer"></div>
        <nav class="mdl-navigation mdl-layout--large-screen-only">
          <a class="mdl-navigation__link" href="index.php"><i class="fa fa-home margin-r-5" aria-hidden="true"></i>หน้าหลัก</a>
          <a class="mdl-navigation__link" href="register.php"><i class="fa fa-file-text-o margin-r-5" aria-hidden="true"></i>ส่งแบบฟอร์ม</a>
          <a class="mdl-navigation__link" href="setting.php"><i class="fa fa-key margin-r-5" aria-hidden="true"></i>เปลียนรหัสผ่าน</a>
        </nav>
      </div>
    </header>
    <div class="mdl-layout__drawer">
      <span class="mdl-layout-title"></span>
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php"><i class="fa fa-home margin-r-5" aria-hidden="true"></i>หน้าหลัก</a>
        <a class="mdl-navigation__link" href="register.php"><i class="fa fa-file-text-o margin-r-5" aria-hidden="true"></i>ส่งแบบฟอร์ม</a>
        <a class="mdl-navigation__link" href="setting.php"><i class="fa fa-key margin-r-5" aria-hidden="true"></i>เปลียนรหัสผ่าน</a>
        <a class="mdl-navigation__link" href="../logout.php"><i class="fa fa-sign-out margin-r-5" aria-hidden="true"></i>ออกจากระบบ</a>
      </nav>
    </div>
    <main class="mdl-layout__content">
      <!-- Main content -->
      <section class="invoice w-50">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header topic">
              <img src="../../public/images/logopage1.svg" width="60" class="topic-logo" alt=""> ระบบบริหารจัดการกองทุนฯ
              <small class="pull-right"> <span id="year"></span></small>
            </h2>
          </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">

        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
          <div class="col-sm-3 invoice-col">
            <div class="box-body">

              <strong><i class="fa fa-user-circle-o margin-r-5" aria-hidden="true"></i>ชื่อผู้ใช้</strong><br><br>
              <span class="text-muted ">ชื่อ: <?php echo $_SESSION['FirstName'] . "  " . $_SESSION['LastName']; ?></span><br>
              <span class="text-muted">สถานะ: <?php echo $_SESSION['STATUS']; ?></span>
              <hr>
              <strong><i class="fa fa-map-marker margin-r-5"></i> กำหนดการ</strong>
              <p class="text-muted">เปิดลงทะเบียน:
                <?php
                if (empty($_SESSION['END'])) {
                  echo "ไม่มีการระบุวันที่เริ่มต้น";
                } else {
                  $dateSTART = explode('-', $_SESSION['START']);
                  $dateST = explode(' ', $dateSTART[2]);
                  $month = array(
                    "", "มกราคม", "กุมภาพันธ์ ", "มีนาคม",
                    "เมษายน", "พฤษภาคม", "มิถุนายน ", "กรกฎาคม", "สิงหาคม",
                    "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                  );
                  unset($month[0]);
                  $datestarted = $dateST[0] . ' / ' . $month[$dateSTART[1] - 1] . ' / ' . ($dateSTART['0'] + 543);
                  echo $datestarted;
                }
                ?>
              </p>
              <p class="text-muted">หมดสิทธิสมัครรับทุน:
                <?php
                if (empty($_SESSION['END'])) {
                  echo "ไม่มีการระบุวันที่สิ้นสุด";
                } else {
                  $dateArr = explode('-', $_SESSION['END']);
                  $date = explode(' ', $dateArr[2]);
                  $month = array(
                    "", "มกราคม", "กุมภาพันธ์ ", "มีนาคม",
                    "เมษายน", "พฤษภาคม", "มิถุนายน ", "กรกฎาคม", "สิงหาคม",
                    "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                  );
                  unset($month[0]);
                  $dateThai = $date[0] . ' / ' . $month[$dateArr[1] - 1] . ' / ' . ($dateArr['0'] + 543);
                  echo $dateThai;
                }
                ?>
              </p>
              <hr>
              <strong><i class="fa fa-file-text-o margin-r-5"></i> คำชี้แจง</strong>
              <p class="text-muted">โปรดกรอกข้อมูลที่สำคัญให้ครบ <br> เนื่องจากจะมีผลต่อการพิจารณาให้ทุนฯ</p>
            </div><!-- /.box-body -->

          </div><!-- /.col -->
          <div class="col-xs-9 table-responsive ">
            <table class="table table-hover">
              <tr>
                <th>ขั้นตอน</th>
                <th>สถานะ</th>
                <th>หมายเหตุ</th>
              </tr>

              <?php
              $date = date('Y');
              $sql = "SELECT f.FORM_ID as formid,CONCAT(ad.EM_NAME,' ',ad.EM_LASTNAME) as AD_NAME ,rq_ad.REQ_STATUS as ad_st,f.REQ_STATUS as rq, f.REQ_STATUS_DIRECTOR as dq," .
                "IF(f.REQ_STATUS = 0,'กำลังดำเนินการ','เสร็จสิ้น') as AD_STEP, CONCAT(dt.EM_NAME,' ',dt.EM_LASTNAME) as DT_NAME," .
                " rq_dt.REQ_STATUS as dt_st, DIRECTOR_ID,BY_ADMIN," .
                "TO_ADMIN FROM formtb f INNER JOIN employeetb ad ON f.AD_ID=ad.EM_ID INNER JOIN req_status rq_ad ON f.REQ_STATUS=rq_ad.REQSTATUS_ID" .
                " INNER JOIN employeetb dt ON f.DIRECTOR_ID=dt.EM_ID INNER JOIN req_status rq_dt ON f.REQ_STATUS_DIRECTOR=rq_dt.REQSTATUS_ID " .
                "WHERE f.FORM_ID != 0 AND f.ST_ID = :ST_ID AND YEAR(f.DATE_) = :YEARS";
              $query = $conn->prepare($sql);
              $query->bindParam(':ST_ID', $_SESSION['Accout_id']);
              $query->bindParam(':YEARS', $date);
              $query->execute();
              $row = $query->fetch();
              ?>
              <tr>
                <td>ส่งแบบฟอร์ม</td>
                <td>
                  <?php
                  if (empty($row['formid'])) {
                    echo '<i class="fa fa-history" style="color:#EE0000;" aria-hidden="true"></i>';
                  } else {
                    echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
                  }
                  ?>
                </td>
                <td>หมายเลขแบบฟอร์ม :
                  <?php echo $row['formid']; ?>
                </td>
              </tr>

              <tr>
                <td>การพิจารณาของอาจารย์</td>

                <td>
                  <?php
                  if (empty($row['ad_st'])) {
                    echo '<i class="fa fa-history" style="color:#EE0000;" aria-hidden="true"></i>';
                  } else {
                    if ($row['rq'] == 0) {
                      echo '<i class="fa fa-history" style="color:#FFD700;" aria-hidden="true"></i>';
                    } else {
                      echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
                    }
                  }
                  ?>
                </td>
                <td>

                </td>
              </tr>

              <tr>
                <td>การสัมภาษณ์ของกรรมการทุนฯ</td>
                <td>
                  <?php
                  if (empty($row['dt_st'])) {
                    echo '<i class="fa fa-history" style="color:#EE0000;" aria-hidden="true"></i>';
                  } else {
                    if ($row['dq'] == 0) {
                      echo '<i class="fa fa-history" style="color:#FFD700;" aria-hidden="true"></i>';
                    } else {
                      echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
                    }
                  }
                  ?>
                </td>
                <td>

                </td>
              </tr>

              <tr>
                <td>ผลการพิจารณา</td>
                <td>
                  <?php
                  if (empty($row['formid'])) {
                    echo '<i class="fa fa-history" style="color:#EE0000;"  aria-hidden="true"></i>';
                  } else {
                    if ($row['BY_ADMIN'] == 0) {
                      echo '<i class="fa fa-history" style="color:#FFD700;" aria-hidden="true"></i>';
                    } else {
                      echo '<i class="fa fa-check" style="color:#7FFF00;" aria-hidden="true"></i>';
                    }
                  }
                  ?>
                </td>
                <td>
                  ติดตามประกาศผลฯ:
                  <a href="https://www.facebook.com/%E0%B8%87%E0%B8%B2%E0%B8%99%E0%B8%81%E0%B8%AD%E0%B8%87%E0%B8%97%E0%B8%B8%E0%B8%99%E0%B8%AF-%E0%B8%9A%E0%B8%9E%E0%B8%B4%E0%B8%95%E0%B8%A3%E0%B8%9E%E0%B8%B4%E0%B8%A1%E0%B8%B8%E0%B8%82-%E0%B8%88%E0%B8%B1%E0%B8%81%E0%B8%A3%E0%B8%A7%E0%B8%A3%E0%B8%A3%E0%B8%94%E0%B8%B4-858180540866398">
                    งานกองทุนฯ บพิตรพิมุข จักรวรรดิ
                  </a>
                </td>
              </tr>


            </table>
          </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row no-print">
          <div class="col-xs-12">
            <a class="btn btn-success pull-right" href="../logout.php"><i class="fa fa-sign-out margin-r-5" aria-hidden="true"></i>ออกจากระบบ</a>
          </div>
        </div>
      </section>
      <div class="clearfix"></div>
  </div>
  </main>
  </div>
</body>
<script src="../../asset/js/material.min.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>
<script>
  const monthNames = ["มกราคม", "กุมภาพันธ์ ", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน ",
    "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
  ];
  const dateObj = new Date();
  const month = monthNames[dateObj.getMonth()];
  const day = String(dateObj.getDate()).padStart(2, '0');
  const year = dateObj.getFullYear() + 543
  const output = day + ' / ' + month + ' / ' + year;
  document.getElementById('year').textContent = output;
</script>

</html>