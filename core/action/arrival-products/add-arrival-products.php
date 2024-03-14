<?php header('Content-type: Application/json');

use Core\Classes\Services\Warehouse\Warehouse;
use Core\Classes\Utils\Utils;

$Warehouse = new Warehouse;

if(empty($_POST['list'])) {
    $utils::abort('Səbət boşdur'); exit;
}

$list = $_POST['list'];

$Warehouse->arrivalProducts($list);

echo Utils::abort([
    'text' => 'Əlavə edildi',
    'type' => 'success'
]);