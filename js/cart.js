/** EXPERIMENTAL */

$(document).ready(function(){

  cart = {
    //** settings */
    cart_list: [],
    is_draw_possible: true,
    /** end settings */

    // рисует данные
    draw: function() {
      
      $('.cart-item').removeClass('in-cart');
      
      let item_list = [];
      
      let data_list = cart.get_cart_list();


      data_list.map(item => {
        $(`.cart-item[data-cart-id="${item.id}"]`).addClass('in-cart');

        // что я в этой строчке делаю 
        if($(`.cart-item[data-cart-id="${item.id}"]`).length <= 0) {
          cart.is_draw_possible = false;
          item_list.push(item);
        }           
      });

      if(item_list.length > 0) {
        $.ajax({
          url: '/core/action/cart/cart_item_row.php',
          type: 'POST',
          data: {
            mode: cart.get_carts_mode(),
            items: item_list
          },
          success: function(data) {
            cart.render(data);
          }
        });    
      }

      $('.cart-item').each(function() {
        if(!$(this).hasClass('in-cart')) {
          $(this).remove();
        }
      });
    },

    // выводит данные в таблиу
    render: function(data) {
      $('.cart').find('.cart-item-list').prepend(data);
      cart.is_draw_possible = true;
    },

    get_carts_mode: function() {
      return $('tbody').data('modifed-link');
    },

    // подготавливает данные
    prepare_data: function(data) {
      var row = data['param'];
      var stock_id = row['stock_id'];
      var stock_name = row['stock_name'];
      var stock_count = row['stock_count'];
      var first_price = row['stock_first_price'];
      var stock_second_price = row['stock_second_price'];



      let myData = {
        id: stock_id,
        name: stock_name,
        first_price: first_price,
        price: stock_second_price,
        description: '',
        count: 1,
        maxCount: stock_count,
      };


      return myData;
    },

    // добавляет данные в массив
    push_cart: function(data) {
      var mode = cart.get_carts_mode();

      let isPush = true;
      
      var this_data = cart.prepare_data(data);
      
      if(cart.get_cart_list()) {
        cart.get_cart_list().forEach(el => {

          if(el.id == this_data.id) {
            isPush = false;
            cart.add_count(this_data);
          }
        });
      }

      if (!cart.cart_list[mode]) {
        cart.cart_list[mode] = [];
      }      

      if(isPush) {
        cart.cart_list[mode].push(this_data);    
      }

    },
    
    // делает запрос и получает товар по id и добавляет в массив
    request_data(id) {
      $.ajax({
        url: '/core/action/stock/get_barcode_product.php',
        type: 'POST',
        dataType: 'json',
        data: {
          id: id,
          page: pageData.page()
        },
        success: (data) => {
          cart.push_cart(data);
          cart.draw();
        }
      });
    },

    // увеличывает количество в массиве
    add_count: function(stock, count) {
      var mode = cart.get_carts_mode();
      cart.get_cart_list().forEach(el => {
        if(el.id == stock.id) {
          var index = cart.cart_list.indexOf(el);

          $(`.cart-item[data-cart-id = ${stock.id}]`).find('.cart-plus-count').trigger('click');
          $(`.cart-item[data-cart-id = ${stock.id}]`).find('.cart-order-count ').blur();
      // раскоментить если нужно запретить увеличивать количество товара больше чем есть в стоке

          // if(count) {
          //   cart.cart_list[index].count = count;
          // } else {
          //   // cart.cart_list[index].count++;

          //   // var get_count = cart.cart_list[index].count;

          //   $(`.cart-item[data-cart-id = ${stock.id}]`).find('.cart-plus-count').trigger('click');
          //   $(`.cart-item[data-cart-id = ${stock.id}]`).find('.cart-order-count ').blur();

          // }
        }
      });

    },

    // обновляет данные в массиве если изменены в корзине 
    update_carts: function(id, param, data) {
      var mode = cart.get_carts_mode();

      cart.get_cart_list().forEach(el => {
        if(el.id == id) {
          var index = cart.get_cart_list().indexOf(el);
          cart.get_cart_list()[index][param] = data;
        }
      });
    },

    // получем id товара
    get_id: function($this) {
      return $this.closest('.stock-list').attr('id');
    },
    
    // получаем id в корзине
    get_cart_item_id: function($this) {
      return $this.closest('.cart-item').data('cart-id');
    },

    // удаляем товар с корзины и массива
    remove_at_cart: function(ids) {
      cart.get_cart_list().forEach(el => {
        if(el.id == ids) {
          var index = cart.get_cart_list().indexOf(el);
          cart.get_cart_list().splice(index, 1);
        }
      });
    },

    // очищаем корзину
    reset_cart: function() {
      if(cart.get_cart_list().length) {
        delete cart.cart_list[cart.get_carts_mode()];
      }
    },

    // ui активируем кнопку "добавить в корзину"
    active_basket_btn: function($this) {
      var class_list = [
        'la-cart-plus',
        'la-check',
        'btn-secondary',
        'btn-success',
        'add-to-cart',
        'added-to-cart',
      ];
    
      $this.toggleClass(class_list).closest('.stock-list').toggleClass('stock-added-in-cart');
    },

    // активируем все кнопки товары которых добавленны в корзину
    active_all_btn: function() {
      if(cart.get_cart_list().length == 0) {
        if($('.added-to-cart')) {
          cart.active_basket_btn($('.added-to-cart'));
          return;
        }
      }

      // las btn add-basket-btn-icon add-basket-button width-100 table-ui-btn la-cart-plus btn-secondary add-to-cart
      // las btn add-basket-btn-icon add-basket-button width-100 table-ui-btn la-cart-plus btn-secondary add-to-cart
      // las btn add-basket-btn-icon add-basket-button width-100 table-ui-btn la-cart-plus btn-secondary add-to-cart
      // las btn add-basket-btn-icon add-basket-button width-100 table-ui-btn la-cart-plus btn-secondary add-to-cart
      // las btn add-basket-btn-icon add-basket-button width-100 table-ui-btn la-check btn-success added-to-cart
      cart.get_cart_list().forEach(el => {
        // var $stock = $(`.stock-list#${el.id}`);

        var $stock = $(`#${el.id}.stock-list`);

        if($stock) {
          var $button = $stock.find('.add-to-cart');

          if(!$button.hasClass('.added-to-cart')) {
            cart.active_basket_btn($button);
          }
        }      
      });
    },

    // получаем списко товаров в корзине
    get_cart_list: () => {
      var mode = cart.get_carts_mode();

      if(!cart.cart_list[mode]) {
        return cart.cart_list;
      } else {
        return cart.cart_list[mode];
      }
    },


    show_in_cart_count: function() {
      var $cart_mark = $('.in-cart-count');
      var cart_count = cart.get_cart_list().length;
      var this_count = $cart_mark.text().trim();

      if(cart_count != this_count) {
        $cart_mark.html(cart_count);
      }
    },

    // отправляем корзину
    send_cart: () => {
      if(cart.is_cart_prepared()) {

        const payment_method = $('.cart-payment-method').val();
        const sales_man = $('.cart-sales-man').val();
        
        $.ajax({
          url: '/core/action/cart/checkout.php',
          type: 'POST',
          dataType: 'json',
          data: {
            cart: cart.get_cart_list(),
            payment_method: payment_method,
            sales_man: sales_man
          },
          success: (data) => {
            if(data.type == 'success') {
              cart.order_success();
            }
            pageData.alert_notice(data.type, data.text);
          }
        });
      }
    },

    // показывает сумму товара в корзине 
    display_total: () => {
      var $el = $('.cart-res-sum');
      let inner_val = $el.text().trim();
    
      inner_val = parseFloat(inner_val);

      let res = 0;
      cart.get_cart_list().forEach(el => {
        res += el.price * el.count; 
      });

      if(inner_val != res) {
        $el.text(res);
        return true;
      } 

      return false;
    },

    // проверяет заполнены ли все поля 
    is_cart_prepared: function() {
      $('.cart-input').trigger('input', 'keyup');
      if($('.input-validate-error').length) {
        pageData.alert_notice('error', 'заполните все поля');
        return false;
      }
      return true;
    },


    modal_cart_show: function() {
      $('.cart').toggleClass('hide');
    },
    order_success: function() {
      cart.reset_cart();
    }
  };


  // $('body').on('focusout keyup input', '.input-validate-min-max-count', function(){
  //   const cart_id = cart.get_cart_item_id($(this));
  //   const carts = cart.get_cart_list();
  
  //   carts.forEach(el => {
  //     if(el.id == cart_id) {
  //       return input_validate_min_max_count(1, el.maxCount, $(this));
  //     }
  //   });
  
  // });
  
  
  $('body').on('click', '.add-basket-button', function() {
    cart.active_basket_btn($(this));
  });


  $('body').on('click', '.add-to-cart', function(){
    var id = $(this).closest('.stock-list').attr('id');
    cart.request_data(id);
  });
  
  $('body').on('click', '.added-to-cart', function(){
    var id = cart.get_id($(this));
    cart.remove_at_cart(id);
  });


  $('body').on('click', '.auto-add-to-cart', function() {
    var id = $(this).data('id');
    cart.request_data(id);
  
  });



  
  $('body').on('click', '.send-cart', function(){
    cart.send_cart(); 
  });
  
  $('body').on('click', '.reset-cart', function(){
    cart.reset_cart();
    cart.active_all_btn();
    cart.show_in_cart_count();
  });
  
  $('body').on('click', '.remove-at-cart', function(){
    var id = cart.get_cart_item_id($(this));

    var $stock = $(`.stock-list#${id}`).find('.added-to-cart');
    cart.active_basket_btn($stock);
    cart.remove_at_cart(id);
    cart.show_in_cart_count();
  });
  
    
  $('body').on('keyup', '.cart-order-price', function(){
    var id = cart.get_cart_item_id($(this));
    var val = $(this).val().trim();
  
    cart.update_carts(id, 'price', val);
    cart.display_total();
  });
  
  $('body').on('keyup input', '.cart-order-count', function(){
    var id = cart.get_cart_item_id($(this));
    var val = $(this).val().trim();
  
    cart.update_carts(id, 'count', val);
    cart.display_total();
  });

  $('body').on('keyup input', '.cart-order-description', function(){
    var id = cart.get_cart_item_id($(this));
    var val = $(this).val().trim();
  
    cart.update_carts(id, 'description', val);
    cart.display_total();
  });
  


  
  function init_obs() {
    var target = document.getElementById('app');
  
    const config = {
      childList: true,
      subtree: true,
      attributes: true
    };
  
    const callback = function(mutationList, observer) {
      mutationList.forEach(el => {

        if($('.cart').length) {
          if(el.type == 'childList') {
              if(cart.is_draw_possible) {
                cart.draw();
              }
            
            cart.display_total();
          }
        } 

        if(el.type == 'attributes') {
          if($('.table-list').length) {
            cart.active_all_btn();
          }
          cart.show_in_cart_count();
        }
      });
    };
    const observer = new MutationObserver(callback);
    observer.observe(target, config);    
  }

  init_obs();

  $(document).pos();

  $(document).on('scan.pos.barcode', function(event){
    var barcode = event.code;
    
    if($('.cart').length > 0) {
      $.ajax({
        url: '/core/action/barcode/get_product_data.php',
          type: 'POST',
          dataType: 'json',
          data: {
          barcode: barcode,
        },
        success: (data) => {
          cart.request_data(data.res_id);
          cart.display_total();
        }
      }); 
    }

    // ЕСЛИ НА СТРАНИЦЕ АНБАРА 
    if($('.table-list[data-stock-page="stock"]').length > 0) {
      $.ajax({
        url: '/core/action/barcode/get_product_data.php',
          type: 'POST',
          dataType: 'json',
          data: {
            barcode: barcode
        },
        success: (data) => {

          $.ajax({
              type: 'POST',
              url: 'core/action/search.php',
              data: {
                search_item_value	: data.res_id, 
                page: pageData.page(), 
                type: pageData.type(),
                sort_data: 'id'
              },
              dataType: 'json',
              success: (data) => {
                //выводим в талицу данные
                if(data.table) {
                  pageData.innerTable(data.table);	
                }
                if(data.total) {
                  pageData.innerTableFooter(data.total);
                }
          
              }			
          });


          $.ajax({
              type: 'POST',
              url: 'core/action/modal/order.php',
              data:{
                product_id : data.res_id,
                // order_id: order_id, 
                type  : pageData.type(), 
                page  : pageData.page()
              },
              success: (data) => {
                pageData.preloaderShow();
                pageData.overlayShow();                
                pageData.rightSideModal(data);
              }			
        
          });          

        }
      }); 
    }    



  });
});
/** END EXPERIMENTAL */