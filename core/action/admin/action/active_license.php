<?php 



    require $_SERVER['DOCUMENT_ROOT'].'/db/config.php';
    require $_SERVER['DOCUMENT_ROOT'].'/core/function/db.wrapper.php';
    //upd  
    require $_SERVER['DOCUMENT_ROOT'].'/private.function.php';
    require $_SERVER['DOCUMENT_ROOT'].'/core/function/user.function.php';
    require $_SERVER['DOCUMENT_ROOT'].'/include/lib_include.php';

    header('Content-type: Application/json');

    if(!empty($_POST['data'])) {
        $key = $_POST['data'];

        $license_hasg = get_license_hash();
    
        if(md5($key) == $license_hasg) {
            active_new_license();
        } else {
            echo  json_encode([
                'alert_type' => 'error',
                'text' => 'Key is incoccert'
            ]);
        }


    } else {
        echo json_encode([
            'alert_type' => 'error',
            'text' => 'Key is incoccert'
        ]);
    }

