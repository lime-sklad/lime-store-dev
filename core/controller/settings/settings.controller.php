<?php 

return  [
    'tab' => [
        'is_main' => false,
        'title'		 		=> 'Setting',
        'icon'				=> [
            'img_big'		 	=> 'img/svg/070-file hosting.svg',
            'img_small'			=> '',
            'modify_class' 		=> 'las la-user-cog'
        ],
        'link'  			=> '/page/base.php',		
        'template_src'      => '/page/base_tpl.twig',
        'background_color'  => 'rgba(72, 61, 139, 0.1)',
        'tab' => array(
            'list' => [
                'tab_setting'
            ],
            'active' => 'tab_setting'
        )
    ],			
    'sql' => [
        'table_name' => ' user_control as tb',
        'col_list'	=> '*',
        'base_query' =>  " INNER JOIN user_control ",
        'param' => array(
            'query' => array(
                'param' => ' ',
                "joins" => " ",		
                'bindList' => array(
                )
            ),
            'sort_by' => " "
        ),	
    ],
    'page_data_list' => [
        'sort_key' => 'setting_id',
        'get_data' => [
            'id' => 'setting_id',
            'description' => 'setting_title',
            'edit'	   => null
        ],
        'table_total_list'	=> [
        ],
        'modal' => [
            'template_block' => 'edit_modal',
            'modal_fields' => array(
                'id' => [
                    'db' 			=> 'setting_id', 
                    'custom_data' 	=> false, 
                    'premission' 	=> true
                ],
                'edit_stock_name' => [
                    'db' 			=> 'setting_title',
                    'custom_data'	=> false,
                    'premission'	=> true
                ],
                'save_category' => [
                    'db' 			=> false,
                    'custom_data'	=> false,
                    'premission'	=> true
                ]												 
            )	
        ],
        'filter_fields' => [
        ],
        'form_fields_list' => array(				
        ),					
    ]
];