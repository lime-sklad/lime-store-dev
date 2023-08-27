$(document).ready(function() {

    $(document).on('click', '.send-arrival-products', function() {
        $.ajax({
            url: 'core/action/arrival-products/add-arrival-products.php',
            type: 'POST',
            data: {
                list: cart.get_cart_list()
            },
            success: (data) => {
                cart.order_success();  
                pageData.alert_notice(data.type, data.text);
            }
        });

    });

});
