(function ($) {
  "use strict";
  $(document).ready(function () {
    var woo_ishaarat_btn_testing = $("input#woo_ishaarat_testing");
    var woo_ishaarat_messages_fields = $("#woo_ishaarat_messages_to_send");
    var woo_ishaarat_submit_sms = $("#woo_ishaarat_sms_submit");
    var woo_ishaarat_load_defaults_message = $(
      "input#woo_ishaarat_load_default_messages"
    );
    var woo_ishaarat_phone_numbers = $("textarea#phone_number");
    var woo_ishaarat_order_status = woo_ishaarat_phone_numbers.attr("order_status");
    var woo_ishaarat_ajax_loading = $("div.wooishaarat-cl-loader");
    var woo_ishaarat_order_id = woo_ishaarat_phone_numbers.attr("order_id");
    var woo_ishaarat_return_modal = $("div.woo_ishaarat_modal_body");
    var woo_ishaarat_return_modal_status = $("div.wooishaarat-body-cl-status");
    var woo_ishaarat_btn_saving_creds = $("input#woo_ishaarat_saving");
    var woo_ishaarat_modal = $("div.wooishaarat-cl-loader");
    var woo_ishaarat_modal_status = $("div.wooishaarat-cl-status");
   

    var wooishaarat_phone_number_validator = document.querySelector("#woo_ishaarat_testing_numbers");  
    try{
      var iti =  window.intlTelInput(wooishaarat_phone_number_validator,{
        initialCountry: "eg",
        utilsScript : woo_ishaarat_ajax_object.woo_ishaarat_phone_utils_path
      });
    }  catch(e){
      //console.info(e);
    }

    $('div.woo-ishaarat-qs-class.woo-ishaarat-use-phone-number' ).show();

    // count numbers of characters
    $(".wooishaarat-textarea").on("keyup", function () {
      $("span.wooishaarat-textcount").empty();
      var limit = $(this).empty().val().length;
      $(
        '<strong><span class="wooishaarat-textcount" style="color : red;">' +
          limit +
          " characters typed </span></strong>"
      ).insertAfter($(this));
    });

    // submit sms from orders
    woo_ishaarat_submit_sms.on("click", function (e) {
      e.preventDefault();
      var woo_ishaarat_messages_to_send = $(
        "#woo_ishaarat_messages_to_send.input-text "
      ).val();
      var woo_ishaarat_phone_numbers = $("#woo_ishaarat_phone_numbers").val();
      var data = {
        "messages-to-send": woo_ishaarat_messages_to_send,
        "phone-number": woo_ishaarat_phone_numbers,
        "order-id": woo_ishaarat_order_id,
        "order-status": woo_ishaarat_order_status,
      };
      woo_ishaarat_ajax_loading.show();
      $.post(
        woo_ishaarat_ajax_object.woo_ishaarat_ajax_url,
        {
          action: "woo_ishaarat_send-messages-manually-from-orders",
          data: data,
          security: woo_ishaarat_ajax_object.woo_ishaarat_ajax_security,
        },
        function (response) {
          woo_ishaarat_ajax_loading.hide();
          $("textarea#phone_number").show().append(response);
        }
      );
      $("textarea#phone_number").hide().empty();
    });

    // test sms sending from general settings
    woo_ishaarat_btn_testing.on("click submit", function (e) {
      e.preventDefault();

      var woo_ishaarat_testing_messages = $("textarea#woo_ishaarat_testing_messages").val();

      var recipient_selection_mode = $('input[name="woo_ishaarat_qs_pn"]:checked').val();

      if ( undefined == recipient_selection_mode ) {
        recipient_selection_mode = "use-phone-number";
      }
    
      // this code runs if you're trying to send custom sms.
      if ( 'use-phone-number' == recipient_selection_mode ) {
        var isValid = iti.isValidNumber();
        if ( !isValid ){
          woo_ishaarat_return_modal_status
          .show().empty()
          .append("<strong>The phone number is not valid.</strong>");
          return;
        }
        var countryData = iti.getSelectedCountryData();
        countryData = countryData.dialCode;

        var woo_ishaarat_testing_numbers = $(".woo-ishaarat-testing-numbers").val();
        var data = {
          "testing-numbers": woo_ishaarat_testing_numbers,
          "testing-messages": woo_ishaarat_testing_messages,
          'country_code' : countryData,
        };
        woo_ishaarat_modal_status.show();
        woo_ishaarat_return_modal_status.empty();
        $.post(
          woo_ishaarat_ajax_object.woo_ishaarat_ajax_url,
          {
            action: "woo_ishaarat-get-api-response-code",
            data: data,
            security: woo_ishaarat_ajax_object.woo_ishaarat_ajax_security,
          },
          function (response) {
            woo_ishaarat_modal_status.hide();
            woo_ishaarat_return_modal_status
              .show()
              .append("<strong>" + response + "</strong>");
          }
        );

      } else if ( 'use-contact-list' == recipient_selection_mode ) {
        var data = {
          "contact-list": $('select#woo_ishaarat_qs_cl').val(),
          "testing-messages": woo_ishaarat_testing_messages,
        };
        woo_ishaarat_modal_status.show();
        woo_ishaarat_return_modal_status.empty();
        $.post(
          woo_ishaarat_ajax_object.woo_ishaarat_ajax_url,
          {
            action: "woo_ishaarat-send-sms-to-contacts",
            data: data,
            security: woo_ishaarat_ajax_object.woo_ishaarat_ajax_security,
          },
          function (response) {
            woo_ishaarat_modal_status.hide();
            woo_ishaarat_return_modal_status
              .show()
              .append("<strong>" + response + "</strong>");
          }
        );
      }

   
    });

    woo_ishaarat_load_defaults_message.on("click submit", function (e) {
      e.preventDefault();
      woo_ishaarat_ajax_loading.show();
      $.post(
        woo_ishaarat_ajax_object.woo_ishaarat_ajax_url,
        {
          action: "get-orders-defaults-messages",
          security: woo_ishaarat_ajax_object.woo_ishaarat_ajax_security,
        },
        function (response) {
          woo_ishaarat_ajax_loading.hide();
          woo_ishaarat_messages_fields.show().append(response);
        }
      );
      woo_ishaarat_messages_fields.empty().hide();
    });

    //Saving the SMS API Key to the db.
    woo_ishaarat_btn_saving_creds.on("click submit", function (e) {
      e.preventDefault();
      var data = {};
      data.auth_key = $('input#woo_ishaarat_api_auth_key').val();
      data.app_key = $('input#woo_ishaarat_api_app_key').val();
      data = wp.hooks.applyFilters( 'woo_ishaarat_save_gateways_data',  data );
      woo_ishaarat_return_modal.empty().hide();
      woo_ishaarat_modal.show();
      $.post(
        woo_ishaarat_ajax_object.woo_ishaarat_ajax_url,
        {
          action: "woo_ishaarat_save-api-credentials",
          data: data,
          security: woo_ishaarat_ajax_object.woo_ishaarat_ajax_security,
        },
        function (response) {
          woo_ishaarat_modal.hide();
          var json_decode = JSON.parse(response);
          if (json_decode.status === 1) {
            response =
              "Congratulations the credentials have been saved.";
          } else {
            response =
              "Unfortunately your operation is not successfully.Please fill fields and try again! ";
          }
          woo_ishaarat_return_modal
            .show()
            .append("<strong>" + response + "</strong>");
        }
      );
    });
    //display settings updated
    var woo_ishaarat_display_settings = function () {
      hs_toggle_display(
        'input[name="woo_ishaarat_options[message_after_customer_purchase]"]',
        "tr.woo-ishaarat-defaults-messages"
      );
      hs_toggle_display(
        'input[name="woo_ishaarat_options[message_after_order_changed]"]',
        "tr.woo-ishaarat-completed-messages"
      );
      hs_toggle_display(
        'input[name="woo_ishaarat_options[message_after_order_changed]"]',
        "tr.woo-ishaarat-completed-messages"
      );
      hs_toggle_display(
        'input[name="woo_ishaarat_options[msg_to_admin]"]',
        "tr.woo-ishaarat-admin-completed-messages"
      );
      hs_toggle_display(
        'input[name="woo_ishaarat_options[sms_to_vendors]"]',
        "tr.woo-ishaarat-vendor-completed-messages"
      );
      hs_toggle_display(
        'input[name="woo_ishaarat_options[sms_consent]"]',
        "tr.woo-ishaarat-customer-consent"
      );
      hs_toggle_display(
        'input[name="woo_ishaarat_options[messages_after_customer_signup]"]',
        "tr.woo-ishaarat-signup-defaults-messages"
      );
      hs_toggle_display(
        'input[name="woo_ishaarat_options[failed_emails_notifications]"]',
        "tr.woo-ishaarat-admin-failed-emails"
      );
    };


    // show/hide fields from the settings page.
    woo_ishaarat_display_settings();
    $("body").on("change", function () {
      woo_ishaarat_display_settings();
    }); 
    $('div#wpfooter').hide();

    $('select#woo_ishaarat_qs_cl').select2();

   
    $('input[name="woo_ishaarat_qs_pn"]').on('change', function(){
      var recipient_selection_mode = $(this).val();
      $('div.woo-ishaarat-qs-class').hide();
      $('div.woo-ishaarat-qs-class.woo-ishaarat-'+recipient_selection_mode ).show();
    });

    $("select[name='woo_ishaarat_options[default_country_selector]']").select2();
  });
})(jQuery);
