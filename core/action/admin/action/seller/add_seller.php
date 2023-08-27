<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: application/json');

$seller_name = $_POST['seller_name'];
$seller_password = $_POST['seller_password'];

if(is_unique_user($seller_name)) {

	add_new_user([
		'seller_name' => $seller_name,
		'seller_password' => $seller_password,
		'seller_role'	=> 'seller'
	]);

	$page = $_POST['page'];
	$type = $_POST['type'];

	$this_data = page_data($page);

	$page_config = $this_data['page_data_list'];

	$this_data['sql']['param']['sort_by'] = " GROUP BY user_id DESC ORDER BY user_id DESC LIMIT 1";

	$table_result = render_data_template($this_data['sql'], $page_config);

	$table = $twig->render('/component/include_component.twig', [
		'renderComponent' => [
			'/component/table/table_row.twig' => [		
				'table' => $table_result['result'],
				'table_tab' => $page,
				'table_type' => $type
			]
		]
	]);	

	return print_alert([
		'alert_type' => 'success',
		'text' => 'Ok',
		'table' => $table,
	]);	

} else {
	return print_alert([
		'alert_type' => 'error',
		'text'	=> 'İstifadəçi artıq əlavə edilib'
	]);
}

