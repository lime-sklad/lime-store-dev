<?php

$data = $_POST['data'];

// autocmplt-type
if(!isset($data['type'], $data['page'])) {
	$utils::abort([
		'type' => 'error',
		'text' => 'No result'
	]);
}

$search_value = trim($data['value']);
$page 	      = $data['page'];

return $main->autocomplete($search_value, $page);








exit;
$data = $_POST['data'];

// autocmplt-type
if(!isset($data['type'], $data['page'])) {
	echo 'error';
	exit();
}

$search_value = trim($data['value']);
$type 		  = $data['type'];
$page 	      = $data['page'];

$th_list = $main->getTableHeaderList();

$sql_data = $main->initController($page);

$td_data = $sql_data['page_data_list'];

$sql_query_data = $sql_data['sql'];

$col_list 		= $sql_query_data['col_list'];
$table_name 	= $sql_query_data['table_name'];
$base_query 	= $sql_query_data['query']['base_query'];
$joins 			= $sql_query_data['query']['joins'];
$sort_by 		= $sql_query_data['query']['sort_by'];
$bind_list 		= $sql_query_data['bindList'];

$page_data_row = $td_data['get_data'];

$sort_column = $td_data['sort_key'];

foreach($page_data_row as $key => $col_name_prefix) {
	$th_this = $th_list[$key];


	$data_sort = $th_this['data_sort'];

	if($data_sort) {
		$bind_list['search'] = "%{$search_value}%";

		$search_array = [
			'table_name' => $table_name,
			'col_list'   => "DISTINCT $col_name_prefix, $sort_column ",			
			'query' => [
				'base_query' => $base_query,			
				'body' => $sql_query_data['query']['body'],
				'joins' => $joins . " WHERE $col_name_prefix LIKE :search ",
				'sort_by' 	 => $sort_by,
			],
			'bindList' => $bind_list
		];
		
		$d = $db->select($search_array)->get();		
		
		
		foreach($d as $key) {
			if(array_key_exists($col_name_prefix, $key)) {
				echo $twig->render('/component/search/search_list.twig', [
					'data' 				=>  $key[$col_name_prefix],
					// 'link_modify_class' => 'get_item_by_filter search-item area-closeable selectable-search-item',
					'link_modify_class' => !empty($sql_data['component_config']['search']['autocomplete']['autocomlete_class_list']) 
										? $sql_data['component_config']['search']['autocomplete']['autocomlete_class_list'] 
										: 'get_item_by_filter search-item area-closeable selectable-search-item',
					'data_sort_value' 	=> true,
					'data_sort' 		=> $data_sort,
					'data_id'			=> $key[$sort_column],
					'mark'				=> ''
				]);		
			}
		}
	}
}




// __________________________________________________
