<?php

/* Template Name: Portfolio */

get_header();

if(of_get_option('ml_ajax_portfolio')) {
	$ajax_portfolio_status = 'ml_ajax_portfolio_enabled';
} else {
	$ajax_portfolio_status = 'ml_ajax_portfolio_disabled';
}

?>


	
	<img src="<?php echo get_template_directory_uri() ?>/images/light/ajax-loader.gif" alt="<?php _e('Loading...', 'meydjer'); ?>" class="ml_initial_loader" />



	<section id="ml_main_area" class="ml_has_welcome_image ml_portfolio">

		<div id="ml_welcome_screen">
		
			<?php if(of_get_option('ml_welcome_image')) { ?>
			
				<img src="<?php echo of_get_option('ml_welcome_image') ?>" alt="<?php echo bloginfo('name') ?>" class="ml_welcome_image" />
			
			<?php } else { ?>
			
				<img src="<?php echo get_template_directory_uri() ?>/images/demo/welcome_image.png" alt="<?php echo bloginfo('name') ?>" class="ml_welcome_image" />
			
			<?php } ?>
	
		</div>

	</section>


	
	<nav id="ml_sidebar" class="<?php echo $ajax_portfolio_status ?> ml_portfolio">

	    <?php get_template_part('includes/loop-sidebar-portfolio'); ?>

	</nav>
	
	
	
	<?php if(of_get_option('ml_show_latest_posts')) { ?>

		<div class="clearfix"></div>
		
		<section class="ml_portfolio_blog">
	
		    <?php get_template_part('includes/loop-portfolio-blog'); ?>
	
		</section>

	<?php } ?>
	
	
	
<?php get_footer('portfolio'); ?>