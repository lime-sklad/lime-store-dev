<?php

namespace core\classes\dbWrapper\traits;

trait insert
{
	/**
	 * 	Певрвый аргуемнт название таблицы
	 * 	Второй аргумент массив с данными которые будем добавлять в базу
	 * 	Структура массива с данными:
	 * @param data = [
	 * 			array(
	 * 				'Название столбца' => 'Значение',
	 * 				'Название столбца 2' => 'Значение 2'
	 * 			)
	 * 		];
	 * 
	 *	Добавлять в базу можно сразу несколько записей, нужно просто в массив $data
	 *	добавить несколько массивов как в примере выше:
	 * 
	 * @param data = [
	 * 			array(
	 * 				'Название столбца первая запись' => ' Первое Значение',
	 * 				'Название столбца #2 первая запись ' => 'Первое Значение #2'
	 * 			),
	 * 			array(
	 * 				'Название столбца вторая запись' => ' Второе Значение',
	 * 				'Название столбца #2 вторая запись ' => 'Второе Значение #2'
	 * 			)  
	 * 		];
	 * 
	 *  
	 * 
	 */    
    public function insert($table_name, $data) 
    {
        $col_names_list = array_keys($data[array_key_first($data)]);
        $col_names_list = implode(",", $col_names_list);
        $toBind = array();
        $valusList = array();
        $sql_val = [];
        foreach($data as $index => $row) {
            $params = array();
            
            foreach($row as $col_name => $value) {
                $params[] = '?';
                $toBind[] = $value;
            }
    
            $sql_val[] = "(" . implode(", ", $params) .")";
        }
    
        $sql_values =  implode(", ", $sql_val);
    
        try {
            $query = "INSERT INTO $table_name ($col_names_list) VALUES $sql_values";
            
            $stmt = $this->dbpdo->prepare($query);
            $stmt->execute($toBind);
    
        } catch(\PDOException $e) {
            echo json_encode([
                'type' => 'error',
                'text'	=> 'Ошибка' . $e
            ]);		
        }
 
    }    
}