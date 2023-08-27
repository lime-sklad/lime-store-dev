<?php
require $_SERVER['DOCUMENT_ROOT'].'/db/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/function/db.wrapper.php';
//upd  
require $_SERVER['DOCUMENT_ROOT'].'/private.function.php';
require $_SERVER['DOCUMENT_ROOT'].'/core/function/user.function.php';
require $_SERVER['DOCUMENT_ROOT'].'/include/lib_include.php';

$image_dir = array_diff(scandir('img/pattern/'), array('.', '..'));

$random_main_background_image = $image_dir[array_rand($image_dir, 1)];

echo $twig->render('/component/include_component.twig', [
    'renderComponent' => [
        '/component/index/head.twig' => [
            'lib_list' => [
                'css' => [
                    'css/fonts.css',
                    'css/style_var.css',
                    'css/template.css',
                    'css/animate.min.css',
                    'lib/css_lib/line-awesome/css/line-awesome.min.css',
                    'css/new.style.css'
                ],
                'script' => [
                    'lib/js_lib/jquery-3.3.1.min.js',
                    'js/upd.ajax.js',
                    'js/upd.function.js',
                                
                ]
            ],
            'v' => time() 
        ],
        '/component/license/license_active.twig' => [
            'user_licence_key' => get_license_sault_key(),
            'main_image' => $random_main_background_image
        ],			
    ]
]); 