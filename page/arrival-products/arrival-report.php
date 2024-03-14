<?php

use Core\Classes\Services\Warehouse\Warehouse;

    $warehouse = new Warehouse;

    $table_result = $warehouse->getArrivalByDate($utils::getDateMY(), $page);
        
        echo $Render->view('/component/inner_container.twig', [
            'renderComponent' => [
				'/component/related_component/include_widget.twig' => [

                    '/component/widget/report_date_picker.twig' => [
                        'res' => $main->getReportDateList([
                            'table_name' 	=> 'arrival_products',
                            'col_name' 		=> 'day_date',
                            'order'			=> 'day_date DESC',
                            'query'			=> ' ',
                            'default'       => date('m.Y')
                        ]),
                        'sort' => 'date'					
                    ],

                    '/component/search/advanced/advanced_search.twig' => [
                        'advanced_fields' => [

                            // 'custom_date_picker' => [
                            //     'res' => get_arrival_report_day_list(),
                            //     'sort' => 'data',
                            //     'title' => 'dsas',
                            //     'fields_name' => 'sds'
                            // ],

                            'arrival_report_day_picker' => [
                                'res' => $main->getReportDateList([
                                    'table_name' 	=> 'arrival_products',
                                    'col_name' 		=> 'full_date',
                                    'order'			=> 'full_date DESC',
                                    'query'			=> ' ',
                                    'default'       => date('d.m.Y')
                                ]),
                                'sort' => 'date'	
                            ],           
                            
                            'stock_name' => true,

                            'custom_input_fields' => [
                                [
                                    'title' => 'Təsvir',
                                    'fields_name' => 'arrival_report_description',
                                    'class_list' => 'advanced'                                    
                                ],
                            ],                            
                        ]					
                    ],
                ],
    
                '/component/table/table_wrapper.twig' => [
                    'table' => $table_result['result'],
                    'table_tab' => $page,
                    'table_type' => $type,
                ],
    
                // '/component/table/table_footer_wrapper.twig' => [
                //     'table_total' => table_footer_result($page_config['table_total_list'], $table_result['base_result'])
                // ],
            ]
        ]);
