var $ = jQuery;

/**
 * @return {string}
 */
var HSGenerateRandom = function (length) {
  "use strict";
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
};

function ishaarat_render_array(array, display) {
  if (Array.isArray(array)) {
    array.forEach(function (data) {
      if (display == "show") {
        data.show();
      } else if (display == "hide") {
        data.hide();
      }
    });
  } else {
    if (display == "show") {
      array.show();
    } else if (display == "hide") {
      array.hide();
    }
  }
}

var hs_add_more_message = function (html_selector, id) {
  let ids = 0;
  if (id) {
    ids += id;
  }
  let button = "<br/><div data-id='" + ids + "'> <button type='submit' class='button button-primary add-more-message'>"
      + woo_ishaarat_ajax_object.add_message_txt + "</button> </div>";
  $(button).insertAfter(html_selector);
};

function ishaarat_hide_fields(sibling, to_hide) {
  $(sibling).change(function () {
    if (this.checked) {
      ishaarat_render_array(to_hide, "show");
    } else {
      ishaarat_render_array(to_hide, "hide");
    }
  });
}

/**
 * This function hide some elements based on the checkbox checked.
 * @param checkbox_elem jQuery element to tag.
 * @param elem_to_hide  jQuery element to tag.
 */
var hs_toggle_display = function (checkbox_elem, elem_to_hide) {
  var woo_ishaarat_elem = $(checkbox_elem).is(":checked");
  if (woo_ishaarat_elem) {
    $(elem_to_hide).show();
  } else {
    $(elem_to_hide).hide();
  }
};

$(document).ready(function (){
    var dismiss_banner = $('a#ishaarat-never-show-again');

    $(document).on('click dbclick', 'a#ishaarat-never-show-again', function (e){
        e.preventDefault();
       $.post(woo_ishaarat_ajax_object.woo_ishaarat_ajax_url, {
           'action' : 'woo_ishaarat-review-answers',
           'type' : 'already_give',
           'security' : woo_ishaarat_ajax_object.woo_ishaarat_ajax_security
       }, function(){
          $('div#woo_ishaarat_banner').hide();
       });

    });


    $(document).on('click dbclick', 'a#ishaarat-never-show-again', function (e){
        e.preventDefault();
        $.post(woo_ishaarat_ajax_object.woo_ishaarat_ajax_url, {
            'action' : 'woo_ishaarat-review-answers',
            'type' : 'dismiss',
            'security' : woo_ishaarat_ajax_object.woo_ishaarat_ajax_security
        }, function(){
            $('div#woo_ishaarat_banner').hide();
        });

    });

    $('form.ishaarat-custom-tables table');

    jQuery('button.woo_ishaarat_s_bs_now').on('click dbclick', function(e){
      e.preventDefault();
      var pn_associated = $(this).data('bsPnAssociated');
      var bs_associated = $(this).data('bsId');
      $.post(woo_ishaarat_ajax_object.woo_ishaarat_ajax_url, {
        'action' : 'send-bs',
        'phone_number' : pn_associated,
        'bulk_sms' : bs_associated
      }, function(response){
        if ( response == 1 ){
          window.location.reload();
        }
      })
    });

    $('div.ishaarat-links').parent().attr('target','_blank');
});
