<?php 
return [
    'tab' => [
        'is_main' => false,
        'title'		 		=> 'Hesabatt',
    ],			
    'sql' => [
        'table_name' => ' user_control  ',
        'col_list'	=> ' * ',
        'query' => array(
            'base_query' =>  " INNER JOIN arrival_products ON arrival_products.id != 0 ",
            'body' =>  "  INNER JOIN stock_list ON stock_list.stock_id = arrival_products.id_from_stock ",
            "joins" => "   ",		
            'sort_by' => " GROUP BY arrival_products.id  DESC ORDER BY  arrival_products.id DESC",
            'limit' => '',
        ),
        'bindList' => array(						
        )
    ],
    'page_data_list' => [
        'sort_key' => 'id',
        'get_data' => [
            'id' 				=> 'id',
            'stock_add_date' 	=> 'full_date',
            'report_order_date' => 'day_date',
            'name'			 	=> 'stock_name',
            'description'       => 'stock_phone_imei',
            'report_note' 		=> 'description',
            'first_price'		=> 'stock_first_price',
            'count'				=> 'count',
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
            'parent_class'	 => 'search-container-width', 			//класс для родителя инпута
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