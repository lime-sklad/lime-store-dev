<?php 
// autocmplt-type

use Core\Classes\Utils\Utils;
use Core\Classes\Services\Expenses;

$Expenses = new Expenses;

$postData = $_POST['data'];

if(!isset($postData['type'], $postData['page'])) {
    return Utils::abort([
        'type' => 'error',
        'text' => 'Empty'
    ]);
}

$get_data 	  = [];
$search_value = trim($postData['search_item_value']); 
$type 		  = $postData['type'];
$page 	      = $postData['page'];
$get_sort_data    = trim($postData['sort_data']);


$th_list = $main->getTableHeaderList();

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


foreach($page_data_row as $key => $col_name_prefix) {
	$th_this = $th_list[$key];
    
	$data_sort = $th_this['data_sort'];
	
	if($data_sort == $get_sort_data) {
        if(!empty($search_value)) {
            
            $bind_list['search'] = $search_value;
            // $bind_list['search'] = "%{$search_value}%";
            $search_array = [
                'table_name' => $table_name,
                'col_list'   => $col_list,
                'query' => [
                    'base_query' => $base_query,			
                    'body' => $param,
                    'joins' => $joins . " WHERE $col_name_prefix = :search ",
                    'sort_by' 	 => $sort_by,
                ],
                'bindList' => $bind_list
                
            ];     
            

            $render_tpl = $main->prepareData($search_array, $allData['page_data_list'], null, 'named');
            
        } else {
            $render_tpl = $main->prepareData($data_page['sql'], $td_data, null, 'named');    
        }

        $table .= $Render->view('/component/include_component.twig', [
            'renderComponent' => [
                '/component/table/table_row.twig' => [
                    'table' => $render_tpl['result'],
                    'table_tab' => $page,
                    'table_type' => $type       
                ]
            ]
        ]);
        
        if(!empty($render_tpl['base_result'])) {                
            $base_result = array_merge($base_result, $render_tpl['base_result'] );
        } 

	}
}

    //for rasxod
    if ($page == 'report') {
        if($get_sort_data == 'date' || $get_sort_data == 'buy_date') {
            array_push($base_result, ['rasxod_money' => $Expenses->seachExpensesByDate($search_value)]);
        }
    }
 

$total = $Render->view('/component/include_component.twig', [
    'renderComponent' => [
        '/component/table/table_footer_row.twig' => [		
            'table_total' => $utils->compareTableFooterData($td_data['table_total_list'], $base_result)  
        ]  
    ]
]);

echo json_encode([
    'table' => $table,
    'total' => $total
]);