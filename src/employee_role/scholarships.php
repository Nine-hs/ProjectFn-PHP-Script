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
    <title>จัดการข้อมูลทุนฯ</title>
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
                    <a class="list-group-item list-group-item-action " href="users.php">จัดการข้อมูลผู้ใช้</a>
                    <a class="list-group-item list-group-item-action active" href="scholarships.php">จัดการข้อมูลทุนฯ</a>
                </div>
            </div>
            <div class="col-sm-12 col-md-10">
                <div class="tab-content" id="nav-tabContent">
                    <div class="card" id="list-profile">
                        <h6 class="card-header">รายการข้อมูลทุนฯประจำปีการศึกษา <span id="year"></span></h6>
                        <div class="card-body  table-responsive" style="height:600px; max-height:600px;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <button type="button" class="btn btn-success btn-sm btn_add_SCHO">เพิ่มข้อมูลทุนฯ</button>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ลำดับ</th>
                                                    <th scope="col">ชื่อทุน</th>
                                                    <th scope="col">จำนวน</th>
                                                    <th scope="col">มูลค่า</th>
                                                    <th scope="col">ให้ไปแล้ว</th>
                                                    <th scope="col" colspan="2">แก้ไข</th>
                                                </tr>
                                            </thead>
                                            <tbody id="scholars_show">

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
        <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form-update">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลทุนฯ: <span id="title-update"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ชื่อทุนฯ:</label>
                                            <input type="hidden" class="form-control" name="new-id" id="scholar-id">
                                            <input type="text" class="form-control" name="name" id="scholar-name">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">จำนวน:</label>
                                            <input type="text" class="form-control" name="amount" id="scholar-amount">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">มูลค่า:</label>
                                            <input type="text" class="form-control" name="value" id="scholar-value">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ให้ไปแล้วจำนวน: ทุน</label>
                                            <input type="text" readonly class="form-control" id="scholar-gived">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ให้ไปแล้วมูลค่า: บาท</label>
                                            <input type="text" readonly class="form-control" id="scholar-valued">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">จำนวนคงเหลือ:</label>
                                            <input type="text" class="form-control" name="curamount" id="scholar-curamount">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">มูลค่าคงเหลือ:</label>
                                            <input type="text" class="form-control" name="curvalue" id="scholar-curvalue">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span style="text-align: left; color:red;" id="alert"></span>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Modal_ADD_SCHO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formid">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลทุนฯ: <span id="title-update"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height:100%;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ชื่อทุนฯ:</label>
                                            <input type="hidden" class="form-control" name="Scholar-id" id="Scholar-id">
                                            <input type="text" class="form-control" name="nameScholar" required id="nameScholar">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">จำนวน:</label>
                                            <input type="text" class="form-control" name="amount_sholar" required id="amount_sholar">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">มูลค่า:</label>
                                            <input type="text" class="form-control" name="total_scholar" required id="total_scholar">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-subtitle mb-2 text-muted">รายชื่อผู้บริจาค</h6>
                                        <div class="table-responsive-md ">
                                            <table id="tb" class="table  table-borderless tb-responsive">
                                                <thead class="table-light">
                                                    <tr>
                                                        <td colspan="4">
                                                            ชื่อ -สกุล
                                                        </td>
                                                        <td colspan="4">
                                                            เบอร์ติดต่อ
                                                        </td>
                                                        <td colspan="4">
                                                            เพิ่ม
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <td colspan="4">
                                                        <input type="text" name="nameDonat[]" required id="YOS" class="form-control">
                                                    </td>
                                                    <td colspan="4">
                                                        <input type="text" name="phone[]" required id="COS" class="form-control">
                                                    </td>
                                                    <td colspan="4">
                                                        <button class="btn btn-success" id="btnplus" type="button">+</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span style="text-align: left; color:red;" id="alert"></span>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Modal_DETAIL_SCHO" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formid">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลทุนฯ: <span id="title-detail"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height:100%;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">ชื่อทุนฯ:</label>
                                            <p id="nameSCHO"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">จำนวน:</label>
                                            <p id="am_sholar"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label">มูลค่า:</label>
                                            <p id="tt_scholar"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        <h6 class="card-subtitle mb-2 text-muted">รายชื่อผู้บริจาค</h6>
                                        <div class="table-responsive-md ">
                                            <table id="tbl" class="table  table-borderless tb-responsive">
                                                <thead class="table-light">
                                                    <tr>
                                                        <td colspan="6">
                                                            ชื่อ -สกุล
                                                        </td>
                                                        <td colspan="6">
                                                            เบอร์ติดต่อ
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="giver_show">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <span style="text-align: left; color:red;" id="alert"></span>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
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