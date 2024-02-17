<?php 

$accessManager = new \core\classes\privates\accessManager;
$user = new \core\classes\privates\user;
$category = new \Core\Classes\Services\Category;
$provider = new \Core\Classes\Services\Provider;


$providerList = $provider->getProviderList();
$categoryList = $category->getCategoryList();

return [
    'tab' => [
        'is_main' => true,
        'title'		 		=> 'Anbar',
        'icon'				=> [
            'img_big'		 	=> 'img/svg/070-file hosting.svg',
            'img_small'			=> '',
            'modify_class' 		=> 'las la-boxes'
        ],
        'link'  			=> '/page/base.php',		
        'template_src'      => '/page/base_tpl.twig',
        'background_color'  => 'rgba(72, 61, 139, 0.1)',
        'tab' => array(
            'list' => [
                'tab_stock_phone',
                'tab_stock_form',
            ],
            'active' => 'tab_stock_phone'
        )
    ],
    'sql' => [
        'table_name' => '  user_control  ',

        // 'col_list'	=> ' *, GROUP_CONCAT( DISTINCT stock_category.category_name SEPARATOR  " \n -- ") as product_category_list, 
        //                     GROUP_CONCAT( DISTINCT stock_provider.provider_name SEPARATOR  " \n -- ") as product_provider_list         
        'col_list'	=> ' * ',
        'query' => array(
            'base_query' =>  " INNER JOIN stock_list ON stock_list.stock_id != 0 ",
            'body' =>  " AND stock_list.stock_visible = 0 AND IF (stock_list.stock_count >= stock_list.min_quantity_stock, stock_list.stock_count >= stock_list.min_quantity_stock, stock_list.stock_count < 0) 

                            ",
            "joins" => "  LEFT JOIN products_provider_list ON products_provider_list.id_from_stock = stock_list.stock_id
                            LEFT JOIN products_category_list ON products_category_list.id_from_stock = stock_list.stock_id
                            
                            LEFT JOIN stock_provider ON stock_provider.provider_id = products_provider_list.id_from_provider
                            LEFT JOIN stock_category ON stock_category.category_id = products_category_list.id_from_category

                            LEFT JOIN stock_barcode_list ON stock_barcode_list.br_stock_id = stock_list.stock_id ",		
            
            'sort_by' => "  GROUP BY stock_list.stock_id  DESC 
                            ORDER BY  stock_list.stock_id DESC
                        ",
            'limit' => ' LIMIT 50 ', 
        ),	
        'bindList' => array(						
        )        
    ],
    'page_data_list' => [
        'sort_key' => 'stock_id',
        'get_data' => [
            'id' 				=> 'stock_id',
            'stock_add_date'	=> 'stock_get_fdate',
            'name'			 	=> 'stock_name',
            'description' 		=> 'stock_phone_imei',
            'first_price'		=> 'stock_first_price',
            'second_price' 		=> 'stock_second_price',
            'count'				=> 'stock_count',
            'provider' 			=> 'provider_name',
            'category'			=> 'category_name',
            'stock_barcode'		=> 'barcode_value',
            'edit_stock_btn' 	=> null
        ],
        'table_total_list'	=> [
            'stock_count',
            'sum_first_price'
        ],
        'modal' => [
            'template_block' => 'edit_product',
            'modal_fields' => array(
                'user' => [
                    'db' 			=> false, 
                    'custom_data' 	=> $user->getUser('get_id'), 
                    'premission' 	=> true
                ],
                'edit_stock_id' => [
                    'db' 			=> 'stock_id', 
                    'custom_data' 	=> false,
                    'premission' 	=> true
                ],
                'edit_stock_name' => [
                    'db'			=> 'stock_name', 
                    'custom_data' 	=> false, 
                    'premission'	=> $accessManager->isDataAvailable('th_prod_name')
                ],
                'edit_stock_description' => [
                    'db'			=> 'stock_phone_imei', 
                    'custom_data' 	=> false, 
                    'premission' 	=> true
                ],
                'edit_stock_category' => [
                    'db' 			=> 'category_name', 
                    'class_list'	=> 'edit',
                    'custom_data' 	=> $categoryList, 
                    'user_function' => [
                        'function_name' => [new \Core\Classes\Products, 'getProductCategory'],
                        'function_args' => 'id',
                    ],
                    'premission' 	=> true
                ],		
                'edit_stock_provider' => [
                    'db' 			=> 'provider_name', 
                    'class_list'	=> 'edit',
                    'custom_data' 	=> $providerList, 
                    'user_function' => [
                        'function_name' => [new \Core\Classes\Products, 'getProductProvider'],
                        'function_args' => 'id',
                    ],							
                    'premission'	=> true
                ],
                'edit_stock_plus_minus_count' => [
                    'db' 			=> 'stock_count',
                    'custom_data' 	=> false,
                    'premission' 	=> true
                ],
                'edit_append_stock_count' => [
                    'db'			=> false,
                    'custom_data'	=> false,
                    'premission'	=> true
                ],
                'edit_min_quantity_count' => [
                    'db' 			=> 'min_quantity_stock',
                    'custom_data' 	=> false,
                    'premission' 	=> true
                ],
                'edit_stock_first_price' => [
                    'db' 			=> 'stock_first_price',
                    'custom_data' 	=> false,
                    'premission' 	=> $accessManager->isDataAvailable('th_buy_price')
                ],
                'edit_stock_second_price' => [
                    'db' 			=> 'stock_second_price',
                    'custom_data' 	=> false,
                    'premission' 	=> true
                ],
                'edit_stock_filter' => [
                    'db' 			=> 'stock_id',
                    'custom_data' 	=> false,
                    'premission' 	=> true
                ],
                // 'edit_arrival_stock' => [
                //     'db'			=> 'stock_id',
                //     'custom_data' 	=> false,
                //     'premission'	=> true
                // ],	
                // 'edit_writeoff_stock' => [
                //     'db'			=> 'stock_id',
                //     'custom_data' 	=> false,
                //     'premission'	=> true
                // ],	                
                'edit_stock_barcode' => [
                    'db'			=> 'stock_id',
                    'custom_data' 	=> false,
                    'premission'	=> true
                ],							
                'edit_save_btn' => [
                    'db' 			=> false,
                    'custom_data' 	=> true,
                    'premission' 	=> true
                ],				
                'delete_stock' => [
                    'db' => 'stock_id',
                    'custom_data' => false,
                    'premission' => true
                ],				
            )					
        ],
        'filter_fields' => [
            // 'color',
            // 'storage',
            // 'ram',
            // 'brand'
        ],
        'form_fields_list' => array(
            [
                'block_name' => 'add_stock_name',
            ],
            [
                'block_name' => 'add_stock_description',
            ],						
            [
                'block_name' => 'add_stock_provider',
                'custom_data' => $providerList
            ],
            [
                'block_name' => 'add_stock_category',
                'custom_data' => $categoryList
            ],	
            [
                'block_name' => 'add_stock_count'
            ],
            [
                'block_name' => 'add_stock_min_quantity'
            ],
            [
                'block_name' => 'add_stock_first_price'
            ],	
            [
                'block_name' => 'add_stock_second_price'
            ],
            [
                'block_name' => 'add_stock_barcode'
            ],																				
            [
                'block_name' => 'add_stock_filter_list',
            ],
            [
                'block_name' => 'add_save_form',
            ],
        )

    ]
];