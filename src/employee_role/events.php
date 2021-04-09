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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/fullcalendar.min.css" />
    <link rel="stylesheet" href="../../asset/font/Trirong.css">
    <link rel="stylesheet" href="./css/employee.css">
    <title>Document</title>
</head>

<body>
    <?php
    require('./css/component/header.php');
    $title = "เปิดรับสมัครรับทุนฯ";
    $sql = "SELECT id,title, By_status, start_event, end_event,active  FROM events WHERE title LIKE CONCAT('%',:TITLE,'%')" .
        " AND YEAR(start_event) = :YEARS";
    $query = $conn->prepare($sql);
    $query->execute(['TITLE' => $title, 'YEARS' => date('Y')]);
    $row = $query->fetch(PDO::FETCH_ASSOC);
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
                    <a class="list-group-item list-group-item-action" href="report.php">รายชื่อผู้ได้รับทุน</a>
                    <a class="list-group-item list-group-item-action active" href="events.php">กำหนดปฏิทินกิจกรรม</a>
                    <a class="list-group-item list-group-item-action" href="users.php">จัดการข้อมูลผู้ใช้</a>
                    <a class="list-group-item list-group-item-action" href="scholarships.php">จัดการข้อมูลทุนฯ</a>
                </div>
            </div>
            <div class="col-sm-12 col-md-10">
                <div class="tab-content" id="nav-tabContent">
                    <div class="card" id="list-profile">
                        <h6 class="card-header">ปฏิทินกิจกรรมประจำปีการศึกษา <span id="year"></span></h6>
                        <div class="form-check form-switch" style="display:flex; justify-content:flex-end; margin-right:85px;">
                            <?php
                            if (empty($row['id'])) {
                                echo '<a href="events.php?sw=1&id=' . $row['id'] . '"  class="btn btn-secondary btn-sm" style="pointer-events: none;">เปิดลงทะเบียนรับทุนฯ</a>';
                            } else {
                                if ($row['active'] == 0) {
                                    echo '<a href="events.php?sw=1&id=' . $row['id'] . '" class="btn btn-secondary btn-sm">เปิดลงทะเบียนรับทุนฯ</a>';
                                } else {
                                    echo '<a href="events.php?sw=0&id=' . $row['id'] . '" class="btn btn-success btn-sm">ปิดลงทะเบียนรับทุนฯ</a>';
                                }
                            }

                            ?>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div id="calendar" style="max-width: 900px; margin: 0 auto;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">กิจกรรมใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="events.php" method="POST">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="disabledSelect" class="form-label">ระบุกิจกรรม</label>
                                        <select id="acty" name="acty" class="form-select">
                                            <option value="-">-</option>
                                            <option value="เปิดรับสมัครรับทุนฯ">เปิดรับสมัครรับทุนฯ</option>
                                            <option value="อาจารย์ที่ปรึกษาสัมภาษณ์นักศึกษา">อาจารย์ที่ปรึกษาสัมภาษณ์นักศึกษา</option>
                                            <option value="กรรมการสัมภาษณ์นักศึกษา">กรรมการสัมภาษณ์นักศึกษา</option>
                                            <option value="ประกาศรายชื่อผู้ได้รับทุน">ประกาศรายชื่อผู้ได้รับทุน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">กิจกรรมอื่นๆ:</label>
                                        <input type="text" name="acty" class="form-control form-control-sm" id="other">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="Check1">
                                        <label class="form-check-label" for="exampleCheck1">คลิ๊กเพื่อกรอกกิจกรรมอื่นๆ</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="mb-3">
                                        <label for="disabledSelect" class="form-label">ระบุถึง</label>
                                        <select id="" name="tostatus" class="form-select">
                                            <?php
                                            $sql = "SELECT STATUS_ID, S_STATUS FROM statustb";
                                            $query = $conn->query($sql);
                                            $query->execute();
                                            $rows = $query->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($rows as $i) {
                                                echo '<option value="' . $i['S_STATUS'] . '">' . $i['S_STATUS'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">ตั้งแต่วันที่:</label>
                                        <input type="text" readonly class="form-control" id="show-start-date">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">ถึงวันที่:</label>
                                        <input type="text" readonly class="form-control" id="show-end-date">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <input type="text" hidden readonly class="form-control" name="startDate" id="start-date">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="mb-3">
                                        <input type="text" hidden readonly class="form-control" name="endDate" id="end-date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="../../asset/js/bootstrap.min.js"></script>
<script src="./js/jquery-3.2.1.min.js"></script>
<script src="./js/moment.min.js"></script>
<script src="./js/fullcalendar.min.js"></script>
<script src="./js/fullcalendar.js"></script>
<script src="./js/th.js"></script>
<script src="./js/script-events.js"></script>
<script src="../../asset/js/785b7d6451.js"></script>
<script>
    const year = new Date().getFullYear() + 543;
    document.getElementById('year').textContent = year;
</script>

</html>

<?php
if (isset($_POST["acty"])) {

    $query = "
            INSERT INTO events 
            (title,	By_status, start_event, end_event) 
            VALUES (:title, :By_status, :start_event, :end_event)
            ";
    $statement = $conn->prepare($query);
    $insert = $statement->execute(
        array(
            ':title'  => $_POST['acty'],
            ':By_status' => $_POST['tostatus'],
            ':start_event' => $_POST['startDate'],
            ':end_event' => $_POST['endDate']
        )
    );
    if ($insert) {
        echo "<script> window.location.href = 'events.php'</script>";
        exit;
    }
}

if (isset($_GET['id'])) {
    try {
        if ($_GET['sw'] == 1) {
            $sql = "UPDATE events SET active = :SW WHERE id = :ID";
            $query = $conn->prepare($sql);
            $query->bindParam(':SW', $_GET['sw'], PDO::PARAM_STR);
            $query->bindParam(':ID', $_GET['id'], PDO::PARAM_STR);
            if ($query->execute()) {
                echo "<script>alert('เปิดสมัครรับทุนฯสำเร็จ'); window.location.href = 'events.php'</script>";
            } else {
                echo "<script>alert('โปรดตรวจสอบว่าได้ทำการสร้างกิจกรรมสมัครรับทุนฯแล้วหรือไม่'); window.location.href = 'events.php'</script>";
            }
        } else if ($_GET['sw'] == 0) {
            $sql = "UPDATE events SET active = :SW WHERE id = :ID";
            $query = $conn->prepare($sql);
            $query->bindParam(':SW', $_GET['sw'], PDO::PARAM_STR);
            $query->bindParam(':ID', $_GET['id'], PDO::PARAM_STR);
            if ($query->execute()) {
                echo "<script>alert('ปิดสมัครรับทุนฯสำเร็จ'); window.location.href = 'events.php'</script>";
            } else {
                echo "<script>alert('โปรดตรวจสอบว่าได้ทำการสร้างกิจกรรมสมัครรับทุนฯแล้วหรือไม่'); window.location.href = 'events.php'</script>";
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>