jQuery(document).ready(function($) {
	
			jQuery("input[type=checkbox].switch").each(function() {
				// Insert switch
				jQuery(this).before('<span class="switch"><span class="background" /><span class="mask" /></span>');
				 //Hide checkbox
				jQuery(this).hide();
				if (!jQuery(this)[0].checked) jQuery(this).prev().find(".background").css({left: "-49px"});
				if (jQuery(this)[0].checked) jQuery(this).prev().find(".background").css({left: "-2px"});	
			});
			// Toggle switch when clicked
			jQuery("span.switch").click(function() {
				// Slide switch off
				if (jQuery(this).next()[0].checked) {
					jQuery(this).find(".background").animate({left: "-49px"}, 200);
				// Slide switch on
				} else {
					jQuery(this).find(".background").animate({left: "-2px"}, 200);
				}
				// Toggle state of checkbox
				jQuery('#').attr('checked', true);
				jQuery(this).next()[0].checked = !jQuery(this).next()[0].checked;
				
					if (jQuery("#easmedia_metabox_media_video_size").is(':checked')) {
					jQuery('#vidcustomsize').hide("slow");
					} else {
					jQuery('#vidcustomsize').show("slow");	
					}
					
					if (jQuery("#easmedia_metabox_media_gmap_size").is(':checked')) {
					jQuery('#gmapcustomsize').hide("slow");
					} else {
					jQuery('#gmapcustomsize').show("slow");	
					}					
					
					if (jQuery("#emgtinymce_custom_columns").is(':checked')) {
					jQuery('#customcolumns').show("slow");
					} else {
					jQuery('#customcolumns').hide("slow");	
					}	
					
					if (jQuery("#emgtinymce_custom_sz").is(':checked')) {
					jQuery('#mediacustomsize').show("slow");
					} else {
					jQuery('#mediacustomsize').hide("slow");	
					}
					
					if (jQuery("#emgtinymce_custom_align").is(':checked')) {
					jQuery('#customalign').show("slow");
					} else {
					jQuery('#customalign').hide("slow");	
					}					
						
					if (jQuery("#emgtinymce_custom_style").is(':checked')) {
					jQuery('#mediacustomstyle').show("slow");
					} else {
					jQuery('#mediacustomstyle').hide("slow");	
					}	
					
					if (jQuery("#emgtinymce_sprd_custom_style").is(':checked')) {
					jQuery('#mediacustomstylesprd').show("slow");
					} else {
					jQuery('#mediacustomstylesprd').hide("slow");	
					}		
					
					if (jQuery("#emgtinymce_custom_sprd_sz").is(':checked')) {
					jQuery('#mediacustomsprdsize').show("slow");
					} else {
					jQuery('#mediacustomsprdsize').hide("slow");	
					}	
					
					
					if (jQuery("#emgtinymce_singal_custom_style").is(':checked')) {
					jQuery('#mediasingalstylesprd').show("slow");
					} else {
					jQuery('#mediasingalstylesprd').hide("slow");	
					}		
					
					if (jQuery("#emgtinymce_singal_sprd_sz").is(':checked')) {
					jQuery('#mediasingalsprdsize').show("slow");
					} else {
					jQuery('#mediasingalsprdsize').hide("slow");	
					}					
									
									
																
			});
			
});