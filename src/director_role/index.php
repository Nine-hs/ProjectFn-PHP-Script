<?php
require_once '../../config/database/db.php';
session_start();
if (empty($_SESSION['Login'])) {
    header('location: /');
    exit;
}
if ($_SESSION['STATUS'] != "กรรมการ") {
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
    <link href="./css/directors.css" rel="stylesheet">
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
                    <a class="mdl-navigation__link" href="setting.php"><i class="fa fa-key margin-r-5" aria-hidden="true"></i>เปลียนรหัสผ่าน</a>
                </nav>
            </div>
        </header>
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title"></span>
            <nav class="mdl-navigation">
                <a class="mdl-navigation__link" href="index.php"><i class="fa fa-home margin-r-5" aria-hidden="true"></i>หน้าหลัก</a>
                <a class="mdl-navigation__link" href="setting.php"><i class="fa fa-key margin-r-5" aria-hidden="true"></i>เปลียนรหัสผ่าน</a>
                <a class="mdl-navigation__link" href="/project-final"><i class="fa fa-sign-out margin-r-5" aria-hidden="true"></i>ออกจากระบบ</a>
            </nav>
        </div>
        <main class="mdl-layout__content">
            <!-- Main content -->
            <section class="invoice w-50">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header topic">
                            <img src="../../public/images/logopage1.svg" width="60" class="topic-logo" alt="">
                            ระบบบริหารจัดการทุนการศึกษา
                            <small class="pull-right .year">
                                <span id="year"></span>
                            </small>
                        </h2>
                    </div><!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <strong><i class="fa fa-address-card-o margin-r-5" aria-hidden="true"></i>ข้อมูลผู้ใช้</strong><br>
                        <address>

                            ชื่อ: <?php echo $_SESSION['FirstName'] . '   ' . $_SESSION['LastName']; ?><br>
                            สถานะ: <?php echo $_SESSION['STATUS']; ?><br>

                            เวลากำหนดการ:
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

                        </address>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-header with-border">
                            <span class=""><i class="fa fa-graduation-cap margin-r-5" aria-hidden="true"></i>รายชื่อนักศึกษา</span>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive table-height">
                        <table class="table table-striped ">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อ - นามสกุล</th>
                                    <th>ชั้นปี</th>
                                    <th>สถานะ</th>
                                    <th>พิจารณา</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
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
<script src="../../asset/js/jquery-3.2.1.min.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            $('#tbody').load('./sv/load.php')
        }, 3000)
    });
</script>
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