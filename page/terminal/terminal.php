<?php

	// $tpl = $twig->load($tpl_src);
	$data_page = page_data($page);

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

	$table_result = render_data_template($data_page['sql'], $data_page['page_data_list'], PDO::FETCH_ASSOC);
	
	echo $twig->render('/component/inner_container.twig', [
		'renderComponent' => [
			'/component/related_component/include_widget.twig' => [
				'/component/filter/filter_sort.twig' => [
					'filter_list' => ls_collect_filter(null, $page_config['filter_fields'])
				],
				'/component/search/advanced/advanced_search.twig' => [
					'advanced_fields' => [
						'stock_name' => true,

						'stock_description' => true,

						'category' => [
							'row' => ['custom_data' => get_category_list()]
						],
						'provider' => [
							'row' => ['custom_data' => get_provider_list()]
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
				'table_total' => table_footer_result($page_config['table_total_list'], $table_result['base_result'])
			]
		]
	]);
		
?>