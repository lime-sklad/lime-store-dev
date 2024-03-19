<?php 
return [
    'tab' => [
        'is_main' => false,
        'title'		 		=> 'Kategoriya',
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
                'tab_category_form'
            ],
            'active' => 'tab_category_form'
        )
    ],			
    'sql' => [
        'table_name' => ' stock_category as tb ',
        'col_list'	=> '*',
        'query' => array(
            'base_query' =>  " INNER JOIN stock_category ",
            'body' => ' ON stock_category.visible = "visible" ',
            'sort_by' => " GROUP BY stock_category.category_id DESC 
                           ORDER BY stock_category.category_id DESC "
        ),
        'bindList' => array()        
    ],
    'page_data_list' => [
        'sort_key' => 'category_id',
        'get_data' => [
            'id' => 'category_id',
            'category_name' => 'category_name',
            'edit'	   => null
        ],
        'table_total_list'	=> [
        ],
        'modal' => [
            'template_block' => 'edit_modal',
            'modal_fields' => array(
                'category_id' => [
                    'db' 			=> 'category_id', 
                    'custom_data' 	=> false, 
                    'premission' 	=> true
                ],
                'category_name' => [
                    'db' 			=> 'category_name',
                    'custom_data'	=> false,
                    'premission'	=> true
                ],

                'save_category' => [
                    'db' 			=> false,
                    'custom_data'	=> false,
                    'premission'	=> true
                ],
                
                'delete_category' => [
                    'db' 			=> 'category_id',
                    'custom_data'	=> false,
                    'premission'	=> true	
                ],
					 
            )	
        ],
        'filter_fields' => [
        ],
        'form_fields_list' => array(
            [
                'block_name' => 'add_category_name',
            ],
            [
                'block_name' => 'add_save_category',
            ],					
        ),					
    ]
];