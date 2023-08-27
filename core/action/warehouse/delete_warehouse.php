<?php 

require_once $_SERVER['DOCUMENT_ROOT']. '/function.php';

header('Content-type: Application/json');

$id = $_POST['id'];

$option = [
    'before' => ' UPDATE warehouse_list SET ',
    'after' => ' WHERE id = :id ',
    'post_list' => [
        'warehouse_id' => [
            'query' => ' warehouse_visible = 1 ',
            'require' => true,
            'bind' => 'id'
        ],
    ]
];

ls_db_upadte($option, [
    'warehouse_id' => $id
]);


echo print_alert([
    'type' => 'success',
    'text' => 'ok'
]);