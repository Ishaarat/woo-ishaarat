<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat-public.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */

class Woo_Ishaarat_public {
	
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private  $plugin_name ;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private  $version ;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version )
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		global  $ishaarat_helper ;
		if ( !is_admin() || $ishaarat_helper->is_product_page() ) {
			wp_enqueue_style(
				$this->plugin_name . '-phone-validator',
				plugin_dir_url( __FILE__ ) . 'css/jquery-phone-validator.css',
				array(),
				$this->version,
				'all'
			);
		}
		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/woo-ishaarat-public.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		if ( class_exists( 'WooCommerce' ) && is_checkout() ) {
			$enqueue_list = array( 'jquery' );
			$localize_object = array();
			wp_enqueue_script(
				$this->plugin_name . '-phone-validator',
				plugin_dir_url( __FILE__ ) . 'js/jquery-phone-validator.js',
				array( 'jquery', 'jquery-ui-tooltip' ),
				$this->version,
				false
			);
			wp_enqueue_script(
				$this->plugin_name . '-phone-validator-utils',
				plugin_dir_url( __FILE__ ) . 'js/jquery-phone-validator-utils.js',
				array( 'jquery', 'jquery-ui-tooltip' ),
				$this->version,
				false
			);
			$options = get_option( 'woo_ishaarat_options' );
			$enqueue_list[] = $this->plugin_name . '-phone-validator';
			$localize_object['woo_ishaarat_phone_utils_path'] = plugin_dir_url( __FILE__ ) . 'js/jquery-phone-validator-utils.js';
			$localize_object['wrong_phone_number_messages'] = __( 'The phone number provided isn\'t valid, please correct it.', WOO_ISHAARAT_PLUGIN_NAME );
			$localize_object['user_country_code'] = strtolower( $options['default_country_selector'] ?? 'EG' );
			$wc_countries = new WC_Countries();
			$localize_object['wc_allowed_countries'] = array_keys( $wc_countries->get_allowed_countries() );
			wp_enqueue_script(
				$this->plugin_name,
				plugin_dir_url( __FILE__ ) . 'js/woo-ishaarat-public.js',
				$enqueue_list,
				$this->version,
				false
			);
			wp_localize_script( $this->plugin_name, 'woo_ishaarat_ajax_object', $localize_object );
		}

	}

	/**
	 * This method send SMS based on the order ID.
	 *
	 * @param object $order_id WooCommerce Order ID.
	 *
	 * @return void
	 */
	public function thank_you_msg( $order_id )
	{
		global  $ishaarat_wa_loader ;
		$ishaarat_wa_loader->send_api_messages( $order_id );
		do_action( 'woo_ishaarat_send_sms_after_an_order', $order_id, $ishaarat_wa_loader );
	}

	/**
	 * Get customer consent.
	 */
	public function get_customer_consent()
	{
		$options = get_option( 'woo_ishaarat_options' );

		if ( isset( $options['sms_consent'] ) ) {
			$content = __( 'I would receive any kind of Whatsapp on my phone number.', WOO_ISHAARAT_PLUGIN_NAME);
			if ( !empty($options['wa_consent_text_to_display']) ) {
				$content = $options['wa_consent_text_to_display'];
			}
			?>
			<p class="form-row validate-required">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="woo_ishaarat_wa_consent" <?php
					checked( apply_filters( 'woo_ishaarat_must_send_wa', isset( $_POST['woo_ishaarat_wa_consent'] ) ), true );
					?> id="woo_ishaarat_wa_consent" />
					<span class="woocommerce-terms-and-conditions-checkbox-text"><?php
						Woo_Ishaarat_UI_Fields::format_html_fields( $content );
						?></span>&nbsp;
				</label>
			</p>
			<?php
		}

	}

	/**
	 * Store customer consent.
	 */
	public function store_customer_consent( WC_Order $order )
	{
		$sent_consent = filter_input( INPUT_POST, 'woo_ishaarat_wa_consent' ) ?? 'off';
		$customer_id = $order->get_customer_id();
		update_user_meta( $customer_id, 'woo_ishaarat_allow_wa_sending', $sent_consent );
		global  $wpdb ;
		$table_name = $wpdb->prefix . '_ishaarat_subscribers';
		$timezone_format = _x( 'Y-m-d  H:i:s', 'timezone date format' );
		$wpdb->insert( $table_name, array(
			'customer_id'              => $customer_id,
			'customer_consent'         => $sent_consent,
			'registered_page' => 'checkout',
			'created_at'               => date_i18n( $timezone_format, false, true ),
		) );
	}

	public function validate_pn()
	{
		$pn_is_valid = filter_input( INPUT_POST, 'woo_ishaarat_pn_is_valid' );

		if ( $pn_is_valid == "no" ) {
			$title = "<strong>" . __( 'Billing Phone', 'woocommerce' ) . '</strong>';
			$message = $title . " " . __( 'is not valid, please correct it.', WOO_ISHAARAT_PLUGIN_NAME );
			wc_add_notice( $message, 'error' );
		}
	}

	public function get_validation_block_html()
	{
		?>
		<input type="hidden" id="wooishaarat_pn_valid" name="woo_ishaarat_pn_is_valid" value="no"/>
		<?php
	}


}