<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');

if(empty($_POST) && empty($_POST['filter_id'])) {
    echo json_encode([
        'alert_type' => 'Error',
        'text'  => 'Empty data'
    ]);

    exit;
}

$filter_id = $_POST['filter_id'];

// ls_var_dump($_POST);

// изменяем название фильтра
if($_POST['filter_name']) {
    $filter_name = $_POST['filter_name'];
    
    ls_edit_filter_name($filter_id, $filter_name);
}

// обновляем пункты фильтра
if(!empty($_POST['option_list'])) {
    $option_list = $_POST['option_list'];
	foreach ($option_list as $key => $row) {
        ls_edit_filter_option($row['id'], $row['value']);
	}
}


// удаление 
if(!empty($_POST['deleted_option_list'])) {
    $deleted_option_list = $_POST['deleted_option_list'];

    foreach ($deleted_option_list as $key => $row) {
        ls_delete_filter_option($row);
    }
}

//добавляем новый пункт 
if(!empty($_POST['add_new_option'])) {
    $new_option_list = $_POST['add_new_option'];

    foreach ($new_option_list as $key => $row) {
        ls_add_new_filter_option($row['value'], $row['type_id']);
    }
}




echo json_encode([
    'alert_type' => 'success',
    'text' => 'updated'
]);