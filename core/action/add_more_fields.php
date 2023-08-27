<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';
header('Content-type: Application/json');
// $template = $twig->load('/component/modal/modal_fields.twig');
$custom_data = false;



if($_POST['fields_name'] == 'edit_append_new_category') {
    $custom_data = get_category_list();
}

if($_POST['fields_name'] == 'add_append_new_category' || $_POST['fields_name'] == 'search_add_category_fields' ) {
    $custom_data = get_category_list();
}

if($_POST['fields_name'] == 'edit_append_new_provider' || $_POST['fields_name'] ==  'add_append_new_provider' || $_POST['fields_name'] === 'search_append_new_provider') {
    $custom_data = get_provider_list();
}


if($_POST['fields_name']) {
    $get_block_name = $_POST['fields_name'];

    $tp =  $twig->render('/component/modal/include_fields.twig',
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

    
    echo json_encode([
        'fields'  => $tp
    ]);

}