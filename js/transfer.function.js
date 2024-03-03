$(document).ready(function() {

    $(document).on('click', '.send-warehouse-transfer', function() {
        
        const warehouse_id = $('.cart-warehouse-id').val();

        if(cart.is_cart_prepared()) {
            $.ajax({
                url: 'ajax_route.php',
                type: 'POST',
                data: {
                    route: 'addTransfer',
                    url: '/core/action/warehouse-transfer/add-transfer.php',
                    warehouse_id: warehouse_id,
                    list: cart.get_cart_list()
                },
                success: (data) => {
    
                    if(data.type == 'success') {
                        cart.order_success();  
                    }
    
                    pageData.alert_notice(data.type, data.text);
                }
            });
        }
    });
});
