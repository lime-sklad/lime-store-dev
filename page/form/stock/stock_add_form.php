<?php 
$page = $_POST['page'];
$tab =  $_POST['tab'];

$this_data = $init->initController($page);

$page_config = $this_data['page_data_list'];

// $modal = $page_config['modal'];

// $modal_tpl_name = $modal['template_block'];
// $modal_fields = $modal['modal_fields'];

$form_fileds_list = $page_config['form_fields_list'];

foreach($form_fileds_list as $key => $value) {
    if($value['block_name'] == 'add_stock_filter_list') {
        $form_fileds_list[$key]['custom_data'] = $productsFilter->compareProductsFIlter(null, $page_config['filter_fields']);
    }
}

echo $Render->view('/component/inner_container.twig', [
    'renderComponent' => [
        '/component/form/stock_form/stock_form.twig' => [
            'res' => $form_fileds_list,
            'form_title' => 'Məhsul əlavə edin'
        ]
    ]
]);

    