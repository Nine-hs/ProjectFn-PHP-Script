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
    <link rel="stylesheet" href="../../asset/font/Trirong.css">
    <link href="./css/admin.css" rel="stylesheet">
    <link href="../../asset/css/AdminLTE.min.css" rel="stylesheet">
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
                            ข้อมูลให้ทุนนักศึกษา
                            <small class="pull-right">
                                <span id="year"></span>
                            </small>
                        </h6>
                    </div><!-- /.col -->
                </div>
                <div class="card-body" style="height: 490px; max-height: 490px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">ค้นหาข้อมูลนักศึกษา</label>
                                <input type="text" class="form-control" id="search">
                                <p class="help-block">สามารถค้นหาด้วยชื่อทุนหรือชื่อนักศึกษา</p>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <br>
                        </div>
                        <div class="col-xs-12 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">ชื่อทุน</th>
                                        <th scope="col">จำนวน</th>
                                        <th scope="col">มูลค่า</th>
                                        <th scope="col">ชื่อนักศึกษา</th>
                                        <th scope="col">ชั้นปี</th>
                                        <th scope="col">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">

                                </tbody>
                                <tbody id="tbody2">
                                    <?php
                                    $year = date('Y');
                                    $n = 1;
                                    $sq = "SELECT R_SCHOLAR_ID,s.SCHOLAR_NAME as scholar_name,rq.R_AMOUNT as amount,rq.R_VALUE as values_scholar" .
                                        ",CONCAT(f.F_NAME,' ',f.L_NAME) student," .
                                        " CONCAT(m.M_MAJOR,' ',f.ST_GEN) as MAJOR FROM req_scholarship rq INNER JOIN scolartb s ON rq.R_ID=s.SCHOLAR_ID INNER JOIN formtb f ON rq.FROM_ID=f.FORM_ID " .
                                        " INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR WHERE rq.R_SCHOLAR_ID != 0 AND YEAR(rq.DATE_GIVE) = :YEARS ORDER BY CONCAT(m.M_MAJOR,' ',f.ST_GEN) ASC";
                                    $querystudent = $conn->prepare($sq);
                                    $querystudent->bindParam(':YEARS', $year, PDO::PARAM_STR);
                                    $querystudent->execute();
                                    $rows = $querystudent->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($rows as $i) {
                                    ?>
                                        <tr>
                                            <th scope="col"><?php echo $n++; ?></th>
                                            <td scope="col"><?php echo $i['scholar_name']; ?></td>
                                            <td scope="col"><?php echo $i['amount']; ?></td>
                                            <td scope="col"><?php echo $i['values_scholar']; ?></td>
                                            <td scope="col"><?php echo $i['student']; ?></td>
                                            <td scope="col"><?php echo $i['MAJOR']; ?></td>
                                            <td scope="col">
                                                <button type="button" id="<?php echo $i['R_SCHOLAR_ID']; ?>" class="btn btn-primary btn-sm btn-edit">แก้ไข</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-xs-12">
                        <button class="btn btn-success pull-right" id="create_excel" type="submit"><i class="fa fa-file-excel-o margin-r-5" aria-hidden="true"></i>Excel</button>
                    </div>
                </div>
            </section>
            <div class="clearfix"></div>


    </div>
    </main>
    </div>

    <div class="modal " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลนักศึกษา</h5>
                </div>
                <div class="modal-body">
                    <form action="sv/update_scholarship.php" method="POST">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="mb-3" style="width: auto; max-width:100%;">
                                    <label for="exampleInputEmail1" class="form-label">ชื่อ-นามสกุลนักศึกษา</label>
                                    <input type="text" class="form-control" readonly id="fullnameST">
                                    <input type="hidden" name="oldscho_id" id="oldscho_id">
                                    <input type="hidden" name="req_id" id="req_id">
                                    <div id="emailHelp" class="form-text"><br></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">ชั้นปี</label>
                                    <input type="text" class="form-control" readonly id="grade">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>ชื่อทุนฯ</label>
                                    <select id="schoname" name="schoname" class="form-control">
                                        <?php
                                        $sc = "SELECT SCHOLAR_ID, SCHOLAR_NAME,CURR_AMOUNT, CURR_VALUE FROM scolartb";
                                        $querySC = $conn->query($sc);
                                        $querySC->execute();
                                        $row = $querySC->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($row as $i) {
                                            echo '<option value="' . $i['SCHOLAR_ID'] . '">' . $i['SCHOLAR_NAME'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">จำนวนทุนฯ</label>
                                    <input type="hidden" class="form-control" name="oldutil" id="oldutil">
                                    <input type="text" class="form-control" readonly name="util" id="util">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">มูลค่าทุนฯ</label>
                                    <input type="hidden" class="form-control" name="oldvalue" id="oldvalue">
                                    <input type="text" class="form-control" readonly name="value" id="value">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</body>
<script src="../../asset/js/material.min.js"></script>
<script src="../employee_role/js/jquery-3.2.1.min.js"></script>
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