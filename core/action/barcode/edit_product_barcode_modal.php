<?php

header('Content-type: Application/json');


$stock_id = $_POST['data'];


$res = $products->getProductBarcodeList($stock_id);


// $total = $twig->render('/component/include_component.twig', [
// 	'renderComponent' => [
// 		'/component/modal/barcode/include_edit_barcode.twig' => [		
//             'res' => $res,
//             'stock_id' => $stock_id
// 		]  
// 	]
// ]);


$total = $Render->view('/component/include_component.twig', [
	'renderComponent' => [
		'/component/modal/custom_modal/u_modal.twig' => [
            'title' => 'Redaktə et',
            'path' => '/component/modal/barcode/edit_barcode_wrapper.twig',		
            'res' => $res,
            'class_list' => '',
            'stock_id' => $stock_id
             
		]  
	]
]);


 $utils::abort([
	'res' => $total,
]);
