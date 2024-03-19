<?php 

namespace Core\Classes\Services\Warehouse\Traits;

use Core\Classes\Utils\Utils;

trait WriteOff 
{

    /**
     * 
     */
    public function writeOFf($list)
    {
        $transaction_id = Utils::generateTransactionId();

        foreach($list as $key => $row) {
            $id = $row['id'];
            $count = $row['count'];
        
            $this->Products->decreaseProductCount([
                'stock_id' => $id,
                'product_count' => $count
            ]);



            /**
             * @param array = [
             * 	'stock_id' => $id,
             * 	'description' => $desc,
             *  'count' => $count,
             *  'transaction_id' => $transaction_id
             * ];
             */            
            return $this->db->insert('write_off_products', [
                [
                    'description' 				=> $row['description'],
                    'count' 					=> $row['count'],
                    'day_date' 					=> Utils::getDateMY(),
                    'full_date'					=> Utils::getDateDMY(),
                    'id_from_stock' 			=>  $row['id'],
                    'transaction_id' 			=> $transaction_id
                ]
            ]); 
        }        
    }


    /**
     * 
     */
    public function getWriteOffByDate($date, $controllerIndex)
    {
        $data_page = $this->main->initController($controllerIndex);
        
        $data_page['sql']['query']['body'] = $data_page['sql']['query']['body'] . "  AND write_off_products.day_date = :mydateyear";
        $data_page['sql']['bindList']['mydateyear'] = $date ?? date("m.Y");
        
        return $this->main->prepareData($data_page['sql'], $data_page['page_data_list'], \PDO::FETCH_ASSOC);        
    }
}