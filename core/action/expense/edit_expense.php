<?php header('Content-type: Application/json');

	use Core\Classes\Services\Expenses;

	$expense = new Expenses;

/**
 * исправить массив что бы выдывал только 1 результат
 * в js дописать js функцию update_table_row 
 * добавить в function.php id к каждой строке в табице для обновления резальутатата
 */

if(!empty($_POST['data']) && count($_POST['data']) > 1) {
	$expense->editExpense($_POST['data']);
	return $utils::abort([
		'type' => 'success',
		'text' => 'Ok'
	]);
} else {
	echo json_encode([
		'type' => 'error',
		'text' => 'Вы ничего не изменили'
	]);
}
