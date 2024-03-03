<?php

use Core\Classes\Utils\Utils;

 header('Content-type', 'Application/json');

$report = new \Core\Classes\Report;

if(!empty($_POST['prepare'])) {
    $data = $_POST['prepare'];

 echo $report->editReport($data);


} else {
    $utils::abort([
        'type' => 'error',
        'text' => 'Emprty'
    ]);
}



