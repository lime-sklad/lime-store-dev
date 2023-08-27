<?php
require $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Applcation/json');

if(!empty($_POST['prepare'])) {
    
    $data = $_POST['prepare'];

    $option = [
        'before' => " UPDATE warehouse_list SET ",
        'after' => " WHERE id =:id ",
        'post_list' => [
            //id
            'warehouse_id' => [ 
                'query' => false,
                'bind' => 'id',
                'require' => true
            ],	
            //изменить название товра
            'edit_warehouse_name' => [
                'query' => "warehouse_name = :name",
                'bind' => 'name',
            ],
        ]
    ];
    
    ls_db_upadte($option, $data);

    echo print_alert([
        'type' => 'success',
        'text' => 'Ok'
    ]);
}