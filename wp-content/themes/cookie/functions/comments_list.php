<?php 
function meydjer_comment($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment; ?>
	<?php /* start the comments list */ ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	
	<?php /* Content containner */ ?>
	<div id="comment-<?php comment_ID(); ?>" class="comment_box">
	
	<?php /* Load only approved comments */ ?>
	<?php if ($comment->comment_approved == '0') : ?>
	   <strong><?php _e('Your comment is awaiting moderation.','meydjer') ?></strong><br /><br />
	<?php endif; ?>

		<?php /* Comment author avatar */ ?>
		<?php echo get_avatar($comment,$size='50'); ?>

		<?php /* Comment author and date */ ?>
			<div class="ml_comment-info">

				<span class="ml_comment-author"><?php comment_author_link(); ?></span>
				
				<br />

				<span class="ml_comment-date-time"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php echo get_comment_date('n.j.y '); echo __('at', 'meydjer'); echo get_comment_time(' H:ia'); ?></a>&nbsp;&nbsp;&nbsp;</span>

			</div>

			<div class="clearfix"></div>
		
		<?php /* Comment content */ ?>
		<div class="ml_comment-content">

			<?php comment_text() ?>
			
			<div class="ml_comment_options">

				<span class="ml_comment-edit"> <?php edit_comment_link(__('(Edit) -','meydjer'),'  ',''); ?></span>
	
				<span class="ml_comment-reply"> <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
			
			</div>

		</div>
	</div>
<?php } ?>