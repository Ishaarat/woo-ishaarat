<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */

class Woo_Ishaarat {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Ishaarat_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected  $loader ;
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected  $plugin_name ;
	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected  $version ;
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{

		if ( defined( 'WOO_ISHAARAT_VERSION' ) ) {
			$this->version = WOO_ISHAARAT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		if( defined('WOO_ISHAARAT_PLUGIN_NAME') ){
			$this->plugin_name = WOO_ISHAARAT_PLUGIN_NAME;
		}else{
			$this->plugin_name = 'woo-ishaarat';
		}
		$this->load_dependencies();
		$this->set_locale();
		if ( is_admin() ) {
			$this->define_admin_hooks();
		} else {
			$this->define_public_hooks();
		}
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{
		$plugin_i18n = new Woo_Ishaarat_I18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$plugin_admin = new Woo_Ishaarat_Admin( $this->get_plugin_name(), $this->get_version() );
		/**
		 * Admin part.
		 */
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'check_requirements' );
		$this->loader->add_filter(
			'admin_footer_text',
			$plugin_admin,
			'footer_credits',
			10,
			1
		);
		$this->loader->add_action(
			'admin_menu',
			'Woo_Ishaarat_Admin_Menu',
			'add_menus',
			10,
			1
		);
		$this->loader->add_action( 'admin_init', 'Woo_Ishaarat_Admin_Settings', 'display_options_on_each_tab' );
		/**
		 * AJAX functions.
		 */
		$this->loader->add_action( 'wp_ajax_woo_ishaarat_save-api-credentials', $plugin_admin, 'save_api_credentials' );
		$this->loader->add_action( 'wp_ajax_woo_ishaarat-review-answers', $plugin_admin, 'review_answers' );
		$this->loader->add_action( 'wp_ajax_woo_ishaarat_send-messages-manually-from-orders', $plugin_admin, 'send_sms_from_orders_by_ajax' );
		$this->loader->add_action( 'wp_ajax_woo_ishaarat-get-api-response-code', $plugin_admin, 'get_api_response_code' );
		$this->loader->add_action( 'wp_ajax_woo_ishaarat-send-sms-to-contacts', $plugin_admin, 'send_sms_to_cl' );
		/**
		 * CPT part.
		 */
		$this->loader->add_action( 'add_meta_boxes', 'Woo_Ishaarat_Admin_Settings', 'message_from_orders_metabox' );
		$this->loader->add_action( 'init', 'Woo_Ishaarat_CPT', 'init' );
		$this->loader->add_action( 'add_meta_boxes', 'Woo_Ishaarat_CPT', 'add_metabox' );
		$this->loader->add_action( 'wp_ajax_woo-ishaarat-get-customers-list','Woo_Ishaarat_CPT', 'woo_ishaarat_get_customers_list' );
		$this->loader->add_filter(
			'plugin_action_links',
			$plugin_admin,
			'settings_link',
			11,
			2
		);
		$this->loader->add_action(
			'woocommerce_order_status_changed',
			$plugin_admin,
			'send_msg_on_status_change',
			15,
			3
		);
		$this->loader->add_filter( 'manage_edit-woo_ishaarat-sms-panel_columns', $plugin_admin, 'change_sms_cpt_columns' );
		$this->loader->add_filter( 'manage_edit-woo_ishaarat-stats_columns', $plugin_admin, 'change_sms_stat_cpt_columns__premium_only' );
		$this->loader->add_action( 'save_post_ishaarat_cl', 'Woo_Ishaarat_CPT', 'save_customer_list' );

	}
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{
		$plugin_public = new Woo_Ishaarat_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action(
			'woocommerce_thankyou',
			$plugin_public,
			'thank_you_msg',
			99
		);
		$this->loader->add_action( 'woocommerce_checkout_after_terms_and_conditions', $plugin_public, 'get_customer_consent' );
		$this->loader->add_action(
			'woocommerce_checkout_update_customer',
			new Woo_Ishaarat_WA(),
			'send_sms_to_new_customers',
			12,
			2
		);
		$this->loader->add_action(
			'woocommerce_checkout_order_created',
			$plugin_public,
			'store_customer_consent',
			15
		);
		$this->loader->add_action(
			'woocommerce_before_checkout_process',
			$plugin_public,
			'validate_pn',
			15
		);
		$this->loader->add_action( 'woocommerce_checkout_billing', $plugin_public, 'get_validation_block_html' );
	}
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{
		require_once WOO_ISHAARAT_PATH . '../inc/class-woo-ishaarat-loader.php';
		require_once WOO_ISHAARAT_PATH . '../inc/class-woo-ishaarat-i18n.php';
		require_once WOO_ISHAARAT_PATH . '../admin/class-woo-ishaarat-admin.php';
		require_once WOO_ISHAARAT_PATH . '../public/class-woo-ishaarat-public.php';
		$this->loader = new Woo_Ishaarat_Loader();
	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Woo_Ishaarat_Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @return    string    The version number of the plugin.
	 * @since     1.0.0
	 */
	public function get_version()
	{
		return $this->version;
	}
}