<?php

use Core\Classes\Utils\Utils;

header('Content-type: Application/json');

/**
 * исправить массив что бы выдывал только 1 результат
 * в js дописать js функцию update_table_row 
 * добавить в function.php id к каждой строке в табице для обновления резальутатата
 */

if(!empty($_POST['prepare_data']) && count($_POST['prepare_data']) > 1) {
	$category->editCategory($_POST['prepare_data']);

} else {
	echo Utils::abort([
		'type'	=> 'error',
		'text' => 'Вы ничего не изменили'
	]);
}
