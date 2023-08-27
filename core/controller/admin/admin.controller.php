<?php 
return [
    'tab' => [
        'is_main' => true,
        'title'		 		=> 'Admin',
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
                'tab_admin',
                'tab_create_warehouse',
                'tab_category_form',
                'tab_provider_form',
                'tab_filter_form',
                'tab_setting'
            ],
            'active' => 'tab_admin'	
        )
    ],			
    'sql' => [
        'table_name' => 'user_control as tb',
        'col_list'	=> '*',
        'base_query' =>  "",
        'param' => array(
            'query' => array(
                'param' => " WHERE user_visible = 0 ",
                "joins" => " ",		
                'bindList' => array(
                )
            ),
            'sort_by' => " ORDER BY user_id DESC "
        ),	
    ],
    'page_data_list' => [
        'sort_key' => 'user_id',
        'get_data' => [
            'seller_id'			=> 'user_id',
            'seller_name' 		=> 'user_name',
            'seller_password' 	=> 'user_password',
            'seller_role' 		=> 'user_role',
            'seller_edit'			=> null
        ],
        'table_total_list'	=> [	
        ],
        'modal' => [
            'template_block' => 'edit_user',
            'modal_fields' => array(
                'seller_id' => [
                    'db' 			=> 'user_id', 
                    'custom_data' 	=> false,
                    'premission' 	=> true
                ],
                'seller_name' => [
                    'db' 			=> 'user_name',
                    'custom_data' 	=> 'false',
                    'premission'	=> true
                ],
                'seller_password' => [
                    'db' 			=> 'user_password',
                    'custom_data' 	=> 'false',
                    'premission'	=> is_data_access_available('th_admin_password')
                ],
                'save_seller_info' => [
                    'db'  => false,
                    'custom_data' => false,
                    'premission' => true
                ],
                'delete_seller' => [
                    'db'  => 'user_id',
                    'custom_data' => false,
                    'premission' => true
                ]                
            )
        ],
        'filter_fields' => [
        ],
    ]
];