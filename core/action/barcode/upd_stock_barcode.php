<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type: Application/json');


// $stock_id = $_POST['stock_id'];

// // изменить баркод товара
// if(!empty($_POST['edit_barcode_list'])) {
//     foreach($_POST['edit_barcode_list'] as $key => $value) {
//         if(get_stock_by_barcode($value['new_barcode'])) {
//             alert_error('Error');
//             exit;
//         }

        
//         return ls_db_upadte([
//             'before' => ' UPDATE stock_barcode_list SET ',
//             'after' => ' WHERE barcode_value = :old_barcode ',
//             'post_list' => [
//                 'old_barcode' => [
//                     'query' => false,
//                     'bind' => 'old_barcode'
//                 ],
//                 'new_barcode' => [
//                     'query' => ' barcode_value = :new_barcode ',
//                     'bind' => 'new_barcode'
//                 ]
//             ]
//         ],
//         [
//             'old_barcode' => $value['old_barcode'],
//             'new_barcode' => $value['new_barcode']
//         ]);
//     };

// }


// // if(!empty($_POST['add_new_barcode'])) {
// //     foreach($_POST['add_new_barcode'] as $key => $value) {

// //     }
// // }




// exit;

$stock_id = $_POST['data'];

ls_db_delete(array(
    [
        'table_name' => 'stock_barcode_list',
        'joins' => '',
        'where' => ' br_stock_id = :id ',
        'bindList' => [
            ':id' => $stock_id,
        ]			
    ]
));

if(!empty($_POST['update_barcodle_list'])) {
    $list = [];
    
    foreach($_POST['update_barcodle_list'] as $key => $value) {

        if(get_stock_by_barcode($value)) {
            echo print_alert([
                'type' => 'error',
                'text' => 'Bu barkodlu məhsul artıq əlavə edilib'
            ]);
            exit;
        }
    
        $list[] = [
            'barcode_value' => $value,
            'br_stock_id' => $stock_id
        ];
    }

    ls_db_insert('stock_barcode_list', $list);
}


echo print_alert([
    'type' => 'success',
    'text' => 'Ok'
]);

