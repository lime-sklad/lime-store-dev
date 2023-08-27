<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');


$stock_id = $_POST['data'];


$res = ls_db_request([
        'table_name' => ' stock_barcode_list ',
        'col_list' => ' * ',
        'base_query' => ' WHERE br_stock_id = :id ',
        'param' => [
            'query' => [
                'param' => '',
                'joins' => '',
                'bindList' => array(
                    'id' => $stock_id
                )
            ],
            'sort_by' => 'ORDER BY barcode_id DESC'
        ]            
    ]);


// $total = $twig->render('/component/include_component.twig', [
// 	'renderComponent' => [
// 		'/component/modal/barcode/include_edit_barcode.twig' => [		
//             'res' => $res,
//             'stock_id' => $stock_id
// 		]  
// 	]
// ]);


$total = $twig->render('/component/include_component.twig', [
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




echo json_encode([
	'res' => $total,
]);
