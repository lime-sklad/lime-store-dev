<?php 

namespace Core\Classes\Traits;

trait TableHeaderList {
	/**
	 * 
	 * old function name get_th_list
	 */
    public function getTableHeaderList() 
    {
		$th_list = [
			'id' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_serial'),
				'modify_class'	 	=> 'th_w40 dom-sort-table',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> 'id',
				'mark'				=> false				
			),
			'name' => array(
				'is_title'  		=> $this->accessManager->checkDataPremission('th_prod_name'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both filter-hotkey-sort res-stock-name',
				'data_sort' 		=> 'name',
				'mark'				=> false
			),									
			'description' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_description'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-description',
				'data_sort' 		=> 'imeis',
				'mark'				=> false
			),
			'first_price' => array(
				'is_title'  		=> $this->accessManager->checkDataPremission('th_buy_price'),
				'modify_class'		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-first-price',
				'data_sort' 		=> '',
				'mark_text' 		=> '',
				'mark'				=> array(
					'mark_text' 		=> '',
					'mark_modify_class' => 'manat-icon--black button-icon-right stock-list-icon'
				)	
			),
			'second_price' => array(
				'is_title'  		=> $this->accessManager->checkDataPremission('th_sale_price'),
				'modify_class'		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-second-price',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_text' 		=> '',
					'mark_title'		=> 'hekk',
					'mark_modify_class' => 'manat-icon--black button-icon-right stock-list-icon'
				)	
			),	
			'stock_barcode' => array(
				'is_title'  		=> 'Barcode',
				'modify_class'		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> ' stock-link-text-both res-stock-barcode-list',
				'data_sort' 		=> 'stock-barcode-sort',
				'mark'				=> false	
			),
			'report_barcode' => array(
				'is_title'  		=> 'Barcode',
				'modify_class'		=> 'th_w80 hide',
				'td_class' 			=> 'hide',
				'link_class' 		=> 'hide stock-link-text-both res-stock-barcode-list',
				'data_sort' 		=> 'stock-barcode-sort',
				'mark'				=> false	
			),			
			'provider' => array(
				'is_title'  		=> $this->accessManager->checkDataPremission('th_provider'),
				'modify_class'		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-provider',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'return_status' => array(
				'is_title'  		=>  $this->accessManager->checkDataPremission('th_return'),
				'modify_class'		=> 'th_w40',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_modify_class' => 'mark-tags mark-danger width-100 height-100',
					'mark_text' 		=> 'Bəli',
					'mark_title'		=> 'Bu mall vazvrat olunub',
				)
			),												
			'count' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_count'),
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-count',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_text'			=> 'ədəd',
					'mark_title'		=> false,
					'mark_modify_class' => 'button-icon-left mark stock-list-mark'
				)	
			),
			'category' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_category'),
				'modify_class' 		=> 'th_w200',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-stock-category',
				'data_sort' 		=> false,
				'mark'				=> false	
			),
			'stock_add_date' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_buy_day'),
				'modify_class' 		=> 'th_w120',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res_buy_date',
				'data_sort' 		=> 'buy_date',
				'mark'				=> false					
			),
			'sales_date' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_day_sale'),
				'modify_class' 		=> 'th_w120',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res_buy_date',
				'data_sort' 		=> 'buy_date',
				'mark'				=> false
			),
			'sales_time' => array(
				'is_title'			=> 'Saat',
				'modify_class'		=> 'th_120',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both',
				'data_sort'			=> '',
				'mark'				=> false,
			),

			'report_note' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_report_note'),
				'modify_class' 		=> 'th_w120',
				'td_class' 			=> '',
				'link_class' 		=> ' stock-link-text-both res_note',
				'data_sort' 		=> '',
				'mark'				=> false				
			),

			'report_profit' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_profit'),
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> 'mark-success',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_text' 		=> '',
					'mark_modify_class' => 'manat-icon--black button-icon-right stock-list-icon'
				)	
			),	
			'report_sum_amount' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_profit'),
				'modify_class' 		=> 'th_w100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort'			=> '',
				'mark' 				=> false
			),			
			'report_total_amount' => array(
				'is_title' 			=> 'Ümumi məbləğ',
				'modify_class' 		=> 'th_w100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort'			=> '',
				'mark'				=> array(
					'mark_text' 		=> '',
					'mark_modify_class' => 'manat-icon--black button-icon-left stock-list-icon'
				)	
			),			
			
			'report_date_year' => array(
				'is_title' 			=> false,
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> 'date_year',
				'mark'				=> false
			),
			'report_order_id' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_report_serial'),
				'modify_class' 		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both get_report_order_id',
				'data_sort' 		=> '',
				'mark'				=> false
			),
			'report_order_date' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_report_serial'),
				'modify_class' 		=> 'hide',
				'td_class' 			=> 'hide',
				'link_class' 		=> 'hide',
				'data_sort' 		=> 'date',
				'mark'				=> false				
			),
			'report_order_edit' => [
				'is_title' 			=> 'Redaktə',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-pen btn btn-secondary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false				
			],	
			'payment_method' => array(
				'is_title'  		=> 'Ödəniş üsulu',
				'modify_class'		=> 'th_w80',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-payment-tags',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_modify_class' => 'mark-tags mark-warning width-100 height-100 zsdljkfsjfklsj',
					'mark_text' 		=> 'u',
					'mark_title'		=> '',
				)
			),
			
			'payment_method_form' => array(
				'is_title'  		=> 'Ödəniş üsulu',
				'modify_class'		=> 'th_w300',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-payment-method-title',
				'data_sort' 		=> '',
				'mark'				=> array(
					'mark_modify_class' => '',
					'mark_text' 		=> '',
					'mark_title'		=> '',
				)
			),			
			
			'report_sales_man' => array(
				'is_title' 			=> 'Satici',
				'modify_class' 		=> 'th_w40',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> '',
				'mark_is_title'		=> true,
				'mark'				=> array(
					'mark_modify_class' => 'mark mark-tags mark-primary width-100 height-100',
					'mark_text' 		=> 'u',
					'mark_title'		=> '',
				)
			),

			'terminal_add_basket' => array(
				'is_title' 			=> ' ',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las btn add-basket-btn-icon add-basket-button width-100 table-ui-btn la-cart-plus btn-secondary add-to-cart',
				'data_sort' 		=> '',
				'mark'				=> false
			),
			'terminal_basket_count_plus' => array(
				'is_title' 			=> ' ',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las las la-info-circle btn btn-primary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false
			),	
			'terminal_stock_info' => array(
				'is_title' 			=> ' ',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-plus btn btn-primary add-basket-btn-icon width-100 card-plus-count table-ui-btn',
				'data_sort' 		=> '',
				'mark'				=> false
			),							
			'edit_stock_btn' => [
				'is_title' 			=> 'Redaktə',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-pen btn btn-secondary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false				
			],
			'seller_id' => array(
				'is_title' 			=> 'id',
				'modify_class' 		=> 'th_w40',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'seller_name' => array(
				'is_title' => 'Логин',
				'modify_class' 		=> 'th_w300',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-seller-name',
				'data_sort' 		=> 'user_name',
				'mark'				=> false
			),
			'seller_password' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_admin_password'),
				'modify_class' 		=> 'th_w70',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-seller-password',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'seller_role' => array(
				'is_title' 			=> 'Роль',
				'modify_class' 		=> 'th_w70',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-seller-role',
				'data_sort' 		=> false,
				'mark'				=> false
			),
			'seller_edit' => array(
				'is_title' 			=> 'Redaktə',
				'modify_class' 		=> 'th_w40',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-pen btn btn-secondary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false	
			),
			'category_name' => array(
				'is_title' 			=> 'Название Категории',
				'modify_class' 		=> 'w100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-category-name',
				'data_sort' 		=> 'category',
				'mark'				=> false
			),
			'provider_name' => array(
				'is_title' 			=> 'Təchizatçı',
				'modify_class' 		=> 'w100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-edit-provider-name',
				'data_sort' 		=> 'provider',
				'mark'				=> false
			),			
			'edit' => array(
				'is_title' 			=> 'Redaktə',
				'modify_class' 		=> 'th_w60',
				'td_class' 			=> 'table-ui-reset',
				'link_class' 		=> 'las la-pen btn btn-secondary width-100 table-ui-btn info-stock',
				'data_sort' 		=> '',
				'mark'				=> false				
			),
			'rasxod_date' => array(
				'is_title' 			=> $this->accessManager->checkDataPremission('th_report_serial'),
				'modify_class' 		=> 'hide',
				'td_class' 			=> 'hide',
				'link_class' 		=> 'hide',
				'data_sort' 		=> 'rasxod-date',
				'mark'				=> false
			),
			'rasxod_day_date' => array(
				'is_title' 			=> 'Tarix',
				'modify_class'		=> 'th_w120',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both res-rasxod-date',
				'data_sort'			=> 'rasxod-day-date',
				'mark'				=> false
			),
	

			'transfer_full_date' => array(
				'is_title' 			=> 'Tarix',
				'modify_class'		=> 'th_w120',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both',
				'data_sort'			=> 'transfer-day-date',
				'mark'				=> false
			),			

			'rasxod_description' => array(
				'is_title' 			=> 'Tesvir',
				'modify_class'		=> 'th_w300',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both res-rasxod-description',
				'data_sort'			=> 'rasxod-description',
				'mark'				=> false
			),
			'rasxod_amount' => array(
				'is_title' 			=> 'Amount',
				'modify_class'		=> 'th_w60',
				'td_class'			=> 'mark-danger',
				'link_class'		=> 'stock-link-text-both res-rasxod-amount',
				'data_sort'			=> false,
				'mark'				=> [
					'mark_text' 		=> '',
					'mark_modify_class' => 'manat-icon--black button-icon-right stock-list-icon'
				]
			),

			'warehouse_name' => array(
				'is_title' 			=> 'Anbar adı',
				'modify_class'		=> 'th_w200',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both res-warehouse-name',
				'data_sort'			=> false,
				'mark'				=> [
				]
			),	


			'warehouse_contact' => array(
				'is_title' 			=> 'Əlaqə',
				'modify_class'		=> 'th_w100',
				'td_class'			=> '',
				'link_class'		=> 'stock-link-text-both',
				'data_sort'			=> false,
				'mark'				=> [
				]
			),						

			'td_filters_title' => array(
				'is_title' 			=> 'Filter adı',
				'modify_class' 		=> 'width-100',
				'td_class' 			=> '',
				'link_class' 		=> 'stock-link-text-both res-filter-name',
				'data_sort' 		=> 'name',
				'mark'				=> false
			),

			'arrival_added_date' => array(
				'is_title' => 'Alış tarıxı',
				'modify_class' => 'width-60',
				'td_class' => '',
				'link_class' => 'stock-link-text-both res-',
				'data_sort' => 'arrival-date-month-srot',
				'mark' => false
			)

		];
	
		return $th_list;
	}    
}