jQuery(document).ready(function($) {
 
 	$("a#nblast-modal").fancybox({
		'hideOnContentClick': true
	});
  
  // Toggle the modal open - close
  function toggleEmailModal()
  {
    $.fancybox.open('#modal-signup');
  }	  

  // If user has not completed the email form
  if (! jQuery.cookie('email-complete')) {

    // set page count if net set
    if (! jQuery.cookie('email-page')) {
      jQuery.cookie('email-page', '1', {  path: '/' } );
    } else {
      var value = parseFloat(jQuery.cookie('email-page'));
      value = value + 1;
      jQuery.cookie('email-page', value, {  path: '/' } );
    }

    // If the have viewed 3 pages and not closed the modal in 7 days
    if (jQuery.cookie('email-page') === '3' && !jQuery.cookie('close-email-page') ) {
      toggleEmailModal();
    }
    
    // listen if they close modal and set the cookie
    jQuery( "#gform_submit_button_1, .fancybox-close, .fancybox-overlay" ).click(function() {
      jQuery.cookie('close-email-page', 'true', { expires: 7, path: '/' } );
    });
}	

});	
