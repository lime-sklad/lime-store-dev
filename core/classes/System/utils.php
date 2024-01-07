<?php

namespace core\classes\system;

class utils extends \core\classes\dbWrapper\db 
{


   /**
     * old function name get_payment_method_list()
     * 
     * 
     */
    public function getPaymentMethodList() 
    {
        return $this->select([
            'table_name' => 'payment_method_list',
            'col_list' => 'id AS custom_data_id, title AS custom_value, visible, tags_id ',
            'base_query' => ' WHERE visible = 0 ',
            'param' => [
                'sort_by' => '  ORDER BY freeze DESC, id '
            ]
        ])->get();
    }


    /**
     * 
     * 
     * 
     */
    public function getTagsList($user_payment_list, $default_tags = null) 
    {
        $default_data = [
            [
                'tags_id' => 'success',
                'class_list' => 'mark mark-tags mark-success-fill width-100 height-100',
            ],
            [
                'tags_id' => 'success-light',
                'class_list' => 'mark mark-tags mark-success width-100 height-100',
            ],
            [
                'tags_id' => 'danger',
                'class_list' => 'mark mark-tags mark-danger-fill width-100 height-100'
            ],
            [
                'tags_id' => 'danger-light',
                'class_list' => 'mark mark-tags mark-danger width-100 height-100'
            ],		
            [
                'tags_id' => 'rose',
                'class_list' => 'mark mark mark-tags mark-rose width-100 height-100'
            ],		
            [
                'tags_id' => 'warning', 
                'class_list' => 'mark mark-tags mark-warning width-100 height-100'
            ],
            [
                'tags_id' => 'primary',                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                'class_list' => 'mark mark-tags mark-primary width-100 height-100'
            ],
            [
                'tags_id' => 'black',
                'class_list' => 'mark mark-tags mark-black-fill width-100 height-100'
            ],
            [
                'tags_id' => 'blue',
                'class_list' => 'mark mark-tags mark-blue-fill width-100 height-100'
            ],
            [
                'tags_id' => 'gray',
                'class_list' => 'mark mark-tags mark-gray width-100 height-100'
            ]
        ];
        
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
    
        // если нужно вывести только теги 
        return $default_data;
    }    
}