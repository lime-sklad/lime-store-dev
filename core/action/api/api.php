<?php
include $_SERVER['DOCUMENT_ROOT'].'/start.php';

use Core\Classes\Report;
use Core\Classes\Utils\Utils;

$report = new Report;

$result = array();

if(isset($_GET['getMonthReport'])) {
    $date = $_GET['getMonthReport'] ?? null;
    
    $result = $report->getReportByMonth($date);

    $result = $result['base_result'];
}


if(isset($_GET['getDayReport'])) {
    $date = $_GET['getDayReport'] ?? null;

    $result = $report->getReportByDay($date);

    $result = $result['base_result'];
}

echo json_encode($result);