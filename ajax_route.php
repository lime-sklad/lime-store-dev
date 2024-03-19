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


	'editReport'			=> ROOT.'/core/action/report/edit.php',
	'deleteOrder'			=> ROOT.'/core/action/report/refaund.php',
	
	'includeStats'			=> ROOT.'/core/pulgin/stats_card/stats_report.php',
	'reportChart'			=> ROOT.'/core/pulgin/charts/report_month_chart_stats.php',
	'reportChartCategory'	=> ROOT.'/core/pulgin/charts/report_category_charts.php',
	'reportChartProvider'	=> ROOT.'/core/pulgin/charts/report_provider_charts.php',
	'reportTopProducts'		=> ROOT.'//core/pulgin/charts/report_top_products.php',
	
	'scanBarcode' 			=> ROOT.'/core/action/barcode/scanBarcode.php',		


	'editExpense'			=> ROOT.'/core/action/expense/edit_expense.php',
	'deleteExpense'			=> ROOT.'/core/action/expense/delete_expense.php',
	'addExpense'			=> ROOT.'/core/action/expense/add_expense.php',

	'addTransfer'			=> ROOT.'/core/action/warehouse-transfer/add-transfer.php',

	'addArrivalProducts'	=> ROOT.'/core/action/arrival-products/add-arrival-products.php',

	'addWriteOff'			=> ROOT.'/core/action/write-off-products/add-write-off-products.php',


	//admin
	'addUser'				=> ROOT.'/core/action/admin/action/user/add-user.php',
	'deleteUser'			=> ROOT.'/core/action/admin/action/user/delete-user.php',
	'editUser'				=> ROOT.'/core/action/admin/action/user/edit-user.php',

	//category
	'addCategory' 			=> ROOT.'/core/action/category/add-category.php',


	'addWarehouse'			=> ROOT.'/core/action/warehouse/add-warehouse.php',
	'editWarehouseInfo'		=> ROOT.'/core/action/warehouse/edit-warehouse.php',
];

$route = $_POST['route'];

require $routeLis[$route]; 