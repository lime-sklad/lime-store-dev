console.log('HARA BAXIRSAN, ALA ?')

/** GLOBAL START */
//показать индинтификатор страницы
$(document).ready(function(){

  // delete this
  // var image_num = Math.floor(Math.random() * (8 - 1) + 1);

  // const image_name = [
  //   '2.jpg',
  //   '4.jpg',
  //   '5.jpg',
  //   '10.jpeg',
  //   '11.jpg'
  // ];

  // const random_img = Math.floor(Math.random() * image_name.length);

  // $('.menu').css({
  //   'background-image' : `url(img/pattern/${image_name[random_img]})`
  // });

  //delete this


  pageData = {
    page: function() {
      // получаем страницу
      return $('.table').find('.table-list').data('stock-page');    
    },
    type: function() {
      // получаем тип данных
      return $('.table').find('.table-list').data('stock-type');
    },
    innerTable: function(data) {
      // заполняем таблицу данными 
      $('.table-list').html(data);
    },
    prependTable: function(data) {
      // заполняем таблицу данными 
      $('.table-list').prepend(data);
    },    
    appendTable: function(data) {
      // заполняем таблицу данными 
      $('.table-list').append(data);
    },    
    update_table_row: function(key, value, id) {
      const $this = $(`#${id}.stock-list`);
      const amimate_delay = 1500;
      switch (key) {
        case 'product_name':
          $this.find('.res-stock-name').find('.stock-list-title').html(value);
          break;

        case 'product_description':
          $this.find('.res-stock-description').find('.stock-list-title').html(value);
          break;  
          
        case 'product_first_price':
          $this.find('.res-stock-first-price').find('.stock-list-title').html(value);
          break;    

        case 'product_second_price':
          $this.find('.res-stock-second-price').find('.stock-list-title').html(value);
          break;  

        case 'change_product_count':
          $this.find('.res-stock-count').find('.stock-list-title').html(value);
          break; 
          
        case 'plus_minus_product_count':
          $this.find('.res-stock-count').find('.stock-list-title').html(value);
          break;
          
        case 'append_stock_count':
          let append_count = $this.find('.res-stock-count').find('.stock-list-title').html();
          append_count = parseInt(append_count) + parseInt(value);
          $this.find('.res-stock-count').find('.stock-list-title').html(append_count);
          break;          

        case 'provider_name_text':
          $this.find('.res-stock-provider').find('.stock-list-title').html(value);
          break;  

        case 'category_name_text':
          $this.find('.res-stock-category').find('.stock-list-title').html(value);
          break;   
          
        case 'upd_category_name': 
          $this.find('.res-category-name').find('.stock-list-title').html(value);
          break;  

        case 'upd_provider_name':
          $this.find('.res-edit-provider-name').find('.stock-list-title').html(value);

        case 'upd_rasxod_description':
          $this.find('.res-rasxod-description').find('.stock-list-title').html(value);
          break;
        

        case 'edit_report_order_note': 
          $this.find('.res_note').find('.stock-list-title').html(value);
        break;             

        case 'upd_rasxod_amount': 
          $this.find('.res-rasxod-amount').find('.stock-list-title').html(value);
          break; 
        case 'filter_name': 
          $this.find('.res-filter-name').find('.stock-list-title').html(value);
          break; 
        case 'edit_seller_name': 
          $this.find('.res-seller-name').find('.stock-list-title').html(value);   
          break; 
        case 'edit_seller_password': 
          $this.find('.res-seller-password').find('.stock-list-title').html(value);  
        break;

        case 'edit_warehouse_name': 
          $this.find('.res-warehouse-name').find('.stock-list-title').html(value);
          break;       

        case 'edit_payment_method_name':
          $this.find('.res-payment-method-title').find('.stock-list-title').html(value);
          break;  
      }



    $this.addClass('modify', amimate_delay);

    setTimeout(() => {
      $this.removeClass('modify');
    }, amimate_delay);


    },
    innerTableFooter: function(data) {
      //заполняем футор таблицы данными
      $('.tfoot_body').html(data);
    },
    preloaderShow: function() {
      $('.body_prelodaer').find('.preloader').removeClass('hide').addClass('flex-cntr'); 
    },
    preloaderHide: function() {
      $('.body_prelodaer').find('.preloader').removeClass('flex-cntr').addClass('hide');
      // setTimeout(function() {
      // }, 10);
    },
    rightSideModal: function(data) {
      var $modal_wrp = $('.module_fix_right_side');
      
      $modal_content = $modal_wrp.find('.modal_view_stock_order');
      $modal_wrp.removeClass(['animate__slideOutRight', 'hide'])
                .addClass('animate__slideInRight');
      $modal_content.html(data);
    },
    rightSideModalHide: function() {
      $modal_wrp = $('.module_fix_right_side');
      
      $modal_wrp.removeClass('animate__slideInRight')
                .addClass('animate__slideOutRight')
                .find('.modal_view_stock_order');

      // с задержкой в 300мс удаляем содержимое
      setTimeout(() => {
        $modal_wrp.find('.modal_view_stock_order').empty();
      }, 300);
                

    },
    overlayShow: function() {
      $('.overlay').show();
    },  
    overlayHide: function() {
      $('.overlay').hide();
    },
    overlayToggle: function() {
      $('.overlay').toggle();
    },
    alert_notice: function(type, text) {
      var $notice = $('.notice');  
      
      $notice.addClass('notice-active').html(text);

      setTimeout(() => {
        $notice.removeClass('notice-active');
      }, 2500);


      switch (type) {
          case 'success':
              $notice.removeClass('error-notice').addClass('success-notice');
            break;
          case 'error': 
              $notice.removeClass('success-notice').addClass('error-notice');
          default:
            break;
        }
    }
  };

});
/** GLOBAL END  */

/** Валидация инпутов start */
$('body').on('focusout input', '.input-validate-length', function(){
  var val = $(this).val();
  input_validate_lenght(val, $(this));
});

$('body').on('focusout input', '.input-required', function(){
  var val = $(this).val();
  val.trim().length == 0 ? $(this).addClass('input-required-error') : $(this).removeClass('input-required-error');
});

$('body').on('focusout input', '.input-validate-price', function(){
  var val = $(this).val();
  var preg_val = input_validate_price(val);
  $(this).val(preg_val);
});

$('body').on('focusout keyup input', '.input-validate-count', function(){
  var $this = $(this);
  var val = $this.val();
  var preg_val = input_validate_count(val);

  $this.val(preg_val);
});

function input_validate_lenght(val, $this) {
  val.trim().length == 0 ? alert_vlidate_notice($this) : hide_validate_notice($this);
}

function input_validate_price(price) {
  var price = price.replace(',', '.' );
  var price = price.replace(/[^.\d]+/g,"");
  var price = price.replace( /^([^\.]*\.)|\./g, '$1');
  return price; 
}

function input_validate_count(count) {
  var count = count.replace(/[^.\d]+/g,"").replace(/[^,\d]+/g,"");
  var count = count.replace(/^0/,'');
  return count;
}

function input_validate_min_max_count(min, max, $this) {
  var val = $this.val();
  var preg_val = input_validate_count(val);

  if(preg_val && preg_val <= min) {
    $this.val(min);
  }
  else if(preg_val > max) {
    $this.val(max);
  } else {
    $this.val(preg_val);
  }
}



//валидация инпутов
function validate_all_input($item) {
  if($item.hasClass(['input-validate-length' || 'input-validate-price' || 'input-validate-count'])) {
    $item.trigger('input', 'keyup');
    
    if($('.input-validate-error').length) {
      pageData.alert_notice('error', 'Bütün sahələri doldurun');
      return false;
    }
    return true;  
  }
}

//валидация обьязательных полей
function is_required_input($item) {
  if($item.hasClass('input-required')) {
    $item.trigger('input', 'keyup');
  }

  if($item.hasClass('input-required-error')) {
      pageData.alert_notice('error', 'Bütün sahələri doldurun');
      return false;
  } else {
    return true;
  }
}



function alert_vlidate_notice(el) {
  hide_validate_notice(el);
  el.addClass('input-validate-error');
}

function hide_validate_notice(el) {
  el.removeClass('input-validate-error');
  el.parent().find('.warning-notice').remove();
}
/** Валидация инпутов end  */



/** menu start 
 * 
 * показывать бокове меню при наведении с задержкой в 700 мс 
 * 
 */
$(function () {
    let timeoutId = null;
    $(".sidebar").hover(
      function () {
        timeoutId = setTimeout(() => {
          $(this).addClass("sidebar_hovered");
        }, 500);
      },
      function () {
        // change to any color that was previously used.
        clearTimeout(timeoutId);
        $(this).removeClass("sidebar_hovered");
      }
    );
});

//при нажатии убираем активуню вкладку в боковом меню и открываем основное меню
$('body').on('click', '.get_main_page', function(){
  $('.sidebar-list').removeClass('sidebar-active');  
  visible_menu('show');
});

/** открываем меню */ 
function visible_menu(param) {
  var class_list = [
    'menu--active',
    'animate__animated',
    'animate__faster', 
    'animate__slideInRight '
  ];

  if(param == 'show') {
    $('.menu').addClass(class_list);

    $('.sidebar').addClass('hide').removeClass([
      'animate__animated',
      'animate__slideInLeft',      
    ]);
  }

  if(param == 'hide') {
    $('.menu').removeClass(class_list);

    $('.sidebar').removeClass('hide').addClass([
      'animate__animated',
      'animate__slideInLeft',      
    ]);
  }
}

//левое бокове меню
function ui_selected_sidebar(tab) {
  $('.sidebar-item').removeClass([
    'sidebar-active',
  ]);

  $(`.sidebar-item[data-tab="${tab}"]`).addClass([
    'sidebar-active',
  ]);
}

//активируем вкладку
function ui_selected_tab() {
  $active_tab = $('.tab_activ');

  $active_tab.ready(function(){
    var $tab = $active_tab.closest('.tab');
      
    // //настроить ширину для меню навигации вкладок
      var active_tab_width  = $tab.width();
      var offset = $tab.position();      
    
      $('.tab-selected-mark').css({
        width : active_tab_width,
        left : offset.left
      });
  });
}

/** menu start */
function notice_modal() {
}

//при навелении на модально окно убирать прокуртку у боди
$(document).on('click', '.scroll_top', function(){
	var $body = $("html, body, .wrapper, .menu");
	 $body.stop().animate({scrollTop:0}, 500, 'swing', function(evt) {
	 });
});



/** start widget button */

//открывам виджет и закрываем остальные
$(document).on('click', '.area-button', function(){
  var $this = $(this);
  var $button = $('.area-button'); 

  var content_modify_class = [
    'animate__animated',
    'animate__lsFadeIn25',
    'animate__faster',
    'area-active'
  ];

  var area_active = 'area-active';

  if($(this).hasClass('not-closeable')) {
    $this.addClass(area_active);
  } else {
    $this.toggleClass(area_active);
  }

  open_dropdown($this, content_modify_class);
});


$(document).on('focusin', '.area-input', function(){
  $this = $(this);
  var area_active = 'area-active';

  var content_modify_class = [
    'animate__animated',
    'animate__lsFadeIn25',
    'animate__faster'
  ];

  $this.addClass(area_active);
  open_dropdown($this, content_modify_class);
});

$(document).on('keydown keyup', '.search-auto, .scroll-auto', function(e){
  let keyCode = {
    'up': e.key == 'ArrowUp',
    'down': e.key == 'ArrowDown',
    'enter': e.key == 'Enter',
    'tab': e.key == 'Tab'
  };

  if(keyCode.up || keyCode.down || keyCode.enter || keyCode.tab) {
    e.preventDefault();

    if(e.type == 'keydown') {
      let node;
      let unselect;
  
      var list = $(this).closest('.search-container').find('.search-content').find('.search-list-content li');
      
      var modify_selected = 'selected';
      var node_selected = $(list).find('.selected');
      var children_element = $('.select-item');
  
      let get_selected_node = list.find(node_selected);

      if(keyCode.enter) {
        get_selected_node.trigger('click');
        $(this).blur();
      }

      unselect = get_selected_node.removeClass(modify_selected);
      ui_unselect_nav(unselect);
  
      if(keyCode.down || keyCode.tab) {
        if (node_selected.parent().next().length == 0) {
          node = list.first();
        } else {
          node = node_selected.parent().next();
        }
      }
  
      if(keyCode.up) {
        if(node_selected.parent().prev().length == 0) {
          node = list.last();
        } else {
          node = node_selected.parent().prev();
        }
      }
      
      if(node) {    
        $('.wrapper').css('overflow', 'hidden');
        var this_node = node.children(children_element);

        if(this_node.length) {
          this_node[0].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
        }
        
        ui_select_nav(this_node);
      }   
    }    
  } else {
    if(e.type == 'keyup' && $(this).hasClass('search-auto')) {
      send_autocomplete($(this));
    }
  }
});

//нужно что бы закрыть выпадающий список
$(document).on('click', '.selectable-search-item.selected', function(){
  let $input = '';
  var data_text = $(this).children('.widget__button-text').text().trim();
  var $parent = $(this).closest('.search-container');
  


  if($parent.find('.search-auto').length) {
    $input = $parent.find('.search-auto');
    send_autocomplete($input);
    reset_area();
  }

  if($parent.find('.scroll-auto').length) {
    $input = $parent.find('.scroll-auto');
  }

  if($parent.find('.input-select').length) {
     $input = $parent.find('.input-select');
  }

  $input.val(data_text);
});

//при клике закрываем выпадающий список
$(document).on('click', '.area-closeable', function(){
  reset_area($(this));
});
          
$(document).on('click', '.reset-search', function(){
  $this = $(this);
  var $parent = $this.closest('.search-container');
  var $input = $parent.find('.search-action');
  
  //костыль, исправить потом (что бы сбросить поиск, отправляем пустой массив фильтров которе возвращает дефолтноные данные)
  send_filter([]);
});

$(document).on('click', '.reset-input', function(){
  var $input = $(this).closest('.input-container, .search-container, .area-container, .search-container').find('.input');

  reset_input($input);
});


function reset_input($input) {
  $input.val('');
} 

$(document).on('mouseenter', '.select-items', function(){
  $parent = $(this).closest('.select-list');
  var $removebl = $parent.find('.selected');
  var $this = $(this).children('.selectable-search-item');
  ui_unselect_nav($removebl);
  ui_select_nav($this);
});

function ui_select_nav($this) {
  $this.addClass('selected'); 
  $('.wrapper').css('overflow', 'auto');
}

function ui_unselect_nav($this) {
  $this.removeClass('selected');
}

function open_dropdown($this, content_modify_class) {
  reset_area($this);


  var area_container = '.area-container';
  var area_content = '.area-content';
  var area_active = 'area-active';
  $content = $this.closest(area_container)
                      .find(area_content)
                      .first();


  if($this.closest(area_container).find('.sub--select-list')) {
    $this.closest(area_container).find('.sub--select-list').css({
      top : $this.position().top + 40
    });            
  }                      
                      
                      
                      

  if($this.hasClass(area_active)) {
    $content.addClass(content_modify_class).show();
  } else {
    $content.removeClass(content_modify_class).hide();
  }
}

//закрываем все открыте виджеты 
function reset_area($t) {
  var sub_area = 'sub-area';
  var $sub_area_btn = $('.sub-area');
  var $area_button = $('.area-button, .area-input');
  var area_active = 'area-active';
  var area_container = '.area-container';
  var area_content = '.area-content';

  if($t && $t.hasClass(sub_area)) {
    $button = $sub_area_btn;
  } else {
    $button = $area_button;
  }

  $button.each(function(){
    if($(this).not($t).hasClass(area_active)) {
      $(this).removeClass(area_active).closest(area_container).find(area_content).first().hide();
    }
  });
}

//при нажатии на любое место закрываем виджеты
$(document).mouseup(function(e) {
  
  
  var button = $('.area-button, .area-input');
  var container = $('.area-content');
    // if the target of the click isn't the container nor a descendant of the container
  if ( !button.is(e.target) && button.has(e.target).length == 0 && 
       !container.is(e.target) && container.has(e.target).length == 0) {  

    reset_area();
    // $(button).blur();
  }
});

// активируем выбраный фмльтр 
$(document).on('click', '.filter-check', function(){
    $(this).toggleClass('filter-active');

    var filter_list = get_checked_filter();
    ui_prepare_filter();
    send_filter(filter_list);
});

function ui_prepare_filter() {
  var filter_list = get_checked_filter();
  display_filter_checked_count(filter_list);
  ui_display_filter_tags(filter_list);  
}

//получем массив всех активных фильтров на странице
function get_checked_filter() {
  var filter_list = [];
  var data = [];
  $('.checker-list').find('.filter-active').each(function(){
    let filter_name = $(this).closest('.area-container').find('.area-button').find('.widget__button-text').text().trim();
		let filter_id = $(this).attr('id');
    let filter_type = $(this).attr('filter-type');
    let value = $(this).find('.widget__button-text').text().trim();
    let mark = $(this).find('.widget__mark').text();
    filter_list.push({
      filter_id, 
      filter_type, 
      filter_name, 
      value, 
      mark
    });
  });
  
  return filter_list;
}

//счетчик активных фильтров
function display_filter_checked_count(filter_list) {
  $('.filter-container').find('.filter-count').html(filter_list.length);
}

function ui_display_filter_tags(list) {
  var filt_arr = [];

  $parent = $('.checked-filter-list');
  $child = $('.checked-mark-item');

  list.forEach(el => {

    //находим все выбранные фильтры и удаяем те, которых нет в массиве
    $parent.each(function(){
      if($(this).find($child).length) {
        var ardy_id =  $(this).find($child).data('rel-filter-id');

        if(ardy_id !== el.filter_type) {
          $(this).find($child).remove();
        }
      }
    });
 
    if($parent.find(`.checked-mark-item[data-rel-filter-id="${el.filter_type}"]`).length === 0){
      $parent.append(`
        <div  class="checked-mark-item " data-rel-filter-id="${el.filter_type}" > 
          <div class="checked-mark-title">${el.filter_name}</div> 
          <div class="tags-list">
          
          </div> 
        </div>
      `);
    } 


    $this = $parent.find(`.checked-mark-item[data-rel-filter-id="${el.filter_type}"]`);
    if($this.find('.tags-list').find(`.checked-tags[data-filter-chip-id="${el.filter_id}"]`).length === 0) {
      $this.find('.tags-list').append(`
       <a class="checked-tags remove_checked_filter" data-filter-chip-id="${el.filter_id}" href="javascript:void(0)">
          <span class="checked-mark-value">${el.value} ${el.mark}</span>
          <span class="remove-checked-icon flex-cntr">
            <i class="las la-times"></i>
          </span>           
        </a> 
      `);
    }
  });


  if(!$('.checked-filter-list').children() || list.length == 0) {
    // alert('array is empty');  
    $('.checked-filter-list').empty();
  } 
}

$(document).on('click', '.remove_checked_filter', function(){
  $this = $(this);
  id = $this.data('filter-chip-id');

  $(`#${id}.filter-check.filter-active`).trigger('click');
});

function reset_all_filter() {
  $('.filter-check').removeClass('filter-active');
  ui_prepare_filter();
}

/** counter input - счетчик для инпута */
$('body').on('click', '.cart-counter', function(){
  var $input = $(this).parent().find('.cart-counter-input');
  let count = $input.val();

  if($(this).hasClass('cart-plus-count')) {
    count++;
  } 
  if($(this).hasClass('cart-minus-count')) {
    count--;
  }
  
  $input.val(count);
  $input.trigger('input').focus();
});

/** counter end */

/** widget end */

$('body').on('click', '.close_modal_btn, .overlay', function(){
  pageData.rightSideModalHide();
  pageData.overlayHide();

  $('.close-edit-barcode-modal').trigger('click');
});


/** поля которые были изменены start */
  $('body').on('focusout keyup input click', '.edit', function() {
    $(this).addClass('edited');
  });
/** поля которые были изменены end */



$(document).on('click', '.select-hidden-fields-input', function() {
  var get_id = $(this).data('id');
  $(this).closest('.fields')
          .find('.hidden-fields-input')
          .val(get_id)
          .addClass('edited');

  $(this).closest('.fields')
          .find('.reset-filter')
          .val(get_id);
});


//открыть потверждение удаление товара
$(document).on('click', '.open-delete-stock-modal', function(){
  $('.fields-modal-container').fadeIn();
});

//закрыть потверждение удаление товара
$(document).on('click', '.cancle-fields-modal', function() {
  $('.fields-modal-container').fadeOut();
});


// dom live search
$(document).on('keyup', '.dom-live-search', function(){
  var get_value = $(this).val().toLowerCase();

  $(this).closest('.search-container').find('.search-list-content li').filter(function(){
    $(this).toggle($(this).find('.widget__button-text').text().trim().toLowerCase().indexOf(get_value) > -1);
  });
});


// table dom live search
$(document).on('keyup', '.table-dom-live-search', function(){
  var get_value = $(this).val().toLowerCase();

  $(this).closest('.content').find('.table-list tr').filter(function(){
    $(this).toggle($(this).find('.res-rasxod-description').text().trim().toLowerCase().indexOf(get_value) > -1);
  });
});



// собираем поля формы
function prepare_form_fields($this) {
  let prepare_data = {};
  $this.find('.add-stock').each(function(){
    if($(this).data('fields-name')) {
      var data_name = $(this).data('fields-name');
      var val = $(this).val();
      prepare_data[data_name] = val;
    }
  });

  return prepare_data;
}

function prepare_form_data($form_container, find_items, item_attr) {
  let prepare_data = {};
  $form_container.find(find_items).each(function(){
    if($(this).data(item_attr)) {
      var data_name = $(this).data(item_attr);
      var val = $(this).val();
      prepare_data[data_name] = val;
    }
  });

  return prepare_data;
}


// собираем поля формы
function prepare_forms($this, $find_input) {
  let prepare_data = {};
  $this.find($find_input).each(function(){
    if($(this).data('fields-name')) {
      var data_name = $(this).data('fields-name');
      var val = $(this).val();
      prepare_data[data_name] = val;
    }
  });

  return prepare_data;
}


/**
 * custom radio switcher
 */
 $(document).on('click', '.ls-switcher', function() {
  var get_radio_state = $(this).attr('data-radio-state');
  let set_radio_state;

  set_radio_state = get_radio_state == 0 ? 1 : 0;

  $(this).attr('data-radio-state', set_radio_state).val(set_radio_state);
});



$(document).on('click', '.reset-filter', function(){
  
  $(this).closest('.area-container').find('.input-dropdown').val('');
  
  $(this).closest('.fields')
          .find('.hidden-fields-input')
          .val('');
});


// добавить дополнительный инпут
// $(document).on('click', '.append-new-input', function() {
//   var Hdd = $(this).closest('.append-new-input-container').find('.form-fields').clone()[0];

  
//   $(Hdd).find('.input').val('');

//   $(this).parent().before(Hdd);

//   if($(this).hasClass('add-new')) {

//     $(this).closest('.append-new-input-container')
//            .find('.form-fields')
//            .last()
//            .removeClass()
//            .addClass([
//             'fields', 
//             'form-fields', 
//             'background-none', 
//             'inline-flex', 
//             'flex-row',
//            ])
//            .show()
//            .find('.form-input')
//            .addClass('new')
//            .removeClass('edit-filter-option');
 
//   }
  
// });



$(document).on('click', '.remove-fields', function() {
  if($(this).closest('.append-new-input-container').find('.fields').length > 1 ) {
    if($(this).hasClass('hide-fields')) {
      $(this).closest('.fields')
             .hide().addClass('hide').removeClass('fields')
             .find('.form-input')
             .addClass('input-removed')
             .removeClass('edit-filter-option');
    } else {
      $(this).closest('.fields').remove();
    }
  } else {
    $(this).closest('.fields').find('.form-input').val('').addClass('deleted');
  }



});


$(document).on('click', '.close-edit-barcode-modal', function(){
  $('.barcode-edit-modal').remove();
});



$(document).ready(function() {
  $(document).on('click', 'th', function(){

    $('th').removeClass('dom-sort-table');
    $(this).addClass('dom-sort-table');

    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(compareCells($(this).index()))
    this.asc = !this.asc
    if (!this.asc) {
      rows = rows.reverse()
    }
    for (var i = 0; i < rows.length; i++) {
      table.append(rows[i])
    }

    $(this).toggleClass('active');
  });
});

function compareCells(index) {
  return function(a, b) {
    var valA = getCellDataValue(a, index),
      valB = getCellDataValue(b, index)
    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
  }
}

function getCellDataValue(row, index) {
  return $(row).children('td').eq(index).find('.stock-link-text-both').data('sort-value')
}


$(document).on('click', '.convert-to-excel', function() {
  
  // $('#tt').DataTable( {
	//         dom: 'Bfrtip',
	//         buttons: [
	//             'excelHtml5',
	//         ], 
  //   		searching: false,
  //   		paging: false,
  //   		info: false,
	//     } );
  export_excel('xlsx');
});



function export_excel(type, fn, dl) {
    // Acquire Data (reference to the HTML table)
    var table_elt = document.getElementById("tt");
    var wb = XLSX.utils.table_to_book(table_elt, { sheet: "sheet1" });
    return dl ?
      XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
      XLSX.writeFile(wb, fn || ('Lime.' + (type || 'xlsx')));
  
}



function advanced_table_filter(type, fn, dl) {
    // Acquire Data (reference to the HTML table)
  var table_elt = document.getElementById("tableList");

  // Extract Data (create a workbook object from the table)
  var workbook = XLSX.utils.table_to_book(table_elt);

  // Process Data (add a new row)
  var ws = workbook.Sheets["Sheet1"];

  XLSX.utils.sheet_add_aoa(ws, [["Created "+new Date().toISOString()]], {origin:-1})

  const jsonData = XLSX.utils.sheet_to_json(ws, { header: 1 });

  var wbout = XLSX.write(workbook, { bookType: "xlsx", type: "base64" });

  var $container = $('#example');

  $container.handsontable({
      data: jsonData,
      rowHeaders: true,
      colHeaders: th_list,
      height: 'auto',
      width: 'auto',
      readOnly: true,
      // cells : function (row, col, prop) { return { renderer: 'html' }; },
      dropdownMenu: true,
      hiddenColumns: {
        indicators: true
      },
      contextMenu: true,
      multiColumnSorting: true,
      filters: true,
      rowHeaders: true,
      manualRowMove: true,
      language: 'ru-RU',
      columnSummary: [
        {
          sourceColumn: 2,
          type: 'sum',
          reversedRowCoords: true,
          destinationRow: 0,
          destinationColumn: 2,
          forceNumeric: true,
          suppressDataTypeErrors: true,
        },
        {
          sourceColumn: 5,
          type: 'sum',
          reversedRowCoords: true,
          destinationRow: 0,
          destinationColumn: 5,
          forceNumeric: true,
          suppressDataTypeErrors: true,
        },
      ],

      afterGetColHeader: Handsontable.alignHeaders,
      afterGetRowHeader: Handsontable.drawCheckboxInRowHeaders,
      afterOnCellMouseDown: Handsontable.changeCheckboxCell,
      beforeRenderer: Handsontable.addClassesToRows,
      licenseKey: 'non-commercial-and-evaluation' // for non-commercial use only
  });


  // const reader = new FileReader();

  // reader.onload = function (e) {
  //   const data = new Uint8Array(e.target.result);
  //   const workbook = XLSX.read(data, { type: 'array' });

  //   // Преобразование данных в массив для Handsontable
  //   const sheetName = workbook.SheetNames[0];
  //   const worksheet = workbook.Sheets[sheetName];
  //   const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

  //   // Установка данных в Handsontable
  //   hot.loadData(jsonData);
  // };

  // reader.readAsArrayBuffer(file);


}

function remove_modal() {
  $('.modal').remove();
}


$(document).on('click', '.change-button-tags', function() {
	let new_class_list = $(this).data('class-list').trim();

	let old_class_list = $(this).closest('.fields').find('.button-tags').attr('data-old-class').trim();

	$(this).closest('.fields').find('.button-tags').removeClass(old_class_list).addClass(new_class_list).attr('data-old-class', new_class_list);


  if($(this).closest('.fields').find('.button-tags').hasClass('change-button-tags-value')) {
      let val = $(this).attr('value');

    $(this).closest('.fields').find('.button-tags').html(val)
  }
});

$(document).on('dblclick', '.stock-list', function() {
  $(this).find('.info-stock').trigger('click');
});