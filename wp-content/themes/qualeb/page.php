<?php
/**
 * The default page template.
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
		</div>
	</div><!-- #header -->
	
	<div id="content-blog" class="clearfix" role="main">
		<section id="primary">
			<div id="page-content">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>

					<?php if (of_get_option('qua_hide_pagecomments') == 'no'){ ?>
					
					<?php comments_template( '', true ); ?>
					
					<?php } else{} ?>

				<?php endwhile; // end of the loop. ?>
			</div><!-- #page-content -->
			
		</section><!-- #primary -->	
		
		<?php get_sidebar('page'); ?>

<?php get_footer(); ?>