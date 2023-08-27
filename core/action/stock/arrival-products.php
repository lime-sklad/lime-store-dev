<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');


$stock_id = $_POST['data'];


$total = $twig->render('/component/include_component.twig', [
	'renderComponent' => [
		'/component/modal/custom_modal/u_modal.twig' => [
            'title' => 'Hello world',
            'path' => '/component/modal/products/arrival-products.twig'
		]  
	]
]);


echo json_encode([
	'res' => $total,
]);
