<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

header('Content-type', 'Application/json');

$report = new \core\classes\report;

echo $report->edit($_POST);

