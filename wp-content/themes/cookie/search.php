<?php
	/* Get the author data */
	if(get_query_var('author_name')) :
	$curauth = get_userdatabylogin(get_query_var('author_name'));
	else :
	$curauth = get_userdata(get_query_var('author'));
	endif;

	get_header();
?>


	<section id="ml_main_area" class="single">
	
		<section id="ml_search-info">

			<h1 class="ml_search-title"><?php _e("Search Results for \"$s\"", 'meydjer') ?></h1>
			
			<div class="ml_divider"></div>

		</section>

	    <?php get_template_part('includes/loop'); ?>

	</section>


	<?php get_sidebar(); ?>
	
	
	
<?php get_footer(); ?>