<?php 
header('Content-Type: application/json');

$Charts = new \Core\Classes\Utils\Charts;

$data = $Charts->getReportChartList();
$profit = $Charts->getReportChartListProfit();

echo json_encode(['turnover' => $data, 'profit' => $profit]);