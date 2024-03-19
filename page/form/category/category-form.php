<?php

$this_data = $main->initController($page);

$page_config = $this_data['page_data_list'];

$table_result = $main->prepareData($this_data['sql'], $page_config);

echo $Render->view('/component/inner_container.twig', [
    'renderComponent' => [
        '/component/form/stock_form/stock_form.twig' => [
            'res' => $page_config['form_fields_list'],
            'form_title' => 'Kateqoriya əlavə et'
        ],
        '/component/table/table_wrapper.twig' => [
            'table' => $table_result['result'],
            'table_tab' => $page,
            'table_type' => $type,				
        ],
    ]
]);