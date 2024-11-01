var $ =jQuery.noConflict();
$("#wps-wcnc-cust-all-mc-btn").click(function(){
  $("#wps-wcnc-cust-all-mc").submit();
});

$("#wps-wcnc-cust-all-ic-btn").click(function(){
  $("#wps-wcnc-cust-all-ic").submit();
}); 

$(document).ready(function() {
  get_mc_lists();
  get_ic_lists();
});
/*MailChimp Get List ID*/
$( "#wps_wcnc_mailchimp_key" ).keyup(function() {
    get_mc_lists();

});
function get_mc_lists(){
  if(!$( "#wps_wcnc_mailchimp_key" ).val())
    return;
  var data = {
    'action': 'wps_wcnc_get_mc_list',
    'dataType': "html",
    'api_key': $( "#wps_wcnc_mailchimp_key" ).val(),
  };
  $("#wps_wcnc_mailchimp_list_id").html('');
  $('.wpcWcncloaderDiv').show();
  jQuery.post(ajaxurl, data, function(response) {
      $("#wps_wcnc_mailchimp_list_id").html(response);
      $('.wpcWcncloaderDiv').hide();
  });
}
/* iConatct Get List ID */
$( "#wps_wcnc_icontact_username" ).keyup(function() {
    get_ic_lists();
});
$( "#wps_wcnc_iconatct_api_key" ).keyup(function() {
    get_ic_lists();
});
$( "#wps_wcnc_iconatct_pass" ).keyup(function() {
    get_ic_lists();
});
function get_ic_lists(){
  if(!$( "#wps_wcnc_iconatct_api_key" ).val())
    return;
  if(!$( "#wps_wcnc_icontact_username" ).val())
    return;
  if(!$( "#wps_wcnc_iconatct_pass" ).val())
    return;
  var data = {
      'action': 'wps_wcnc_get_ic_list',
      'dataType': "html",
      'api_key': $( "#wps_wcnc_iconatct_api_key" ).val(),
      'user_name': $( "#wps_wcnc_icontact_username" ).val(),
      'app_pass': $( "#wps_wcnc_iconatct_pass" ).val(),
    };
    $('.wpcWcncloaderDiv').show();
    jQuery.post(ajaxurl, data, function(response) {
        $('#wps_wcnc_iconatct_list_id').html('');
        $("#wps_wcnc_iconatct_list_id").append(response);
        $('.wpcWcncloaderDiv').hide();
    });
}
