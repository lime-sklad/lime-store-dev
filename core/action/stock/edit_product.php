<?php
header('Content-type: Application/json');

$postData = $_POST['data'];


$stock_id = $postData['product_id'];

// добавляем новую категорию для товара (не создаем категория, а добавляем уже существующую для товра )
if(!empty($postData['new_added_category']) && !empty($postData['product_id'])) {
	$products->setProductCategory($stock_id, $postData['new_added_category']);
}

// если нужно изменить категория товара
if(!empty($postData['edited_category'])) {
	$products->editProductCategory($postData['edited_category']);
}

// если нужно удалить категория товара
if(!empty($postData['deleted_category'])) {
	$products->deleteProductCategory($postData['deleted_category']);
}


if(!empty($postData['new_added_provider'])) {
	$products->setProductProvider($stock_id, $postData['new_added_provider']);
}

if(!empty($postData['edited_provider'])) {
	$products->editProductProvider($postData['edited_provider']);
}

if(!empty($postData['deleted_provider'])) {
	$products->deleteProductProvider($postData['deleted_provider']);
}


/**
 * исправить массив что бы выдывал только 1 результат
 * в js дописать js функцию update_table_row 
 * добавить в function.php id к каждой строке в табице для обновления резальутатата
 */

 $data = $postData['prepare_data']; 	


if(!empty($data) && count($data) > 1) {
	$products->editProduct($data);

	$productsFilter->editProductFilter($data, $data['upd_product_id']);
	
	return $utils::abort([
		'type' => 'success',
		'text' => 'Updated'
	]);
} else {
	return $utils::abort([
		'type' => 'error',
		'text' => 'Вы ничего не изменили'
	]);	
}
