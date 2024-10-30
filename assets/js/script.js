jQuery(document).ready(function ($) {

    //after product added to cart
    $('body').on('added_to_cart', function () {
        openCartDrawer();
    });

    $('.js-menu__open').on('touchend click', function () {
        openCartDrawer();
    });

    $('.js-menu__context, .js-menu__close').on('touchend click', function (event) {
        if ($(event.target).hasClass('js-menu__context') || $(event.target).hasClass('js-menu__close')) {
            $('.js-menu__open').removeClass('js-menu__right_pos');
            $('.js-menu__expanded').removeClass('js-menu__expanded');
        }
    });
    
    
    
    
}); //document.ready

function openCartDrawer() {
    var menu = '#main-nav';
    jQuery(menu).toggleClass('js-menu__expanded');
    jQuery(menu).parent().toggleClass('js-menu__expanded');

    if (jQuery('.js-menu__context').hasClass('js-menu__expanded')) {
        jQuery('.js-menu__open').addClass('js-menu__right_pos');
    } else {
        jQuery('.js-menu__open').removeClass('js-menu__right_pos');
    }

    //call ajax function and fetch cart items
    loadAjaxCartItems();
}

function loadAjaxCartItems() {
    
    jQuery('#cover-spin').show();
    
    total_line_items();

    jQuery.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        data:{action: 'load_ajax_cart_items'},
        success: function (data)
        {
            jQuery('.cart_response').html(data);
            jQuery('#cover-spin').hide();
            
            //add promo code click event
            jQuery('#promo_code').on('click', function () {
                jQuery( ".xoo-wsc-sl-body" ).slideToggle( "slow", function() {});
                jQuery( ".promo-close" ).slideToggle( "slow", function() {});
            });
            
            jQuery('.promo-close').on('click', function () {
                jQuery( ".xoo-wsc-sl-body" ).slideToggle( "slow", function() {});
                jQuery( ".promo-close" ).slideToggle( "slow", function() {});
            });
            
            //apply coupon
            jQuery('.xoo-wsc-coupon-apply-btn').on('click', function (event) {
                var coupon_code = jQuery(this).val();
                apply_coupon(coupon_code);
            });
            
            //remove coupon
            jQuery('.show-coupon').on('click', function (event) {
                var coupon_code = jQuery(this).data('coupon');
                cart_delete_coupon(coupon_code);
            });
            
            //on coupon code input
            jQuery('.xoo-wsc-sl-apply-coupon button').on('click', function (event) {
                var coupon_code = jQuery('#xoo-wsc-slcf-input').val();
                if(coupon_code != ''){
                    jQuery('#invalid_coupon').hide();
                    apply_input_coupon(coupon_code);
                } else {
                    jQuery('#invalid_coupon').html('Please enter a coupon code.');
                    jQuery('#invalid_coupon').show();
                }
            });
        }
    });
}

//increase/decrease the quantity of the product in cart drawer
function cart_item_qty_update(product_key, quantity){
    
    jQuery('#cover-spin').show();
    
    jQuery.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        data:{action: 'cart_item_update', product_key: product_key, quantity: quantity},
        success: function (data)
        {
            loadAjaxCartItems();
        }
    });
}

//get the total number of items in the cart
function total_line_items(){
    
    jQuery.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        data:{action: 'total_line_items'},
        success: function (data)
        {
            jQuery('.js-wsc-items-count').html(data);
        }
    });
}

//delete an item from the cart
function delete_cart_item(cart_item_key){
    
    jQuery('#cover-spin').show();
    
    jQuery.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        data:{action: 'delete_cart_item', cart_item_key: cart_item_key},
        success: function (data)
        {
            loadAjaxCartItems();
        }
    });
}

//apply a coupon code to the cart total
function apply_coupon(coupon_code){
    jQuery.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        data:{action: 'apply_coupon', coupon_code: coupon_code},
        success: function (data)
        {
           loadAjaxCartItems();
        }
    });
}

//delete a coupon code from the cart
function cart_delete_coupon(coupon_code){
    jQuery.ajax({
        url: wc_add_to_cart_params.ajax_url,
        type: "POST",
        data:{action: 'remove_coupon', coupon_code: coupon_code},
        success: function (data)
        {
           
           var quantity = jQuery('#hid_qty').val();
           var product_key = jQuery('#hid_prodkey').val();
           cart_item_qty_update(product_key, quantity);
        }
    });
}

//apply a coupon code through input field
function apply_input_coupon(coupon_code){
    
    if(coupon_code == ''){
        alert('Please enter a coupon code.');
    } else {
        jQuery.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: "POST",
            data:{action: 'apply_input_coupon', coupon_code: coupon_code},
            success: function (data)
            {
                if(data == 'invalid'){
                    jQuery('#invalid_coupon').html('Invalid Coupon Code!');
                    jQuery('#invalid_coupon').show();
                } else {
                    jQuery('#invalid_coupon').hide();
                    loadAjaxCartItems();
                }
            }
        });
    }
    
    
}