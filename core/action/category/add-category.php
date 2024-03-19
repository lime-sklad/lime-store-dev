<?php

use Core\Classes\Utils\Utils;

header('Content-type: Application/json');


if(!empty($_POST) && count($_POST['post_data']) > 0) {
		$category->addCategory($_POST['post_data']);
		
		$this_data = $main->initController(Utils::getPostPage());

		$page_config = $this_data['page_data_list'];

		$table_result = $main->prepareCustomData($category->getLastAddedCategory(), $page_config);

		$table = $Render->view('/component/include_component.twig', [
			'renderComponent' => [
				'/component/table/table_row.twig' => [		
					'table' => $table_result['result'],
					'table_tab' => Utils::getPostPage(),
					'table_type' => Utils::getPostType()
				]  
			]
		]);	

		return $utils::abort([
			'text' => 'ok',
			'type' => 'success',
			'table' => $table
		]);	

}