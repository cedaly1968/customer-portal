<?php

/* Template Name: Portfolio */

get_header();

?>

	<section id="ml_main_area" class="ml_portfolio">


	    <?php get_template_part('includes/loop-single-portfolio'); ?>


	</section>


	
	<nav id="ml_sidebar" class="ml_ajax_portfolio_disabled ml_portfolio">

	    <?php get_template_part('includes/loop-sidebar-portfolio'); ?>

	</nav>
	
	
	
<?php get_footer('portfolio'); ?>