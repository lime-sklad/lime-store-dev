<?php 

include $_SERVER['DOCUMENT_ROOT'] . '/function.php';

header('Content-type: Application/json');

if(empty($_POST['list'])) {
    return alert_error('Səbət boşdur');
    exit;
}



$list = $_POST['list'];

$transaction_id = ls_generate_transaction_id();

foreach($list as $key => $row) {
    $id = $row['id'];
    $count = $row['count'];

    stock_arrivals_count($id, $count);

    add_arrivals_report($row, $transaction_id);
}

return print_alert([
    'text' => 'Əlavə edildi',
    'type' => 'success'
]);