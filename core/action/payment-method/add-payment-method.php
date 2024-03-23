<?php
header('Content-type: Application/json');

use Core\Classes\Utils\Utils;

$Payment = new Core\Classes\Cart\Payment;

if(empty($_POST) || empty($_POST['prepare_data']['create_payment_method_name'])  || empty($_POST['prepare_data']['create_payment_method_tags_id'])) {
    return Utils::abort([
        'type' => 'error',
        'text' => 'Empty'
    ]);
}


$row = $_POST['prepare_data'];
$title = $row['create_payment_method_name'];
$tags_key = $row['create_payment_method_tags_id'];

$Payment->addPaymentMethod($title, $tags_key);


$page = Utils::getPostPage();
$type = Utils::getPostType();

$config = $main->getControllerData($page)->allData;

$table_result = $main->prepareCustomData($Payment->getLastAddedPaymentMethod(), $config['page_data_list']);

$table = $Render->view('/component/include_component.twig', [
    'renderComponent' => [
        '/component/table/table_row.twig' => [		
            'table' => $table_result['result'],
        ]  
    ]
]);	

return Utils::abort([
    'type' => 'success',
    'text' => 'Ok',
    'table' => $table
]);