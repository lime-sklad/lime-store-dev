<?php
header('Content-type: Application/json');

$postData = $_POST['data'];

// autocmplt-type
if(!isset($postData['type'], $postData['page'])) {
	echo 'error';
	exit();
}

$post_list = !empty($postData['post_list']) ? $postData['post_list'] : $postData;

$type 		  = $postData['type'];
$page 	      = $postData['page'];


$th_list = $main->getTableHeaderList();

$controllerData = $init->getControllerData($page);

$sql_data = $controllerData->allData;

$td_data = $sql_data['page_data_list'];

$sql_query_data = $sql_data['sql'];

$table = ' ';
$table_name     = $controllerData->tableName;
$param 			= $controllerData->body;
$col_list 		= $controllerData->columnList;
$bind_list 		= $controllerData->bindList;
$table_name 	= $controllerData->tableName;
$base_query 	= $controllerData->baseQuery;
$sort_by 		= $controllerData->sortBy;
$joins 		    = '  ';

if($page == 'report') {
    $joins 		    = ' LEFT JOIN payment_method_list ON payment_method_list.id = stock_order_report.payment_method ';
}

$where = ' WHERE user_control.user_id != 0 ';

$page_data_row = $td_data['get_data'];

$data = [];

if(empty($post_list['stock_category_list'])) {
    $joins = $joins.' LEFT JOIN products_category_list ON products_category_list.id_from_stock = stock_list.stock_id 
                      LEFT JOIN stock_category ON stock_category.category_id = products_category_list.id_from_category
    ';
}

if(empty($post_list['stock_provider_list'])) {
    $joins = $joins.' LEFT JOIN products_provider_list ON products_provider_list.id_from_stock = stock_list.stock_id
                      LEFT JOIN stock_provider ON stock_provider.provider_id = products_provider_list.id_from_provider
                        ';
}


if(!empty($post_list['stock_category_list'])) {
    $product_category_list = $post_list['stock_category_list'];

    $id = implode(',', array_fill(0, count($product_category_list), '?'));

    $joins = $joins." INNER JOIN products_category_list ON products_category_list.id_from_category IN ($id) 
                      AND stock_list.stock_id = products_category_list.id_from_stock  
                      LEFT JOIN stock_category ON stock_category.category_id = products_category_list.id_from_category
                      ";

   $data = array_merge($data, $product_category_list);   

}

if(!empty($post_list['stock_provider_list'])) {
    $product_provider_list = $post_list['stock_provider_list'];

    $id = implode(',', array_fill(0, count($product_provider_list), '?'));

    $joins = $joins." INNER JOIN products_provider_list ON products_provider_list.id_from_provider IN ($id) 
                      AND stock_list.stock_id = products_provider_list.id_from_stock  
                      LEFT JOIN stock_provider ON stock_provider.provider_id = products_provider_list.id_from_provider
                      ";    
    
   $data = array_merge($data, $product_provider_list); 
} 

if(!empty($post_list['report_month'])) {
    $report_month = reset($post_list['report_month']);

    if($report_month !== 'all') {
        $where = $where. " AND stock_order_report.order_my_date = ?  ";
        array_push($data, $report_month); 
    }

}


if(!empty($post_list['report_day'])) {
    $report_day = reset($post_list['report_day']);

    $where = $where. " AND stock_order_report.order_date = ?  ";
    
    array_push($data, $report_day); 
}

if(!empty($post_list['stock_name'])) {
    $stock_name = reset($post_list['stock_name']);

    $where = $where. " AND stock_list.stock_name LIKE ? ";

    array_push($data, "%{$stock_name}%");
    // $data['search'] = "%{$stock_name}%";
}

if(!empty($post_list['stock_description'])) {
    $stock_description = reset($post_list['stock_description']);

    $where = $where. " AND stock_list.stock_phone_imei LIKE ? ";

    array_push($data, "%{$stock_description}%");
}



// arrival _________________________________________________

if(!empty($post_list['arrival_report_day'])) {
    $arrival_day = reset($post_list['arrival_report_day']);


    if($arrival_day !== 'all') {
        $where = $where. " AND arrival_products.full_date = ?  ";
        array_push($data, $arrival_day); 
    }
}

// arrival_report_description
if(!empty($post_list['arrival_report_description'])) {
    $arrival_report_description = reset($post_list['arrival_report_description']);

    $where = $where. " AND arrival_products.description LIKE ? ";

    array_push($data, "%{$arrival_report_description}%");
}


// write_off_description
if(!empty($post_list['write_off_description'])) {
    $write_off_description = reset($post_list['write_off_description']);

    $where = $where. " AND write_off_products.description LIKE ? ";

    array_push($data, "%{$write_off_description}%");
}

if(!empty($post_list['write_off_date'])) {
    $write_off_date = reset($post_list['write_off_date']);


    if($write_off_date !== 'all') {
        $where = $where. " AND write_off_products.full_date = ?  ";
        array_push($data, $write_off_date); 
    }
}



//transfer

if(!empty($post_list['transfer_date_picker'])) {
    $transfer_full_date = reset($post_list['transfer_date_picker']);


    if($transfer_full_date !== 'all') {
        $where = $where. " AND transfer_list.transfer_full_date = ?  ";
        array_push($data, $transfer_full_date); 
    }
}

if(!empty($post_list['report_transfer_warehouse_list'])) {
    $transfer_warehouse_list = $post_list['report_transfer_warehouse_list'];

    $id = implode(',', array_fill(0, count($transfer_warehouse_list), '?'));;

    $where = $where." AND transfer_list.warehouse_id IN ($id) ";    
    
   $data = array_merge($data, $transfer_warehouse_list); 
}

// _________________________________________________________

$joins = $joins . $where;



// $bind_list['search'] = "%{$search_value}%";
$search_array = [
    'table_name' => $table_name,
    'col_list'   => $col_list,
    'query' => [
        'base_query' => $base_query,			
        'body' => $param,
        'joins' => $joins,
        'sort_by' 	 => $sort_by,
    ],
    'bindList' => $data
];


$render_tpl = $main->prepareData($search_array, $sql_data['page_data_list'], null, 'positional');

$table .= $Render->view('/component/include_component.twig', [
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

return $utils::abort([
    'table' => $table,
    'total' => $total
]);