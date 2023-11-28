<?php 
namespace core\classes;

class report extends \core\classes\dbWrapper\db {
    /**
     * @param int $id  id отчета
     * @return array
     *  Получить отчет по id
     */
    public function getById(int $id) {
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


    public function edit($data) {
        $option = [
            'before' => 'UPDATE stock_order_report JOIN stock_list ON stock_list.stock_id = stock_order_report.stock_id SET',
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
                'report_edit_order_count' => [
                    'query' => ' stock_list.stock_count = stock_list.stock_count + stock_order_report.order_stock_count,
                                stock_order_report.order_stock_count = :changeCount,
                                stock_list.stock_count = stock_list.stock_count - stock_order_report.order_stock_count
                    
                    ',
                    'bind' => 'changeCount',
                    'require' => false
                ]
            ]
        ];

        $this->update($option, $data);
               
    }


    public function getDifferenceOrderCount(int $orderCount, int $changeCount) {

    }
} 
