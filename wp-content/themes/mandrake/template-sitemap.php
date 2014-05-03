<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header() ?>
	<?php theme_builder('introduce',$post->ID); ?>
    <div class="container sidebar-right">
        <div class="inner">
        	<?php theme_builder('breadcrumbs'); ?>
            <!-- / breadcrumbs -->
        	<div class="content">
            	<h2><?php _e('Pages','mandrake_theme');?></h2>
                <?php wp_nav_menu(array('theme_location' => 'main-menu', 'container' => 'false', 'menu_class' => 'list2', 'link_before' => '', 'link_after' => '', 'depth' => '3')); ?>	
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
<?php get_footer() ?>