<?php
header('Content-type: Application/json');

use Core\Classes\Services\Warehouse\Warehouse;
use Core\Classes\Utils\Utils;

$warehouse = new Warehouse;

$table = '';

if(!empty($_POST) && !empty($_POST['data_row'])) {
    if(!empty($_POST['data_row']['warehouse_name'])) {

		$warehouse->addWarehouse($_POST['data_row']);

		$page = Utils::getPostPage();
		$type = Utils::getPostType();

		$config = $main->getControllerData($page)->allData;

		$table_result = $main->prepareCustomData($warehouse->getLastAddedWarehouse(), $config['page_data_list']);

		$table = $Render->view('/component/include_component.twig', [
			'renderComponent' => [
				'/component/table/table_row.twig' => [		
					'table' => $table_result['result'],
					'table_tab' => $page,
					'table_type' => $type
				]  
			]
		]);	        
    }
} else {
	return Utils::abort([
		'type' => 'error',
		'text' => 'Заполните все поля'
	]);
}



return Utils::abort([
    'type' => 'success',
    'text' => 'ok',
    'table' => $table
]);