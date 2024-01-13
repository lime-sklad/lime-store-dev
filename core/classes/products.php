<?php

namespace Core\Classes;

class Products extends \Core\Classes\dbWrapper\db
{


    public function getProductsById(int $id) 
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


    public function refaund(array $data) {

    }
}


