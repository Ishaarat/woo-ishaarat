<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat-wa.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */

class Woo_Ishaarat_WA {

	const API_URL = "https://ishaarat.com/api/";
	/**
	 * This variable contains all the data related to the SMS API object.
	 *
	 * @var object
	 */
	private $api_credentials;

	/**
	 * Class constructor.
	 */
	public function __construct() {
		/** @var Woo_Ishaarat_Helper $ishaarat_helper */
		global $ishaarat_helper;
		$this->api_credentials = json_decode( $ishaarat_helper::get_api_credentials() );
	}

	public static function save_log_to_db(
		$to,
		$msg,
		$status
	) {
		global $wpdb;
		$table_name      = $wpdb->prefix . '_ishaarat_logs';
		$timezone_format = _x( 'Y-m-d  H:i:s', 'timezone date format' );
		$wpdb->insert( $table_name, array(
			'msg_to'     => $to,
			'messages'   => $msg,
			'status'     => $status,
			'created_at' => date_i18n( $timezone_format, false, true ),
		) );
	}

	/**
	 * Send SMS using Twilio Rest API.
	 *
	 * @return mixed
	 */
	private function send_sms_with_rest(
		$to,
		$body
	) {
		global $wpdb;
		$headers     = array(
			'Authorization' => 'Bearer ' . $this->api_credentials->auth_key,
		);
		$data        = [
			'appkey'      => $this->api_credentials->app_key,
			'to'          => $to,
			'message'     => $body,
			'template_id' => 0
		];
		$result      = wp_remote_post( self::API_URL . 'create-message', array(
			'body'    => $data,
			'headers' => $headers,
			'timeout' => 65,
			'method'  => 'POST',
		) );
		$body_result = wp_remote_retrieve_body( $result );
		$body_status = wp_remote_retrieve_response_code( $result );
		if ( ! preg_match( '/^2([0-9]{1})([0-9]{1})$/', $body_status ) ) {
			if ( function_exists( 'wc_get_logger' ) ) {
				$wc_log = wc_get_logger();
				$wc_log->error( 'error : ' . print_r( $body_result, true ), array(
					'source' => WOO_ISHAARAT_PLUGIN_NAME,
				) );
			} else {
				Woo_Ishaarat_Helper::write_log( 'error : ' . print_r( $body_result, true ) );
			}
			self::save_log_to_db($to, $body, 'failed');
			return 400;
		}

		if ( is_object( $body_result ) ) {
			$decoded = get_object_vars( $body_result );
		} else {
			$decoded = json_decode( $body_result );
		}
		$decoded_data = get_object_vars( $decoded );
		if ( $decoded_data['status'] == 'success' ) {
			self::save_log_to_db($to, $body, 'success');
			return 200;
		} else {

			if ( function_exists( 'wc_get_logger' ) ) {
				$wc_log = wc_get_logger();
				$wc_log->error( 'error : ' . print_r( $decoded_data, true ), array(
					'source' => WOO_ISHAARAT_PLUGIN_NAME,
				) );
			} else {
				Woo_Ishaarat_Helper::write_log( 'error : ' . print_r( $decoded, true ) );
			}
			self::save_log_to_db($to, $body, 'failed');
			return 400;
		}
	}

	/**
	 * This functions send SMS to phone numbers using the SMS API defined.
	 *
	 * @param string $phone_number Customer phone number.
	 * @param string $message_to_send Message to send to customer.
	 *
	 * @return bool|string
	 */
	public final function send_sms( $phone_number, $message_to_send ) {
		$phone_number = str_ireplace( ' ', '', $phone_number );
		$status       = $this->send_sms_with_rest( $phone_number, $message_to_send ) ?? 400;

		return apply_filters(
			'woo_ishaarat_send_sms_to_customer',
			$status,
			$phone_number,
			$message_to_send
		);
	}

	/**
	 * This method allows to send SMS based on the data related at a WC order.
	 *
	 * @param int $order WooCommerce Order ID.
	 *
	 * @return void
	 */
	public function send_api_messages( $order ) {

		global $ishaarat_helper;
		$_order        = new WC_Order( $order );
		$country       = $_order->get_billing_country();
		$_phone_number = $ishaarat_helper::get_right_phone_numbers( $country, $_order->get_billing_phone() );
		if ( ! isset( $_phone_number ) && ! isset( $country ) ) {
			return;
		}
		$country_indicator = $ishaarat_helper::get_country_town_code( $country );
		$phone_number      = $country_indicator . $ishaarat_helper::get_right_phone_numbers( $country_indicator, $_phone_number );
		$options           = get_option( 'woo_ishaarat_options' );
		if ( isset( $options['message_after_customer_purchase'] ) ) {
			$customer_message = $ishaarat_helper::decode_message_to_send( $order, $options['success_order_template'] );

			// send SMS to customer.
			if ( isset( $customer_message ) && ! is_admin() ) {
				$this->sms_to_numbers( $_order, $phone_number, $customer_message );
			}
		}

		if ( isset( $options['msg_to_admin'] ) ) {
			$admin_can_receive_messages = esc_attr( $options['msg_to_admin'] );
			$admin_numbers              = esc_attr( $options['admin_numbers'] );
			$admin_message              = $ishaarat_helper::decode_message_to_send( $order, $options['admin_message_template'] );
			// send SMS to shop manager.
			if ( isset( $admin_can_receive_messages ) && ! is_admin() ) {
				$this->sms_to_numbers( $_order, $admin_numbers, $admin_message );
			}
		}
	}

	private function sms_to_numbers( $order_obj, $pn, $message ) {
		$status_code     = $this->send_sms( $pn, $message );
		$status          = Woo_Ishaarat_Helper::get_sms_status( $status_code );
		$orders_messages = '<br/><strong>' . __( 'Phone Numbers : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>' . $pn . '<br/><strong>' . __( 'Messages : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>' . $message . '<br/><strong>' . __( 'Message Status : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>' . $status . '<br/>' . __( 'Sent from', WOO_ISHAARAT_PLUGIN_NAME ) . '<strong>Ishaarat Order & Abandonded Cart Whatsapp Notifications for WooCommerce</strong>';
		$order_obj->add_order_note( $orders_messages );
	}


	public static function send_sms_to_new_customers( $customer_obj, $data ) {
		// prevent multiple sms send after user creation.
		if ( $customer_obj->get_date_created() != null ) {
			return;
		}
		$options = get_option( 'woo_ishaarat_options' );

		if ( ! empty( $options['messages_after_customer_signup'] ) ) {
			$billing_phone     = $data['billing_phone'];
			$billing_country   = $data['billing_country'];
			$real_country_code = Woo_Ishaarat_Helper::get_country_town_code( $billing_country );
			$real_pn           = $real_country_code . $billing_phone;
			$template_message  = $options['customer_signup_template'];
			$customer_message  = preg_replace( array(
				'/%store_name%/',
				'/%customer_name%/',
				'/%customer_phone_number%/'
			), array(
				get_bloginfo( 'name' ),
				$data['billing_first_name'] . ' ' . $data['billing_last_name'],
				$real_pn
			), $template_message );
			$waHelper          = new Woo_Ishaarat_WA();
			$waHelper->send_sms( $real_pn, $customer_message );
		}

	}
}