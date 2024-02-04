<?php

namespace Core\Classes\Services;

use core\classes\dbWrapper\db;

class Category
{
    private $db;

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
    



}