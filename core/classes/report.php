<?php 
namespace core\classes;

class report extends \core\classes\dbWrapper\db {
    /**
     * @param int $id  id отчета
     * @return array
     *  Получить отчет по id
     */
    public function getById(int $id) 
    {
        return $this->select([
            'table_name' => 'stock_order_report',
            'col_list' => '*',
            'base_query' => ' WHERE order_stock_id = :id ',
            'param' => [
                'query' => [
                    'bindList' => [
                        ':id' => $id
                    ]
                ],

            'sort_by' => ' GROUP BY order_stock_id DESC ORDER BY order_stock_id DESC  '
            ]
        ]);
    }


    /**
     * Редактировать отчет продажи 
     * @param array $data
     * @return json
     */
    public function edit($data) 
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


        $this->update($option, $data);
        
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

        $this->update($option2, $data);




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


        return $this->update($option3, $data);
    }


    /**
     * Возврат товара (продажи)
     * @param array $data
     * @return json 
     */
    public function refaundOrder($data) 
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
        
        

        return $this->update($option, $data);
    }

    public function getDifferenceOrderCount(int $orderCount, int $changeCount) {

    }
} 
