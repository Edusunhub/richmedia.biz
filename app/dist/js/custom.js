function selectCountry(ele){
  var value=$(ele).val();
  $.ajax({
  	type 		: 'get',
  	url 		: '../ajax.php?action=getstate&value='+value,
  	success 	: function(html) {
  		$('#state').html(html);
  	}
  })
}
function selectState(ele){
  var value=$(ele).val();
  $.ajax({
  	type 		: 'get',
  	url 		: '../ajax.php?action=getcity&value='+value,
  	success 	: function(html) {
  		$('#city').html(html);
  	}
  })
}

(function($) {
  'use strict';
  $(function() {
    $('.file-upload-browse').on('click', function() {
      var file = $(this).parent().parent().parent().find('.file-upload-default');
      file.trigger('click');
    });
    $('.file-upload-default').on('change', function() {
      $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });
  });
})(jQuery);
$(document).ready(function(){
  var value=$('.banner_type_input:checked').val();
  if(value=='url'){
    $('.banner_type_url_form input,.banner_type_url_form textarea').prop('disabled',false);
    $('.banner_type_js_form input,.banner_type_js_form textarea').prop('disabled',true);
    $('.banner_type_js_form').hide();
    $('.banner_type_url_form').show();
  }
  if(value=='js'){
    $('.banner_type_url_form input,.banner_type_url_form textarea').prop('disabled',true);
    $('.banner_type_js_form input,.banner_type_js_form textarea').prop('disabled',false);
    $('.banner_type_url_form').hide();
    $('.banner_type_js_form').show();
  }
})
$('.banner_type_input').on('change',function(){
  var value=$('.banner_type_input:checked').val();
  if(value=='url'){
    $('.banner_type_url_form input,.banner_type_url_form textarea').prop('disabled',false);
    $('.banner_type_js_form input,.banner_type_js_form textarea').prop('disabled',true);
    $('.banner_type_js_form').hide();
    $('.banner_type_url_form').show();
  }
  if(value=='js'){
    $('.banner_type_url_form input,.banner_type_url_form textarea').prop('disabled',true);
    $('.banner_type_js_form input,.banner_type_js_form textarea').prop('disabled',false);
    $('.banner_type_url_form').hide();
    $('.banner_type_js_form').show();
  }
});

$('input[name=payment]').on('change',function(){
  var value=$('input[name=payment]:checked').val();
  console.log(value);
  if(value==1){
    $('.wire-transfer-cover').slideDown();
    $('.wallet-form').slideUp();
    $('.paypal-form').slideUp();
    $('.razorpay-form').slideUp();
  } else if(value==3){
    $('.wallet-form').slideDown();
    $('.paypal-form').slideUp();
    $('.wire-transfer-cover').slideUp();
    $('.razorpay-form').slideUp();
  }
  else if(value==4){
    $('.razorpay-form').slideDown();
    $('.wallet-form').slideUp();
    $('.paypal-form').slideUp();
    $('.wire-transfer-cover').slideUp();
  }
  else{
    $('.paypal-form').slideDown();
    $('.wire-transfer-cover').slideUp();
    $('.wallet-form').slideUp();
    $('.razorpay-form').slideUp();
  }
})
$('[data-toggle="tooltip"]').tooltip();