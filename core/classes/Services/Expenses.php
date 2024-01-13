<?php
namespace Core\Classes\Services;


use core\classes\dbWrapper\db;

class Expenses
{
    private $db;

    public function __construct()
    {
        $this->db = new DB;
    }


    /**
     * получить сумму расхода по конкретной дате
     * @param string $date
     * @return int|null
     * 
     * old function name get_today_total_rasxod
     */
    function getExpensesByDate($date) 
    {
        $res = $this->db->select([
            'table_name' => 'rasxod',
            'col_list' => ' sum(rasxod_money) as total_rasxod_money  ',
            'base_query' => ' ',
            'param' => [
                'query' => [
                    'param' => " WHERE rasxod_day_date = :mydaydate  AND rasxod_visible = 0",
                    'joins' => "",
                    'bindList' => array(
                        'mydaydate' => $date
                    )
                ],
                'sort_by' => ' ORDER BY rasxod_id DESC '
            ]
        ])->get();
    
        return $res[0]['total_rasxod_money'];
    }



    /**
     * получить сумму расхода по месяцу
     * @param string $month
     * @return int|null
     * 
     * old function name get_total_rasxod
     */    
    public function getExpensesByMonth($month) {
        $res = $this->db->select([
            'table_name' => 'rasxod',
            'col_list' => ' sum(rasxod_money) as total_rasxod_money  ',
            'base_query' => ' ',
            'param' => [
                'query' => [
                    'param' => " WHERE rasxod_year_date = :mydateyear  AND rasxod_visible = 0",
                    'joins' => "",
                    'bindList' => array(
                        'mydateyear' => $month
                    )
                ],
                'sort_by' => ' ORDER BY rasxod_id DESC '
            ]
        ])->get();
    
        return $res[0]['total_rasxod_money'];
    }    
}