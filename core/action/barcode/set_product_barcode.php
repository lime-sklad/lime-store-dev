<?php

use Core\Classes\System\Utils;

header('Content-type: Application/json');

$stock_id = $_POST['productId'];

$products->editBarcodeValue($_POST['edited_barcode']);


exit;

$products->resetProductBarcode($stock_id);

if(!empty($_POST['update_barcode_list'])) {
    $barcodeList = $_POST['update_barcode_list'];
    $products->setProductBarcode($barcodeList, $stock_id);
}

$utils::abort([
    'type' => 'success',
    'text' => 'Ok'
]);

