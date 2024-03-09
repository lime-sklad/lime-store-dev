<?php

use Core\Classes\Services\Expenses;

	$data_page = $main->initController($page);
	$page_config = $data_page['page_data_list'];

	$expense = new Expenses;

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
		


	$table_result = $expense->getDailyExpenses($utils::getDateDMY());


	echo $Render->view('/component/inner_container.twig', [
		'renderComponent' => [			
			'/component/related_component/include_widget.twig' => [			
				'/component/rasxod/rasxod_date_picker.twig' => [
					'res' => $expense->getExpenseDayList(),
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
				'table_total'    	=> $utils->compareTableFooterData($page_config['table_total_list'], $table_result['base_result'])
			]			
		]
	]);

?>
