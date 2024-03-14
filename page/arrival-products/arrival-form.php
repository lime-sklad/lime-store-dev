<?php
	$data_page = $main->initController($page);
	$page_config = $data_page['page_data_list'];




        $table_result = $main->prepareData($data_page['sql'], $data_page['page_data_list'], PDO::FETCH_ASSOC);

	
        echo $Render->view('/component/inner_container.twig', [
            'renderComponent' => [
				'/component/related_component/include_widget.twig' => [
                    '/component/search/search.twig' => $data_page['component_config']['search']
                ],

				'/component/arrival-products/form/cart.twig' => [
					'class_list' => 'cart-arrivals custom arrival-product-cart',
					'page' => $page,
					'type' => 'phone',
                    'attribute' => [
                        'data-modifed-link' => 'arrivals_products'
                    ]
				],	

    
                // '/component/table/table_wrapper.twig' => [
                //     'table' => $table_result['result'],
                //     'table_tab' => $page,
                //     'table_type' => $type,
                // ],
    
                // '/component/table/table_footer_wrapper.twig' => [
                //     'table_total' => table_footer_result($page_config['table_total_list'], $table_result['base_result'])
                // ],
            ]
        ]);
