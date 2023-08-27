<?php
	$data_page = page_data($page);
	$page_config = $data_page['page_data_list'];




        $table_result = render_data_template($data_page['sql'], $data_page['page_data_list'], PDO::FETCH_ASSOC);

	
        echo $twig->render('/component/inner_container.twig', [
            'renderComponent' => [
				'/component/related_component/include_widget.twig' => [
                    '/component/search/search.twig' => $data_page['component_config']['search']
                ],

				'/component/write-off-products/form/cart.twig' => [
					'class_list' => 'cart-write-off custom write-off-product-cart',
					'page' => $page,
					'type' => 'phone',
                    'attribute' => [
                        'data-modifed-link' => 'write_off_products'
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
