<?php 

$Checkout = new \Core\Classes\Cart\Checkout;

$postData = $_POST['data'];

// если корзина пустая, то выводим сообщение
if(!isset($postData['cart'])) {
    return $utils::abort([
        'type' => 'error',
        'text' => 'Səbət boşdur'
    ]);
}


// способ оплаты
$payment_method = $postData['payment_method'];
// продавец
$sales_man = $postData['sales_man'];
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
        return $utils::abort([
            'type' => 'error',
            'text' => 'Заполните все поля!'
        ]);
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

    $stock_row = $products->getProductsById($id);


     // в запросе указано, если в заказе указано количесто больше чем есть в базе, то вывести пустой результат
    // if(empty($stock_row)) {
    //     return alert_error('no result');
    // }


    $Checkout->checkoutOrder([
        'ProductsData' => $stock_row,
        'id'           => $id,
        'order_price' => $order_price,
        'order_count' => $order_count,
        'description' => $description,
        'payment_method' => $payment_method,
        'sales_man' => $sales_man,
        'transaction_id' => $transaction_id,
    ]);
}


return $utils::abort([
    'type' => 'success',
    'text' => 'Ok!'
]);
