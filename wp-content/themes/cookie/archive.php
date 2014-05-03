<?php
	/* Get the author data */
	if(get_query_var('author_name')) :
	$curauth = get_userdatabylogin(get_query_var('author_name'));
	else :
	$curauth = get_userdata(get_query_var('author'));
	endif;

	get_header();
?>


	<section id="ml_main_area">

		<section id="ml_archive-info">

			<?php $post = $posts[0]; // hack for the_date(); ?>
			
			<?php
			/* Category Archive */
			if (is_category()) { ?>
			<h1 class="ml_archive-title"><?php printf(__('All posts in "%s"', 'meydjer'), single_cat_title('',false)); ?></h1>
			<?php }
			
			/* Tag Archive */
			elseif( is_tag() ) { ?>
			<h1 class="ml_archive-title"><?php printf(__('All posts tagged "%s"', 'meydjer'), single_tag_title('',false)); ?></h1>
			<?php } 
			
			/* Day Archive */
			elseif (is_day()) { ?>
			<h1 class="ml_archive-title"><?php _e('Archive for', 'meydjer') ?> <?php the_time('F jS, Y'); ?></h1>
			<?php } 
			
			/* Month Archive */
			elseif (is_month()) { ?>
			<h1 class="ml_archive-title"><?php _e('Archive for', 'meydjer') ?> <?php the_time('F, Y'); ?></h1>
			<?php }
			
			/* Year Archive */
			elseif (is_year()) { ?>
			<h1 class="ml_archive-title"><?php _e('Archive for', 'meydjer') ?> <?php the_time('Y'); ?></h1>
			<?php }
			
			/* Author Archive */
			elseif (is_author()) { ?>
			<h1 class="ml_archive-title"><?php _e('All posts by', 'meydjer') ?> "<?php echo $curauth->display_name; ?>"</h1>
			<?php }
			
			/* Other */
			elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h1 class="ml_archive-title"><?php _e('Blog Archives', 'meydjer') ?></h1>
			<?php } ?>
	
			<div class="ml_divider"></div>

		</section>
		

	    <?php get_template_part('includes/loop-single'); ?>

	</section>


	<?php get_sidebar(); ?>