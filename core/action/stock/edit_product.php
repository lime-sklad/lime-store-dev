<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');

$stock_id = $_POST['product_id'];

// добавляем новую категорию для товара (не создаем категория, а добавляем уже существующую для товра )
if(!empty($_POST['new_added_category']) && !empty($_POST['product_id'])) {
	add_product_category($stock_id, $_POST['new_added_category']);
}

// если нужно изменить категория товара
if(!empty($_POST['edited_category'])) {
	edit_product_category($_POST['edited_category']);
}

// если нужно удалить категория товара
if(!empty($_POST['deleted_category'])) {
	delete_product_category($_POST['deleted_category']);
}


if(!empty($_POST['new_added_provider'])) {
	add_product_provider($stock_id, $_POST['new_added_provider']);
}

if(!empty($_POST['edited_provider'])) {
	edit_product_provider($_POST['edited_provider']);
}

if(!empty($_POST['deleted_provider'])) {
	delete_product_provider($_POST['deleted_provider']);
}


// в первом массиве мы должны описать и связвать данные $_POST с таблицей
$option = [
	'before' => " UPDATE stock_list, user_control SET ",
	'after' => " WHERE stock_id =:stock_id ",
	'post_list' => [
		//id
		'upd_product_id' => [ 
			'query' => false,
			'bind' => 'stock_id',
			'require' => true
		],	
		//изменить название товра
		'product_name' => [
			'query' => "stock_list.stock_name = :prod_name",
			'bind' => 'prod_name',
		],
		//изменить описание товара (старое imei)
		'product_description' => [
			'query' => "stock_list.stock_phone_imei = :prod_imei",
			'bind' => 'prod_imei'
		],
		//изменить количество товара
		'plus_minus_product_count' => [
			'query' => "stock_list.stock_count = :add_count",
			'bind' => 'add_count',
		],		
		//прибавить n-количсестов товара 
		'append_stock_count' => [
			'query' => "stock_list.stock_count = stock_list.stock_count + :append_count",
			'bind' => 'append_count',
		],		
		//изменить себе стоимость товара
		'product_first_price' => [
			'query' => "stock_list.stock_first_price = :f_price",
			'bind' => 'f_price',
		],
		//изменить стоимость
		'product_second_price' => [
			'query' => "stock_list.stock_second_price = :s_price",
			'bind' => 's_price'
		],
		//изменить минимальное количество товара
		'change_min_quantity' => [
			'query' => "stock_list.min_quantity_stock = :min_count",
			'bind' => 'min_count',	
		],

		//изменить количество товара
		'change_product_count' => [
			'query' => "stock_list.stock_count = :change_count",
			'bind' => 'change_count',
		],		
		
		//последнее изминение товара
		'last_edited_date' => [
			'query' => "stock_list.last_edited_date = :last_date",
			'bind' => 'last_date'
		]

	]
];

$data = $_POST['prepare_data'];

$default_data = [
	'last_edited_date' => date('Y-m-d h:i:s')
];

$data = array_merge($data, $default_data);

/**
 * исправить массив что бы выдывал только 1 результат
 * в js дописать js функцию update_table_row 
 * добавить в function.php id к каждой строке в табице для обновления резальутатата
 */

if(!empty($data) && count($data) > 1) {
	echo ls_db_upadte($option, $data);

	ls_edit_stock_filter($data, $data['upd_product_id']);

} else {
	echo json_encode([
		'error' => 'Вы ничего не изменили'
	]);
}
