<?php header('Content-type: Application/json');

use Core\Classes\Services\Expenses;

$expense = new Expenses;

//удалить товар
if(isset($_POST['id']) && !empty($_POST['id'])) {

	$rasxod_id = $_POST['id'];
	
	$expense->deleteExpense($rasxod_id);
	
	return $utils::abort([
		'type' => 'success',
		'text' => 'Ok'
	]);

} else {
	echo json_encode(['error' => 'Cant find id']);
}
