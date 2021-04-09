<?php
require_once '../../../config/database/db.php';

$n = 1;
$year = date('Y');
$sqll = "SELECT EM_ID, CONCAT(EM_NAME,' ',EM_LASTNAME) as fullname, EM_USERNAME, EM_PASSWORD, EM_DEPART,S_STATUS FROM employeetb" .
    " INNER JOIN statustb ON employeetb.EM_DEPART = statustb.STATUS_ID WHERE EM_ID != 0 ORDER BY S_STATUS ASC";
$query_schoar = $conn->query($sqll);
//$query_schoar->bindParam(':YEARS', $year, PDO::PARAM_STR);
$query_schoar->execute();
$row = $query_schoar->fetchAll(PDO::FETCH_ASSOC);
foreach ($row as $r) {
?>

    <tr>
        <th scope="row"><?php echo $n++; ?></th>
        <td><?php echo $r['fullname']; ?></td>
        <td><?php echo $r['EM_USERNAME']; ?></td>
        <td><?php echo $r['S_STATUS']; ?></td>
        <td>
            <button type="button" id="<?php echo $r['EM_ID']; ?>" class="btn btn-danger btn-sm btn-delete-user">ลบ</button>
            <button type="button" id="<?php echo $r['EM_ID']; ?>" class="btn btn-warning btn-sm btn-update-users">แก้ไข</button>
        </td>
    </tr>
<?php
}
?>