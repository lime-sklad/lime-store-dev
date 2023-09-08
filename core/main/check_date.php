<?php 
header('Content-type: Application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/function.php';

$ntp = ntp();

$content = $twig->render('/component/error_page/correct_date.twig', []);

if($ntp) {
    if(get_my_datetoday() !== $ntp) {
        return print_alert([
            'type' => 'error',
            'content' => $content
        ]);
    }
} else {
    if(is_correct_local_date()) {
        return print_alert([
            'type' => 'error',
            'content' => $content
        ]);
    }
}

return false;