jQuery(document).ready(function($) {
/* Core Inbound Form Tracking Script */
	
		jQuery("body").on('submit', '.wpl-track-me', function (e) {
			
			this_form = jQuery(this);
			
			// process form only once
			processed = this_form.hasClass('lead_processed');
			if (processed === true) {
				return;
			}

			form_id = jQuery(this).attr('id');
			form_class = jQuery(this).attr('class');

			jQuery('button, input[type="button"]').css('cursor', 'wait');
			jQuery('input').css('cursor', 'wait');
			jQuery('body').css('cursor', 'wait');
			
			e.preventDefault(); // halt normal form
			
			var email = "";
			var firstname = "";
			var lastname = "";			
			var phone = "";			
			var company = "";		
			var address = "";		
			
			var tracking_obj = JSON.stringify(trackObj);
			var page_view_count = countProperties(pageviewObj);
			//console.log("view count" + page_view_count);
			
			if (!email)
			{

				 jQuery(this_form).find('input[type=text],input[type=email]').each(function() {
					if (this.value)
					{
						if (jQuery(this).attr("name").toLowerCase().indexOf('email')>-1&&!email) {
							email = this.value;
							
						}
						else if(jQuery(this).attr("name").toLowerCase().indexOf('e-mail')>-1&&!email) {
							 email = this.value;
						}
						else if(jQuery(this).attr("name").toLowerCase().indexOf('name')>-1&&!firstname) {
							 firstname = this.value;
						}
						else if (jQuery(this).attr("name").toLowerCase().indexOf('last')>-1) {
							 lastname = this.value;
						}
						else if (jQuery(this).attr("name").toLowerCase().indexOf('phone')>-1) {
							 phone = this.value;
						}
						else if (jQuery(this).attr("name").toLowerCase().indexOf('company')>-1) {
							 company = this.value;
						}
						else if (jQuery(this).attr("name").toLowerCase().indexOf('address')>-1) {
							 address = this.value;
						}
					}
				});
			}

			if (!email)
			{
				jQuery(this_form).find('input[type=text],input[type=email]').each(function() {
					if (jQuery(this).closest('li').children('label').length>0)
					{
						if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('email')>-1&&!email) 
						{
							email = this.value;
						}
						else if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('e-mail')>-1&&!email) {
							email =  this.value;
						}
						else if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('name')>-1&&!firstname) {
							firstname = this.value;
						}
						else if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('last')>-1) {
							lastname = this.value;
						}						
						else if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('phone')>-1) {
							 phone = this.value;
						}
						else if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('company')>-1) {
							 company = this.value;
						}
						else if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('address')>-1) {
							 address = this.value;
						}
					}

				});
			}

			if (!email)
			{
				jQuery(this_form).find('input[type=text],input[type=email]').each(function() {
					if (jQuery(this).closest('div').children('label').length>0)
					{
						if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('email')>-1&&!email) 
						{
							email = this.value;
						}
						else if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('e-mail')>-1&&!email) {
							email = this.value;
						}		
						else if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('name')>-1&&!firstname) {
							firstname = this.value;
						}
						else if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('last')>-1) {
							lastname = this.value;
						}						
						else if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('phone')>-1) {
							 phone = this.value;
						}
						else if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('company')>-1) {
							 company = this.value;
						}
						else if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('address')>-1) {
							 address = this.value;
						}
					}
				});
			}


			if (!lastname&&firstname)
			{
				var parts = firstname.split(" ");
				firstname = parts[0];
				lastname = parts[1];
			}

			var form_inputs = jQuery('.wpl-track-me').find('input[type=text],textarea,select');

			var post_values = {};
			form_inputs.each(function() {
				post_values[this.name] = jQuery(this).val();
			});	
			var post_values_json = JSON.stringify(post_values);
			var wp_lead_uid = jQuery.cookie("wp_lead_uid");	
			var page_views = JSON.stringify(pageviewObj);
			var page_id = inbound_ajax.post_id;
			if (typeof (landing_path_info) != "undefined" && landing_path_info != null && landing_path_info != "") {	
				var lp_v = landing_path_info.variation;
			} else if (typeof (cta_path_info) != "undefined" && cta_path_info != null && cta_path_info != "") {	
				var lp_v = cta_path_info.variation;
			} else {
				var lp_v = null;
			}
		
			jQuery.cookie("wp_lead_email", email, { path: '/', expires: 365 });
			
			function release_form_sub(this_form){
				jQuery('button, input[type="button"]').css('cursor', 'default');
				jQuery('input').css('cursor', 'default');
				jQuery('body').css('cursor', 'default');
				this_form.unbind('submit');
				this_form.submit();
			}

			/* Timeout Fallback
			setTimeout(function() {
				console.log('more than 10 seconds has passed. Release form')
	            release_form_sub();   
	       	}, 10000);
			*/
			jQuery.ajax({
				type: 'POST',
				url: inbound_ajax.admin_url,
				timeout: 10000,
				data: {
					action: 'inbound_store_lead',
					emailTo: email, 
					first_name: firstname, 
					last_name: lastname,
					phone: phone,
					address: address,
					company_name: company,
					wp_lead_uid: wp_lead_uid,
					page_view_count: page_view_count,
					page_views: page_views,
					post_type: inbound_ajax.post_type,
					lp_v: lp_v,
					json: tracking_obj, // replace with page_view_obj
					// type: 'form-completion',
					raw_post_values_json : post_values_json,
					lp_id: page_id
					/* Replace with jquery hook
						do_action('wpl-lead-collection-add-ajax-data'); 
					*/
				},
				success: function(user_id){	
						jQuery(this_form).trigger("inbound_form_complete"); // Trigger custom hook
						jQuery.cookie("wp_lead_id", user_id, { path: '/', expires: 365 });
						jQuery.totalStorage('wp_lead_id', user_id);
						this_form.addClass('lead_processed');
						// Unbind form
						this_form.unbind('submit');
						this_form.submit();
						
						
						jQuery('button, input[type="button"]').css('cursor', 'default');
						jQuery('input').css('cursor', 'default');
						jQuery('body').css('cursor', 'default');
						
						jQuery.totalStorage.deleteItem('page_views'); // remove pageviews
						jQuery.totalStorage.deleteItem('tracking_events'); // remove events
						//jQuery.totalStorage.deleteItem('cta_clicks'); // remove cta
					   },
				error: function(MLHttpRequest, textStatus, errorThrown){
						//alert(MLHttpRequest+' '+errorThrown+' '+textStatus); // debug

					    // Create fallback localstorage object 
						var conversionObj = new Array();
						conversionObj.push({ 
											action: 'inbound_store_lead',
											emailTo: email, 
											first_name: firstname, 
											last_name: lastname,
											wp_lead_uid: wp_lead_uid,
											page_view_count: page_view_count,
											page_views: page_views,
											post_type: inbound_ajax.post_type,
											lp_v: lp_v,
											json: tracking_obj,
											// type: 'form-completion',
											raw_post_values_json : post_values_json,
											lp_id: page_id
											});

						jQuery.totalStorage('failed_conversion', conversionObj); // store failed data
						jQuery.cookie("failed_conversion", true, { path: '/', expires: 365 });
 
						// If fail, cookie form data and ajax submit on next page load
						console.log('ajax fail');
						release_form_sub(this_form);   
						
					}
			});
			

			
		});


	// Fallback for form ajax fails
	var failed_conversion = jQuery.cookie("failed_conversion");
	var fallback_obj = jQuery.totalStorage('failed_conversion');
	
	if (typeof (failed_conversion) != "undefined" && failed_conversion == 'true' ) {
		if (typeof fallback_obj =='object' && fallback_obj)
		{
			//console.log('fallback ran');	
				jQuery.ajax({
					type: 'POST',
					url: inbound_ajax.admin_url,
					data: {
							action: fallback_obj[0].action,
							emailTo: fallback_obj[0].emailTo, 
							first_name: fallback_obj[0].first_name, 
							last_name: fallback_obj[0].last_name,
							wp_lead_uid: fallback_obj[0].wp_lead_uid,
							page_view_count: fallback_obj[0].page_view_count,
							page_views: fallback_obj[0].page_views,
							post_type: fallback_obj[0].post_type,
							lp_v: fallback_obj[0].lp_v,
							json: fallback_obj[0].json, // replace with page_view_obj
							// type: 'form-completion',
							raw_post_values_json : fallback_obj[0].raw_post_values_json,
							lp_id: fallback_obj[0].lp_id
							/* Replace with jquery hook
								do_action('wpl-lead-collection-add-ajax-data'); 
							*/
						},
					success: function(user_id){
						//console.log('Fallback fired');
						jQuery.removeCookie("failed_conversion"); // remove failed cookie	
						jQuery.totalStorage.deleteItem('failed_conversion'); // remove failed data	
						   },
					error: function(MLHttpRequest, textStatus, errorThrown){
							//alert(MLHttpRequest+' '+errorThrown+' '+textStatus);
							//die();
						}

				});
		}
	}

 });