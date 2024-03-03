<?php 
header('Content-Type: application/json');

$Charts = new \Core\Classes\Utils\Charts;

$data = $Charts->getReportChartList();

echo json_encode($data);