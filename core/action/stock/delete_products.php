<?php 
header('Content-type: Application/json');

$postData = $_POST['data'];

//удалить товар
if(!empty($postData['stock_id'])) {
	$products->deleteProduct($postData['stock_id']);
	return $utils::abort([
		'type'	=> 'success',
		'text'	=> 'Ok'
	]);
} else {
	return $utils::abort([
		'type'	=> 'error',
		'text' 	=> 'Cant find id'
	]);
}
