<?php
/**
 *
 * Template Name: Blog Index with Accordion
 *
 * This template is used to display all blog Items.
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */

get_header(); ?>
			<div id="header-description">
					<h1 class="page-title">
						<?php
						$page_title = get_post_meta($post->ID, 'dm_he_title', true);
						if ($page_title){
							echo $page_title;
						}
						else{
							echo get_the_title().'.';
						}
						?>
					</h1>
					<span class="header-desc"><?php echo get_post_meta($post->ID, 'dm_he_desc', true); ?></span>
			</div><!-- #header-description -->
		</div><!-- #header-content -->
	</div><!-- #header -->

	<div id="content-blog" class="clearfix" role="main">
		<section id="primary">
			<div id="blog-index">
				<div id="blog-accordion">			
					<?php 	
						$wp_query = new WP_Query();
						$wp_query->query( array( 'posts_per_page' => 3, 'paged' => $paged ) );
						$more = 0;
					?>
					<?php
						while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
							get_template_part( 'content', 'blog' );
						endwhile;
					?>
				</div><!-- #blog-accordion -->
				<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="arrow">&larr;</span> Older posts', 'demagician' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="arrow">&rarr;</span>', 'demagician' ) ); ?></div>
				</div><!-- #nav-below -->
				<?php endif; ?>
			</div><!-- #blog-index -->
		</section>	<!-- #primary -->
		<?php get_sidebar('blog'); ?>
	<?php get_footer(); ?>