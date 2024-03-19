<?php

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
    
    $db->update($option, $data);

    echo print_alert([
        'type' => 'success',
        'text' => 'Ok'
    ]);
}