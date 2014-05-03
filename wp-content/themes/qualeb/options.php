<?php
/**
 * This file stores all the options found in the options panel.
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
 
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	$qua_skin = array("light" => "Light","dark" => "Dark");
	$qua_hide_blogcomments = array("yes" => "Yes","no" => "No");
	$qua_hide_pagecomments = array("yes" => "Yes","no" => "No");
	
	$slink1 = of_get_option('slink1_name', 'link 1' );
	if ($slink1 == ""){
		$slink1 = "link 1";
	}
	$slink2 = of_get_option('slink2_name', 'link 2' );
	if ($slink2 == ""){
		$slink2 = "link 2";
	}
	$slink3 = of_get_option('slink3_name', 'link 3' );
	if ($slink3 == ""){
		$slink3 = "link 3";
	}
	$slink4 = of_get_option('slink4_name', 'link 4' );
	if ($slink4 == ""){
		$slink4 = "link 4";
	}
	$slink5 = of_get_option('slink5_name', 'link 5' );
	if ($slink5 == ""){
		$slink5 = "link 5";
	}
	$slink6 = of_get_option('slink6_name', 'link 6' );
	if ($slink6 == ""){
		$slink6 = "link 6";
	}
	$slink7 = of_get_option('slink7_name', 'link 7' );
	if ($slink7 == ""){
		$slink7 = "link 7";
	}
	$slink8 = of_get_option('slink8_name', 'link 8' );
	if ($slink8 == ""){
		$slink8 = "link 8";
	}
	
	// Social Links 
	$slinks_show = array("one" => $slink1, "two" => $slink2, "three" => $slink3,"four" => $slink4, "five" => $slink5,
	"six" => $slink6, "seven" => $slink7, "eight" => $slink8 );
	
	
	
	
	// Slider Options Arrays
	$tyfn = array("true" => "Yes","false" => "No");
	$truefalse = array("true" => "True","false" => "False");
	$qua_fwidgets = array("yes" => "Yes","no" => "No");
	$slider_anim = array("fade" => "Fade","slide" => "Slide");
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
		
	// GENERAL
	$options[] = array( "name" => "General Settings",
						"type" => "heading");
							
	$options[] = array( "name" => "Skin",
						"desc" => "Light or Dark skin",
						"id" => "qua_skin",
						"std" => "light",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $qua_skin);	
								
	$options[] = array( "name" => "Main Color",
						"desc" => "Main Theme color.",
						"id" => "qua_color",
						"std" => "",
						"type" => "color");
							
	$options[] = array( "name" => "Logo (Header)",
						"desc" => "Logo for the header area.",
						"id" => "qua_logo",
						"type" => "upload");
								 
	$options[] = array( "name" => "Logo (Footer)",
						"desc" => "Logo for the footer area.",
						"id" => "qua_footer_logo",
						"type" => "upload");
					

	// SLIDER
	$options[] = array( "name" => "Slider Settings",
						"type" => "heading");
	
	$options[] = array( "name" => "Animation",
						"desc" => "Select your animation type",
						"id" => "qua_slider_animation",
						"std" => "fade",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => $slider_anim);
						
	$options[] = array( "name" => "Slideshow",
						"desc" => "Should the slider animate automatically by default?",
						"id" => "qua_slider_slideshow",
						"std" => "true",
						"type" => "radio",
						"options" => $tyfn);	

	$options[] = array( "name" => "Slideshow Speed",
						"desc" => "Set the speed of the slideshow cycling, in milliseconds.",
						"id" => "qua_slider_speed",
						"std" => "5000",
						"class" => "mini",
						"type" => "text");
						
	$options[] = array( "name" => "Animation Duration",
						"desc" => "Set the speed of animations, in milliseconds.",
						"id" => "qua_slider_duration",
						"std" => "600",
						"class" => "mini",
						"type" => "text");
						
	$options[] = array( "name" => "Direction Nav",
						"desc" => "Create navigation for previous/next navigation?",
						"id" => "qua_slider_direction",
						"std" => "true",
						"type" => "radio",
						"options" => $truefalse);
						
	$options[] = array( "name" => "Control Nav",
						"desc" => "Create navigation for paging control of each slide?",
						"id" => "qua_slider_control",
						"std" => "true",
						"type" => "radio",
						"options" => $truefalse);			
						
	// CONTENT
	$options[] = array( "name" => "Content",
						"type" => "heading");
	
	$options[] = array( "name" => "Show Footer Widgets",
						"desc" => "The displaying of widgets in the footer area, in all pages.",
						"id" => "qua_fwidgets",
						"std" => "no",
						"type" => "radio",
						"options" => $qua_fwidgets);
						
	$options[] = array( "name" => "Copyright Information",
						"desc" => "Copyright Information displayed in footer.",
						"id" => "qua_copyright",
						"std" => "Copyright",
						"class" => "",
						"type" => "textarea");
											
	$options[] = array( "name" => "Portfolio Index Page",
						"desc" => "Select your portfolio Index Page. This page will be linked to from the portfolio items pages.",
						"id" => "qua_portfolio_index",
						"type" => "select",
						"options" => $options_pages);
						
	$options[] = array( "name" => "Blog Index Page",
						"desc" => "Select your blog Index Page. ",
						"id" => "qua_blog_index",
						"type" => "select",
						"options" => $options_pages);
						
	$options[] = array( "name" => "Posts per page",
						"desc" => "Number of blog posts shown per page.",
						"id" => "qua_posts_perpage",
						"std" => "4",
						"class" => "",
						"type" => "text");
	
	$options[] = array( "name" => "Hide Comments (Blog articles)",
						"desc" => "Hide comments in all blog articles.",
						"id" => "qua_hide_blogcomments",
						"std" => "no",
						"type" => "radio",
						"options" => $qua_hide_blogcomments);
						
	$options[] = array( "name" => "Hide Comments (Pages)",
						"desc" => "Hide comments in all pages.",
						"id" => "qua_hide_pagecomments",
						"std" => "yes",
						"type" => "radio",
						"options" => $qua_hide_pagecomments);
						
	// CONTENT
	$options[] = array( "name" => "Contact",
						"type" => "heading");
						
	$options[] = array( "name" => "Receiving Email Address",
						"desc" => "The E-mail address which will be receiving the emails sent through the contact form.",
						"id" => "qua_contact_email",
						"std" => "youremail@site.com",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Email Subject",
						"desc" => "The subject of the emails you will receive from your contact form.",
						"id" => "qua_contact_subject",
						"std" => "Subject Line",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Success Message",
						"desc" => "The message that will appear once the user submits the form.",
						"id" => "qua_contact_success",
						"std" => "Thanks! Your request has been sent.",
						"class" => "",
						"type" => "textarea");
						
	// SOCIAL LINKS
	$options[] = array( "name" => "Social Links",
						"type" => "heading");
	
	$options[] = array( "name" => "Show",
						"desc" => "Select the links you wish to show.",
						"id" => "slinks_show",
						"std" => "", // These items get checked by default
						"type" => "multicheck",
						"options" => $slinks_show);
						
	$options[] = array( "name" => "Link 1",
						"type" => "smallheading",
						"class" => "smallheading");
						
	$options[] = array( "name" => "Name",
						"desc" => "(ex: Facebook, Vimeo)",
						"id" => "slink1_name",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Link ",
						"desc" => "Full link (http://)",
						"id" => "slink1_link",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Hover Color",
						"desc" => "",
						"id" => "slink1_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Link 2",
						"type" => "smallheading",
						"class" => "smallheading");
						
	$options[] = array( "name" => "Name",
						"desc" => "(ex: Facebook, Vimeo)",
						"id" => "slink2_name",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Link ",
						"desc" => "Full link (http://)",
						"id" => "slink2_link",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Hover Color",
						"desc" => "",
						"id" => "slink2_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Link 3",
						"type" => "smallheading",
						"class" => "smallheading");
						
	$options[] = array( "name" => "Name",
						"desc" => "(ex: Facebook, Vimeo)",
						"id" => "slink3_name",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Link ",
						"desc" => "Full link (http://)",
						"id" => "slink3_link",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Hover Color",
						"desc" => "",
						"id" => "slink3_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Link 4",
						"type" => "smallheading",
						"class" => "smallheading");
						
	$options[] = array( "name" => "Name",
						"desc" => "(ex: Facebook, Vimeo)",
						"id" => "slink4_name",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Link ",
						"desc" => "Full link (http://)",
						"id" => "slink4_link",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Hover Color",
						"desc" => "",
						"id" => "slink4_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Link 5",
						"type" => "smallheading",
						"class" => "smallheading");
						
	$options[] = array( "name" => "Name",
						"desc" => "(ex: Facebook, Vimeo)",
						"id" => "slink5_name",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Link ",
						"desc" => "Full link (http://)",
						"id" => "slink5_link",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Hover Color",
						"desc" => "",
						"id" => "slink5_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Link 6",
						"type" => "smallheading",
						"class" => "smallheading");
						
	$options[] = array( "name" => "Name",
						"desc" => "(ex: Facebook, Vimeo)",
						"id" => "slink6_name",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Link ",
						"desc" => "Full link (http://)",
						"id" => "slink6_link",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Hover Color",
						"desc" => "",
						"id" => "slink6_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Link 7",
						"type" => "smallheading",
						"class" => "smallheading");
						
	$options[] = array( "name" => "Name",
						"desc" => "(ex: Facebook, Vimeo)",
						"id" => "slink7_name",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Link ",
						"desc" => "Full link (http://)",
						"id" => "slink7_link",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Hover Color",
						"desc" => "",
						"id" => "slink7_color",
						"std" => "",
						"type" => "color");
						
	$options[] = array( "name" => "Link 8",
						"type" => "smallheading",
						"class" => "smallheading");
						
	$options[] = array( "name" => "Name",
						"desc" => "(ex: Facebook, Vimeo)",
						"id" => "slink8_name",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Link ",
						"desc" => "Full link (http://)",
						"id" => "slink8_link",
						"std" => "",
						"class" => "",
						"type" => "text");
						
	$options[] = array( "name" => "Hover Color",
						"desc" => "",
						"id" => "slink8_color",
						"std" => "",
						"type" => "color");

						
						
		
	return $options;
}