<?php

namespace Core\Classes\Traits;

use Core\Classes\System\Utils;

trait Barcode
{
    /**
     * Добавлят для товара  баркод
     * 
     * @param array $barcodeList - список штрих кодов
     * @param int $productId - id товара 
     */
    public function setProductBarcode($barcodeList, $productId)
    {
        $list = [];
    
        $this->hasProductBarcode($barcodeList) ?? die;

        foreach($barcodeList as $key => $barcode) {
            $list[] = [
                'barcode_value' => $barcode,
                'br_stock_id' => $productId
            ];
        }
    
        $this->db->insert('stock_barcode_list', $list);
    }

    /**
     * Удалить штрихкоды для твоара
     * 
     * @param int $productId - id товара
     */
    public function resetProductBarcode($productId)
    {
        $this->db->delete(array(
            [
                'table_name' => 'stock_barcode_list',
                'joins' => '',
                'where' => ' br_stock_id = :id ',
                'bindList' => [
                    ':id' => $productId,
                ]			
            ]
        ));
    }


    /**
     * Получить список штрихкода товара
     * 
     * @param int $productId - id товара
     */
    public function getProductBarcodeList(int $productId)
    {
        return $this->db->select([
            'table_name' => ' stock_barcode_list ',
            'col_list' => ' * ',
            'query' => [
                'base_query' => ' WHERE br_stock_id = :id ',
                'body' => '',
                'joins' => '',
                'sort_by' => 'ORDER BY barcode_id DESC'
            ],            
            'bindList' => array(
                'id' => $productId
            ),
        ])->get();
    }


    /**
     * Проверить есть ли такой штрих код у товара 
     * @param array $barcodeList
     * @return true|false
     * Если выводит @return true то баркод есть в базе данных 
     * old function name get_stock_by_barcode
     */
    public function hasProductBarcode(array $barcodeList) 
    {
        foreach($barcodeList as $key => $barcode) {
            $data = $this->db->select([
                'table_name' => ' user_control as tb ',
                'col_list' => '*',
                'query' => [
                    'body' => " INNER JOIN stock_barcode_list ON stock_barcode_list.barcode_value = :id 
                                INNER JOIN stock_list ON stock_list.stock_id = stock_barcode_list.br_stock_id 
                                AND stock_list.stock_visible = 0 
                                AND stock_list.stock_count >= stock_list.min_quantity_stock
                                ",				
                ],
                'bindList' => [
                    ':id' => $barcode
                ],            
            ], \PDO::FETCH_ASSOC)->get();
                
            if (!empty($data)) {
                return Utils::abort([
                    'type' => 'error',
                    'text' => 'Bu barkodlu məhsul artıq əlavə edilib'
                ]);
            }
        }
        
        return false;
    }
     
    /**
     * Получить товар по баркоду
     */
    public function getProductByBarcode($barcode)
    {
       return $this->db->select([
            'table_name' => 'stock_list as tb',
            'col_list'   => '*',
            'query' => array(
                'base_query' => 'INNER JOIN stock_barcode_list ON stock_barcode_list.barcode_value = :barcode ',			
                'body' =>  " ",
                "joins" => " LEFT JOIN stock_list ON stock_list.stock_visible != 3  
                                AND stock_list.stock_count >= stock_list.min_quantity_stock 
                                AND stock_list.stock_visible = 0
                                AND stock_list.stock_id = stock_barcode_list.br_stock_id
                                ",		
    
                'sort_by' => " GROUP BY stock_barcode_list.barcode_id, stock_list.stock_id DESC ORDER BY stock_list.stock_id DESC "
            ),
            'bindList' => array(
                'barcode' => $barcode
            )
            
        ])->get();	        
    }


    /**
     * 
     */
    public function editBarcodeValue($list) 
    {
        $option = [
            'before' => " UPDATE stock_barcode_list SET ",
            'after' => " WHERE barcode_id = :id",
            'post_list' => [
                'id' => [
                    'query' => false,
                    'bind' => 'id'
                ],
                'value' => [
                    'query' => "stock_barcode_list.barcode_value = :val ",
                    'bind' => 'val'
                ]
            ]    
        ];

        foreach ($list as $key => $val) {
            self::vardump($val);
            $this->update($option, [
                'id' => $val['barcodeId'],
                'value' => $val['value']
            ]);
        }
    }    

}