<?php

use Core\Classes\Utils\Charts;
use Core\Classes\Services\Provider;
header('Content-Type: application/json');

$Charts = new Charts;
$Provider = new Provider;

$date = '01.2024';

$data = $Provider->sumSalesByProvider($date);


$res = $Charts->getPieChartsData($data, 'provider_name', 'total');

echo json_encode($res);