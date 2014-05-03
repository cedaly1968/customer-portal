<?php
/*
Template Name: Gallery
*/
?>
<?php get_header(); ?>
	<?php theme_builder('introduce', $post->ID); ?>
    <div class="container">
        <div class="inner">
			<?php theme_builder('breadcrumbs'); ?>
        	<div class="content">
            <ul class="gallery-list four-column">
				<?php get_template_part('loop','gallery'); ?>
            </ul>
            <div class="clear"></div>
            </div>
            <!-- / content -->
        </div>
    </div>
    <!-- / container -->
<?php get_footer(); ?>