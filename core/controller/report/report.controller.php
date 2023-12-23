<?php 
return [
    'tab' => [
        'is_main' => true,
        'title'		 		=> 'Hesabat',
        'icon'				=> [
            'img_big'		 	=> 'img/svg/070-file hosting.svg',
            'img_small'			=> '',
            'modify_class' 		=> 'las las la-donate'
        ],
        'link'  			=> '/page/base.php',		
        'template_src'      => '/page/base_tpl.twig',
        'background_color'  => 'rgba(72, 61, 139, 0.1)',
        'tab' => array(
            'list' => [
                'tab_report_day',
                'tab_report_phone',
            ],
            'active' => 'tab_report_day'			
        )
    ],			
    'sql' => [
        'table_name' => ' user_control ',
        'col_list'	=> '*, GROUP_CONCAT( DISTINCT stock_category.category_name SEPARATOR  " \n -- ") as product_category_list, 
                           GROUP_CONCAT( DISTINCT stock_provider.provider_name SEPARATOR  " \n -- ") as product_provider_list',
        'base_query' =>  " INNER JOIN stock_list ON stock_list.stock_id  != 0 
                           INNER JOIN stock_order_report ON  stock_order_report.stock_order_visible = 0
                            ",
        'param' => array(
            'query' => array(
                'param' =>  " AND stock_order_report.stock_id = stock_list.stock_id
                              AND stock_order_report.order_stock_count > 0 
                              ",
                "joins" => "  
                
                                LEFT JOIN products_provider_list ON products_provider_list.id_from_stock = stock_list.stock_id
                                LEFT JOIN products_category_list ON products_category_list.id_from_stock = stock_list.stock_id
                                
                                LEFT JOIN stock_provider ON stock_provider.provider_id = products_provider_list.id_from_provider
                                LEFT JOIN stock_category ON stock_category.category_id = products_category_list.id_from_category
                                
                                LEFT JOIN stock_barcode_list ON stock_barcode_list.br_stock_id = stock_list.stock_id 

                                LEFT JOIN user_control as sales_manager ON sales_manager.user_id = stock_order_report.sales_man
   
                                LEFT JOIN payment_method_list ON payment_method_list.id = stock_order_report.payment_method                                  
                              ",		
                'bindList' => array(
                )
            ),
            'sort_by' => " GROUP BY stock_order_report.order_stock_id DESC
                           ORDER BY stock_order_report.order_stock_id DESC "
        ),
            
    ],
    'page_data_list' => [
        'sort_key' => 'order_stock_id',
        'get_data' => [
            'report_order_id'	    => 'order_stock_id',
            // 'sales_time'        => 'sales_time',
            'sales_date'  		    => 'order_date',
            'name'			 	    => 'stock_name',
            'description'		    => 'stock_phone_imei',
            'category'			    => 'product_category_list',
            'provider'			    => 'product_provider_list',
            'report_note'		    => 'order_who_buy',
            'first_price'		    => 'stock_first_price',
            'second_price'		    => 'order_stock_sprice',
            'report_barcode'		=> 'barcode_value',
            'count'				    => 'order_stock_count',
            'report_total_amount'   => 'order_stock_total_price',
            'report_profit'		    => 'order_total_profit',
            'report_order_date'		=> 'order_my_date',
            'payment_method'        => 'payment_method',
            'report_sales_man'      => 'user_name',
            'report_order_edit'	=> null

        ],
        'table_total_list'	=> [
            'sum_total_sales',
            'sum_total_rasxod',
            'card_cash',
            'sum_total_sales_margin',
            'sum_profit',
            'sum_margin'
            
        ],
        'stats_card' => [
            'order_turnover',
            'order_profit',
            'rasxod',
            'order_margin',
            // 'order_count',
        ],
        'modal' => [
            'template_block' => 'report_return',
            'modal_fields' => array(
                'user' => [
                    'db' 			=> false, 
                    'custom_data' 	=> getUser('get_id'), 
                    'premission' 	=> true
                ],
                'report_order_id' => [
                    'db' => 'order_stock_id',
                    'custom_data' => false,
                    'premission' => true
                ],
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
                'report_change_tags' => [
                    'db' => 'id',
                    'custom_data' =>  get_tags_list(true),
                    'premission' => true
                ],
                'report_order_note' => [
                    'db' => 'order_who_buy',
                    'custom_data' => false,
                    'premission' => true
                ],

                'report_edit_order_count' => [
                    'db' => 'order_stock_count',
                    'custom_data' => false,
                    'premission' => true
                ],


                'report_edit_price' => [
                    'db' => 'order_stock_sprice',
                    'custom_data' => false,
                    'premission' => true
                ],


 

                'save_report_change' => [
                    'db' => false,
                    'custom_data' => false,
                    'premission' => true
                ],
                'report_return_btn' => [
                    'db' => false,
                    'custom_data' => false,
                    'premission' => true
                ]
            )
        ],
        'filter_fields' => [
        ],
    ]
];