<?php header('Content-type: application/json');

$seller_name = $_POST['seller_name'];
$seller_password = $_POST['seller_password'];

if($user->isUsernameAvailable($seller_name)) {
	$user->addUser([
		'seller_name' => $seller_name,
		'seller_password' => $seller_password,
		'seller_role'	=> 'seller'
	]);

	$page = $_POST['page'];
	$type = $_POST['type'];

	$this_data = $main->initController($page);

	$page_config = $this_data['page_data_list'];

	$table_result = $main->prepareCustomData($user->getLastAddedUser(), $page_config);

	$table = $Render->view('/component/include_component.twig', [
		'renderComponent' => [
			'/component/table/table_row.twig' => [		
				'table' => $table_result['result'],
				'table_tab' => $page,
				'table_type' => $type
			]
		]
	]);	

	return $utils::abort([
		'alert_type' => 'success',
		'text' => 'Ok',
		'table' => $table,
	]);	

} else {
	return $utils::abort([
		'alert_type' => 'error',
		'text'	=> 'İstifadəçi artıq əlavə edilib'
	]);
}

