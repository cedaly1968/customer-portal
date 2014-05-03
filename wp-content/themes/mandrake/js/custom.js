// Mandrake JavaScript Document

// Zebra Table
jQuery(document).ready(function(){
	jQuery("tr:odd").addClass("odd");
	jQuery("tr:even").addClass("even");
});

// Image zoom hover
jQuery(document).ready(function(){
	jQuery("a").live("mouseenter", function() {
		jQuery(".zoom-image", this).fadeTo(400, 0.5);
		jQuery(".zoom-document", this).fadeTo(400, 0.5);
		jQuery(".zoom-video", this).fadeTo(400, 0.5);
	}).live("mouseleave", function() {
		jQuery(".zoom-image", this).fadeOut(400);
		jQuery(".zoom-document", this).fadeOut(400);
		jQuery(".zoom-video", this).fadeOut(400);
	});
});

// Lightbox
jQuery(document).ready(function(){
	jQuery(".lightbox").colorbox({opacity:0.85, current:"{current} of {total}"});
	jQuery(".videobox").colorbox({opacity:0.85, innerWidth:640, innerHeight:390, iframe:true, current:"{current} of {total}"});
});

// Toggle list
jQuery(document).ready(function() {
	jQuery('.toggle-content').hide();
	jQuery('.toggle-item .toggle-title').live('click', function(event) {
		event.preventDefault();
		jQuery(this).next('.toggle-content').slideToggle();
		jQuery(this).toggleClass('selected');
	});
});

// Tabbed box
jQuery(document).ready(function() {
	jQuery(".tabbed-box").each(function(i) {
		jQuery(".pane", this).hide();
		jQuery(".tabbed-menu li:first", this).addClass("selected").show();
		jQuery(".pane:first", this).show();
	});
	jQuery(".tabbed-box .tabbed-menu a").live("click", function(event) {
		event.preventDefault();
	});
	jQuery(".tabbed-box .tabbed-menu li").live("click", function() {
		jQuery(this).parent().find("a").each(function(i) {
			jQuery(this).addClass('tab' + i);
		});
		jQuery(this).parent().parent().parent().find(".pane").each(function(i) {
			jQuery(this).addClass('tab' + i);
		});
		jQuery(this).parent().children().removeClass("selected");
		jQuery(this).addClass("selected");
		jQuery(this).parent().parent().parent().find(".pane").hide();
		var selectedTab = jQuery(this).find("a").attr("class");
		jQuery(this).parent().parent().parent().find("." + selectedTab).fadeIn();
		return false;
	});
});

// Accordion
jQuery(document).ready(function() {
	jQuery(".accordion").each(function(i) {
		jQuery(".accordion-content", this).hide();
		jQuery(".accordion-tab:first", this).addClass("selected").show();
		jQuery(".accordion-content:first", this).show();
	});
	jQuery(".accordion .accordion-tab a").live("click", function(event) {
		event.preventDefault();
	});
	jQuery(".accordion .accordion-tab").live("click", function() {
		jQuery(this).parent().find(".accordion-tab").each(function(i) {
			jQuery(this).addClass('accordion' + i);
		});
		jQuery(this).parent().find(".accordion-content").each(function(i) {
			jQuery(this).addClass('accordion' + i);
		});
		jQuery(this).parent().children().removeClass("selected");
		jQuery(this).addClass("selected");
		jQuery(this).parent().find(".accordion-content").hide();
		jQuery(this).next().fadeIn();
		return false;
	});
});

// Expand box
jQuery(document).ready(function() {
	jQuery(".expand-box").each(function(i) {
		jQuery(".expand-content", this).hide();
	});
	jQuery(".expand-box .expand-tab a").live("click", function(event) {
		event.preventDefault();
	});
	jQuery(".expand-box .expand-tab").live("click", function() {
		jQuery(this).toggleClass("selected");
		jQuery(this).next().slideToggle();
		return false;
	});
});

// Portfolio Slider
jQuery(document).ready(function(){
	jQuery('#portfolio-slider .portfolio-panel').carouFredSel({
		prev: {
			button: '#portfolio-prev',
			easing: 'easeInOutCubic',
			duration: 1000
		},
		next: {
			button: '#portfolio-next',
			easing: 'easeInOutCubic',
			duration: 1000
		},
		auto: false
	});
});

// Portfolio sorting
jQuery(document).ready(function(){
	var $data = jQuery(".portfolio-list").clone();
	jQuery(".portfolio-filter a").live("click", function(event) {
		event.preventDefault();
		jQuery(".portfolio-filter a").removeClass("active").addClass("white");
		jQuery(this).removeClass("white").addClass("active");
		var filterClass=jQuery(this).attr("data-value");
		if (filterClass == "all") {
			var $filteredData = $data.find(".portfolio-item");
		} else {
			var $filteredData = $data.find(".portfolio-item[data-type=" + filterClass + "]");
		}
		jQuery(".portfolio-list").quicksand($filteredData, {
			duration: 800,
			easing: "easeInOutQuad",
			enhancement: function() {
				jQuery(".portfolio-item img").show();
				jQuery(".lightbox").colorbox({opacity:0.85, current:"{current} of {total}"});
				jQuery(".videobox").colorbox({opacity:0.85, innerWidth:640, innerHeight:390, iframe:true, current:"{current} of {total}"});
			}
		});
		return false;
	});
});

// Testimonials widget
jQuery(document).ready(function() {
	jQuery(".widget_testimonials .blockquote li").each(function(i) {
		jQuery(this).hide();
		jQuery(this).parent().parent().find(".navigation a:first").addClass("selected").show();
		jQuery(this).parent().find("li:first").show();
	});
	jQuery(".widget_testimonials .navigation a").live("click", function(event) {
		event.preventDefault();
		jQuery(this).parent().find("a").each(function(i) {
			jQuery(this).addClass('tab' + i);
		});
		jQuery(this).parent().parent().find(".blockquote li").each(function(i) {
			jQuery(this).addClass('tab' + i);
		});
		jQuery(this).parent().children().removeClass("selected");
		jQuery(this).parent().parent().find(".blockquote li").hide();
		var selectedTab = jQuery(this).attr("class");
		jQuery(this).addClass("selected");
		jQuery(this).parent().parent().find(".blockquote ." + selectedTab).fadeIn();
		return false;
	});
});

// Form input focus
jQuery(document).ready(function(){
	var searchText = jQuery(".search-input").val();
	jQuery(".search-input").focus(function () { 
         this.value = "";
    }).focusout(function() {
		if (this.value == "") {
			this.value = searchText;
		}
	});
});

//IE8-7 button and link :active bug fixes
jQuery(document).ready(function() {
    jQuery.each(jQuery.browser, function(i, val) {
		if (jQuery.browser.msie) {
			if (parseInt(val) >= 7 && parseInt(val) < 9) {
				//Fixes link :active state bug
				jQuery('a.button').mousedown(function() {
					jQuery(this).addClass('current');
					jQuery(this).bind('mouseenter',function(){
					}).bind('mouseleave',function(){
						jQuery(this).removeClass('current');
					});
				}).mouseup(function(){
					jQuery(this).removeClass('current');
				});
				if (parseInt(val) == 7) {
					//Fixes button :active state bug
					jQuery('button.button').mousedown(function() {
						jQuery(this).addClass('current');
						jQuery(this).bind('mouseenter',function(){
						}).bind('mouseleave',function(){
							jQuery(this).removeClass('current');
						});
					}).mouseup(function(){
						jQuery(this).removeClass('current');
					});
				}
			}
		}
	});
});

// Contact Form submit
jQuery(document).ready(function(){
	jQuery('.contact-form').submit(function(event){
		event.preventDefault();
		
		var nameToVal = jQuery('.contact-name', this).val();
		var emailToVal = jQuery('.contact-email', this).val();
		var messageToVal = jQuery('.contact-message', this).val();
		var contactToVal = jQuery('.contact-to', this).val();
		
		var hasError = false;
		var blankReg = /\S/;
		var emailReg = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
		
		// Message
		if(!blankReg.test(messageToVal)) {
			jQuery('.contact-message', this).addClass('invalid').focus();
			hasError = true;
		} else {
			jQuery('.contact-message', this).removeClass('invalid');
		}
		// E-mail
		if(!blankReg.test(emailToVal) || !emailReg.test(emailToVal)) {
			jQuery('.contact-email', this).addClass('invalid').focus();
			hasError = true;
		} else {
			jQuery('.contact-email', this).removeClass('invalid');
		}
		// Name
		if(!blankReg.test(nameToVal)) {
			jQuery('.contact-name', this).addClass('invalid').focus();
			hasError = true;
		} else {
			jQuery('.contact-name', this).removeClass('invalid');
		}
		
		if (hasError == false) {
			var form = jQuery(this);				
			jQuery.post(this.action,{ 
				'contact_to':jQuery('input[name="contact_to"]').val(),
				'contact_name':jQuery('input[name="contact_name"]').val(),
				'contact_email':jQuery('input[name="contact_email"]').val(),
				'contact_message':jQuery('textarea[name="contact_message"]').val()
			},function(data){	
				form.fadeOut('fast', function() {
					form.parent().find('.contact-success').show();
				});
			});
		}
		return false;
	});						   
});