<?php

use Core\Classes\Services\Warehouse\Warehouse;

header('Content-type: Application/json');

$warehouse = new Warehouse;

$id = $_POST['id'];

return $warehouse->deleteWarehouse($id);