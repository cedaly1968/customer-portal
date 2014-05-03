


	<div class="ml_nav-top">

		<div class="nav-prev"><?php next_posts_link(__('&larr; Older Entries', 'meydjer')) ?></div>
		
		<div class="nav-next"><?php previous_posts_link(__('Newer Entries &rarr;', 'meydjer')) ?></div>

	</div>


		
<?php

$counter = 0;

if ( have_posts() ) : while ( have_posts() ) : the_post();

$counter++;

//get meta data of the featured image
global $post;

$featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
$featured_image = $featured_image_array[0];
$featured_image_fit = get_template_directory_uri() . '/includes/timthumb.php?src=' . $featured_image . '&w=290&zc=1&q=100';



if ($featured_image){

	$featured_size = getimagesize($featured_image_fit);
	$featured_height = $featured_size[1];

} else {

	$featured_height = '';

}



$child = '';
if($counter == 1) {
	$child = 'first';
}



$featured_id = get_post_meta($post->ID, '_thumbnail_id', true);
$featured_attachment = get_post($featured_id);
$featured_description = '';
$featured_description = $featured_attachment->post_excerpt == "" ? $featured_attachment->post_content : $featured_attachment->post_excerpt;

?>



	<article id="post-<?php the_ID(); ?>" <?php post_class('ml_post_index '.$child); ?>>



		<a href="<?php the_permalink(); ?>" class="ml_post-title">

			<h2 class="ml_post-title"><?php the_title(); ?></h2>

		</a>


		
		<div class="ml_post-left">
		
			<?php
				//if have featured image, get it and add a content wrapper
				if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
				
				?>
	
				<a href="<?php echo $featured_image; ?>" class="ml_featured-image" data-rel="prettyPhoto" title="<?php echo $featured_description; ?>">
	
					<img src="<?php echo $featured_image_fit; ?>" alt="<?php the_title(); ?>" width="290" height="<?php echo $featured_height ?>" />
	
				</a>
	
			<?php } ?>
			
			<div class="ml_post-info">
			
				<span><?php echo get_the_date('n.j.y'); ?> </span>
	
				<span><?php _e('by', 'meydjer'); ?></span> <?php the_author_posts_link(); ?>,
	
				<span><?php _e('in', 'meydjer'); ?></span> <?php the_category(', ') ?> 
	
				<span><?php _e('with', 'meydjer'); ?></span> <?php comments_popup_link( __('0 comments', 'meydjer'), __('1 comment', 'meydjer'), __('% comments', 'meydjer'), 'comments-link', '0'); ?>
	
			</div><!-- end div.ml_post-info -->

		</div><!-- end div.ml_post-left -->


		
		<div class="ml_post-right">

			<p><?php $excerpt = get_the_excerpt(); echo ml_custom_excerpt($excerpt,40); ?></p>
	
			<a href="<?php the_permalink(); ?>" class="ml_read-more ml_button"><?php _e('Read more', 'meydjer'); ?></a>

		</div><!-- end div.ml_post-right -->
		


	</article>



<?php endwhile; ?>
	
	<div class="clearfix"></div>
	
	<br /><br />

	<div class="nav-prev"><?php next_posts_link(__('&larr; Older Entries', 'meydjer')) ?></div>

	<div class="nav-next"><?php previous_posts_link(__('Newer Entries &rarr;', 'meydjer')) ?></div>


		
<?php else: ?>
	
	<article id="post-none" class="ml_post_content ml_with_padding ml_boxed" >
	<p><?php _e('Sorry, no posts matched your criteria.', 'meydjer') ?></p>
	</article>

<?php endif; ?>

<?php wp_reset_query(); ?>