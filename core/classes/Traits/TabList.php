<?php 

namespace Core\Classes\Traits;

trait TabList {
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
                'tab_data_page' 	=> 'expense',
                'tab_title' 		=> 'Aylıq xərclər',
                'tab_link' 			=> '/page/rasxod/rasxod.php',
                'tab_icon' 			=> false,
                'tab_modify_class' 	=> 'pos-relative',
                'mark' => false
            ),
            'tab_day_rasxod' => array(
                'type' 				=> false,
                'tab_data_page' 	=> 'expense',
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
}