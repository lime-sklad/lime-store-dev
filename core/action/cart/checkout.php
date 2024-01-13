<?php 

$Products = new \Core\Classes\Products;
$Checkout = new \Core\Classes\Cart\Checkout;

$postData = $_POST['data'];

$error = false;

$total = 0;

$stock_data = [];

$payment_method = $postData['payment_method'];

$sales_man = $postData['sales_man'];

// если корзина пустая, то выводим сообщение
if(!isset($postData['cart'])) {
    return alert_error('Səbət boşdur');
    die;
}

// получаем списко товаров в корзине
$cart_list = $postData['cart'];
// получаем дату (день, месяц, год)
$full_date = $utils->getDateDMY();
// получаем день и месяц
$short_date = $utils->getDateMY();

//ls_generate_transaction_id()
$transaction_id = '';

// перебираем массив товаров в корзине
foreach($cart_list as $row) {
    // проверям на пустые значение - id товара, цены, количества
    if(!isset($row['id'], $row['price'], $row['count']) || empty($row['id'] && $row['price'] && $row['count']) ) {
        // если пустые, то выводим сообщение
        $error = true;
        return alert_error('Заполните все поля!');
    }
    
    // id товара
    $id = (int) $row['id'];
    // цена товара
    $order_price = (float) $row['price'];
    // количество товара
    $order_count = (int) $row['count'];  
    // заметка продажи
    $description = $row['description'];
    
    // если ввели количество 0 или отрицательно значение, то выводим сообщение
    // if($order_count <= 0) {
    //     return alert_error('Заполните поля правильно!');
    // }

    $stock_row = $Products->getProductsById($id);


     // в запросе указано, если в заказе указано количесто больше чем есть в базе, то вывести пустой результат
    // if(empty($stock_row)) {
    //     return alert_error('no result');
    // }


    $Checkout->checkoutOrder([
        'ProductsData' => $stock_row,
        'id' => $id,
        'order_price' => $order_price,
        'order_count' => $order_count,
        'description' => $description,
        'payment_method' => $payment_method,
        'sales_man' => $sales_man,
        'transaction_id' => $transaction_id,
    ]);
}



exit;


return print_alert([
    'type' => 'success',
    'text' => 'OK!'
]);

if($error == false) {
    // $dbpdo->beginTransaction();
    try {
        // добавляем заказ в базу
        ls_db_insert('stock_order_report', $stock_data);

        // полсе добавления товра в базу, обновляем данные товара, уменьшаем количестов товара
        foreach($stock_data as $index => $data) {
            $option = [
                'before' => " UPDATE stock_list SET ",
                'after' => " WHERE stock_id = :stock_id",
                'post_list' => [
                    'stock_id' => [
                        'query' => false,
                        'bind' => 'stock_id'
                    ],
                    'order_stock_count' => [
                        'query' => "stock_list.stock_count = stock_list.stock_count - :product_count",
                        'bind' => 'product_count'
                    ]
                ]
            ];

            ls_db_upadte($option, $data);
        }
        
        $dbpdo->commit();
        
        return print_alert([
            'type' => 'success',
            'text' => 'OK!'
        ]);
    
    } catch (\Throwable $e) {
        $dbpdo->rollback();
        throw $e;
        return alert_error("Детали ( '. $e . ' ) ");
    }
    
    if($error) {
        return alert_error("Неверный запрос \n Обновите страницу и попробуйте еще раз! ");
    }
} 
