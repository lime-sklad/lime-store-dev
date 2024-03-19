<?php 
    header('Content-type: application/json');
    
    $prepare_data = $_POST['prepare_data'];

    if(array_key_exists('edit_seller_name', $prepare_data)) {
        if(!$user->isUsernameAvailable($prepare_data['edit_seller_name'])) {
            
            return $utils::abort([
                'type' => 'error',
                'text'	=> 'İstifadəçi artıq əlavə edilib'
            ]);

            die();
        } 
    }

    $user->editUser($prepare_data);

    return $utils::abort([
        'type' => 'success',
        'text' => 'Ok'
    ]);