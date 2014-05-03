<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>
	<?php theme_builder('introduce', $post->ID); ?>
    <div class="container">
        <div class="inner">
			<?php theme_builder('breadcrumbs'); ?>
        	<div class="content">
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
            <div class="clear"></div>
            </div>
            <!-- / content -->
        </div>
    </div>
    <!-- / container -->
<?php get_footer(); ?>