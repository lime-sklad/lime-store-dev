<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';


header('Content-type: Application/json');


if(empty($_POST) || empty($_POST['filter_title']) || empty($_POST['filter_option'])) {

    echo json_encode([
        'alert_type' => 'error',
        'text' => 'Заполните все поля'
    ]);

}

create_new_filter(['title' => $_POST['filter_title'] ], $_POST['filter_option']);

$page = $_POST['page'];
$this_data = page_data($page);
$page_config = $this_data['page_data_list'];

$this_data['sql']['param']['limit'] = " LIMIT 1 ";

$table_result = render_data_template($this_data['sql'], $page_config);

$table = $twig->render('/component/include_component.twig', [
    'renderComponent' => [
        '/component/table/table_row.twig' => [		
            'table' => $table_result['result'],
            'table_tab' => $page,
        ]  
    ]
]);	


echo json_encode([
    'alert_type' => 'success',
    'text' => 'OK',
    'table' => $table
]);
