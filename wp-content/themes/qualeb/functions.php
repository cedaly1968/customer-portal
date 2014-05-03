<?php

/*-------------------------------------------------------------------------------------*/
/*		Fix Cron issue when in debug mode
/*-------------------------------------------------------------------------------------*/

define('ALTERNATE_WP_CRON', true);


/*-------------------------------------------------------------------------------------*/
/*		Translation / localization support
/*-------------------------------------------------------------------------------------*/

load_theme_textdomain( 'demagician', TEMPLATEPATH . '/library/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );


/*-------------------------------------------------------------------------------------*/
/*		Load Scripts 
/*-------------------------------------------------------------------------------------*/

function my_scripts_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/library/js/jquery-1.6.4.min.js', true);
    wp_enqueue_script( 'jquery' );
	wp_register_script( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js', true);
    wp_enqueue_script( 'jquery-ui' );
	
	// register the scripts
	wp_register_script('flexslider', get_template_directory_uri() . '/library/js/jquery.flexslider-min.js', array('jquery'), '1.7' , true);
	wp_register_script('hoverintent', get_template_directory_uri() . '/library/js/jquery.hoverIntent.minified.js', array('jquery-ui'), '1.7', true);
	wp_register_script('superfish', get_template_directory_uri() . '/library/js/superfish.js', array('jquery'), '1.4.8' , true);
	wp_register_script('quicksand', get_template_directory_uri() . '/library/js/jquery.quicksand.js', array('jquery'), '1.2.2', true );
	wp_register_script('cufon-yui', get_template_directory_uri() . '/library/js/cufon-yui.js', array('jquery'), '1.09', true );
	wp_register_script('easing', get_template_directory_uri() . '/library/js/jquery.easing.1.3.js', array('jquery'), '1.3', true );
	wp_register_script('tweet', get_template_directory_uri() . '/library/js/jquery.tweet.js', array('jquery'), '1.0', true );
	wp_register_script('validate', get_template_directory_uri() . '/library/js/jquery.validate.js', array('jquery'), '1.9.0', true );
	wp_register_script('form', get_template_directory_uri() . '/library/js/jquery.form.js', array('jquery'), '1.0', true);
	wp_register_script('core', get_template_directory_uri() . '/library/js/core.js', array('jquery'), '1.0', true);
    
	
	// enqueue the scripts
    wp_enqueue_script('flexslider');
	wp_enqueue_script('hoverintent');
	wp_enqueue_script('superfish');
	wp_enqueue_script('quicksand');
	wp_enqueue_script('cufon-yui');
	wp_enqueue_script('easing');
	wp_enqueue_script('tweet');
	wp_enqueue_script('validate');
	wp_enqueue_script('form');
	wp_enqueue_script('core');
}    

add_action('wp_enqueue_scripts', 'my_scripts_method');


/*-------------------------------------------------------------------------------------*/
/*		Define Path / Load Extensions
/*-------------------------------------------------------------------------------------*/

// Theme Path constant
define('THEMELIB', TEMPLATEPATH . '/library');

// Load Widget Areas & Widgets
require_once(THEMELIB . '/extensions/widgets.php');

// Custom Post Types (Slider + Portfolio)
require_once(THEMELIB . '/extensions/post-type-slider.php');
require_once(THEMELIB . '/extensions/post-type-portfolio.php');

// Shortcodes
require_once(THEMELIB . '/shortcodes/home.php');
require_once(THEMELIB . '/shortcodes/video.php');
require_once(THEMELIB . '/shortcodes/columns.php');
require_once(THEMELIB . '/shortcodes/typography.php');

// Metaboxes
require_once(THEMELIB . '/extensions/metabox-portfolioindex.php');
require_once(THEMELIB . '/extensions/metabox-header.php');
require_once(THEMELIB . '/extensions/metabox-slider.php');

// TinyMCE Shortcodes Adder
require_once(THEMELIB . '/shortcodes/columnsadder.php');
require_once(THEMELIB . '/shortcodes/shortcodeadder.php');


/*-------------------------------------------------------------------------------------*/
/*		Add support for thumbnails (Featured Image) & Set default img width & sizes
/*-------------------------------------------------------------------------------------*/

add_theme_support( 'post-thumbnails' );  

if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */
	
add_image_size( 'blog-post-image', 480, 280, true );
add_image_size( 'portfolio-single', 600, 380, true );
add_image_size( 'portfolio-index', 300, 273, true );
add_image_size( 'portfolio-home', 300, 273, true );
add_image_size( 'home-slider', 940, 340, true );

// Prevent wordpress from adding image width and height, 
// when posting a image to the editor

function image_tag($html, $id, $alt, $title) {
	return preg_replace(array(
			'/\s+width="\d+"/i',
			'/\s+height="\d+"/i',
			'/alt=""/i'
		),
		array(
			'',
			'',
			'',
			'alt="' . $title . '"'
		),
		$html);
}
add_filter('get_image_tag', 'image_tag', 0, 4);


/*-------------------------------------------------------------------------------------*/
/*		Register Navigation Menu - wp_nav_menu() / Do not Show Home Link
/*-------------------------------------------------------------------------------------*/

register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'demagician' ),
) );

// Prevent the menu from showing the HomePage link
function toolbox_page_menu_args($args) {
	$args['show_home'] = false;
	return $args;
}
add_filter( 'wp_page_menu_args', 'toolbox_page_menu_args' );


/*-------------------------------------------------------------------------------------*/
/*		Add default posts and comments RSS feed links to head
/*-------------------------------------------------------------------------------------*/

add_theme_support( 'automatic-feed-links' );

/*-------------------------------------------------------------------------------------*/
/*		Activate shortcodes in Text Widget
/*-------------------------------------------------------------------------------------*/

add_filter('widget_text', 'do_shortcode');

/*-------------------------------------------------------------------------------------*/
/*		Style the TinyMCE editor
/*-------------------------------------------------------------------------------------*/

add_editor_style();

/*-------------------------------------------------------------------------------------*/
/*		TinyMCE editor, remove extra p tags
/*-------------------------------------------------------------------------------------*/

// remove_filter ('the_content',  'wpautop');
// remove_filter ('comment_text', 'wpautop');

/*-----------------------------------------------------------------------------------*/
/* Options Framework (http://wptheming.com)
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'optionsframework_init' ) ) {

/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */
if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
} else {
	define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('stylesheet_directory') . '/admin/');
}

require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {

		jQuery('#example_showhidden').click(function() {
			jQuery('#section-example_text_hidden').fadeToggle(400);
		});
		
		if (jQuery('#example_showhidden:checked').val() !== undefined) {
			jQuery('#section-example_text_hidden').show();
		}
		
	});
	</script>
<?php
}

/*-------------------------------------------------------------------------------------*/
/*		Limit Search to posts only
/*-------------------------------------------------------------------------------------*/

function SearchFilter($query) {
     if ($query->is_search) {
          $query->set('post_type','post');
     }
     return $query;
}
add_filter('pre_get_posts','SearchFilter');


/*-------------------------------------------------------------------------------------*/
/*		Retrieve the number of comments for a post (from the Thematic Framework)
/*-------------------------------------------------------------------------------------*/

function dm_postfooter_postcomments() {
	if (comments_open()) {
		$postcommentnumber = get_comments_number();
		if ($postcommentnumber > '1') {
			$postcomments = ' <span class="comments-link"><a href="' . apply_filters('the_permalink', get_permalink()) . '#comments" title="' . __('Comment on ', 'demagician') . the_title_attribute('echo=0') . '">';
			$postcomments .= get_comments_number() . __(' Comments', 'demagician') . '&nbsp; &rarr;</a></span>';
		} elseif ($postcommentnumber == '1') {
			$postcomments = ' <span class="comments-link"><a href="' . apply_filters('the_permalink', get_permalink()) . '#comments" title="' . __('Comment on ', 'demagician') . the_title_attribute('echo=0') . '">';
			$postcomments .= get_comments_number() . __(' Comment', 'demagician') . '&nbsp; &rarr; </a></span>';
		} elseif ($postcommentnumber == '0') {
			$postcomments = ' <span class="comments-link"><a href="' . apply_filters('the_permalink', get_permalink()) . '#comments" title="' . __('Comment on ', 'demagician') . the_title_attribute('echo=0') . '">';
			$postcomments .= __('Leave a comment', 'demagician') . '&nbsp; &rarr; </a></span>';
		}
	} else {
		$postcomments = ' <span class="comments-link comments-closed-link">' . __('Comments closed', 'demagician') .'</span>';
	}             
	return apply_filters('dm_postfooter_postcomments',$postcomments); 
	
}

/*-------------------------------------------------------------------------------------*/
/*		Misc functions
/*-------------------------------------------------------------------------------------*/

// Reduced Excerpt for HomePage
function intro_text($length) {
	global $post;
	$text = get_the_excerpt(); //get_the_excerpt($post->ID); deprecated
	if (strlen($text) > $length) {
	$text = substr($text,0,strpos($text,' ',$length)) . ' ... <a class="home-arr" href="' . get_permalink() . '">'.__( 'Continue reading <span class="readmore-arrow">&rarr;</span>', 'demagician' ).'</a>'; } ;
	return apply_filters('the_excerpt',$text);
}

// Reduced Excerpt for Portfolio Items (Overlay)
function item_text($length) {
	global $post;
	$text = get_the_excerpt();
	if (strlen($text) > $length) {
	$text = substr($text,0,strpos($text,' ',$length)) . ' ...'; } ;
	return apply_filters('the_excerpt',$text);
}

/*-------------------------------------------------------------------------------------*/
/*		Template for comments and pingbacks.
/*-------------------------------------------------------------------------------------*/

if ( ! function_exists( 'dm_comments' ) ) :
function dm_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p>
			<?php _e( 'Pingback:', 'demagician' ); ?> <?php comment_author_link(); ?>
			<?php edit_comment_link( __( 'Edit', 'demagician' ), '<span class="edit-link">', '</span>' ); ?>
		</p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard clearfix">
					<?php
						$avatar_size = 35;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 35;
						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( '%1$s <br />%2$s',
							sprintf( '<span class="comment-data"><span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s" class="comments-date"><time pubdate datetime="%2$s">%3$s</time></a></span><br />',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf('%1$s at %2$s', get_comment_date(), get_comment_time() )
							)
						);
					?>
					<?php edit_comment_link( __( 'Edit', 'demagician' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'demagician' ); ?></em>
					<br />
				<?php endif; ?>
			</footer>
			<div class="comment-content clearfix">
				<?php remove_filter( 'comment_text', 'wpautop', 30 ); comment_text(); ?> 
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span class="readmore-arrow">&rarr;</span>', 'demagician' ), 'depth' => $depth, 'max_depth' => $args['max_depth'], 'respond_id' => 'respond-area' ) ) ); ?>
			</div>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for dm_comments()
?>