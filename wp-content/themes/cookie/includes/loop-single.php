<?php

if ( have_posts() ) : while ( have_posts() ) : the_post();

//get meta data of the featured image
global $post;

$featured_image_array = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
$featured_image = $featured_image_array[0];
$featured_image_fit = get_template_directory_uri() . '/includes/timthumb.php?src=' . $featured_image . '&w=640&zc=1&q=100';



if ($featured_image){

	$featured_size = getimagesize($featured_image_fit);
	$featured_height = $featured_size[1];

} else {

	$featured_height = '';

}



$featured_id = get_post_meta($post->ID, '_thumbnail_id', true);
$featured_attachment = get_post($featured_id);
$featured_description = '';
$featured_description = $featured_attachment->post_excerpt == "" ? $featured_attachment->post_content : $featured_attachment->post_excerpt;

?>



	<div class="ml_nav-top">

		<div class="nav-prev"><?php previous_post_link('%link','&larr; '.'%title') ?></div>
	
		<div class="nav-next"><?php next_post_link('%link','%title'.' &rarr;') ?></div>

	</div>

	

	<article id="post-<?php the_ID(); ?>" <?php post_class('ml_post_single'); ?>>



		<h2 class="ml_post-title"><?php the_title(); ?></h2>



		<?php
			//if have featured image, get it and add a content wrapper
			if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) {
			
			/* width is 639 because of a IE7 bug :( */
			?>

			<a href="<?php echo $featured_image; ?>" class="ml_featured-image" data-rel="prettyPhoto" title="<?php echo $featured_description; ?>">

				<img src="<?php echo $featured_image_fit; ?>" alt="<?php the_title(); ?>" width="639" height="<?php echo $featured_height ?>" />

			</a>

		<?php } ?>



		<div class="ml_post-info">
		
			<span><?php echo get_the_date('n.j.y'); ?> </span>
			
			<span><?php _e('at', 'meydjer'); ?> <?php echo get_the_time('g:i a'); ?>,</span>

			<span><?php _e('by', 'meydjer'); ?></span> <?php the_author_posts_link(); ?>,

			<span><?php _e('in', 'meydjer'); ?></span> <?php the_category(', ') ?> 

			<span><?php _e('with', 'meydjer'); ?></span> <?php comments_popup_link( __('0 comments', 'meydjer'), __('1 comment', 'meydjer'), __('% comments', 'meydjer'), 'comments-link', '0'); ?>

		</div>



		<?php the_content(); ?>


<?php endwhile; ?>


	
	<div class="ml_post-tags"><?php _e('Tags:', 'meydjer'); ?> <?php the_tags('', ', ',''); ?></div>
	
	<?php comments_template('', true); ?>

	</article>



	<div class="nav-prev"><?php previous_post_link('%link','&larr; '.'%title') ?></div>

	<div class="nav-next"><?php next_post_link('%link','%title'.' &rarr;') ?></div>
	
	

<?php else: ?>

	

	<article id="post-<?php the_ID(); ?>" <?php post_class('ml_post_content ml_with_padding ml_boxed'); ?>>

		<p><?php _e('Sorry, no posts matched your criteria.', 'meydjer') ?></p>

	</article>



<?php endif; ?>

<?php wp_reset_query(); ?>