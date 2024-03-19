<?php 

$postData = $_POST['data'];

$template = $Render->load('/component/modal/modal_view.twig');

if(isset($postData['product_id'], $postData['type'], $postData['page'])) {
	//массив в который будем заносить данные товара
	$stock_list = [];

    $input_fileds_list = [];
	//тип или вкладка
	$type = $postData['type'];
	//страница 
	$page = $postData['page'];
	//id товара или записи
	$id = $postData['product_id'];
	

	//получаем конфиги вкладки и страницы 
	$controllerData = $init->getControllerData($page);

	$allData = $controllerData->allData;

	$page_config = $allData['page_data_list'];

	$sql_query_data = $allData['sql'];

	$table_name     = $controllerData->tableName;
	$param 			= $controllerData->body;
	$col_list 		= $controllerData->columnList;
	$bind_list 		= $controllerData->bindList;
	$table_name 	= $controllerData->tableName;
	$base_query 	= $controllerData->baseQuery;
	$sort_by 		= $controllerData->sortBy;
	$joins 		    = $controllerData->joins;

	$sort_key = $page_config['sort_key'];

	$search_array = [
		'table_name' => ' user_control ',
		'col_list'   => " * ",
		'query' => [
			'base_query' => $base_query,			
			'body' => $param . " AND $sort_key = :id  ",
			'joins' =>  $joins,
			'sort_by' 	 =>  $sort_by,
			'limit'		=> ' LIMIT 1',
		],
		'bindList' => array(
			':id' => $id
		)
	];	


	//делаем запрос в базу с id  и знаносим результат в переменную
	$stock = $main->prepareData($search_array, $page_config, PDO::FETCH_ASSOC);	

	$filter_modal_list = [
		'edit_stock_filter',
		'info_product_filter_list',
	];


	if($stock && !empty($stock)) {

		//данные товаров
		$stock_base = $stock['base_result'][0];	
		
        foreach ($page_config['modal']['modal_fields'] as $key => $value) {
			$data_value = '';
			$data_custom = '';

			if($value['premission']) {

				// исправить это недоразумение - если данные это фильтры
				if(in_array($key, $filter_modal_list)) {
					$value['custom_data'] = $productsFilter->compareProductsFIlter($id, []);
				}


				if($value['db']) {
					$data_value = !empty($stock_base[$value['db']]) && $stock_base[$value['db']] ? $stock_base[$value['db']] : '';
				}
	
				if($value['custom_data']) {
					$data_custom = !empty($value['custom_data']) && $value['custom_data'] ? $value['custom_data'] : '';	
				}

				if(array_key_exists('user_function', $value)) {

					$args = ${$value['user_function']['function_args']};

					$data_value = call_user_func($value['user_function']['function_name'], $args);
				}
 	
				$input_fileds_list[] = [
					'block_name' 	=> $key,
					'class_list'	=> !empty($value['class_list']) ? $value['class_list'] : ' ', 
					'value' 		=> $data_value,
					'custom_data' 	=> $data_custom
				];
			}
		}

        $input_fileds_list['user'] = [
            'user_name'  => $user->getCurrentUser('get_name'),
            'user_id'    => $user->getCurrentUser('get_id'),
            'user_role'  => $user->getCurrentUser('get_role')
        ];


		$input_fileds_list['get'] = [
			'id' => $stock_base[$sort_key]
		];

        echo $template->renderBlock($page_config['modal']['template_block'], ['res' => $input_fileds_list]);
	}

}
