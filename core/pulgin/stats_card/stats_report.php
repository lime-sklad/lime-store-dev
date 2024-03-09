<?php
header('Content-Type: application/json');


$report = new \Core\Classes\Report;

$expense = new \Core\Classes\Services\Expenses;

if($_POST && $_POST['page']) {

	$page = $_POST['page'];
	$type = $_POST['type'];
	$date = $_POST['date'];
	$date_type = $_POST['date_types'];
	$get_expense = 0;

	$data_page = $main->initController($page);

	// Utils::vardump($data_page);

	if ($date_type == 'date') {
		$data_page['sql']['query']['base_query'] = $data_page['sql']['query']['base_query']  . "  AND stock_order_report.order_my_date = :mydateyear";
		$get_expense = $expense->getSumExpensesByMonth($date);
	}

	if ($date_type == 'day') {
		$data_page['sql']['query']['base_query'] = $data_page['sql']['query']['base_query']  . "  AND stock_order_report.order_date = :mydateyear";
		$get_expense = $expense->getSumExpensesByDay($date);
	}

	$data_page['sql']['bindList']['mydateyear'] = $date;
	$table_result = $main->prepareData($data_page['sql'], $data_page['page_data_list']);	

	$base_result = $table_result['base_result'];

	$res = $Render->view('/component/include_component.twig', [
		'renderComponent' => [
			'/component/pulgin/stats_card/stats_card_list.twig' => [
				'res' => $report->getStatsList($base_result, $data_page['page_data_list']['stats_card'], $get_expense)
			]
		]
	]);

	echo json_encode([
		'report_cards' => $res
	]);
}