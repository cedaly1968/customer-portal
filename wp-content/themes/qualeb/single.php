<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */

get_header(); ?>
			<div id="header-description">
				<?php 
				// Get the Blog Index Page ID from the specified page in the Options Panel
				$indexId = of_get_option('qua_blog_index'); 
				if ($indexId){
					// Get the title in the blog index metabox
					$indexTitle = get_post_meta($indexId, 'dm_he_title', true);
					//If there is one, make it the title
					if ($indexTitle){
						$theindexTitle = $indexTitle;
					}
					//If the field is empty, use the blog index page title
					else{
						$theindexTitle = get_the_title($indexId).'.';
					}
				}
				// If the blog index page wasn't specified, use this as a title
				else{
					$theindexTitle = 'THE BLOG.';
				}
				?>
				<h1 class="page-title"> <?php echo $theindexTitle; ?></h1>
			</div><!-- #header-description -->	
		</div><!-- #header-content -->
	</div><!-- #header -->

	<div id="content-blog" class="clearfix" role="main">
		<section id="primary">
			<div id="blog-index">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php if (of_get_option('qua_hide_blogcomments') == 'no'){ ?>
					
					<?php comments_template( '', true ); ?>
					
					<?php } else{} ?>

				<?php endwhile; // end of the loop. ?>
			</div><!-- #blog-index -->
		</section><!-- #primary -->	
		<?php get_sidebar('blog'); ?>
	<?php get_footer(); ?>