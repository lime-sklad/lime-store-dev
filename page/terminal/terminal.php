<?php

	$data_page = $main->initController($page);

	$page_config = $data_page['page_data_list'];


// ls_var_dump($data_page[]);
	//параметры поиска
	$search_arr = array(
		'input_class' 	 => 'search-auto area-input', //классы поля ввода поиска
		'parent_class'	 => 'search-container-width', //класс для родителя инпута
		'label'			 => '', //заполнить/оставить пустым или 
		'input_placeholder' => 'Axtar',
		'widget_class_list' => '',
		'input_icon' => [
			'icon' => 'la-search'
		],
		'widget_container_class_list' => 'flex-cntr',
		'reset' => true,
		'autocomplete' => array(
			'type' 	=> 'search' 
		)
	);

	$table_result = $main->prepareData($data_page['sql'], $data_page['page_data_list'], PDO::FETCH_ASSOC);
	
	echo $Render->view('/component/inner_container.twig', [
		'renderComponent' => [
			'/component/related_component/include_widget.twig' => [
				'/component/filter/filter_sort.twig' => [
					'filter_list' =>  $productsFilter->compareProductsFIlter(null, $page_config['filter_fields'])
				],
				'/component/search/advanced/advanced_search.twig' => [
					'advanced_fields' => [
						'stock_name' => true,

						'stock_description' => true,

						'category' => [
							'row' => ['custom_data' => $category->getCategoryList()]
						],
						'provider' => [
							'row' => ['custom_data' => $provider->getProviderLIst()]
						],
					]
				],				
				'/component/search/search.twig' => $search_arr,
			],
			'/component/table/table_wrapper.twig' => [
				'table' => $table_result['result'],
				'table_tab' => $page,
				'table_type' => $type,
				'attribute' => [
					'data-modifed-link' => 'terminal'
				]	
			],

			'/component/buttons/button.twig' => [
				'btn_text' => 'Hamısını göstər',
				'btn_attr_list' => [
					'class' => 'btn btn-info float-left advanced-search-submit'
				]
			],
						
			'/component/table/table_footer_wrapper.twig' => [
				'table_total' => $utils->compareTableFooterData($page_config['table_total_list'], $table_result['base_result'])
			]
		]
	]);
		
?>