$(document).ready(function() {


/** 
 * START report 
 * удаление отчёта
 */
$(document).on('click', '.report-refaund-btn', function(){
    //id - отячёта
    var report_order_id = $('.report_order_id').data('id');
  
    $.ajax({
        url: 'ajax_route.php',
        type: 'POST',
        data: {
			route: 'deleteOrder',
			url: 'core/action/report/refaund.php',
            report_id: report_order_id
        },
        dataType: 'json',
        success: (data)=> {
            if(data.type == 'success') {
				pageData.rightSideModalHide();
				pageData.overlayHide();

                $(`.get_report_order_id[data-sort-value="${report_order_id}"]`).closest('.stock-list').remove();
            }
			
            pageData.alert_notice(data.type, data.text);
            
        }
    });
});
/** END report */

/**
 * Удалить отчет
 */
$(document).on('click', '.report-return-btn-modal', function() {
	var data = $(this).data('value');

	remove_modal();

	$.ajax({
		type: 'POST',
		url: 'core/action/report/refaund_modal.php',
		data: {data: data},
		dataType: 'json',
		success: (data) => {
			$('.container').append(data.res);
		}
	});
});


$(document).on('click', '.edit-report-order', function() {
	const prepare = prepare_form_data(
		$(this).closest('.modal_order_form'),
		'.edit-report-order-input.edited',
		'fields-name'
	);


	const id = $(this).closest('.modal_order_form').find('.report_order_id').attr('data-id');

	let $item = $(this).closest('.modal_order_form').find('.button-tags');
	let class_list = $item.attr('data-old-class');

	
	$(`#${id}.stock-list`).find('.res-payment-tags').find('.mark').attr('class', '').addClass(class_list).html($item.text());


	$.ajax({
		url: 'ajax_route.php',
		type: 'POST',
		dataType: 'json',
		data: {
			route: 'editReport',
			url: 'core/action/report/edit.php',
			prepare: prepare,

		},
		success: (data) => {
			if(data.type == 'success') {
				for (key in prepare) {
					pageData.update_table_row(key, prepare[key], id);
				}
			}

			pageData.alert_notice(data.type, data.text);		
		}
	});
});

});