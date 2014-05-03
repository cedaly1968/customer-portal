<?php
/*
Template Name: Homepage Nivo Slider
*/
?>
<?php
$layout = theme_get_option('homepage','theme_layout');
?>
<?php get_header(); ?>
	<?php theme_builder('slideshow','nivo'); ?>
    <?php theme_builder('teaser'); ?>
    <div class="container <?php if($layout=='right'):?>sidebar-right<?php endif;?><?php if($layout=='left'):?>sidebar-left<?php endif;?>">
        <div class="inner">
        	<div class="content">
            <?php if (have_posts()) while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
            </div>
            <!-- / content -->
            <?php if($layout != 'full') : ?>
            <div id="sidebar">
            	<div class="sidebar-content">
                   <?php sidebar_builder('get_sidebar','home'); ?>
                </div>
            </div>
            <!-- / sidebar -->
            <?php endif; ?>
            <div class="clear"></div>
        </div>
    </div>
    <!-- / container -->
    <?php theme_builder('portfolio_slider'); ?> 
<?php get_footer(); ?>