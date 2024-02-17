<?php

header('Content-Type: application/json');

use Core\Classes\Report;

$report = new Report;

$expense = new \Core\Classes\Services\Expenses;

if($_POST && $_POST['page']) {

	$page = $_POST['page'];
	$type = $_POST['type'];
	$date = $_POST['date'];
	$date_type = $_POST['date_types'];

	$data_page = $main->initController($page);

	// Utils::vardump($data_page);

	if ($date_type == 'date') {
		$data_page['sql']['query']['base_query'] = $data_page['sql']['query']['base_query']  . "  AND stock_order_report.order_my_date = :mydateyear";
	}

	if ($date_type == 'day') {
		$data_page['sql']['query']['base_query'] = $data_page['sql']['query']['base_query']  . "  AND stock_order_report.order_date = :mydateyear";
	}

	$data_page['sql']['bindList']['mydateyear'] = $date;
	$table_result = $main->prepareData($data_page['sql'], $data_page['page_data_list']);	

	$base_result = $table_result['base_result'];

	$res = $Render->view('/component/include_component.twig', [
		'renderComponent' => [
			'/component/pulgin/stats_card/stats_card_list.twig' => [
				'res' => $report->getStatsList($base_result, $data_page['page_data_list']['stats_card'], $expense->getExpensesByMonth($date))
			]
		]
	]);

	echo json_encode([
		'report_cards' => $res
	]);
}