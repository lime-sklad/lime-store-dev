<?php

namespace Core\Classes\Services\Warehouse;

use Core\Classes\Products;
use Core\Classes\System\Main;
use core\classes\dbWrapper\db;

class Warehouse
{
    use Traits\Transfer,
        Traits\Arrival,
        Traits\WriteOFf;
        
    public $main;
    public $Products;
    private $db;

    public function __construct()
    {
        $this->db = new db;
        $this->main = new Main;   
        $this->Products = new Products;
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

}