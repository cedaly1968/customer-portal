<?php
/*-------------------------------------------------*/
/*	Localization
/*-------------------------------------------------*/
load_theme_textdomain('meydjer', get_template_directory() . '/lang');

/*-------------------------------------------------*/
/*	Register and load common JavaScripts
/*-------------------------------------------------*/
function ml_register_js() {
	if (!is_admin()) {
		
		//the next 2 lines loads the theme version of jquery (1.6.2)
		/*1*/wp_deregister_script('jquery');
		/*2*/wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js');
		
		wp_register_script('easing', get_template_directory_uri() . '/js/libs/jquery.easing.min.js', 'jquery');
		wp_register_script('superfish', get_template_directory_uri() . '/js/libs/superfish.js', 'jquery');
		wp_register_script('isotope', get_template_directory_uri() . '/js/libs/jquery.isotope.min.js', 'jquery');
		wp_register_script('slides', get_template_directory_uri() . '/js/libs/slides.min.jquery.js', 'jquery');
		wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/libs/jquery.prettyPhoto.js', 'jquery');
		wp_register_script('ml_plugins', get_template_directory_uri() . '/js/plugins.js.php', 'jquery', '1.0');
		wp_register_script('ml_scripts', get_template_directory_uri() . '/js/scripts.js.php', 'jquery', '1.0');
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('easing');
		wp_enqueue_script('superfish');
		wp_enqueue_script('isotope');
		wp_enqueue_script('slides');
		wp_enqueue_script('prettyPhoto');
		wp_enqueue_script('ml_plugins');
		wp_enqueue_script('ml_scripts');
		
	}
	
	/* media uploader for the theme options panel */
	if(is_admin()) {
		wp_register_script('easing', get_template_directory_uri() . '/js/libs/jquery.easing.min.js', 'jquery');
		wp_enqueue_script('easing');
		wp_register_script( 'of-medialibrary-uploader', get_template_directory_uri() .'/admin/js/of-medialibrary-uploader.js', array( 'jquery', 'thickbox' ) );
	}
}
add_action('init', 'ml_register_js');


/*-------------------------------------------------*/
/*	Call Options Framework
/*-------------------------------------------------*/
if ( !function_exists( 'optionsframework_init' ) ) {
	/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */
	if ( STYLESHEETPATH == TEMPLATEPATH ) {
		define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/admin/');
	}
	else {
		define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_stylesheet_directory_uri() . '/admin/');
	}
	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}


/*-------------------------------------------------*/
/*	Minimal Settings
/*-------------------------------------------------*/
/*--- Max Content Width ---*/
if (!isset($content_width)) $content_width = 1920;

/*--- Post and comment RSS feed links to head ---*/
add_theme_support('automatic-feed-links');

/*--- Load single scripts only on single pages ---*/
function ml_single_scripts() {
	if(is_singular()) wp_enqueue_script( 'comment-reply' ); // Visit http://codex.wordpress.org/Migrating_Plugins_and_Themes_to_2.7/Enhanced_Comment_Display for more info
}


/*-------------------------------------------------*/
/*	Custom Login Image
/*-------------------------------------------------*/
function ml_custom_login() {
	/* if you don't have any custom logo, this function will retrieve the theme's logo */
	$theme_logo = get_template_directory_uri() . '/images/light/cookie-logo.png';
	echo '<style type="text/css">'; 
	echo '	#login {margin:0 auto 7em auto;}';
	echo '	h1 a {';
	echo '		background:url('.of_get_option('ml_login_image', $theme_logo).') no-repeat center bottom;';
	echo '		height:145px;';
	echo '		margin:20px auto;';
	echo '		padding:0 8px;';
	echo '		width:310px;';
	echo '	}';
	echo '</style>';
}
add_action('login_head', 'ml_custom_login');


/*-------------------------------------------------*/
/*	Main Menu
/*-------------------------------------------------*/
function register_my_menus() {

	register_nav_menus(
	
		array(	'main-menu' => __('Main Menu','meydjer') )
	
	);

}

add_action( 'init', 'register_my_menus' );


/*-------------------------------------------------*/
/*	Thumbnails
/*-------------------------------------------------*/

add_theme_support( 'post-thumbnails' );



/*-------------------------------------------------*/
/*	Excerpts
/*-------------------------------------------------*/

function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

function new_excerpt_length($length) {
global $post;
/* Standard excerpt */
return 40;
}
add_filter('excerpt_length', 'new_excerpt_length');

//custom excerpt length functions
function ml_custom_excerpt($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit) {
	  array_pop($words);
	  $words = str_replace('...','',$words);
	  return implode(' ', $words).'...';
  } else {
	  return implode(' ', $words);  
  }
}

?>