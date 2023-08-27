<?php
	$data_page = page_data($page);
	$page_config = $data_page['page_data_list'];

	//параметры поиска
	$search_arr = array(
		'input_class' 	 => 'table-dom-live-search area-input', 	//классы поля ввода поиска
		'parent_class'	 => 'search-container-width', 			//класс для родителя инпута
		'input_placeholder' => 'Axtar', //заполнить/оставить пустым или
		'reset' => true, 
		'input_icon' => [
			'icon' => 'la-search',
		],
		'widget_class_list' => '',
		'widget_container_class_list' => 'flex-cntr',
	);
		
	$data_page['sql']['param']['query']['param'] = $data_page['sql']['param']['query']['param'] . "  AND rasxod.rasxod_day_date = :rasxodDay";
	$data_page['sql']['param']['query']['bindList']['rasxodDay'] = date('d.m.Y');

	$table_result = render_data_template($data_page['sql'], $data_page['page_data_list']);


	echo $twig->render('/component/inner_container.twig', [
		'renderComponent' => [			
			'/component/related_component/include_widget.twig' => [			
				'/component/rasxod/rasxod_date_picker.twig' => [
					'res' => get_rasxod_day_list(),
                    'rasxod_sort' => 'rasxod-day-date'
				],

				'/component/search/search.twig' => $search_arr,				
			],
			'/component/table/table_wrapper.twig' => [
				'table'				=> $table_result['result'],
				'table_tab' 		=> $page,
				'table_type' 		=> $type,
			],
			'/component/table/table_footer_wrapper.twig' => [
				'table_total'    	=> table_footer_result($page_config['table_total_list'], $table_result['base_result'])
			]			
		]
	]);

?>
