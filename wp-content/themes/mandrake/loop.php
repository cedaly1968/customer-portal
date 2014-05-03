<?php
/**
 * The template for displaying blog large image
 */
?>
<?php $display_meta = theme_get_option('blog','display_meta'); ?>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>
	<div class="article" id="post-<?php the_ID(); ?>" >
		<div class="article-header">
			<div class="article-title">
				<h2><a href="<?php echo get_permalink(); ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'mandrake_theme'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
			</div>
            <?php if ($display_meta) : ?>
			<div class="article-detail">
				<span class="date"><a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>"><?php echo get_the_date(); ?></a></span>
				<span class="separator">|</span>
				<span class="category"><?php _e('Category: ', 'mandrake_theme');  the_category(', '); ?></span>                            
				<span class="comments"><?php comments_popup_link(__('No Comments','mandrake_theme'), __('1 Comment','mandrake_theme'), __('% Comments','mandrake_theme')); ?></span>
			</div>
            <?php endif; ?>
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