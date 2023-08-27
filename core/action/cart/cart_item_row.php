<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/function.php';

    // header('Content-type: application/json');



if(isset($_POST['items'])) {

    $myPost = $_POST['items'];


    switch ($_POST['mode']) {
        
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
   echo $twig->render($render_tpl_path,  ['items' => $myPost]);
}