<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');


//удалить товар
if(isset($_POST['id']) && !empty($_POST['id'])) {

	$cateogry_id = $_POST['id'];

	ls_db_delete([
		[
			'table_name' => 'stock_category',
			'where' => ' category_id = :cat_id',
			'bindList' => [
				':cat_id' => $cateogry_id
			],
		],
		[
			'table_name' => 'products_category_list',
			'where' => ' id_from_category = :cat_id',
			'bindList' => [
				':cat_id' => $cateogry_id
			],
		]		
	]);

	// $update_data = [
	// 	'before' => 'UPDATE stock_category SET ',
	// 	'after' => ' WHERE category_id = :prod_id ',
	// 	'post_list' => [
	// 		'id' => [
	// 			'query' => ' stock_category.visible = "invisible" ',
	// 			'bind' => 'prod_id',
	// 		]
	// 	]
	// ];

	// echo ls_db_upadte($update_data, [
	// 	'id' => $cateogry_id
// ]);

	
	echo json_encode([
		'success' => 'ok'
	]);	
} else {
	echo json_encode(['error' => 'Cant find id']);
}
