<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
			<div id="header-description">
			<?php if ( have_posts() ) : ?>
			
				<?php the_post(); ?>
				<span class="header-title-light"><?php printf( __( 'Search results for: ', 'demagician' )); ?></span>
				<h1 class="page-title">
					 <?php echo get_search_query(); ?>
				</h2>
				
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
							
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
								get_template_part( 'content', 'blogreg' );
							?>

						<?php endwhile; ?>
					</div>
				
				<?php else : ?>

						<div id="page-content">
							<p><center><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'demagician' ); ?></center></p>
						</div><!-- #page-content -->
						
				<?php endif; ?>
			
			</div><!-- #blogreg-index -->
		</section><!-- #primary -->
		<?php get_sidebar('blog'); ?>
	<?php get_footer(); ?>