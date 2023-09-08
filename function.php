<?php

require $_SERVER['DOCUMENT_ROOT'].'/db/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/function/db.wrapper.php';
//upd  
require $_SERVER['DOCUMENT_ROOT'].'/private.function.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/function/stock.function.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/function/filter.function.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/function/user.function.php';
require $_SERVER['DOCUMENT_ROOT'].'/include/lib_include.php';

require $_SERVER['DOCUMENT_ROOT'].'/core/controller/init.php';


// syc new 
//test
if(!isset($_SESSION['user'])){
	$login_dir = '/login.php';
	header("Location: $login_dir");
	exit();      
}


function is_correct_local_date() {
	$data = ls_db_request([
		'table_name' => 'stock_order_report',
		'col_list' => '*',
		'base_query' => '',
		'param' => [
			'query' => [
			],
			'sort_by' => ' GROUP BY order_stock_id DESC ORDER BY order_stock_id DESC ',
			'limit' => 'limit 1'
		]
	]);

	$last_sale_date = $data[0]['order_date'];
	
	$local_date = get_my_datetoday();

	if(strtotime($last_sale_date) > strtotime($local_date)) {
		return true;
	} else {
		return false;
	}
}

// ls_var_dump(exec(' whoami'));

//проверка доступа страницы
access_request_action($_SERVER['REQUEST_URI']);
//проверка достпа запросов
access_request_uri($_SERVER['REQUEST_URI']);

$manat_image = '<img src="/img/icon/manat.png" class="manat_con_class">';
$manat_image_green = '<img src="/img/icon/manat_green.png" class="manat_con_class">';
//маркировака возврата
$stock_return_image = '<img src="img/icon/investment.png" style="width: 20px; height:20px;" title="Bu mall vazvrat olunub">';

// $update_check_day = 'Saturday'; 
$update_check_day = date("l");
$ordertoday = date("d.m.Y");
$order_myear = date("m.Y");
$weak_now = date("l"); //date("l");
$deactive_date = date('d.m.Y', strtotime('+30 day'));

function get_my_dateyear() {
	return date("m.Y");
}

function get_my_datetoday() {
	return  date("d.m.Y");
}

// time.windows.com - 180-200ms
// time.google.com - 80-90ms
// time.cloudflare.com - 8-25ms
function ntp($server = 'time.cloudflare.com', $port = 123) {
	$socket = @fsockopen("udp://$server", $port, $err_no, $err_str, 1);
	if (!$socket) return;
  
	fwrite($socket, chr(0x1b).str_repeat("\0",47));
  
	$packetReceived = fread($socket, 48);
   
	$unixTimestamp = unpack('N',$packetReceived, 40)[1] - 2208988800;
   
	$utcDate = date("d.m.Y",$unixTimestamp);

	return $utcDate;
}

function get_date($args) {
	switch ($args) {
		case 'shortDate':
			return date("m.Y");
			break;
		case 'fullDate':
			return date("d.m.Y"); 
			break;
		default:
			return date($args);
			break;
	}
}

function get_current_time() {
	return date('H:i');
}

function check_connections($var) {
	$ch = curl_init('https://www.google.com/');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$get_connectino = curl_exec($ch);

	$info = curl_getinfo($ch);
	curl_close($ch);

	if($info['http_code'] == '200') {
		return $var;
	} else {
		$do = 'nothing';
	}
}

function alert_error($text) {
    $error = true;
    echo json_encode([
            'type' => 'error',
            'text' => "[error] \n" .$text
    ]);
}

function print_alert($arr) {
	echo json_encode($arr);
}



function ls_trim($var) {
	$var = 	trim($var);
	$var =  htmlspecialchars($var);
	$var =  stripcslashes($var);
	$var =  strip_tags($var);
	return $var;	
}	


//дебаг функция
function ls_var_dump($var) {
	echo "<pre>";
		print_r($var) ;
	echo "</pre>";
}



//получаем массив для меню на главной странице и сайдбаре
function page_tab_list() {
	// для версия выше 7.4 return array_map(fn($post) => $post['tab'], page_data(false));
	
	//для версий ниже 7.4
	// return array_map(function($post) { return $post['tab']; }, page_data(false));

	$page_data = init_controller(false);
	$res = [];
	foreach ($page_data as $key => $value) {
		if($value['tab']['is_main']) {
			$res[$key] = $value['tab'];
		}
	}

	return $res;
}


//тут описываем вкладки и страницы
function get_tab_data($key = null, $active = null) {
	$result = [];

	$tab_arr = array(
		'tab_terminal_phone' => array(
			'type'				=> 'phone',
			'tab_title'			=> 'Mallar',
			'tab_data_page'		=> 'terminal',
			'tab_link' 			=> '/page/terminal/terminal.php',
			'tab_icon' 			=> '',
			'tab_modify_class'  => ''
		),
		'tab_stock_phone' => array(
			'type'				=> 'phone',
			'tab_title'			=> 'Mallar',
			'tab_link' 			=> '/page/stock/stock.php',
			'tab_icon' 			=> '',
			'tab_modify_class'  => ''
		),
		'tab_arrival_products' => array(
			'type'				=> 'phone',
			'tab_data_page'		=> 'arrival_form',
			'tab_title'			=> 'Alis fakturasi',
			'tab_link'			=> '/page/arrival_products/arrival_form.php',
			'tab_icon'			=> false,
			'tab_modify_class'	=> 'pos-relative',
			'mark' => [
				'modify_class' => ' widget__mark-rigt in-cart-count',
				'text' => ''
			]
		),
		'tab_arrival_report' => array(
			'type'				=> 'phone',
			'tab_data_page'		=> 'arrival_report',
			'tab_title'			=> 'Hesabat',
			'tab_link'			=> '/page/arrival_products/arrival_report.php',
			'tab_icon'			=> '',
			'tab_modify_class'	=> '',
		),
		'tab_write_off_form' => array(
			'type'				=> 'phone',
			'tab_data_page'		=> 'write_off_form',
			'tab_title'			=> 'Silinmə əməliyyatı',
			'tab_link'			=> '/page/write_off_products/write_off_form.php',
			'tab_icon'			=> false,
			'tab_modify_class'	=> ' pos-relative ',
			'mark' => [
				'modify_class' => 'widget__mark-rigt in-cart-count',
				'text' => ''
			]
		),
		'tab_write_off_report' => array(
			'type'				=> 'phone',
			'tab_data_page'		=> 'write_off_report',
			'tab_title'			=> 'Hesabat',
			'tab_link'			=> '/page/write_off_products/write_off_report.php',
			'tab_icon'			=> '',
			'tab_modify_class'	=> 'pos-relative',
			'mark' => [
				'modify_class' => 'widget__mark-right',
				'text' => ''
			]
		),
		
		
		'tab_warehouse_transfer_form' => array(
			'type'				=> 'phone',
			'tab_data_page'		=> 'warehouse_transfer_form',
			'tab_title'			=> 'Yeni transfer',
			'tab_link'			=> '/page/warehouse_transfer/warehouse_transfer_form.php',
			'tab_icon'			=> false,
			'tab_modify_class'	=> ' pos-relative ',
			'mark' => [
				'modify_class' => 'widget__mark-rigt in-cart-count',
				'text' => ''
			]
		),
		'tab_warehouse_transfer_report' => array(
			'type'				=> 'phone',
			'tab_data_page'		=> 'warehouse_transfer_report',
			'tab_title'			=> 'Hesabat transfer',
			'tab_link'			=> '/page/warehouse_transfer/warehouse_transfer_report.php',
			'tab_icon'			=> '',
			'tab_modify_class'	=> 'pos-relative',
			'mark' => [
				'modify_class' => 'widget__mark-right',
				'text' => ''
			]
		),


		'tab_report_phone' => array(
			'type'				=> 'phone',
			'tab_title'			=> 'Aylıq',
			'tab_link' 			=> '/page/report/report.php',
			'tab_icon' 			=> '/img/icon/investment.png',
			'tab_modify_class'  => ''		
		),

		'tab_report_day' => array(
			'type' 				=> false,
			'tab_title' 		=> 'Gündəlik',
			'tab_link' 			=> '/page/report/day_report.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' 				=> false
		),

		'tab_test' => array(
			'type' 				=> 'phone',
			'tab_title' 		=> 'Admin panel',
			'tab_link' 			=> '/page/terminal/terminal.php',
			'tab_icon' 			=> false,
			'tab_modify_class'  => false
		),
		'tab_cart' => array(
			'type' 				=> 'phone',
			'tab_data_page' 	=> 'cart_terminal',
			'tab_title' 		=> 'SƏbƏt',
			'tab_link' 			=> '/page/cart/cart.php',
			'tab_icon' 			=> false,
			'tab_modify_class'  => ' pos-relative ',
			'mark' => [
				'modify_class' 	=> 'widget__mark-rigt in-cart-count',
				'text' 			=> ''
			]
		),
		'tab_stock_form' => array(
			'type' 				=> false,
			'tab_title' 		=> 'Yeni məhsul',
			'tab_link' 			=> '/page/form/stock/stock_add_form.php',
			'tab_icon' 			=> false,
			'tab_modify_class'  => 'pos-relative',
			'mark' => [
				'modify_class' 	=> '',
				'text' 			=> ''
			]
		),
		'tab_create_warehouse' => array(
			'type' 				=> 'phone',
			'tab_title' 		=> 'Anbar',
			'tab_data_page'		=> 'create_warehouse',
			'tab_link'			=> '/page/form/warehouse/create_warehouse.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),
		'tab_admin' => array(
			'type' 				=> 'phone',
			'tab_title' 		=> 'Account',
			'tab_link' 			=> '/page/form/admin/admin.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),
		'tab_category_form' => array(
			'type' 				=> false,
			'tab_data_page' 	=> 'category_form',
			'tab_title' 		=> 'Kategoriya',
			'tab_link' 			=> '/page/form/category/category_form.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),
		'tab_provider_form' => array(
			'type' 				=> false,
			'tab_data_page' 	=> 'provider_form',
			'tab_title' 		=> 'Təchizatçı',
			'tab_link' 			=> '/page/form/provider/provider_form.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),
		'tab_filter_form' => array(
			'type' 				=> false,
			'tab_data_page' 	=> 'filter_form',
			'tab_title' 		=> 'Filterler',
			'tab_link' 			=> '/page/form/new_filter/filter_form.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),		
		'tab_rasxod' => array(
			'type' 				=> false,
			'tab_data_page' 	=> 'rasxod',
			'tab_title' 		=> 'Aylıq xərclər',
			'tab_link' 			=> '/page/rasxod/rasxod.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),
		'tab_day_rasxod' => array(
			'type' 				=> false,
			'tab_data_page' 	=> 'rasxod',
			'tab_title' 		=> 'GÜNDƏLIK xərclər',
			'tab_link' 			=> '/page/rasxod/day_rasxod.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),		
		'tab_rasxod_form' => array(
			'type' 				=> false,
			'tab_data_page' 	=> 'rasxod',
			'tab_title' 		=> 'Xərc əlavə etmək',
			'tab_link' 			=> '/page/form/rasxod/rasxod_form.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),	
		
		'tab_setting' => array(
			'type' 				=> false,
			'tab_data_page' 	=> 'settings',
			'tab_title'			=> 'Settings',
			'tab_link' 			=> '/page/form/settings/setting.php',
			'tab_icon' 			=> false,
			'tab_modify_class' 	=> 'pos-relative',
			'mark' => false
		),			
	);

	if(!empty($key)) {
		foreach ($key as $row => $value) {
			$result[$value] = $tab_arr[$value];
			//если значение таба активна, то присваиваем вкладке класс модификатор активной вкладки
			if($active) {
			   $result[$active]['tab_modify_class'] = $result[$active]['tab_modify_class'] . ' tab_activ';
			}
	   }
	   return $result;
	} else {
		return $tab_arr;
	}
	

}

// тут адов говно код, который тем не менее работает. Переделать!
function collect_product_data($stock_list, $page_data_list) {
	$result 	= [];
	$th_list 	= [];
	$complete 	= [];
	$sort_key = false;
	$tr_class_list = '';
	$compare_data = [];

	$data_name = $page_data_list['get_data'];

	if(array_key_exists('sort_key', $page_data_list)) {
		$sort_key = $page_data_list['sort_key'];
	}


	$th = get_th_list();		

	foreach ($data_name as $td_list => $td_row) {
		$th_this		 	= $th[$td_list];

		$th_title 			= $th_this['is_title'];
		$th_modify_class 	= $th_this['modify_class'];
		$td_class 			= $th_this['td_class'];
		$link_class 		= $th_this['link_class'];
		$data_sort 			= $th_this['data_sort'];
		$mark 				= $th_this['mark'];



		if($th_title) {

			$th_list[] = [
				'title' => $th_title,
				'modify_class' => $th_modify_class
			];

			$mass = [];
			foreach ($stock_list as $key => $row) {
				//fix return	
				if(array_key_exists('stock_return_status', $row)) {
					($row['stock_return_status'] == 1) ? $row['stock_return_status'] = ' ' : $row['stock_return_status'] = false;
				}


				if(array_key_exists('payment_method', $row)) {
					$mark_text = '';
					$mark_modify_class = '';
					// ($row['payment_method'] == 1) ? $row['payment_method'] = ' ' : $row['payment_method'] = false;

					if($td_row == 'payment_method') {

						if($row['payment_method'] == 1) {
							$mark_text = 'Nağd'; 
							$mark_modify_class = 'mark-chips mark-success-fill width-100 height-100';
						} else {
							$mark_text = 'Kart'; 
							$mark_modify_class = 'mark-chips mark-danger-fill width-100 height-100' ;
						}

					
						$row['payment_method'] = ' ';

						$mark['mark_text'] = $mark_text;
						$mark['mark_modify_class'] = $mark_modify_class;
					}
				}	
			
				

				if(array_key_exists('stock_order_visible', $row)) {
					if($row['stock_order_visible'] == 3) {

						$tr_class_list = ' mark-danger ';


					}
				}

				if(array_key_exists($td_row, $row)) {
					$data = $row[$td_row];
				} else {
					$data = null;
				}



				if(array_key_exists('mark_is_title', $th_this)) {
					$data = ' ';

					$mark['mark_text'] = $row[$td_row];
				}



				// если в массиве есть id товара то добавляем его, если нет, то берем просто ключ 
				// array_key_exists('stock_id', $row) ? $id = $row['stock_id'] : $id = $key;
		
				$sort_key ? $id = $row[$sort_key] : $id = $key;

				$result[$key][$id]['data'][] = [
					'data' 			=> $data,
					'td_class' 		=> $td_class,
					'link_class' 	=> $link_class,
					'data_sort' 	=> $data_sort,
					'mark'			=> $mark,
				];

				$result[$key][$id]['tr'] = [
					'class_list' => $tr_class_list
				];

				$tr_class_list = '';
			}
		}

	}

	$complete = [
		'th' => $th_list,
		'td' => $result,
	];

	return $complete;	
}


function get_th_list() {
	
		$th_list = [
			'id' => array(
				'is_title' 			=> check_th_return_name('th_serial'),
				'modify_class'	 	=> 'th_w40 dom-sort-table',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> 'id',
				'mark'				=> false				
			),
			'name' => array(
				'is_title'  		=> check_th_return_name('th_prod_name'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both filter-hotkey-sort res-stock-name',
				'data_sort' 		=> 'name',
				'mark'				=> false
			),									
			'description' => array(
				'is_title' 			=> check_th_return_name('th_description'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-description',
				'data_sort' 		=> 'imeis',
				'mark'				=> false
			),
			'first_price' => array(
				'is_title'  		=> check_th_return_name('th_buy_price'),
				'modify_class'		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-first-price',
				'data_sort' 		=> '',
				'mark_text' 		=> '',
				'mark'				=> array(
					'mark_text' 		=> '',
					'mark_modify_class' => 'manat-icon--black button-icon-right stock-list-icon'
				)	
			),
			'second_price' => array(
				'is_title'  		=> check_th_return_name('th_sale_price'),
				'modify_class'		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-second-price',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_text' 		=> '',
					'mark_title'		=> 'hekk',
					'mark_modify_class' => 'manat-icon--black button-icon-right stock-list-icon'
				)	
			),	
			'stock_barcode' => array(
				'is_title'  		=> 'Barcode',
				'modify_class'		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> ' stock-link-text-both res-stock-barcode-list',
				'data_sort' 		=> 'stock-barcode-sort',
				'mark'				=> false	
			),
			'report_barcode' => array(
				'is_title'  		=> 'Barcode',
				'modify_class'		=> 'th_w80 hide',
				'td_class' 			=> 'hide',
				'link_class' 		=> 'hide stock-link-text-both res-stock-barcode-list',
				'data_sort' 		=> 'stock-barcode-sort',
				'mark'				=> false	
			),			
			'provider' => array(
				'is_title'  		=> check_th_return_name('th_provider'),
				'modify_class'		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-provider',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'return_status' => array(
				'is_title'  		=>  check_th_return_name('th_return'),
				'modify_class'		=> 'th_w40',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_modify_class' => 'mark-chips mark-danger width-100 height-100',
					'mark_text' 		=> 'Bəli',
					'mark_title'		=> 'Bu mall vazvrat olunub',
				)
			),												
			'count' => array(
				'is_title' 			=> check_th_return_name('th_count'),
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-count',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_text'			=> 'ədəd',
					'mark_title'		=> false,
					'mark_modify_class' => 'button-icon-left mark stock-list-mark'
				)	
			),
			'category' => array(
				'is_title' 			=> check_th_return_name('th_category'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-category',
				'data_sort' 		=> false,
				'mark'				=> false	
			),
			'stock_add_date' => array(
				'is_title' 			=> check_th_return_name('th_buy_day'),
				'modify_class' 		=> 'th_w120',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res_buy_date',
				'data_sort' 		=> 'buy_date',
				'mark'				=> false					
			),
			'sales_date' => array(
				'is_title' 			=> check_th_return_name('th_day_sale'),
				'modify_class' 		=> 'th_w120',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res_buy_date',
				'data_sort' 		=> 'buy_date',
				'mark'				=> false
			),
			'sales_time' => array(
				'is_title'			=> 'Saat',
				'modify_class'		=> 'th_120',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both',
				'data_sort'			=> '',
				'mark'				=> false,
			),

			'report_note' => array(
				'is_title' 			=> check_th_return_name('th_report_note'),
				'modify_class' 		=> 'th_w120',
				'td_class' 			=> '',
				'link_class' 		=> ' stock-link-text-both res_note',
				'data_sort' 		=> '',
				'mark'				=> false				
			),

			'report_profit' => array(
				'is_title' 			=> check_th_return_name('th_profit'),
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> 'mark-success',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_text' 		=> '',
					'mark_modify_class' => 'manat-icon--black button-icon-right stock-list-icon'
				)	
			),	
			'report_sum_amount' => array(
				'is_title' 			=> check_th_return_name('th_profit'),
				'modify_class' 		=> 'th_w100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort'			=> '',
				'mark' 				=> false
			),			
			'report_total_amount' => array(
				'is_title' 			=> 'Ümumi məbləğ',
				'modify_class' 		=> 'th_w100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort'			=> '',
				'mark'				=> array(
					'mark_text' 		=> '',
					'mark_modify_class' => 'manat-icon--black button-icon-left stock-list-icon'
				)	
			),			
			
			'report_date_year' => array(
				'is_title' 			=> false,
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> 'date_year',
				'mark'				=> false
			),
			'report_order_id' => array(
				'is_title' 			=> check_th_return_name('th_report_serial'),
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both get_report_order_id',
				'data_sort' 		=> '',
				'mark'				=> false
			),
			'report_order_date' => array(
				'is_title' 			=> check_th_return_name('th_report_serial'),
				'modify_class' 		=> 'hide',
				'td_class' 			=> 'hide',
				'link_class' 		=> 'hide',
				'data_sort' 		=> 'date',
				'mark'				=> false				
			),
			'report_order_edit' => [
				'is_title' 			=> 'Redaktə',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-pen btn btn-secondary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false				
			],	
			'payment_method' => array(
				'is_title'  		=> 'Ödəniş üsulu',
				'modify_class'		=> 'th_w40',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_modify_class' => 'mark-chips mark-warning width-100 height-100',
					'mark_text' 		=> 'u',
					'mark_title'		=> '',
				)
			),		
			
			'report_sales_man' => array(
				'is_title' 			=> 'Satici',
				'modify_class' 		=> 'th_w40',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> '',
				'mark_is_title'		=> true,
				'mark'				=> array(
					'mark_modify_class' => 'mark mark-chips mark-primary width-100 height-100',
					'mark_text' 		=> 'u',
					'mark_title'		=> '',
				)
			),

			'terminal_add_basket' => array(
				'is_title' 			=> ' ',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las btn add-basket-btn-icon add-basket-button width-100 table-ui-btn la-cart-plus btn-secondary add-to-cart',
				'data_sort' 		=> '',
				'mark'				=> false
			),
			'terminal_basket_count_plus' => array(
				'is_title' 			=> ' ',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las las la-info-circle btn btn-primary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false
			),	
			'terminal_stock_info' => array(
				'is_title' 			=> ' ',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-plus btn btn-primary add-basket-btn-icon width-100 card-plus-count table-ui-btn',
				'data_sort' 		=> '',
				'mark'				=> false
			),							
			'edit_stock_btn' => [
				'is_title' 			=> 'Redaktə',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-pen btn btn-secondary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false				
			],
			'seller_id' => array(
				'is_title' 			=> 'id',
				'modify_class' 		=> 'th_w40',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'seller_name' => array(
				'is_title' => 'Логин',
				'modify_class' 		=> 'th_w300',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-seller-name',
				'data_sort' 		=> 'user_name',
				'mark'				=> false
			),
			'seller_password' => array(
				'is_title' 			=> check_th_return_name('th_admin_password'),
				'modify_class' 		=> 'th_w70',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-seller-password',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'seller_role' => array(
				'is_title' 			=> 'Роль',
				'modify_class' 		=> 'th_w70',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-seller-role',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'seller_edit' => array(
				'is_title' 			=> 'Redaktə',
				'modify_class' 		=> 'th_w40',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-pen btn btn-secondary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false	
			),
			'category_name' => array(
				'is_title' 			=> 'Название Категории',
				'modify_class' 		=> 'w100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-category-name',
				'data_sort' 		=> 'category',
				'mark'				=> false
			),
			'provider_name' => array(
				'is_title' 			=> 'Təchizatçı',
				'modify_class' 		=> 'w100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-edit-provider-name',
				'data_sort' 		=> 'provider',
				'mark'				=> false
			),			
			'edit' => array(
				'is_title' 			=> 'Redaktə',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-pen btn btn-secondary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false				
			),
			'rasxod_date' => array(
				'is_title' 			=> check_th_return_name('th_report_serial'),
				'modify_class' 		=> 'hide',
				'td_class' 			=> 'hide',
				'link_class' 		=> 'hide',
				'data_sort' 		=> 'rasxod-date',
				'mark'				=> false
			),
			'rasxod_day_date' => array(
				'is_title' 			=> 'Tarix',
				'modify_class'		=> 'th_w120',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both res-rasxod-date',
				'data_sort'			=> 'rasxod-day-date',
				'mark'				=> false
			),
	

			'transfer_full_date' => array(
				'is_title' 			=> 'Tarix',
				'modify_class'		=> 'th_w120',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both',
				'data_sort'			=> 'transfer-day-date',
				'mark'				=> false
			),			

			'rasxod_description' => array(
				'is_title' 			=> 'Tesvir',
				'modify_class'		=> 'th_w300',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both res-rasxod-description',
				'data_sort'			=> 'rasxod-description',
				'mark'				=> false
			),
			'rasxod_amount' => array(
				'is_title' 			=> 'Amount',
				'modify_class'		=> 'th_w60',
				'td_class'			=> 'mark-danger',
				'link_class'		=> 'stock-link-text-both res-rasxod-amount',
				'data_sort'			=> false,
				'mark'				=> [
					'mark_text' 		=> '',
					'mark_modify_class' => 'manat-icon--black button-icon-right stock-list-icon'
				]
			),

			'warehouse_name' => array(
				'is_title' 			=> 'Anbar adı',
				'modify_class'		=> 'th_w200',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both res-warehouse-name',
				'data_sort'			=> false,
				'mark'				=> [
				]
			),	


			'warehouse_contact' => array(
				'is_title' 			=> 'Əlaqə',
				'modify_class'		=> 'th_w100',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both',
				'data_sort'			=> false,
				'mark'				=> [
				]
			),						

			'td_filters_title' => array(
				'is_title' 			=> 'Filter adı',
				'modify_class' 		=> 'width-100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-filter-name',
				'data_sort' 		=> 'name',
				'mark'				=> false
			),

			'arrival_added_date' => array(
				'is_title' => 'Alış tarıxı',
				'modify_class' => 'width-60',
				'td_class' => '',
				'link_class' => 'stock-link-text-both res-',
				'data_sort' => 'arrival-date-month-srot',
				'mark' => false
			)

		];
	
	return $th_list;
}


// получаем страницы
function page_data($page) {
	return init_controller($page);
}

// в этой функцие описываем какие данные таблицы нужны для определённой категории
// пример вызова функции
/**
 * 	@param $arr = array(
 * 	 'type' => 'phone/akss/..'         - обьязательное поле 
 * 	 'page => 'terminal/stock/report'  - обьязательное поле
 * 	'search' => array(                 - не обьязательное поле
 * 	 'param' =>  " AND stock_type = :stock_type AND stock_count > 0 " ,
 *		'bindList' => array(
 *			':stock_type' => $type
 *		)
 *	)
 * 	);
**/
function render_data_template($sql_data, $get_data, $pdo_fetch = null, $placeholders = 'named') {

	//страница
	$stock_list = ls_db_request($sql_data, $pdo_fetch, $placeholders);

	return [
		'result' => collect_product_data($stock_list, $get_data),
		'base_result' => query_clear_by_user_access([ 'query' => $stock_list, 'access' => $get_data ])
	]; 	

}

//** удалить все что между этим комментом и концом этого коммента  */

//количество товаров 
function get_table_result_row_count($arr) {
	$total_count = [];
	foreach($arr as $stock) {
		$total_count[] = $stock['stock_count'];
	}

	return [
		'title' => 'Tapıldı',
		'value' => array_sum($total_count),
		'mark' 	=> [
			'mark_text' => 'ədəd',
			'mark_modify_class' => ''
		]
	];
}

//сумма себестоимости
function get_stock_first_price_sum($stock_list) {
	$total_sum = [];
	foreach($stock_list as $key) {
		if(array_key_exists('stock_first_price', $key) && array_key_exists('stock_count', $key)) {
			$total_sum[] = $key['stock_first_price'] * $key['stock_count'];
		}	
	}
	return [
		'title' => 'Malların ümumi dəyəri',
		'value' => array_sum($total_sum),
		'mark' 	=> [
			'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'			
		]
	];	
}


function table_footer_result($type_list, $data) {
	// $page_config['sql']['col_list'] = ' stock_list.stock_count ';
	// $page_config['sql']['param']['query']['joins'] = " ";

	
	// $stock_list = ls_db_request($page_config['sql'], PDO::FETCH_ASSOC);
	
	// $dd = 0;
	// foreach ($stock_list as $val ) {
	// 	$dd += $val['stock_count']; 
	// }

	// // echo $dd;

	// // foreach($type_list as $type) {
	// // 	//количество товара
	// // 	switch ($type) {
	// // 		case 'stock_count':
	// // 			 array_push($res, [
	// // 				'title' => 'Ümumi say',
	// // 				'value' => decorate_num(array_sum($stock_total_count)),
	// // 				'mark' 	=> [
	// // 					'mark_text' => 'ədəd',
	// // 					'mark_modify_class' => ''
	// // 				]
	// // 			]);
	// // 			break;
	// // 	}
	// // }






	// exit;
	$res = [];
	$stock_total_count = [];
	$search_result = count($data);
	$sum_stock_first_price = [];
	$sum_profit = 0;
	$sum_order_count = 0;
	$sum_rasxod = 0;
	$sum_sales = 0;
	$sum_margin = 0;
	
	$sum_card_money = 0;


	foreach($data as $stock) {
		if(array_key_exists('stock_count', $stock)) {

			if($stock['stock_count'] > 0) {
				$stock_total_count[] = $stock['stock_count'];
			}

			if(array_key_exists('stock_first_price', $stock)) {
				if($stock['stock_count'] > 0) {
					$sum_stock_first_price[] = $stock['stock_first_price'] * $stock['stock_count'];
				}
			}
		}

		if(array_key_exists('order_total_profit', $stock)) {
			$sum_profit += $stock['order_total_profit'];
		}

		if(array_key_exists('order_stock_count', $stock)) {
			if($stock['order_stock_count'] > 0 ) {
				$sum_order_count += $stock['order_stock_count'];
			} 
		}

		if(array_key_exists('rasxod_money', $stock)) {
			$sum_rasxod += $stock['rasxod_money'];
		}

		if(array_key_exists('order_stock_total_price', $stock)) {
			$sum_sales += $stock['order_stock_total_price'];
		}

		if(array_key_exists('payment_method', $stock)) {
			if($stock['payment_method'] == 2) {
				$sum_card_money += $stock['order_stock_total_price'];
			}
		}
	}

	foreach($type_list as $type) {
		//количество товара
		switch ($type) {
			case 'stock_count':
				 array_push($res, [
					'title' => 'Ümumi say',
					'value' => decorate_num(array_sum($stock_total_count)),
					'mark' 	=> [
						'mark_text' => 'ədəd',
						'mark_modify_class' => ''
					]
				]);
				break;
				case 'card_cash':
					array_push($res, [
					   'title' => 'Kart',
					   'value' => decorate_num($sum_card_money),
					   'mark' 	=> [
							'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'	
					   ]
				   ]);
				   break;				
			case 'sum_total_sales':
				array_push($res, [
				   'title' => 'Satış',
				   'value' => decorate_num($sum_sales),
				   'mark' 	=> [
						'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'			
					]
			   ]);
			   break;				
			case 'search_count': 
				array_push($res, [
					'title' => 'Tapıldı',
					'value' => decorate_num($search_result),
					'mark' 	=> [
						'mark_text' => 'ədəd',
						'mark_modify_class' => ''
					]
				]);
				break;
			case 'sum_first_price': 
				array_push($res, [
					'title' => 'Malların ümumi dəyəri',
					'value' => decorate_num(array_sum($sum_stock_first_price)),
					'mark' 	=> [
						'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'			
					]
				]);
				break;
			case 'sum_profit':
				array_push($res, [
					'title' => 'ümumi Mənfəət',
					'value' => decorate_num($sum_profit),
					'mark' 	=> [
						'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'			
					]
				]);
				break;
			case 'stock_order_count':
				array_push($res, [
				   'title' => 'Qaimə',
				   'value' => decorate_num($sum_order_count),
				   'mark' 	=> [
					   'mark_text' => 'ədəd',
					   'mark_modify_class' => ''
				   ]
			   ]);
			   break;
			   
			case 'sum_total_rasxod': 
				array_push($res, [
					'title' => 'ümumi xərc',
					'value' => decorate_num($sum_rasxod),
					'mark' => [
						'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'
					]
				]); 
				break;
			case 'sum_margin': 
				array_push($res, [
					'title' => 'Xalis mənfəət',
					'value' => decorate_num( $sum_profit - $sum_rasxod),
					'mark' => [
						'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'
					]
				]); 
				break;
				case 'sum_total_sales_margin': 
					array_push($res, [
						'title' => 'Qaliq (kassa)',
						'value' => decorate_num( ($sum_sales - $sum_rasxod) - $sum_card_money ),
						'mark' => [
							'mark_modify_class' => 'mark-icon-manat button-icon-right manat-icon--black'
						]
					]); 
					break;				
				
				
				
		}
	}

	return $res;
}


// получаем список поставщиков
function get_provider_list() {
	$provider = ls_db_request([
		'table_name' => ' stock_provider ',
		'col_list' => ' * ',
		'base_query' => ' WHERE visible = "visible" ',
		'param' => [
			'query' => [
				'param' => '',
				'joins' => '',
				'bindList' => array(
				)
			],
			'sort_by' => 'ORDER BY provider_id DESC'
		]
	]);

	return $provider;
}


// получаем список поставщиков
function get_category_list() {
	$provider = ls_db_request([
		'table_name' => ' stock_category ',
		'col_list' => ' * ',
		'base_query' => ' WHERE visible = "visible" ',
		'param' => [
			'query' => [
				'param' => '',
				'joins' => '',
				'bindList' => array(
				)
			],
			'sort_by' => 'ORDER BY category_id DESC'
		]
	]);

	return $provider;
}

/** 
 * @param array $arr
 * $arr = [
 * 	'table_name' => 'stock_list',
 * 	'col_name'	 => 'stock_name',
 * 	'order'		 => ' date desc ',
 *  'query' 	 => 'WHERE date_query = 0'
 * ];
 */
function get_report_date_list($data) {
	$table_name 	= $data['table_name'];
	$col_name 		= $data['col_name'];
	$order 			= $data['order'];
	$query 			= $data['query'];
	$default 		= $data['default'];

	$res = ls_db_request([
		'table_name' => $table_name,
		'col_list' => " DISTINCT $col_name",
		'base_query' => $query,
		'param' => [
			'query' => [
				'param' => "",
				'joins' => "",
				'bindList' => array()
			],
			'sort_by' => " ORDER BY $order "
		]
	]);
	
	$dd = array_column($res, $col_name);

	$dd['default'] = $default;

	return $dd;
}


// расход месячные
function get_total_rasxod($date) {
	$res = ls_db_request([
		'table_name' => 'rasxod',
		'col_list' => ' sum(rasxod_money) as total_rasxod_money  ',
		'base_query' => ' ',
		'param' => [
			'query' => [
				'param' => " WHERE rasxod_year_date = :mydateyear  AND rasxod_visible = 0",
				'joins' => "",
				'bindList' => array(
					'mydateyear' => $date
				)
			],
			'sort_by' => ' ORDER BY rasxod_id DESC '
		]
	]);

	return $res[0]['total_rasxod_money'];
}


//искать расход по не четкой дате
function search_rasxod_by_date($date) {
	$res = ls_db_request([
		'table_name' => 'rasxod',
		'col_list' => ' sum(rasxod_money) as total_rasxod_money  ',
		'base_query' => ' ',
		'param' => [
			'query' => [
				'param' => " WHERE rasxod_year_date = :mydateyear OR rasxod_day_date = :mydateday  AND rasxod_visible = 0",
				'joins' => "",
				'bindList' => array(
					'mydateyear' => $date,
					'mydateday' => $date,
				)
			],
			'sort_by' => ' ORDER BY rasxod_id DESC '
		]
	]);

	return $res[0]['total_rasxod_money'];
}

// расход
function get_today_total_rasxod($date) {
	$res = ls_db_request([
		'table_name' => 'rasxod',
		'col_list' => ' sum(rasxod_money) as total_rasxod_money  ',
		'base_query' => ' ',
		'param' => [
			'query' => [
				'param' => " WHERE rasxod_day_date = :mydaydate  AND rasxod_visible = 0",
				'joins' => "",
				'bindList' => array(
					'mydaydate' => $date
				)
			],
			'sort_by' => ' ORDER BY rasxod_id DESC '
		]
	]);

	return $res[0]['total_rasxod_money'];
}


// список месячных расходов
function get_rasxod_date_list() {
	$res = ls_db_request([
		'table_name' => "rasxod",
		'col_list' => " DISTINCT rasxod_year_date ",
		'base_query' => ' WHERE rasxod_visible = 0',
		'param' => [
			'query' => [
				'param' => "",
				'joins' => "",
				'bindList' => array()
			],
			'sort_by' => " ORDER BY rasxod_id DESC "
		]
	]);
	
	$dd = array_column($res, 'rasxod_year_date');

	$dd['default'] = date("m.Y");

	return $dd;
}

// список дневных расходов
function get_rasxod_day_list() {
	$res = ls_db_request([
		'table_name' => "rasxod",
		'col_list' => " DISTINCT rasxod_day_date ",
		'base_query' => ' WHERE rasxod_visible = 0',
		'param' => [
			'query' => [
				'param' => "",
				'joins' => "",
				'bindList' => array()
			],
			'sort_by' => " ORDER BY rasxod_id DESC "
		]
	]);
	
	$dd = array_column($res, 'rasxod_day_date');

	$dd['default'] = date("d.m.Y");

	return $dd;
}



function decorate_num($price) {
	return number_format($price, 0, '', ' ');
}


function license_expired_notify() {
	// Преобразуем дату в количество секунд
	$targetDate = get_license_expired_date();

	$targetTime = strtotime($targetDate);

	// Вычисляем количество секунд до определенной даты
	$timeRemaining = $targetTime - time();

	// Проверяем, осталось ли до определенной даты менее 3 дней
	if ($timeRemaining < (3 * 24 * 60 * 60)) {
		$data = ls_db_request([
			'table_name' => 'ls_notify',
			'col_list' => '*',
			'param' => [
				'query' => [
					'param' => " WHERE notify_type = :type",
					'bindList' => [
						':type' => 'expired',
					],
				]
			]
		], PDO::FETCH_ASSOC);

		if(empty($data[0])) {
			ls_db_insert('ls_notify', [
				array(
					'notify_text' => "Lisenziyanın müddəti $targetDate tarixində bitir",
					'notify_type' => 'expired'            
				)
			]);
		} else {
			return $data[0]['notify_text'];
		}
		
	} else {
		ls_db_delete([
			array(
				'table_name' => 'ls_notify',
				'where' => ' notify_type = :not_type ',
				'bindList' => [
					':not_type' => 'expired'
				]
			)
		]);	
		
		return false;
	}

	return false;
}


function get_warehouse_list() {
	return ls_db_request([
		'table_name' => 'warehouse_list',
		'col_list' => 'id AS custom_data_id, warehouse_name AS custom_value, warehouse_visible ',
		'base_query' => ' WHERE warehouse_visible = 0 ',
		'param' => [
			'sort_by' => ' GROUP BY custom_data_id DESC ORDER BY custom_data_id DESC '
		]
	]);
}