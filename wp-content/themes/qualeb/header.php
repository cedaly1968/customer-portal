<?php
/**
 * The Header for Qualeb theme.
 *
 * Displays the Head, the logo and the Navigation
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]> <html id="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]> <html id="ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html id="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<!-- Meta Tags -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
	
	<!-- Title -->
	<title><?php
		global $page, $paged;
		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'demagician' ), max( $paged, $page ) );
		?>
	</title>
	 
	<!-- XFN and Pingback -->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- StyleSheet -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic,bold,bolditalic" type="text/css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/<?php echo of_get_option('qua_skin', 'light'); ?>.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/color.php" />
	
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/library/js/modernizr-1.7.min.js" type="text/javascript"></script>
	<![endif]-->
    
	<!--[if lte IE 7]>
	<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/ie7.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/library/js/DD_belatedPNG.js"></script>
	<script type="text/javascript">
		DD_belatedPNG.fix('div.portfolio-hover, #psingle-nav a, .flex-control-nav li a, div.home-portfolio-hover, .flex-direction-nav li a');
	</script>
	<![endif]-->
    
    
    <?php 
	if (is_page_template( 'home-portfolio.php' ) || is_page_template( 'archive-portfolio.php' ) ) {
	?>
    <!-- Fixes the disappearing browser scrollbar, when we don't have too many items showing in portfolio -->
	<style type="text/css"> 
		html{overflow-y: scroll;}
	</style>
	<!-- -->
    <?php } ?>

	<!-- wp Head-->
	<?php
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		wp_head();
	?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="homepage" data-color="<?php echo of_get_option('qua_color'); ?>">
	<div id="header" class="clearfix">
		<div id="logo">
				<a href="<?php echo get_bloginfo('url') ?>">
					<?php if ( of_get_option('qua_logo') ) { ?>
					<img class="logo" src="<?php echo of_get_option('qua_logo'); ?>" />
					<?php } ?>
				</a>
		</div><!-- #logo -->
		<div id="header-content">
			<!-- Large Screens Navigation -->
			<div id="access" role="navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'div', 'menu_class' => 'menu', 'container_class' => 'menu',  ) ); ?>
			</div><!-- #access -->
			
			<!-- Small Screens Navigation -->
			<nav id="responsiveaccess">
			<select name="page-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> 
				<option value="<?php echo get_bloginfo('url') ?>">
				<?php echo esc_attr( __( 'Home' ) ); ?></option> 
				<?php 
				$pages = get_pages(); 
				foreach ( $pages as $pagg ) {
				$option = '<option value="' . get_page_link( $pagg->ID ) . '">';
				$option .= $pagg->post_title;
				$option .= '</option>';
				echo $option;
				}
				?>
			</select>
			</nav> <!-- #responsiveaccess -->