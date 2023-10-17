<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/function.php';

header('Content-type: Application/json');


if(empty($_POST) || empty($_POST['prepare_data']['create_payment_method_name'])  || empty($_POST['prepare_data']['create_payment_method_tags_id'])) {
    return print_alert([
        'type' => 'error',
        'text' => 'Empty'
    ]);
}


$row = $_POST['prepare_data'];

$title = $row['create_payment_method_name'];
$tags_key = $row['create_payment_method_tags_id'];


 ls_db_insert('payment_method_list', [
    [
        'title' => $title,
        'tags_id' => $tags_key
    ]
]);



$page = $_POST['page'];
$type = $_POST['type'];
$this_data = page_data($page);
$page_config = $this_data['page_data_list'];

$this_data['sql']['param']['sort_by'] = " GROUP BY payment_method_list.id DESC ORDER BY payment_method_list.id DESC LIMIT 1";

$table_result = render_data_template($this_data['sql'], $page_config);

$table = $twig->render('/component/include_component.twig', [
    'renderComponent' => [
        '/component/table/table_row.twig' => [		
            'table' => $table_result['result'],
        ]  
    ]
]);	

return print_alert([
    'type' => 'success',
    'text' => 'Ok',
    'table' => $table
]);