<?php
/**
 *
 * Template Name: Home
 *
 * This template is used to display the home page.
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */

get_header(); ?>
			<div id="home-header-description">
				<h2 id="home-slogan"><?php echo get_post_meta($post->ID, 'dm_he_title', true); ?></h2>
				<p class="main-description"><?php echo get_post_meta($post->ID, 'dm_he_desc', true); ?></p>
			</div>
		</div>
	</div><!-- #header -->

	<div id="content-home" class="clearfix" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; // end of the loop. ?>
				
<?php get_footer(); ?>