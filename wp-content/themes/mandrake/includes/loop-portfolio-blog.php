<h2><?php _e('Latest Posts', 'meydjer'); ?></h2>



<?php $portfolio_blog_query = new WP_Query( 'post_type=post&posts_per_page=3' );

$count = 0;

while ( $portfolio_blog_query->have_posts() ) : $portfolio_blog_query->the_post();

$count++;

$column_child = '';
if($count == 1) {
	$column_child = 'first';
}

$featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
$featured_image = $featured_image_array[0];
$featured_image_fit = get_template_directory_uri() . '/includes/timthumb.php?src=' . $featured_image . '&w=57&h=57&zc=1&q=100';

?>



<div class="ml_one_third ml_fix_column <?php echo $column_child ?>">

	<a href="<?php the_permalink(); ?>" class="ml_portfolio-blog-title"><h6><?php the_title(); ?></h6></a>

	<span class="ml_portfolio-blog-info">&#8211; <?php echo get_the_date('n.j.y'); ?> - <?php the_category(', ') ?></span> <br />
	
	<?php if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>

		<a href="<?php the_permalink(); ?>" class="ml_featured-image ml_portfolio-blog-thumbnail" title="<?php the_title(); ?>">

			<img src="<?php echo $featured_image_fit; ?>" alt="<?php the_title(); ?>" width="57" height="57" />

		</a>

	<?php } ?>

	<p><?php $excerpt = get_the_excerpt(); echo ml_custom_excerpt($excerpt,20); ?></p>


</div>




<?php endwhile; wp_reset_postdata(); ?>