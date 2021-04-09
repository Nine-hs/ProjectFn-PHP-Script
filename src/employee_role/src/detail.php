<?php
require_once '../../../config/database/db.php';

if (isset($_POST['find_detail_scho'])) {
    $year = date('Y');
    try {
        $find = "SELECT GIVER_NAME, GIVER_PHONE FROM givertb WHERE SCHOLAR_ID =:ID AND YEAR(DATE_ADD) = :YEARS";
        $queryFind = $conn->prepare($find);
        $queryFind->bindParam(':ID', $_POST['find_detail_scho'], PDO::PARAM_STR);
        $queryFind->bindParam(':YEARS', $year, PDO::PARAM_STR);
        $queryFind->execute();
        $fetch = $queryFind->fetchAll(PDO::FETCH_ASSOC);
        foreach ($fetch as $t) {
            echo '<tr>';
            echo '<td colspan="6">' . $t['GIVER_NAME'] . '</td>';
            echo '<td colspan="6">' . $t['GIVER_PHONE'] . '</td>';
            echo '</tr>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
