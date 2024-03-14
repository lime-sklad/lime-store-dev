<?php 
namespace Core\Classes;

use core\classes\dbWrapper\db;
use Core\Classes\Traits\ReportStatsCard;
use Core\Classes\System\Main;
use Core\Classes\Utils\Utils;

class Report {
    use ReportStatsCard;

    public $main;
    public $db;
    
    public function __construct()
    {
        $this->main = new Main;
        $this->db = new db;
    }

    /**
     * @param int $id  id отчета
     * @return array
     *  Получить отчет по id
     */
    public function getById(int $id) 
    {
        return $this->db->select([
            'table_name' => 'stock_order_report',
            'col_list' => '*',
            'query' => [
                'base_query' => ' WHERE order_stock_id = :id ',
                'sort_by' => ' GROUP BY order_stock_id DESC ORDER BY order_stock_id DESC  '
            ],            
            'bindList' => [
                ':id' => $id
            ]
            
        ]);
    }


    /**
     * Получить отчет за месяц
     */
    public function getMonthlyReport(string $month = null)
    {

        $controllerData = $this->main->getControllerData('report');

        $data_page = $controllerData->allData;

        $data_page['sql']['query']['body'] = $data_page['sql']['query']['body']  . "  AND stock_order_report.order_my_date = :mydateyear";
        $data_page['sql']['bindList']['mydateyear'] = !empty($month) ? $month : date('m.Y');
        

        return $this->main->prepareData($data_page['sql'], $data_page['page_data_list'], \PDO::FETCH_ASSOC);
    }

    /**
     *  Поулчить отчет за день
     */
    public function getDailyReport(string $day = null)
    {
        $controllerData = $this->main->getControllerData('report');

        $data_page = $controllerData->allData;
                
        $data_page['sql']['query']['body'] = $data_page['sql']['query']['body'] . "  AND stock_order_report.order_date = :mayday ";
        $data_page['sql']['bindList']['mayday'] = !empty($day) ? $day : date('d.m.Y');
        
        return $this->main->prepareData($data_page['sql'], $data_page['page_data_list'], \PDO::FETCH_ASSOC);
    }    


    /**
     * 
     */
    public function getTopSellingProductsOfMonth($date) 
    {
        return $this->db->select([
            'table_name' => 'stock_order_report',
            'col_list' => "  order_my_date as smonth, order_stock_name,  SUM(order_total_profit) AS total_profit ",
            'query' => [
                'base_query' => '',
                'body' => " WHERE stock_order_report.order_my_date = :mydate
                            AND stock_order_visible = 0 ",
                'sort_by' => ' GROUP BY stock_order_report.stock_id ASC ORDER BY total_profit DESC ',
                'limit' => ' limit 10 '
            ],
            'bindList' => [
                ':mydate' => $date
            ],
        ])->get();

    } 



    /**
     * Редактировать отчет продажи 
     * @param array $data
     * @return json
     */
    public function editReport($data) 
    {
        $option = [
            'before' => ' UPDATE stock_order_report JOIN stock_list ON stock_list.stock_id = stock_order_report.stock_id SET ',
            'after' => ' WHERE order_stock_id = :report_id  ',
            'post_list' => [
                'report_order_id' => [
                    'query' => false,
                    'bind' => 'report_id',
                    'require' => true
                ],
                'edit_report_order_tags' => [
                    'query' => ' stock_order_report.payment_method = :payment_tags_id ',
                    'bind' => 'payment_tags_id',
                    'require' => false
                ],
                'edit_report_order_note' => [
                    'query' => ' stock_order_report.order_who_buy = :order_note ',
                    'bind' => 'order_note',
                    'require' => false
                ],

                'report_edit_order_count' => [
                    'query' => '  stock_list.stock_count =  stock_list.stock_count + stock_order_report.order_stock_count ',
                    'bind' => false,
                    'require' => false                    
                ],
            ]
        ];


        $this->db->update($option, $data);
        $this->refaundOrder($data);
        return $this->changeOrderPrice($data);
    }



    /**
     * Возврат товара, по количеству
     * 
     * @param array $data
     */
    public function refaundOrder($data)
    {
        // products count refaund
        $option2 = [
            'before' => ' UPDATE stock_order_report JOIN stock_list ON stock_list.stock_id = stock_order_report.stock_id SET ',
            'after' => ' WHERE order_stock_id = :report_id  ',
            'post_list' => [
                'report_order_id' => [
                    'query' => false,
                    'bind' => 'report_id',
                    'require' => true
                ],                
                'report_edit_order_count' => [
                    'query' => ' 
                        stock_list.stock_count =  stock_list.stock_count - :changeCount1,
                        stock_order_report.order_stock_count = :changeCount2
                    ',
                    'bind' => [
                        'changeCount1',
                        'changeCount2'
                    ],
                    
                    'require' => false
                ],
            ]
        ];

        return $this->db->update($option2, $data);        
    }


    /**
     * Изменяем цену в отчете 
     * 
     * @param array @data
     */
    public function changeOrderPrice($data) 
    {
        // products price change
        $option3 = [
            'before' => ' UPDATE stock_order_report JOIN stock_list ON stock_list.stock_id = stock_order_report.stock_id SET ',
            'after' => ' WHERE order_stock_id = :report_id  ',
            'post_list' => [
                'report_order_id' => [
                    'query' => false,
                    'bind' => 'report_id',
                    'require' => true
                ],                
                'report_edit_price' => [
                    'query' => ' stock_order_report.order_stock_sprice = :new_price, 
                                 stock_order_report.order_stock_total_price = :new_price2 * stock_order_report.order_stock_count,
                                 stock_order_report.order_total_profit = stock_order_report.order_stock_total_price - (stock_list.stock_first_price * stock_order_report.order_stock_count) 
                                 
                    
                    ',
                    'bind' => [
                        'new_price',
                        'new_price2'
                    ],
                    'require' => false                    
                ]
            ]
        ];

        return $this->db->update($option3, $data);        
    }




    /**
     * Возврат товара (продажи)
     * @param array $data
     * @return json 
     */
    public function deleteOrder($data) 
    {
        $option = [
            'before' => " UPDATE stock_list
                          JOIN stock_order_report ON stock_order_report.order_stock_id = :delete_id
                          SET stock_list.stock_count = stock_list.stock_count + stock_order_report.order_stock_count, 
                        --   stock_order_report.order_stock_count = 0,
                          stock_order_report.stock_order_visible = 3,
                          stock_list.stock_return_status = 1 ",
            'after' => "  WHERE stock_list.stock_id = stock_order_report.stock_id ",    
            'post_list' => [
                'report_id' => [
                    'query' => false,
                    'bind' => 'delete_id'
                ]
            ]
        ];   
        
        echo $this->db->update($option, $data);
    }

    public function getDifferenceOrderCount(int $orderCount, int $changeCount) {

    }




} 
