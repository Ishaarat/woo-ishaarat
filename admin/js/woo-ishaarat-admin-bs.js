(function ($) {
    'use strict';

   

    //$('select.wooishaarat-select').select2();
    $(document).on('keyup', 'textarea.woo_ishaarat_textarea_text', function (evt) {
        evt.stopPropagation();
        evt.preventDefault();
        $('div.wooishaarat-textcount').remove();
        let limit = $(this).empty().val().length;
        // if (limit >= parseInt(160)) {
        //     $('div.wooishaarat-textcount').append(woo_ishaarat_ajax_object.warning_message);
        // }
        $('<div class="wooishaarat-textcount" style="color : red;"> <strong>' + limit + ' ' + woo_ishaarat_ajax_object.count_characters_typed + '</strong> <br/></div>').insertAfter($(this));
    });

    $(document).on('click dbclick', '.woo-ishaarat-add-more-message', function (evt) {
        evt.stopPropagation();
        evt.preventDefault();
        
        let nextValue = HSGenerateRandom(5);
        let html = '<span class="woo-ishaarat-bulk-sms-index" style="display: grid;" data-id="' + nextValue + '">\n' +
            '\t\t            <textarea class="woo-ishaarat-textarea-' + nextValue + ' woo_ishaarat_textarea_text" rows="5" style="width: 500px;" name="woo-ishaarat[messages-to-send][' + nextValue + ']"></textarea>\n' +
            '\t                <button class="button button-primary woo-ishaarat-remove-prev-block" data-id="' + nextValue + '" style="width: 40% !important;">Remove message block</button>\n' +
            '\t                <br>\n' +
            '</span>';
        
        $(html).insertBefore('span.woo-ishaarat-bulk-sms-add-more-message');
    });


    $(document).on('click dbclick', 'button.wooishaarat-remove', function (evt) {
        evt.stopPropagation();
        evt.preventDefault();
        let block_id = $(this).data('id');
        $('textarea.woo_ishaarat_textarea_messages[data-id=' + block_id + ']').remove();
    });

    $(document).on('click dbclick', '.woo-ishaarat-remove-prev-block', function (e) {
        e.stopPropagation();
        e.preventDefault();
        let blockID = $(this).data('id');
        let blockQty = $('span.woo-ishaarat-bulk-sms-index').length;
       
        $('span.woo-ishaarat-bulk-sms-index[data-id=' + blockID + ']').remove();
    });


    

    $(document).on('keyup', 'textarea.woo_ishaarat_textarea_text', function (evt) {
        evt.stopPropagation();
        evt.preventDefault();
        $('div.wooishaarat-textcount').remove();
        let limit = $(this).empty().val().length;
        // if (limit >= parseInt(160)) {
        //     $('div.wooishaarat-textcount').append(woo_ishaarat_ajax_object.warning_message);
        // }
        $('<div class="wooishaarat-textcount" style="color : red;"> <strong>' + limit + ' ' + woo_ishaarat_ajax_object.count_characters_typed + '</strong> <br/></div>').insertAfter($(this));
    });
    
    $(document).on('ready', function(){
        //Load and display the datetimepicker of the plugin.
        //$('.woo-ishaarat-datetime-local').appendDtpicker();
        $.wooishaarat_datetimepicker.setDateFormatter('moment');
        setTimeout(function(){
            $('#woo-ishaarat-start-date').wooishaarat_datetimepicker({ formatDate: 'Y-m-d', timepicker: true});
            $('#woo-ishaarat-end-date').wooishaarat_datetimepicker({ formatDate: 'Y-m-d', timepicker: true});
        }, 3000);
       
        if ( jQuery('select[name="woo-ishaarat[bulk-sms-receivers]"]').val() == null ){
             jQuery('<p>'+woo_ishaarat_ajax_object.warning_cl_message+'</p>').insertAfter( 'select[name="woo-ishaarat[bulk-sms-receivers]').css('color', 'red');
	}
    });

})(jQuery);
