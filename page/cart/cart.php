<?php
	$data_page = page_data($page);

	$page_config = $data_page['page_data_list'];
	$user_list_arr = get_all_user_list();

	$get_session_user = getUser();

	$user_list = [];
	// ls_var_dump($user_list);
	

	foreach($user_list_arr as $row => $val) {
		$user_list[] = [
			'custom_value' => $val['user_name'],
			'custom_data_id' => $val['user_id']
		];
	}

	echo $twig->render('/component/inner_container.twig', [
		'renderComponent' => [
			'/component/related_component/include_widget.twig' => [			
				'/component/search/search.twig' => $data_page['component_config']['search']
			],			
			'/component/cart/cart.twig' => [
				'user_data' => [
					'user_list' => $user_list,
					'current_user' => $get_session_user
				],
				'payment_method' => [
					'list' => get_payment_method_list()
				],	
				'page' => $page,
				'type' => 'phone',
				'attribute' => [
					'data-modifed-link' => 'terminal'
				]			
			]
		]
	]);
		
?>