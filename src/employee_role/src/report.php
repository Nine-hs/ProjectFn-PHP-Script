<?php
define('FPDF_FONTPATH', '../css/fpdf/font/');
require('../css/fpdf/fpdf.php');
require_once '../../../config/database/db.php';

class PDF extends FPDF
{

    function HEAD($conn, $title)
    {
        $year = date('Y');
        $sql = "SELECT ev.start_event as DATE_START,ev.end_event as DATE_END FROM events ev WHERE ev.title LIKE CONCAT('%' ,:TITLE, '%') AND YEAR(ev.start_event) = :YEARS ";
        $query = $conn->prepare($sql);
        $query->execute([':TITLE' => $title, ':YEARS' => $year]);
        $row = $query->fetch();
        $this->Image('../css/logopage.png', 3, 3, 10);
        $this->AddFont('THSarabunNew', '', 'THSarabunNew_b.php');
        $this->SetFont('THSarabunNew', '', 14);
        $this->Cell(188, 5, iconv('UTF-8', 'TIS-620', 'รายชื่อนักศึกษาที่ได้รับทุน ประจำปีการศึกษา ' . (date('Y') + 543) . ''), 0, 0, 'C');
        $this->Ln();
        if (empty($row)) {
            $this->AddFont('THSarabunNew', '', 'THSarabunNew_b.php');
            $this->SetFont('THSarabunNew', '', 16);
            $this->Cell(188, 5, iconv('UTF-8', 'TIS-620', "ยังไม่มีกำหนดการ"), 0, 0, 'C');
            $this->Ln();
            $this->Line(9, 28, 201, 28);
            $this->Ln(12);
        } else {

            $dateArr = explode('-', $row['DATE_START']);
            $date = explode(' ', $dateArr[2]);
            $month = array(
                "", "มกราคม", "กุมภาพันธ์ ", "มีนาคม",
                "เมษายน", "พฤษภาคม", "มิถุนายน ", "กรกฎาคม", "สิงหาคม",
                "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            );
            unset($month[0]);
            $dateThai = $date[0] . ' ' . $month[$dateArr[1] - 1] . ' พ.ศ. ' . ($dateArr['0'] + 543);

            $dateArr2 = explode('-', $row['DATE_END']);
            $date2 = explode(' ', $dateArr2[2]);
            $month2 = array(
                "", "มกราคม", "กุมภาพันธ์ ", "มีนาคม",
                "เมษายน", "พฤษภาคม", "มิถุนายน ", "กรกฎาคม", "สิงหาคม",
                "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            );
            unset($month2[0]);
            $dateThai2 = $date2[0] . ' ' . $month2[$dateArr2[1] - 1] . ' พ.ศ. ' . ($dateArr2[0] + 543);

            $this->Cell(188, 15, iconv('UTF-8', 'TIS-620', 'ให้มาติดต่อห้องงานกองทุนฯ ตั้งแต่วันที่ ' . $dateThai . ' - ' . $dateThai2 . ''), 0, 0, 'C');
            $this->Ln();
            $this->Line(9, 28, 201, 28);
            $this->Ln(2);
        }
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->AddFont('THSarabunNew', '', 'THSarabunNew_b.php');
        $this->SetFont('THSarabunNew', '', 12);
        $this->SetTextColor(128);
        $this->Cell(0, 10, iconv('UTF-8', 'TIS-620', 'หน้าที่') . $this->PageNo(), 0, 0, 'C');
    }

    function HeaderTable()
    {
        $this->AddFont('THSarabunNew', '', 'THSarabunNew_b.php');
        $this->SetFont('THSarabunNew', '', 14);
        $this->Cell(10, 10, iconv('UTF-8', 'TIS-620', 'ลำดับ'), 1, 0, 'C');
        $this->Cell(65, 10, iconv('UTF-8', 'TIS-620', 'ชื่อ - สกุล'), 1, 0, 'C');
        $this->Cell(25, 10, iconv('UTF-8', 'TIS-620', 'ชั้นเรียน'), 1, 0, 'C');
        $this->Cell(40, 10, iconv('UTF-8', 'TIS-620', 'เบอร์ติดต่อ'), 1, 0, 'C');
        $this->Cell(20, 10, iconv('UTF-8', 'TIS-620', 'ลายเซ็น'), 1, 0, 'C');
        $this->Cell(30, 10, iconv('UTF-8', 'TIS-620', 'หมายเหตุ'), 1, 0, 'C');
        $this->Ln();
    }

    function Row($conn)
    {
        $n = 1;
        $this->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $this->SetFont('THSarabunNew', '', 12);
        $year = date('Y');
        $sql = "SELECT ST_NUMBER, CONCAT(f.F_NAME,'        ',f.L_NAME) as FULLNAME, CONCAT(m.M_MAJOR,' ',f.ST_GEN) as CLASS FROM" .
            " formtb f INNER JOIN majors m ON f.ST_MAJORS=m.ID_MAJOR WHERE YEAR(DATE_) = :YEAD AND REQ_STATUS != 0 AND" .
            " REQ_STATUS_DIRECTOR != 0 AND BY_ADMIN = 1  ORDER BY CONCAT(M_MAJOR,' ',ST_GEN) ASC";
        $query = $conn->prepare($sql);
        $query->execute([':YEAD' => $year]);
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $i) {
            $this->Cell(10, 7, iconv('UTF-8', 'TIS-620', $n++), 1, 0, 'C');
            $this->Cell(65, 7, iconv('UTF-8', 'TIS-620', $i['FULLNAME']), 1, 0, 'C');
            $this->Cell(25, 7, iconv('UTF-8', 'TIS-620', $i['CLASS']), 1, 0, 'C');
            $this->Cell(40, 7, iconv('UTF-8', 'TIS-620', ''), 1, 0, 'C');
            $this->Cell(20, 7, iconv('UTF-8', 'TIS-620', ''), 1, 0, 'C');
            $this->Cell(30, 7, iconv('UTF-8', 'TIS-620', ''), 1, 0, 'C');
            $this->Ln();
        }
    }
}

if (isset($_GET['title'])) {
    $title = $_GET['title'];
}
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->HEAD($conn, $title);
$pdf->HeaderTable();
$pdf->Row($conn);
$pdf->Output();
