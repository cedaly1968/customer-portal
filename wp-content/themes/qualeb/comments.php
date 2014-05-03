<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to dm_comments() which is
 * located in the functions.php file.
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
?>
	<div id="comments">
		<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'demagician' ); ?></p>
	<?php
		return;
		endif;
	?>
    
	
	<?php if ( have_comments() ) : ?>
	<div class="comments-left">
		<span class="blog-article-meta">
			<?php
				printf( _n( 'One comment', '%1$s comments', get_comments_number(), 'demagician' ),
					number_format_i18n( get_comments_number() ) );
			?>
		</span>
		<br />
		<span class="comments-link"><a href="#respond">Leave a comment</a></span>
	</div><!--.comments-left-->
	
	<div class="comments-right">
		<ol class="commentlist">
			<?php
				wp_list_comments( array( 'callback' => 'dm_comments' ) );
			?>
		</ol>
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="nav-below">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'demagician' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'demagician' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
			/* If there are no comments and comments are closed, let's leave a little note, shall we?
			 * But we don't want the note on pages or post types that do not support comments.
			 */
			elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'demagician' ); ?></p>
		<?php endif; ?>
	</div><!-- .comments-right -->
	</div><!-- #comments -->
	<div style="clear:both;"></div>
	
	<div id="respond-area">
		<div class="respond-left">
			<span class="blog-article-meta"> 
			<?php if ( ! comments_open()  && post_type_supports( get_post_type(), 'comments' ) ) {
			?>
				<p class="nocomments"><?php _e( 'Comments are closed.', 'demagician' ); ?></p>
			<?php
			}
			else{
			?>
			Leave a Comment 
			<?php } ?>
			</span>
		</div><!-- #respond-left -->
		<div class="respond-right">
			<?php
				$aria_req = ( $req ? " aria-required='true'" : '' );
				$fields =  array(
					'author' => '<p class="respond comment-form-author">' .  '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />'
								. '<label for="author">' . __( 'Name', 'demagician' )  . '</label> ' . ( $req ? '<span class="required">*</span> </p>' : '') ,
					'email'  => '<p class="respond comment-form-email">' .  '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />'
								. '<label for="email">' . __( 'Email', 'demagician'  )  . '</label> ' . ( $req ? '<span class="required">*</span> </p>' : '') ,
					'url'    => '<p class="respond comment-form-url"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />'
								. '<label for="url">' . __( 'Website', 'demagician'  ) . '</label></p>',
				); 
				comment_form(array(
					'fields' =>  apply_filters( 'comment_form_default_fields', $fields ),
					'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
					'comment_notes_after' => '', 
					'comment_notes_before' => '', 
					'title_reply' => ' '));
			?>
		</div> <!-- #respond-right -->

