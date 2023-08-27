<?php 
require_once  $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');
$table = '';


if(!empty($_POST) && !empty($_POST['data_row'])) {
    if(!empty($_POST['data_row']['warehouse_name'])) {
     ls_db_insert('warehouse_list', [
            [
                'warehouse_name' => $_POST['data_row']['warehouse_name'],
                'warehouse_contact' => $_POST['data_row']['warehouse_contact']
            ]
        ]);

		$page = $_POST['page'];
		$type = $_POST['type'];

		$this_data = page_data($page);
		$page_config = $this_data['page_data_list'];

		$this_data['sql']['param']['sort_by'] = " GROUP BY id DESC ORDER BY id DESC LIMIT 1";

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

    }
} else {
	return print_alert([
		'alert_type' => 'error',
		'text' => 'Заполните все поля'
	]);
}



return print_alert([
    'alert_type' => 'success',
    'text' => 'ok',
    'table' => $table
]);