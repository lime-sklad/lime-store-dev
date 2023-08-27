<?php 
/**
 * в этом файле описываем логику работы с товарами
 * и отчетами 
 */


 function get_last_added_stock() {
    return ls_db_request([
        'table_name' => 'stock_list',
        'col_list' => '*',
        'base_query' => ' WHERE stock_visible = 0 ',
        'param' => [
            'sort_by' => 'ORDER BY stock_id DESC LIMIT 1'
        ]
    ])[0];
 }

 
/**
 * @param arr =  array(
 *				'id' => $id,
 *				'action' => 'get_name'
 *			);
 * получить информацию товара по id
 */
function get_stock_by_id($arr) {
	$id = $arr['id'];
	$action = $arr['action'];

    $row = ls_db_request([
        'table_name' => 'stock_list as tb',
        'col_list'   => '*',
        'base_query' => 'INNER JOIN stock_list ON stock_list.stock_visible != 3 ',			
        'param' => [
			'query' => array(
				'param' =>  " AND stock_list.stock_count >= stock_list.min_quantity_stock
							  AND stock_list.stock_visible = 0 AND stock_list.stock_id = :id ",
				"joins" => "  LEFT JOIN stock_provider ON stock_provider.provider_id = stock_list.product_provider
							  LEFT JOIN stock_category ON stock_category.category_id = stock_list.product_category ",		
				'bindList' => array(
					'id' => $id
				)
			),
			'sort_by' => " GROUP BY stock_list.stock_id DESC ORDER BY stock_list.stock_id DESC "
        ]
    ]);	

	$row = $row[0];


	switch ($action) {
		case 'name':
			return $row['stock_name'];
			break;
		case 'imei':
			return $row['stock_phone_imei'];
			break;
		case 'provider':
			return $row['stock_provider'];
			break;
		case 'category':
			return $row['stock_provider'];
			break;			
		case 'first_price':
			return $row['stock_first_price'];
			break;
		case 'all':
			return $row;
			break;
		default:
			return $row;
			break;
	}

}

/**
 * получаем список категории id товара
 * @param int $id
 */
function get_products_categorty_list($id) {
	$cat = ls_db_request([
		'table_name' => ' user_control ',
		'col_list' => ' * ',
		'base_query' => ' INNER JOIN products_category_list ON products_category_list.id_from_stock = :id 
						  LEFT JOIN stock_category ON stock_category.category_id = products_category_list.id_from_category
		',
		'param' => [
			'query' => [
				'bindList' => array(
					":id" => $id
				)
			],
			'sort_by' => ' GROUP BY products_category_list.id ASC ORDER BY products_category_list.id ASC '
		]
	]);

	return $cat;
}


/**
 * получаем список поставщика id товара
 * @param int $id
 */
function get_products_provider_list($id) {
	$cat = ls_db_request([
		'table_name' => ' user_control ',
		'col_list' => ' * ',
		'base_query' => ' INNER JOIN products_provider_list ON products_provider_list.id_from_stock = :id 
						  LEFT JOIN stock_provider ON stock_provider.provider_id = products_provider_list.id_from_provider
		',
		'param' => [
			'query' => [
				'bindList' => array(
					":id" => $id
				)
			],
			'sort_by' => ' GROUP BY products_provider_list.id ASC ORDER BY products_provider_list.id ASC '
		]
	]);

	return $cat;
}


/**
 * Изменяем категорию товара
 * @param array $data
 */
function edit_product_category($data) {
	$option = [
		'before' => " UPDATE products_category_list SET ",
		'after' => " WHERE id_from_stock =:stock_id AND id_from_category = :old_id",
		'post_list' => [
			//id
			'product_id' => [ 
				'query' => false,
				'bind' => 'stock_id',
				'require' => true
			],			
			'old_category_id' => [ 
				'query' => false,
				'bind' => 'old_id',
				'require' => true
			],
			'edited_category_id' => [
				'query' => ' id_from_category = :new_id ',
				'bind' => 'new_id',
				'require' => true
			]
		]
	];

	foreach ($data as $key => $collect_data) {
		ls_db_upadte($option, $collect_data);
	}
}



/**
 * Добавляем категорию для товара
 * @param int $product_id
 * @param array $data 
 */
function add_product_category($product_id, $data) {
	$collect_data = [];
	
	foreach ($data as $key => $val) {
		if(!empty($val['get_new_id'])) {
			$collect_data[] = [
				'id_from_category' => $val['get_new_id'],
				'id_from_stock' => $product_id
			];
		}
	}

	if(!empty($collect_data)) {
		ls_db_insert('products_category_list', $collect_data);
	}
}



/**
 * Удаляем категори для товара
 * @param array $data  
 */
function delete_product_category($data) {
	foreach ($data as $key => $val) {
		ls_db_delete([
			[
				'table_name' => 'products_category_list',
				'joins'	=> '',
				'where' => ' id_from_stock = :stock_id AND id_from_category = :cat_id ',
				'bindList' => [
					':stock_id' => $val['product_id'],
					':cat_id' => $val['del_id']
				],
			]
		]);
	}
}






/**
 * Изменяем поставщика товара
 * @param array $data
 */
function edit_product_provider($data) {
	$option = [
		'before' => " UPDATE products_provider_list SET ",
		'after' => " WHERE id_from_stock =:stock_id AND id_from_provider = :old_id",
		'post_list' => [
			//id
			'product_id' => [ 
				'query' => false,
				'bind' => 'stock_id',
				'require' => true
			],			
			'old_provider_id' => [ 
				'query' => false,
				'bind' => 'old_id',
				'require' => true
			],
			'edited_provider_id' => [
				'query' => ' id_from_provider = :new_id ',
				'bind' => 'new_id',
				'require' => true
			]
		]
	];

	foreach ($data as $key => $collect_data) {
		ls_db_upadte($option, $collect_data);
	}
}



/**
 * Добавляем поставщика для товара
 * @param int $product_id
 * @param array $data 
 */
function add_product_provider($product_id, $data) {
	$collect_data = [];
	
	foreach ($data as $key => $val) {
		if(!empty($val['get_new_id'])) {
			$collect_data[] = [
				'id_from_provider' => $val['get_new_id'],
				'id_from_stock' => $product_id
			];
		}
	}
	
	if(!empty($collect_data)) {
		ls_db_insert('products_provider_list', $collect_data);
	}
}



/**
 * Удаляем поставщика для товара
 * @param array $data  
 */
function delete_product_provider($data) {
	foreach ($data as $key => $val) {
		ls_db_delete([
			[
				'table_name' => 'products_provider_list',
				'joins'	=> '',
				'where' => ' id_from_stock = :stock_id AND id_from_provider = :cat_id ',
				'bindList' => [
					':stock_id' => $val['product_id'],
					':cat_id' => $val['del_id']
				],
			]
		]);
	}
}



function get_stock_by_barcode($barcode) {
		$ddt = ls_db_request([
			'table_name' => ' user_control as tb ',
			'col_list' => '*',
			'param' => [
				'query' => [
					'param' => " INNER JOIN stock_barcode_list ON stock_barcode_list.barcode_value = :id 
								 INNER JOIN stock_list ON stock_list.stock_id = stock_barcode_list.br_stock_id 
								 AND stock_list.stock_visible = 0 
								 AND stock_list.stock_count >= stock_list.min_quantity_stock

								",
					'bindList' => [
						':id' => $barcode
					],
				]
			]
		], PDO::FETCH_ASSOC);
			


		if(!empty($ddt)) {
			return $ddt;
		} else {
			return false;
		}
}


/**
 * увеличываем количество товара 
 * @param int $id - id товара
 * @param int $count - количество товара
 */
function stock_arrivals_count($id, $count) {
    ls_db_upadte([
        'before' => ' UPDATE stock_list SET ',
        'after'  => ' WHERE stock_id = :id ',
        'post_list' => [
            'stock_id' => [
                'query' => false,
                'bind' => 'id'
            ],
            'count' => [
                'query' => ' stock_count = stock_count + :add_count ',
                'bind' => 'add_count'
            ]
        ]
    ], [
        'stock_id' => $id,
        'count' => $count
    ]);
}


function add_arrivals_report($data, $transaction_id) {
	/**
	 * @param array = [
	 * 	'stock_id' => $id,
	 * 	'description' => $desc,
	 *  'count' => $count,
	 *  'transacrion_id' => $transacrion_id
	 * ];
	 */


	return ls_db_insert('arrival_products', [
		[
			'description' 				=> $data['description'],
			'count' 					=> $data['count'],
			'day_date' 					=> get_my_dateyear(),
			'full_date'					=> get_my_datetoday(),
			'id_from_stock' 			=>  $data['id'],
			'transaction_id' 			=> $transaction_id
		]
	]);

	 
}




/**
 * списываем количество товара 
 * @param int $id - id товара
 * @param int $count - количество товара
 */
function stock_write_off_count($id, $count) {
    ls_db_upadte([
        'before' => ' UPDATE stock_list SET ',
        'after'  => ' WHERE stock_id = :id ',
        'post_list' => [
            'stock_id' => [
                'query' => false,
                'bind' => 'id'
            ],
            'count' => [
                'query' => ' stock_count = stock_count - :write_off_count ',
                'bind' => 'write_off_count'
            ]
        ]
    ], [
        'stock_id' => $id,
        'count' => $count
    ]);
}


function add_write_off_report($data, $transaction_id) {
	/**
	 * @param array = [
	 * 	'stock_id' => $id,
	 * 	'description' => $desc,
	 *  'count' => $count,
	 *  'transacrion_id' => $transacrion_id
	 * ];
	 */


	return ls_db_insert('write_off_products', [
		[
			'description' 				=> $data['description'],
			'count' 					=> $data['count'],
			'day_date' 					=> get_my_dateyear(),
			'full_date'					=> get_my_datetoday(),
			'id_from_stock' 			=>  $data['id'],
			'transaction_id' 			=> $transaction_id
		]
	]);

	 
}