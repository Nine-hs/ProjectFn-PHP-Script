<?php
require_once '../../config/database/db.php';
session_start();
if (empty($_SESSION['Login'])) {
    header('location: /');
    exit;
}
if ($_SESSION['STATUS'] != "นักศึกษา") {
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
    <link href="../../asset/css/AdminLTE.min.css" rel="stylesheet">
    <link href="../../asset/css/bootstrap.min.css" rel="stylesheet">
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

            <div class="card mt-3 card-box">
                <div class="card-header">
                    แบบฟอร์มลงทะเบียนรับทุนฯ
                </div>
                <div class="card-body col-sm-12 col-md-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <h6 class="card-title m-4">ประวัตินักศึกษา</h6>
                            </div>
                        </div>
                        <!-- action="form.php" method="post" -->
                        <form id="form">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">รหัสนึกศึกษา</label>
                                        <input type="text" id="disabledTextInput" value="<?php echo $_SESSION['Student_id']; ?>" name="stdid" class="form-control" readonly>
                                        <input type="text" id="disabledTextInput" value="<?php echo $_SESSION['Accout_id']; ?>" name="studentid" class="form-control" hidden> <!-- รหัสนศ. จากตาราง -->
                                        <input type="text" id="disabledTextInput" value="<?php echo $_SESSION['Student_id']; ?>" name="studentnumber" class="form-control" hidden> <!-- รหัสนศ. จากม. จากตาราง -->
                                        <input type="text" id="disabledTextInput" value="<?php echo $_SESSION['FirstName']; ?>" name="stdyfname" class="form-control" hidden>
                                        <input type="text" id="disabledTextInput" value="<?php echo $_SESSION['LastName']; ?>" name="stdylname" class="form-control" hidden>
                                        <input type="text" id="disabledTextInput" value="<? echo date('y-m-d'); ?>" name="dateregis" class="form-control" hidden>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ชื่อ</label>
                                        <input type="text" id="disabledTextInput" value="<?php echo $_SESSION['FirstName']; ?>" name="firstname" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">นามสกุล</label>
                                        <input type="text" id="disabledTextInput" value="<?php echo $_SESSION['LastName']; ?>" name="lastname" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">คณะ</label>
                                        <select class="form-select" name="faculty" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $faculty = "SELECT * FROM facultytb WHERE facultytb !=0";
                                            $facul = $conn->query($faculty);
                                            foreach ($facul as $i) {
                                                echo '<option value="' . $i['facultytb'] . '">' . $i['ST_FACULTY'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">สาขา</label>
                                        <select class="form-select" name="major" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $major = "SELECT * FROM majors WHERE ID_MAJOR !=0";
                                            $major = $conn->query($major);
                                            foreach ($major as $i) {
                                                echo '<option value="' . $i['ID_MAJOR'] . '">' . $i['ST_MAJOR'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">หลักสูตร</label>
                                        <select class="form-select" name="program" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $programtb = "SELECT * FROM programtb WHERE ID_PROGRAM !=0";
                                            $program = $conn->query($programtb);
                                            foreach ($program as $i) {
                                                echo '<option value="' . $i['ID_PROGRAM'] . '">' . $i['ST_PROGRAM'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ชั้นปี</label>
                                        <input type="text" id="disabledTextInput" required name="generation" class="form-control">
                                        <div id="emailHelp" class="form-text">กรณีนักศึกษาตกค้างให้พิมพ์คำว่า "(ตกค้าง)" ต่อท้าย</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">อาจารย์ที่ปรึกษา</label>
                                        <select class="form-select" name="advisor" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $subdist = "SELECT em.EM_ID,CONCAT(em.EM_NAME,' ',em.EM_LASTNAME) advisor FROM employeetb em WHERE em.EM_DEPART ='3'";
                                            $subdists = $conn->query($subdist);
                                            foreach ($subdists as $i) {
                                                echo '<option value="' . $i['EM_ID'] . '">' . $i['advisor'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">คะแนนเฉลี่ยสะสม</label>
                                        <input type="text" id="disabledTextInput" required name="grade" class="form-control">
                                        <div id="emailHelp" class="form-text">กรณีนักศึกษาชั้นปีที่ 1 ให้ใช้เกรดจากชั้นมัธยมปีการศึกษาล่าสุด</div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">วัน/เดือน/ปีเกิด</label>
                                        <input type="date" id="disabledTextInput" name="birthdate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">อายุ</label>
                                        <input type="text" id="disabledTextInput" name="age" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">เชื้อชาติ</label>
                                        <input type="text" id="disabledTextInput" name="reace" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">สัญชาติ</label>
                                        <input type="text" id="disabledTextInput" name="national" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ศาสนา</label>
                                        <input type="text" id="disabledTextInput" name="religion" class="form-control">
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
                                    <h6 class="card-title m-4">ที่อยู่ตามทะเบียนบ้าน</h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">บ้านเลขที่</label>
                                        <input type="text" id="disabledTextInput" required name="home_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ตรอก/ซอย</label>
                                        <input type="text" id="disabledTextInput" required name="allay" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ถนน</label>
                                        <input type="text" id="disabledTextInput" required name="street" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ตำบลแขวง</label>
                                        <select class="form-select" name="district" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $subdist = "SELECT * FROM subdisttb WHERE SUBDIST_ID !=0 ORDER BY SUBDIST_NAME ASC";
                                            $subdists = $conn->query($subdist);
                                            foreach ($subdists as $i) {
                                                echo '<option value="' . $i['SUBDIST_ID'] . '">' . $i['SUBDIST_NAME'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">อำเภอ/เขต</label>
                                        <select value="3" class="form-select" name="area" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $DISTRICT = "SELECT * FROM disttb WHERE DISTRICT_ID !=0 ORDER BY DISTRICT_NAME ASC";
                                            $DISTRICTs = $conn->query($DISTRICT);
                                            foreach ($DISTRICTs as $i) {
                                                echo '<option value="' . $i['DISTRICT_ID'] . '">' . $i['DISTRICT_NAME'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">จังหวัด</label>
                                        <select class="form-select" name="province" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $PROVINCE = "SELECT * FROM provincetb WHERE PROVINCE_ID !=0 ORDER BY PROVINCE_NAME ASC";
                                            $PROVINCES = $conn->query($PROVINCE);
                                            foreach ($PROVINCES as $i) {
                                                echo '<option value="' . $i['PROVINCE_ID'] . '">' . $i['PROVINCE_NAME'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">โทรศัพท์(บ้าน)</label>
                                        <input type="text" id="disabledTextInput" name="tell" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">มือถือ</label>
                                        <input type="text" id="disabledTextInput" required name="phone_number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">Facebook</label>
                                        <input type="text" id="disabledTextInput" name="facebook" class="form-control">
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
                                    <h6 class="card-title m-4">สถานภาพครอบครัว</h6>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-check form-check-inline check-forms">
                                        <input class="form-check-input" type="radio" name="status_family" id="inlineRadio1" checked value="บิดา มารดา อยู่ด้วยกัน">
                                        <label class="form-check-label" for="inlineRadio1">บิดา มารดา อยู่ด้วยกัน</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status_family" id="inlineRadio2" value="บิดา มารดา แยกกันอยู่">
                                        <label class="form-check-label" for="inlineRadio2">บิดา มารดา แยกกันอยู่</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status_family" id="inlineRadio3" value="หย่าร้าง">
                                        <label class="form-check-label" for="inlineRadio3">หย่าร้าง</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status_family" id="inlineRadio3" value="บิดา ถึงแก่กรรม">
                                        <label class="form-check-label" for="inlineRadio3">บิดา ถึงแก่กรรม</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status_family" id="inlineRadio3" value="มารดา ถึงแก่กรรม">
                                        <label class="form-check-label" for="inlineRadio3">มารดา ถึงแก่กรรม</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ชื่อ-นามสกุล บิดา</label>
                                        <input type="text" id="disabledTextInput" name="f_father" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">อาชีพ</label>
                                        <input type="text" id="disabledTextInput" name="f_career" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">รายได้ต่อเดือนเฉลี่ย</label>
                                        <input type="text" id="disabledTextInput" name="f_income" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">เบอร์โทรศัพท์</label>
                                        <input type="text" id="disabledTextInput" name="f_phone" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ชื่อ-นามสกุล มารดา</label>
                                        <input type="text" id="disabledTextInput" name="m_mother" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">อาชีพ</label>
                                        <input type="text" id="disabledTextInput" name="m_career" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">รายได้ต่อเดือนเฉลี่ย</label>
                                        <input type="text" id="disabledTextInput" name="m_income" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">เบอร์โทรศัพท์</label>
                                        <input type="text" id="disabledTextInput" name="m_phone" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">มีพี่น้องรวม</label>
                                        <input type="text" id="disabledTextInput" name="numrealation" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ข้าพเจ้าเป็นคนที่</label>
                                        <input type="text" id="disabledTextInput" name="being" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ปัจจุบันอาศัยอยู่กับ</label>
                                        <input type="text" id="disabledTextInput" name="stay_with" class="form-control">
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
                                    <h6 class="card-title m-4">ที่อยู่ปัจจุบัน</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">บ้านเลขที่</label>
                                        <input type="text" id="disabledTextInput" required name="cur_homeno" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ตรอก/ซอย</label>
                                        <input type="text" id="disabledTextInput" required name="cur_allay" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ถนน</label>
                                        <input type="text" id="disabledTextInput" required name="cur_street" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ตำบลแขวง</label>
                                        <select class="form-select" name="cur_district" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $subdist = "SELECT * FROM subdisttb WHERE SUBDIST_ID !=0 ORDER BY SUBDIST_NAME ASC";
                                            $subdists = $conn->query($subdist);
                                            foreach ($subdists as $i) {
                                                echo '<option value="' . $i['SUBDIST_ID'] . '">' . $i['SUBDIST_NAME'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">อำเภอ/เขต</label>
                                        <select class="form-select" name="cur_area" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $DISTRICT = "SELECT * FROM disttb WHERE DISTRICT_ID !=0 ORDER BY DISTRICT_NAME ASC";
                                            $DISTRICTs = $conn->query($DISTRICT);
                                            foreach ($DISTRICTs as $i) {
                                                echo '<option value="' . $i['DISTRICT_ID'] . '">' . $i['DISTRICT_NAME'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">จังหวัด</label>
                                        <select class="form-select" name="cur_province" required aria-label="Default select example">
                                            <option selected>กรุณาเลือก</option>
                                            <?php
                                            $PROVINCE = "SELECT * FROM provincetb WHERE PROVINCE_ID !=0 ORDER BY PROVINCE_NAME ASC ";
                                            $PROVINCES = $conn->query($PROVINCE);
                                            foreach ($PROVINCES as $i) {
                                                echo '<option value="' . $i['PROVINCE_ID'] . '">' . $i['PROVINCE_NAME'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ชื่อ-นามสกุล ผู้อุปการะ</label>
                                        <input type="text" id="disabledTextInput" name="p_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">อาชีพ</label>
                                        <input type="text" id="disabledTextInput" name="p_career" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">รายได้ต่อเดือนเฉลี่ย</label>
                                        <input type="text" id="disabledTextInput" name="p_income" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">เบอร์โทรศัพท์</label>
                                        <input type="text" id="disabledTextInput" name="p_phone" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">มีความสัมพันธ์กับนักศึกษาคือ</label>
                                        <input type="text" id="disabledTextInput" name="p_relation" class="form-control">
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
                                    <h6 class="card-title m-4">ประวัติการรับทุนการศึกษา</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <h6 class="card-title ">กู้ยืมกองทุนเงินให้กู้ยืมเพื่อการศึกษา(กยศ.)หรือไม่</h6>
                                </div>
                            </div>
                            <div class="row m-2">
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-check ">
                                        <input class="form-check-input" type="radio" value="เคย" name="borrow" id="exampleRadios1" value="เคย">
                                        <label class="form-check-label" for="exampleRadios1">
                                            เคย
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="ไม่เคย" name="borrow" id="exampleRadios2" checked value="ไม่เคย">
                                        <label class="form-check-label" for="exampleRadios2">
                                            ไม่เคย
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="กำลัรอผลพิจารณา" name="borrow" id="exampleRadios3" value="กำลังรอผลพิจารณา">
                                        <label class="form-check-label" for="exampleRadios3">
                                            กำลังรอผลพิจารณา
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <h6 class="card-title ">ได้รับทุนการศึกษา</h6>
                                </div>
                            </div>
                            <div class="row m-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="เคย" type="radio" name="scholar" id="rdo1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        เคย (โปรดระบุทุนที่เคยได้รับ)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="ไม่เคย" type="radio" name="scholar" id="rdo2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        ไม่เคย
                                    </label>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-12 col-md-12 ">
                                    <div class="table-responsive-md ">
                                        <table id="tb" class="table  table-borderless tb-responsive">
                                            <thead class="table-light">
                                                <tr>
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
                                                    <td colspan="4">
                                                        เพิ่ม
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td colspan="4">
                                                    <input type="text" name="year_old_scholar[]" id="YOS" class="form-control">
                                                </td>
                                                <td colspan="4">
                                                    <input type="text" name="cate_old_scholar[]" id="COS" class="form-control">
                                                </td>
                                                <td colspan="4">
                                                    <input type="text" name="name_old_scholar[]" id="NOS" class="form-control">
                                                </td>
                                                <td colspan="4">
                                                    <input type="text" name="perpty_old_scholar[]" id="POS" class="form-control">
                                                </td>
                                                <td colspan="4">
                                                    <input type="text" name="value_old_scholar[]" id="VOS" class="form-control">
                                                </td>
                                                <td colspan="4">
                                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                        <button class="btn btn-primary" id="plus" type="button">+</button>
                                                    </div>
                                                </td>
                                            </tr>
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
                                    <h6 class="card-title m-4">ประสบการณ์ทำงาน</h6>
                                </div>
                            </div>
                            <div class="row m-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="เคย" name="work" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        เคย (โปรดระบุ)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="ไม่เคย" type="radio" name="work" id="flexRadioDefault2" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        ไม่เคย
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ทำงานนอกเวลาที่</label>
                                        <input type="text" id="disabledTextInput" name="tp_at" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ลักษณะงานที่ทำ</label>
                                        <input type="text" id="disabledTextInput" name="tp_cate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ระยะเวลาที่ทำงาน</label>
                                        <input type="text" id="disabledTextInput" name="tp_timeperriod" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">รายได้/วันละ</label>
                                        <input type="text" id="disabledTextInput" name="tp_income" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ทำงานเต็มเวลาที่</label>
                                        <input type="text" id="disabledTextInput" name="ft_at" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ลักษณะงานที่ทำ</label>
                                        <input type="text" id="disabledTextInput" name="ft_cate" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ระยะเวลาที่ทำงาน</label>
                                        <input type="text" id="disabledTextInput" name="ft_timeperiod" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">รายได้/วันละ</label>
                                        <input type="text" id="disabledTextInput" name="ft_income" class="form-control">
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
                                    <h6 class="card-title m-4">กิจกรรมจิตอาสา</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">ระยะเวลาที่ทำกิจกรรมจิตอาสา</label>
                                        <input type="text" id="disabledTextInput" name="aty_timeperiod" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">จำนวนชั่วโมงกิจกรรมจิตอาสา</label>
                                        <input type="text" id="disabledTextInput" name="aty_hour" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">บรรยายกิจกรรมจิตอาสา</label>
                                        <textarea class="form-control" name="aty_describe" id="exampleFormControlTextarea1" rows="3"></textarea>
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
                                    <h6 class="card-title m-4">ปัญหาและความจำเป็นที่จะต้องใช้ทุน</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="disabledTextInput" class="form-label label">บรรยายปัญหาและความจำเป็นที่จะต้องใช้ทุน</label>
                                        <textarea class="form-control" required name="stdy_describe" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <?php
                                        if ($_SESSION['ACTIVE'] == 1) {
                                            echo '<button type="submit" name="sub" class="btn btn-success done-btn">ส่งเรื่อง</button>';
                                        } else if ($_SESSION['ACTIVE'] == 0) {
                                            echo '<button type="submit" disabled class="btn btn-success done-btn">ส่งเรื่อง</button>';
                                        }
                                        ?>
                        </form>
                        <a type="button" href="index.php" class="btn btn-primary home-btn">กลับหน้าหลัก</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="footer">
                        <p class="text-footer">โปรดติดตามสถานะที่หน้าหลัก</p>
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
        $('#YOS').attr('readOnly', true)
        $('#COS').attr('readOnly', true)
        $('#NOS').attr('readOnly', true)
        $('#POS').attr('readOnly', true)
        $('#VOS').attr('readOnly', true)
        end = $('#time_end').val()
        start = $('#time_start').val()

        var i = 1;
        $('#plus').click(function() {
            i++;
            $('#tb').append('<tr id="row' + i + '"><td colspan="4"><input type="text" name="year_old_scholar[]" id="YOS" class="form-control"></td><td colspan="4"><input type="text" name="cate_old_scholar[]" id="COS" class="form-control"></td><td colspan="4"><input type="text" name="name_old_scholar[]" id="NOS" class="form-control"></td><td colspan="4"><input type="text" name="perpty_old_scholar[]" id="POS" class="form-control"></td><td colspan="4"><input type="text" name="value_old_scholar[]" id="VOS" class="form-control"></td><td colspan="4"><div class="btn-group" role="group" aria-label="Button group with nested dropdown"><button class="btn btn-danger btn-minus"  id="' + i + '" type="button">-</button></div></td></tr>');
        });

        $(document).on('click', '.btn-minus', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        $('#form').submit(function(e) {
            form = $(this).serialize()
            $.ajax({
                url: "form.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    if (res === "ลงทะเบียนสมัครรับทุนฯสำเร็จ") {
                        alert(res)
                        window.location.href = 'index.php'
                    } else {
                        alert(res)
                    }
                }
            })
            e.preventDefault()
        });

        $('#rdo1').change(function() {
            $('#YOS').attr('readOnly', false)
            $('#COS').attr('readOnly', false)
            $('#NOS').attr('readOnly', false)
            $('#POS').attr('readOnly', false)
            $('#VOS').attr('readOnly', false)
        })

        $('#rdo2').change(function() {
            $('#YOS').attr('readOnly', true)
            $('#COS').attr('readOnly', true)
            $('#NOS').attr('readOnly', true)
            $('#POS').attr('readOnly', true)
            $('#VOS').attr('readOnly', true)
        })


    });
</script>

</html>