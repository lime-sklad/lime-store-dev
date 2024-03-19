$(document).ready(function() {

    $(document).on('click', '.send-write-off-products', function() {
        $.ajax({
            type: 'POST',
            url: 'ajax_route.php',
            data: {
                route: 'addWriteOff',
                url: 'core/action/write-off-products/add-write-off-products.php',
                list: cart.get_cart_list()
            },
            success: (data) => {
                cart.order_success();  
                pageData.alert_notice(data.type, data.text);
            }
        });

    });

});
