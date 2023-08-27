<?php 

return [
    'tab' => [
        'is_main' => true,
        'title' 			=> 'Satış',
        'icon'				=> [
            'img_big'		 	=> 'img/svg/sidebar/1.svg',
            'img_small'			=> 'img/svg-icon/sidebar/1.svg',
            'modify_class' 		=> 'las la-cart-arrow-down'
        ],
        'link'  			=> '/page/base.php',
        'template_src'      => 'page/base_tpl.twig',
        'background_color'  => 'rgba(0, 150, 136, 0.1)',
        'tab' => array(
            'list' => [
                'tab_cart',
                'tab_terminal_phone',
            ],
            'active' => 'tab_cart'
        )
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
            'limit' => " LIMIT 50 "
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
            'stock_count',
            'search_count',
        ],
        'modal' => [
            'template_block' => 'info_product',
            'modal_fields' => array(
                'info_product_name' => [
                    'db' => 'stock_name',
                    'custom_data' => false,
                    'premission' => true
                ],
                'info_product_description' => [
                    'db' => 'stock_phone_imei',
                    'custom_data' => false,
                    'premission' => true
                ],
                'info_product_count' => [
                    'db' => 'stock_count',
                    'custom_data' => false,
                    'premission' => true
                ],
                'info_product_category' => [
                    'db' => 'category_name',
                    'custom_data' => false,
                    'premission' => true
                ],						
                'info_product_provider' => [
                    'db' => 'provider_name',
                    'custom_data' => false,
                    'premission' => true
                ],						
                'info_product_first_price' => [
                    'db' => 'stock_first_price',
                    'custom_data' => false,
                    'premission' => is_data_access_available('th_buy_price')
                ],
                'info_product_second_price' => [
                    'db' => 'stock_second_price',
                    'custom_data' => false,
                    'premission' => true
                ],
                'info_product_count' => [
                    'db' => 'stock_count',
                    'custom_data' => false,
                    'premission' => true
                ],
                'info_product_min_quantity' => [
                    'db' => 'min_quantity_stock',
                    'custom_data' => false,
                    'premission' => true
                ],
                'info_product_filter_list' => [
                    'db' => 'stock_id',
                    'custom_data' => false,
                    'premission' => true
                ],
                'info_product_add_date' => [
                    'db' => 'stock_get_fdate',
                    'custom_data' => false,
                    'premission' => true
                ]
            )
        ],
        'filter_fields' => [
            // 'color',
            // 'used',
            // 'storage',
            // 'ram',
            // 'brand'
        ]					
    ],

];