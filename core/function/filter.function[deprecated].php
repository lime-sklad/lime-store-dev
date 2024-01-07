<?php


//получем активный фильтр 
function get_active_filters($prefix, $id) {
	global $dbpdo;

	$array = [];

	$data = ls_db_request([
		'table_name' => 'user_control',
		'col_list' => '*',
		'param' => [
			'query' => [
				'param' => "

					INNER JOIN stock_filter ON stock_filter.stock_id = :id
					left JOIN filter ON filter.filter_id = stock_filter.active_filter_id


					GROUP BY stock_filter.active_filter_id	 
				",
				'bindList' => [
					':id' => $id,
					// ':prefix' => $prefix
				],
			]
		]
	], PDO::FETCH_ASSOC);




	if(count($data) > 0) {

		foreach($data as $key => $row) {
			// $row = $data[0];

			if($row['filter_type'] == $prefix) {
				$active_filter_id = $row['filter_id']; 
				$active_filter_val = $row['filter_value']; 
				$active = 'actived';
				$array = ['res' => $active, 'filter_id' => $active_filter_id, 'filter_val' => $active_filter_val];	
				
			}
		}
	
	}

	return $array;
}



// ----------------------------------------- upd ------------------------------------------------ //

/**
 * получаем список всех фильтров 
 * @return array $result список названий фильтров
 */
function get_all_filter_prefix_list() {
    $r = ls_db_request([
        'table_name' => 'filter_list',
        'col_list' => '*',
        'base_query' => ' ',
        'param' => [
            'query' => [
                'param' => ' WHERE filter_list_visible = 0',
                'joins' => '',
                'bindList' => []
            ],
            'sort_by' => ''
        ]
    ]);

	$result = [];

	foreach ($r as $value) {
		$result[$value['filter_list_prefix']] = [
			'filter_prefix_id' 		=> $value['id'],
			'filter_prefix' 		=> $value['filter_list_prefix'],
			'filter_short_name'		=> $value['filter_short_name'],
			'filter_prefix_title' 	=> $value['filter_list_title']
		];
	}

	return $result;
}


/**
 * получаем список значений фильтров
 * @return array $result - список значений фильтров
 */
function get_all_filter_value_list() {
    $r = ls_db_request([
        'table_name' => ' `filter` ',
        'col_list' => '*',
        'base_query' => ' ',
        'param' => [
            'query' => [
                'param' => ' WHERE `filter_visible` = 0 ',
                'joins' => '',
                'bindList' => []
            ],
            'sort_by' => ''
        ]
    ]);

	$result = [];

	foreach ($r as $value) {
		$result[$value['filter_type']][] = [
			'filter_id' => $value['filter_id'],
			'filter_value' => $value['filter_value'],
			'filter_type' => $value['filter_type']
		];
	}

	return $result;
}

/**
 * собираем фильтры в единий массив
 * @return array
 */
function ls_collect_filter(int $id  = null, array $type_list = array()) {
	$filter_prefix_list = get_all_filter_prefix_list();

	$filter_value_list = get_all_filter_value_list();

	// ls_var_dump($filter_value_list);
	
	// ну хз что тут, главное работает как мне нужно. Не помню когда и зачем, но работает. 
	if(!empty($filter_prefix_list)) {
		foreach ($filter_prefix_list as $key => $prefix_value) {

			$filter_prefix_list[$key] = array_merge([
				'list' => $filter_value_list[$prefix_value['filter_prefix_id']]
			], 
				$filter_prefix_list[$key]
			);
	
			$filter_prefix_list[$key]['active'] = get_active_filters($prefix_value['filter_prefix_id'], $id);
		}
	}

	$res = [];

	if(!empty($type_list)) {
		foreach($type_list as $key => $val) {
			if(array_key_exists($val, $filter_prefix_list)) {
				$res[$val] = array_merge($filter_prefix_list[$val]);
			}
		}
	} else {
		$res = $filter_prefix_list;
	}

	return $res;
}


/**
 * добавляем фильтры в базу для товара
 * 
 * @param array $post_data - массив $_POST
 * @param int $stock_id - id товара
 */
function ls_insert_stock_filter(array $post_data, int $stock_id) {
	$result = [];
	$data = [];
	if(!empty($post_data)) {

		$result = array_filter($post_data, function ($key) { 
			return strpos($key, 'filter_') === 0 ? true : false; 
		}, ARRAY_FILTER_USE_KEY);		
		
		
		foreach ($result as $key => $val) {
			if($val) {
				$data[] = [
					'active_filter_id' => $val,
					'stock_id'	=> $stock_id
				];
			}
		}
	
		if($data) {
			ls_db_insert('stock_filter', $data);
		} else {
			return false;
		}
		
		return true;
	}
}


/**
 * Удалаяем фильтер для товара
 * 
 * @param int $stock_id - id товара
 * @param int $filter_id - id фильтра 
 */ 
function ls_reset_stock_filter($stock_id, $filter_id) {
	ls_db_delete(array(
		[
			'table_name' => 'stock_filter',
			'joins' => ' INNER JOIN filter as tb ON tb.filter_id = :filter_id 
					     INNER JOIN filter ON filter.filter_type = tb.filter_type
			',
			'where' => ' stock_filter.active_filter_id = `filter`.filter_id AND stock_filter.stock_id = :id ',
			'bindList' => [
				':id' => $stock_id,
				':filter_id' => $filter_id
			]			
		]
	));
}




/**
 * изменить фильтр товара
 * @param array $post_data - массив с данными POST
 * @param int $id - id товара
 */
function ls_edit_stock_filter($post_data, $stock_id) {
	$result = [];
	$reset_result = [];

	// https://ru.stackoverflow.com/questions/1494106/%d0%9a%d0%b0%d0%ba-%d0%be%d1%81%d1%82%d0%b0%d0%b2%d0%b8%d1%82%d1%8c-%d0%b2-%d0%bc%d0%b0%d1%81%d1%81%d0%b8%d0%b2%d0%b5-%d0%b7%d0%bd%d0%b0%d1%87%d0%b5%d0%bd%d0%b8%d1%8f-%d0%bd%d0%b0%d1%87%d0%b8%d0%bd%d0%b0%d1%8e%d1%89%d0%b8%d0%b5%d1%81%d1%8f-%d1%81-%d0%be%d0%bf%d1%80%d0%b5%d0%b4%d0%b5%d0%bb%d0%b5%d0%bd%d0%bd%d0%be%d0%b3%d0%be-%d1%81%d0%bb%d0%be%d0%b2%d0%b0?noredirect=1#comment2678652_1494106
	$result = array_filter($post_data, function ($key) { 
		return strpos($key, 'filter_') === 0 ? true : false; 
	}, ARRAY_FILTER_USE_KEY);

	$reset_result = array_filter($post_data, function ($key) { 
		return strpos($key, 'reset_filter_') === 0 ? true : false; 
	}, ARRAY_FILTER_USE_KEY);	


	$reset_result = array_merge($result, $reset_result);

	foreach($reset_result as $filter_id) {
		// сбрасываем фиьтры товара с данной категорией
		ls_reset_stock_filter($stock_id, $filter_id);
	}

	// добавляем фильтер для товара
	ls_insert_stock_filter($result, $stock_id);
}


// получаем послденюю добавленный фильтер
function get_last_add_filter() {
	$res = ls_db_request([
        'table_name' => 'filter_list',
        'col_list' => '*',
        'base_query' => ' WHERE filter_list_visible = 0 ',
        'param' => [
            'query' => [
                'param' => '',
                'joins' => '',
                'bindList' => [
                   
                ]
            ],
            'sort_by' => ' ORDER BY id DESC LIMIT 1 '
        ]
	]);

	return $res[0];
}





// получаем список пунктов фильтра по id
function get_filter_option_list_by_id($id) {
	$res = ls_db_request([
		'table_name' => ' filter ',
		'col_list' => " * ",
		'base_query' => ' WHERE filter_type = :id ',
		'param' => [
			'query' => [
				'bindList' => [
					'id' => $id
				]
			]
		]
	]);

	return $res;
}







/**
 * создание кастомного фильтра
 * 
 * @param array $filter_name[
 * 		'title' => ...
 *       ...
 * ]
 * 
 * @param array $filter_option_list
 * 
 */
function create_new_filter($filter_name, $filter_option_list) {
	// array filter name
	// array filter_option

	ls_db_insert('filter_list', [
		[
			'filter_list_prefix' => $filter_name['title'],
			'filter_list_title'  => $filter_name['title'],
			'filter_short_name'	 => '',
		]
	]);


	$last_add_filter_id = get_last_add_filter()['id'];

	$data = [];

	foreach($filter_option_list as $key => $value) {
		$data[] = [
			'filter_type' => $last_add_filter_id,
			'filter_value' => $value
		];
	}

	ls_db_insert('filter', $data);
}





/**
 * изменить название фильтра
 * @param int $filter_id 
 * @param string $filter_name
 */
function ls_edit_filter_name($filter_id, $filter_name) {

	$option = [
		'before' => " UPDATE filter_list SET ",
		'after' => " WHERE id = :filter_id ",
		'post_list' => [
			//id
			'id' => [ 
				'query' => false,
				'bind' => 'filter_id',
				'require' => true
			],	
			//изменить название категории
			'name' => [
				'query' => "filter_list_title = :filter_name",
				'bind' => 'filter_name',
			],
		]
	];


	ls_db_upadte($option, [
		'id' => $filter_id,
		'name' => $filter_name
	]);
}




/**
 * изменить название пункьлв фильтра
 * @param int $id 
 * @param string $value
 */
function ls_edit_filter_option($id, $value) {
	$configs = [
		'before' => " UPDATE `filter` SET ",
		'after' => " WHERE filter_id = :filter_id ",
		'post_list' => [
			//id
			'id' => [ 
				'query' => false,
				'bind' => 'filter_id',
				'require' => true
			],	
			//изменить название категории
			'name' => [
				'query' => "filter_value = :option_value",
				'bind' => 'option_value',
			],
		]
	];

	ls_db_upadte($configs, [
		'id' => $id,
		'name' => $value
	]); 
}



/**
 * Удалаяем пункт фильтра
 * @param int $id
 */
function ls_delete_filter_option($id) {
	ls_db_delete(array(
		[
			'table_name' => 'filter',
			'joins' => ' ',
			'where' => ' filter.filter_id = :id ',
			'bindList' => [
				':id' => $id,
			]			
		]
	));
}


function delete_filter($id) {
	ls_db_delete(array(
		[
			'table_name' => 'filter_list',
			'joins' => ' ',
			'where' => ' filter_list.id = :id ',
			'bindList' => [
				':id' => $id
			]			
		]
	));
}


function ls_add_new_filter_option($option_name, $filter_type) {
	ls_db_insert('filter', [
		array(
			'filter_type' => $filter_type,
			'filter_value' => $option_name
		)
	]);
}



function get_page_stock_filter_fileds($page) {
	$page = page_data($page);

	return $page['page_data_list']['filter_fileds'];
}


function ls_get_filter_list_by_page_type($page) {
	$page_config = page_data($page);

	ls_var_dump($page_config);

	// $filter_fields = $page['page_data_list']['filter_fields'];

	// return ls_collect_filter(null, $filter_fields);
}