<?php
	$data_page = page_data($page);
	$page_config = $data_page['page_data_list'];

	$report_date_list = get_report_date_list([
		'table_name' 	=> 'stock_order_report',
		'col_name' 		=> 'order_date',
		'order'			=> 'order_real_time DESC',
		'query'			=> ' WHERE order_stock_count > 0 AND stock_order_visible = 0 ',
		'default'		=> date('d.m.Y')
	]);
		//параметры поиска
		$search_arr = array(
			'input_class' 	 => 'search-auto area-input', 	//классы поля ввода поиска
			'parent_class'	 => 'search-container-width', 			//класс для родителя инпута
			'input_placeholder' => 'Axtar', //заполнить/оставить пустым или
			'reset' => true, 
			'input_icon' => [
				'icon' => 'la-search',
			],
			'widget_class_list' => '',
			'widget_container_class_list' => 'flex-cntr',
			'autocomplete' 	 => array(
				'type' => 'search',
				'parent_modify_class' => '',
				'autocomlete_class_list' => 'get_item_by_filter search-item area-closeable selectable-search-item'
			)
		);
		
	$data_page['sql']['param']['query']['param'] = $data_page['sql']['param']['query']['param'] . "  AND stock_order_report.order_date = :mydateyear";
	$data_page['sql']['param']['query']['bindList']['mydateyear'] = date("d.m.Y");

	$table_result = render_data_template($data_page['sql'], $data_page['page_data_list']);

	array_push($table_result['base_result'], ['rasxod_money' => get_today_total_rasxod(get_my_datetoday())]);


	echo $twig->render('/component/inner_container.twig', [
		'renderComponent' => [
			// '/component/pulgin/stats_card/stats_card_container.twig' => [
			// 	'date_type' => 'day'
			// ],			
			'/component/related_component/include_widget.twig' => [
				'/component/widget/report_date_picker.twig' => [
					'res' => $report_date_list,
                    'sort' => 'buy_date'
				],
				// '/component/search/search.twig' => $search_arr,	
				
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
						'report_day_picker' => [
							'res' => $report_date_list,
							'sort' => 'buy_date'	
						]
					]					
				],				
			],
			'/component/table/table_wrapper.twig' => [
				'table'				=> $table_result['result'],
				'table_tab' 		=> $page,
				'table_type' 		=> $type,
			],
			'/component/table/table_footer_wrapper.twig' => [
				'table_total' => table_footer_result($page_config['table_total_list'], $table_result['base_result'])
			]
		]
	]);


?>
