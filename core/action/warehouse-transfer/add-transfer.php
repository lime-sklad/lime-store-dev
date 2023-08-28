<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');

if(empty($_POST) || empty($_POST['list'])) {
    return print_alert([
        'type' => 'error',
        'text' => 'Корзина пустая' 
    ]);
}

if(empty($_POST['warehouse_id'])) {
    return print_alert([
        'type' => 'error',
        'text' => 'Выберите анбар для трансфера' 
    ]); 
}


$warehouse_id = $_POST['warehouse_id'];
$list = $_POST['list'];


$check_warehouse = ls_db_request([
    'table_name' => 'warehouse_list',
    'col_list' => 'id',
    'base_query' => ' WHERE id = :id ',
    'param' => [
        'query' => [
            'bindList' => [
                ':id' => $warehouse_id
            ]
        ],
    ]
]);


if(empty($check_warehouse[0])) {
    return print_alert([
        'type' => 'error',
        'text' => 'ERROR 820828'
    ]);
}




foreach($list as $key => $row) {
    $count = $row['count'];
    $stock_id = $row['id'];
    $description = $row['description'];

}


$option = [
    'before' => ' UPDATE stock_list SET ',
    'after' => ' WHERE stock_id = :id ',
    'post_list' => [
        'id' => [
            'query' => false,
            'bind' => 'id'
        ],
        'count' => [
            'query' => ' stock_list.stock_count = stock_list.stock_count - :product_count ',
            'bind' => 'product_count'
        ]
    ]
];

foreach($list as $key => $row) {
    ls_db_upadte($option, $row);

    ls_db_insert('transfer_list', [
        [
            'warehouse_id' => $warehouse_id,
            'stock_id' => $row['id'],
            'count' => $row['count'],
            'description' => $row['description']
        ]
    ]);    
}




return print_alert([
    'type' => 'success',
    'text' => 'Ok'
]);