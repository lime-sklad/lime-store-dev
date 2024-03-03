<?php

namespace Core\Classes\Utils;
use core\classes\dbWrapper\db;

class Charts 
{
    private $db;

    public function __construct()
    {
        $this->db = new DB;    
    }


    /**
     * 
     */
    public function getReportChartList()
    {
        $data = $this->db->select([
            'table_name' => 'stock_order_report',
            'col_list' => "  order_my_date as smonth , SUM(order_total_profit) AS total_profit ",
            'query' => [
                'base_query' => '',
                'body' => " WHERE order_real_time >= DATE_SUB(NOW(), INTERVAL 24 MONTH) AND stock_order_visible = 0 ",
                'sort_by' => ' GROUP BY smonth ASC ORDER BY order_real_time ASC'
            ],
            'bindList' => [],
        ])->get();     
        

        $date_list = [];
        $sum_list = [];
        
        foreach ($data as $key => $val) {
            $date_list[] = $val['smonth'];
            $sum_list[] = $val['total_profit'];
        }        

        return [
            'date_list' => $date_list, 
            'sum_list' => $sum_list
        ];
    }


    /**
     * Выводим данные для графика
     * @param array $data массив с данными
     * @param string $labelName Название столбца 
     * @param string $sumName Название столбца суммы
     */
    public function getPieChartsData(array $data, string $labelName, string $sumName)
    {
        $label_list = [];
        $sum_list = [];
        
        foreach ($data as $key => $val) {
            $label_list[] = $val[$labelName];
            $sum_list[] = $val[$sumName];
        }

        return [
            'label_list' => $label_list, 
            'sum_list' => $sum_list
        ];
    }
}