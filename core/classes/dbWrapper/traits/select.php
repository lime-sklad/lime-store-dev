<?php

namespace core\classes\dbWrapper\traits;

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

        $param_row = $query['param'];

        $conditions 		= [];
        $table_name 		= $query['table_name'] 				?? '';
        $col_list 			= $query['col_list'] 				?? '';
        $base_query 		= $query['base_query'] 				?? '';
        $param				= $param_row['query']['param'] 		?? '';
        $joins				= $param_row['query']['joins'] 		?? '';
        $bind_list			= $param_row['query']['bindList'] 	?? array();
        $sort_by			= $param_row['sort_by'] 			?? '';
        $limit				= $param_row['limit'] 				?? '';
     
    
        $query  = "SELECT $col_list FROM $table_name ";
        $query .= $base_query;
        $query .= $param;
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
