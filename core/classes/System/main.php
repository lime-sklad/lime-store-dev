<?php

namespace Core\Classes\System;

use \Core\Classes\Privates\AccessManager;
use \Core\Classes\System\Utils;
use \Core\Classes\dbWrapper\db;

class Main extends \Core\Classes\System\Init 
{

    private $utils;
    private $accessManager;
    private $db;

    public function __construct()
    {
        $this->utils = new utils;
        $this->accessManager = new accessManager;
        $this->db = new db;
    }



    /**
     * old function name page_tab_list
     * 
     * получаем массив для меню на главной странице и сайдбаре
     * 
     * @return array|null
     */
    public function getMenuList() 
    {
        // для версия выше 7.4+ return array_map(fn($post) => $post['tab'], page_data(false));
        
        //для версий ниже 7.4
        // return array_map(function($post) { return $post['tab']; }, page_data(false));

        $page_data = $this->initController(false);

        $res = [];

        foreach ($page_data as $key => $value) {
            if($value['tab']['is_main']) {
                $res[$key] = $value['tab'];
            }
        }

        return $res;
    }



    /**
     * old function name get_tab_data
     * 
     * тут описываем вкладки и страницы
     * 
     * @param string|null  
     */
    public function getTabs($key = null, $active = null) 
    {
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


            'tab_payment_method_manage' => array(
                'type'				=> 'phone',
                'tab_data_page'		=> 'payment_method_form',
                'tab_title'			=> 'Ödəniş üsulu',
                'tab_link'			=> '/page/form/payment_method/payment_method_manage.php',
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

        // вывести все вкладки
        if(!empty($key)) {
            foreach ($key as $row => $value) {
                $result[$value] = $tab_arr[$value];

                //если значение таба активна, то присваиваем вкладке класс модификатор активной вкладки
                if($active) {
                    $result[$active]['tab_modify_class'] = $result[$active]['tab_modify_class'] . ' tab_activ';
                }
            }

            return $result;
        } 
        
        // вывести все вкладки
        return $tab_arr;
    }





    /**
     * в этой функцие описываем какие данные таблицы нужны для определённой категории
     *
     * пример вызова функции 
     * 	@param array $arr = array(
     * 	 'type' => 'phone/akss/..'         - обьязательное поле 
     * 	 'page => 'terminal || stock || report'  - обьязательное поле
     * 	'search' => array(                 - не обьязательное поле
     * 	 'param' =>  " AND stock_type = :stock_type AND stock_count > 0 " ,
     *		'bindList' => array(
     *			':stock_type' => $type
     *		)
     *	)
     * 	);
     * 
     * old function name render_data_template
    **/
    public function prepareData(array $sql_data, array $get_data,  $pdo_fetch = null, string $placeholders = 'named') 
    {
        //страница
        $stock_list = $this->db->select($sql_data, $pdo_fetch, $placeholders)->get();

        return [
            'result' => $this->compareData($stock_list, $get_data),
            'base_result' => $this->accessManager->cleanseInaccessibleData([ 'query' => $stock_list, 'access' => $get_data ], $this->getTableHeaderList())
        ]; 	

    }


    /**
     * тут адов говно код, который тем не менее работает. Переделать!
     */
    public function compareData($stock_list, $page_data_list) 
    {
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


        $th = $this->getTableHeaderList();		

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
                            $tags_id = $row['tags_id'];

                            $mark_text = $row['title'];
                            $mark_modify_class = $this->utils->getTagsList($base = false, $tags_id); 
                        
                            $row['payment_method'] = ' ';

                            $mark['mark_text'] = $mark_text;

                            $mark['mark_modify_class'] = $mark_modify_class['class_list'];
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


	/**
	 * 
	 * old function name get_th_list
	 */
    function getTableHeaderList() 
    {
		$th_list = [
			'id' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_serial'),
				'modify_class'	 	=> 'th_w40 dom-sort-table',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> 'id',
				'mark'				=> false				
			),
			'name' => array(
				'is_title'  		=> $this->accessManager->checkDataPremission('th_prod_name'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both filter-hotkey-sort res-stock-name',
				'data_sort' 		=> 'name',
				'mark'				=> false
			),									
			'description' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_description'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-description',
				'data_sort' 		=> 'imeis',
				'mark'				=> false
			),
			'first_price' => array(
				'is_title'  		=> $this->accessManager->checkDataPremission('th_buy_price'),
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
				'is_title'  		=> $this->accessManager->checkDataPremission('th_sale_price'),
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
				'is_title'  		=> $this->accessManager->checkDataPremission('th_provider'),
				'modify_class'		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-provider',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'return_status' => array(
				'is_title'  		=>  $this->accessManager->checkDataPremission('th_return'),
				'modify_class'		=> 'th_w40',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_modify_class' => 'mark-tags mark-danger width-100 height-100',
					'mark_text' 		=> 'Bəli',
					'mark_title'		=> 'Bu mall vazvrat olunub',
				)
			),												
			'count' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_count'),
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
				'is_title' 			=> $this->accessManager->checkDataPremission('th_category'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-category',
				'data_sort' 		=> false,
				'mark'				=> false	
			),
			'stock_add_date' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_buy_day'),
				'modify_class' 		=> 'th_w120',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res_buy_date',
				'data_sort' 		=> 'buy_date',
				'mark'				=> false					
			),
			'sales_date' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_day_sale'),
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
				'is_title' 			=> $this->accessManager->checkDataPremission('th_report_note'),
				'modify_class' 		=> 'th_w120',
				'td_class' 			=> '',
				'link_class' 		=> ' stock-link-text-both res_note',
				'data_sort' 		=> '',
				'mark'				=> false				
			),

			'report_profit' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_profit'),
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
				'is_title' 			=> $this->accessManager->checkDataPremission('th_profit'),
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
				'is_title' 			=> $this->accessManager->checkDataPremission('th_report_serial'),
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both get_report_order_id',
				'data_sort' 		=> '',
				'mark'				=> false
			),
			'report_order_date' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_report_serial'),
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
				'modify_class'		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-payment-tags',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_modify_class' => 'mark-tags mark-warning width-100 height-100 zsdljkfsjfklsj',
					'mark_text' 		=> 'u',
					'mark_title'		=> '',
				)
			),
			
			'payment_method_form' => array(
				'is_title'  		=> 'Ödəniş üsulu',
				'modify_class'		=> 'th_w300',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-payment-method-title',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_modify_class' => '',
					'mark_text' 		=> '',
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
					'mark_modify_class' => 'mark mark-tags mark-primary width-100 height-100',
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
				'is_title' 			=> $this->accessManager->checkDataPremission('th_admin_password'),
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
				'is_title' 			=> $this->accessManager->checkDataPremission('th_report_serial'),
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

}