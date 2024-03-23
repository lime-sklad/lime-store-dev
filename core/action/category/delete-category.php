<?php 

header('Content-type: Application/json');

//удалить товар
if(isset($_POST['id']) && !empty($_POST['id'])) {

	$cateogry_id = $_POST['id'];

	$category->deleteCategory($cateogry_id);

	echo json_encode([
		'type'	=> 'success',
		'text' => 'ok'
	]);	
} else {
	echo json_encode([
		'type'	=> 'error',
		'text' => 'Cant find id'
	]);
}
