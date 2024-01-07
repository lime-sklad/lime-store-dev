<?php 

if(!isset($_SESSION['user'])) {
    $login_dir = '/login.php';
	header("Location: $login_dir");
	exit();      
}