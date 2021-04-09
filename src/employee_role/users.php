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

if (isset($_POST['lname'])) {
    try {
        $emailDomain = $_POST['username'];
        $Domain = explode("@", $emailDomain);
        if ($Domain[1] === "rmutr.ac.th" || $Domain[1] === "outlook.rmutr.ac.th") {
            try {
                $pwd_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $push = "INSERT INTO employeetb(EM_NAME, EM_LASTNAME, EM_USERNAME, EM_PASSWORD,EM_DEPART)" .
                    " VALUES (:EM_NAME,:EM_LASTNAME,:EM_USERNAME,:EM_PASSWORD,:EM_DEPART)";
                $querypush = $conn->prepare($push);
                $querypush->bindParam(':EM_NAME', $_POST['fname'], PDO::PARAM_STR);
                $querypush->bindParam(':EM_LASTNAME', $_POST['lname'], PDO::PARAM_STR);
                $querypush->bindParam(':EM_USERNAME', $emailDomain, PDO::PARAM_STR);
                $querypush->bindParam(':EM_PASSWORD', $pwd_hashed, PDO::PARAM_STR);
                $querypush->bindParam(':EM_DEPART', $_POST['status'], PDO::PARAM_STR);
                if ($querypush->execute()) {
                    echo "<script>window.location.href = 'users.php'</script>";
                } else {
                    echo "<script>alert('ลงทะเบียนเข้าสู่ระบบไม่สำเร็จ')</script>";
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else if ($Domain[1] !== "rmutr.ac.th" || $Domain[1] !== "outlook.rmutr.ac.th") {
            echo "<script>alert('กรุณาใช้ Email ของทางมหาวิทยาลัย')</script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
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
    <style>
        * {
            font-family: 'Trirong', serif;
        }

        .logo-page {
            width: 45px;
            margin-left: 5%;
        }

        .nav-bar {
            background-color: #ECEFF1;
        }

        @media only screen and (max-width: 768px) {
            .table {
                width: 200%;
                font-size: 12px;
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
                    <a class="list-group-item list-group-item-action" href="index.php" role="tab" aria-controls="home">หน้าหลัก</a>
                    <a class="list-group-item list-group-item-action" href="reportbydirector.php">ผลพิจารณาจากกรรมการ</a>
                    <a class="list-group-item list-group-item-action" href="report.php">รายชื่อผู้ได้รับทุน</a>
                    <a class="list-group-item list-group-item-action" href="events.php">กำหนดปฏิทินกิจกรรม</a>
                    <a class="list-group-item list-group-item-action active" href="users.php">จัดการข้อมูลผู้ใช้</a>
                    <a class="list-group-item list-group-item-action" href="scholarships.php">จัดการข้อมูลทุนฯ</a>
                </div>
            </div>
            <div class="col-sm-12 col-md-10">
                <div class="tab-content" id="nav-tabContent">
                    <div class="card" id="list-profile">
                        <h6 class="card-header">รายชื่อผู้ใช้ระบบ</h6>
                        <div class="card-body  table-responsive" style="height:600px; max-height:600px;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <button type="button" class="btn btn-success btn-sm btn-add">เพิ่มข้อมูลผู้ใช้ระบบ</button>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">ชื่อ-นามสกุล</th>
                                                    <th scope="col">ชื่อผู้ใช้</th>
                                                    <th scope="col">สถานะ</th>
                                                    <th scope="col" colspan="2">แก้ไข</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_users">

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
        <div class="modal fade" id="Modals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form-update-user">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลผู้ใช้: <span id="title-update"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ชื่อ:</label>
                                            <input type="hidden" class="form-control" name="e_user_id" id="e_user_id">
                                            <input type="text" class="form-control" name="e_fname" id="e_fname">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">นามสกุล:</label>
                                            <input type="text" class="form-control" name="e_lname" id="e_lname">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ชื่อผู้ใช้:</label>
                                            <input type="text" class="form-control" name="e_username" id="e_username">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">สถานะ:</label>
                                            <select class="form-select" name="e_status" id="e_status">
                                                <?php
                                                $st = "SELECT * FROM statustb WHERE STATUS_ID != 4";
                                                $queryst = $conn->query($st);
                                                $queryst->execute();
                                                $row = $queryst->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($row as $i) {
                                                    echo '<option value="' . $i['STATUS_ID'] . '">' . $i['S_STATUS'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span style="text-align: left; color:red;" id="alert"></span>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <input type="submit" class="btn btn-primary" name="btnedit" value="บันทึก" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Modal_Add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="users.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลผู้ใช้: <span id="title-update"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ชื่อ:</label>
                                            <input type="hidden" class="form-control" name="user_id" id="user_id">
                                            <input type="text" class="form-control" required name="fname" id="fname">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">นามสกุล:</label>
                                            <input type="text" class="form-control" required name="lname" id="lname">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ชื่อผู้ใช้:</label>
                                            <input type="text" class="form-control" required name="username" id="username">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">รหัสผ่าน:</label>
                                            <input type="text" class="form-control" required name="password" id="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">สถานะ:</label>
                                            <select class="form-select" name="status" required id="status">
                                                <?php
                                                $st = "SELECT * FROM statustb WHERE STATUS_ID != 4";
                                                $queryst = $conn->query($st);
                                                $queryst->execute();
                                                $row = $queryst->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($row as $i) {
                                                    echo '<option value="' . $i['STATUS_ID'] . '">' . $i['S_STATUS'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span style="text-align: left; color:red;" id="alert"></span>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary btn-save-add-user">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</body>
<script src="../../asset/js/bootstrap.min.js"></script>
<script src="../../asset/js/jquery-3.2.1.min.js"></script>
<script src="./js/add-scholars.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>
<script>
    const year = new Date().getFullYear() + 543;
    document.getElementById('year').textContent = year;
</script>

</html>