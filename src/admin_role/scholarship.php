<?php
require_once '../../config/database/db.php';
session_start();
if (empty($_SESSION['Login'])) {
    header('location: /');
    exit;
}
if ($_SESSION['STATUS'] != "หัวหน้าฝ่ายกองทุน") {
    header('location: /src/' . $_SESSION['STATUSENG'] . '_role');
    exit;
}

$sql = "SELECT ev.title as title,ev.start_event as STARTT, ev.end_event as ENDD FROM" .
    " events ev WHERE YEAR(ev.start_event) = :YEARS AND ev.By_status LIKE CONCAT('%' ,:BY_STATUS, '%')";
$query = $conn->prepare($sql);
$query->execute(['YEARS' => date('Y'), 'BY_STATUS' => $_SESSION['STATUS']]);
$row = $query->fetch();
if (isset($row['ENDD'])) {
    $_SESSION['START'] = $row['STARTT'];
    $_SESSION['END'] = $row['ENDD'];
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
    <link rel="stylesheet" href="../../asset/font/Trirong.css">
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
            <!-- Main content -->
            <section class="invoice w-50">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h6 class="page-header topic">
                            <img src="../../public/images/logopage1.svg" width="60" class="topic-logo" alt="">
                            บันทึกข้อมูลนักศึกษา
                            <small class="pull-right">
                                <span id="year"></span>
                            </small>
                        </h6>
                    </div><!-- /.col -->
                </div>
                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive col-scholar">
                        <div class="box-body">
                            <div class="row no-print">
                                <div class="col-sm-12 col-md-6">
                                    <label><i class="fa fa-graduation-cap margin-r-5"></i>เลือกทุนฯ</label>
                                    <select class="form-control" id="scholarship">
                                        <?php
                                        $year = date('Y');
                                        $sc = "SELECT SCHOLAR_ID, SCHOLAR_NAME FROM scolartb WHERE YEAR(scolar_date) = :YEARS";
                                        $querySC = $conn->prepare($sc);
                                        $querySC->bindParam(':YEARS', $year, PDO::PARAM_STR);
                                        $querySC->execute();
                                        $rows = $querySC->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($rows as $s) {
                                        ?>
                                            <option value="<?php echo $s['SCHOLAR_ID'] ?>"><?php echo $s['SCHOLAR_NAME'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label><i class="fa fa-book margin-r-5"></i>เลือกสาขา</label>
                                    <select class="form-control" id="majors">
                                        <?php
                                        $year = date('Y');
                                        $sc = "SELECT * FROM majors";
                                        $querySC = $conn->query($sc);
                                        $querySC->execute();
                                        $rows = $querySC->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($rows as $s) {
                                        ?>
                                            <option value="<?php echo $s['ID_MAJOR'] ?>"><?php echo $s['ST_MAJOR'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                        </div><!-- /.box-footer -->
                        <div class="row no-print">
                            <div class="col-sm-12 col-md-12 table-responsive">
                                <div class="box box-primary width-box">
                                    <div class="box-header">
                                        <div class="box-header with-border">
                                            <div class="row ">
                                                <div class="col-sm-12 col-md-4">
                                                    <strong><i class="fa fa-envelope-open-o margin-r-5"></i> ชื่อทุนฯ</strong>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <span class="text-muted" id="name_scho">

                                                    </span>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <strong><i class="fa fa-hand-o-right margin-r-5"></i> ทุนฯที่มี</strong>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <span>
                                                        จำนวนทุนฯ: <span id="amount"></span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        มูลค่าทุนฯ: <span id="total"></span>
                                                    </span>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <strong><i class="fa fa-hand-o-right margin-r-5"></i> ทุนฯคงเหลือ</strong>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <span>
                                                        จำนวนทุนฯ: <span id="cur_amount"></span>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        มูลค่าทุนฯ: <span id="cur_total"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row ">

                                        </div>
                                    </div>
                                    <form action="test.php" method="POST">
                                        <div class="box-body" id="body-box" style="height: 320px; max-height: 320px;">
                                            <div class="row ">
                                                <div class="col-sm-12 col-md-3">
                                                    <strong><i class="fa fa-graduation-cap margin-r-5"></i> รายชื่อนักศึกษา</strong>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <input type="hidden" name="r_id" id="r_id" value="0">
                                                <input type="hidden" name="txtamount" id="txtamount">
                                                <input type="hidden" name="txttotal" id="txttotal">
                                                <input type="hidden" name="txtcur_amount" id="txtcur_amount">
                                                <input type="hidden" name="txtcur_total" id="txtcur_total">
                                                <div id="showMajor"></div>
                                            </div>

                                        </div><!-- /.box-body -->
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section>
            <div class="clearfix"></div>
    </div>
    </main>
    </div>
</body>
<script src="../../asset/js/material.min.js"></script>
<script src="../../asset/js/jquery-3.2.1.min.js"></script>
<script src="./js/scholar-admin.js"></script>
<script src="./js/table2excel.min.js"></script>
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
</body>

</html>