<?php
session_start();
require_once '../../config/database/db.php';
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
            th {
                font-size: 12px;
            }

            .tb {
                width: 200%;
            }

            .btn {
                font-size: 12px;
                margin: 0 auto;
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
                        <small>ชื่อ: <?php echo $_SESSION['FirstName'] . '  ' . $_SESSION['LastName']; ?><br></small>
                        <small>สถานะ: <?php echo $_SESSION['STATUS']; ?></small>
                    </div>
                    <a class="list-group-item list-group-item-action " href="index.php" role="tab" aria-controls="home">หน้าหลัก</a>
                    <a class="list-group-item list-group-item-action" href="reportbydirector.php">ผลพิจารณาจากกรรมการ</a>
                    <a class="list-group-item list-group-item-action active" href="report.php">รายชื่อผู้ได้รับทุน</a>
                    <a class="list-group-item list-group-item-action " href="events.php">กำหนดปฏิทินกิจกรรม</a>
                    <a class="list-group-item list-group-item-action" href="users.php">จัดการข้อมูลผู้ใช้</a>
                    <a class="list-group-item list-group-item-action" href="scholarships.php">จัดการข้อมูลทุนฯ</a>
                </div>
            </div>
            <div class="col-sm-12 col-md-10">
                <div class="tab-content" id="nav-tabContent">
                    <div class="card table-responsive table-height" style="height: 600px;" id="list-profile">
                        <h6 class="card-header">รายชื่อผู้ได้รับทุนฯ ประจำปีการศึกษา <span id="year"></span></h6>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <a href="./src/report.php?title=ประกาศรายชื่อผู้ได้รับทุน" class="btn btn-primary m-2 btn" type="button">ประกาศรายชื่อผู้ที่ได้รับทุนฯ</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 table-responsive table-height">
                                        <table class="table table-striped tb">
                                            <thead>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>รหัสนักศึกษา</th>
                                                    <th>ชื่อ - นามสกุล</th>
                                                    <th>ชั้นปี</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                            </tbody>
                                        </table>
                                    </div><!-- /.col -->
                                </div </div>
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
        setInterval(function() {
            $('#tbody').load('./src/report-load.php')
        }, 3000)
    });
</script>
<script>
    const year = new Date().getFullYear() + 543;
    document.getElementById('year').textContent = year;
</script>

</html>