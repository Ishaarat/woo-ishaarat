<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat-admin-menu.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */

class Woo_Ishaarat_Admin_Menu {
	/**
	 * This function add menus to WP Dashboard.
	 *
	 * @return void
	 */
	public static function add_menus()
	{
		global  $submenu ;
		// Main menu container
		add_menu_page(
			__( 'Ishaarat', WOO_ISHAARAT_PLUGIN_NAME),
			__( 'Ishaarat', WOO_ISHAARAT_PLUGIN_NAME),
			'manage_woocommerce',
			WOO_ISHAARAT_PLUGIN_NAME,
			array( 'Woo_Ishaarat_Admin_Settings', 'configure_woo_ishaarat_settings' ),
			plugins_url( 'img/ishaarat.svg', __FILE__ ),
			57
		);
		// Quick Message Item
		add_submenu_page(
			WOO_ISHAARAT_PLUGIN_NAME,
			__( 'Send a Quick msg', WOO_ISHAARAT_PLUGIN_NAME),
			__( 'Send a Quick msg', WOO_ISHAARAT_PLUGIN_NAME),
			'manage_woocommerce',
			WOO_ISHAARAT_PLUGIN_NAME . '-send-wa',
			array( 'Woo_Ishaarat_Admin_Settings', 'send_msg' ),
			10
		);
		// Settings Item
		unset( $submenu[WOO_ISHAARAT_PLUGIN_NAME][0] );
		add_submenu_page(
			WOO_ISHAARAT_PLUGIN_NAME,
			__( 'Settings', WOO_ISHAARAT_PLUGIN_NAME),
			__( 'Settings', WOO_ISHAARAT_PLUGIN_NAME),
			'manage_woocommerce',
			WOO_ISHAARAT_PLUGIN_NAME,
			array( 'Woo_Ishaarat_Admin_Settings', 'configure_woo_ishaarat_settings' ),
			20
		);
		// Logs Item
		$logs_loader = new Woo_Ishaarat_Admin_Logs_Loader();
		$log_hook = add_submenu_page(
			WOO_ISHAARAT_PLUGIN_NAME,
			__( 'Logs', WOO_ISHAARAT_PLUGIN_NAME),
			__( 'Logs', WOO_ISHAARAT_PLUGIN_NAME),
			'manage_woocommerce',
			WOO_ISHAARAT_PLUGIN_NAME . '-logs',
			array( $logs_loader, 'plugin_settings_page' ),
			30
		);
		add_action( "load-{$log_hook}", array( $logs_loader, 'screen_option' ) );
		// Contacts List Item
		add_submenu_page(
			WOO_ISHAARAT_PLUGIN_NAME,
			__( 'Contact Lists', WOO_ISHAARAT_PLUGIN_NAME),
			__( 'Contact Lists', WOO_ISHAARAT_PLUGIN_NAME),
			'manage_woocommerce',
			'edit.php?post_type=ishaarat_cl',
			false,
			40
		);
		// Subscribers Item
		$subscribers_loader = new Woo_Ishaarat_Admin_Subscribers_Loader();
		$subhook = add_submenu_page(
			WOO_ISHAARAT_PLUGIN_NAME,
			__( 'Subscribers', WOO_ISHAARAT_PLUGIN_NAME),
			__( 'Subscribers', WOO_ISHAARAT_PLUGIN_NAME),
			'manage_woocommerce',
			WOO_ISHAARAT_PLUGIN_NAME . '-subscribers',
			array( $subscribers_loader, 'plugin_settings_page' ),
			50
		);
		add_action( "load-{$subhook}", array( $subscribers_loader, 'screen_option' ) );
		// Extra items

		$submenu[WOO_ISHAARAT_PLUGIN_NAME][60] = array( '<div class="woo-ishaarat-links">' . __( 'Documentations', WOO_ISHAARAT_PLUGIN_NAME) . '</div>', 'manage_woocommerce', 'https://docs.ultimatesmsnotifications.com/?utm_source=' . get_site_url() );
		$submenu[WOO_ISHAARAT_PLUGIN_NAME][70] = array( '<div class="woo-ishaarat-links">' . __( 'Contact us', WOO_ISHAARAT_PLUGIN_NAME) . '</div>', 'manage_woocommerce', 'https://chatting.page/homescriptone?utm_source=' . get_site_url() );


	}
}