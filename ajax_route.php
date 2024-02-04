<?php 

// if(!isset($_SESSION['user'])) {
//     $login_dir = '/login.php';
// 	header("Location: $login_dir");
// 	exit();      
// }

require_once 'start.php';

$routeLis = [
	'getProductsById' 		=> ROOT.'/core/action/stock/get_products_by_id.php',
	'filtredProducts'		=> ROOT.'/core/action/stock/get_filter_stock.php',
	'deleteProducts'		=> ROOT.'/core/action/stock/delete_products.php',
	'editProductBarcodeModal' => ROOT.'/core/action/barcode/edit_product_barcode_modal.php',
	'setProductBarcode'		=> ROOT.'/core/action/barcode/set_product_barcode.php',
	'addProduct'			=> ROOT.'/core/action/stock/add_stock.php',

	'addToCart' 			=> ROOT.'/core/action/cart/cart_item_row.php',
	'checkout'				=> ROOT.'/core/action/cart/checkout.php',
	
	'search'				=> ROOT.'/core/action/search/search.php',
	'autocomplete' 			=> ROOT.'/core/action/search/autocomplete.php',
	'advancedSearch'		=> ROOT.'/core/action/search/advanced_search.php',
		
	'modal'					=> ROOT.'/core/action/modal/modal.php',
	'appendMoreFields'		=> ROOT.'/core/action/add_more_fields.php',
	'editProduct'			=> ROOT.'/core/action/stock/edit_product.php',

	'scanBarcode' 			=> ROOT.'/core/action/barcode/scanBarcode.php',		
];

$route = $_POST['route'];

require $routeLis[$route]; 