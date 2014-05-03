<?php
/**
 * The template for displaying Search
 */
?>
<?php get_header(); ?>
	<?php theme_builder('introduce'); ?>
    <div class="container sidebar-right">
        <div class="inner">
        	<?php theme_builder('breadcrumbs'); ?>
        	<div class="content">
            	<?php get_template_part('loop','search'); ?>
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