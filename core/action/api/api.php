<?php
include $_SERVER['DOCUMENT_ROOT'].'/start.php';

$controllerData = $main->getControllerData('report');

$data_page = $controllerData->allData;

$page_config = $data_page['page_data_list'];

$report = new \Core\Classes\Report;
$expenses = new \Core\Classes\Services\Expenses;

$data_page['sql']['query']['body'] = $data_page['sql']['query']['body']  . "  AND stock_order_report.order_my_date = :mydateyear";
$data_page['sql']['bindList']['mydateyear'] = date('m.Y');

$table_result = $main->prepareData($data_page['sql'], $data_page['page_data_list']);


$table_result = $table_result['base_result'];

echo json_encode($table_result);