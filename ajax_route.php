<?php 

// if(!isset($_SESSION['user'])) {
//     $login_dir = '/login.php';
// 	header("Location: $login_dir");
// 	exit();      
// }

require_once 'start.php';

$routeLis = [
	'autocomplete' 			=> ROOT.'/core/action/search/autocomplete.php',
	'getProductsById' 		=> ROOT.'/core/action/stock/get_products_by_id.php',
	'addToCart' 			=> ROOT.'/core/action/cart/cart_item_row.php',
	'checkout'				=> ROOT.'/core/action/cart/checkout.php',
];

$route = $_POST['route'];

require $routeLis[$route]; 