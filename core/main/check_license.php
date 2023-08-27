<?php

// $lincence_check = $dbpdo->prepare("SELECT * FROM licence");
// $lincence_check->execute();

// $lince_check_row = $lincence_check->fetch();

// $lincence_status = $lince_check_row['licence_active'];

// if($lincence_status == 0)
// {
// 	header('Location: licence.php');
// 	exit();
// }

// if($lincence_status == 1)
// {
// 	$licence_deactive_date = $lince_check_row['licence_active_deactive'];
// }

if(ntp()) {
    $today = ntp();
} else {
    $today = get_my_datetoday();
}

$expired_licese_date = get_license_expired_date();

return check_license_expired($today, $expired_licese_date);