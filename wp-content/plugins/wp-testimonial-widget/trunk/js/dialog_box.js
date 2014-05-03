//tinyMCEPopup.requireLangPack();
	
var SWPTInsertDialog = {

	init : function() {
	    var shortcode; var intTesti; var order; var orderby; var effects; var time;
	    jQuery('.btn_add').live("click",function(e){	        
			jQuery("#add_shortcode").validate();
			var form = jQuery("#add_shortcode");
			
			if(form.valid())
			{
				update_shortcode();
			}
			else
			{
				return false;
			}        
	    });

		function update_shortcode() {
				if (jQuery('#no_of_testi').val() !='' && isNaN(jQuery('#no_of_testi').val()) == false) {
					intTesti = 'testimonials='+jQuery('#no_of_testi').val();
				}else{
					intTesti = 1;
				}
				
				if (jQuery('input.order:checked').val() !='') {	
					order = ' order='+jQuery('input.order:checked').val();
					
				}else{
					order = 'asc';
				}

				if (jQuery('input.orderby:checked').val() !='') {	
					orderby = ' orderby='+jQuery('input.orderby:checked').val();
					
				}else{
					orderby = 'id';
				}
				
				if ((jQuery('#effects').val() != '') ) {
					effects = ' effects='+jQuery('#effects').val();
				}
				else
				{
					effects = 'none';

				}
				
				if (jQuery('#time').val() !='' && isNaN(jQuery('#time').val()) == false) {
					time = ' time='+jQuery('#time').val();
				}else{
					time = 1000 ;
				}

				var newsc = '[swp-testimonial '+intTesti+order+orderby+effects+time+']';
				jQuery('#shortcode').val(newsc);			
		}
		
	},
	insert : function() {
		// insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, jQuery('#shortcode').val());
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(SWPTInsertDialog.init, SWPTInsertDialog);

// function to check height and width is number or not
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}