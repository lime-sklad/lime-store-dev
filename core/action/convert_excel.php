<?php 

require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

// ls_var_dump($_POST);

$file_name = $_SERVER['DOCUMENT_ROOT']."/convert to excel/".$_POST['file'];

$data = $_POST['data'];


file_put_contents($file_name, $data);

// exec($file_name);