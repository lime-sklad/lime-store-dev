<?php

namespace core\classes;

class products extends \core\classes\dbWrapper\db
{


    public function get_products_by_id(int $id) 
    {
        return $this->select([
            'table_name' => 'stock_list',
            'col_list' => '*',
            'base_query' => ' WHERE stock_id = :id ',
            'param' => [
                'query' => [
                    'bindList' => [
                        ':id' => $id
                    ]
                ]
            ],
        ])->first()->get();
    }
}


