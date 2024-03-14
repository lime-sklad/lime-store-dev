$(document).ready(function() {

    $(document).on('click', '.send-write-off-products', function() {
        $.ajax({
            url: 'core/action/write-off-products/add-write-off-products.php',
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
