<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: application/json');


$seller_id = $_POST['seller_id'];


if($seller_id == 1) {
    return print_alert([
        'alert_type' => 'error',
        'text' => 'İstifadəçini silmək mümkün deyil'
    ]);

    exit;
}


delete_user($seller_id);

return print_alert([
    'alert_type' => 'success',
    'text' => 'OK'
]);