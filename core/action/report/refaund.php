<?php

use Core\Classes\System\Utils;

header('Content-type', 'Application/json');

$report = new \Core\Classes\Report;

if(!empty($_POST['report_id'])) {
	return $report->deleteOrder($_POST);
} else {
	return Utils::errorAbort('Emty result');
}


