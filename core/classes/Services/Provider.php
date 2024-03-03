<?php 
namespace Core\Classes\Services;

use \Core\classes\dbWrapper\db;

class Provider 
{
    private $db;

    public function __construct()
    {
        $this->db = new db;
    }

    /**
     * получаем список поставщиков
     * @return array|null
     * old function name get_provider_list
     **/ 
    public function getProviderList() 
    {
        return $this->db->select([
            'table_name' => ' stock_provider ',
            'col_list' => ' * ',
            'query' => [
                'base_query' => ' WHERE visible = "visible" ',                
                'body' => '',
                'joins' => '',
                'sort_by' => 'ORDER BY provider_id DESC'
            ],
            'bindList' => array(
            )
        ])->get();
    }

    /**
     * получаем список поставщиков
     * @return array|null
     * old function name get_category_list
     **/  
    function getCategoryList() 
    {
        return $this->db->select([
            'table_name' => ' stock_category ',
            'col_list' => ' * ',
            'query' => [
                'base_query' => ' WHERE visible = "visible" ',
                'body' => '',
                'joins' => '',
                'sort_by' => 'ORDER BY category_id DESC'
            ],
            'bindList' => array(
            )
            
        ])->get();
    }
    

    /**
     * Выводит сумму продаж по категориям
     * 
     * @param date m.y $date дата
     * @return array|null
     */
    public function sumSalesByProvider($date)
    {
        return $this->db->select([
            'table_name' => ' stock_order_report ',
            'col_list'	=> ' SUM(order_stock_total_price) AS total, provider_name ',
        
            'query' => array(
                'base_query' => "",
                'body' =>  "
                            INNER JOIN 
                                products_provider_list ON products_provider_list.id_from_stock = stock_order_report.stock_id 
                                    AND stock_order_report.stock_order_visible = 0
                                    AND stock_order_report.order_stock_count > 0 
                                    
                            LEFT JOIN 
                                stock_provider ON stock_provider.provider_id = products_provider_list.id_from_provider
        
                ",
                "joins" => " WHERE order_my_date = :mydateyear   ",		
                'sort_by' => " GROUP BY stock_provider.provider_id ",
            ),
            'bindList' => array(
                'mydateyear'    => $date
            )  
        ])->get();        
    }

}