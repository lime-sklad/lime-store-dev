<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type', 'Application/json');

$option = [
    'before' => ' UPDATE stock_order_report SET ',
    'after' => ' WHERE order_stock_id = :report_id  ',
    'post_list' => [
        'report_order_id' => [
            'query' => false,
			'bind' => 'report_id',
			'require' => true
        ],
        'edit_report_order_tags' => [
            'query' => ' payment_method = :payment_tags_id ',
            'bind' => 'payment_tags_id',
            'require' => false
        ]
    ]
];

echo ls_db_upadte($option, $_POST);