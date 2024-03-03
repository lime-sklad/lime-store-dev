<?php header('Content-type: Application/json');

use Core\Classes\Services\Expenses;

$expense = new Expenses;

if(!empty($_POST) && count($_POST['post_data']) > 0) {
	try {
		$expense->addExpense($_POST['post_data']);
		
		echo json_encode([
			'type'	 => 'success',
			'text' => 'ok',
		]);	
	} catch (Exception $e) {
		echo json_encode([
			'text' => "Ошибка",
			'type' 	=> 'error'
		]);
	}
}