<?php

namespace core\classes\dbWrapper\traits;

use Core\Classes\System\Utils;

trait select
{

    public $result;
    
    /**
     * Делает запрос в базу данных
     * 
     * @param array $query - массив с данными таблицы
     */
    
    public function select(array $query, $pdo_fetch_type = \PDO::FETCH_ASSOC, string $placeholders = 'named')
    {

        /**
        *    $res = $db->select([
        *        'table_name' => 'stock_list',
        *        'col_list' => '*',
        *        'base_query' => '',
        *        'param' => [
        *            'query' => [
        *                'param' => '',
        *                'joins' => '',
        *                'bindList' => [
        *                    'param' => $param
        *                ]
        *            ],
        *            'sort_by' => '',
        *            'limit' => ''
        *        ],
        *    ])->get(); 
        **/
       

        $query_row = $query['query'];

        $conditions 		= [];
        $table_name 		= $query['table_name'] 				?? '';
        $col_list 			= $query['col_list'] 				?? '';
        $base_query 		= $query_row['base_query'] 				?? '';
        $body				= $query_row['body'] 		?? '';
        $joins				= $query_row['joins'] 		?? '';
        $sort_by			= $query_row['sort_by'] 			?? '';
        $limit				= $query_row['limit'] 				?? '';
        $bind_list			= $query['bindList'] 	?? array();
     
    
        $query  = "SELECT $col_list FROM $table_name ";
        $query .= $base_query;
        $query .= $body;
        $query .= $joins;
        $query .= $sort_by;
        $query .= $limit;
    
    

        $conditions = array_merge($conditions, $bind_list);
    
        $stock_view = $this->dbpdo->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL));
    
        if($placeholders == 'named') {
            foreach($conditions as $bind_key => $bindValue) {
                $stock_view->bindParam($bind_key, $bindValue);
            }
        
            $stock_view->execute();
        }
    
        if($placeholders == 'positional') {
            $stock_view->execute($conditions);
        }
    
        
        $this->result = $stock_view->fetchAll($pdo_fetch_type);
    
        $stock_view->closeCursor();
        

        return $this;
    }

    public function first()
    {
        $this->result = $this->result[0];
        return $this;
    }

    public function columnName(string $columnName)
    {
        $this->result = $this->result[$columnName];

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {  
        return (array) $this->result;
    }
}
