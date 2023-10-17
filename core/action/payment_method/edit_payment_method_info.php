<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/function.php';

header('Content-type: Application/json');


if(empty($_POST) || count($_POST) < 2) {
   echo print_alert([
        'type' => 'error',
        'text' => 'Empty'
   ]);  
   exit;
}


$option = [
    'before' => ' UPDATE payment_method_list SET ',
    'after' => ' WHERE id = :id ',
    'post_list' => [
        'payment_method_id' => [
            'query' => false,
            'bind' => 'id',
            'require' => true,
        ],
        'edit_payment_method_name' => [
            'query' => ' payment_method_list.title = :title ',
            'bind' => 'title',
            'require' => false
        ],
        'change_payment_method_tags_id' => [
            'query' => ' payment_method_list.tags_id = :tag_id',
            'bind' => 'tag_id',
            'require' => false
        ]
    ]
];

echo ls_db_upadte($option, $_POST);