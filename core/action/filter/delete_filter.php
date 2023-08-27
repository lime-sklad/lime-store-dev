<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');

delete_filter($_POST['id']);

return print_alert([
    'type' => 'success',
    'text' => 'ok'
]);