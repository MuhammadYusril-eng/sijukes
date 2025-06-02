<?php
session_start();
require_once '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (!isset($_SESSION['rows_wrong']) || empty($_SESSION['rows_wrong'])) {
    echo "Tidak ada data error.";
    exit;
}

$rows_wrong = $_SESSION['rows_wrong'];
unset($_SESSION['rows_wrong']);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromArray($rows_wrong, NULL, 'A1');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="file_wrong.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

echo "window.location.href = 'formSiswa.php';";

exit;
