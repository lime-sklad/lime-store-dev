<?php

namespace Core\Classes\Services;

use core\classes\dbWrapper\db;
use Core\Classes\Utils\Utils;


class Warehouse 
{
    private $db;
    
    public function __construct()
    {
        $this->db = new DB;    
    }


    /**
     * Добавить новый склад в базу
     */
    public function addWarehouse($data)
    {
        //code          
    }



    /**
     * Получить список складов
     * 
     * old function name get_warehouse_list
     */
    public function getWarehouseList() 
    {
        return $this->db->select([
            'table_name' => 'warehouse_list',
            'col_list' => 'id AS custom_data_id, warehouse_name AS custom_value, warehouse_visible ',
            'query' => [
                'base_query' => ' WHERE warehouse_visible = 0 ',
                'sort_by' => ' GROUP BY custom_data_id DESC ORDER BY custom_data_id DESC '
            ]
        ])->get();
    }


    /**
     * Получить склад по id 
     * 
     * @param int $warehouseId склада
     * 
     */
    public function getWarehouse(int $warehouseId)
    {
        return $this->db->select([
            'table_name' => 'warehouse_list',
            'col_list' => 'id',
            'query' => [
                'base_query' => ' WHERE id = :id ',
            ],
            'bindList' => [
                ':id' => $warehouseId
            ]            
        ])->get();        
    }


    /**
     * Есть ли склад с тамим id 
     * 
     * @param int $warehouseId id склада
     */
    public function hasWarehouse(int $warehouseId)
    {
        $warehouse = $this->getWarehouse($warehouseId);

        return !empty($warehouse) ? true : false;
    }


    /**
     * Добавить трансфер
     * 
     * @param array @data массив с даннми
     * @param int $warehousId id склада
     */
    public function addTransfer(array $data, int $warehouseId)
    {
        $option = [
            'before' => ' UPDATE stock_list SET ',
            'after' => ' WHERE stock_id = :id ',
            'post_list' => [
                'id' => [
                    'query' => false,
                    'bind' => 'id'
                ],
                'count' => [
                    'query' => ' stock_list.stock_count = stock_list.stock_count - :product_count ',
                    'bind' => 'product_count'
                ]
            ]
        ];

        foreach($data as $key => $row) {
            $this->db->update($option, $row);
        
            $this->db->insert('transfer_list', [
                [
                    'warehouse_id' => $warehouseId,
                    'transfer_date' => Utils::getDateMY(),
                    'transfer_full_date' => Utils::getDateDMY(),
                    'stock_id' => $row['id'],
                    'count' => $row['count'],
                    'description' => $row['description']
                ]
            ]);    
        }         
    }
}