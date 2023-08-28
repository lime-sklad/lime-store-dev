<?php 
return [
    'tab' => [
        'is_main' => false,
        'title'		 		=> 'Hesabatt',
    ],			
    'sql' => [
        'table_name' => ' user_control  ',
        'col_list'	=> ' * ',
        'base_query' =>  " INNER JOIN transfer_list ON transfer_list.transfer_id != 0 ",
        'param' => array(
            'query' => array(
                'param' =>  "  INNER JOIN stock_list ON stock_list.stock_id = transfer_list.stock_id ",
                "joins" => "   ",		
                'bindList' => array(						
                )
            ),
            'sort_by' => " GROUP BY transfer_list.transfer_id  DESC ORDER BY  transfer_list.transfer_id DESC
                             ",
            'limit' => '',
        ),
    ],
    'page_data_list' => [
        'sort_key' => 'transfer_id',
        'get_data' => [
            'id' 				=> 'transfer_id',
            'name'			 	=> 'stock_name',
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