<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

// autocmplt-type
if(!isset($_POST['type'], $_POST['page'])) {
	echo 'error';
	exit();
}

$page = $_POST['page'];
$type = $_POST['type'];

$start = $_POST['start'];
$limit = $_POST['limit'];

$data_page = page_data($page);

$page_config = $data_page['page_data_list'];



$data_page['sql']['param']['limit'] = " LIMIT $start, $limit ";

$table_result = render_data_template($data_page['sql'], $data_page['page_data_list']);


$table = $twig->render('/component/include_component.twig', [
    'renderComponent' => [
        '/component/table/table_row.twig' => [
            'table' => $table_result['result'],
            'table_tab' => $page,
            'table_type' => $type       
        ]
    ]
]);


$rs = $start + $limit;

if(!empty($table_result['base_result'])){
    echo json_encode([
        'table' => $table,
        'next_offset' => $rs 
    ]);
} else {
    echo json_encode([
        'empty' => 'no result' 
    ]); 
}


