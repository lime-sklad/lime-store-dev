<?php 
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


// deprecated
// require_once 'function.php';
// require_once 'vendor/autoload.php';

// пока что уберем 
// require_once $_SERVER['DOCUMENT_ROOT'].'/core/function/update.function.php';
// require $_SERVER['DOCUMENT_ROOT'].'/core/main/check_license.php';



	require_once 'start.php';


	if(!isset($_SESSION['user'])) {
		$login_dir = '/login.php';
		header("Location: $login_dir");
		exit();      
	}


	$sysConfig = new \Core\Classes\System\SystemConfig;
	$updater = new \Core\Classes\System\Updater;
	$user = new \Core\Classes\Privates\User;


	$image_dir = array_diff(scandir('img/pattern/'), array('.', '..'));

	$random_main_background_image = $image_dir[array_rand($image_dir, 1)];
	
	
	echo $twig->render('/component/include_component.twig', [
		'renderComponent' => [
			'/component/index/head.twig' => [
				'lib_list' => $sysConfig->loadAssets(),
				'v' => time() 
			],
			'/component/widget/notice.twig' => [
				//code
			],
			'/component/related_component/body_preloader.twig' => [
				//data
			],
			'/component/related_component/overlay.twig' => [
				//data
			],
		]
	]);
	
	echo $twig->render('/component/related_component/main_page.twig', [
		'renderComponent' => [

			'/component/index/show_current_version.twig' => [
				'current_version' => $updater->getCurrentVersion()
			],

			// sidebar
			'/component/index/sidebar.twig' => [
				'menu_list' => [
					'data' => $main->getMenuList()
				],
			],

			// main content
			'/component/container.twig' => [
				'includs' => [
					'renderMain' => [
						// header
						'/component/index/top_nav_content/top_nav.twig' => [							
							'includs' => [
								'renderTopNavComponent' => [
									'/component/index/top_nav_content/nav_list_options.twig' => [
										'username' => $user->getUser('get_name'),
										// вложеность в шаблоне, рендерим друигие шаблоны
										'includs' => [
											'renderUpdateNotify' => [
												'/component/notify/update/update_notify_item.twig' => [
													'notify' => [
														// 'expired_notify' => license_expired_notify(),
														// 'update_notify' => is_check_update()
													]
												]
											],
										],
									]
								],
							]
						],

						// menu
						'/component/main/menu_list.twig' => [
							'menu' => $main->getMenuList(),
							'main_image' => $random_main_background_image
						],	
						
						// main
						'/component/main/main.twig' => [
							//data
						],
						
						// modal
						'/component/modal/modal_wrapper.twig' => [
							//data
						],
						

					]
				]
			]
		],
	]);