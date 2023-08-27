<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';
header('Content-type: Application/json');
// autocmplt-type
if(!isset($_POST['type'], $_POST['page'])) {
	echo 'error';
	exit();
}

$post_list = !empty($_POST['post_list']) ? $_POST['post_list'] : $_POST;

$type 		  = $_POST['type'];
$page 	      = $_POST['page'];


$th_list = get_th_list();

$sql_data = page_data($page);

$td_data = $sql_data['page_data_list'];

$sql_query_data = $sql_data['sql'];
$table = ' ';
$table_name     = $sql_query_data['table_name'];
$param 			= $sql_query_data['param'];
$col_list 		= $sql_query_data['col_list'];
$bind_list 		= $sql_query_data['param']['query']['bindList'];
$table_name 	= $sql_query_data['table_name'];
$base_query 	= $sql_query_data['base_query'];
$sort_by 		= $sql_query_data['param']['sort_by'];
$joins 			= ' ';

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

    $id = implode(',', array_fill(0, count($product_category_list), '?'));;

    $joins = $joins." INNER JOIN products_category_list ON products_category_list.id_from_category IN ($id) 
                      AND stock_list.stock_id = products_category_list.id_from_stock  
                      LEFT JOIN stock_category ON stock_category.category_id = products_category_list.id_from_category
                      ";

   $data = array_merge($data, $product_category_list);   

}

if(!empty($post_list['stock_provider_list'])) {
    $product_provider_list = $post_list['stock_provider_list'];

    $id = implode(',', array_fill(0, count($product_provider_list), '?'));;

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


// _________________________________________________________

$joins = $joins . $where;




// $bind_list['search'] = "%{$search_value}%";
$search_array = [
    'table_name' => $table_name,
    'col_list'   => $col_list,
    'base_query' => $base_query,			
    'param' => [
        'query' => [
            'param' => $param['query']['param'],
            'joins' => $joins,
            'bindList' => $data
        ],
        'sort_by' 	 => $sort_by,
    ]
];


$render_tpl = render_data_template($search_array, $sql_data['page_data_list'], null, 'positional');

$table .= $twig->render('/component/include_component.twig', [
    'renderComponent' => [
        '/component/table/table_row.twig' => [
            'table' => $render_tpl['result'],
            'table_tab' => $page,
            'table_type' => $type       
        ]
    ]
]);


$total = $twig->render('/component/include_component.twig', [
    'renderComponent' => [
        '/component/table/table_footer_row.twig' => [		
            'table_total' => table_footer_result($td_data['table_total_list'], $render_tpl['base_result'])  
        ]  
    ]
]);

echo json_encode([
    'table' => $table,
    'total' => $total
]);