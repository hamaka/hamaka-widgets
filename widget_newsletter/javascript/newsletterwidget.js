
 jQuery(document).ready(function()
 {
	 fNewsletterWidgetInit();
 });

 function fNewsletterWidgetInit()
 {
	 if (jQuery('form')[0]) {
		 // Add validation checks to forms by default
		 jQuery('form').submit(fNewsletterWidgetInputCheck);
	 }
 }

 function fNewsletterWidgetInputCheck(event)
 {
	 if (jQuery(this).hasClass('ajaxForm')) {
		 // AJAX form, call function depending on which form it is
		 switch (jQuery(this).hasClass('widgetNewsLetter')) {
			 case true:
				 fNewsletterWidgetSubscribe(jQuery(this));
				 break;
			 default:
				 // Temp catch-all
				 break;
		 }
	 }

		 // dit mag de normale fInputCheck verder afhandelen
		 return true;
 }


 /********** AJAX FUNCTIONS **********************************/
	 // A function which performs an AJAX call to subscribe to the newsletter
 function fNewsletterWidgetSubscribe(oForm) {
	 var jsonFormData = oForm.serialize();
	 var jqEmailField = oForm.find('.email');
	 jqEmailField.attr('disabled', true);
	 oForm.find('.action').attr('disabled', true);

	 jQuery.get(sHostURL + 'NewsletterWidget_Controller/subscribeNewsLetterAJAX/', jsonFormData, function(sData)
	 {
		 if (sData == "success")
		 {
			 jqEmailField.attr('disabled', false);
			 oForm.find('.action').attr('disabled', false);
			 oForm.find('.message').show();
			 oForm.find('.message').html('<h2>Keep me updated</h2><p>Thanks, your submission has been received. We will keep you posted.</p>');
			 oForm.find('fieldset').hide();
			 oForm.find('.Actions').hide();
		 }
		 else {
			 jqEmailField.attr('disabled', false);
			 oForm.find('.action').attr('disabled', false);
			 oForm.find('.message').show();
			 oForm.find('.message').html('<p>'+sData+'</p>');
		 }
	 });
 }