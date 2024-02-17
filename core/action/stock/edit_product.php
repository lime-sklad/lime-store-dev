<?php
header('Content-type: Application/json');

$postData = $_POST['data'];

$stock_id = $postData['product_id'];

$advanced = $postData['advanced'] ?? null;

// добавляем новую категорию для товара (не создаем категория, а добавляем уже существующую для товра )
if(!empty($advanced['new_added_category']) && !empty($postData['product_id'])) {
	$products->setProductCategory($stock_id, $advanced['new_added_category']);
}

// если нужно изменить категория товара
if(!empty($advanced['edited_category'])) {
	$products->editProductCategory($advanced['edited_category']);
}

// если нужно удалить категория товара
if(!empty($advanced['deleted_category'])) {
	$products->deleteProductCategory($advanced['deleted_category']);
}


if(!empty($advanced['new_added_provider'])) {
	$products->setProductProvider($stock_id, $advanced['new_added_provider']);
}

if(!empty($advanced['edited_provider'])) {
	$products->editProductProvider($advanced['edited_provider']);
}

if(!empty($advanced['deleted_provider'])) {
	$products->deleteProductProvider($advanced['deleted_provider']);
}


/**
 * исправить массив что бы выдывал только 1 результат
 * в js дописать js функцию update_table_row 
 * добавить в function.php id к каждой строке в табице для обновления резальутатата
 */

 $prepare_data = $postData['prepare_data']; 
 
 if(empty($advanced) && count($prepare_data) < 2) {
	return $utils::abort([
		'type' => 'error',
		'text' => 'Вы ничего не изменили'
	]);		
} 

if(!empty($prepare_data) && count($prepare_data) > 1) {
	$products->editProduct($prepare_data);
	$productsFilter->editProductFilter($prepare_data, $prepare_data['upd_product_id']);
}

return $utils::abort([
	'type' => 'success',
	'text' => 'Updated'
]);



