<?php

use Core\Classes\Cart\Payment;
use Core\Classes\Utils\Utils;

$Payment = new Payment;

return [
    'tab' => [
        'is_main' => false,
    ],			
    'sql' => [
        'table_name' => 'data_td_accsess ',
        'col_list'	=> "*",
        'query' => array(
            'base_query' =>  " INNER JOIN payment_method_list ON payment_method_list.visible = 0  ",
            'body' =>  " ",
            "joins" => "  ",									  
            'sort_by' => " 	GROUP BY payment_method_list.id DESC  
                            ORDER BY payment_method_list.id DESC "
                        
        ),	
        'bindList' => array()
    ],
    'page_data_list' => [
        'sort_key' => 'id',
        'get_data' => [
            'id' => 'id',
            'payment_method_form' => 'title',
            'edit'	=> null
        ],
        'table_total_list' => [
        ],
        'modal' => [
            'template_block' => 'edit_modal',
            'modal_fields' => array(
                'modal_payment_method_id' => [
                    'db' 			=> 'id',
                    'custom_data' 	=> false, 
                    'premission' 	=> true								
                ],
                'edit_payment_method_name' => [
                    'db' 			=> 'title',
                    'custom_data' 	=> false, 
                    'premission' 	=> true								
                ],

                'edit_payment_method_tags' => [
                    'db' 			=> 'tags_id',
                    'custom_data' 	=> Utils::getTagsList(), 
                    'premission' 	=> true								
                ],

                'save_payment_method_info' => [
                    'db' 			=> false,
                    'custom_data' 	=> false, 
                    'premission' 	=> true								
                ],       
                
                'modal_delete_payment_method' => [
                    'db' 			=> 'id',
                    'custom_data' 	=> false, 
                    'premission' 	=> true	
                ]
            )
        ],
        'filter_fields' => [
        ],
        'form_fields_list' => array(				
        ),						
    ],
];