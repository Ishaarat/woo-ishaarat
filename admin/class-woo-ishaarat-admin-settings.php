<?php
/**
 *
 * @link  https://algovers.com
 * @since 1.0.0
 * @file class-woo-ishaarat-admin-settings.php
 * @package    Woo_Ishaarat
 * @subpackage Woo_Ishaarat/inc
 * @author     Mageserv LTD. <mageserv.ltd@gmail.com>
 */

class Woo_Ishaarat_Admin_Settings {
	/**
	 * Function for configure settings.
	 */
	public static function configure_woo_ishaarat_settings()
	{
		?>
		<?php

		if ( isset( $_GET ) && isset( $_GET['tab'] ) && !wp_verify_nonce( '_wpnonce' ) ) {
			$active_tab = filter_input( INPUT_GET, 'tab' );
		} else {
			$active_tab = 'options';
		}

		$settings_names = apply_filters( 'woo_ishaarat_settings_names', array(
			'options'      => array(
				'url'   => '?page='. WOO_ISHAARAT_PLUGIN_NAME .'&tab=options',
				'title' => __( 'Message Notifications', WOO_ISHAARAT_PLUGIN_NAME),
			),
            'abandoned-options'      => array(
				'url'   => '?page='. WOO_ISHAARAT_PLUGIN_NAME .'&tab=abandoned-options',
				'title' => __( 'Abandoned Carts', WOO_ISHAARAT_PLUGIN_NAME ),
			),
			'api-options'      => array(
				'url'   => '?page='. WOO_ISHAARAT_PLUGIN_NAME .'&tab=api-options',
				'title' => __( 'API settings', WOO_ISHAARAT_PLUGIN_NAME ),
			),

		) );
		?>
		<div class="wrap">
			<h1> <?php
				__( 'Ishaarat Order notifications and Abandoned carts for WooCommerce', WOO_ISHAARAT_PLUGIN_NAME );
				?></h1>
			<?php
			settings_errors();
			?>

			<h2 class="wooishaarat nav-tab-wrapper">
				<?php
				foreach ( $settings_names as $keyname => $keyvalues ) {
					$class_name = ( $active_tab === $keyname ? 'wooishaarat-tab-active nav-tab-active' : '' );
					?>
					<a href="<?php
					echo  wp_kses_post( $keyvalues['url'] ) ;
					?>"
					   class="wooishaarat-tab nav-tab <?php
					   echo  esc_attr( $class_name ) ;
					   ?>"> <?php
						echo  wp_kses_post( $keyvalues['title'] ) ;
						?></a>
					<?php
				}
				?>
			</h2>


			<form method="post" action="options.php">
				<?php

				if ( 'options' === $active_tab ) {
					?>
					<div class="wooishaarat-options-tab">
						<?php
						settings_fields( 'woo_ishaarat_options' );
						do_settings_sections( 'woo_ishaarat_options' );
						do_action( 'woo_ishaarat_options' );
						submit_button();
						?>
					</div>
					<?php
				} elseif ( 'api-options' === $active_tab ) {
					self::display_settings_fields();
				}
				do_action( 'woo_ishaarat_add_settings_tabs', $active_tab );
				?>

			</form>
		</div>
		<?php
	}

	/**
	 * Function to display the options on each tab.
	 */
	public static function display_options_on_each_tab()
	{
		/*
		 * -----------------------------------------------------------------------------
		 * Options.
		 * -----------------------------------------------------------------------------
		 */
		// Select Options.
		add_settings_section(
			'woo_ishaarat_options_page',
			// ID used to identify this section and with which to register options.
			__( 'Setup your Notifications', WOO_ISHAARAT_PLUGIN_NAME ),
			// Title to be displayed on the administration page.
			__CLASS__ . '::description_for_the_tab_pages',
			// Callback used to render the description of the section.
			'woo_ishaarat_options'
		);
		add_settings_field(
			'messages_from_orders',
			// ID used to identify the field throughout the theme.
			__( 'Send message from WooCommerce Orders Details :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::messages_from_orders',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-message-from-orders',
			)
		);
		add_settings_field(
			'messages_after_customer_signup',
			// ID used to identify the field throughout the theme.
			__( 'Send message to customer registering a new account from checkout page :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::after_customer_sign',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-message-after-signups',
			)
		);
		add_settings_field(
			'customer_signup_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send to customer signing up :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::default_signup_message',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-signup-defaults-messages',
			)
		);
		add_settings_field(
			'customer_signup_tags',
			// ID used to identify the field throughout the theme.
			'',
			// The label to the left of the option interface element.
			__CLASS__ . '::display_customer_signup_tags',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'is_vendor' => true,
				'class'     => 'woo-ishaarat-signup-defaults-messages',
			)
		);
		add_settings_field(
			'message_after_customer_purchase',
			// ID used to identify the field throughout the theme.
			__( 'Send message after customer purchase :  ', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::after_customer_purchase',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-message-after-customer-purchase',
			)
		);
		add_settings_field(
			'success_order_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send to customer after a successfully purchase on your store :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::default_sms_messages',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-defaults-messages',
			)
		);
		add_settings_field(
			'message_after_order_changed',
			// ID used to identify the field throughout the theme.
			__( 'Send message after changing WooCommerce Order Status :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::after_order_changed',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-message-after-order-changed',
			)
		);
		add_settings_field(
			'completed_order_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send when the order status is completed :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::sms_when_completed',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-completed-messages',
			)
		);
		add_settings_field(
			'processing_order_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send when the order status is processing :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::sms_when_processing',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-completed-messages',
			)
		);
		add_settings_field(
			'cancelled_order_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send when the order status is cancelled :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::sms_when_cancelled',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-completed-messages',
			)
		);
		add_settings_field(
			'refunded_order_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send when the order status is refunded :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::sms_when_refunded',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-completed-messages',
			)
		);
		add_settings_field(
			'on_hold_order_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send when the order status is on hold :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::sms_when_on_hold',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-completed-messages',
			)
		);
		add_settings_field(
			'failed_order_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send when the order status is failed :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::sms_when_failed',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-completed-messages',
			)
		);
		add_settings_field(
			'pending_payment_order_template',
			// ID used to identify the field throughout the theme.
			__( 'Message to send when the order status is pending payment :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::sms_when_pending_payment',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-completed-messages',
			)
		);
		add_settings_field(
			'msg_to_admin',
			// ID used to identify the field throughout the theme.
			__( 'Send message to shop owner/manager after an order completed :  ', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::messages_to_admin',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				// The array of arguments to pass to the callback. In this case, just a description.
				'',
			)
		);
		add_settings_field(
			'admin_message_template',
			// ID used to identify the field throughout the theme.
			__( 'Message that shop owner/manager will receive after a completed order : ', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::display_shop_admin_template_messages',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-admin-completed-messages',
			)
		);
		add_settings_field(
			'admin_numbers',
			// ID used to identify the field throughout the theme.
			__( 'Phone number of the store owner/manager : ', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::display_shop_admin_numbers',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-admin-completed-messages',
			)
		);
		add_settings_field(
			'notification_to_vendor',
			// ID used to identify the field throughout the theme.
			__( 'Send message to vendors after an order completed :', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::messages_to_vendor',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				// The array of arguments to pass to the callback. In this case, just a description.
				'',
			)
		);
		add_settings_field(
			'vendor_message_template',
			// ID used to identify the field throughout the theme.
			__( 'Message that vendor will receive after an completed order : ', WOO_ISHAARAT_PLUGIN_NAME ),
			// The label to the left of the option interface element.
			__CLASS__ . '::display_vendor_template_messages',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'class' => 'woo-ishaarat-vendor-completed-messages',
			)
		);
		add_settings_field(
			'vendor_options_tags',
			// ID used to identify the field throughout the theme.
			'',
			// The label to the left of the option interface element.
			__CLASS__ . '::display_options_tags',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				'is_vendor' => true,
				'class'     => 'woo-ishaarat-vendor-completed-messages',
			)
		);
		add_settings_field(
			'options_tags',
			// ID used to identify the field throughout the theme.
			'',
			// The label to the left of the option interface element.
			__CLASS__ . '::display_options_tags',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				// The array of arguments to pass to the callback. In this case, just a description.
				'',
			)
		);
		add_settings_field(
			'sms_consent',
			// ID used to identify the field throughout the theme.
			__( 'Get customer approbation before sending him message : ', WOO_ISHAARAT_PLUGIN_NAME ),
			__CLASS__ . '::display_consent_sms',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				// The array of arguments to pass to the callback. In this case, just a description.

			)
		);
		add_settings_field(
			'wa_consent_text_to_display',
			// ID used to identify the field throughout the theme.
			__( 'text asking customer to consent sending whatsapp notifications and messages : ', WOO_ISHAARAT_PLUGIN_NAME ),
			__CLASS__ . '::display_consent_sms_content',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				// The array of arguments to pass to the callback. In this case, just a description.
				'class' => 'woo-ishaarat-customer-consent'
			)
		);
		add_settings_field(
			'sms_default_country',
			// ID used to identify the field throughout the theme.
			__( 'Default Country to use on the Phone Number country selector : ', WOO_ISHAARAT_PLUGIN_NAME ),
			__CLASS__ . '::choose_default_country_selector',
			// The name of the function responsible for rendering the option interface.
			'woo_ishaarat_options',
			// The page on which this option will be displayed.
			'woo_ishaarat_options_page',
			// The name of the section to which this field belongs.
			array(
				// The array of arguments to pass to the callback. In this case, just a description.
				'',
			)
		);
		
		do_action( 'woo_ishaarat_options_settings_field' );
		register_setting( 'woo_ishaarat_options', 'woo_ishaarat_options' );
	}
    
	public static function choose_default_country_selector()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$countries = new WC_Countries();
		ishaarat_input_fields( 'woo_ishaarat_options[default_country_selector]', array(
			'type'    => 'select',
			'options' => $countries->get_countries(),
		), $options['default_country_selector'] ?? 'EG' );
	}

	public static function display_consent_sms()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$checked = 1;
		if ( !isset( $options['sms_consent'] ) ) {
			$checked = 0;
		}
		ishaarat_input_fields( 'woo_ishaarat_options[sms_consent]', array(
			'type'        => 'checkbox',
			'label'       => __( 'Enable/Disable', WOO_ISHAARAT_PLUGIN_NAME ),
			'description' => __( '<br/>By enabling, customers can decide if they want to receive mobile notifications.', WOO_ISHAARAT_PLUGIN_NAME ),
		), $checked );
	}
	public static function display_consent_sms_content()
	{
		$options = get_option( 'woo_ishaarat_options' );

		ishaarat_input_fields( 'woo_ishaarat_options[wa_consent_text_to_display]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default text to display.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['wa_consent_text_to_display'] ?? __( 'I would receive order notifications and promotions on my Whatsapp.', WOO_ISHAARAT_PLUGIN_NAME),
		) );
	}

	/**
	 * Message to vendor.
	 */
	public static function messages_to_vendor()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$checked = 0;
		if ( !empty($options['sms_to_vendors']) ) {
			$checked = 1;
		}

		ishaarat_input_fields( 'woo_ishaarat_options[sms_to_vendors]', array(
			'type'        => 'checkbox',
			'label'       => __( 'Enable/Disable', WOO_ISHAARAT_PLUGIN_NAME ),
			'description' => __( '<br/>By enabling it, The vendor phone number will receive an automated message once a customer purchases products from his shop. (You must enable Dokan plugin)', WOO_ISHAARAT_PLUGIN_NAME ),
		), $checked );	}

	/**
	 * Display admin template messages fields.
	 */
	public static function display_shop_admin_template_messages()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[admin_message_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['admin_message_template'] ?? '',
		) );
	}

	public static function display_vendor_template_messages()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[vendor_message_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['vendor_message_template'] ?? '',
		) );
	}

	/**
	 * Display settings fields.
	 */
	public static function display_settings_fields()
	{
		do_action( 'woo_ishaarat_options_before_api_options_fields' );
		$display_settings = apply_filters( 'woo_ishaarat_display_api_options', true );

		if ( $display_settings ) {
			ob_start();
			?>
			<div class="wooishaarat-settings-panel ishaarat-center-panel-values" id="ishaarat-contents">
				<h3><?php
					esc_html_e( 'Configure message Gateways', WOO_ISHAARAT_PLUGIN_NAME );
					?></h3>
				<?php
				esc_html_e( 'Please provide API Credentials from your Ishaarat account.', WOO_ISHAARAT_PLUGIN_NAME );
				Woo_Ishaarat_UI_Fields::format_html_fields( '<br/>' );

				?>
				<div id="woo_ishaarat_api" class="wrap">
					<?php
					ishaarat_input_fields( 'woo_ishaarat_api_auth_key', array(
						'type'        => 'text',
						'label'       => '<strong>' . __( ' Auth Key: ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>',
						'input_class' => array( 'wooishaarat-text-customs-api' ),
						'placeholder' => 'AB1234567890',
						'required'    => true,
						'default'     => esc_attr( get_option( 'woo_ishaarat_api_auth_key' ) ),
						'description' => __( "You can retrieve it from your <a href='https://ishaarat.com/login' target='__blank'>Ishaarat Portal</a>.", WOO_ISHAARAT_PLUGIN_NAME ),
					) );
					Woo_Ishaarat_UI_Fields::format_html_fields( '<br/>' );
					ishaarat_input_fields( 'woo_ishaarat_api_app_key', array(
						'type'        => 'text',
						'label'       => '<strong>' . __( ' APP Key : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>',
						'input_class' => array( 'wooishaarat-text-customs-api' ),
						'required'    => true,
						'placeholder' => 'AB1234567890',
						'default'     => esc_attr( get_option( 'woo_ishaarat_api_app_key' ) ),
						'description' => __( "You can retrieve it from your <a href='https://ishaarat.com/login' target='__blank'>Ishaarat</a>. Note: Each app is linked to 1 whatspp number and defines from which number you will send your messages", WOO_ISHAARAT_PLUGIN_NAME ),
					) );
					Woo_Ishaarat_UI_Fields::format_html_fields( "You will need an Auth Key and App Key in order to use Ishaarat. If you already have an account you can retrieve\n\t\tthem from your account dashboard within the  <a href='https://ishaarat.com/login'>Portal</a>. If you have not signed up\n\t\tyet, sign up <a href='https://ishaarat/signup'>here</a>." );
					?>
				</div>
				<?php
				do_action( 'woo_ishaarat_options_before_saving_api_options_fields' );
				?>
			</div>
			<?php
		}

		$sms_output_html = ob_get_clean();
		// add filter for replace the view displaying api fields.
		$sms_output_html = apply_filters( 'woo_ishaarat_edit_gateways_fields_html', $sms_output_html );
		Woo_Ishaarat_UI_Fields::format_html_fields( $sms_output_html );
		?>
		<div id="woo_ishaarat_testing_sections" class="wrap">
			<?php
			submit_button(
				__( 'Save API Credentials', WOO_ISHAARAT_PLUGIN_NAME ),
				'primary',
				'',
				false,
				array(
					'id' => 'woo_ishaarat_saving',
				)
			);
			?>
		</div>
		<br/>
		<div class="wooishaarat-cl-loader" style="display: none;"></div>
		<div class="woo_ishaarat_modal_body"></div>
		<span class="woo_ishaarat_panels" id="woo_ishaarat_saving_status" style="display:none;"></span>
		<div id="woo_ishaarat_testing_sections" class="wrap">
			<h3><?php
				esc_html_e( 'Status', WOO_ISHAARAT_PLUGIN_NAME );
				?></h3>
			<?php
			esc_html_e( 'Send test messages to a number to find out if your API credentials are working properly.', WOO_ISHAARAT_PLUGIN_NAME );
			?>
			<br/>

			<br/>
			<?php
			ishaarat_input_fields( 'woo_ishaarat_testing_numbers', array(
				'required'    => true,
				'label'       => '<strong>' . __( 'Testing numbers : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>',
				'input_class' => array( 'woo-ishaarat-testing-numbers', 'wooishaarat-text-customs' ),
			) );
			ishaarat_input_fields( 'woo_ishaarat_testing_messages', array(
				'type'        => 'textarea',
				'required'    => true,
				'label'       => '<strong>' . __( 'Testing messages : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>',
				'input_class' => array( 'wooishaarat-textarea', 'woo-ishaarat-testing-messages' ),
				'placeholder' => __( 'Type your message here.', WOO_ISHAARAT_PLUGIN_NAME ),
			) );
			ishaarat_input_fields( 'woo_ishaarat_testing_status', array(
				'type'        => 'textarea',
				'required'    => true,
				'id'          => 'woo-ishaarat-response-status',
				'input_class' => array( 'wooishaarat-textarea', 'woo-ishaarat-response-status' ),
				'placeholder' => __( 'Type your message here.', WOO_ISHAARAT_PLUGIN_NAME ),
			) );
			submit_button(
				__( 'Send Test Msg', WOO_ISHAARAT_PLUGIN_NAME ),
				'primary',
				'',
				false,
				array(
					'id' => 'woo_ishaarat_testing',
				)
			);
			?>
		</div>
		<br/>
		<div class="wooishaarat-cl-status" style="display: none;"></div>

		<div class="wooishaarat-body-cl-status">
		</div>
		</div>
		<?php
	}

	/**
	 * Display checkbox for sending messages to admin.
	 */
	public static function messages_to_admin()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$checked = 0;
		if ( !empty($options['msg_to_admin']) ) {
			$checked = 1;
		}
		ishaarat_input_fields( 'woo_ishaarat_options[msg_to_admin]', array(
			'type'        => 'checkbox',
			'label'       => __( 'Enable/Disable', WOO_ISHAARAT_PLUGIN_NAME ),
			'description' => __( '<br/>By enabling it, the shop owner/manager phone number will receive an automated message once any purchase is made on his shop.', WOO_ISHAARAT_PLUGIN_NAME ),
		), $checked );
	}

	/**
	 * Setting pending payment orders status by sms.
	 */
	public static function messages_from_orders()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$checked = 0;
		if ( !empty($options['messages_from_orders']) ) {
			$checked = 1;
		}
		ishaarat_input_fields( 'woo_ishaarat_options[messages_from_orders]', array(
			'type'        => 'checkbox',
			'label'       => __( 'Enable/Disable', WOO_ISHAARAT_PLUGIN_NAME ),
			'description' => __( '<br/>By enabling it, you will be able to send a customized message from customer order details.', WOO_ISHAARAT_PLUGIN_NAME ),
		), $checked );
	}

	/**
	 * Display fields where admin put his phone numbers.
	 */
	public static function display_shop_admin_numbers()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$display_options = array(
			'type'        => 'text',
			'required'    => true,
			'input_class' => array( 'wooishaarat-text-customs' ),
			'placeholder' => '+1234567890',
		);
		ishaarat_input_fields( 'woo_ishaarat_options[admin_numbers]', $display_options, ( isset( $options['admin_numbers'] ) ? esc_attr( $options['admin_numbers'] ) : '' ) );
	}

	/**
	 * Function for setting who allows to send message after customer purchase.
	 */
	public static function after_customer_purchase()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$checked = 0;
		if ( !empty($options['message_after_customer_purchase']) ) {
			$checked = 1;
		}
		ishaarat_input_fields( 'woo_ishaarat_options[message_after_customer_purchase]', array(
			'type'        => 'checkbox',
			'label'       => __( 'Enable/Disable', WOO_ISHAARAT_PLUGIN_NAME ),
			'description' => __( '<br/>By enabling it, an automated message will be sent to the customer alongside the WooCommerce email.', WOO_ISHAARAT_PLUGIN_NAME ),
		), $checked );
	}

	/**
	 * Function for setting who allows to send message after order changed.
	 */
	public static function after_order_changed()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$checked = 0;
		if ( !empty($options['message_after_order_changed']) ) {
			$checked = 1;
		}
		ishaarat_input_fields( 'woo_ishaarat_options[message_after_order_changed]', array(
			'type'        => 'checkbox',
			'label'       => __( 'Enable/Disable', WOO_ISHAARAT_PLUGIN_NAME ),
			'description' => __( '<br/>By enabling it, an automatic message will be sent to the customer to inform him of the change of status of his order.', WOO_ISHAARAT_PLUGIN_NAME ),
		), $checked );
	}

	/**
	 * Display options tags.
	 */
	public static function display_options_tags( $is_vendor = false )
	{
		global  $ishaarat_helper ;
		Woo_Ishaarat_UI_Fields::format_html_fields( '<p> Use these tags to customize your message : </p>' );

		if ( !isset( $is_vendor['is_vendor'] ) ) {
			foreach ( $ishaarat_helper::get_list_of_tag_names() as $tag_names => $tag_desc ) {
				Woo_Ishaarat_UI_Fields::format_html_fields( '<strong style="background-color : #5ce1e6;">' . str_replace( '/', '', $tag_names ) . '</strong>' . $tag_desc . '<br/>' );
			}
		} else {
			Woo_Ishaarat_UI_Fields::format_html_fields( '
                <strong style="background-color : #5ce1e6;">%vendor_name%</strong> : Vendor Name <br/> 
                <strong style="background-color : #5ce1e6;">%vendor_products_names%</strong> : Vendor Product Name<br/> 
                <strong style="background-color : #5ce1e6;">%vendor_product_link%</strong> : Vendor Product Link<br/> 
                <strong style="background-color : #5ce1e6;">%vendor_order_id%</strong> : Vendor Order ID<br/> 
                <strong style="background-color : #5ce1e6;">%vendor_order_link%</strong> : Vendor Order Link<br/> 
                
                You can still use, the normal tags listed below for sending message to the vendors too.
                ' );
		}

	}

	/**
	 * Display the description for settings tab pages.
	 */
	public static function description_for_the_tab_pages()
	{
		esc_html_e( 'You can configure options you want to use into this plugin here.', WOO_ISHAARAT_PLUGIN_NAME );
		if ( !class_exists( 'WooCommerce' ) ) {
			Woo_Ishaarat_UI_Fields::format_html_fields( '<br/><br/><strong>This options works best with WooCommerce, it is needed in order to use the plugin.</strong>', WOO_ISHAARAT_PLUGIN_NAME );
		}
	}

	/**
	 * Display a field for set the messages for changement of order status.
	 */
	public static function sms_when_completed()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[completed_order_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['completed_order_template'] ?? '',
		) );
	}

	/**
	 * Display a field for set the messages for changement of order status.
	 */
	public static function sms_when_processing()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[processing_order_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['processing_order_template'] ?? '',
		) );
	}

	/**
	 * Display a field for set the messages for changement of order status.
	 */
	public static function sms_when_cancelled()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[cancelled_order_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['cancelled_order_template'] ?? '',
		) );
	}

	/**
	 * Display a field for set the messages for changement of order status.
	 */
	public static function sms_when_on_hold()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[on_hold_order_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['on_hold_order_template'] ?? '',
		) );
	}

	/**
	 * Display a field for set the messages for changement of order status.
	 */
	public static function sms_when_pending_payment()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[pending_payment_order_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['pending_payment_order_template'] ?? '',
		) );
	}

	/**
	 * Display a field for set the messages for changement of order status.
	 */
	public static function sms_when_failed()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[failed_order_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['failed_order_template'] ?? '',
		) );
	}

	/**
	 * Display a field for set the messages for changement of order status.
	 */
	public static function sms_when_refunded()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[refunded_order_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['refunded_order_template'] ?? '',
		) );
	}

	/**
	 * Message who is sent to user when his orders is in pending payment status.
	 */
	public static function default_sms_messages()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( ' woo_ishaarat_options[success_order_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'woo_ishaarat_messages_to_send', 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['success_order_template'] ?? '',
		) );
	}
	/**
	 * This allows to send message from the dashboard.
	 *
	 * @return void
	 */
	public static function send_msg()
	{
		?>
		<div>
			<h3><?php
				Woo_Ishaarat_UI_Fields::format_html_fields( 'Send a Quick Msg' );
				?></h3>
			<br/>
			<?php

			if ( isset( $_GET['page'] ) && WOO_ISHAARAT_PLUGIN_NAME . '-send-sms' === $_GET['page'] ) {
				?>
				<span><?php
					echo  esc_html__( 'Send a Quick message to a relative, family, customer in less than a second from your WordPress dashboard.', WOO_ISHAARAT_PLUGIN_NAME ) ;
					?></span>
				<?php
			}

			?>
			<br/>
			<br/>
		</div>
		<div id="sms-block">
			<?php
			$msg_options_list = apply_filters( 'woo_ishaarat_qs_selection_mode', array(
				'use-phone-number'         => __( 'Using Phone Number', WOO_ISHAARAT_PLUGIN_NAME ),
				'use-contact-list' =>   __( 'Using Customer List', WOO_ISHAARAT_PLUGIN_NAME ),
			) );
			?>
			<?php

			ishaarat_input_fields( 'woo_ishaarat_qs_pn', array(
				'type'        => 'radio',
				'required'    => true,
				'label'       => '<strong>' . __( 'Recipient Selection Mode : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>',
				'input_class' => array( 'wooishaarat-textarea', 'woo-ishaarat-testing-messages' ),
				'options'     => $msg_options_list,
				'default'     => 'use-phone-number',
			) );
			?>
			<br/>
			<br/>

			<div class="woo-ishaarat-use-phone-number woo-ishaarat-qs-class" >
				<?php
				ishaarat_input_fields( 'woo_ishaarat_testing_numbers', array(
					'required'    => true,
					'label'       => '<strong>' . __( 'Enter Phone Number : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>',
					'input_class' => array( 'woo-ishaarat-testing-numbers', 'wooishaarat-text-customs' ),
				) );
				?>
			</div>
			<div class="woo-ishaarat-use-contact-list  woo-ishaarat-qs-class" style='display:none;'>
				<?php
                //add csv file uploader
                $query = new WP_Query(array(
                    'post_type' => 'ishaarat_cl',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                ));
                $posts = $query->get_posts();
                $cls = [];
                foreach ($posts as $post) {
                    $cls[$post->ID] = $post->post_title;
                }
                ishaarat_input_fields( 'woo_ishaarat_qs_cl', array(
                    'type'        => 'select',
                    'required'    => true,
                    'label'       => '<strong>' . __( 'Contact List to use : ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>',
                    'input_class' => array( 'wooishaarat-textarea', 'woo-ishaarat-testing-messages' ),
                    'options'     => $cls,
                    'default'     => '',
                ) );
				?>
			</div>
			<br/>
			<br/>
			<?php
			ishaarat_input_fields( 'woo_ishaarat_testing_messages', array(
				'type'        => 'textarea',
				'required'    => true,
				'label'       => '<strong>' . __( 'Message to send: ', WOO_ISHAARAT_PLUGIN_NAME ) . '</strong>',
				'input_class' => array( 'wooishaarat-textarea', 'woo-ishaarat-testing-messages' ),
				'placeholder' => __( 'Type your message here.', WOO_ISHAARAT_PLUGIN_NAME ),
			) );
			ishaarat_input_fields( 'woo_ishaarat_testing_status', array(
				'type'        => 'textarea',
				'required'    => true,
				'id'          => 'woo-ishaarat-response-status',
				'input_class' => array( 'wooishaarat-textarea', 'woo-ishaarat-response-status' ),
				'placeholder' => __( 'Type your message here.', WOO_ISHAARAT_PLUGIN_NAME ),
			) );

			if ( isset( $_GET['page'] ) && WOO_ISHAARAT_PLUGIN_NAME . '-send-sms' === $_GET['page'] ) {
				$sms_message_text = __( 'Try message Sending', WOO_ISHAARAT_PLUGIN_NAME );
			} else {
				$sms_message_text = __( 'Send Test SMS', WOO_ISHAARAT_PLUGIN_NAME );
			}

			submit_button(
				$sms_message_text,
				'primary',
				'',
				false,
				array(
					'id' => 'woo_ishaarat_testing',
				)
			);
			?>
		</div>
		<br/>
		<div class="wooishaarat-cl-status" style="display: none;"></div>

		<div class="wooishaarat-body-cl-status">
		</div>
		</div>
		<?php
	}

	public static function after_customer_sign()
	{
		$options = get_option( 'woo_ishaarat_options' );
		$checked = 0;
		if ( !empty($options['messages_after_customer_signup']) ) {
			$checked = 1;
		}
		ishaarat_input_fields( 'woo_ishaarat_options[messages_after_customer_signup]', array(
			'type'        => 'checkbox',
			'label'       => __( 'Enable/Disable', WOO_ISHAARAT_PLUGIN_NAME ),
			'description' => __( '<br/>By enabling it, an automated message will be sent to the new customer.', WOO_ISHAARAT_PLUGIN_NAME ),
		), $checked );
	}

	public static function default_signup_message()
	{
		$options = get_option( 'woo_ishaarat_options' );
		ishaarat_input_fields( 'woo_ishaarat_options[customer_signup_template]', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'wooishaarat-textarea' ),
			'placeholder' => __( 'Please put the default message to send.', WOO_ISHAARAT_PLUGIN_NAME ),
			'default'     => $options['customer_signup_template'] ?? '',
		) );
	}

	public static function display_customer_signup_tags()
	{
		Woo_Ishaarat_UI_Fields::format_html_fields( '<p> Use these tags to customize your message : </p>' );
		Woo_Ishaarat_UI_Fields::format_html_fields( '<strong style="background-color : #5ce1e6;">%store_name%</strong> : Store Name <br/> <strong style="background-color : #5ce1e6;">%customer_name%</strong> : Customer Name  <br/> <strong style="background-color : #5ce1e6;">%customer_phone_number%</strong> : Customer Phone Number <br/>' );
	}

	/**
	 * Display metabox for sending message from the orders.
	 */
	public static function message_from_orders_metabox()
	{
		$options = get_option( 'woo_ishaarat_options' );
		if ( isset( $options['messages_from_orders'] ) && 1 == $options['messages_from_orders'] ) {
			add_meta_box(
				'woo_ishaarat_send_messages',
				__( 'Send SMS', WOO_ISHAARAT_PLUGIN_NAME ),
				__CLASS__ . '::message_box_for_orders',
				'shop_order',
				'side',
				'high'
			);
		}
	}

	/**
	 * Display a message box who allows shop owner/manager to send SMS
	 * directly from customer orders.
	 *
	 * @param object $order_id WooCommerce Order ID.
	 */
	public static function message_box_for_orders( $order_id )
	{
		$order = new WC_Order( $order_id );
		$id = $order->get_id();
		$order_status = $order->get_status();
		ishaarat_input_fields( 'woo_ishaarat_messages_to_send', array(
			'type'        => 'textarea',
			'required'    => true,
			'input_class' => array( 'woo_ishaarat_messages_to_send', 'wooishaarat-textarea' ),
			'placeholder' => __( 'Type your message here.', WOO_ISHAARAT_PLUGIN_NAME ),
			'maxlength'   => 160,
		) );
		?>
		<input type="submit" name="woo_ishaarat_sms_submit" id="woo_ishaarat_sms_submit" class="button button-primary" value="<?php
		esc_html_e( 'Send', WOO_ISHAARAT_PLUGIN_NAME );
		?>" style="width:80px; word-wrap: break-word;">
		<br/>
		<br/>
		<textarea id="phone_number" class="wooishaarat-textarea" maxlength='160' order_id='<?php
		echo  esc_attr( $id ) ;
		?>' order_status='<?php
		echo  esc_attr( $order_status ) ;
		?>' rows="5" style="display : none; height:83px; width : 254px;" readonly></textarea>
		<br/>
		<div class="wooishaarat-cl-loader" style="display: none;"></div>
		<?php
	}
}