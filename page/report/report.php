<?php

$controllerData = $main->getControllerData($page);

$data_page = $controllerData->allData;

$page_config = $data_page['page_data_list'];

$report = new \Core\Classes\Report;
$expenses = new \Core\Classes\Services\Expenses;

$report_date_list = $main->getReportDateList([
	'table_name' 	=> 'stock_order_report',
	'col_name' 		=> 'order_my_date',
	'order'			=> 'order_real_time DESC',
	'query'			=> ' WHERE order_stock_count > 0 AND stock_order_visible = 0 ',
	'default'		=> date('m.Y')
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

$data_page['sql']['query']['body'] = $data_page['sql']['query']['body']  . "  AND stock_order_report.order_my_date = :mydateyear";
$data_page['sql']['bindList']['mydateyear'] = date('m.Y');

$table_result = $main->prepareData($data_page['sql'], $data_page['page_data_list'], \PDO::FETCH_ASSOC);


$getExpensesCost = $expenses->getExpensesByMonth($utils->getDateMY());

array_push($table_result['base_result'], ['rasxod_money' => $getExpensesCost]);

echo $Render->view('/component/inner_container.twig', [
	'renderComponent' => [
		'/component/pulgin/stats_card/stats_card_container.twig' => [
			'date_type' => 'date'
		],
		'/component/pulgin/charts/report_charts.twig' => [
			// data
		],
		'/component/include_once_component.twig' => [
			'includs' => [
				'script' => [
					'/component/pulgin/charts/chartsScript.twig' => []
				],
				'category' => [
					'/component/pulgin/charts/chartsLoader.twig' => [
						'classList' => 'reloadCategory',
						'chartsName' => 'categoryCharts',
						'scriptUrl' => 'core/pulgin/charts/report_category_charts.php',
						'scriptRoute' => 'reportChartCategory',
					]
				],
				'provider' => [
					'/component/pulgin/charts/chartsLoader.twig' => [
						'classList' => 'reloadProvider',
						'chartsName' => 'providerCharts',
						'scriptUrl' => 'core/pulgin/charts/report_provider_charts.php',
						'scriptRoute' => 'reportChartProvider',
					],					
				]
			]
		],

		// '/component/pulgin/charts/report_pie_category.twig' => [
		// 	'chartsName' => 'categoryCharts',
		// 	'scriptUrl' => 'core/pulgin/charts/report_category_charts.php',
		// 	'scriptRoute' => 'reportChartCategory',
		// ],		
		// '/component/pulgin/charts/report_pie_provider.twig' => [
		// 	'chartsName' => 'categoryProvider',
		// 	'scriptUrl' => 'core/pulgin/charts/report_provider_charts.php',
		// 	'scriptRoute' => 'reportChartProvider',
		// ],				
		'/component/related_component/include_widget.twig' => [
			'/component/widget/report_date_picker.twig' => [
				'res' => $report_date_list,
				'sort' => 'date'
			],
			'/component/search/advanced/advanced_search.twig' => [
				'advanced_fields' => [
					'stock_name' => true,
					'stock_description' => true,
					'category' => [
						'row' => ['custom_data' => $category->getCategoryList()]
					],
					'provider' => [
						'row' => ['custom_data' => $provider->getProviderList()]
					],
					'report_month_picker' => [
						'res' => $report_date_list,
						'sort' => 'date'
					]
				]
			],


			'/component/include_once_component.twig' => [
				'includs' => [
					'covertToExcel' => [
						'/component/buttons/button.twig' => [
							'btn_text' => 'Convert to Excel',
							'btn_attr_list' => [
								'class' => ' btn btn-success convert-to-excel mrgn-right-left-10 
									
									buttons-excel buttons-html5 excel_convert_btn
									'
							]
						],
					],
				]
			],

			'/component/search/search.twig' => $search_arr,
		],
		'/component/table/table_wrapper.twig' => [
			'table'				=> $table_result['result'],
			'table_tab' 		=> $page,
			'table_type' 		=> $type,
		],
		'/component/table/table_footer_wrapper.twig' => [
			'table_total' => $utils->compareTableFooterData($page_config['table_total_list'], $table_result['base_result'])
		],

	]
]);
