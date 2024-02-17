<?php

namespace core\classes\dbWrapper\traits;

trait update 
{
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
    public function update($option, $data) 
    {
        $before 	= $option['before'];
        $after 		= $option['after'];
        $post_list  = $option['post_list'];
        $conditions = [];
    
        foreach($post_list as $post_key => $post_value) {
            if(array_key_exists($post_key, $data)) {
                if(array_key_exists('require', $post_value)) {
                    if(empty($data[$post_key])) {
                        return json_encode([
                            'type' => 'error', 
                            'text' => 'Заполните все обязательные поля!'
                        ]);
                    }
                }            
    
                if($post_value['query']) {
                    $conditions[] = $post_value['query'];
                }
                
                // ужас, я не знаю что делает эта штука и зачем я ее написал
                if($post_value['bind']) {
                    if(is_array($post_value['bind'])) {
                        foreach ($post_value['bind'] as $k => $v) {
                            $bind_list[$v] = $data[$post_key];
                        }
                    } else {
                        $bind_list[$post_value['bind']] = $data[$post_key];
                    }

                }
            }
        }
    
        // echo "<pre>";
        // var_dump($bind_list);   
        // echo "</pre>";    
    
        $query = $before;
        if($conditions) {
            $conditions = implode(", ", $conditions);
            $query .= $conditions;
        }
        $query .= $after;
            
        try {
            $update = $this->dbpdo->prepare($query);
        
            foreach($bind_list as $bind_key => $bind_value) {
                $update->bindValue($bind_key, $bind_value);
            }
            $update->execute();
    
        
            return json_encode([
                'type' => 'success',
                'text' => 'ok'
            ]);
        } catch(\PDOException $e) {
            return json_encode([
                'type' => 'error',
                'text' => 'Ошибка' . $e
            ]);
        }        
    }
}