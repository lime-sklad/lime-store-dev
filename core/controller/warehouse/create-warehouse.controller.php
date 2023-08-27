<?php 
return [
    'tab' => [
        'is_main' => false,
    ],			
    'sql' => [
        'table_name' => ' user_control  ',
        'col_list'	=> ' * ',
        'base_query' =>  " INNER JOIN warehouse_list ON warehouse_list.warehouse_visible = 0 ",
        'param' => array(
            'query' => array(
                'param' =>  "",
                "joins" => "",		
                'bindList' => array(						
                )
            ),
            'sort_by' => " GROUP BY warehouse_list.id DESC ORDER BY warehouse_list.id DESC ",
            'limit' => '',
        ),
    ],
    'page_data_list' => [
        'sort_key' => 'id',
        'get_data' => [
            'id' 				=> 'id',
            'warehouse_name'			 	=> 'warehouse_name',
            'description' 		=> 'warehouse_info',
            'warehouse_contact'	=> 'warehouse_contact',
            'edit'              => null
        ],
        'table_total_list'	=> [
        ],
        'modal' => [
            'template_block' => 'edit_product',
            'modal_fields' => array(		
                'edit_warehouse_name' => [
                    'db'   => 'warehouse_name',
                    'custom_data' => false,
                    'premission' => true
                ],

                'save_warehouse_edited' => [
                    'db' => false,
                    'custom_data' => false,
                    'premission' => true
                ],
                'delete_warehouse' => [
                    'db' => 'id',
                    'custom_data' => false,
                    'premission' => true
                ]
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