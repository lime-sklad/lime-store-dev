<?php 

header('Content-type: application/json');


$seller_id = $_POST['seller_id'];


if($seller_id == 1) {
    return $utils::abort([
        'type' => 'error',
        'text' => 'İstifadəçini silmək mümkün deyil'
    ]);

    exit;
}

$user->deleteUser($seller_id);

return $utils::abort([
    'type' => 'success',
    'text' => 'OK'
]);