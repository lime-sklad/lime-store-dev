<?php

namespace Core\Classes\Cart;

use core\classes\dbWrapper\db;
use Core\Classes\Utils\Utils;

use Core\Classes\System\Init;

class Payment 
{
    private $db;
    private $init;

    public function __construct()
    {
        $this->db = new db;
        $this->init = new Init;
    }

   /**
     * Получить список способов оплаты
     * @return array|null
     * old function name get_payment_method_list()
    */
    public function getPaymentMethodList() 
    {
        return $this->db->select([
            'table_name' => 'payment_method_list',
            'col_list' => 'id AS custom_data_id, title AS custom_value, visible, tags_id ',
            'query' => [
                'base_query' => ' WHERE visible = 0 ',
                'sort_by' => '  ORDER BY freeze DESC, id '
            ]
        ])->get();
    }


    /**
     * 
     */
    public function getPaymentMethodTags($user_payment_list, $default_tags = null)
    {
        $default_data = Utils::getTagsList();

        $data_arr = $this->getPaymentMethodList();
        
        // если нужно вывести только добавленные в базу теги способы оплаты 
        if(!empty($user_payment_list) && empty($default_tags)) {
    
            $result = array_reduce($data_arr, function($carry, $item) use ($default_data) {
                foreach($default_data as $default_key => $default_val) {
                    if($item['tags_id'] == $default_val['tags_id']) {
                        $carry[] = array_merge($item, $default_data[$default_key]);
                    } 	
                }
                
                return $carry;
            }, []);
    
            return $result;
        }
    
    
        // если нужно вывести определенны тег (способ оплаты)
        if(!empty($default_tags)) {
            $default_tags_data = [];
    
            if($user_payment_list) {
                $default_tags_data = $data_arr;
            } else {
                $default_tags_data = $default_data;
            }
    
            return array_reduce($default_tags_data, function($carry, $item) use ($default_tags) { 
                    if($item['tags_id'] == $default_tags) {
                        $carry = $item;
                    }
    
    
                    if(!empty($carry)) {
                        return $carry;
                    }
    
                    // если такого тега не найдено
                    return [
                        'tags_id' => 'gray',
                        'class_list' => ' mark-tags mark-default width-100 height-100'
                    ];
            }, []);
            
        }
    }


    /**
     * 
     */
    public function addPaymentMethod($title, $tags_key)
    {
        return $this->db->insert('payment_method_list', [
            [
                'title' => $title,
                'tags_id' => $tags_key
            ]
        ]);
    }


    /**
     * 
     */
    public function editPaymentMethod($data)
    {
        $option = [
            'before' => ' UPDATE payment_method_list SET ',
            'after' => ' WHERE id = :id ',
            'post_list' => [
                'payment_method_id' => [
                    'query' => false,
                    'bind' => 'id',
                    'require' => true,
                ],
                'edit_payment_method_name' => [
                    'query' => ' payment_method_list.title = :title ',
                    'bind' => 'title',
                    'require' => false
                ],
                'change_payment_method_tags_id' => [
                    'query' => ' payment_method_list.tags_id = :tag_id',
                    'bind' => 'tag_id',
                    'require' => false
                ]
            ]
        ];
        
        return $this->db->update($option, $data); 
    }


    /**
     * 
     */
    public function deletePaymentMethod($data)
    {
        $option = [
            'before' => ' UPDATE payment_method_list SET ',
            'after' => ' WHERE id = :id ',
            'post_list' => [
                'payment_method_id' => [
                    'query' => ' visible = 1 ',
                    'bind' => 'id',
                    'require' => true,
                ],
            ]
        ];
        
        return $this->db->update($option, $data);    
    }

    /**
     * Вывести последную добавленнй способ опоаты 
     */
    public function getLastAddedPaymentMethod()
    {
        $controllerIndex = Utils::getPostPage();

		$this_data = $this->init->getControllerData($controllerIndex)->allData;

		$page_config = $this_data['page_data_list'];

		$this_data['sql']['query']['sort_by'] = " GROUP BY payment_method_list.id DESC ORDER BY payment_method_list.id DESC LIMIT 1";

        return $this->db->select($this_data['sql'])->get();
    }    
}