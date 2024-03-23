<?php 
namespace Core\Classes\System;

class Init extends \Core\Classes\dbWrapper\db
{
    
    public $tableName;
    public $columnList;
    public $baseQuery;
    public $body;
    public $joins;
    public $sortBy;
    public $limit;
    public $allData;
    public $bindList;

    public function initController($page) 
    {    
        $controller_list = [
            'cart_terminal'   	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/cart-terminal/cart-terminal.controller.php',
            'terminal'      	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/terminal/terminal.controller.php',
            'stock'         	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/stock/stock.controller.php',
            'report'        	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/report/report.controller.php',
            'expense'        	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/expense/expense.controller.php',
            'warehouse-transfer-form'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/warehouse-transfer/warehouse-transfer-form/warehouse-transfer-form.controller.php',
            'warehouse-transfer-report'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/warehouse-transfer/warehouse-transfer-report/warehouse-transfer-report.controller.php',
            
            'arrival-form' 		=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/arrival-products/arrival-form/arrival-form.controller.php',
            'arrival-report'  	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/arrival-products/arrival-report/arrival-report.controller.php',
            
            'write-off-form'    =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/write-off-products/write-off-form/write-off-form.controller.php',
                'write-off-report'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/write-off-products/write-off-report/write-off-report.controller.php',
            
            'admin'         	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/admin/admin.controller.php',
                'create_warehouse'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/warehouse/create-warehouse.controller.php',
                'category_form' 	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/category-form/category-form.controller.php',
                'payment_method_form'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/payment-method-form/payment-method-form.controller.php',
                // 'provider_form' 	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/provider_form/provider_form.controller.php',
                // 'filter_form'   	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/filter_form/filter_form.controller.php',
                // 'settings'      	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/settings/settings.controller.php',
            
        ];

        

        $param = [];
        $all_pages = [];

        if($page) {
            $data_param = require $controller_list[$page];
        } else {
            foreach ($controller_list as $key => $val) {
                $all_pages[$key] = require $val; 
            }

            return $all_pages;
        }

        
        if($data_param) {
            $sql_param = $data_param['sql'];
            $table_name = $sql_param['table_name'];
            $base_query = $sql_param['query']['base_query'];
            $col_list = $sql_param['col_list'];
            $get_param = false;
            $get_sort  = false;

            if(!empty($sql_param['query'])) {
                if(array_key_exists('body', $sql_param['query'])) {
                    $get_param = $sql_param['query']['body'];
                }
                if(array_key_exists('sort_by', $sql_param['query'])) {
                    $get_sort = $sql_param['query']['sort_by'];
                }
            }
            // return $param;
            return $data_param;	
        }
    }

    public function getControllerData($index)
    {
        $data = $this->initController($index);

        $sql = $data['sql'];

        $this->tableName    = $sql['table_name'];
        $this->columnList   = $sql['col_list'];
        $this->baseQuery    = $sql['query']['base_query'];
        $this->body         = $sql['query']['body'];
        $this->joins        = $sql['query']['joins'];
        $this->sortBy       = $sql['query']['sort_by'];
        $this->limit        = $sql['query']['limit'] ?? '';
        $this->bindList     = $sql['bindList'] ?? [];
        $this->allData      = $data;
        
        return $this;
    }

}
