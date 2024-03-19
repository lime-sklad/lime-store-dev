<?php 

header('Content-type: Application/json');

$warehouse = new Core\Classes\Services\Warehouse\Warehouse;

if(empty($_POST['list'])) {
    return $utils::abort('Səbət boşdur');
    exit;
}


$list = $_POST['list'];

$warehouse->writeOff($list);

return $utils::abort([
    'text' => 'Əlavə edildi',
    'type' => 'success'
]);