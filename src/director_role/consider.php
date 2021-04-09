<?php
session_start();
if (empty($_SESSION['Login'])) {
    header('location: /');
    exit;
}
if ($_SESSION['STATUS'] != "กรรมการ") {
    header('location: /src/' . $_SESSION['STATUSENG'] . '_role');
    exit;
}
require_once '../../config/database/db.php';


try {
    if ($_GET['form']) {
        $sql = "SELECT FORM_ID, ST_ID, ST_NUMBER, F_NAME, L_NAME, fc.ST_FACULTY as Faculty, m.ST_MAJOR as MAJOR," .
            " pg.ST_PROGRAM as PROGRAM,CONCAT(em.EM_NAME,'  ',em.EM_LASTNAME) as AD_CLASS, AD_ID, ST_GEN, ST_GRADE, DATE_," .
            " ST_AGE_, BRITH_YEAR, ST_NAT, ST_RACE, ST_RELIGION, ST_LOCAT, ST_HOME, ST_ALLAY, ST_STREET, sd1.SUBDIST_NAME as ST_SD," .
            " d1.DISTRICT_NAME as ST_D, pv1.PROVINCE_NAME as ST_PV, ST_TELL, ST_PHONE, FACEBOOK, FAMILY_STATUS, FULLNAME_FATHER," .
            " FATHER_CAREER, FATHER_INCOME, FATHER_PHONE, FULLNAME_MOTHER, MOTHER_CAREER, MOTHER_INCOME, MOTHER_PHONE,NUM_RELA, BEING_NUM, STAY_WITH," .
            " CURR_HOME, CURR_ALLAY, CURR_STREET, sd2.SUBDIST_NAME as ST_SD2, d2.DISTRICT_NAME as ST_D2,pv2.PROVINCE_NAME as ST_PV2, PATR_FULLNAME," .
            " PATR_CAREER, PATR_INCOME, RELAT, PATR_PHONE, SCH_BORROW, SCHOLAR, Job, PARTTIME_PLACE,P_DETAIL_CARR, P_TIME_PERIOD, P_INCOME," .
            " FULLTIME_PLACE, F_DETAIL_CARR, F_TIME_PERIOD, F_INCOME, ACTI_TIME_PERIOD, ACTI_HOURS, ACTI_DESCRIBE,ST_DESCRIPE,rs.REQ_STATUS as CMT_AD," .
            " ADVISOR_DESCRIBE,CONCAT(em_dt.EM_NAME,' ',em_dt.EM_LASTNAME) as DT_N,ed.S_STATUS as DEPART,DIRECTOR_ID FROM formtb f INNER JOIN facultytb fc ON f.ST_FACULTS = fc.facultytb" .
            " INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR INNER JOIN programtb pg ON f.ST_PROGRAMS=pg.ID_PROGRAM INNER JOIN employeetb em ON f.AD_ID=em.EM_ID INNER JOIN subdisttb sd1 ON" .
            " f.ST_SUBDIST=sd1.SUBDIST_ID INNER JOIN disttb d1 ON f.ST_DIST=d1.DISTRICT_ID INNER JOIN provincetb pv1 ON f.ST_PROVINCE=pv1.PROVINCE_ID" .
            " INNER JOIN subdisttb sd2 ON f.CURR_SUBDIST=sd2.SUBDIST_ID INNER JOIN disttb d2 ON f.CURR_DIST=d2.DISTRICT_ID INNER JOIN provincetb pv2 ON" .
            " f.CURR_PROVINCE=pv2.PROVINCE_ID INNER JOIN REQ_STATUS rs ON f.REQ_STATUS=rs.REQSTATUS_ID INNER JOIN employeetb em_dt ON f.DIRECTOR_ID = em_dt.EM_ID" .
            " INNER JOIN statustb ed ON em_dt.EM_DEPART=ed.STATUS_ID WHERE f.FORM_ID = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':id', $_GET['form'], PDO::PARAM_INT);
        $query->execute();
        $i = $query->fetch(PDO::FETCH_ASSOC);

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="../../asset/css/bootstrap.min.css" rel="stylesheet">
            <link href="../../asset/css/material-icons.css" rel="stylesheet">
            <link href="../../asset/css/material.indigo-pink.min.css" rel="stylesheet">
            <link href="../../asset/css/AdminLTE.min.css" rel="stylesheet">
            <link rel="stylesheet" href="../../asset/font/Trirong.css">
            <link href="./css/dt-consider.css" rel="stylesheet">
            <title>พิจารณาการให้ทุนการศึกษา
            </title>
        </head>

        <body>
            <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
                <header class="mdl-layout__header">
                    <div class="mdl-layout__header-row">
                        <span class="mdl-layout-title"></span>
                        <div class="mdl-layout-spacer"></div>
                        <nav class="mdl-navigation mdl-layout--large-screen-only">
                            <a class="mdl-navigation__link" href="index.php"><i class="fa fa-home  margin-r-5" aria-hidden="true"></i>หน้าหลัก</a>
                            <a class="mdl-navigation__link" href="setting.php"><i class="fa fa-key margin-r-5" aria-hidden="true"></i>เปลียนรหัสผ่าน</a>
                        </nav>
                    </div>
                </header>
                <div class="mdl-layout__drawer">
                    <span class="mdl-layout-title"></span>
                    <nav class="mdl-navigation">
                        <a class="mdl-navigation__link" href="index.php"><i class="fa fa-home margin-r-5" aria-hidden="true"></i>หน้าหลัก</a>
                        <a class="mdl-navigation__link" href="setting.php"><i class="fa fa-key margin-r-5" aria-hidden="true"></i>เปลียนรหัสผ่าน</a>
                        <a class="mdl-navigation__link" href="../logout.php"><i class="fa fa-sign-out margin-r-5" aria-hidden="true"></i>ออกจากระบบ</a>
                    </nav>
                </div>
                <main class="mdl-layout__content">

                    <div class="card mt-3 card-box">
                        <div class="card-header">
                            แบบฟอร์มสมัครขอรับทุนการศึกษา ประจำปีการศึกษา พ.ศ. <span id="year">2563 </span>
                        </div>
                        <div class="card-body col-sm-12 col-md-12">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">ประวัตินักศึกษา</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">รหัสนึกศึกษา: <?php echo $i['ST_NUMBER']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ชื่อ: <?php echo $i['F_NAME']; ?></label>

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">นามสกุล: <?php echo $i['L_NAME']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">คณะ: <?php echo $i['Faculty']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">สาขา: <?php echo $i['MAJOR']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">หลักสูตร: <?php echo $i['PROGRAM']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ชั้นปี: <?php echo $i['ST_GEN']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">อาจารย์ที่ปรึกษา: <?php echo $i['AD_CLASS']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">คะแนนเฉลี่ยสะสม: <?php echo $i['ST_GRADE']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">วัน/เดือน/ปีเกิด:
                                                <?php
                                                if (empty($i['BRITH_YEAR'])) {
                                                    echo "ไม่มีข้อมูล";
                                                } else {
                                                    $dateArr = explode('-', $i['BRITH_YEAR']);
                                                    $month = array(
                                                        "", "มกราคม", "กุมภาพันธ์ ", "มีนาคม",
                                                        "เมษายน", "พฤษภาคม", "มิถุนายน ", "กรกฎาคม", "สิงหาคม",
                                                        "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                                                    );
                                                    unset($month[0]);
                                                    $dateThai = $dateArr[2] . ' / ' . $month[$dateArr[1] - 1] . ' / ' . ($dateArr['0'] + 543);
                                                    echo $dateThai;
                                                }
                                                ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">อายุ: <?php echo $i['ST_AGE_']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">เชื้อชาติ: <?php echo $i['ST_NAT']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">สัญชาติ: <?php echo $i['ST_RACE']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ศาสนา: <?php echo $i['ST_RELIGION']; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">ที่อยู่ตามทะเบียนบ้าน</h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">บ้านเลขที่: <?php echo $i['ST_HOME']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ตรอก/ซอย: <?php echo $i['ST_ALLAY']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ถนน: <?php echo $i['ST_STREET']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ตำบลแขวง: <?php echo $i['ST_SD']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">อำเภอ/เขต: <?php echo $i['ST_D']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">จังหวัด: <?php echo $i['ST_PV']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">โทรศัพท์(บ้าน): <?php echo $i['ST_TELL']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">มือถือ: <?php echo $i['ST_PHONE']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">Facebook: <?php echo $i['FACEBOOK']; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title">สถานภาพครอบครัว</h6>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-sm-12 col-md-12 ">
                                        <div class="form-check form-check-inline check-forms m-3">
                                            <label class="form-check-label label" for="inlineRadio1">สถานะ: <?php echo $i['FAMILY_STATUS']; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ชื่อ-นามสกุล บิดา: <?php echo $i['FULLNAME_FATHER']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">อาชีพ: <?php echo $i['FATHER_CAREER']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">รายได้ต่อเดือนเฉลี่ย: <?php echo $i['FATHER_INCOME']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">เบอร์โทรศัพท์: <?php echo $i['FATHER_PHONE']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ชื่อ-นามสกุล มารดา: <?php echo $i['FULLNAME_MOTHER']; ?></label>

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">อาชีพ: <?php echo $i['MOTHER_CAREER']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">รายได้ต่อเดือนเฉลี่ย: <?php echo $i['MOTHER_INCOME']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">เบอร์โทรศัพท์: <?php echo $i['MOTHER_PHONE']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">มีพี่น้องรวม: <?php echo $i['NUM_RELA']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ข้าพเจ้าเป็นคนที่: <?php echo $i['BEING_NUM']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ปัจจุบันอาศัยอยู่กับ: <?php echo $i['STAY_WITH']; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">ที่อยู่ปัจจุบัน</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">บ้านเลขที่: <?php echo $i['CURR_HOME']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ตรอก/ซอย: <?php echo $i['CURR_ALLAY']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ถนน: <?php echo $i['CURR_STREET']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ตำบลแขวง: <?php echo $i['ST_SD2']; ?></label>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">อำเภอ/เขต: <?php echo $i['ST_D2']; ?></label>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">จังหวัด: <?php echo $i['ST_PV2']; ?></label>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ชื่อ-นามสกุล
                                                ผู้อุปการะ: <?php echo $i['PATR_FULLNAME']; ?></label>

                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">อาชีพ: <?php echo $i['PATR_CAREER']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">รายได้ต่อเดือนเฉลี่ย: <?php echo $i['PATR_INCOME']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">เบอร์โทรศัพท์: <?php echo $i['PATR_PHONE']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">มีความสัมพันธ์กับนักศึกษาคือ: <?php echo $i['RELAT']; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">ประวัติการรับทุนการศึกษา</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-2 mt-0 label">กู้ยืมกองทุนเงินให้กู้ยืมเพื่อการศึกษา(กยศ.)หรือไม่:</h6>
                                    </div>
                                </div>
                                <div class="row m-2">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-check ">
                                            <div class="alert alert-light" role="alert">
                                                <label for="disabledTextInput" class="form-label label"><?php echo $i['SCH_BORROW']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-2 mt-0 label">ได้รับทุนการศึกษา:</h6>
                                    </div>
                                </div>
                                <div class="row m-3">
                                    <div class="form-check">
                                        <div class="alert alert-light" role="alert">
                                            <label for="disabledTextInput" class="form-label label"><?php echo $i['SCHOLAR']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-sm-12 col-md-12 ">
                                        <div class="table-responsive-md ">
                                            <table class="table  table-borderless tb-responsive">
                                                <thead class="table-light">
                                                    <tr>
                                                        <td colspan="4">
                                                            ลำดับ
                                                        </td>
                                                        <td colspan="4">
                                                            ปีการศึกษา
                                                        </td>
                                                        <td colspan="4">
                                                            ประเภท
                                                        </td>
                                                        <td colspan="4">
                                                            ชื่อทุนการศึกษา
                                                        </td>
                                                        <td colspan="4">
                                                            คุณสมบัติผู้รับทุน
                                                        </td>
                                                        <td colspan="4">
                                                            จำนวนเงิน
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT OLD_SCHO, OLDSCHOLA_YEAR, OLDSCHOLA_CATE, PROPERTY, OLDSCHOLA_VALUE FROM old_scholarship WHERE OLD_ID !=0 AND OLD_FORM = :formid";
                                                    $query = $conn->prepare($sql);
                                                    $query->bindParam(':formid', $i['ST_ID']);
                                                    $query->execute();
                                                    $row = $query->fetchAll(PDO::FETCH_ASSOC);
                                                    $n = 1;
                                                    foreach ($row as $j) {
                                                    ?>
                                                        <tr>
                                                            <td colspan="4">
                                                                <?php echo $n++; ?>
                                                            </td>
                                                            <td colspan="4">
                                                                <div class="mb-3">
                                                                    <?php echo $j['OLDSCHOLA_YEAR']; ?>
                                                                </div>
                                                            </td>
                                                            <td colspan="4">
                                                                <div class="mb-3">
                                                                    <?php echo $j['OLDSCHOLA_CATE']; ?>
                                                                </div>
                                                            </td>
                                                            <td colspan="4">
                                                                <div class="mb-3">
                                                                    <?php echo $j['OLD_SCHO']; ?>
                                                                </div>
                                                            </td>
                                                            <td colspan="4">
                                                                <div class="mb-3">
                                                                    <?php echo $j['PROPERTY']; ?>
                                                                </div>
                                                            </td>
                                                            <td colspan="4">
                                                                <div class="mb-3">
                                                                    <?php echo $j['OLDSCHOLA_VALUE']; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">ประสบการณ์ทำงาน</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ทำงานนอกเวลาที่: <?php echo $i['PARTTIME_PLACE']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ลักษณะงานที่ทำ: <?php echo $i['P_DETAIL_CARR']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ระยะเวลาที่ทำงาน: <?php echo $i['P_TIME_PERIOD']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">รายได้/วันละ: <?php echo $i['P_INCOME']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ทำงานเต็มเวลาที่: <?php echo $i['FULLTIME_PLACE']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ลักษณะงานที่ทำ: <?php echo $i['F_DETAIL_CARR']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ระยะเวลาที่ทำงาน: <?php echo $i['F_TIME_PERIOD']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">รายได้/วันละ: <?php echo $i['F_INCOME']; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">กิจกรรมจิตอาสา:</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">ระยะเวลาที่ทำกิจกรรมจิตอาสา: <?php echo $i['ACTI_TIME_PERIOD']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">จำนวนชั่วโมงกิจกรรมจิตอาสา: <?php echo $i['ACTI_HOURS']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="disabledTextInput" class="form-label label">บรรยายกิจกรรมจิตอาสา: </label>
                                            <div class="alert alert-secondary" role="alert">
                                                <p><?php echo $i['ACTI_DESCRIBE']; ?></p>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">ปัญหาและความจำเป็นที่จะต้องใช้ทุน</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <div class="alert alert-secondary" role="alert">
                                                <p><?php echo $i['ST_DESCRIPE']; ?></p>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">ความเห็นของอาจารย์ที่ปรึกษา</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label label">ข้าพเจ้า:
                                                <?php echo $i['AD_CLASS']; ?><br>เป็นอาจารย์ที่ปรึกษาชั้นปี: <?php echo $i['ST_GEN']; ?> </label>
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label label">พิจารณาแล้วมีความเห็นว่า: <?php echo $i['CMT_AD']; ?></label>
                                                <div class="alert alert-primary" role="alert">
                                                    <p><?php echo $i['ADVISOR_DESCRIBE']; ?></p>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-title mb-5 mt-0">ความเห็นของกรรมการ</h6>
                                    </div>
                                </div>
                                <form id="form">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label label">ข้าพเจ้า:
                                                    <?php echo $i['DT_N']; ?><br>ตำแหน่ง: <?php echo $i['DEPART']; ?></label>
                                                <div class="mb-3">
                                                    <label for="exampleFormControlTextarea1" class="form-label label">พิจารณาแล้วมีความเห็นว่า</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_comment" required value="1">
                                                        <input class="form-check-input" type="hidden" name="form_id" value="<?php echo $i['FORM_ID']; ?>">
                                                        <input class="form-check-input" type="hidden" name="date_of_comment" value="<?php echo date('Y-m-d'); ?>">
                                                        <input class="form-check-input" type="hidden" name="director_id" value="<?php echo $i['DIRECTOR_ID']; ?>">
                                                        <label class="form-check-label label" for="inlineRadio1">สมควร</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_comment" required value="2">
                                                        <label class="form-check-label label" for="inlineRadio2">ไม่สมควร</label>
                                                    </div>
                                                </div>
                                                <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                            <?php
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                            ?>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <h6 class="card-title mb-2 mt-0">เกณฑ์การให้คะแนน:</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 ">
                                    <div class="form-group">
                                        <label for="exampleInputFile">เกรดเฉลี่ย</label>
                                        <input class="form-control" value="0" name="gradeScore" type="number" placeholder="เต็ม 15 คะแนน">
                                        <p class="help-block">คะแนนเต็ม 15 คะแนน</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 ">
                                    <div class="form-group">
                                        <label for="exampleDataList" class="form-label">รายได้ต่อครอบครัว</label>
                                        <input class="form-control" value="0" name="incomeScore" type="number" placeholder="เต็ม 15 คะแนน">
                                        <p class="help-block">คะแนนเต็ม 15 คะแนน</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="exampleDataList" class="form-label">สถานภาพครอบครัว</label>
                                        <input class="form-control" value="0" name="familyScore" type="number" placeholder="เต็ม 25 คะแนน">
                                        <p class="help-block">คะแนนเต็ม 25 คะแนน</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="exampleDataList" class="form-label">การแต่งกายและความประพฤติ</label>
                                        <input class="form-control" value="0" name="personScore" type="number" placeholder="เต็ม 25 คะแนน">
                                        <p class="help-block">คะแนนเต็ม 25 คะแนน</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="exampleDataList" class="form-label">จิตอาสาและการมีส่วนร่วม</label>
                                        <input class="form-control" value="0" name="actyScore" type="number" placeholder="เต็ม 20 คะแนน">
                                        <p class="help-block">คะแนนเต็ม 20 คะแนน</p>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12 col-md-6 ">
                                    <div class="mb-3">
                                        <button type="submit" href="index.php" class="btn btn-primary save-btn">
                                            <i class="fa fa-floppy-o margin-r-5" aria-hidden="true"></i> บันทึก</button>
                                        <a type="submit" href="index.php" class="btn btn-success save-btn"><i class="fa fa-home margin-r-5" aria-hidden="true"></i> หน้าหลัก</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="footer">
                                        <p class="text-footer label">โปรดเช็คว่าท่านได้กรอกข้อมูลครบถ้วน</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
            </main>
            </div>
        </body>
        <script src="../../asset/js/material.min.js"></script>
        <script src="../../asset/js/jquery-3.2.1.min.js"></script>
        <script src="../../asset/js/785b7d6451.js"></script>
        <script>
            $(document).ready(function() {

                $('#form').submit(function(e) {
                    e.preventDefault()
                    $.ajax({
                        url: "sv/comment.php",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(res) {
                            if (res === "บันทึกคำพิจารณาสำเร็จ") {
                                alert(res)
                                window.location.href = "index.php"
                            }
                        }
                    })
                })

            });
        </script>
        <script>
            document.getElementById('year').textContent = new Date().getFullYear() + 543;
        </script>

        </html>