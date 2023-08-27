<?php 

return [
    'tab' => [
        'is_main' => false,       
    ],			
    'sql' => [
        'table_name' => ' user_control ',
        'col_list'	=> ' *, GROUP_CONCAT( DISTINCT stock_category.category_name SEPARATOR  " \n -- ") as product_category_list, 
                            GROUP_CONCAT( DISTINCT stock_provider.provider_name SEPARATOR  " \n -- ") as product_provider_list 
        ',
        'base_query' =>  "  INNER JOIN stock_list ON stock_list.stock_visible != 3  ",
        'param' => array(
            'query' => array(
                'param' =>  " AND stock_list.stock_visible = 0 AND IF (stock_list.stock_count > 0, stock_list.stock_count > 0, stock_list.stock_count < 0)  ",
                "joins" => "
                              LEFT JOIN products_provider_list ON products_provider_list.id_from_stock = stock_list.stock_id
                              LEFT JOIN products_category_list ON products_category_list.id_from_stock = stock_list.stock_id
                              
                              LEFT JOIN stock_provider ON stock_provider.provider_id = products_provider_list.id_from_provider
                              LEFT JOIN stock_category ON stock_category.category_id = products_category_list.id_from_category

                              LEFT JOIN stock_barcode_list ON stock_barcode_list.br_stock_id = stock_list.stock_id									 
                             
                              ",									  
                'bindList' => array(
                )
            ),
            'sort_by' => " 	GROUP BY stock_list.stock_id DESC  
                            ORDER BY stock_list.stock_id DESC ",
            'limit' => " "
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
            'provider' 			=> 'product_provider_list',
            'category'			=> 'product_category_list',	
            'stock_barcode'		=> 'barcode_value',
            'return_status' 	=> 'stock_return_status',
            'terminal_add_basket' => null,
            'terminal_basket_count_plus' => null,
        ],
        'table_total_list' => [
        ],
        'modal' => [
        ],
        'filter_fields' => [
        ]					
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