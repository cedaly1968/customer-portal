<?php
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
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {

	$shortname = 'ml_';
	
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
	$imagepath =  get_stylesheet_directory_uri() . '/admin/images/';
		
	$options = array();
		
	/*-------------------------------------------------*/
	/*	Welcome
	/*-------------------------------------------------*/
	$options[] = array( "name" => __('Portfolio', 'meydjer'),
						"type" => "heading");
							
	$options[] = array( "name" => __('Welcome', 'meydjer'),
						"desc" => "",
						"class" => "of_headline",
						"type" => "info");
											
	$options[] = array( "name" => __('Welcome Image', 'meydjer'),
						"desc" => __('Maximum size: 640x400', 'meydjer'),
						"id" => $shortname . "welcome_image",
						"std" => get_template_directory_uri().'/images/demo/welcome_image.png',
						"type" => "upload");
						
	$options[] = array( "name" => __('Animation Time', 'meydjer'),
						"desc" => __('In Seconds. Default: 5.4', 'meydjer'),
						"id" => $shortname . "animation_time",
						"std" => "5.4",
						"class" => "micro",
						"type" => "text");
						
	$options[] = array( "name" => __('Animation Effect', 'meydjer'),
						"desc" => __('When your welcome image appear.', 'meydjer'),
						"id" => $shortname . "animation_effect",
						"std" => "easeOutBack",
						"type" => "select",
						"class" => "mini",
						"options" => array(
							
							"easeOutBack" => "Back",
							"easeOutBounce" => "Bounce",
							"easeOutCirc" => "Circ",
							"easeOutCubic" => "Cubic",
							"easeOutElastic" => "Elastic",
							"easeOutExpo" => "Expo",
							"easeOutQuad" => "Quad",
							"easeOutQuart" => "Quart",
							"easeOutQuint" => "Quint",
							"easeOutSine" => "Sine"
							
						));

	$options[] = array( "name" => __('Animation Demo', 'meydjer'),
						"desc" => __('Change the effect above and see me coming alive. :)', 'meydjer'),
						"class" => $shortname . "animation_demo",
						"type" => "info");


	$options[] = array( "name" => __('Layout', 'meydjer'),
						"desc" => "",
						"class" => "of_headline",
						"type" => "info");
											
	$options[] = array( "name" => __('Portfolio Layout', 'meydjer'),
						"id" => $shortname . "portfolio_layout",
						"std" => "right",
						"type" => "images",
						"options" => array(
							'left' => $imagepath . '2cl.png',
							'right' => $imagepath . '2cr.png')
						);

	$options[] = array( "name" => __('Ajaxified Portfolio', 'meydjer'),
						"desc" => __('Uncheck if you don\'t like AJAX.', 'meydjer'),
						"id" => $shortname . "ajax_portfolio",
						"std" => "1",
						"type" => "checkbox");
												
	$options[] = array( "name" => __('Show Like Hearts', 'meydjer'),
						"desc" => __('Display heart icons bellow each portfolio item thumbnail.', 'meydjer'),
						"id" => $shortname . "show_like_hearts",
						"std" => "1",
						"type" => "checkbox");
												
	$options[] = array( "name" => __('Show Latest Posts', 'meydjer'),
						"desc" => __('Check if you want to show your latest blog posts.', 'meydjer'),
						"id" => $shortname . "show_latest_posts",
						"std" => "0",
						"type" => "checkbox");
												
	$options[] = array( "name" => __('Show Footer', 'meydjer'),
						"desc" => __('Show footer columns in your portfolio.', 'meydjer'),
						"id" => $shortname . "show_footer",
						"std" => "0",
						"type" => "checkbox");
												

								
	/*-------------------------------------------------*/
	/*	General
	/*-------------------------------------------------*/	
	$options[] = array( "name" => __('General', 'meydjer'),
						"type" => "heading");
							
	$options[] = array( "name" => __('Brand', 'meydjer'),
						"desc" => "",
						"class" => "of_headline",
						"type" => "info");
											
	$options[] = array( "name" => __('Text Logo', 'meydjer'),
						"desc" => __('No images, please. Just the website name.', 'meydjer'),
						"id" => $shortname . "text_logo",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => __('Logo Image', 'meydjer'),
						"id" => $shortname . "website_logo",
						"std" => get_template_directory_uri().'/images/light/cookie-logo.png',
						"type" => "upload");
						
	$options[] = array( "name" => __('Favicon', 'meydjer'),
						"desc" => __('16x16 pixels. .ico format.', 'meydjer'),
						"id" => $shortname . "icon_favicon",
						"class" => "last_option",
						"type" => "upload");

						
	$options[] = array( "name" => __('Info', 'meydjer'),
						"desc" => "",
						"class" => "of_headline",
						"type" => "info");
											
	$options[] = array( "name" => __('Footer Copy', 'meydjer'),
						"desc" => __('Tip: Use "&amp;copy;" (without quotes) to generate the &copy; symbol.', 'meydjer'),
						"id" => $shortname . "footer_copy",
						"std" => '&copy; Copyright 2011 Cookie <a href="http://wordpress.org/">WordPress</a> Theme.',
						"type" => "textarea"); 
						
	$options[] = array( "name" => __('Social', 'meydjer'),
						"desc" => __('Your social media links.', 'meydjer'),
						"id" => $shortname . "footer_social",
						"std" => 'Keep in touch: <a href="http://twitter.com/meydjer">Twitter</a>, <a href="http://dribbble.com/meydjer">Dribbble</a>, <a href="https://plus.google.com/110141112835304053696">Google+</a>.',
						"type" => "textarea"); 
						
								

	/*-------------------------------------------------*/
	/*	Styling
	/*-------------------------------------------------*/	
	$options[] = array( "name" => __('Styling', 'meydjer'),
						"type" => "heading");

	$options[] = array( "name" => __('Structure', 'meydjer'),
						"desc" => "",
						"class" => "of_headline",
						"type" => "info");
											
	$options[] = array( "name" => __('Header Logo Align', 'meydjer'),
						"id" => $shortname . "header_align",
						"std" => "left",
						"type" => "images",
						"options" => array(
							'left' => $imagepath . 'header-left.png',
							'right' => $imagepath . 'header-right.png'
							)
						);

	$options[] = array( "name" => __('Sidebar', 'meydjer'),
						"id" => $shortname . "sidebar",
						"std" => "right",
						"type" => "images",
						"options" => array(
							'left' => $imagepath . '2cl.png',
							'right' => $imagepath . '2cr.png')
						);
						
	$options[] = array( "name" => __('Footer Columns', 'meydjer'),
						"id" => $shortname . "footer_columns",
						"std" => "0",
						"type" => "images",
						"class" => "last_option",
						"options" => array(
							'1' => $imagepath . 'footer-1col.gif',
							'2' => $imagepath . 'footer-2cols.gif',
							'3' => $imagepath . 'footer-3cols.gif',
							'4' => $imagepath . 'footer-4cols.gif',
							'0' => $imagepath . 'footer-no.gif'
							)
						);

	$options[] = array( "name" => __('Visual', 'meydjer'),
						"desc" => "",
						"class" => "of_headline",
						"type" => "info");
											
	$options[] = array( "name" => __('Main Color', 'meydjer'),
						"id" => $shortname . "main_color",
						"std" => "#f23b8d",
						"type" => "color");
						
	$options[] = array( "name" => __('Body Background', 'meydjer'),
						"id" => $shortname . "body_background",
						"std" => array(
							'color' => '#f2f4f5',
							'image' => get_template_directory_uri().'/images/light/pattern-body.jpg',
							'repeat' => 'repeat',
							'position' => 'top center',
							'attachment'=>'scroll'
							),
						"type" => "background");
								
	$options[] = array( "name" => __('Header Background', 'meydjer'),
						"id" => $shortname . "header_background",
						"std" => array(
							'color' => '#414345',
							'image' => get_template_directory_uri().'/images/light/pattern-header.jpg',
							'repeat' => 'repeat',
							'position' => 'top center',
							'attachment'=>'scroll'
							),
						"type" => "background");
								
	$options[] = array( "name" => __('Disable White Shadows', 'meydjer'),
						"desc" => __('If you are using a dark background in the body, I recommend you to check this to disable white shadows from inputs, textareas and buttons.', 'meydjer'),
						"id" => $shortname . "disable_white_shadows",
						"std" => "0",
						"class" => "last_option",
						"type" => "checkbox");
						
	$options[] = array( "name" => __('Typography', 'meydjer'),
						"desc" => "",
						"class" => "of_headline",
						"type" => "info");
											
	$options[] = array( "name" => __('Header Menu Typography', 'meydjer'),
						"desc" => __('For the main menu', 'meydjer'),
						"id" => $shortname . "header_typo",
						"std" => array('size' => '12px','face' => 'helvetica','style' => 'normal','color' => '#edeff0'),
						"type" => "typography");			

	$options[] = array( "name" => __('Header Menu Active Color', 'meydjer'),
						"id" => $shortname . "header_active",
						"std" => "#f166ac",
						"type" => "color");
						
	$options[] = array( "name" => __('Body Typography', 'meydjer'),
						"id" => $shortname . "body_typo",
						"std" => array('size' => '12px','face' => 'helvetica','style' => 'normal','color' => '#3f4547'),
						"type" => "typography");			

	$options[] = array( "name" => __('Google Web Font API Link', 'meydjer'),
						"desc" => __('Copy your font link from <a href="http://www.google.com/webfonts" target="_blank">google.com/webfonts</a>. (e.g. &lt;link href=\'http://fonts.googleapis.com/css?family=Rokkit\' rel=\'stylesheet\' type=\'text/css\'>)', 'meydjer'),
						"id" => $shortname . "google_font_link",
						"std" => "<link href='http://fonts.googleapis.com/css?family=Rokkit' rel='stylesheet' type='text/css'>",
						"type" => "html");

	$options[] = array( "name" => __('Google Web Font CSS Keyword', 'meydjer'),
						"desc" => __('The Font Family CSS keyword. E.g. If google says your Integrate CSS code is "font-family: "Open Sans Condensed", sans-serif;", paste the "Open Sans Condensed" keyword (without quotes).', 'meydjer'),
						"id" => $shortname . "google_font_css_key",
						"std" => "Rokkit",
						"type" => "text");

	$options[] = array( "name" => __('Google Web Font Text Transform', 'meydjer'),
						"id" => $shortname . "google_font_text_transform",
						"type" => "select",
						"std" => "uppercase",
						"options" => array(
												"none" => __('None', 'meydjer'),
												"capitalize" => __('Capitalize', 'meydjer'),
												"lowercase" => __('Lowercase', 'meydjer'),
												"uppercase" => __('Uppercase', 'meydjer')
												));
	
	$options[] = array( "name" => __('Apply Google Web Font To...', 'meydjer'),
						"desc" => __('The CSS tags that you want to apply google web font. Default: h1, h2, h3, h4, .sf-menu a, .nav-prev, .nav-next, .ml_portfolio-categories, .ml_comment-author, .ml_comment-reply, button, .ml_button, .wpcf7-submit, .input[type=submit]', 'meydjer'),
						"id" => $shortname . "apply_google_font_to",
						"std" => "h1, h2, h3, h4, .sf-menu a, .nav-prev, .nav-next, .ml_portfolio-categories, .ml_comment-author, .ml_comment-reply, button, .ml_button, .wpcf7-submit, .input[type=submit]",
						"type" => "text");



	/*-------------------------------------------------*/
	/*	Other
	/*-------------------------------------------------*/	
	$options[] = array( "name" => __('Other', 'meydjer'),
						"type" => "heading");
							
	$options[] = array( "name" => __('Extra', 'meydjer'),
						"desc" => "",
						"class" => "of_headline",
						"type" => "info");
											
	$options[] = array( "name" => __('Custom CSS', 'meydjer'),
						"desc" => __('Add your CSS code easily.', 'meydjer'),
						"id" => $shortname . "custom_css",
						"type" => "textarea"); 

	$options[] = array( "name" => __('Tracking/JavaScript Code', 'meydjer'),
						"desc" => __('Put your Google Analytics (or any other) and Custom Javascript/jQuery code here.', 'meydjer'),
						"id" => $shortname . "custom_js",
						"type" => "textarea"); 

	$options[] = array( "name" => __('Custom Login Image', 'meydjer'),
						"desc" => __('Customize the image of your login screen. (Maximum Size: 310x145 pixels.)', 'meydjer'),
						"id" => $shortname . "login_image",
						"type" => "upload");



	return $options;
}



function optionsframework_custom_scripts() { ?>
	
	
	
	<script type="text/javascript">
	
	jQuery(document).ready(function() {
	
		
		jQuery('#ml_animation_effect').change(function() {
		
			var effectValue = jQuery(this).val();

			jQuery('.ml_animation_demo p').animate(
		
				{marginTop: '130px'},
				1200,
				effectValue,
				function(){
				
					jQuery('.ml_animation_demo p').delay(600).animate(
				
						{marginTop: '0'},
						600,
						'easeInOutQuad'
										
					)
				
				}
		
			)

		});

		
	});
		
	</script>
	
	<style type="text/css">
	
	.ml_animation_demo {
		height: 225px;
	}
	
	.ml_animation_demo h4 {
		color: #d54e21;
	}
	
	.ml_animation_demo p {
		background-color: #f9f9f9;
		box-shadow: 1px 1px 1px rgba(0,0,0,.06);
			-moz-box-shadow: 1px 1px 1px rgba(0,0,0,.06);
			-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.06);
		border: 1px solid #d4d5d6;
		border-radius: 2px;
			-moz-border-radius: 2px;
			-webkit-border-radius: 2px;
		padding: 10px 10px 0;
		text-align: center;
	}
	
	#optionsframework .of_headline h4 {
		background-color: #f9f9f9;
		box-shadow: 1px 1px 1px rgba(0,0,0,.06);
			-moz-box-shadow: 1px 1px 1px rgba(0,0,0,.06);
			-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.06);
		border: 1px solid #d4d5d6;
		border-radius: 2px;
			-moz-border-radius: 2px;
			-webkit-border-radius: 2px;
		color: #d54e21;
		font: 23px "HelveticaNeue-Light","Helvetica Neue Light","Helvetica Neue",sans-serif;
		margin: 20px 0 0 !important;
		padding-left: 12px !important;
		text-align: center;
		text-shadow: rgba(255, 255, 255, 1) 0 1px 0;
	}
	
	.last_option {
		margin-bottom: 80px;
	}
	
	</style>
	
	
	
<?php }


add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');



?>