<?php
add_shortcode('coupon_codes', 'cdwp_get_coupon_codes' );
function cdwp_get_coupon_codes() {
    
    $coupon_posts = get_posts( array(
        'posts_per_page'   => -1,
        'orderby'          => 'name',
        'order'            => 'asc',
        'post_type'        => 'shop_coupon',
        'post_status'      => 'publish',
    ) );
    
    $output = '';
    
    if(!empty($coupon_posts)){
	
	foreach($coupon_posts as $code){
	    
	    $date_expires = get_post_meta($code->ID, 'date_expires', 'true');
	    $current_date = time();
	    
	    if($current_date < $date_expires){
		$output .= '<div class="xoo-wsc-coupon-row">
		    <span class="xoo-wsc-cr-code">'.esc_attr($code->post_title).'</span>
		    <span class="xoo-wsc-cr-desc">'.esc_html_e($code->post_excerpt).'</span>
		    <button class="xoo-wsc-coupon-apply-btn button btn" value="'.esc_attr($code->post_title).'">Apply Coupon</button>
		 </div>';
	    }
	}
    }
    return $output;
}

