(function ($) {
    'use strict';



    /**
     * This function generate random string who is used by the plugin.
     * @param length
     * @returns {string}
     * @constructor
     */

    var hs_generate_html_operators = function () {
        var html ;
        for (var option_name in woo_ishaarat_ajax_object.woo_ishaarat_cl_operators_names['woo-ishaarat-operators']) {
            html += "<option class='woo-ishaarat-operators' value='" + option_name + "'>" + woo_ishaarat_ajax_object.woo_ishaarat_cl_operators_names['woo-ishaarat-operators'][option_name] + "</option>";
        }
        return html;
    };

    var hs_generate_guest_customers_select_operators = function() {
        var html = "<select name='customer-consent'><option class='woo-ishaarat-operators' value='guest-customers'>Guest Customer</option></select>"
        return html;
    }

    var hs_generate_consent_select_operators = function() {
        var html = "<select name='customer-consent'><option class='woo-ishaarat-operators' value='accepted'>ACCEPTED</option></select>"
        return html;
    }

    var hs_generate_consent_html_operators = function() {
        var html;
        for (var option_name in woo_ishaarat_ajax_object.woo_ishaarat_cl_operators_names['woo-ishaarat-consent-operators']) {
            html += "<option class='woo-ishaarat-consent-operators' value='" + option_name + "'>" + woo_ishaarat_ajax_object.woo_ishaarat_cl_operators_names['woo-ishaarat-consent-operators'][option_name] + "</option>";
        }
        return html;
    }
 

    var hs_hide_show_fields = function ( cl_type_mode ){
        var ishaarat_add_btn = $('input#wooishaarat_add_custom_filters');
        if ( cl_type_mode == "dynamic" ){
            $('tr.woo-ishaarat-customer-list-dynamic').show();
            $('tr.woo-ishaarat-customer-list-manual').hide();
            $('tr.woo-ishaarat-from-file').hide();
            ishaarat_add_btn.show();
            $('#wooishaarat_search').attr('disabled',false);
        }else if (  cl_type_mode == "by-id"  ){
            $('tr.woo-ishaarat-customer-list-dynamic').hide();
            $('tr.woo-ishaarat-customer-list-manual').show();
            $('tr.woo-ishaarat-from-file').hide();
            ishaarat_add_btn.hide();
            $('#wooishaarat_search').attr('disabled',false);
        }else if( cl_type_mode == "from-csv-file"){
            $('tr.woo-ishaarat-customer-list-dynamic').hide();
            $('tr.woo-ishaarat-customer-list-manual').hide();
            ishaarat_add_btn.hide();
            $('tr.woo-ishaarat-from-file').show();
            $('#wooishaarat_search').attr('disabled',false);
        }

    }

    var hs_generate_html_math_operators = function () {
        var html ;
        for (var option_name in woo_ishaarat_ajax_object.woo_ishaarat_cl_operators_names['woo-ishaarat-math-operators']) {
            html += "<option class='woo-ishaarat-math-operators' value='" + option_name + "'>" + woo_ishaarat_ajax_object.woo_ishaarat_cl_operators_names['woo-ishaarat-math-operators'][option_name] + "</option>";
        }
        return html;
    };

    var hs_generate_html = function (options) {
        var html ;
        for (var option_name in options) {
            html += "<option class='woo-ishaarat-math-operators' value='" + option_name + "'>" + options[option_name] + "</option>";
        }
        return html;
    };

    var hs_generate_fields = function (hash_code = HSGenerateRandom(5)) {
        var html = "<p data-hash='" + hash_code + "' class='woo-ishaarat-cl-parent'><select class='woo-ishaarat-cl-rules' name='woo-ishaarat-cl[" + hash_code + "][cl-rules]' >";
        for (var option_name in woo_ishaarat_ajax_object.woo_ishaarat_cl_rules_names) {
            html += "<option value='" + option_name + "'>" + woo_ishaarat_ajax_object.woo_ishaarat_cl_rules_names[option_name] + "</option>";
        }
        html += "</select>&nbsp;&nbsp;&nbsp; <select class='woo-ishaarat-cl-options' name='woo-ishaarat-cl[" + hash_code + "][cl-options]'>";
        html += hs_generate_html_operators();
        html += "</select>&nbsp;&nbsp;&nbsp; <span class='woo-ishaarat-cl-values'><select  multiple='multiple' name='woo-ishaarat-cl[" + hash_code + "][cl-values][]'>" + hs_generate_html(woo_ishaarat_ajax_object.woo_ishaarat_get_payment_methods) + "</select></span> <span class='woo-ishaarat-cl-remove-block'><button class='button button-primary woo-ishaarat-cl-remove-block' >Remove</button> </span></p>";
        return html;
    };

    var hs_regenerate_html = function( hashcode, values ){
        $('#wooishaarat-custom-fields-block').append(hs_generate_fields(hashcode));
        $('p[data-hash='+hashcode+'] select.woo-ishaarat-cl-rules').val(values['cl-rules']);
        woo_ishaarat_reset_fields(hashcode, values);
        $('select[name="woo-ishaarat-cl['+hashcode+'][cl-options]"]').val(values['cl-options']);
        $('p[data-hash='+hashcode+'] select[name="woo-ishaarat-cl['+hashcode+'][cl-values][]"]').val(values['cl-values']);
        $('p[data-hash='+hashcode+'] input[name="woo-ishaarat-cl['+hashcode+'][cl-values]"]').val(values['cl-values']);
    };


    var hs_initiate_dynamic_select_fields = function( parent_selector, child_selector ){
        $(child_selector).each(function(index, value){
            if ( index == 0 ){
                var value_name = $(value).val();
                $(parent_selector).select2();
                $(parent_selector).select2('val',value_name);
            }
        });
    }

    /**
     * This function generate the field needed dynamically.
     * 
     * @param string option_name Option fields key.
     * @param string hash_code Option fields value.
     */
    var hs_field_dynamic_views = function (option_name, hash_code) {
        var woo_ishaarat_field_options = $("p[data-hash='" + hash_code + "'] select.woo-ishaarat-cl-options");
        var woo_ishaarat_field_values  = $("p[data-hash='" + hash_code + "'] span.woo-ishaarat-cl-values");
        switch (option_name) {
            //case 'order-products-count':
            case '_order_shipping_tax':
            case '_order_shipping':
            case '_order_tax':
            case '_order_total':
                woo_ishaarat_field_options.empty().append(hs_generate_html_math_operators());
                woo_ishaarat_field_values.empty().attr('name', 'filter-by-amount').append('<input type="number" name="woo-ishaarat-cl[' + hash_code + '][cl-values]"  required/>');
                break;

            case '_payment_method':
                woo_ishaarat_field_options.empty().append(hs_generate_html_operators());
                woo_ishaarat_field_values.empty().attr('name', 'payment-methods').append('<select  multiple="multiple" name="woo-ishaarat-cl[' + hash_code + '][cl-values][]">' + hs_generate_html(woo_ishaarat_ajax_object.woo_ishaarat_get_payment_methods) + '</select>');
                break;

            case '_shipping_method':
                woo_ishaarat_field_options.empty().append(hs_generate_html_operators());
                woo_ishaarat_field_values.empty().attr('name', 'shipping-methods').append('<select multiple="multiple" name="woo-ishaarat-cl[' + hash_code + '][cl-values][]">' + hs_generate_html(woo_ishaarat_ajax_object.woo_ishaarat_get_shipping_methods) + '</select>');
                break;

            case '_billing_country':
            case '_shipping_country':
                woo_ishaarat_field_options.empty().append(hs_generate_html_operators());
                woo_ishaarat_field_values.empty().attr('name', 'filter-by-country').append('<select multiple="multiple" name="woo-ishaarat-cl[' + hash_code + '][cl-values][]">' + hs_generate_html(woo_ishaarat_ajax_object.woo_ishaarat_country) + '</select>');
                break;

            case 'shop_order':
                woo_ishaarat_field_options.empty().append(hs_generate_html_operators());
                woo_ishaarat_field_values.empty().attr('name', 'order-status').append('<select multiple="multiple" name="woo-ishaarat-cl[' + hash_code + '][cl-values][]">' + hs_generate_html(woo_ishaarat_ajax_object.woo_ishaarat_customer_order_status) + '</select>');
                break;

            // case 'customer-roles':
            //     $("p[data-hash='" + hash_code + "'] select.woo-ishaarat-cl-options").empty().append(hs_generate_html_operators());
            //     $("p[data-hash='" + hash_code + "'] span.woo-ishaarat-cl-values").empty().attr('name', 'customer-roles').append('<select multiple="multiple" name="woo-ishaarat-cl[' + hash_code + '][cl-values][]">' + hs_generate_html(woo_ishaarat_ajax_object.woo_ishaarat_customer_roles) + '</select>');
            //     break;

            case '_billing_email':
                woo_ishaarat_field_options.empty().append(hs_generate_html_operators());
                woo_ishaarat_field_values.empty().attr('name', 'customer-email').append('<input type="text" name="woo-ishaarat-cl[' + hash_code + '][cl-values]"  required/>');
                break;

            case '_completed_date':
            case '_paid_date':
                woo_ishaarat_field_options.empty().append(hs_generate_html_operators());
                var date_field = woo_ishaarat_field_values.empty().attr('name', 'customer-date').append('<input type="text" name="woo-ishaarat-cl[' + hash_code + '][cl-values]"  required/>');
                var ch_field   = date_field.children('input'); 

                if ( ch_field ) {
                    $(ch_field).datepicker({
                        changeMonth: true,
                        changeYear: true,
                        defaultDate: '',
                        dateFormat: 'yy-mm-dd',
                        numberOfMonths: 1,
                        minDate: '-20Y',
                        maxDate: '+1D',
                        showButtonPanel: true,
                        showOn: 'focus',
                        buttonImageOnly: true
                    });
                }
                break;

            case '_customer_mobile_marketing':
            case '_guest_customer_mobile_marketing':
                woo_ishaarat_field_options.empty().append(hs_generate_consent_html_operators());
                woo_ishaarat_field_values.empty().attr('name', 'customer-consent').append(hs_generate_consent_select_operators())
                break;

            case '_customer_role':
                woo_ishaarat_field_options.empty().append(hs_generate_consent_html_operators());
                woo_ishaarat_field_values.empty().attr('name', 'customer-consent').append(hs_generate_guest_customers_select_operators())

            default:
                break;
        }
    };


    var woo_ishaarat_reset_fields = function (hash_code) {
        hs_field_dynamic_views($("p[data-hash='" + hash_code + "'] select.woo-ishaarat-cl-rules").val(), hash_code);
        $(document).on('change', 'p[data-hash="' + hash_code + '"] select.woo-ishaarat-cl-rules', function (evt) {
            var option_name = $(this).val();
            hs_field_dynamic_views(option_name, hash_code);
           // hs_initiate_dynamic_select_fields( 'span.woo-ishaarat-cl-values select[name="woo-ishaarat-cl['+hash_code+'][cl-values][]"]', 'span.woo-ishaarat-cl-values select[name="woo-ishaarat-cl['+hash_code+'][cl-values][]"] option');
        });
    };

    $(document).on('click dbclick', '#wooishaarat_add_custom_filters', function (e) {
        e.preventDefault();
        var hash_code = HSGenerateRandom(12);
        $('#wooishaarat-custom-fields-block').append(hs_generate_fields(hash_code));
        woo_ishaarat_reset_fields(hash_code);
    });

    $(document).on('click dbclick', 'button.woo-ishaarat-cl-remove-block', function (e) {
        e.preventDefault();
        $(this).closest('p.woo-ishaarat-cl-parent').remove();
        while ( $('p#wooishaarat-custom-fields-block').is(':empty') ){
            $('#wooishaarat_add_custom_filters').trigger('click');
            //hs_initiate_dynamic_select_fields( 'span.woo-ishaarat-cl-values select', 'span.woo-ishaarat-cl-values select option' );
        }
    });

    $(document).on('click dbclick', '#wooishaarat_search', function (evt) {
        evt.preventDefault();
        var woo_ishaarat_cl_obj = $('form').serializeJSON();
        var woo_ishaarat_cl_list = woo_ishaarat_cl_obj['woo-ishaarat-cl'];

        if ( woo_ishaarat_cl_list['customer-list-search-type'] == "from-csv-file" ){
            woo_ishaarat_cl_list = {
                    attachment_id : $('a.woo-ishaarat-add-file-csv').data("attachmentId"),
                    "customer-list-search-type" : "from-csv-file"
            }
        }
        $('div.wooishaarat-cl-loader').show();
        $('div.wooishaarat-search-list').empty().hide();
        $.post(woo_ishaarat_ajax_object.woo_ishaarat_ajax_url, {
            action: 'woo-ishaarat-get-customers-list',
            data: woo_ishaarat_cl_list,
            'security': woo_ishaarat_ajax_object.woo_ishaarat_ajax_security
        }, function (response) {
            $('div.wooishaarat-search-list').empty().show().append(response);
            $('div.wooishaarat-cl-loader').hide();
        });
    });

    $(document).on('ready', function() {

        if ( typeof(woo_ishaarat_cl_type) === 'undefined' ){
            return;
        }

        if (woo_ishaarat_ajax_object.cl_list_data) {
            //if this code is executed, that means we are on customer list page.
            setTimeout(function () {
                $.blockUI({'message': woo_ishaarat_ajax_object.cl_list_data.loader_message});
                if ( woo_ishaarat_ajax_object.cl_list_data.length == 0 ){
                    $('#wooishaarat_add_custom_filters').trigger('click');
                }else{
                    for (var hash in woo_ishaarat_ajax_object.cl_list_data) {
                        hs_regenerate_html(hash, woo_ishaarat_ajax_object.cl_list_data[hash]);
                    }        
                }
                $.unblockUI();
            }, 1000);
        } else {
            //if this code is executed, that means it's a new customer list.
            $('#wooishaarat_add_custom_filters').trigger('click');
        }

        hs_hide_show_fields( woo_ishaarat_cl_type );
        if ( woo_ishaarat_csv_data ){
            var media_attachment_id = woo_ishaarat_csv_data['csv-attachment-id'];
            var media_attachment_url = woo_ishaarat_csv_data['csv-attachment-url'];
            woo_ishaarat_display_csv_attach_files( media_attachment_url, media_attachment_id );
        }


        $(document).on('change click dbclick', 'input[name="woo-ishaarat-cl[customer-list-search-type]"]', function (){
            var ishaarat_type = $(this).val();
            hs_hide_show_fields( ishaarat_type );
        });

        $('select.woo-ishaarat-exclude-phone-numbers').select2({
            tags: true,
            tokenSeparators: [',', ' '],
        });
        woo_ishaarat_get_users_to_exclud(  $('select.woo-ishaarat-exclude-phone-numbers'), 'get-users-to-exclude');
        $('span.select2.select2-container.select2-container--default').removeAttr('style');

        function woo_ishaarat_get_users_to_exclud( selector, action_url ){
            selector.select2({
                ajax: {
                    url: ajaxurl,
                    dataType: 'json',
                    delay: 50,
                    data: function (params) {
                        return {
                            q: params.term,
                            action: action_url
                        };
                    },
                    processResults: function( data ) {
                        var options = [];
                        if ( data ) {
                            data.forEach(( content )=>{
                                options.push( { id: content[0], text: content[1]  } );
                            });
                        }
                        return {
                            results: options
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
        }

        $('a.woo-ishaarat-add-file-csv').on('click dbclick submit', function(e){
            e.preventDefault();
            var frame;
            if ( frame ) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: 'Select or Upload Contact List',
                button: {
                    text: 'Use this CSV/Excel Contact List'
                },
                library: {
                    type: [ 'text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ]
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected in the media frame...
            frame.on( 'select', function() {

                // Get media attachment details from the frame state
                var attachment = frame.state().get('selection').first().toJSON();

                var media_attachment_id = attachment.id;
                var media_attachment_url = attachment.url;
                woo_ishaarat_display_csv_attach_files( media_attachment_url, media_attachment_id );

            });

            // Finally, open the modal on click
            frame.open();
        });


    });

    function woo_ishaarat_display_csv_attach_files( media_attachment_url, media_attachment_id ){
        $('a.woo-ishaarat-add-file-csv').before( "The CSV/Excel file uploaded is available : <a href='"+ media_attachment_url +"'> here</a><br/>" );
        $('a.woo-ishaarat-add-file-csv').attr('data-attachment-id', media_attachment_id);
        $('input.woo-ishaarat-hidden-attachment-id').val( media_attachment_id);
    }

})(jQuery);
