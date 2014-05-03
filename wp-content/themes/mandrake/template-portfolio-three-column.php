<?php
/*
Template Name: Portfolio Three Column
*/
?>
<?php $portfolio_count = theme_get_option('portfolio','portfolio_count'); ?>
<?php get_header(); ?>
	<?php theme_builder('introduce', $post->ID); ?>
    <div class="container">
        <div class="inner">
			<?php theme_builder('breadcrumbs'); ?>
        	<div class="content">
				<?php theme_builder('portfolio_filter', $post->ID); ?>
                <ul class="portfolio-list three-column">
					<?php 
                    $count = 0;
					$category = get_post_meta($post->ID, '_portfolio_category', true);
                    query_posts(array('portfolio_category' => $category, 'post_type' => 'portfolio', 'paged' => $paged, 'posts_per_page'=>$portfolio_count)); 
                    if (have_posts()) while (have_posts()) : the_post();
						theme_builder('portfolio', 'portfolio_three_column', $count, $post->ID);
                    	$count++;
					endwhile; 
					?>
                </ul>
                <!-- / portfolio-list -->
                <?php theme_builder('pagination'); ?>
            </div>
            <!-- / content -->
            <div class="clear"></div>
        </div>
    </div>
    <!-- / container -->
<?php get_footer(); ?>