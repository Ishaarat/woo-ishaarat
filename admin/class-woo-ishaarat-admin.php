<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat-admin.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */
class Woo_Ishaarat_Admin {
	private  $plugin_name ;
	private  $version ;
	public function __construct( $plugin_name, $version )
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
	public function enqueue_styles()
	{
		global  $ishaarat_helper ;
		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/woo-ishaarat-admin.css',
			array(),
			$this->version,
			'all'
		);
		wp_enqueue_style(
			$this->plugin_name . '-datatables-css',
			plugin_dir_url( __FILE__ ) . 'css/jquery-datatables.css',
			array(),
			$this->version,
			'all'
		);

		if ( $ishaarat_helper->is_ishaarat_page() ) {
			wp_enqueue_style(
				$this->plugin_name . '-jquery-datepicker-css',
				plugin_dir_url( __FILE__ ) . 'css/jquery-datepicker.css',
				array(),
				$this->version,
				'all'
			);
			wp_enqueue_style(
				$this->plugin_name . '-phone-validator',
				plugin_dir_url( __FILE__ ) . 'css/jquery-phone-validator.css',
				array(),
				$this->version,
				'all'
			);
			wp_enqueue_style(
				$this->plugin_name . '-select2-css',
				plugin_dir_url( __FILE__ ) . 'css/jquery-select2.css',
				array(),
				$this->version,
				'all'
			);
			wp_enqueue_editor();
			wp_enqueue_style( 'jquery-ui-style' );
		}
	}

	public function enqueue_scripts()
	{
		global $ishaarat_helper ;
		$woo_ishaarat_ajax_variables = array(
			'woo_ishaarat_ajax_url'      => admin_url( 'admin-ajax.php' ),
			'woo_ishaarat_ajax_security' => wp_create_nonce( 'woo-ishaarat-ajax-nonce' )
		);
		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/woo-ishaarat-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);
		wp_enqueue_script(
			$this->plugin_name . '-datatables-js',
			plugin_dir_url( __FILE__ ) . 'js/jquery-datatables.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		if ( $ishaarat_helper->is_ishaarat_page( 'cl' ) ) {
			wp_enqueue_script(
				$this->plugin_name . '-blockUI',
				plugin_dir_url( __FILE__ ) . 'js/jquery-blockui.js',
				array( 'jquery' ),
				$this->version,
				false
			);
			wp_enqueue_script(
				$this->plugin_name . '-cl',
				plugin_dir_url( __FILE__ ) . 'js/woo-ishaarat-admin-cl.js',
				array(
					'jquery',
					$this->plugin_name . '-blockUI',
					'jquery-ui-core',
					'jquery-ui-datepicker'
				),
				$this->version,
				false
			);
			$woo_ishaarat_cl_variables = array(
				'woo_ishaarat_cl_rules_names'            => Woo_Ishaarat_UI_Fields::get_cl_rules_names(),
				'woo_ishaarat_cl_operators_names'        => Woo_Ishaarat_UI_Fields::get_cl_operators_names(),
				'woo_ishaarat_get_payment_methods'       => $ishaarat_helper::get_wc_payment_gateways(),
				'woo_ishaarat_get_shipping_methods'      => $ishaarat_helper::get_wc_shipping_methods(),
				'woo_ishaarat_country'                   => $ishaarat_helper::get_wc_country(),
				'woo_ishaarat_customer_roles'            => $ishaarat_helper::get_wp_roles(),
				'woo_ishaarat_customer_order_status'     => wc_get_order_statuses(),
				'woo_ishaarat_input_number_placeholders' => __( 'enter the amount', WOO_ISHAARAT_PLUGIN_NAME),
				'woo_ishaarat_text_field'                => __( 'separate domain name by commas', WOO_ISHAARAT_PLUGIN_NAME),
				'loader_message'                    => __( 'Loading ...', WOO_ISHAARAT_PLUGIN_NAME),
				'woo_ishaarat_cl_table_list'             => __( 'Customer List Details ', WOO_ISHAARAT_PLUGIN_NAME),
				'woo_ishaarat_cl_customer_name'          => __( 'Customers Names ', WOO_ISHAARAT_PLUGIN_NAME),
				'woo_ishaarat_cl_customer_phonenumber'   => __( 'Customers Phone Numbers ', WOO_ISHAARAT_PLUGIN_NAME),
			);
			$woo_ishaarat_ajax_variables = array_merge( $woo_ishaarat_ajax_variables, $woo_ishaarat_cl_variables );
		}

		wp_localize_script( $this->plugin_name, 'woo_ishaarat_ajax_object', $woo_ishaarat_ajax_variables );

		// settings page.
		if ( $ishaarat_helper->is_ishaarat_page() ) {
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
			wp_enqueue_script(
				$this->plugin_name . '-select2',
				plugin_dir_url( __FILE__ ) . 'js/jquery-select2.js',
				array( 'jquery' ),
				$this->version,
				false
			);
			$woo_ishaarat_ajax_variables['woo_ishaarat_phone_utils_path'] = plugin_dir_url( __FILE__ ) . 'js/jquery-phone-validator-utils.js';
			wp_enqueue_script(
				$this->plugin_name . '-settings',
				plugin_dir_url( __FILE__ ) . 'js/woo-ishaarat-admin-settings.js',
				array(
					'jquery',
					'jquery-ui-tooltip',
					'serializejson',
					'wp-hooks',
					$this->plugin_name . '-select2',
					$this->plugin_name,
					$this->plugin_name . '-phone-validator'
				),
				$this->version,
				false
			);
			wp_localize_script( $this->plugin_name . '-settings', 'woo_ishaarat_ajax_object', $woo_ishaarat_ajax_variables );
		}

	}


	/**
	 * Give feedback or reviews on the website or WP.org.
	 */
	public function review_answers()
	{
		$success = 0;

		if ( isset( $_POST['type'] ) ) {
			$success = 1;

			if ( $_POST['type'] === 'already_give' && wp_verify_nonce( $_POST['security'], 'woo-ishaarat-ajax-nonce' ) ) {
				update_option( 'ishaarat_have_already_give_reviews', true );
			} elseif ( $_POST['type'] === 'dismiss' && wp_verify_nonce( $_POST['security'], 'woo-ishaarat-ajax-nonce' ) ) {
				update_option( 'ishaarat_have_already_give_reviews', true );
			}

			if ( 1 === $success ) {
				update_option( 'ishaarat_display_banner', $success );
			}
		}

		echo  wp_json_encode( array(
			'status' => $success,
		) ) ;
		wp_die();
	}

	public static function settings_link( $links, $file )
	{

		if ( preg_match( '/woo-ishaarat\\.php/', $file ) && current_user_can( 'manage_options' ) ) {
			$settings = array(
				'settings' => '<a href="admin.php?page='.WOO_ISHAARAT_PLUGIN_NAME.'&tab=settings">' . __( 'Settings', WOO_ISHAARAT_PLUGIN_NAME ) . '</a>',
			);
			$links = array_merge( $settings, $links );
		}

		return $links;
	}

	public function send_msg_on_status_change( $order_id, $old_status, $new_status )
	{
		global $ishaarat_helper;
		global $ishaarat_wa_loader ;
		$_order = new WC_Order( $order_id );
		$country = $_order->get_billing_country();
		$country_indicator = $ishaarat_helper::get_country_town_code( $country );
		$_phone_number = $_order->get_billing_phone();
		$phone_number = $ishaarat_helper::get_right_phone_numbers( $country_indicator, $_phone_number );
		$phone_number = $country_indicator . $phone_number;
		$order_type = array(
			'on-hold',
			'completed',
			'processing',
			'cancelled',
			'pending',
			'failed'
		);
		$options = get_option( 'woo_ishaarat_options' );
		$shop_manager_can_change_on_order_status_change = $options['message_after_order_changed'];

		if ( '1' == $shop_manager_can_change_on_order_status_change ) {

			if ( in_array( $new_status, $order_type ) ) {

				if ( $new_status == 'completed' ) {
					$message = $options['completed_order_template'];
				} elseif ( $new_status == 'on-hold' ) {
					$message = $options['on_hold_order_template'];
				} elseif ( $new_status == 'processing' ) {
					$message = $options['processing_order_template'];
				} elseif ( $new_status == 'cancelled' ) {
					$message = $options['cancelled_order_template'];
				} elseif ( $new_status == 'pending_payment' ) {
					$message = $options['pending_payment_order_template'];
				} elseif ( $new_status == 'failed' ) {
					$message = $options['failed_order_template'];
				}

				$message = $ishaarat_helper::decode_message_to_send( $order_id, $message );
			}

			try {
				$status_code = $ishaarat_wa_loader->send_sms( $phone_number, $message );
				$status = Woo_Ishaarat_Helper::get_sms_status( $status_code );
			} catch ( Exception $errors ) {
				$status = Woo_Ishaarat_Helper::log_errors( $errors );
			}
			$orders_messages = '<br/><strong>' . __( 'Phone Numbers : ', WOO_ISHAARAT_PLUGIN_NAME) . '</strong>' . $phone_number . '<br/><strong>' . __( 'Message sent : ', WOO_ISHAARAT_PLUGIN_NAME) . '</strong>' . $message . '<br/><strong>' . __( 'Delivery Messages Status : ', WOO_ISHAARAT_PLUGIN_NAME) . '</strong>' . $status . '<br/>' . 'Sent from <strong>Ishaarat Order and Abandoned carts notifications for WooCommerce</strong>';
			$_order->add_order_note( $orders_messages );
		}

	}

	public function send_sms_from_orders_by_ajax()
	{

		if ( is_admin() && true == current_user_can( 'install_plugins' ) ) {
			$posted_data = filter_input_array( INPUT_POST );
			$security = $posted_data['security'];

			if ( wp_verify_nonce( $security, 'woo-ishaarat-ajax-nonce' ) ) {
				global $ishaarat_helper;
				global $ishaarat_wa_loader;
				$ajax_data = $posted_data['data'];
				$order_id = sanitize_text_field( $ajax_data['order-id'] );
				$message = sanitize_text_field( $ajax_data['messages-to-send'] );
				$order = wc_get_order( $order_id );
				$country = $order->get_billing_country();
				$country_indicator = $ishaarat_helper::get_country_town_code( $country );
				$_phone_number = $order->get_billing_phone();
				$phone_number = $country_indicator . $ishaarat_helper::get_right_phone_numbers( $country_indicator, $_phone_number );

				if ( !empty($phone_number) && !empty($message) ) {
					$message = $ishaarat_helper::decode_message_to_send( $order_id, $message );
					try {
						$status_code = $ishaarat_wa_loader->send_sms( $phone_number, $message );
						$return = Woo_Ishaarat_Helper::get_sms_status( $status_code );
					} catch ( Exception $errors ) {
						$return = Woo_Ishaarat_Helper::log_errors( $errors );
					}
					$orders_messages = '<br/><strong>' . __( 'Phone Numbers : ', WOO_ISHAARAT_PLUGIN_NAME) . '</strong>' . $phone_number . '<br/><strong>' . __( 'Message sent : ', WOO_ISHAARAT_PLUGIN_NAME) . '</strong>' . $message . '<br/><strong>' . __( 'Delivery Messages Status : ', WOO_ISHAARAT_PLUGIN_NAME) . '</strong>' . $return . '<br/>' . 'Sent from <strong>Ultimate SMS & WhatsApp Notifications for WooCommerce</strong>';
					$order->add_order_note( $orders_messages );
					Woo_Ishaarat_UI_Fields::format_html_fields( $return );
				} else {
					esc_html_e( 'Please fill messages and phone numbers fields before press Send.', WOO_ISHAARAT_PLUGIN_NAME);
				}

			}

			wp_die();
		}

	}

	public function footer_credits( $text )
	{
		global  $ishaarat_helper ;
		if ( $ishaarat_helper->is_ishaarat_page() ) {
			$text = sprintf(
				__( 'If you like %1$s please leave us a %2$s rating.This will make happy %3$s.', WOO_ISHAARAT_PLUGIN_NAME),
				printf( '<strong>%s</strong>', esc_html__( 'Ishaarat Orders and Abandoned Carts notifications for WooCommerce', WOO_ISHAARAT_PLUGIN_NAME) ),
				'<a href="https://wordpress.org/support/plugin/'.WOO_ISHAARAT_PLUGIN_NAME.'/reviews?rate=5#new-post" target="_blank" class="wc-rating-link" data-rated="' . esc_attr__( 'Thanks :)', WOO_ISHAARAT_PLUGIN_NAME) . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>',
				sprintf( '<strong>%s</strong>', esc_html__( 'Algovers LTD.', WOO_ISHAARAT_PLUGIN_NAME) )
			);
		}
		return $text;
	}

	public function get_api_response_code()
	{
		global $ishaarat_wa_loader;
		$posted_data = filter_input_array( INPUT_POST );
		$security = $posted_data['security'];

		if ( wp_verify_nonce( $security, 'woo-ishaarat-ajax-nonce' ) ) {
			$ajax_data = $posted_data['data'];
			$testing_numbers = sanitize_text_field( $ajax_data['testing-numbers'] );
			$testing_message = sanitize_text_field( $ajax_data['testing-messages'] );
			$country_code = sanitize_text_field( $ajax_data['country_code'] );
			$testing_message = Woo_Ishaarat_Helper::decode_message_to_send( null, $testing_message );

			if ( !$testing_numbers ) {
				$status_code = __( 'Please provide an phone number before to press Send SMS.', WOO_ISHAARAT_PLUGIN_NAME);
			} else {
				try {
					$testing_numbers = Woo_Ishaarat_Helper::get_right_phone_numbers( $country_code, $testing_numbers );
					$testing_numbers = $country_code . $testing_numbers;
					$return = $ishaarat_wa_loader->send_sms( $testing_numbers, $testing_message );
					$status_code = Woo_Ishaarat_Helper::get_sms_status( $return );
				} catch ( Exception $errors ) {
					$status_code = Woo_Ishaarat_Helper::log_errors( $errors );
				}
			}

		}

		Woo_Ishaarat_UI_Fields::format_html_fields( $status_code );
		wp_die();
	}

	public function check_requirements()
	{
		// Check if WC is installed.
		global  $ishaarat_helper ;
		$ishaarat_helper::is_wc_active( 'admin' );
		$auth_key = get_option( 'woo_ishaarat_api_auth_key' );
		$app_key = get_option( 'woo_ishaarat_api_app_key' );

		if ( !$auth_key || !$app_key ) {
			$links = '<a href="admin.php?page='.WOO_ISHAARAT_PLUGIN_NAME.'&tab=api-options" >' . __( 'you can setup the plugin here', WOO_ISHAARAT_PLUGIN_NAME) . '</a>';
			?>
			<div class=" notice notice-error">
				<p>
					<?php
					Woo_Ishaarat_UI_Fields::format_html_fields( wp_sprintf( '<strong>Ishaarat Orders and Abandoned Carts notifications for WooCommerce is almost ready.</strong> To get started, %s.', $links ) );
					?>
				</p>
			</div>
			<?php
		}

		$options = get_option( 'woo_ishaarat_options' );
		if ( isset( $options['sms_to_vendors'] ) ) {

			if ( !function_exists( 'wcfm_get_vendor_id_by_post' ) && !function_exists( 'dokan' ) ) {
				?>
				<div class=" notice notice-error">
					<p>
						<?php
						Woo_Ishaarat_UI_Fields::format_html_fields( '<strong>SMS Notifications to vendors</strong> requires <strong>Dokan</strong>/<strong>WCFM Vendors</strong> in order to work. ', WOO_ISHAARAT_PLUGIN_NAME);
						?>
					</p>
				</div>
				<?php
			}

		}
		$woo_ishaarat_display_banner = get_option( 'ishaarat_display_banner' );
		$display_banner = 'display : block ;';

		if ( $woo_ishaarat_display_banner == 1 ) {
			$reviews_already_give = get_option( 'ishaarat_have_already_give_reviews' );
			$dismiss_banner = get_option( 'ishaarat_dismiss_banner' );
			if ( $dismiss_banner || $reviews_already_give ) {
				$display_banner = 'display : none ;';
			}
		}

		// display newsletters banner.
		?>
		<div id="woo_ishaarat_banner" class="notice notice-info" style="<?php
		Woo_Ishaarat_UI_Fields::format_html_fields( $display_banner );
		?>">
			<p>
			<div id="ishaaratthank-you" style="display : inline;">
				<p id="woorci-banner-content"><strong
						style="font-size : 15px;"><?php
						esc_html_e( 'Enjoying Ishaarat Orders and Abandoned Carts notifications for WooCommerce?', WOO_ISHAARAT_PLUGIN_NAME);
						?></strong>
					<br/> <?php
					esc_html_e( ' Hope that you had a neat and snappy experience with the plugin. Would you please show us a little love by rating us in the WordPress.org?', WOO_ISHAARAT_PLUGIN_NAME);
					?>
				</p>
				<p style="position: relative; left: 1px; top: -8px;">
					<a href="https://wordpress.org/support/plugin/<?= WOO_ISHAARAT_PLUGIN_NAME;?>/reviews/#postform"
					   id="ishaarat-review" target="_blank"><span class="dashicons dashicons-external"></span>Sure! I'd love
						to!</a>
					&nbsp
					<a href="#" id="ishaarat-already-give-review"><span class="dashicons dashicons-smiley"></span>I've
						already
						left a review</a> &nbsp
					<a href="#" id="ishaarat-never-show-again"><span class="dashicons dashicons-dismiss"></span>Never show
						again</a>
				</p>
			</div>
		</div>
		<?php
		do_action( 'woo_ishaarat_admin_notices' );
	}

	public function save_api_credentials()
	{
		$success = 0;
		$posted_data = filter_input_array( INPUT_POST );
		$security = $posted_data['security'];

		if ( wp_verify_nonce( $security, 'woo-ishaarat-ajax-nonce' ) ) {
			$data = $posted_data['data'];
			$auth_key = sanitize_text_field( $data['auth_key'] );
			$app_key = sanitize_text_field( $data['app_key'] );

			update_option( 'woo_ishaarat_api_auth_key', $auth_key );
			update_option( 'woo_ishaarat_api_app_key', $app_key );
			$success = 1;

		}

		$success = apply_filters( 'woo_ishaarat_save_credentials_status', $success, $posted_data['data'] );
		echo  wp_json_encode( array(
			'status' => $success,
		) ) ;
		wp_die();
	}

	public function send_sms_to_cl()
	{
		$posted_data = filter_input_array( INPUT_POST );
		$security = $posted_data['security'];

		if ( wp_verify_nonce( $security, 'woo-ishaarat-ajax-nonce' ) ) {
			$cl_id = $posted_data['data']['contact-list'];
			$msg = $posted_data['data']['testing-messages'];
            $cl = get_post_meta($cl_id, 'woo-ishaarat-cl');
			$order_lists = Woo_Ishaarat_CPT::woo_ishaarat_query_customers_list( $cl, true );
			foreach ( $order_lists as $order_id ) {
				$_order = new WC_Order( $order_id );
				$country = $_order->get_billing_country();
				$_phone_number = Woo_Ishaarat_Helper::get_right_phone_numbers( $country, $_order->get_billing_phone() );
				if ( !isset( $_phone_number ) && !isset( $country ) ) {
					return;
				}
				$country_indicator = Woo_Ishaarat_Helper::get_country_town_code( $country );
				$phone_number = $country_indicator . Woo_Ishaarat_Helper::get_right_phone_numbers( $country_indicator, $_phone_number );
				$sms_obj = new Woo_Ishaarat_WA();
				$sms_obj->send_sms( $phone_number, $msg );
			}
		}

		echo  __( 'Msgs are scheduled to send, you can check SMS logs for more details.', WOO_ISHAARAT_PLUGIN_NAME ) ;
		wp_die();
	}

}