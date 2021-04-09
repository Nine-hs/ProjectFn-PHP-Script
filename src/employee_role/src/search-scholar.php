<?php
require_once '../../../config/database/db.php';

$n = 1;
$year = date('Y');
$sqll = "SELECT SCHOLAR_ID,s.SCHOLAR_NAME as SCHOLAR_NAMES," .
    "s.SCOLAR_AMOUNTH as AMOUNT,s.SCHOLAR_VALUE as SCHOLAR_VALUES ,(SELECT COUNT(R_ID) FROM req_scholarship WHERE R_ID = SCHOLAR_ID) as gived " .
    "FROM scolartb s WHERE SCHOLAR_ID != 0 AND YEAR(s.scolar_date) = :YEARS";
$query_schoar = $conn->prepare($sqll);
$query_schoar->bindParam(':YEARS', $year, PDO::PARAM_STR);
$query_schoar->execute();
$row = $query_schoar->fetchAll(PDO::FETCH_ASSOC);
foreach ($row as $r) {
?>
    <tr>
        <td scope="row"><?php echo $n++; ?></td>
        <td><?php echo $r['SCHOLAR_NAMES']; ?></td>
        <td><?php echo $r['AMOUNT']; ?></td>
        <td><?php echo $r['SCHOLAR_VALUES']; ?></td>
        <td align="center"><?php echo $r['gived']; ?></td>
        <td colspan="2">
            <button type="button" id="<?php echo $r['SCHOLAR_ID']; ?>" class="btn btn-danger btn-sm btn-delete">ลบ</button>
            <button type="button" id="<?php echo $r['SCHOLAR_ID']; ?>" class="btn btn-warning btn-sm btn-update">แก้ไข</button>
            <button type="button" id="<?php echo $r['SCHOLAR_ID']; ?>" class="btn btn-primary btn-sm btn-detail-scho" attr1="<?php echo $r['SCHOLAR_NAMES']; ?>" attr2="<?php echo $r['AMOUNT']; ?>" attr3="<?php echo $r['SCHOLAR_VALUES']; ?>">รายละเอียด</button>
        </td>
    </tr>
<?php
}
?>
