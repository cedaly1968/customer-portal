jQuery(document).ready(function ($) {

	jQuery('#templates-container').isotope();
              
	// filter items when filter link is clicked
	jQuery('#template-filter a').click(function(){      
	  var selector = jQuery(this).attr('data-filter');
	  //alert(selector);
	  jQuery('#templates-container').isotope({ filter: selector });
	  return false;
	});
	/* Ajax loading tabs
		jQuery.koolSwap({
			swapBox : '#poststuff',
			outDuration : 550,
			inDuration : 600,
	});
	*/

      jQuery("body").on('click', '#content-tmce, .wp-switch-editor.switch-tmce', function () {
            $.cookie("lp-edit-view-choice", "editor", { path: '/', expires: 7 });
        });
        jQuery("body").on('click', '#content-html, .wp-switch-editor.switch-html', function () {
            $.cookie("lp-edit-view-choice", "html", { path: '/', expires: 7 });
        });
        var which_editor = $.cookie("lp-edit-view-choice");
        if(which_editor === null){
           setTimeout(function() {
            jQuery("#content-tmce").click();
            //jQuery(".wp-switch-editor.switch-tmce").click();
            }, 1000);
       
        }    
        if(which_editor === 'editor'){
          setTimeout(function() {
            jQuery("#content-tmce").click();
            //jQuery(".wp-switch-editor.switch-tmce").click();
            }, 1000);
        }

    /* Tour Start JS */
    var tourbutton = '<a class="" id="lp-tour" style="font-size:13px;">Need help? Take the tour</a>';
    jQuery(tourbutton).appendTo("h2:eq(0)");
    jQuery("body").on('click', '#lp-tour', function () {
        var tour = jQuery("#lp-tour-style").length;
         if ( tour === 0 ) {
            jQuery('head').append("<link rel='stylesheet' id='lp-tour-style' href='/wp-content/plugins/landing-pages/css/admin-tour.css' type='text/css' /><script type='text/javascript' src='/wp-content/plugins/landing-pages/js/admin/tour/tour.post-edit.js'></script><script type='text/javascript' src='/wp-content/plugins/landing-pages/js/admin/intro.js'></script>");
          }
        setTimeout(function() {
                introJs().start(); // start tour
        }, 300);

    });
   
    var current_a_tab = jQuery("#tabs-0").hasClass('nav-tab-special-active');
    if (current_a_tab === true){
        var url_norm = jQuery("#view-post-btn a").attr('href');
        var new_url = url_norm + "?lp-variation-id=0";
        jQuery("#view-post-btn a").attr('href', new_url);
    }
    
    // Fix inactivate theme display
    jQuery("#template-box a").live('click', function () {

		setTimeout(function() {
			jQuery('#TB_window iframe').contents().find("#customize-controls").hide();
				jQuery('#TB_window iframe').contents().find(".wp-full-overlay.expanded").css("margin-left", "0px");
		}, 600);
     
    });
    
    // Fix Split testing iframe size
    jQuery("#lp-metabox-splittesting a.thickbox, #leads-table-container-inside .column-details a").live('click', function () {
        jQuery('#TB_iframeContent, #TB_window').hide();
        setTimeout(function() {

         jQuery('#TB_iframeContent, #TB_window').width( 640 ).height( 800 ).css("margin-left", "0px").css("left", "35%");
         jQuery('#TB_iframeContent, #TB_window').show();
        }, 600);     
    });
    
    // Load meta box in correct position on page load
    var current_template = jQuery("input#lp_select_template ").val();
    var current_template_meta = "#lp_" + current_template + "_custom_meta_box";
    jQuery(current_template_meta).removeClass("postbox").appendTo("#template-display-options").addClass("Old-Template");
    var current_template_h3 = "#lp_" + current_template + "_custom_meta_box h3";
    jQuery(current_template_h3).css("background","#f8f8f8");
    jQuery(current_template_meta +' .handlediv').hide();
    jQuery(current_template_meta +' .hndle').css('cursor','default');
        
  
    // Fix Thickbox width/hieght
    jQuery(function($) {
        tb_position = function() {
            var tbWindow = $('#TB_window');
            var width = $(window).width();
            var H = $(window).height();
            var W = ( 1720 < width ) ? 1720 : width;

            if ( tbWindow.size() ) {
                tbWindow.width( W - 50 ).height( H - 45 );
                $('#TB_iframeContent').width( W - 50 ).height( H - 75 );
                tbWindow.css({'margin-left': '-' + parseInt((( W - 50 ) / 2),10) + 'px'});
                if ( typeof document.body.style.maxWidth != 'undefined' )
                    tbWindow.css({'top':'40px','margin-top':'0'});
                //$('#TB_title').css({'background-color':'#fff','color':'#cfcfcf'});
            };

            return $('a.thickbox').each( function() {
                var href = $(this).attr('href');
                if ( ! href ) return;
                href = href.replace(/&width=[0-9]+/g, '');
                href = href.replace(/&height=[0-9]+/g, '');
                $(this).attr( 'href', href + '&width=' + ( W - 80 ) + '&height=' + ( H - 85 ) );
                /*
                var frontend_status = jQuery("#frontend-on").val();
                if (typeof (frontend_status) != "undefined" && frontend_status !== null) {
                     console.log('clixk');
                    var custom_css = jQuery("#TB_iframeContent").contents().find('#custom-media-css').length; 
                    // Not complete need to troubleshoot
                        if( custom_css < 1) {
                        console.log('yes');
                        setTimeout(function() {
                        jQuery("#TB_iframeContent").contents().find('head').append('<link rel="stylesheet" id="custom-media-css" href="/wp-content/plugins/landing-pages/css/customizer.media-uploader.css" type="text/css" />');
                         }, 500);
                        setTimeout(function() {
                            jQuery("#TB_iframeContent").contents().find('head').append('<link rel="stylesheet" id="custom-media-css" href="/wp-content/plugins/landing-pages/css/customizer.media-uploader.css" type="text/css" />');
                        }, 2000);
                    }
                } */
            });

        };

        jQuery('a.thickbox').click(function(){
            if ( typeof tinyMCE != 'undefined' &&  tinyMCE.activeEditor ) {
                tinyMCE.get('content').focus();
                tinyMCE.activeEditor.windowManager.bookmark = tinyMCE.activeEditor.selection.getBookmark('simple');
            }
           
        });

        $(window).resize( function() { tb_position() } );
    });
    
    // Isotope Styling
    jQuery('#template-filter a').first().addClass('button-primary');
    jQuery('#template-filter a').click(function(){
        jQuery("#template-filter a.button-primary").removeClass("button-primary");
        jQuery(this).addClass('button-primary');
    });
    
    jQuery('.lp_select_template').click(function(){
        var template = jQuery(this).attr('id');
        var label = jQuery(this).attr('label');
		var selected_template_id = "#" + template;
		var currentlabel = jQuery(".currently_selected").show();
		var current_template = jQuery("input#lp_select_template ").val();
        var current_template_meta = "#lp_" + current_template + "_custom_meta_box";
        var current_template_h3 = "#lp_" + current_template + "_custom_meta_box h3";
        var current_template_div = "#lp_" + current_template + "_custom_meta_box .handlediv";
        var open_variation = jQuery("#open_variation").val();

		if (open_variation>0)
		{
			var variation_tag = "-"+open_variation;
		}
		else
		{
			var variation_tag = "";
		}
       
	    jQuery("#template-box.default_template_highlight").removeClass("default_template_highlight");   
        
        jQuery(selected_template_id).parent().addClass("default_template_highlight").prepend(currentlabel);
       
	    jQuery(".lp-template-selector-container").fadeOut(500,function(){
			jQuery('#lp_metabox_select_template input').remove();
			jQuery('#lp_metabox_select_template .form-table').remove(); 
						
			var ajax_data = {
				action: 'lp_get_template_meta',
				selected_template: template,
				post_id: lp_post_edit_ui.post_id,
			};	
	
			jQuery.ajax({
					type: "POST",
					url: lp_post_edit_ui.ajaxurl,
					data: ajax_data,
					dataType: 'html',
					timeout: 7000,
					success: function (response) {		
						//alert(response);
						var html = '<input id="lp_select_template" type="hidden" value="'+template+'" name="lp-selected-template'+variation_tag+'">'
								 + '<input type="hidden" value="'+lp_post_edit_ui.lp_template_nonce+'" name="lp_lp_custom_fields_nonce">'
								 + '<h3 class="hndle" style="background: none repeat scroll 0% 0% rgb(248, 248, 248); cursor: default;">'
								 + '<span>'
								 + '<small>'+ template +' Options:</small>'
								 +	'</span>'
								 +	'</h3>'
								 + response;									
						
						jQuery('#lp_metabox_select_template #template-display-options').html(html);
						jQuery('.time-picker').timepicker({ 'timeFormat': 'H:i' });						
						
					},
					error: function(request, status, err) {					
						alert(status);
					}
				});
            jQuery(".wrap").fadeIn(500, function(){
            });
        });
		
        jQuery(current_template_meta).appendTo("#template-display-options");
        jQuery('#lp_metabox_select_template h3').first().html('Current Active Template: '+label);
        jQuery('#lp_select_template').val(template);
        jQuery(".Old-Template").hide();
      
        jQuery(current_template_div).css("display","none");
        jQuery(current_template_h3).css("background","#f8f8f8");
        jQuery(current_template_meta).show().appendTo("#template-display-options").removeClass("postbox").addClass("Old-Template");
        //alert(template);
        //alert(label);
    });

    jQuery('#lp-cancel-selection').click(function(){
        jQuery(".lp-template-selector-container").fadeOut(500,function(){
            jQuery(".wrap").fadeIn(500, function(){
            });
        });
    
    });
    
    // the_content default overwrite
    jQuery('#overwrite-content').click(function(){
        if (confirm('Are you sure you want to overwrite what is currently in the main edit box above?')) {
            var default_content = jQuery(".default-content").text();
           jQuery("#content_ifr").contents().find("body").html(default_content);
        }
    });
    
    // Colorpicker fix
    jQuery(document).on('mouseenter', '.jpicker', function (e) {
		if(jQuery(e.target).data('mouseovered')!='yes')
		{
  
			jQuery(this).jPicker({
				window: // used to define the position of the popup window only useful in binded mode
				{
					title: null, // any title for the jPicker window itself - displays "Drag Markers To Pick A Color" if left null
					position: {
						x: 'screenCenter', // acceptable values "left", "center", "right", "screenCenter", or relative px value
						y: 'center', // acceptable values "top", "bottom", "center", or relative px value
					},
					expandable: false, // default to large static picker - set to true to make an expandable picker (small icon with popup) - set
					// automatically when binded to input element
					liveUpdate: true, // set false if you want the user to click "OK" before the binded input box updates values (always "true"
					// for expandable picker)
					alphaSupport: false, // set to true to enable alpha picking
					alphaPrecision: 0, // set decimal precision for alpha percentage display - hex codes do not map directly to percentage
					// integers - range 0-2
					updateInputColor: true // set to false to prevent binded input colors from changing
				}
			},
			function(color, context)
			{
			  var all = color.val('all');
			 // alert('Color chosen - hex: ' + (all && '#' + all.hex || 'none') + ' - alpha: ' + (all && all.a + '%' || 'none'));
			   //jQuery(this).attr('rel', all.hex);
			   jQuery(this).parent().find(".lp-success-message").remove();
			   jQuery(this).parent().find(".new-save-lp").show();
			   jQuery(this).parent().find(".new-save-lp-frontend").show();

			   //jQuery(this).attr('value', all.hex);
			});
			jQuery(e.target).data('mouseovered','yes');
		}		
    });

    if (jQuery(".lp-template-selector-container").css("display") == "none"){
        jQuery(".currently_selected").hide(); }
    else {
        jQuery(".currently_selected").show();
    }

    // Add current title of template to selector
    var selected_template = jQuery('#lp_select_template').val();
    var selected_template_id = "#" + selected_template;
    var clean_template_name = selected_template.replace(/-/g, ' ');
    function capitaliseFirstLetter(string)
    {
    return string.charAt(0).toUpperCase() + string.slice(1);
    }
    var currentlabel = jQuery(".currently_selected");
    jQuery(selected_template_id).parent().addClass("default_template_highlight").prepend(currentlabel);
    jQuery("#lp_metabox_select_template h3").first().prepend('<strong>' + capitaliseFirstLetter(clean_template_name) + '</strong> - ');

    jQuery('#lp-change-template-button').live('click', function () {
        jQuery(".wrap").fadeOut(500,function(){
            jQuery('#templates-container').isotope();
            jQuery(".lp-template-selector-container").fadeIn(500, function(){
                jQuery(".currently_selected").show();
                jQuery('#lp-cancel-selection').show();
            });
            jQuery("#template-filter li a").first().click();
        });
    });
    
    /* Move Slug Box
    var slugs = jQuery("#edit-slug-box");
    jQuery('#main-title-area').after(slugs.show());
    */
    // Background Options
    jQuery('.current_lander .background-style').live('change', function () {
        var input = jQuery(".current_lander .background-style option:selected").val();
        if (input == 'color') {
            jQuery('.current_lander tr.background-color').show();
            jQuery('.current_lander tr.background-image').hide();
            jQuery('.background_tip').hide();
        } 
        else if (input == 'default') {
            jQuery('.current_lander tr.background-color').hide();
            jQuery('.current_lander tr.background-image').hide();
            jQuery('.background_tip').hide();
        } 
        else if (input == 'custom') {
            var obj = jQuery(".current_lander tr.background-style td .lp_tooltip");
            obj.removeClass("lp_tooltip").addClass("background_tip").html("Use the custom css block at the bottom of this page to set up custom CSS rules");
            jQuery('.background_tip').show();
        }
        else {
            jQuery('.current_lander tr.background-color').hide();
            jQuery('.current_lander tr.background-image').show();
            jQuery('.background_tip').hide();
        }

    });

    // Check BG options on page load  
    jQuery(document).ready(function () {
        var input2 = jQuery(".current_lander .background-style option:selected").val();
        if (input2 == 'color') {
            jQuery('.current_lander tr.background-color').show();
            jQuery('.current_lander tr.background-image').hide();
        } else if (input2 == 'custom') {
            var obj = jQuery(".current_lander tr.background-style td .lp_tooltip");
            obj.removeClass("lp_tooltip").addClass("background_tip").html("Use the custom css block at the bottom of this page to set up custom CSS rules");
            jQuery('.background_tip').show();
        } else if (input2 == 'default') {
            jQuery('.current_lander tr.background-color').hide();
            jQuery('.current_lander tr.background-image').hide();   
        } else {
            jQuery('.current_lander tr.background-color').hide();
            jQuery('.current_lander tr.background-image').show();
        }
    });

    //Stylize lead's wp-list-table
    var cnt = $("#leads-table-container").contents();
    $("#lp_conversion_log_metabox").replaceWith(cnt);
    
    //remove inputs from wp-list-table
    jQuery('#leads-table-container-inside input').each(function(){
        jQuery(this).remove();
    });

     var post_status = jQuery("#original_post_status").val();
    
    if (post_status === "draft") {
        // jQuery( ".nav-tab-wrapper.a_b_tabs .lp-ab-tab, #tabs-add-variation").hide();
        jQuery(".new-save-lp-frontend").on("click", function(event) {
            event.preventDefault();
            alert("Must publish this page before you can use the visual editor!");
        });
        var subbox = jQuery("#submitdiv");
        jQuery("#lp_ab_display_stats_metabox").before(subbox)
    } else {
        jQuery("#publish").val("Update All");
    }

    // Ajax Saving for metadata
    jQuery('#lp_metabox_select_template input, #lp_metabox_select_template select, #lp_metabox_select_template textarea').on("change keyup", function (e) {
        // iframe content change needs its own change function $("#iFrame").contents().find("#someDiv")
        // media uploader needs its own change function
        var this_id = jQuery(this).attr("id");
        var parent_el = jQuery(this).parent();
        jQuery(parent_el).find(".lp-success-message").remove();
        jQuery(parent_el).find(".new-save-lp").remove();
        var ajax_save_button = jQuery('<span class="button-primary new-save-lp" id="' + this_id + '" style="margin-left:10px">Update</span>');
        //console.log(parent_el);
        jQuery(ajax_save_button).appendTo(parent_el);
    });
    jQuery('#lp-notes-area input').on("change keyup", function (e) {
       var this_id = jQuery(this).attr("id");
        var parent_el = jQuery(this).parent();
        jQuery(parent_el).find(".lp-success-message").remove();
        jQuery(parent_el).find(".new-save-lp").remove();
        var ajax_save_button = jQuery('<span class="button-primary new-save-lp" id="' + this_id + '" style="margin-left:10px">Update</span>');
        //console.log(parent_el);
        jQuery(ajax_save_button).appendTo(parent_el);
    });

    jQuery('#main-title-area input').on("change keyup", function (e) {
        // iframe content change needs its own change function $("#iFrame").contents().find("#someDiv")
        // media uploader needs its own change function
        var this_id = jQuery(this).attr("id");
        var current_view = jQuery("#lp-current-view").text();
        if (current_view !== "0") {
            this_id = this_id + '-' + current_view;
        }
        var parent_el = jQuery(this).parent();
        jQuery(parent_el).find(".lp-success-message").remove();
        jQuery(parent_el).find(".new-save-lp").remove();
        var ajax_save_button = jQuery('<span class="button-primary new-save-lp" id="' + this_id + '" style="margin-left:10px">Update</span>');
        //console.log(parent_el);
        jQuery(ajax_save_button).appendTo(parent_el);
    });

    // wysiwyg on keyup save action
    /*
    setTimeout(function() {
    jQuery('.mceIframeContainer iframe, .landing-page-option-row iframe').contents().find('body').on("keyup", function (e) {
        var thisclass = jQuery(this).attr("class");
        var this_class_dirty = thisclass.replace("mceContentBody ", "");
        var this_class_cleaner = this_class_dirty.replace("wp-editor", "");
        var clean_1 = this_class_cleaner.replace("post-type-landing-page", "");
        var clean_2 = clean_1.replace("post-status-publish", ""); 
        var clean_3 = clean_2.replace(/[.\s]+$/g, ""); // remove trailing whitespace
        var clean_spaces = clean_3.replace(/\s{2,}/g, ' '); // remove more than one space
        var this_id =  clean_spaces.replace(/[.\s]+$/g, ""); // remove trailing whitespace
        console.log(this_id);
        var parent_el = jQuery( "." + this_id + " .landing-page-table-header");
        jQuery(parent_el).find(".lp-success-message").remove();
        jQuery(parent_el).find(".new-save-lp").remove();
        var ajax_save_button = jQuery('<span class="button-primary new-save-lp" id="' + this_id + '" style="margin-left:10px;">Update</span>');
        //console.log(parent_el);
        jQuery(ajax_save_button).appendTo(parent_el);
    });
    }, 4000);
    */
   
      
	// SAVE META
    var nonce_val = lp_post_edit_ui.wp_landing_page_meta_nonce; // NEED CORRECT NONCE
    jQuery(document).on('mousedown', '.new-save-lp', function () {
        var type_input = jQuery(this).parent().find("input").attr("type");
        var type_select = jQuery(this).parent().find("select");
        // var the_conversion_area_editor = jQuery(this).parent().parent().find('#lp-conversion-area_ifr').length;
        jQuery(this).parent().find(".lp-success-message").hide();
       // var the_content_editor = jQuery(this).parent().parent().find('#wp_content_ifr').length;
        var type_wysiwyg = jQuery(this).parent().parent().find('iframe').length;

        var type_textarea = jQuery(this).parent().find("textarea");
        if (typeof (type_input) != "undefined" && type_input !== null) {
            var type_of_field = type_input;
        } else if (typeof (type_wysiwyg) != "undefined" && type_wysiwyg !== null && type_wysiwyg === 1) {
            var type_of_field = 'wysiwyg';
        } else if (typeof (type_textarea) != "undefined" && type_textarea !== null) {
            var type_of_field = 'textarea';
        } else {
            (typeof (type_select) != "undefined" && type_select)
            var type_of_field = 'select';
        }
        // console.log(type_of_field); // type of input
        var new_value_meta_input = jQuery(this).parent().find("input").val();
        //console.log(new_value_meta_input); 
        var new_value_meta_select = jQuery(this).parent().find("select").val();
        var new_value_meta_textarea = jQuery(this).parent().find("textarea").val();
       // console.log(new_value_meta_select); 
        var new_value_meta_radio = jQuery(this).parent().find("input:checked").val();
        var new_value_meta_checkbox = jQuery(this).parent().find('input[type="checkbox"]:checked').val();
        var new_wysiwyg_meta = jQuery(this).parent().parent().find("iframe").contents().find("body").html();
        // prep data
        if (typeof (new_value_meta_input) != "undefined" && new_value_meta_input !== null && type_of_field == "text") {
            var meta_to_save = new_value_meta_input;
        } else if (typeof (new_value_meta_textarea) != "undefined" && new_value_meta_textarea !== null && type_of_field == "textarea") {
            var meta_to_save = new_value_meta_textarea;
        } else if (typeof (new_value_meta_select) != "undefined" && new_value_meta_select !== null) {
            var meta_to_save = new_value_meta_select;
        } else if (typeof (new_value_meta_radio) != "undefined" && new_value_meta_radio !== null && type_of_field == "radio") {
            var meta_to_save = new_value_meta_radio;
        } else if (typeof (new_value_meta_checkbox) != "undefined" && new_value_meta_checkbox !== null && type_of_field == "checkbox") {
            var meta_to_save = new_value_meta_checkbox;
        } else if (typeof (new_wysiwyg_meta) != "undefined" && new_wysiwyg_meta !== null && type_of_field == "wysiwyg") {
            var meta_to_save = new_wysiwyg_meta;
            //alert('here');  
        } else {
            var meta_to_save = "";
        }

        // if data exists save it
        // console.log(meta_to_save);

        var this_meta_id = jQuery(this).attr("id"); // From save button
        console.log(this_meta_id);
        var post_id = jQuery("#post_ID").val();
        console.log(post_id);
        console.log(meta_to_save);
        var frontend_status = jQuery("#frontend-on").val();

        function do_reload_preview() {    
        var cache_bust =  generate_random_cache_bust(35);
        var reload_url = parent.window.location.href;
        reload_url = reload_url.replace('template-customize=on','');
        //alert(reload_url);
        var current_variation_id = jQuery("#lp-current-view").text();
    
        // var reload = jQuery(parent.document).find("#lp-live-preview").attr("src"); 
        var new_reload = reload_url + "&live-preview-area=" + cache_bust + "&lp-variation-id=" + current_variation_id;
        //alert(new_reload);
        jQuery(parent.document).find("#lp-live-preview").attr("src", new_reload);
        // console.log(new_reload);
        }
        // Run Ajax
        jQuery.ajax({
            type: 'POST',
            url: lp_post_edit_ui.ajaxurl,
            context: this,
            data: {
                action: 'wp_landing_page_meta_save',
                meta_id: this_meta_id,
                new_meta_val: meta_to_save,
                page_id: post_id,
                nonce: nonce_val
            },

            success: function (data) {
                var self = this;

                //alert(data);
                // jQuery('.lp-form').unbind('submit').submit();
                //var worked = '<span class="success-message-map">Success! ' + this_meta_id + ' set to ' + meta_to_save + '</span>';
                var worked = '<span class="lp-success-message">Updated!</span>';
                var s_message = jQuery(self).parent();
                jQuery(worked).appendTo(s_message);
                jQuery(self).parent().find("lp-success-message").remove();
                jQuery(self).hide();
                // RUN RELOAD
                if (typeof (frontend_status) != "undefined" && frontend_status !== null) {
               
                console.log('reload frame');
                do_reload_preview();
                } else {
                console.log('No reload frame');    
                }
                //alert("Changes Saved!");
            },

            error: function (MLHttpRequest, textStatus, errorThrown) {
                alert("Ajax not enabled");
            }
        });
        
        //reload_preview();    
        return false;    
            
    });

    
});
