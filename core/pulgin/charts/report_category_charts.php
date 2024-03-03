<?php

use Core\Classes\Utils\Charts;
use Core\Classes\Services\Category;
header('Content-Type: application/json');

$Charts = new Charts;
$category = new Category;

$date = $_POST['date'];

$data = $category->sumSalesByCategory($date);


$res = $Charts->getPieChartsData($data, 'category_name', 'total');

echo json_encode($res);