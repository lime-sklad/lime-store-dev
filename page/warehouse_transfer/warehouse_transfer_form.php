<?php

use Core\Classes\Services\Warehouse;

	$data_page = $main->initController($page);
	$page_config = $data_page['page_data_list'];


    $Warehouse = new Warehouse;

        $table_result = $main->prepareData($data_page['sql'], $data_page['page_data_list'], PDO::FETCH_ASSOC);

	
        echo $Render->view('/component/inner_container.twig', [
            'renderComponent' => [
                '/component/related_component/include_widget.twig' => [
                    'component/search/search.twig' => $data_page['component_config']['search']
                ],

                '/component/warehouse-transfer/cart.twig' => [
					'class_list' => 'cart-arrivals custom arrival-product-cart',
					'page' => $page,
					'type' => 'phone',
                    'attribute' => [
                        'data-modifed-link' => 'warehouse_transfer_form'
                    ],
                    'warehouse_list' => $Warehouse->getWarehouseList()
				],	
            ]
        ]);
