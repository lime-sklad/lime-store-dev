<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/function.php';

header('Content-Type: application/json');

$report =  new core\classes\dbWrapper\db;

$data = $report->select([
	'table_name' => 'stock_order_report',
	'col_list' => "  order_my_date as smonth , SUM(order_total_profit) AS total_profit ",
	'query' => [
		'base_query' => '',
		'param' => " WHERE order_my_date >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 10 MONTH), '%m.%Y')  AND stock_order_visible = 0 ",
		'sort_by' => '    GROUP BY order_my_date ORDER BY order_my_date'
	],
	'bindList' => [
	],
])->get();

$date_list = [];
$sum_list = [];

foreach ($data as $key => $val) {
	$date_list[] = $val['smonth'];
	$sum_list[] = $val['total_profit'];
}



echo json_encode([
    'date_list' => $date_list,
    'sum_list' => $sum_list
]);