<?php 
return [
			'tab' => [
				'is_main' => false,
				'title'		 		=> 'Təchizatçı',
				'icon'				=> [
					'img_big'		 	=> 'img/svg/070-file hosting.svg',
					'img_small'			=> '',
					'modify_class' 		=> 'las la-user-cog'
				],
				'link'  			=> '/page/base.php',		
				'template_src'      => '/page/base_tpl.twig',
				'background_color'  => 'rgba(72, 61, 139, 0.1)',
				'tab' => array(
					'list' => [
						'tab_provider_form',
					],
					'active' => 'tab_provider_form'
				)
			],			
			'sql' => [
				'table_name' => ' stock_provider as tb ',
				'col_list'	=> '*',
				'base_query' =>  " INNER JOIN stock_provider ",
				'param' => array(
					'query' => array(
						'param' => ' ON stock_provider.visible = "visible" ',
						"joins" => " ",		
						'bindList' => array(
						)
					),
					'sort_by' => " GROUP BY stock_provider.provider_id DESC ORDER BY stock_provider.provider_id DESC "
				),	
			],
			'page_data_list' => [
				'sort_key' => 'provider_id',
				'get_data' => [
					'id' => 'provider_id',
					'provider_name' => 'provider_name',
					'edit'	   => null
				],
				'table_total_list'	=> [
				],
				'modal' => [
					'template_block' => 'edit_modal',
					'modal_fields' => array(
						'provider_id' => [
							'db' 			=> 'provider_id', 
							'custom_data' 	=> false, 
							'premission' 	=> true
						],
						'provider_name' => [
							'db' 			=> 'provider_name',
							'custom_data'	=> false,
							'premission'	=> true
						],
						'save_provider' => [
							'db' 			=> false,
							'custom_data'	=> false,
							'premission'	=> true
						],
						'delete_provider' => [
							'db' 			=> 'provider_id',
							'custom_data'	=> false,
							'premission'	=> true	
						],												 
					)	
				],
				'filter_fields' => [
				],
				'form_fields_list' => array(
					[
						'block_name' => 'add_provider_name',
					],
					[
						'block_name' => 'add_save_provider',
					],
				),
			]
];		