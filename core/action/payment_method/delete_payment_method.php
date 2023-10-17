<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/function.php';

header('Content-type: Application/json');



$option = [
    'before' => ' UPDATE payment_method_list SET ',
    'after' => ' WHERE id = :id ',
    'post_list' => [
        'p_method_id' => [
            'query' => ' visible = 1 ',
            'bind' => 'id',
            'require' => true,
        ],
    ]
];


echo ls_db_upadte($option, $_POST);

