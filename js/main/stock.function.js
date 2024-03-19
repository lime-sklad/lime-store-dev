$(document).ready(function() {




/** update stock */
$('body').on('click', '.submit-save-stock', function() {
	let prepare_data = {};

	const stock_id = $('.edit-stock-id').data('id');

	prepare_data['upd_product_id'] = stock_id;

	$('.edit').each(function(){
		if($(this).data('fields-name') && $(this).hasClass('edited')) {
			var data_name = $(this).data('fields-name');
			var val = $(this).val();
			prepare_data[data_name] = val;
		}
	});


	let edited_category 		= [];
	let new_added_category 		= [];
	let deleted_category 		= [];

	let edited_provider 		= [];
	let new_added_provider 		= [];
	let deleted_provider 		= [];


	// GET EDITED CATEGORY
	$('.edit-product-category').each(function() {
		// если поле не удалнно
		if(!$(this).closest('.form-fields').hasClass('hide')) {
			if($(this).hasClass('edited') && !$(this).hasClass('new')) {
				var old_id = $(this).data('old-id');
				var edited_id = $(this).val();
	
				edited_category.push({
					'product_id': stock_id,
					'old_category_id': old_id,
					'edited_category_id': edited_id 
				});
			}
		}
	});
	
	// GET NEW ADDED CATEGORY
	$('.new.edit-product-category.edited').each(function() {
		var get_new_id = $(this).val();
		
		if(!$(this).closest('.form-fields').hasClass('hide')) {
			new_added_category.push({
				'get_new_id': get_new_id
			});
		}

		$(this).attr('data-old-id', get_new_id);
	});


	// GET DELETED CATEGORY
	$('.edit-product-category').each(function() {
		if($(this).closest('.form-fields').hasClass('hide') && !$(this).hasClass('new')) {
			var deleted_id = $(this).val();

			deleted_category.push({
				'product_id': stock_id,
				'del_id': deleted_id
			});			
		}

		if($(this).closest('.form-fields').find('.deleted').length  && !$(this).hasClass('new')) {
			deleted_category.push({
				'product_id': stock_id,
				'del_id': $(this).val()
			});				
		}
	});	


	// GET EDITED provider
	$('.edit-product-provider').each(function() {
		// если поле не удалнно
		if(!$(this).closest('.form-fields').hasClass('hide')) {
			if($(this).hasClass('edited') && !$(this).hasClass('new')) {
				var old_id = $(this).data('old-id');
				var edited_id = $(this).val();
	
				edited_provider.push({
					'product_id': stock_id,
					'old_provider_id': old_id,
					'edited_provider_id': edited_id 
				});
			}
		}
	});
	
	// GET NEW ADDED provider
	$('.new.edit-product-provider.edited').each(function() {
		var get_new_id = $(this).val();
		
		if(!$(this).closest('.form-fields').hasClass('hide')) {
			new_added_provider.push({
				'get_new_id': get_new_id
			});
		}

		$(this).attr('data-old-id', get_new_id);
	});


	// GET DELETED provider
	$('.edit-product-provider').each(function() {
		if($(this).closest('.form-fields').hasClass('hide') && !$(this).hasClass('new')) {
			var deleted_id = $(this).val();

			deleted_provider.push({
				'product_id': stock_id,
				'del_id': deleted_id
			});			
		}

		if($(this).closest('.form-fields').find('.deleted').length  && !$(this).hasClass('new')) {
			deleted_provider.push({
				'product_id': stock_id,
				'del_id': $(this).val()
			});				
		}		
	});	




	$.ajax({
		type: 'POST',
		url: 'ajax_route.php',
		data: {
			url: 'core/action/stock/edit_product.php',
			route: 'editProduct',
			data: {
				product_id: 		stock_id,
				prepare_data: 		prepare_data,
				advanced: {
					edited_category: 	edited_category,
					new_added_category: new_added_category,
					deleted_category: 	deleted_category,
		
					edited_provider: 	edited_provider,
					new_added_provider: new_added_provider,
					deleted_provider: 	deleted_provider
				}			
			}
		},
		dataType: "json",
		success: (data) => {		
			if(data.type == 'success') {
				for (key in prepare_data) {
					pageData.update_table_row(key, prepare_data[key], stock_id);
				}
			}

			pageData.alert_notice(data.type, data.text);

				/**
				 * это нужно для того что бы повторно не отправлять уже измененные данные
				 * Например мы изменили и удалили категорию, потом нажали "сохранить" 
				 * После изиенили напрмер количество, вместе с количество отпять изменилась бы категория 
				 */
				$('.edit-product-category').removeClass([
					'new',
					'edited'
				]);

				$('.edit-product-provider').removeClass([
					'new',
					'edited'
				])				

				$('.edit-append-stock-count').val('').removeClass('edited');

		}			

	});
});



/** удалить товар start */
$(document).on('click', '.delete-stock', function() {
	const id = $(this).data('delete-id');

	$.ajax({
		type: 'POST',
		url: 'ajax_route.php',
		data: {
			url: 'core/action/stock/delete_products.php',
			route: 'deleteProducts',
			data: {
				stock_id: id
			}
		},
		dataType: 'json',
		success: (data) => {
			pageData.alert_notice(data.type, data.text);
			
			if(data.type == 'success') {
				pageData.rightSideModalHide();
				pageData.overlayHide();

				var $stock = $(`#${id}.stock-list`); 

				$stock.hide(1000, function() {
					$stock.remove();
				});
			}

		}
	});
});
/** удалить товар end */



/** добавить товар товар start */
$('body').on('click', '.submit-stock-addd-form', function() {

	let prepare_data = {};
	let barcode_list = {};
	let category_list = [];
	let provider_list = [];

	if(is_required_input($(this).closest('.stock-from-container').find('.form-input'))) {
		prepare_data = prepare_form_fields($(this).closest('.stock-from-container'));

		$('.add-stock-barcode').each(function(index, el){
			var barcode_value = $(this).val();
				if(barcode_value) {
					var this_fileds = $(this).data('fields-name');
					barcode_list[this_fileds+index] = barcode_value;
				}
		});


		$('.add-new-stock-category').each(function() {
			var cat_id = $(this).val();

			category_list.push({
				'get_new_id': cat_id
			});
		});

		$('.add-new-stock-provider').each(function() {
			var prov_id = $(this).val();

			provider_list.push({
				'get_new_id': prov_id
			});
		});		

		
		
		prepare_data['category_list'] = category_list;
		prepare_data['provider_list'] = provider_list;
		
		prepare_data['stock_barcode_list'] = barcode_list;
		
		$.ajax({
			type: 'POST',
			url: 'ajax_route.php',
			data: {
				url: 'core/action/stock/add_stock.php',
				route: 'addProduct',
				data: {
					prepare_data: prepare_data
				}
			},
			dataType: "json",
			success: (data) => {
				pageData.alert_notice(data.type, data.text);

				if(data.type == 'success') {
					$('.form-input').val('');

				}

			}			

		});
	}
});

/** добавить товар end */





$('body').on('click', '.open-category-form-modal', function() {

	$('.fields').removeClass('opened-custom-modal');

	$(this).closest('.fields').addClass('opened-custom-modal');

	$.ajax({
		url: 'core/action/category/modal_form_category.php',
		type: 'POST',
		dataType: 'json',
		success: (data) => {
			if(data.error) {
				pageData.notice_modal('error', data.error);
			}

			if(data.success) {
				pageData.overlayShow();
				pageData.rightSideModal(data.success);
			}
		}
	});
});



// добавить поставщика
$('body').on('click', '.add-submit-provider', function() {
	let prepare_data = {};

	if($(this).closest('.modal-form').length) {
		if(is_required_input($(this).closest('.modal-form').find('.form-input'))) {
			prepare_data = prepare_form_fields($(this).closest('.modal-form'));
			$.ajax({
				type: 'POST',
				url: 'core/action/provider/modal_add_provider.php',
				data: {
					post_data: prepare_data,
				},
				dataType: "json",
				success: (data) => {
					if(data.success) {
						$('.opened-custom-modal').find('.provider-input-value').val(data.provider_name)
						$('.opened-custom-modal').find('.hidden-provider-id').val(data.provider_id);

						// $('.provider-input-value').val(data.provider_name);
						// $('.hidden-provider-id').val(data.provider_id);

						pageData.rightSideModalHide();
						pageData.overlayHide();
					}
				}			
	
			});
		}
	}

	if($(this).closest('.stock-from-container').length) {
		if(is_required_input($(this).closest('.stock-from-container').find('.form-input'))) {
			prepare_data = prepare_form_fields($(this).closest('.stock-from-container'));
			$.ajax({
				type: 'POST',
				url: 'core/action/provider/add_provider.php',
				data: {
					post_data: prepare_data,
					page: pageData.page(),
					type: pageData.type()
				},
				dataType: "json",
				success: (data) => {
					var error 	= data['error'];
					var success = data['success'];
					
					if(error) {
						pageData.alert_notice('error', error);
					}
	
					if(success) {
						pageData.alert_notice('success', 'Ок');
						$('.form-input').val('');
	
						if(data.table) {
							return pageData.prependTable(data.table);
						}
					}
				}			
	
			});
		}
	}
});

// добавить поставщика в модальном окне
$('body').on('click', '.open-provider-form-modal', function(){
	$('.fields').removeClass('opened-custom-modal');

	$(this).closest('.fields').addClass('opened-custom-modal');

	$.ajax({
		url: 'core/action/provider/modal_form_provider.php',
		type: 'POST',
		dataType: 'json',
		success: (data) => {
			if(data.error) {
				pageData.notice_modal('error', data.error);
			}

			if(data.success) {
				pageData.overlayShow();
				pageData.rightSideModal(data.success);
			}
		}
	});
});



});