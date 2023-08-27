<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');

$prepare_data = $_POST['prepare_data'];

$data = [];
$arr = [];
$col_post_list = [
	'add_stock_name' => [	
		'col_name' => 'stock_name',
		'required' => true
	],
	'add_stock_description' => [ 
		'col_name' => 'stock_phone_imei' 
	],
	// 'add_stock_provider_id' => [
	// 	'col_name' => 'product_provider'
	// ],
	// 'add_stock_category_id' => [
	// 	'col_name' => 'product_category'
	// ],
	'add_stock_count' => [
		'col_name' => 'stock_count'
	],	
	'add_stock_min_quantity' => [
		'col_name' => 'min_quantity_stock'
	],
	'add_stock_first_price' => [
		'col_name' => 'stock_first_price',
		'required' => true 
	],
	'add_stock_second_price' => [
		'col_name' => 'stock_second_price' 
	],
	// 'add_stock_barcode' => [
	// 	'col_name' => 'barcode_article'
	// ]	
];

if(!empty($prepare_data) && count($prepare_data) > 0) {
	foreach ($col_post_list as $key => $value) {
		if(array_key_exists($key, $prepare_data)) {
			$data = array_merge($data, [
				$value['col_name'] => $prepare_data[$key]
			]);
		}
	}


	$default_data = [
		'stock_visible' 	=> 0,
		'stock_get_fdate' 	=> date("d.m.Y"),
		'stock_get_year' 	=> date("m.Y"),
		'product_added' 	=> getUser('get_id')
	];

	$data = array_merge($data, $default_data);

	try {
		if(!empty($prepare_data['stock_barcode_list']) && $prepare_data['stock_barcode_list']) {
			$barcode_list = $prepare_data['stock_barcode_list'];
			$bra = [];
			
			foreach ($barcode_list as $key => $value) {
				if(get_stock_by_barcode($value)) {
					echo json_encode([
						'error' => "такой товар уже есть "
					]);
		
					exit();
				}
			}





			// $barcode_list = $prepare_data['stock_barcode_list'];
			// $bra = [];
	
			// foreach ($barcode_list as $key => $value) {
	
			// 	$ddt = ls_db_request([
			// 		'table_name' => ' user_control as tb ',
			// 		'col_list' => '*',
			// 		'param' => [
			// 			'query' => [
			// 				'param' => " INNER JOIN stock_barcode_list ON stock_barcode_list.barcode_value = :id 
			// 							 INNER JOIN stock_list ON stock_list.stock_id = stock_barcode_list.br_stock_id 
			// 							 AND stock_list.stock_visible = 0 
			// 							 AND stock_list.stock_count >= stock_list.min_quantity_stock

			// 							",
			// 				'bindList' => [
			// 					':id' => $value,
			// 				],
			// 			]
			// 		]
			// 	], PDO::FETCH_ASSOC);
				
			// 	if(!empty($ddt)) {
			// 		$bra[] = $ddt;
			// 	}
			// }	
	
			// if(!empty($bra)) {
			// 	echo json_encode([
			// 		'error' => "такой товар уже есть "
			// 	]);

			// 	exit();
			// }
		}

		// создаем новый товар
		ls_db_insert('stock_list', [$data]);

		
		// получаем последний добавленный товар, тоесть тот который мы только что добавили
		$last_stock = get_last_added_stock();

		//получаем из списка только id товара
		$last_stock_id = $last_stock['stock_id'];

		//добавляем фильтры для товара
		ls_insert_stock_filter($prepare_data, $last_stock_id);

		// тут добавляем баркоды товара
		if(!empty($prepare_data['stock_barcode_list']) && $prepare_data['stock_barcode_list']) {
			$barcode_data = [];

			$barcode_list = $prepare_data['stock_barcode_list'];
	
			foreach ($barcode_list as $key => $value) {
				$barcode_data[] = [
					'barcode_value' => $value,
					'br_stock_id' => $last_stock_id
				];
			}

			ls_db_insert('stock_barcode_list', $barcode_data);
		}


		// тут добавляем категорию товара
		add_product_category($last_stock_id, $prepare_data['category_list']);

		// тут добавляем поставщика товра
		add_product_provider($last_stock_id, $prepare_data['provider_list']);


		//выводим сообщение о добавленом товаре
		echo json_encode([
			'success' => 'bla-bla'
		]);
	} catch (Exception $e) {
		echo json_encode([
			'error' => "Ошибка " . $e
		]);
	}

}