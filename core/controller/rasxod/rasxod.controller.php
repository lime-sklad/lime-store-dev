<?php 
return [
    'tab' => [
        'is_main' => true,
        'title' 			=> 'Xərclər',
        'icon'				=> [
            'img_big'		 	=> '',
            'img_small'			=> '',
            'modify_class' 		=> 'la la-money'
        ],
        'link'  			=> '/page/base.php',
        'template_src'      => 'page/base_tpl.twig',
        'background_color'  => '',
        'tab' => array(
            'list' => [
                'tab_day_rasxod',
                'tab_rasxod',
                'tab_rasxod_form'
            ],
            'active' => 'tab_day_rasxod'
        )
    ],			
    'sql' => [
        'table_name' => ' user_control ',
        'col_list'	=> "*",
        'query' => array(
            'base_query' =>  " INNER JOIN rasxod ON rasxod.rasxod_visible !=1  ",
            'body' =>  " ",
            "joins" => " ",									  
            'sort_by' => " 	GROUP BY rasxod.rasxod_id DESC  
                            ORDER BY rasxod.rasxod_id DESC 
            ",
        'bindList' => array()
        ),	
    ],
    'page_data_list' => [
        'sort_key' => 'rasxod_id',
        'get_data' => [
            'id' 					=> 'rasxod_id',
            'rasxod_date'			=> 'rasxod_year_date',
            'rasxod_day_date'		=> 'rasxod_day_date',
            'rasxod_description'	=> 'rasxod_description',
            'rasxod_amount'			=> 'rasxod_money',
            'edit'					=> null
        ],
        'table_total_list' => [
            'sum_total_rasxod'
        ],
        'modal' => [
            'template_block' => 'info_product',
            'modal_fields' => array(
                'edit_rasxod_id' => [
                    'db' 			=> 'rasxod_id',
                    'custom_data' 	=> false, 
                    'premission' 	=> true								
                ],
                'edit_rasxod_description' => [
                    'db' 			=> 'rasxod_description',
                    'custom_data' 	=> false, 
                    'premission' 	=> true							
                ],
                'edit_rasxod_amount' => [
                    'db'		  	=> 'rasxod_money',
                    'custom_data' 	=> false,
                    'premission'  	=> true
                ],
                'delete_rasxod' => [
                    'db' 			=> 'rasxod_id',
                    'custom_data' 	=> false, 
                    'premission' 	=> true	
                ],
                'save_rasxod' => [
                    'db' 			=> false,
                    'custom_data' 	=> false, 
                    'premission' 	=> true	
                ]
            )
        ],
        'filter_fields' => [
        ],
        'form_fields_list' => array(
            [
                'block_name' => 'add_rasxod_description',
            ],
            [
                'block_name' => 'add_rasxod_amount'
            ],
            [
                'block_name' => 'add_save_rasxod',
            ],					
        ),						
    ],
];