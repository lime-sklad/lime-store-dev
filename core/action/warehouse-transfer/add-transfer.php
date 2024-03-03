<?php header('Content-type: Application/json');

$Warehouse = new Core\Classes\Services\Warehouse;

if(empty($_POST) || empty($_POST['list'])) {
   return $utils::abort([
        'type' => 'error',
        'text' => 'Корзина пустая' 
    ]);
}

if(empty($_POST['warehouse_id'])) {
   return $utils::abort([
        'type' => 'error',
        'text' => 'Выберите анбар для трансфера' 
    ]); 
}

$warehouse_id = $_POST['warehouse_id'];

$list = $_POST['list'];

if($Warehouse->hasWarehouse($warehouse_id) == false) {
    return $utils::abort([
        'type' => 'error',
        'text' => 'ERROR 820828'
    ]);
}

$Warehouse->addTransfer($list, $warehouse_id);

return $utils::abort([
    'type' => 'success',
    'text' => 'Ok'
]);

