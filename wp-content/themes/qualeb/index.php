<?php
/**
 * The main template file
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
 
get_header(); ?>
			<div id="header-description">
				<?php if ( have_posts() ) : ?>
				
					<h1 class="page-title">
						<?php the_title(); ?>
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
		
			<?php if ( have_posts() ) : ?>
			
				<div id="blog-index">
					<div id="blog-accordion" class="archive-accordion">			
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
							get_template_part( 'content', 'blog' );
						?>
					<?php endwhile; ?>
					</div><!-- #blog-accordion -->
					<?php if (  $wp_query->max_num_pages > 1 ) : ?>
					<div id="nav-below" class="navigation">
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'demagician' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'demagician' ) ); ?></div>
					</div><!-- #nav-below -->
					<?php endif; ?>
				</div><!-- #blog-index -->
				
			<?php else : ?>
			
				<div id="page-content">
					<p><?php _e( 'Apologies, but no results were found for the requested archive.', 'demagician' ); ?></p>
				</div><!-- #page-content -->
				
			<?php endif; ?>
		</section>	<!-- #primary -->
		<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>