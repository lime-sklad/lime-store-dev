<?php 

namespace Core\Classes\Cart;


use \Core\Classes\dbWrapper\db;
use \Core\Classes\Products;
use \Core\Classes\Report;
use \Core\Classes\Utils\Utils;

class Checkout 
{
    private $db;
    public $products;
    public $report;
    public $utils;

    public function __construct()
    {
        $this->db = new DB;
        $this->products = new Products;
        $this->report = new Report;
        $this->utils = new Utils;
    }


    /**
     * @param array $orderData
     * 
     * $orderData = [
     *  'ProductsData' => $stock_row, - данные товара
     *  'id'           => $id,        - id товара
     *  'order_price'  => $order_price, - цена заказа
     *  'order_count'  => $order_count, - количество
     *  'description'  => $description - описание
     *  'payment_method' => $payment_method
     * ];
     */
    public function checkoutOrder(array $orderData) 
    {
        $res = $this->prepareOrderData($orderData);

        $this->addOrder($res);

        $this->products->updateStockAfterSale(array(
            [
                'stock_id' => $orderData['id'],
                'product_count' => $orderData['order_count']
            ]
        ));
    }


    public function addOrder($res)
    {
        return $this->db->insert('stock_order_report', $res);
    }


    public function sumCost($price, $count) 
    {
        return $price * $count;
    }

    public function sumOrder($orderPrice, $orderSum)
    {
        return $orderPrice * $orderSum;
    }

    public function sumProfit($orderSum, $costSum) 
    {
        return $orderSum - $costSum;
    }


    public function prepareOrderData($orderData)
    {
        $ProductsData = $orderData['ProductsData'];
        $order_count = $orderData['order_count'];
        $order_price = $orderData['order_price'];
        $description = $orderData['description'];
        $payment_method = $orderData['payment_method'];
        $sales_man = $orderData['sales_man'];
        $transaction_id = $orderData['transaction_id'];
        $id = $orderData['id'];

        // себестоимость товара
        $first_price    = $ProductsData['stock_first_price'];


        // в переменную заносим значение себестоимость товара умноженное на количество в заказе
        $total_profit   = $this->sumCost($first_price, $order_count) ;

        // в переменную заносим значение цена указанная в заказе на количество
        $order_sum      = $this->sumOrder($order_price, $order_count);
        
        // высчитываем прыбыль
        $profit         = $this->sumProfit($order_sum, $total_profit);

        
        // готовим данные для добавления в таблицу бд
        $stock_data[$id] = [
            'stock_id'                  => $id,
            'order_stock_name'          => $ProductsData['stock_name'],
            'order_stock_imei'          => $ProductsData['stock_phone_imei'],
            'order_who_buy'             => $description,
            'order_stock_count'         => $order_count,
            'order_stock_sprice'        => $order_price,
            'order_stock_total_price'   => $order_sum,
            'order_total_profit'        => $profit,
            'order_date'                => $this->utils->getDateDMY(),
            'order_my_date'             => $this->utils->getDateMY(),
            'order_real_time'           => date('Y-m-d'),
            'payment_method'            => $payment_method,
            'sales_man'                 => $sales_man,
            'transaction_id'            => $transaction_id
        ];        


        return $stock_data;
    }

}