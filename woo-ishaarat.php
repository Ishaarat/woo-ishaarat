<?php
/**
 *
 * Plugin Name:       Ishaarat Orders & Abandoned Carts WhatsApp Notifications
 * Plugin URI:        https://ishaarat.com?utm_source=customer_websites&utm_medium=plugin_page
 * Description:       Send Whatsapp order notifications and campaigns from your woocommerce store.
 * Version:           1.0.0
 * Author:            Algovers LTD.
 * Author URI:        https://algovers.com/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-ishaarat
 * Domain Path:       /languages
 * WC requires at least: 3.0.0
 * WC tested up to: 8.0
 *
  */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) && ! defined( 'ABSPATH' ) ) {
	die;
}
require plugin_dir_path( __FILE__ ) . '/inc/constants.php';
require plugin_dir_path( __FILE__ ) . '/require.php';


register_activation_hook( __FILE__, 'activate_woo_ishaarat' );
/**
 * Code fired after activate the plugin.
 *
 * @return void
 */
function activate_woo_ishaarat() {
	$options = get_option( 'woo_ishaarat_options' );
	if ( ! isset( $options ) ) {
		update_option( 'woo_ishaarat_options', array() );
	}
}

/**
 * This function the core of the plugin.
 */
function run_woo_ishaarat() {
	$plugin = new Woo_Ishaarat();
	$plugin->run();
}

run_woo_ishaarat();
