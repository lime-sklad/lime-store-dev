$(document).ready(function() {

    $(document).on('click', '.send-arrival-products', function() {
        $.ajax({
            type: 'POST',
            url: 'ajax_route.php',
            data: {
                route: 'addArrivalProducts',
                url: 'core/action/arrival-products/add-arrival-products.php',
                list: cart.get_cart_list()
            },
            success: (data) => {
                cart.order_success();  
                pageData.alert_notice(data.type, data.text);
            }
        });

    });

});
