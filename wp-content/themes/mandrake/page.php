<?php
/**
 * The template for displaying Page
 */
?>
<?php get_header(); ?>
	<?php theme_builder('introduce',$post->ID); ?>
    <div class="container sidebar-right">
        <div class="inner">
        	<?php theme_builder('breadcrumbs'); ?>
        	<div class="content">
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
            </div>
            <!-- / content -->
            <div id="sidebar">
            	<div class="sidebar-content">
                   <?php sidebar_builder('get_sidebar',$post->ID); ?>
                </div>
            </div>
            <!-- / sidebar -->
            <div class="clear"></div>
        </div>
    </div>
    <!-- / container -->
<?php get_footer(); ?>