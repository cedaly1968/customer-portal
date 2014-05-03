<?php

/* Template Name: DEMO - Portfolio With Extra */

get_header();

?>


	<style type="text/css">
	
		#ml_header,
		#ml_welcome_screen,
		#ml_sidebar,
		#ml_footer,
		.ml_portfolio_blog {
			display: none;
		}

		.ml_initial_loader {
			left: 50%;
			position: absolute;
			top: 66%;
		}
		


		/*-------------------------------------------------*/
		/*	Sidebar
		/*-------------------------------------------------*/
			
		<?php if(of_get_option('ml_portfolio_layout') == 'left') { ?>
			
			#ml_main_area {
				float:right;
			}
			
			#ml_sidebar {
				float:left;
			}
			.ml_portfolio_item_title div {
				background: transparent url(<?php echo get_template_directory_uri() ?>/images/portfolio_item_arrow_right.png) no-repeat right bottom;
			}
			.ml_portfolio_item_title {
				text-align: left;
			}
		
		<?php } else { ?>
			
			#ml_main_area {
				float:left;
			}
			
			#ml_sidebar {
				float:right;
			}
			.ml_portfolio_item_title div {
				background: transparent url(<?php echo get_template_directory_uri() ?>/images/portfolio_item_arrow_left.png) no-repeat left bottom;
			}
			.ml_portfolio_item_title {
				text-align: right;
			}
		
		<?php } ?>
		
		.ml_portfolio_item {
			margin: 0 10px 10px 0;
		}
		
	
	</style>
	
	<img src="<?php echo get_template_directory_uri() ?>/images/light/ajax-loader.gif" alt="<?php _e('Loading...', 'meydjer'); ?>" class="ml_initial_loader" />



	<section id="ml_main_area" class="ml_has_welcome_image ml_portfolio">

		<div id="ml_welcome_screen">
		
			<?php if(of_get_option('ml_welcome_image')) { ?>
			
				<img src="<?php echo of_get_option('ml_welcome_image') ?>" alt="<?php echo bloginfo('name') ?>" class="ml_welcome_image" />
			
			<?php } else { ?>
			
				<img src="<?php echo get_template_directory_uri() ?>/images/demo/welcome_image.png" alt="<?php echo bloginfo('name') ?>" class="ml_welcome_image" />
			
			<?php } ?>
	
		</div>

	</section>


	
	<nav id="ml_sidebar" class="ml_ajax_portfolio_disabled ml_portfolio">

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
		
		
		

		$already_liked = 'ml_already_liked';

		if($_COOKIE['ml_likes_'.$post->ID] == 'no') {

			$already_liked = '';

		}
		


		if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>

			<a href="<?php the_permalink() ?>" class="ml_portfolio_item_thumbnail ml_link_to" data-id="<?php echo $post->ID; ?>">
	
				<img src="<?php echo get_template_directory_uri() . '/includes/timthumb.php?src=' . $featured_image . '&h=80&w=80&zc=1&q=100'; ?>" alt="" width="80" height="80" /></a>
	
			</a>		
		
			<a href="<?php the_permalink() ?>" class="ml_portfolio_item_title ml_link_to" data-id="<?php echo $post->ID; ?>">
			
				<div>
				
					<span><?php the_title() ?></span>
				
				</div>
	
			</a>
		
		
		
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
	</nav>
	
	
	
	<div class="clearfix"></div>
	
	<section class="ml_portfolio_blog">

	    <?php get_template_part('includes/loop-portfolio-blog'); ?>

	</section>
	
	
	
<?php get_footer(); ?>