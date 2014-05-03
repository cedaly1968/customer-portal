<?php
/**
 * The template for displaying Comments
 */
?>
<?php
function theme_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    	<div id="comment-<?php comment_ID(); ?>" class="comment-wrap">
            <div class="comment-image">
                <div class="image-border">
                	<?php echo get_avatar($comment, $size='50', $default=''); ?>
                </div>
            </div>
            <div class="comment-text">
                <span class="date"><?php echo get_comment_date(); ?></span>
                <?php printf('<strong>%s </strong>', get_comment_author_link()); ?><?php edit_comment_link( __('(Edit)', 'mandrake_theme' ), '', ''); ?>
                <?php comment_text(); ?>
			<?php if ($comment->comment_approved == '0') : ?>
                <p class="unapproved"><em><?php _e('Your comment is awaiting moderation.', 'mandrake_theme'); ?></em></p>
            <?php endif; ?>
            	<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </div>
        </div>
<?php
}
?>

<?php if (post_password_required()) : ?>
<div class="article-comments" id="comments">
	<p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'mandrake_theme'); ?></p>
</div>
<!-- / article-comments -->
<?php
	return;
	endif;
?>

<?php if (have_comments()) : ?>
<div class="article-comments" id="comments">
    <h4><?php
    printf( _n('One Comment to %2$s', '%1$s Comments to %2$s', get_comments_number(), 'mandrake_theme'),
    number_format_i18n(get_comments_number()), get_the_title());
    ?></h4>
    <ul class="comment-list">
	<?php wp_list_comments(array('callback' => 'theme_comments')); ?>
    </ul>
    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
    <div class="comment-navigation">
    	<div class="previous"><?php previous_comments_link( __( '&larr; Older Comments', 'mandrake_theme')); ?></div>
        <div class="next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'mandrake_theme' )); ?></div>
    </div>
    <?php endif; ?>
</div>
<!-- / article-comments --> 
<?php else :
	if (!comments_open()) :
	/* <p class="nocomments"><?php _e('Comments are closed.', 'mandrake_theme'); ?></p> */
?>
<?php endif; ?>
<?php endif; ?>

<?php if (comments_open()) : ?>
<div class="comment-respond" id="respond">
	<h4><?php comment_form_title( __('Leave a Comment','mandrake_theme'), __('Leave a Comment to %s','mandrake_theme')); ?></h4>
    <div class="cancel-comment-reply">
        <?php cancel_comment_reply_link(); ?>
    </div>
    <p><?php _e('Your email address will not be published. Required fields are marked *', 'mandrake_theme'); ?></p>
<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
	<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment','mandrake_theme'), wp_login_url(get_permalink())); ?></p>
<?php else : ?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
    <?php if (is_user_logged_in()) : ?>
		<p class="logged"><?php printf( __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','mandrake_theme'), admin_url('profile.php'), $user_identity, wp_logout_url(get_permalink())); ?></p>
	<?php else : ?>
        <p><input type="text" name="author" id="author" class="contact-name" value="<?php echo $comment_author; ?>" tabindex="1" />
        <label for="author"><?php _e('Name', 'mandrake_theme');  if ($req) echo " *"; ?></label></p>
        
        <p><input type="text" name="email" id="email" class="contact-email" value="<?php echo $comment_author_email; ?>" tabindex="2" />
        <label for="email"><?php _e('Email', 'mandrake_theme');  if ($req) echo " *"; ?></label></p>
        
        <p><input type="text" name="url" id="url" class="contact-website" value="<?php echo $comment_author_url; ?>" tabindex="3" />
        <label for="url"><?php _e('Website','mandrake_theme'); ?></label></p>       
	<?php endif; ?>
        <p><textarea name="comment" id="comment" class="contact-message" cols="20" rows="5" tabindex="4"></textarea></p>
        <p><button type="submit" class="button small active"><span><?php _e('Post Comment', 'mandrake_theme'); ?></span></button></p>
        <?php comment_id_fields(); ?>
        <p><?php do_action('comment_form', $post->ID); ?></p>
    </form>
<?php endif; // If registration required and not logged in ?>
</div>
<!-- / respond -->
<?php endif; ?>