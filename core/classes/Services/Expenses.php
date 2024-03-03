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
    function getExpensesByDay($date) 
    {
        $res = $this->db->select([
            'table_name' => 'rasxod',
            'col_list' => ' sum(rasxod_money) as total_rasxod_money  ',
            'query' => [
                'base_query' => ' ',
                'body' => " WHERE rasxod_day_date = :mydaydate  AND rasxod_visible = 0",
                'joins' => "",
                'sort_by' => ' ORDER BY rasxod_id DESC '
            ],
            'bindList' => array(
                'mydaydate' => $date
            ),            
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
    public function getExpensesByMonth($month) 
    {
        $res = $this->db->select([
            'table_name' => 'rasxod',
            'col_list' => ' sum(rasxod_money) as total_rasxod_money  ',
            'query' => [
                'base_query' => ' ',
                'body' => " WHERE rasxod_year_date = :mydateyear  AND rasxod_visible = 0",
                'joins' => "",
                'sort_by' => ' ORDER BY rasxod_id DESC '
            ],
            'bindList' => array(
                'mydateyear' => $month
            )
        ])->get();
    
        return $res[0]['total_rasxod_money'];
    }    



    /**
     * Ищем расход по дате
     */
    public function seachExpensesByDate($date) 
    {
        $res = $this->db->select([
            'table_name' => 'rasxod',
            'col_list' => ' sum(rasxod_money) as total_rasxod_money  ',
            'query' => [
                'base_query' => ' ',
                'body' => " WHERE rasxod_year_date = :mydateyear OR rasxod_day_date = :mydateday  AND rasxod_visible = 0",
                'joins' => "",
                'sort_by' => ' ORDER BY rasxod_id DESC '
            ],
            'bindList' => array(
                'mydateyear' => $date,
                'mydateday' => $date,
            )
        ])->get();
    
        return $res[0]['total_rasxod_money'];
    }    


    /**
     * ПОлучить даты дневных расходов
     * @return array|null
     * 
     * old function name get_rasxod_day_list
     */
    public function getExpenseDayList() 
    {
        $res = $this->db->select([
            'table_name' => "rasxod",
            'col_list' => " DISTINCT rasxod_day_date ",
            'query' => [
                'base_query' => ' WHERE rasxod_visible = 0',
                'body' => "",
                'joins' => "",
                'sort_by' => " ORDER BY rasxod_id DESC "
            ],
            'bindList' => array()
        ])->get();
        
        $dd = array_column($res, 'rasxod_day_date');

        $dd['default'] = date("d.m.Y");

        return $dd;
    }

    /**
     * список месячных расходов
     * 
     * old function name get_rasxod_date_list
     */
    public function getExpenseMonthList() 
    {
        $res = $this->db->select([
            'table_name' => "rasxod",
            'col_list' => " DISTINCT rasxod_year_date ",
            'query' => [
                'base_query' => ' WHERE rasxod_visible = 0',
                'body' => "",
                'joins' => "",
                'sort_by' => " ORDER BY rasxod_id DESC "
            ],
            'bindList' => array()
        ])->get();
        
        $dd = array_column($res, 'rasxod_year_date');

        $dd['default'] = date("m.Y");

        return $dd;
    }    


    /**
     * Изменить расходы
     */
    public function editExpense($data) 
    {
        $option = [
            'before' => " UPDATE rasxod SET ",
            'after' => " WHERE rasxod_id  = :rasxod_id ",
            'post_list' => [
                //id
                'rasxod_id' => [ 
                    'query' => false,
                    'bind' => 'rasxod_id',
                    'require' => true
                ],	
                //изменить название категории
                'upd_rasxod_description' => [
                    'query' => "rasxod_description = :description_name",
                    'bind' => 'description_name',
                ],
                'upd_rasxod_amount' => [
                    'query' => 'rasxod_money = :amount',
                    'bind' => 'amount'
                ]
            ]
        ];
        
        return $this->db->update($option, $data);
    }

    /**
     * Удалить расхож
     */
    public function deleteExpense($expenseId) 
    {
        $update_data = [
            'before' => 'UPDATE rasxod SET ',
            'after' => ' WHERE rasxod_id = :rasxod_id ',
            'post_list' => [
                'id' => [
                    'query' => ' rasxod_visible = 1 ',
                    'bind' => 'rasxod_id',
                ]
            ]
        ];
    
        return $this->db->update($update_data, [
            'id' => $expenseId
        ]);        
    }

    /**
     * Добавить новый расход
     * 
     * old function name add_new_rasxod
     */
    public function addExpense($post_data) 
    {
        $data = [];
        $arr = [];

        $col_post_list = [
            'add_rasxod_description' => [
                'col_name' => 'rasxod_description',
                'required' => false
            ],
            'add_rasxod_sum' => [
                'col_name' => 'rasxod_money',
                'required'  => true,
            ]
        ];
        
    
        foreach ($col_post_list as $key => $value) {
            if(array_key_exists($key, $post_data)) {
                $data = array_merge($data, [
                    $value['col_name'] => $post_data[$key]
                ]);
            }
        }
    
        $default_data = [
            'rasxod_visible' => 'visible',
            'rasxod_day_date' => date('d.m.Y'),
            'rasxod_year_date' => date('m.Y')
        ];
    
        $data = array_merge($data, $default_data);
        
        $this->db->insert('rasxod', [$data]);
    
        return true;
    }    

}