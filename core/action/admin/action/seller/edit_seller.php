<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: application/json');


$prepare_data = $_POST['prepare_data'];

    if(array_key_exists('edit_seller_name', $prepare_data)) {
        if(!is_unique_user($prepare_data['edit_seller_name'])) {
            
            return print_alert([
                'alert_type' => 'error',
                'text'	=> 'İstifadəçi artıq əlavə edilib'
            ]);

            die();
        } 
    }

    edit_user($prepare_data);

    return print_alert([
        'alert_type' => 'success',
        'text' => 'Ok'
    ]);