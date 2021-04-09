<?php
require('../../../config/database/db.php');
$rows = array();
$year = date('Y');
$n = 1;
if (isset($_POST['search'])) {
    $sq = "SELECT R_SCHOLAR_ID,s.SCHOLAR_NAME as scholar_name,rq.R_AMOUNT as amount,rq.R_VALUE as values_scholar" .
        ",CONCAT(DATE_FORMAT(rq.DATE_GIVE,'%d / %m / '),'',YEAR(rq.DATE_GIVE)+543) as whenAdd,CONCAT(f.F_NAME,' ',f.L_NAME) student," .
        " CONCAT(m.M_MAJOR,' ',f.ST_GEN) as MAJOR FROM req_scholarship rq INNER JOIN scolartb s ON rq.R_ID=s.SCHOLAR_ID INNER JOIN formtb f ON rq.FROM_ID=f.FORM_ID" .
        " INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR WHERE rq.R_SCHOLAR_ID != 0 AND YEAR(rq.DATE_GIVE) = :YEARS AND s.SCHOLAR_NAME LIKE CONCAT('%',:SEARCH_SCHOLAR,'%')" .
        "OR f.F_NAME LIKE CONCAT('%',:SEARCH,'%') OR f.FORM_ID LIKE CONCAT('%',:SEARCH,'%')";
    $querystudent = $conn->prepare($sq);
    $querystudent->bindParam(':YEARS', $year, PDO::PARAM_STR);
    $querystudent->bindParam(':SEARCH_SCHOLAR', $_POST['search'], PDO::PARAM_STR);
    $querystudent->bindParam(':SEARCH', $_POST['search'], PDO::PARAM_STR);
    $querystudent->execute();
    $rows = $querystudent->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $i) {
?>
        <tr id="row-<?php echo $i['R_SCHOLAR_ID']; ?>">
            <th scope="col"><?php echo $n++; ?></th>
            <td scope="col"><?php echo $i['scholar_name']; ?></td>
            <td scope="col"><?php echo $i['amount']; ?></td>
            <td scope="col"><?php echo $i['values_scholar']; ?></td>
            <td scope="col"><?php echo $i['student']; ?></td>
            <td scope="col"><?php echo $i['MAJOR']; ?></td>
            <td scope="col"><?php echo $i['whenAdd']; ?></td>
            <td scope="col">
                <button type="button" class="btn btn-primary btn-sm btn-edit">แก้ไข</button>
                <button type="button" id="<?php echo $i['R_SCHOLAR_ID']; ?>" class="btn btn-danger btn-sm ">ลบ</button>
            </td>
        </tr>
<?php
    }
} else {
    echo "<tr><td colspan='6'><h5 align='center'>ไม่พบข้อมูล</h5></td></tr>";
}
?>