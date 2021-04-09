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
                        <h2 class="page-header topic">
                            <img src="../../public/images/logopage1.svg" width="60" class="topic-logo" alt="">
                            ระบบบริหารจัดการทุนการศึกษา
                            <small class="pull-right">
                                <span id="year"></span>
                            </small>
                        </h2>
                    </div><!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <i class="fa fa-address-card-o margin-r-5" aria-hidden="true"></i>ข้อมูลผู้ใช้
                        <address>
                            <strong>ชื่อ: <?php echo $_SESSION['FirstName'] . '   ' . $_SESSION['LastName']; ?></strong><br>
                            สถานะ: <?php echo $_SESSION['STATUS']; ?><br>

                            <strong>เวลากำหนดการ:
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
                            </strong>
                        </address>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="box-header with-border">
                            <span class=""><i class="fa fa-graduation-cap margin-r-5" aria-hidden="true"></i>ดึงรายชื่อนักศึกษาจากกรรมการ</span>
                            <select class="form-select form-select-sm" id="dt">
                                <option selected>รายชื่อกรรมการ</option>
                                <?php
                                $dt = "SELECT EM_ID,CONCAT(EM_NAME,' ',EM_LASTNAME) as DT  FROM employeetb WHERE EM_DEPART = '2'";
                                $query = $conn->query($dt);
                                $row = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($row as $i) {
                                    echo "<option value='" . $i['EM_ID'] . "'>" . $i['DT'] . "</option>";
                                }
                                ?>
                            </select>
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
                                    <th>คะแนนพิจาณารวม</th>
                                    <th colspan="2">พิจารณา</th>
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
<script>
    $(document).ready(function() {

        $('#dt').change(function(e) {
            e.preventDefault()
            $.ajax({
                url: "sv/load.php",
                type: "POST",
                data: {
                    search: $(this).val()
                },
                success: function(res) {
                    $('#tbody').html(res)
                }
            })
        })

        $(document).on('click', '.btn-id', function() {
            var button_id = $(this).attr("id");
            $.ajax({
                url: "sv/add-score.php",
                type: "POST",
                data: {
                    form_id: button_id
                },
                success: function(res) {
                    alert(res)
                }
            })
        });

        $(document).on('click', '.btn-del', function() {

            var button_id = $(this).attr("id");
            if (confirm("ต้องการคัดนักศึกษาออก")) {
                msg = prompt("หมายเหตุ", "");
                if (msg) {
                    $.ajax({
                        url: "sv/add-score.php",
                        type: "POST",
                        data: {
                            btn_del: button_id,
                            msg: msg
                        },
                        success: function(res) {
                            alert(res)
                        }
                    })
                }
            }

        });


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
<script src="../../asset/js/785b7d6451.js"></script>

</html>
</body>

</html>