<?php

/*--- Logo ---*/
if(of_get_option('ml_text_logo')) {

	$logo = '<h1 class="ml_text_logo">'.get_bloginfo('name').'</h1>';
	
	$logo_type = 'has_text_logo';

} else if (of_get_option('ml_website_logo')) {

	$logo = '<img src="'.of_get_option('ml_website_logo').'" alt="'.get_bloginfo('name').'" />';
	
	$logo_type = 'has_image_logo';
	
} else {

	$logo = '<img src="'.get_template_directory_uri().'/images/light/cookie-logo.png" alt="'.get_bloginfo('name').'" />';
	
	$logo_type = 'has_image_logo';
	
}


/*--- Favicon ---*/
$favicon = '';
if (of_get_option('ml_icon_favicon')) {

	$favicon = '<link rel="shortcut icon" href="'.of_get_option('ml_icon_favicon').'">';

}



/*--- Google Font ---*/
$google_font_link = of_get_option('ml_google_font_link','<link href=\'http://fonts.googleapis.com/css?family=Oswald\' rel=\'stylesheet\' type=\'text/css\'>');

?>



<!doctype html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->

<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->

<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->

<!--[if IE 9]>    <html class="no-js ie9 oldie" lang="en"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<html <?php language_attributes(); ?>>

<head>

	<meta charset="utf-8">

	<title><?php wp_title('-', true, 'right'); ?><?php bloginfo('name'); ?></title>

	<meta name="description" content="<?php bloginfo('description'); ?>">

	<meta name="author" content="">

	<meta name="viewport" content="width=device-width,initial-scale=1">

	<?php echo $favicon; ?>

	<?php echo $google_font_link; ?>

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/prettyPhoto.css">

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/html5boilerplate.css">

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom_options.css.php">
	
	<?php if(is_page_template('template-portfolio.php')) { ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/portfolio.css.php">
	<?php } ?>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

	<!--[if lt IE 9]>

		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

	<![endif]-->

	<?php wp_head(); ?>
	
	<?php /* if(is_page_template('template-portfolio.php')) {
		
	    get_template_part('includes/like-cookies');
	
	} */ ?>

</head>



<body <?php body_class(); ?>>
	
	
	
	<div id="ml_top_border"></div>
	
	
	
	<div id="ml_wrapper">
	
		<header id="ml_header" class="ml_welcome_hide <?php echo $logo_type ?>">
		
			<a href="<?php echo home_url(); ?>" class="ml_header_main_logo">

				<?php echo $logo; ?>

			</a>

			<?php
			
			/* Custom menu (Main Menu) */
			
			if ( has_nav_menu( 'main-menu' ) )
	
			{
	
				wp_nav_menu( array(	'theme_location' => 'main-menu',
									'container' => false,
									'menu_class' => 'sf-menu' ) );
	
			} ?>
			


		</header>