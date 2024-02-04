<?php 

header('Content-type: Application/json');
// $template = $twig->load('/component/modal/modal_fields.twig');
$custom_data = false;

$postData = $_POST['data'];

$categoryList = $category->getCategoryList();
$providerList = $provider->getProviderList();


if($postData['fields_name'] == 'edit_append_new_category') {
    $custom_data = $categoryList;
}

if($postData['fields_name'] == 'add_append_new_category' || $postData['fields_name'] == 'search_add_category_fields' ) {
    $custom_data = $categoryList;
}

if($postData['fields_name'] == 'edit_append_new_provider' || $postData['fields_name'] ==  'add_append_new_provider' || $postData['fields_name'] === 'search_append_new_provider') {
    $custom_data = $providerList;
}


if($postData['fields_name'] == 'search_warehouse_list') {
    $custom_data = get_warehouse_list();
}



if($postData['fields_name']) {
    $get_block_name = $postData['fields_name'];

    $tp =  $Render->view('/component/modal/include_fields.twig',
        [
            'res' => [
                array(
                    'block_name' => $get_block_name,
                    'class_list' => 'new',
                    'custom_data' => $custom_data
                )
            ]
        ]
    );

    echo $utils::abort([
        'fields'  => $tp
    ]);

}