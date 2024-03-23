<?php

namespace Core\Classes\Services;

use core\classes\dbWrapper\db;

use function PHPSTORM_META\map;

class Category
{
    private $db;

    public $defaultData = [
        'visible' => 'visible',
    ];


    public function __construct()
    {
        $this->db = new db;
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
    public function sumSalesByCategory($date)
    {
        return $this->db->select([
            'table_name' => ' stock_order_report ',
            'col_list'	=> ' SUM(order_stock_total_price) AS total, category_name ',
        
            'query' => array(
                'base_query' => "",
                'body' =>  "
                            INNER JOIN 
                                products_category_list ON products_category_list.id_from_stock = stock_order_report.stock_id 
                                    AND stock_order_report.stock_order_visible = 0
                                    AND stock_order_report.order_stock_count > 0 
                                    
                            LEFT JOIN 
                                stock_category ON stock_category.category_id = products_category_list.id_from_category
        
                ",
                "joins" => " WHERE order_my_date = :mydateyear   ",		
                'sort_by' => " GROUP BY stock_category.category_id ",
            ),
            'bindList' => array(
                'mydateyear'    => $date
            )  
        ])->get();        
    }


    /**
     * Добавляем новую категорию в базу данных
     * @param array $post_data ['add_category_name' => {name} ]
     */
    public function addCategory($post_data)
    {
        $data = [];

        $col_post_list = [
            'add_category_name' => [
                'col_name' => 'category_name',
                'required' => true
            ],
        ];
    
        foreach ($col_post_list as $key => $value) {
            if(array_key_exists($key, $post_data)) {
                $data = array_merge($data, [
                    $value['col_name'] => $post_data[$key]
                ]);
            }
        }
    

        $data = array_merge($data, $this->defaultData);    
    
        $this->db->insert('stock_category', [$data]);
    
        return true;
    }


    /**
     * 
     */
    public function editCategory($data)
    {
        // в первом массиве мы должны описать и связвать данные $_POST с таблицей
        $option = [
            'before' => " UPDATE stock_category, user_control SET ",
            'after' => " WHERE category_id  = :category_id ",
            'post_list' => [
                //id
                'category_id' => [ 
                    'query' => false,
                    'bind' => 'category_id',
                    'require' => true
                ],	
                //изменить название категории
                'upd_category_name' => [
                    'query' => "stock_category.category_name = :cat_name",
                    'bind' => 'cat_name',
                ],
            ]
        ];    
        
        $this->db->update($option, $data);
    }

    /**
     * 
     */
    public function deleteCategory($cateogryId)
    {
       return $this->db->delete([
            [
                'table_name' => 'stock_category',
                'where' => ' category_id = :cat_id',
                'bindList' => [
                    ':cat_id' => $cateogryId
                ],
            ],
            [
                'table_name' => 'products_category_list',
                'where' => ' id_from_category = :cat_id',
                'bindList' => [
                    ':cat_id' => $cateogryId
                ],
            ]		
        ]);        
    }

    /**
     * 
     * 
     */
    public function getLastAddedCategory()
    {
        return $this->db->select([
            'table_name' => 'stock_category as tb',
            'col_list' => '*',
            'query' => [
                'body' => ' INNER JOIN stock_category
                            ON stock_category.visible = "visible" 
                ',
                'sort_by' => " GROUP BY stock_category.category_id DESC ORDER BY stock_category.category_id DESC LIMIT 1 "
            ]
        ])->get();
    }

}