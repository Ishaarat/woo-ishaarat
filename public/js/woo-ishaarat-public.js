(function( $ ) {
	'use strict';

	/**
	 * This init the phone validator on the checkout page.
	 *
	 * @param country_code the country code that will be used for the phone number field.
	 */
	function woo_ishaarat_init_pn_validator( country_code ) {
		var iti;
		var wooishaarat_phone_number_validator = document.querySelector( "#billing_phone" );
		var wc_allowed_countries	      = woo_ishaarat_ajax_object.wc_allowed_countries;
		
		try {
			iti = window.intlTelInput(
				wooishaarat_phone_number_validator,
				{
					initialCountry: country_code,
					utilsScript : woo_ishaarat_ajax_object.woo_ishaarat_phone_utils_path,
					onlyCountries: wc_allowed_countries
				}
			);

			wooishaarat_phone_number_validator.addEventListener("countrychange", function() {
				woo_ishaarat_check_pn_validity( iti );
			});
		} catch (e) {
			console.info( e );
		}
		return iti;
	}

	function woo_ishaarat_check_pn_validity( iti ){
		var isValid  = iti.isValidNumber();
		var selector = $( 'input#wooishaarat_pn_valid' );
		if ( ! isValid ) {
			$('p#billing_phone_field').removeClass('woocommerce-validated')
			$('p#billing_phone_field').addClass('woocommerce-invalid-phone')
			$('p#billing_phone_field').addClass('woocommerce-invalid')
			selector.val('no')
		} else {
			$('p#billing_phone_field').removeClass('woocommerce-invalid-phone')
			$('p#billing_phone_field').addClass('woocommerce-validated')
			selector.val('yes')
		}
	}
	$( document ).ready(
		function(){
			if ( woo_ishaarat_ajax_object.woo_ishaarat_phone_utils_path ) {

				var country_code = 'us';
				if ( woo_ishaarat_ajax_object.user_country_code ) {
					country_code = woo_ishaarat_ajax_object.user_country_code;
				}
				var iti_pn;
				
				$( document.body ).on(
					'change',
					'#billing_country',
					function() {
						iti_pn = woo_ishaarat_init_pn_validator( $( this ).val() );
					}
				);

				$( document.body ).on(
					'change keydown',
					'#billing_phone',
					function() {
						woo_ishaarat_check_pn_validity( iti_pn );
					}
				);
				iti_pn = woo_ishaarat_init_pn_validator( country_code );

				$(document).on('click dbclick', function(){
					$( "#billing_country" ).trigger( 'change' );
					$( "#billing_phone" ).trigger( 'change' );
				});
				
			}
		}
	);

})( jQuery );
