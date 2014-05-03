<?php
/**
 * The template for displaying search
 */
?>
<?php $display_meta = theme_get_option('blog','display_meta'); ?>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>
	<div class="article" id="post-<?php the_ID(); ?>" >
		<div class="article-header">
			<div class="article-title">
				<h2><a href="<?php echo get_permalink(); ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'mandrake_theme'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
			</div>
		</div>
		<?php if (has_post_thumbnail()) : ?>
		<div class="article-image">
			<div class="image-holder">
				<div class="image-shadow">
					<a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail('blog_large'); ?><span class="zoom-document"></span></a>
                    <div class="shadow"><img src="<?php echo THEME_URI; ?>/images/image-shadow.png" alt="" /></div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="article-text">
			<?php the_excerpt(); ?>
			<p><a href="<?php the_permalink(); ?>" class="button more"><span><?php _e('Read more','mandrake_theme'); ?></span></a></p>
		</div>
	</div>
<?php endwhile; ?>