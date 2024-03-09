<?php

use Core\Classes\Utils\Charts;
use Core\Classes\Report;

header('Content-Type: application/json');

$Charts = new Charts;
$Report = new Report;

$date = $_POST['date'];

$data = $Report->getTopSellingProductsOfMonth($date);


$res = $Charts->getPieChartsData($data, 'order_stock_name', 'total_profit');

echo json_encode($res);