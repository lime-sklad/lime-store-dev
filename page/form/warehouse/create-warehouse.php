<?php
$data_page = $main->initController($page);

$page_config = $data_page['page_data_list'];

$table_result = $main->prepareData($data_page['sql'], $data_page['page_data_list']);	

echo $Render->view('/component/inner_container.twig', [
	'renderComponent' => [
        '/component/form/fields/warehouse/create-warehouse.twig' => [
        ],		
		'/component/table/table_wrapper.twig' => [
			'table' => $table_result['result'],
			'table_tab' => $page,
			'table_type' => $type,
		],
	]
]);