<?php
/**
 * Plugin Name: Cart Drawer for WC
 * Plugin URI: https://wordpress.org/plugins/cart-drawer-woocommerce
 * Description: Say good bye to your woocommerce cart page. With side cart users can access cart items from anywhere on your site.
 * Version: 1.5.0
 * Author: Evincedev
 * Text Domain: cart-drawer-woocommerce
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Author URI: https://evincedev.com/
 */

global $table_prefix, $wpdb;

/**
 *  Activation Class 
 * */
if (!class_exists('WC_CPInstallCheck')) {

    class WC_CPInstallCheck {

	static function install() {
	    /**
	     * Check if WooCommerce is active
	     * */
	    if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

		// Deactivate the plugin
		deactivate_plugins(__FILE__);

		// Throw an error in the wordpress admin console
		$error_message = 'This plugin requires <a href="'.(esc_attr( esc_url("http://wordpress.org/extend/plugins/woocommerce/"))).'" WooCommerce </a>';
		die($error_message);
	    }
	}

    }

}
register_activation_hook(__FILE__, array('WC_CPInstallCheck', 'install'));

//If WC is deactivated then deactivate this plugin
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // Deactivate the plugin
    deactivate_plugins(__FILE__);
}

//scripts include
function cdwp_enqueue_scripts() {
    wp_enqueue_style('woo-style', plugins_url('assets/css/frontend.css', __FILE__) . '?' . time());
    wp_enqueue_script('woo-script', plugins_url('assets/js/script.js', __FILE__), array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'cdwp_enqueue_scripts');

require_once 'includes/cart-drawer.php';
require_once 'includes/ajax-functions.php';
require_once 'includes/shortcodes.php';
?>