<?php 

    // header('Content-type: application/json');

    $data = $_POST['data'];

    
if(isset($data['items'])) {

    $myPost = $data['items'];


    switch ($data['mode']) {
        
        case 'arrivals_products':
            $render_tpl_path = '/component/arrival-products/form/cart-item.twig';
            break;

        case 'write_off_products':
            $render_tpl_path = '/component/write-off-products/form/cart-item.twig';
            break;            
        
        case 'terminal':
            $render_tpl_path = '/component/cart/cart-item.twig';
            break;
        case 'warehouse_transfer_form':
            $render_tpl_path = '/component/warehouse-transfer/cart-item.twig';
            break;    

        default:
            $render_tpl_path = '/component/cart/cart-item.twig';
            break;
    }

    // ls_var_dump($myPost);
   echo $Render->view($render_tpl_path,  ['items' => $myPost]);
}