<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/action/category/category.controller.php';

$f_date = date("d.m.Y");
$y_date = date("m.Y");
$query = "INSERT INTO stock_list (stock_get_fdate, stock_get_year, stock_name, barcode_article, stock_first_price, stock_second_price, min_quantity_stock) VALUES 
('$f_date', '$y_date', 'GLASS HD SAM A01 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A01CORE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A02 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A02S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A03 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A03S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A03CORE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A04 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A04S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A04E QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A10 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A10S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A11 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A12 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A13 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A14 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A20/30/50 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A20S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A20E QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A21S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A21 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A22 5G QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A22 4G QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A23 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A24 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A31 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A32 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A33 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A34 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A40 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A41 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A42 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A51 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A52 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A53 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A54 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A60 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A70 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A71 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A72 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A73 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A74 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A310 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A310 GOLD QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A320 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A320 GOLD QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A330 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A6 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM A6++ QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J2 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J2 PRİME QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J4 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J4 GOLD QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J250 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J260 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J310 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J320 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J330 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J510 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J520 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J530 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J6 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J7 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J710 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J720 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J730 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J7 PRM QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J7 PRM GOLD QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM J4++/J6++ QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S20FE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S21 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S21++ QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S22 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S23 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S22+ QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD SAM S23+ QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 4X QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 5 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 5++ QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 6/6A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 7 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 7A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 8A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 9 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 9A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 9T QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 9C QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 10 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 10A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 10C QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 12 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI 12C QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI A1 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI A2 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI A2LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI A3 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 8 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 8 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 9SE/MI PLAY QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 9/9 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 10 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 10T QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 11T QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 11 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 11 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 12 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 12 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD MI 13 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 5 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 5 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 6 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 6 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 7 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 7 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 8 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 8T QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 8 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 9 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 9S/9 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 10/10S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 11/11S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 10 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 11 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 12 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REDMI NOTE 12 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO M3 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO M3 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO X3 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO C40 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO X5 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD POCO X5 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P20 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P20 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P30 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P30 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P40 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P40 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P SMART 2019 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P SMART 2020 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P SMART 2021 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI P SMART Z QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI MATE 20 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI MATE 20 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y5 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y5 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y6  QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y6 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y7 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y7 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y8 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HUAWEI Y8 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 8X QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 9X QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X5 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X6 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X7 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X7A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X8 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X8A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR X9 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 8A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 8S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 9A QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 9C QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 10 LITE QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 20/20PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD HONOR 7C QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C2 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C3 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C11 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C21Y /C25Y QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C30S QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME C33 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME 5 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME 9I QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD REALME 6 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 5 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 6 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 7/8 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 6+/7+/8+ QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 11/XR QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH X/XS/11PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH XS MAX/11 PRO MAX QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 12/12PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 12 PROMAX QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 13/13 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 13 PROMAX QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 14 QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 14 PLUS QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 14 PRO QUTUSUZ','','0.8',3,0),
('$f_date', '$y_date', 'GLASS HD IPH 14 PRO MAX QUTUSUZ','','0.8',3,0); ";

$stmt = $dbpdo->prepare($query);
$stmt->execute();


function get_glass_category() {
   return ls_db_request([
        'table_name' => 'stock_category',
        'col_list' => '*',
        'base_query' => ' WHERE category_name LIKE :category_name  ',
        'param' => [
            'query' => [
                'bindList' => [
                    ':category_name' => 'GLASS'
                ]
            ]
        ]
    ]);
}

function insert_imported_products_category($id) {
    ls_db_upadte([
        'before' => " UPDATE stock_list SET ",
        'after' => " WHERE stock_name LIKE :glass ",
        'post_list' => [
            'glass' => [ 
                'query' => false,
                'bind' => 'glass',
                'require' => true
            ],            
            'id' => [
                'query' => ' product_category = :id ',
                'bind' => 'id'
            ]
        ]
    ], 
    [
        'glass' => "%GLASS%",
        'id' => $id,
    ]);
}


$tt = get_glass_category();

if(empty($tt)) {
    add_new_category([
        'add_category_name' => 'GLASS'
    ]);

    $new = get_glass_category();

    return insert_imported_products_category($new[0]['category_id']);

} else {

    return insert_imported_products_category($tt[0]['category_id']);
}