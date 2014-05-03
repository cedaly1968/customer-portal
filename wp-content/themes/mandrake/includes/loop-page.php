<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>



	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
			<h2 class="page-title"><?php the_title(); ?></h2>

			<?php

				//if have featured image, get it and add a content wrapper
				if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { ?>

				<a href="<?php echo $featured_link; ?>" class="featured-image <?php echo $featured_class; ?>" data-rel="prettyPhoto[portfolio]" title="<?php echo $featured_description; ?>">

					<?php the_post_thumbnail('featured'); ?></a>

				</a>

			<?php } ?>

			<p><?php the_content(); ?></p>



<?php endwhile; ?>



	<?php comments_template('', true); ?>

	</article>


	
<?php else: ?>


	
	<p><?php _e('Sorry, no posts matched your criteria.', 'meydjer') ?></p>



<?php endif; ?>

<?php wp_reset_query(); ?>