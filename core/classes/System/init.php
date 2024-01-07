<?php 
namespace core\classes\system;

class init extends \core\classes\dbWrapper\db
{
    
    public function initController($page) 
    {    
        $controller_list = [
            'cart_terminal'   	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/cart-terminal/cart-terminal.controller.php',
            'terminal'      	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/terminal/terminal.controller.php',
            // 'stock'         	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/stock/stock.controller.php',
            // 'report'        	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/report/report.controller.php',
            // 'rasxod'        	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/rasxod/rasxod.controller.php',
            // 'category_form' 	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/category_form/category_form.controller.php',
            // 'provider_form' 	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/provider_form/provider_form.controller.php',
            // 'filter_form'   	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/filter_form/filter_form.controller.php',
            // 'settings'      	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/settings/settings.controller.php',
            // 'warehouse_transfer_form'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/warehouse-transfer/warehouse-transfer-form/warehouse-transfer-form.controller.php',
            // 'warehouse_transfer_report'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/warehouse-transfer/warehouse-transfer-report/warehouse-transfer-report.controller.php',
            // 'arrival_form' 		=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/arrival-products/arrival-form/arrival-form.controller.php',
            // 'arrival_report'  	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/arrival-products/arrival-report/arrival-report.controller.php',
            // 'write_off_form'    =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/write-off-products/write-off-form/write-off-form.controller.php',
            // 'write_off_report'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/write-off-products/write-off-report/write-off-report.controller.php',
            // 'admin'         	=>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/admin/admin.controller.php',
            // 'create_warehouse'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/warehouse/create-warehouse.controller.php',
            // 'payment_method_form'  =>  $_SERVER['DOCUMENT_ROOT'].'/core/controller/payment_method_form/payment-method-form.controller.php',
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
            $base_query = $sql_param['base_query'];
            $col_list = $sql_param['col_list'];
            $get_param = false;
            $get_sort  = false;
            $param =  $sql_param['param'];
            if(array_key_exists('query', $param)) {
                $get_param = $param['query'];
            }
            if(array_key_exists('sort_by', $param)) {
                $get_sort = $param['sort_by'];
            }
            // return $param;
            return $data_param;	
        }
    }


}
