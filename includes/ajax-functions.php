<?php
add_action('wp_ajax_load_ajax_cart_items', 'cdwp_load_ajax_cart_items');
add_action('wp_ajax_nopriv_load_ajax_cart_items', 'cdwp_load_ajax_cart_items');

/**
 * Used to get number of items added to the cart
 */
function cdwp_load_ajax_cart_items() {
    try {

	global $woocommerce;
	$items = $woocommerce->cart->get_cart();

	$subtotal = $woocommerce->cart->get_cart_subtotal();
	$total = $woocommerce->cart->get_cart_total();
	$shipping = $woocommerce->cart->get_cart_shipping_total();
	$totaldisc = $woocommerce->cart->get_total_discount();

	$output = '';
	?>
	<?php echo '<div class="xoo-wsc-body">'; ?>
	    <?php
	    if (!empty($items)) {
		$i = 0;
		foreach ($items as $key => $product) {
		    
		    $item_key = $product['key'];
		    $product_id = $product['product_id'];
		    $quantity = $product['quantity'];
		    $line_total = $product['line_total'];

		    //hyperlink
		    $product = wc_get_product($product_id);
		    $permalink = $product->get_permalink();
		    $price_html = $product->get_price_html();
		    $currency = get_woocommerce_currency_symbol();

		    //product name
		    $name = get_the_title($product_id);
		    
		    //total sales
		    $total_sold = get_post_meta( $product_id, 'total_sales', true );
		    
		    //applied coupons
		    $coupons_applied = $woocommerce->cart->get_applied_coupons();
		    
		    //image
		    $image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
	    
		    echo '<div class="xoo-wsc-products">
			<div data-key="'.esc_attr($key).'" class="xoo-wsc-product">
			    <div class="xoo-wsc-img-col">
				<a href="'.esc_url($permalink).'"><img src="'.esc_url($image[0]).'" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" width="324" height="324"></a>
			    </div>
			    <div class="xoo-wsc-sum-col">';
				if($total_sold != '' && $total_sold != 0){
				echo '<div class="xoo-wsc-sm-sales">';
				    echo esc_html($total_sold > 6 ? '6+': $total_sold).' shopper(s) have bought this.';
				echo '</div>';
				}
				echo '<div class="xoo-wsc-sm-info">
				    <div class="xoo-wsc-sm-left">
					<span class="xoo-wsc-pname"><a href="'.esc_url($permalink).'">'.esc_attr($name).'</a></span>
					<div class="xoo-wsc-pprice">
					    Price: <span class="woocommerce-Price-amount amount">'.$price_html.'</span>					
					</div>
					<!-- Quantity -->
					<div class="xoo-wsc-qty-box xoo-wsc-qtb-square">
					    <span class="xoo-wsc-minus xoo-wsc-chng" onclick=cart_item_qty_update("'.esc_attr($key).'","'.esc_attr($quantity - 1).'");>-</span>
					    <input type="number" class="xoo-wsc-qty" value="'.esc_attr($quantity).'" placeholder="" inputmode="numeric" onblur=cart_item_qty_update("'.esc_attr($key).'","'.this.value.'"); />
					    <span class="xoo-wsc-plus xoo-wsc-chng" onclick=cart_item_qty_update("'.esc_attr($key).'","'.esc_attr($quantity + 1).'");>+</span>
					</div>
				    </div>
				    <!-- End Quantity -->
				    <div class="xoo-wsc-sm-right">
					<span class="xoo-wsc-smr-del xoo-wsc-icon-trash" onclick=delete_cart_item("'.esc_attr($item_key).'");><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAABHklEQVRIie2VvU7DMBSFv/4sDG0lEGVNWZD6KO3ACu9RqS9ReIxIjDxMBwZIy0anstBOlMHXLTiO7RvKxpGsyPHxPfecxAn8MRoK3jVwJfMn4BHYHauReyn2fdwdqzjAGsiBloxc7kXRduZuFBZdoA9MZH4O9ICpw4tG54tCO2YhR+8cotDCG50bURdjf0I92OgqMef3Ec1jXdwKcajofCh7btyFpoe8kGumEBg4e4MCRQ0Byy3cBZ/AG/BRQ2ADrFIEdsArB9spGGDiKR0wnwBC1joo5R8SKNA7KOUfElgCZ0AnoXgHOJU9yQKaN8k6VTmw5EuFgPcZVP3RTjCv6wvwAHxW8JqY05sBF8A2oaE9xiIQ+/Y8AyNN4X/8wBeDcF55Z/xeWAAAAABJRU5ErkJggg=="/></span>
					<span class="xoo-wsc-smr-ptotal"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">'.esc_attr($currency).'</span>'.esc_attr($line_total).'</span></span>
				    </div>
				</div>
			    </div>
			</div>
		    </div>';
		    if($i==0){
			echo '<input type="hidden" id="hid_qty" value="'.esc_attr($quantity).'">
			<input type="hidden" id="hid_prodkey" value="'.esc_attr($key).'">';
		    }$i++;
		}
	    } else {
		echo '<div class="empty_cart">Your cart is currently empty!</div>';
	    }
	    
	echo '</div>';
	if(count($items) != 0){
	    echo '<div class="xoo-wsc-footer">
		<div class="xoo-wsc-ft-extras">
		    <div class="xoo-wsc-ftx-row xoo-wsc-ftx-coupon">
			<span class="xoo-wsc-ftx-icon xoo-wsc-icon-coupon-8"></span>
			<span class="xoo-wsc-toggle-slider" id="promo_code" data-slider="coupon"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABmJLR0QA/wD/AP+gvaeTAAABWElEQVQ4jcXTsUpcQRQG4A8lhWmUaBdjMAHBPqaxFhvjIml2BUMQ0rlbmQeIlnkEY6kRkUDewl3YB4iBjWUKoy7WcS3uXLiMs3q10B9OMYdz/v+fOWd4JDRC3BsVbOAlargMUQ25DSzehbCN3i3RLks2hrMShGehti8qaOG8BFmRtIV3OclAgfANZjAczoey9/uC/yG3h83CeST0vE05nIjUJ/ExNO3jD4awnXA6kXI4GwmcYxpP0cVn2WRXE2biXg3ZWhRVv2Ec8/gZHPcb1iXqRcJ6gjCPLl7jB+bwPIjFhGuxy1ofwpVw1dzxVzyLaqqJZ7g2lB528QS/cCDbgBW8iupe5CTFoXyKBHo4xhamsIR12cp8j2rjXsK1msr9kuJiN7GQIsxR9uudYjRuHogTOEHnJsWADv7FycE+xX/xGx9kf/V9yC/L3vECOzgqIZxEXWLPHgRXRWqS1z3oZGgAAAAASUVORK5CYII="/> '.(!empty($coupons_applied) ? '<a style="text-decoration:none !important; color:green;">Promo Code Applied!</a>' : '<a style="text-decoration: underline; text-underline-position: under;">Have a Promo Code?</a>').'</span>
			<span class="promo-close">✕</span>
		    </div>
		</div>

		<!--Promo code listing start-->
		<div class="xoo-wsc-sl-body">
		   <form class="xoo-wsc-sl-apply-coupon">
		      <input type="text" id="xoo-wsc-slcf-input" name="xoo-wsc-slcf-input" placeholder="Enter Promo Code">
		      <div id="invalid_coupon">Invalid Coupon Code!</div>
		      <button class="button btn" type="button">Submit</button>
		   </form>
		   <div class="xoo-wsc-clist-cont">
		      <div class="xoo-wsc-clist-section xoo-wsc-clist-section-valid">
			 <span class="xoo-wsc-clist-label">Available Coupons</span>
			 '.do_shortcode('[coupon_codes]').'
		      </div>
		   </div>
		</div>
		<!--Promo code listing end-->';

		if(!empty($coupons_applied)){
		    echo '<div class="applied-promo-main">
			<div class="show-coupon" data-coupon='.current($coupons_applied).'><b>COUPON:</b> <span style="color: blue;">'.current($coupons_applied).'</span> <span><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAABmJLR0QA/wD/AP+gvaeTAAAA8ElEQVQYlZWQsUoDQRiEvz8uXCA2Ek7RQLS4t0izlqlDFuRILQiXdzFFeos0h+9w11hapgocKhiJIGnCZskF1yJ6ps10MwMzw8Ah8Ek3cIPe0GutKk1r5Qa9oU+6AYACWM3lFtx92Wx0vNYxwKrZmGCdKa0AjBTA8ZcdL+u1DoJZ1mu7SLs2eNIT9z0GkKqq3z/6XLw/gI/ZOY+nEtxInm+r6j9s1lbw//zZb6ogAci0VpeLjwlggPTXM0D6enYeX+f5VgG0iuKuFAxCOn95iwEurtrgMa2ieAJGAMyiKJiGYZLtTclATcMwmUVRcNDXP0GHUUNFhH/GAAAAAElFTkSuQmCC"/></span></div>
		    </div>';
		}

		echo '<div class="xoo-wsc-ft-totals">
		    <div class="xoo-wsc-ft-amt xoo-wsc-ft-amt-subtotal ">
			<span class="xoo-wsc-ft-amt-label">Subtotal</span>
			<span class="xoo-wsc-ft-amt-value"><span class="woocommerce-Price-amount amount">'.$subtotal.'</span>
		    </div>
		    <div class="xoo-wsc-ft-amt xoo-wsc-ft-amt-shipping add">
			<span class="xoo-wsc-ft-amt-label"><span class="" data-slider="shipping">Shipping<span class="xoo-wsc-icon-pencil"></span></span></span>
			<span class="xoo-wsc-ft-amt-value"><span class="" data-slider="shipping">'.$shipping.'</span></span>
		    </div>';

		    if($totaldisc != '') {
			echo '<div class="xoo-wsc-ft-amt xoo-wsc-ft-amt-discount ">
			    <span class="xoo-wsc-ft-amt-label">Discount Amount</span>
			    <span class="xoo-wsc-ft-amt-value"><span class="woocommerce-Price-amount amount">'.$totaldisc.'</span>
			</div>';
		    }
		    echo '<div class="xoo-wsc-ft-amt xoo-wsc-ft-amt-total ">
			<span class="xoo-wsc-ft-amt-label">Total</span>
			<span class="xoo-wsc-ft-amt-value"><span class="woocommerce-Price-amount amount">'.$total.'</span>
		    </div>
		</div>
		<div class="xoo-wsc-ft-buttons-cont">';

		    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
		    $checkout_page_url = wc_get_checkout_url();

		    echo '<a href="'.esc_url($shop_page_url).'" class="xoo-wsc-ft-btn button btn xoo-wsc-cart-close xoo-wsc-ft-btn-continue">Continue Shopping</a><a href="'.esc_url($checkout_page_url).'" class="xoo-wsc-ft-btn button btn xoo-wsc-ft-btn-checkout">Checkout</a>
		</div>
		<div class="xoo-wsc-payment-btns">
		    <div class="widget_shopping_cart xoo-wsc-paypal-btn">
			<p class="woocommerce-mini-cart__buttons buttons wcppec-cart-widget-spb">
			    <span id="woo_pp_ec_button_mini_cart" class="wc_ppec_responsive_payment_buttons">
				<div id="zoid-paypal-buttons-uid_74518ce587_mdq6nti6ndy" class="paypal-buttons paypal-buttons-context-iframe paypal-buttons-label-paypal paypal-buttons-layout-vertical" data-paypal-smart-button-version="5.0.267" style="height: 45px; transition: all 0.2s ease-in-out 0s;"></div></span>
			</p>
		    </div>
		</div>
	    </div>';
	}
	echo '</div>';
	wp_die();
    } catch (Exception $e) {
	$e->getMessage();
    }
}

/* Increase/decrease the quantity of the product */
add_action('wp_ajax_cart_item_update', 'cdwp_cart_item_update');
add_action('wp_ajax_nopriv_cart_item_update', 'cdwp_cart_item_update');

function cdwp_cart_item_update() {
    try {

	global $woocommerce;

	if (!empty($_POST)) {

	    $product_key = sanitize_key($_POST['product_key']);
	    $quantity = sanitize_key($_POST['quantity']);

	    $woocommerce->cart->set_quantity($product_key, $quantity);
	}
	wp_die();
    } catch (Exception $e) {
	$e->getMessage();
    }
}

/* Increase/decrease the quantity of the product */
add_action('wp_ajax_total_line_items', 'cdwp_total_line_items');
add_action('wp_ajax_nopriv_total_line_items', 'cdwp_total_line_items');

function cdwp_total_line_items() {
    try {

	global $woocommerce;
    
	$items = $woocommerce->cart->get_cart();
	echo count($items);
	
	wp_die();
    } catch (Exception $e) {
	$e->getMessage();
    }
}

//delete an item from the cart
add_action('wp_ajax_delete_cart_item', 'cdwp_delete_cart_item');
add_action('wp_ajax_nopriv_delete_cart_item', 'cdwp_delete_cart_item');

function cdwp_delete_cart_item() {
    try {

	global $woocommerce;
    
	if(isset($_POST['cart_item_key']) && $_POST['cart_item_key'] != ''){
	    $cart_item_key = sanitize_key($_POST['cart_item_key']);
	    $woocommerce->cart->remove_cart_item($cart_item_key);
	}
	wp_die();
    } catch (Exception $e) {
	$e->getMessage();
    }
}

//apply coupon code to the cart total
add_action('wp_ajax_apply_coupon', 'cdwp_apply_coupon');
add_action('wp_ajax_nopriv_apply_coupon', 'cdwp_apply_coupon');

function cdwp_apply_coupon() {
    try {

	global $woocommerce;
    
	if(isset($_POST['coupon_code']) && $_POST['coupon_code'] != ''){
	    $coupon_code = sanitize_key($_POST['coupon_code']);
	    
	    //first delete all discount coupons applied
	    $coupons_applied = $woocommerce->cart->get_applied_coupons();
	    if(!empty($coupons_applied)){
		foreach($coupons_applied as $coupon){
		    $woocommerce->cart->remove_coupon( $coupon );
		}
	    }
	    
	    $woocommerce->cart->add_discount( sanitize_text_field( $coupon_code ));
	}
	wp_die();
    } catch (Exception $e) {
	$e->getMessage();
    }
}

//remove coupon code
add_action('wp_ajax_remove_coupon', 'cdwp_remove_coupon');
add_action('wp_ajax_nopriv_remove_coupon', 'cdwp_remove_coupon');

function cdwp_remove_coupon() {
    try {

	global $woocommerce;
    
	if(isset($_POST['coupon_code']) && $_POST['coupon_code'] != ''){
	    $coupon_code = sanitize_key($_POST['coupon_code']);
	    $woocommerce->cart->remove_coupon( $coupon_code );
	}
	wp_die();
    } catch (Exception $e) {
	$e->getMessage();
    }
}

//apply a coupon code through input field
add_action('wp_ajax_apply_input_coupon', 'cdwp_apply_input_coupon');
add_action('wp_ajax_nopriv_apply_input_coupon', 'cdwp_apply_input_coupon');

function cdwp_apply_input_coupon() {
    try {

	global $woocommerce;
    
	if(isset($_POST['coupon_code']) && $_POST['coupon_code'] != ''){
	    
	    $coupon_code = sanitize_key($_POST['coupon_code']);
	    
	    //first check if the coupon code is valid or not
	    $coupon = new WC_Coupon( $coupon_code );
	    if(!$coupon->is_valid()){
		echo 'invalid';
	    } else {
		$woocommerce->cart->add_discount( sanitize_text_field( $coupon_code ));
	    }
	}
	wp_die();
    } catch (Exception $e) {
	$e->getMessage();
    }
}