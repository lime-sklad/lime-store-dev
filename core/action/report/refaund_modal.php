<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');


$res = [];

$total = $twig->render('/component/include_component.twig', [
	'renderComponent' => [
		'/component/modal/custom_modal/u_modal.twig' => [
            'title' => 'Redaktə et',
            'path' => '/component/modal/refaund/refaund_modal.twig',		
            'res' => $res,
            'class_list' => '',
            'stock_id' => ''
             
		]  
	]
]);




echo json_encode([
	'res' => $total,
]);
