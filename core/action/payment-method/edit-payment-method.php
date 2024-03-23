<?php
header('Content-type: Application/json');

use Core\Classes\Cart\Payment;
use Core\Classes\Utils\Utils;

$Payment = new Payment;


if(empty($_POST['prepare_data']) || count($_POST['prepare_data']) < 2) {
   echo Utils::abort([
        'type' => 'error',
        'text' => 'Empty'
   ]);  
   exit;
}

$Payment->editPaymentMethod($_POST['prepare_data']);