<?php

namespace Core\Classes\Services\Warehouse;

use Core\Classes\Products;
use Core\Classes\System\Main;
use core\classes\dbWrapper\db;
use Core\Classes\Utils\Utils;

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
        return $this->db->insert('warehouse_list', [
            [
                'warehouse_name' => $data['warehouse_name'],
                'warehouse_contact' => $data['warehouse_contact']
            ]
        ]);
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
     * 
     */
    public function getLastAddedWarehouse()
    {
        $controllerIndex = Utils::getPostPage();

		$this_data = $this->main->getControllerData($controllerIndex)->allData;

		$page_config = $this_data['page_data_list'];

		$this_data['sql']['query']['sort_by'] = " GROUP BY id DESC ORDER BY id DESC LIMIT 1";

        return $this->db->select($this_data['sql'])->get();
    }

    
    /**
     * 
     */
    public function editWarehouse($data)
    {
        $option = [
            'before' => " UPDATE warehouse_list SET ",
            'after' => " WHERE id = :id ",
            'post_list' => [
                //id
                'warehouse_id' => [
                    'query' => false,
                    'bind' => 'id',
                    'require' => true
                ],	
                //изменить название товра
                'edit_warehouse_name' => [
                    'query' => "warehouse_name = :name",
                    'bind' => 'name',
                    'require' => true
                ],
            ]
        ];
        
        echo $this->db->update($option, $data);
    }


    /**
     * 
     */
    public function deleteWarehouse($id)
    {
        $option = [
            'before' => ' UPDATE warehouse_list SET ',
            'after' => ' WHERE id = :id ',
            'post_list' => [
                'warehouse_id' => [
                    'query' => ' warehouse_visible = 1 ',
                    'require' => true,
                    'bind' => 'id'
                ],
            ]
        ];
        
        echo $this->db->update($option, [
            'warehouse_id' => $id
        ]);        
    }
}