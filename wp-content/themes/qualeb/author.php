<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */

get_header(); ?>
			<div id="header-description">
				<?php if ( have_posts() ) : ?>
					<?php the_post(); ?>
					<span class="header-title-light"><?php printf( __( 'Author Archives: ', 'demagician' )); ?></span>
					<h1 class="page-title">
						 <?php  echo get_the_author(); ?> 
					</h1>
				<?php else : ?>
					<h1 class="page-title">
						<?php printf( __( 'Nothing Found', 'demagician' )); ?>
					</h1>
				<?php endif; ?>
			</div><!-- #header-description -->
		</div><!-- #header-content -->
	</div><!-- #header -->
	<div id="content-blog" class="clearfix" role="main">
		<section id="primary">	
			<div id="blogreg-index">
					
				<?php if ( have_posts() ) : ?>
				
					<div id="blog-accordion" class="archive-accordion">	
						<?php  rewind_posts();	?>
							
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
								get_template_part( 'content', 'blogreg' );
							?>

						<?php endwhile; ?>
					</div>
				
				<?php else : ?>

						<div id="page-content">
							<p><center><?php _e( 'Apologies, but no results were found for the requested archive.', 'demagician' ); ?></center></p>
						</div><!-- #page-content -->
						
				<?php endif; ?>
			
			</div><!-- #blogreg-index -->
		</section><!-- #primary -->
		<?php get_sidebar('blog'); ?>
	<?php get_footer(); ?>