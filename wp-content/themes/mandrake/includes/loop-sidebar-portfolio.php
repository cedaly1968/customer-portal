<?php

/* filter portfolio custom post type and show unlimited items */
query_posts( 'post_type=ml_portfolio&posts_per_page=-1');

?>


<?php /* filter by skill */ ?>
<section class="ml_portfolio-categories">

	<ul>

		<?php /* button to show all the items */ ?>
		<li class="ml_first-child selected"><a href="#" data-value="all"><?php _e('All', 'meydjer'); ?></a></li>

		<?php /* generate one button per skill */ 

		 $terms = get_terms('ml_skill');

		 $count = count($terms);

		 if ( $count > 0 ){

		     foreach ( $terms as $term ) {

		       echo "<li><a href=\"#\">" . $term->name . "</a></li>";

		     }

		 } ?>

	</ul>

</section><!--END #portfolio-categories-->

<div class="clearfix"></div>

<section id="ml_portfolio" class="ml_with_columns">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php 

$terms = get_the_terms( $post->ID, 'ml_skill' ); // get an array of all the terms as objects.

$terms_slugs = array();

$portfolio_item = '';

foreach( $terms as $term ) {

    $portfolio_item = $portfolio_item . ' ' . 'skill_' . sanitize_title($term->name) . ' '; // save each sanitized name inside the array and add a 'skill_' prefix to prevent conclicts

}

$portfolio_item = $portfolio_item . 'portfolio-item';
?>

	<?php /* add the skills as classes for each portfolio item */ ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class($portfolio_item . ' ml_portfolio_item'); ?>>
		
		<?php

		global $post;		

		//full image URL
		$featured_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );

		$featured_image = $featured_array[0];
				


		if(empty($likes_number)) { $likes_number = '0'; }
		
		add_post_meta($post->ID, '_ml_likes', $likes_number, true);

		$ml_likes = get_post_meta($post->ID, '_ml_likes');
		
		

		if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>

			<a href="<?php the_permalink() ?>" class="ml_portfolio_item_thumbnail ml_link_to" data-id="<?php echo $post->ID; ?>">
	
				<img src="<?php echo get_template_directory_uri() . '/includes/timthumb.php?src=' . $featured_image . '&h=80&w=80&zc=1&q=100'; ?>" alt="" width="80" height="80" />
	
			</a>		
		
			<a href="<?php the_permalink() ?>" class="ml_portfolio_item_title ml_link_to" data-id="<?php echo $post->ID; ?>">
			
				<div>
				
					<span><?php the_title() ?></span>
				
				</div>
	
			</a>
			
			
			
			<?php if(of_get_option('ml_show_like_hearts')) { ?>

				<div class="ml_like_heart ml_portfolio_item-<?php echo $post->ID; ?>" data-id="<?php echo $post->ID; ?>">
	
					<span><?php echo $ml_likes[0] ?></span>
	
				</div>

			<?php } ?>
		
		
		
		<?php
		} ?>
		
	</div><!-- end div.ml_portfolio_item -->
	
<?php endwhile; ?>

</section>

<?php else: ?>
	
	<div class="divider"></div><div class="clearfix"></div><!--double line divider-->

	<p><?php _e('Sorry, no posts matched your criteria.', 'meydjer') ?></p>

	<div class="divider"></div><div class="clearfix"></div><!--double line divider-->

<?php endif; ?>

<?php wp_reset_query(); ?>