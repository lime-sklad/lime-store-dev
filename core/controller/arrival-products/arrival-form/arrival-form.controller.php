<?php 
return [
    'tab' => [
        'is_main' => true,
        'title'		 		=> 'Alış fakturası',
        'icon'				=> [    
            'modify_class' 		=> 'las la-warehouse'
        ],
        'link'  			=> '/page/base.php',		
        'template_src'      => '/page/base_tpl.twig',
        'background_color'  => 'rgba(72, 61, 139, .1)',
        'tab' => array(
            'list' => [
                'tab_arrival_products',
                'tab_arrival_report'
            ],
            'active' => 'tab_arrival_products'			
        )
    ],			
    'sql' => [
        'table_name' => ' user_control  ',
        'col_list'	=> ' * ',
        'base_query' =>  " INNER JOIN stock_list ON stock_list.stock_id != 0 ",
        'param' => array(
            'query' => array(
                'param' =>  " AND stock_list.stock_visible = 0 ",
                "joins" => " LEFT JOIN stock_barcode_list ON stock_barcode_list.br_stock_id = stock_list.stock_id ",		
                'bindList' => array(						
                )
            ),
            'sort_by' => " GROUP BY stock_list.stock_id  DESC ORDER BY  stock_list.stock_id DESC
                             ",
            'limit' => '',
        ),
    ],
    'page_data_list' => [
        'sort_key' => 'stock_id',
        'get_data' => [
            'id' 				=> 'stock_id',
            'name'			 	=> 'stock_name',
            'description' 		=> 'stock_phone_imei',
            'first_price'		=> 'stock_first_price',
            'second_price' 		=> 'stock_second_price',
            'count'				=> 'stock_count',
            'stock_barcode'		=> 'barcode_value',
        ],
        'table_total_list'	=> [
            'stock_count',
            'sum_first_price'
        ],
        'modal' => [
            'template_block' => 'edit_product',
            'modal_fields' => array(			
            )					
        ],
        'filter_fields' => [
        ],
        'form_fields_list' => array(
        )

    ],
    'component_config' => [
        'search' => [
            'input_class' 	 => 'search-auto area-input', 	//классы поля ввода поиска
            'parent_class'	 => 'cart-search-container-width', 			//класс для родителя инпута
            'input_placeholder' => 'Axtar', //заполнить/оставить пустым или
            'reset' => false, 
            'input_icon' => [
                'icon' => 'la-search',
            ],
            'widget_class_list' => '',
            'widget_container_class_list' => 'flex-cntr',
            'autocomplete' 	 => array(
                'type' => 'button',
                'parent_modify_class' => '',
                'autocomlete_class_list' => 'get_item_by_filter auto-add-to-cart '
            )            
        ]
    ]
];