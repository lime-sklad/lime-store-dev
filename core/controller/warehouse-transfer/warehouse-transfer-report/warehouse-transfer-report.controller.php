<?php 
return [
    'tab' => [
        'is_main' => false,
        'title' => 'Transfer Hesabat',
    ],			
    'sql' => [
        'table_name' => ' user_control  ',
        'col_list'	=> ' * ',
        'query' => array(
            'base_query' =>  " INNER JOIN transfer_list ON transfer_list.transfer_id != 0 ",
            'body' =>  "  INNER JOIN stock_list ON stock_list.stock_id = transfer_list.stock_id 
                            INNER JOIN warehouse_list ON warehouse_list.id = transfer_list.warehouse_id ",
            'joins' => " ",		
            'sort_by' => " GROUP BY transfer_list.transfer_id  DESC ORDER BY  transfer_list.transfer_id DESC ",
            'limit' => '',
        ),
        'bindList' => array()        
    ],
    'page_data_list' => [
        'sort_key' => 'transfer_id',
        'get_data' => [
            'id' 				=> 'transfer_id',
            'report_order_date' => 'transfer_date',
            'transfer_full_date' => 'transfer_full_date',
            'name'			 	=> 'stock_name',
            'description' 		=> 'stock_phone_imei',
            'report_note'       => 'description',
            'warehouse_name'    => 'warehouse_name',
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