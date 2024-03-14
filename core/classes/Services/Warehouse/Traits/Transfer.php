<?php 

namespace Core\Classes\Services\Warehouse\Traits;

use Core\Classes\Utils\Utils;
use Core\Classes\System\Main;

trait Transfer 
{


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


    /**
     * 
     */
    public function getTransferByDate($date = null, $controllerIndex)
    {
        $data_page = $this->main->initController($controllerIndex);
        $page_config = $data_page['page_data_list'];
        
        
        $data_page['sql']['query']['body'] = $data_page['sql']['query']['body'] . "  AND transfer_list.transfer_date = :mydateyear";
        $data_page['sql']['bindList']['mydateyear'] = $date ?? date("m.Y");
        
        return $this->main->prepareData($data_page['sql'], $data_page['page_data_list'], \PDO::FETCH_ASSOC);
    }



}