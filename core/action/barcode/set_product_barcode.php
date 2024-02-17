<?php
header('Content-type: Application/json');

$result = [
    'type' => 'success',
    'text' => 'Saved'
];

$stock_id = $_POST['productId'];

if(!empty($_POST['edited_barcode_list'])) {
    $products->editBarcodeValue($_POST['edited_barcode_list']);
}

if(!empty($_POST['new_barcode_list'])) {
    $newBarcodeList = $_POST['new_barcode_list'];
    
    $products->setProductBarcode($newBarcodeList, $stock_id);
    
    $result['newAddedBarcode'] = $products->getBarcodeInfo($newBarcodeList);
}

if(!empty($_POST['removed_barcode_list'])) {
    $products->removeProductBarcode($_POST['removed_barcode_list']);
}

$utils::abort($result);