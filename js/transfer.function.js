$(document).ready(function() {

    $(document).on('click', '.send-warehouse-transfer', function() {
        
        const warehouse_id = $('.cart-warehouse-id').val();

        if(cart.is_cart_prepared()) {
            $.ajax({
                url: 'core/action/warehouse-transfer/add-transfer.php',
                type: 'POST',
                data: {
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
