<?php $author = theme_get_option('blog','display_author'); ?>
<?php $meta = theme_get_option('blog','display_meta'); ?>
<?php $tags = theme_get_option('blog','display_tags'); ?>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>
    <div class="article" id="post-<?php the_ID(); ?>">
        <div class="article-header">
            <div class="article-title">
                <h2><?php the_title(); ?></h2>
            </div>
            <?php if ($meta) : ?>
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
                    <?php the_post_thumbnail('blog_large'); ?>
                    <div class="shadow"><img src="<?php echo THEME_URI; ?>/images/image-shadow.png" alt="" /></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="article-text">
        	<?php the_content(); ?>
            <?php if ($tags) : ?>
            <p class="tags"><strong><?php _e('Tags: ', 'mandrake_theme'); ?></strong><?php the_tags('', ', '); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <!-- / article -->	
    <?php if ($author) : ?>
    <div class="article-author">
        <h4><?php _e('About the author', 'mandrake_theme'); ?></h4>
        <div class="frame-box">
            <div class="author-image">
                <div class="image-border">
                	<?php echo get_avatar(get_the_author_meta('user_email'), $size='50', $default='', $alt=''); ?>
                </div>
            </div>
            <div class="author-text">
            	<strong><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php printf(get_the_author()); ?></a></strong>
                <p><?php the_author_meta('description'); ?></p>
            </div>
        </div>
    </div>
    <!-- / article-author -->
    <?php endif; ?>
    <?php comments_template('', true); ?>
<?php endwhile; ?>