<?php
header('Content-type: Application/json');

$postData = $_POST['data'];



// ls_var_dump(postData);
if(!isset($postData['type'], $postData['page'])) {
	return $utils::abort([
		'type' => 'error',
		'text' => "Ошибка! Параметры не найдены \n Обновите страницу и попробуйде снова, если ошибка сохранится, обратитесь в тех потдержку"
	]);
}

$search_bind_list = [];

$type = $postData['type'];
$page = $postData['page'];

$data = $main->getControllerData($page);

$allData = $data->allData;

$td_data = $allData['page_data_list'];

$base_result = [];
$res = [];
$table = '';

$sql_query_data = $allData['sql'];

$col_list 		= $data->columnList;
$param 			= $data->body;
$bind_list 		= $data->bindList;
$table_name 	= $data->tableName;
$base_query 	= $data->baseQuery;
$sort_by 		= $data->sortBy;
$joins 			= $data->joins;
$limit 			= $data->limit;

$page_data_row = $td_data['get_data'];

if(isset($postData['id'])) {
	$filter_list = $postData['id'];
	$filter_query = [];
	foreach($filter_list as $key => $row) {
		$filter_query[$row['filter_type']][] = $row['filter_id'];
	}
	
	foreach($filter_query as $filter_type => $filter_id_list) {
		$id = implode(',', $filter_id_list);
		$table_prexif = 'table_name'.$filter_type;
		$query[] = " INNER JOIN stock_filter AS $table_prexif 
					 ON $table_prexif.active_filter_id IN($id) 
					 AND stock_list.stock_id = $table_prexif.stock_id ";
	}	
	$query = implode("\n", $query);
} else {
	// дикий треш - изменить
	if($page == 'report') {
		$query = ' AND stock_order_report.order_my_date = :mydateyear ';
		$search_bind_list['mydateyear'] = date("m.Y");
	} 
	// дикий треш - нужно переписать так что бы надобновсти не было	
	else if($page == 'rasxod') {
		$query = ' AND rasxod.rasxod_year_date= :mydateyear ';
		$search_bind_list['mydateyear'] = date("m.Y");
	}
	
	else {
		$query = '';		
	}

}



$search_array = [
    'table_name' => 'user_control',
    'col_list'   => $col_list,
    'query' => [
		'base_query' => $base_query,			
        'body' 		=> $param,
        'joins' 	=> $query . $joins,
        'sort_by' 	=> $sort_by,
		'limit'		=> $limit
	],
	'bindList' => $search_bind_list
];

$render_tpl = $main->prepareData($search_array, $td_data);


// exit();



$table = $Render->view('/component/include_component.twig', [
	'renderComponent' => [
		'/component/table/table_row.twig' => [		
			'table' => $render_tpl['result'],
			'table_tab' => $page,
			'table_type' => $type
		]  
	]
]);	


$total = $Render->view('/component/include_component.twig', [
	'renderComponent' => [
		'/component/table/table_footer_row.twig' => [		
			'table_total' => $utils->compareTableFooterData($td_data['table_total_list'], $render_tpl['base_result'])  
		]  
	]
]);




return $utils->abort([
	'table' => $table,
	'total' => $total
]);
