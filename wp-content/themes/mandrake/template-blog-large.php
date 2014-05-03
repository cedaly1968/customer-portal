<?php
/*
Template Name: Blog Large Image
*/
?>
<?php $layout = theme_get_option('blog','theme_layout'); ?>
<?php get_header(); ?>
	<?php theme_builder('introduce',$post->ID); ?>
    <div class="container <?php if($layout=='right'): ?>sidebar-right<?php endif; ?><?php if($layout=='left'): ?>sidebar-left<?php endif; ?>">
        <div class="inner">
        	<?php theme_builder('breadcrumbs'); ?>
        	<div class="content">
            	<?php $category = get_post_meta($post->ID, '_blog_category', true); ?>
            	<?php query_posts(array('post_type' => 'post', 'category_name' => $category, 'paged' => $paged)); ?>
            	<?php get_template_part('loop','blog'); ?>
                <?php theme_builder('pagination'); ?>
            </div>
            <!-- / content -->
            <div id="sidebar">
            	<div class="sidebar-content">
					<?php sidebar_builder('get_sidebar','blog'); ?>
                </div>
            </div>
            <!-- / sidebar -->
            <div class="clear"></div>
        </div>
    </div>
    <!-- / container -->
<?php get_footer(); ?>