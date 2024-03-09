<?php

namespace core\classes\dbWrapper\traits;

trait delete 
{
    /**
     * удаление
     * @param array $data_list массив с данными
     */
    public function delete($data_list) 
    {
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

        foreach($data_list as $data) {
            $table_name 		= array_key_exists('table_name', $data) 	? $data['table_name'] 	: null;
            $joins 				= array_key_exists('joins', $data)			? $data['joins'] 		: null;
            $where 				= array_key_exists('where', $data)			? $data['where'] 		: null;
            $bind_list 			= array_key_exists('bindList', $data)		? $data['bindList'] 	: null;
            $order 				= array_key_exists('order', $data)			? $data['order'] 		: null;

            $delete = $this->dbpdo->prepare("DELETE $table_name FROM $table_name $joins WHERE $where $order");
            $delete->execute($bind_list);	
        }
    }    
}