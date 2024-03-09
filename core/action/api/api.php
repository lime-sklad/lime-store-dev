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


if(isset($_GET['getDateListByMonth'])) {
    $result = $main->getReportDateList([
        'table_name' 	=> 'stock_order_report',
        'col_name' 		=> 'order_my_date',
        'order'			=> 'order_real_time DESC',
        'query'			=> ' WHERE order_stock_count > 0 AND stock_order_visible = 0 ',
        'default'		=> date('m.Y')
    ]);
}


if(isset($_GET['getDateListByDay'])) {
    $result = $main->getReportDateList([
        'table_name' 	=> 'stock_order_report',
        'col_name' 		=> 'order_date',
        'order'			=> 'order_real_time DESC',
        'query'			=> ' WHERE order_stock_count > 0 AND stock_order_visible = 0 ',
        'default'		=> date('d.m.Y')
    ]);
}


if(isset($_GET['getTopSellingProductsOfMonth'])) {
    $date = $_GET['getTopSellingProductsOfMonth'] ?? null;

    $result = $report->getTopSellingProductsOfMonth($date);
}

if(isset($_GET['getProductsList'])) {
    $limit = $_GET['limit'] ?? '50';

    $getConfig = $main->getControllerData('stock')->allData;

    $getConfig['sql']['query']['limit'] = " limit :limit ";
    
    $getConfig['sql']['bindList'] = [
        'limit' => $limit
    ];
    
    $data = $main->prepareData($getConfig['sql'], $getConfig['page_data_list'], \PDO::FETCH_ASSOC);
    
    $result = $data['base_result'];
    
}

Utils::log($result);

echo json_encode($result);