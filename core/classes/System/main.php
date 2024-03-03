<?php

namespace Core\Classes\System;

use \Core\Classes\Privates\AccessManager;
use \Core\Classes\Utils\Utils;
use \Core\Classes\dbWrapper\db;
use \Core\Classes\Services\RenderTemplate;

class Main extends \Core\Classes\System\Init 
{
	use \Core\Classes\Traits\TabList,
	    \Core\Classes\Traits\TableHeaderList;

    private $utils;
    private $accessManager;
    private $db;
	public $Render;

    public function __construct()
    {
        $this->utils = new utils;
        $this->accessManager = new accessManager;
        $this->db = new db;
		$this->Render = new RenderTemplate; 
    }


        /** 
     * @param array $arr
     * $arr = [
     * 	'table_name' => 'stock_list',
     * 	'col_name'	 => 'stock_name',
     * 	'order'		 => ' date desc ',
     *  'query' 	 => 'WHERE date_query = 0'
     * ];
     * 
     * @return array|null
     * 
     * old function name get_report_date_list
     */
    public function getReportDateList($data) 
    {
        $table_name 	= $data['table_name'];
        $col_name 		= $data['col_name'];
        $order 			= $data['order'];
        $query 			= $data['query'];
        $default 		= $data['default'];

        $res = $this->db->select([
            'table_name' => $table_name,
            'col_list' => " DISTINCT $col_name",
            'query' => [
                'base_query' => $query,
                'body' => "",
                'joins' => "",
                'sort_by' => " ORDER BY $order "
            ],
            'bindList' => array()
            
        ])->get();
        
        $dd = array_column($res, $col_name);

        $dd['default'] = $default;

        return $dd;
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
     */
    public function autocomplete($search_value, $controller_index)
    {
		$th_list = $this->getTableHeaderList();
		$controllerData = $this->getControllerData($controller_index);
		$allData = $controllerData->allData;

		$td_data = $allData['page_data_list'];
		
		$page_data_row = $td_data['get_data'];
		
		$sort_column = $td_data['sort_key'];

		$col_list 		= $controllerData->columnList;
		$table_name 	= $controllerData->tableName;
		$base_query 	= $controllerData->baseQuery;
		$joins 			= $controllerData->joins;
		$sort_by 		= $controllerData->sortBy;
		$bind_list 		= $controllerData->bindList;


        foreach($page_data_row as $key => $col_name_prefix) {
            $th_this = $th_list[$key];
        
        
            $data_sort = $th_this['data_sort'];
        
            if($data_sort) {
                $bind_list['search'] = "%{$search_value}%";
        
                $search_array = [
                    'table_name' => $table_name,
                    'col_list'   => "DISTINCT $col_name_prefix, $sort_column ",			
                    'query' => [
                        'base_query' 	=> $base_query,			
                        'body' 			=> $controllerData->body,
                        'joins' 		=> $joins . " WHERE $col_name_prefix LIKE :search ",
                        'sort_by' 	 	=> $sort_by,
                    ],
                    'bindList' => $bind_list
                ];
                

                
                $d = $this->db->select($search_array)->get();		
                
                
                foreach($d as $key) {
                    if(array_key_exists($col_name_prefix, $key)) {
                        echo $this->Render->view('/component/search/search_list.twig', [
                            'data' 				=>  $key[$col_name_prefix],
                            // 'link_modify_class' => 'get_item_by_filter search-item area-closeable selectable-search-item',
                            'link_modify_class' => !empty($allData['component_config']['search']['autocomplete']['autocomlete_class_list']) 
                                                ? $allData['component_config']['search']['autocomplete']['autocomlete_class_list'] 
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
    }
 	
}