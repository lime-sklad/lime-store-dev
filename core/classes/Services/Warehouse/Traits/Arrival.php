<?php 

namespace Core\Classes\Services\Warehouse\Traits;

use Core\Classes\Utils\Utils;
trait Arrival
{

    /**
     * 
     */
    public function arrivalProducts($productList)
    {
        $transaction_id = Utils::generateTransactionId();

        foreach($productList as $key => $row) {
            $id = $row['id'];
            $count = $row['count'];
        
            // stock_arrivals_count($id, $count);

            $this->Products->increaseProductCount([
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
            return $this->db->insert('arrival_products', [
                [
                    'description' 				=> $row['description'],
                    'count' 					=> $count,
                    'day_date' 					=> Utils::getDateMY(),
                    'full_date'					=> Utils::getDateDMY(),
                    'id_from_stock' 			=>  $id,
                    'transaction_id' 			=> $transaction_id
                ]
            ]);
        }
    }

    /**
     * 
     */
    public function getArrivalByDate($date, $controllerIndex)
    {
        $data_page = $this->main->initController($controllerIndex);
        
        $data_page['sql']['query']['body'] = $data_page['sql']['query']['body'] . "  AND arrival_products.day_date = :mydateyear";
        $data_page['sql']['bindList']['mydateyear'] = $date ?? date("m.Y");
        
        return $this->main->prepareData($data_page['sql'], $data_page['page_data_list'], \PDO::FETCH_ASSOC);
    }
}