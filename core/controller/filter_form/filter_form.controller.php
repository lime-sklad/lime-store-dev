<?php 

return [
    'tab' => [
        'is_main' => false,
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
                'tab_filter_form',
            ],
            'active' => 'tab_filter_form'
        )
    ],			
    'sql' => [
        'table_name' => 'filter_list as tb',
        'col_list'	=> "*",
        'base_query' =>  " INNER JOIN filter_list ON filter_list.filter_list_visible !=1  ",
        'param' => array(
            'query' => array(
                'param' =>  " ",
                "joins" => " LEFT JOIN `filter` ON `filter`.filter_type = filter_list.id ",									  
                'bindList' => array(
                )
            ),
            'sort_by' => " 	GROUP BY filter_list.id DESC  
                            ORDER BY filter_list.id DESC "
        ),	
    ],
    'page_data_list' => [
        'sort_key' => 'id',
        'get_data' => [
            'id' => 'id',
            'td_filters_title' => 'filter_list_title',
            'edit'	=> null
        ],
        'table_total_list' => [
        ],
        'modal' => [
            'template_block' => 'edit_modal',
            'modal_fields' => array(
                'eidt_filter_name' => [
                    'db' 			=> 'filter_list_title',
                    'custom_data' 	=> false, 
                    'premission' 	=> true								
                ],
                'edit_filter_option' => [
                    'db' 			=> false,
                    'custom_data' 	=> false,
                    'user_function' => [
                        'function_name' => 'get_filter_option_list_by_id',
                        'function_args' => 'id',
                    ],
                    'premission' 	=> true,
                ],
                'edit_delete_filter' => [
                    'db' 			=> 'id',
                    'custom_data' 	=> false, 
                    'premission' 	=> true	
                ],
                'edit_save_filter' => [
                    'db' 			=> false,
                    'custom_data' 	=> false, 
                    'premission' 	=> true	
                ],																	
            )
        ],
        'filter_fields' => [
        ],
        'form_fields_list' => array(				
        ),						
    ],
];