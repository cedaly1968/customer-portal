<?php
/**
 * The template for displaying archive
 */
?>
<?php $layout = theme_get_option('blog','theme_layout'); ?>
<?php get_header(); ?>
	<?php theme_builder('introduce'); ?>
    <div class="container <?php if($layout=='right'):?>sidebar-right<?php endif;?><?php if($layout=='left'):?>sidebar-left<?php endif;?>">
        <div class="inner">
        	<?php theme_builder('breadcrumbs'); ?>
        	<div class="content">
            	<?php get_template_part('loop','archive'); ?>
                <?php theme_builder('pagination'); ?>
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