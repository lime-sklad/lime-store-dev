<?php 

/**
 * получить строки из базы данных 
 * @param array $query
 * @param CONSTANT PDO::FETCH_ASSOC / FETCH_BOTH ...
 * $query = array(
 * 	'table_name' => //название таблицы !! обьязательный параметр
 *  'col_list' => //название столбцов !! обьязательный параметр
 *  'base_query' => //начальный
 * ); 
 */
function ls_db_request($query, $pdo_fetch_type = PDO::FETCH_ASSOC, $placeholders = 'named') {
	global $dbpdo;

	$param_row = $query['param'];
	// ls_var_dump($query);


	$result 			= [];
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

	$stock_view = $dbpdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

	if($placeholders == 'named') {
		foreach($conditions as $bind_key => $bindValue) {
			$stock_view->bindParam($bind_key, $bindValue);
		}
	
		$stock_view->execute();
	}

	if($placeholders == 'positional') {
		$stock_view->execute($conditions);
	}


	// while ($row = $stock_view->fetch($pdo_fetch_type)) {
	// 	$result[] = $row;
	// }
	
	$result = $stock_view->fetchAll($pdo_fetch_type);

	$stock_view->closeCursor();
	

	return  $result;	
}

function ls_db_upadte($option, $data) {
	/**
	 * Первым аргументом передаём массив с настройками запрса: 
	 * 	@param option = [
	 *         'before' => " UPDATE stock_list SET ",
	 *         'after' => " WHERE stock_id = :stock_id",
	 *         'post_list' => [
	 *             'stock_id' => [
	 *                 'query' => false,
	 *                 'bind' => 'stock_id'
	 *             ],
	 *             'order_stock_count' => [
	 *                 'query' => "stock_list.stock_count = stock_list.stock_count - :product_count",
	 *                 'bind' => 'product_count'
	 *             ]
	 *         ]  
	 *      ];
	 * 
	 *  	before - Тут указываем название таблицы
	 * 		after - тут указываем что будет в запросе после перечесления SET
	 * 		post_list - это массив в котором мы указываем массив с индексом из второго аргумента $data
	 * 			индекс напрмер как в примере выше stock_id это ключ из массива $data, мы указываем какое значение взять из data
	 * 			указывая его ключ. Далле в query - указываем сам запрос, что обновить и какой столбец. В bind указываем название бинда котору
	 * 			мы указали выше в запросе query
	 * 		
	 * 		$data это массив с данными которые будут добавлены в таблицу
	 * 		массив должен иметь такую структуру
	 * 		@param data = array(
	 * 					'stock_id' => 777,
	 * 					'order_stock_count' => 'some count'
	 * 				); 
	 *  
	 * */	 
	
	global $dbpdo;

	$before 	= $option['before'];
	$after 		= $option['after'];
	$post_list  = $option['post_list'];
	$conditions = [];

	foreach($post_list as $post_key => $post_value) {
		if(array_key_exists($post_key, $data)) {
			if(array_key_exists('require', $post_value)) {
				if(empty($data[$post_key])) {
					return json_encode([
						'error' => 'Заполните все обязательные поля!'
					]);
				}
			}

			if($post_value['query']) {
				$conditions[] = $post_value['query'];
			}
			
			// ужас, я не знаю что делает эта штука и зачем я ее написал
			if($post_value['bind']) {
				$bind_list[$post_value['bind']] = $data[$post_key];
			}
		}
	}


	$query = $before;
	if($conditions) {
		$conditions = implode(", ", $conditions);
		$query .= $conditions;
	}
	$query .= $after;
	
	try {
		$update = $dbpdo->prepare($query);
	
		foreach($bind_list as $bind_key => $bind_value) {
			$update->bindValue($bind_key, $bind_value);
		}
		$update->execute();

	
		return json_encode([
			'type' => 'success',
			'text' => 'ok'
		]);
	} catch(PDOException $e) {
		return json_encode([
			'type' => 'error',
			'text' => 'Ошибка' . $e
		]);
	}
}

function ls_db_insert($table_name, $data) {
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

	global $dbpdo;

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
		
		$stmt = $dbpdo->prepare($query);
		$stmt->execute($toBind);

	} catch(PDOException $e) {
		echo json_encode([
			'type' => 'error',
			'text'	=> 'Ошибка' . $e
		]);		
	}

}



/**
 * удаление
 * @param array $data_list массив с данными
 * @param var $dbpdo db connetion
 */
 function ls_db_delete($data_list) {
	/**
	*  @param array $data_list = 
	*	array(
	*		'table_name' => 'cart',
	*		'joins'	=> '',
	*		'where' => ' (c_sotck_id)  IN (:id2) ',
	*		'bindList' => [
	*			':id2' => 2,
	*		],
	*		'order' => null,
	*	)
	*/
	
	global $dbpdo;

	foreach($data_list as $data) {
		$table_name 		= array_key_exists('table_name', $data) 	? $data['table_name'] 	: null;
		$joins 				= array_key_exists('joins', $data)			? $data['joins'] 		: null;
		$where 				= array_key_exists('where', $data)			? $data['where'] 		: null;
		$bind_list 			= array_key_exists('bindList', $data)		? $data['bindList'] 	: null;
		$order 				= array_key_exists('order', $data)			? $data['order'] 		: null;

		$delete = $dbpdo->prepare("DELETE $table_name FROM $table_name $joins WHERE $where $order");
		// ls_var_dump($delete);
		$delete->execute($bind_list);	

	}
 }