<?php
        $data_page = page_data($page);
        $page_config = $data_page['page_data_list'];
        
        
        $data_page['sql']['param']['query']['param'] = $data_page['sql']['param']['query']['param'] . "  AND arrival_products.day_date = :mydateyear";
        $data_page['sql']['param']['query']['bindList']['mydateyear'] = date("m.Y");
        
        $table_result = render_data_template($data_page['sql'], $data_page['page_data_list'], PDO::FETCH_ASSOC);
        
        echo $twig->render('/component/inner_container.twig', [
            'renderComponent' => [
				'/component/related_component/include_widget.twig' => [

                    '/component/widget/report_date_picker.twig' => [
                        'res' => get_report_date_list([
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
                                'res' => get_report_date_list([
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
