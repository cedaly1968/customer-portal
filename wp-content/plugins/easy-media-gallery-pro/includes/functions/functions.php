<?php


/**
* Get a Easy Media Gallery Global Functions
*
* @param string $name The option name
* @return object|bool Option value on success, false if no value exists
*/
 
 
 
/*
|--------------------------------------------------------------------------
| Easymedia Get Control Panel Options
|--------------------------------------------------------------------------
*/
function easy_get_option( $name ){
    $easymedia_values = get_option( 'easy_media_opt' );
    if ( is_array( $easymedia_values ) && array_key_exists( $name, $easymedia_values ) ) return $easymedia_values[$name];
    return false;
} 

/*-------------------------------------------------------------------------------*/
/*   ADMIN Register JS & CSS
/*-------------------------------------------------------------------------------*/
function easymedia_reg_script() {
	// CSS ( settings.php, tinymce-dlg.php, metaboxes.php )
	wp_register_style( 'easymedia-cpstyles', plugins_url( 'css/funcstyle.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION, 'all');
	wp_register_style( 'easymedia-colorpickercss', plugins_url( 'css/colorpicker.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'easymedia-sldr', plugins_url( 'css/slider.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'easymedia-ibutton', plugins_url( 'css/ibutton.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );	
	wp_register_style( 'easymedia-tinymce', plugins_url( 'css/tinymce.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'jquery-ui-themes-redmond', plugins_url( 'css/jquery/jquery-ui/themes/smoothness/jquery-ui-1.10.0.custom.min.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'easymedia-tinymce', plugins_url( 'css/tinymce.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );	
	wp_register_style( 'jquery-multiselect-css', plugins_url( 'css/jquery/multiselect/jquery.multiselect.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'jquery-messi-css', plugins_url( 'css/messi.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'jquery-lightbox-css', plugins_url( 'css/lightbox_me.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
	wp_register_style( 'jquery-gdakramttip-css', plugins_url( 'css/jquery/jquery.tooltip/jquery.tooltip.css' , dirname(__FILE__) ), false, EASYMEDIA_VERSION );
			
	// JS ( settings.php ) 
	wp_register_script( 'easymedia-jquery-easing', plugins_url( 'js/jquery/jquery.easing.1.3.js' , dirname(__FILE__) ) );	
	wp_register_script( 'easymedia-colorpicker', plugins_url( 'js/colorpicker/colorpicker.js' , dirname(__FILE__) ) );	
	wp_register_script( 'colorpicker-eye', plugins_url( 'js/colorpicker/eye.js' , dirname(__FILE__) ) );
	wp_register_script( 'colorpicker-utils', plugins_url( 'js/colorpicker/utils.js' , dirname(__FILE__) ) );
	
	// JS ( tinymce-dlg.php ) 
	//wp_register_script( 'jquery-ui-custom', plugins_url( 'js/jquery/jquery-ui-1.10.0.min.js' , dirname(__FILE__) ) );
	//wp_register_script( 'jquery-ui-custom-1', plugins_url( 'js/jquery/jquery-ui-1.9.2.custom.min.js' , dirname(__FILE__) ) );
	wp_register_script( 'jquery-multi-sel', plugins_url( 'js/jquery/multiselect/jquery.multiselect.js' , dirname(__FILE__) ) );
	//wp_register_style('layoutjs', plugins_url('js/colorpicker/layout.js' , dirname(__FILE__) ));
	
	// JS ( metaboxes.php, ) 
	wp_register_script( 'jquery-multi-sel', plugins_url( 'js/jquery/multiselect/jquery.multiselect.js' , dirname(__FILE__) ) );
	wp_register_script( 'easymedia-ckeditor', plugins_url( 'addons/ckeditor/ckeditor.js' , dirname(__FILE__) ) );
	wp_register_script( 'jquery-messi-js', plugins_url( 'js/jquery/jquery.messi.min.js' , dirname(__FILE__) ) );
	wp_register_script( 'jquery-lightbox-js', plugins_url( 'js/jquery/jquery.lightbox_me.js' , dirname(__FILE__) ) );
	wp_register_script( 'jquery-gdakram-tooltip', plugins_url( 'js/jquery/jquery.tooltip.js' , dirname(__FILE__) ) );	
}
add_action( 'admin_init', 'easymedia_reg_script' );


function easymedia_frontend_js() {
	// JS ( frontend.php ) 
	wp_deregister_script('fittext'); // deregister		
	wp_register_script( 'fittext', plugins_url( 'js/jquery/jquery.fittext.js' , dirname(__FILE__) ) );		
	wp_register_script( 'mootools-core', plugins_url( 'js/mootools/mootools-' .easy_get_option( 'easymedia_plugin_core' ). '.js' , dirname(__FILE__) ) );	
	wp_register_script( 'easymedia-core', plugins_url( 'js/mootools/easymedia.js' , dirname(__FILE__) ) );	
	wp_register_script( 'easymedia-isotope', plugins_url( 'js/jquery/jquery.isotope.min.js' , dirname(__FILE__) ) );		
	wp_register_script( 'easymedia-ajaxfrontend', plugins_url( 'js/func/ajax-frontend.js' , dirname(__FILE__) ) );	
	wp_register_script( 'easymedia-frontend', plugins_url( 'js/func/frontend.js' , dirname(__FILE__) ) );		

}
add_action( 'wp_enqueue_scripts', 'easymedia_frontend_js' );

/*
|--------------------------------------------------------------------------
| Defines
|--------------------------------------------------------------------------
*/
define( 'EMG_IS_AJAX', easy_get_option( 'easymedia_disen_ajax' ) );

/* These files build out the plugin specific options and associated functions. */
require_once (EMGDEF_PLUGIN_DIR . 'includes/options.php'); 

/*-------------------------------------------------------------------------------*/
/*   Plugin Update Check
/*-------------------------------------------------------------------------------*/
if ( easy_get_option( 'easymedia_disen_upchk' ) == '1' ) {
include_once(EMGDEF_PLUGIN_DIR . 'includes/up-notifier.php');
}
/*-------------------------------------------------------------------------------*/
/*   Load Control Panel
/*-------------------------------------------------------------------------------*/
include_once( EMGDEF_PLUGIN_DIR . 'includes/settings.php' );

/*-------------------------------------------------------------------------------*/
/*   Load Front End Script
/*-------------------------------------------------------------------------------*/
if ( easy_get_option( 'easymedia_disen_plug' ) == '1' ) {	
include_once( EMGDEF_PLUGIN_DIR . 'includes/frontend.php' );
}
/*-------------------------------------------------------------------------------*/
/*  Add Metabox & Shortcode
/*-------------------------------------------------------------------------------*/
include_once( EMGDEF_PLUGIN_DIR . 'includes/metaboxes.php' ); 
include_once( EMGDEF_PLUGIN_DIR . 'includes/shortcode.php' ); 
include_once( EMGDEF_PLUGIN_DIR . 'includes/tinymce-dlg.php' ); 
include_once( EMGDEF_PLUGIN_DIR . 'includes/taxonomy.php' );

/*
|--------------------------------------------------------------------------
| AJAX UPDATE GALLERY
|--------------------------------------------------------------------------
*/
function emg_updt_gall_list() {
	if ( !isset( $_POST['pstid'] ) ) {
		echo '<p>Ajax request failed, please refresh your browser window.</p>';
		die;
		}
		else {
			update_post_meta( $_POST['pstid'] , 'easmedia_metabox_media_gallery', '' );
			echo '<p>No images selected...</p>';
			die;
		}
}
add_action( 'wp_ajax_emg_updt_gall_list', 'emg_updt_gall_list' );


/*
|--------------------------------------------------------------------------
| AJAX LIST MEDIA (TINYMCE)
|--------------------------------------------------------------------------
*/
function emg_load_media_list() {
	
	if ( !isset( $_POST['taxo'] ) ) {
		echo '<p>Ajax request failed, please refresh your browser window.</p>';
		die;
		}
		else {
			global $post;
			$taxoterm = $_POST['taxo'];
			
			
$args = array(
'tax_query' => array(
    array(
        'taxonomy' => 'emediagallery',
        'field' => 'id'
        //'terms' => $taxoterm
    )
)
);

query_posts( $args );			
			
if ( have_posts() ) :
	while ( have_posts() ) :
			$show_media .= '
			<input name="'.$post->ID.'" id="'.$post->ID.'" type="text" value="'.get_post_meta( $id, 'easmedia_metabox_title', true ).'" />';

	echo $show_media;
	die();
	
	endwhile;	
else:
  echo 'Sorry, no media matched your criteria.';		
  die();	
endif;
wp_reset_query();			
			
	}
}
add_action( 'wp_ajax_emg_load_media_list', 'emg_load_media_list' );

/*
|--------------------------------------------------------------------------
| AJAX DELETE MEDIA IMAGE
|--------------------------------------------------------------------------
*/
function easmedia_img_media_remv() {
	
	if ( !isset( $_POST['pstid'] ) || !isset( $_POST['type'] ) ) {
		echo '0';
		die;
		}
		
		else {
			if ( !current_user_can( 'edit_theme_options' ) )
			die('-1');
			
			if ( $_POST['type'] == 'image' ){
				$data = $_POST['pstid'];
				update_post_meta($data, 'easmedia_metabox_img', '');
				echo '1';
				die;
				}
	
	elseif ( $_POST['type'] == 'audio' ){
		$data = $_POST['pstid'];
				update_post_meta($data, 'easmedia_metabox_media_audio', '');
				echo '1';
	    die;
		}
	}
}
add_action( 'wp_ajax_easmedia_img_media_remv', 'easmedia_img_media_remv' );


/*
|--------------------------------------------------------------------------
| AJAX LOAD IMAGE DETAILS
|--------------------------------------------------------------------------
*/
function easmedia_img_dtl() {
	
	if ( !isset( $_POST['imgid'] ) ) {
		echo '0';
		die;
		}
		
		else {
			
			$img_info = get_post( $_POST['imgid'] );
			$ttl = $img_info->post_title;
			$sbttl = $img_info->post_excerpt;
			$decs =  $img_info->post_content;
			
			$allimgdat = array( $ttl, $sbttl, $decs );
			echo implode("|~|", $allimgdat);
	    die;
		}
}
add_action( 'wp_ajax_easmedia_img_dtl', 'easmedia_img_dtl' );


/*
|--------------------------------------------------------------------------
| AJAX UPDATE IMAGE DETAILS
|--------------------------------------------------------------------------
*/
function easy_custom_save_function(){
	
		if ( !isset( $_POST['imgid'] ) || !isset( $_POST['imgttl'] ) || !isset( $_POST['imgsbttl'] ) || !isset( $_POST['imgdesc'] ) ) {
		echo '0';
		die;
		}
		
		else {
    wp_update_post(array('ID' => $_POST['imgid'], 'post_title' => $_POST['imgttl']));
	wp_update_post(array('ID' => $_POST['imgid'], 'post_excerpt' => $_POST['imgsbttl']));
	wp_update_post(array('ID' => $_POST['imgid'], 'post_content' => $_POST['imgdesc']));
	echo '101';
		    die;
		}
}
add_action( 'wp_ajax_easy_custom_save_function', 'easy_custom_save_function' );


/*
|--------------------------------------------------------------------------
| AJAX LOAD IMAGE GALLERY
|--------------------------------------------------------------------------
*/
function emg_gallery_list() {

	if ( !isset( $_POST['page'] ) ) {$page = 1;}
	else {$page = (int)addslashes( $_POST['page'] );}
	
	if ( !isset( $_POST['per_page'] ) ) {$per_page = 8;}
	else {$per_page = (int)addslashes( $_POST['per_page'] );}
	
	$img_data = emg_library_images( $page, $per_page );
	
	echo '<ul>';
	
	if ( $img_data['totalimg'] == 0 ) {echo '<p>No images found .. </p>';}
	else {
		foreach( $img_data['img'] as $img ) {
			echo '<li><img src="'.EMG_THUMB_FILE.'?src='.$img['url'].'&w=90&h=90" id="'.$img['id'].'" /></li>';	
		}
	}
	
	echo '
	</ul>
	<br class="metagal_clear" />
	<table cellspacing="0" cellpadding="5" border="0" width="100%" style="border-top: 1px solid #DDD; margin-top:10px; padding-top:5px;">
		<tr>
			<td style="width: 35%;">';			
			if ( $page > 1 )  {
				echo '<input type="button" class="prev_page button-secondary" id="btnnav_'. ( $page - 1 ) .'" name="prevbtnnav" value="&laquo; Previous images" />';
			}
			
		echo '</td><td style="width: 30%; text-align: center;">';
		
			if ( $img_data['totalimg'] > 0 && $img_data['page_count'] > 1 ) {
				echo '<em>page '.$img_data['pag'].' of '.$img_data['page_count'].'</em><input style="display:none;" type="text" size="2" name="img_number" id="imgbutperpage" value="'.$per_page.'" />';	
			}
			else { echo '<input style="display:none;" type="text" size="2" name="img_number" id="imgbutperpage" value="'.$per_page.'" />';	}
			
		echo '</td><td style="width: 35%; text-align: right;">';
			if ( $img_data['more'] != false )  {
				echo '<input type="button" class="next_page button-secondary" id="btnnav_'. ($page + 1) .'" name="nextbtnnav" value="Next images &raquo;" />';
			}
		echo '</td>
		</tr>
	</table>
	';

	die();
}
add_action( 'wp_ajax_emg_gallery_list', 'emg_gallery_list' );

function emg_sel_img_rld() {	
	
	if ( !isset( $_POST['images'] ) ) { $images = array();}
	else { $images = $_POST['images'];}
	
	// get the titles
	$images = emg_ext_sel( $images );
	$new_img = '';
	
	if ( !$images ) {$new_img = '<p>No images selected...</p>';}
	else {
		foreach( $images as $img_id ) {
			$img_data = get_post( $img_id );
			$img_url = $img_data->guid;
			
			$new_img .= '
			<li>
				<input type="hidden" name="easmedia_metabox_img_slider[]" value="'.$img_id.'" />
				<img src="'.EMG_THUMB_FILE.'?src='.$img_url.'&w=90&h=90" />
				<span title="Remove Image"></span>
			</li>
			';	
		}
	}
	
	echo $new_img;
	die();
}
add_action( 'wp_ajax_emg_sel_img_rld', 'emg_sel_img_rld' );


/*
|--------------------------------------------------------------------------
| Get the images from the WP library
|--------------------------------------------------------------------------
*/
function emg_library_images( $page = 1, $per_page = 10 ) {
	$query_images_args = array(
		'post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => $per_page, 'paged' => $page
	);
	
	$query_images = new WP_Query( $query_images_args );
	$images = array();
	
	foreach ( $query_images->posts as $image ) { 
		$images[] = array(
			'id'	=> $image->ID,
			'url' 	=> $image->guid
		);
	}
	
	$img_number = $query_images->found_posts;
	$page_count = ceil( $img_number / $per_page );
	$shown = $per_page * $page;
	( $shown >= $img_number ) ? $more = false : $more = true; 
	
	return array( 'img' => $images, 'pag' => $page, 'page_count' =>$page_count, 'more' => $more, 'totalimg' => $img_number );
}

function emg_ext_sel( $media ) {
	if ( is_array( $media ) ) {
		$new_array = array();
		
		foreach( $media as $media_id ) {
			if ( get_the_title( $media_id ) ) {	
				$new_array[] = $media_id;
			}
		}
		
		if (count($new_array) == 0) {return false;}
		else {return $new_array;}
	}
	else {return false;}	
}


/*
|--------------------------------------------------------------------------
| Easymedia Custom Category Box (Metabox)
|--------------------------------------------------------------------------
*/
function easymediagallery_categories_meta_box( $post, $box ) {
	$defaults = array('taxonomy' => 'emediagallery');
	if ( !isset( $box['args'] ) || !is_array( $box['args'] ) )
		$args = array();
	else
		$args = $box['args'];
	extract( wp_parse_args($args, $defaults), EXTR_SKIP );
	$tax = get_taxonomy( $taxonomy );

	?>
	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv">
		<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
			<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all"><?php echo $tax->labels->all_items; ?></a></li>
			<li class="hide-if-no-js"><a href="#<?php echo $taxonomy; ?>-pop"><?php _e( 'Most Used' ); ?></a></li>
		</ul>

		<div id="<?php echo $taxonomy; ?>-pop" class="tabs-panel" style="display: none;">
			<ul id="<?php echo $taxonomy; ?>checklist-pop" class="categorychecklist form-no-clear" >
				<?php $popular_ids = wp_popular_terms_checklist($taxonomy); ?>
			</ul>
		</div>

		<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
			<?php
            $name = ( $taxonomy == 'emediagallery' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
            echo "<input type='hidden' name='{$name}[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
            ?>
			<ul id="<?php echo $taxonomy; ?>checklist" data-wp-lists="list:<?php echo $taxonomy?>" class="categorychecklist form-no-clear">
				<?php wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids ) ) ?>
			</ul>
		</div>
	<?php if ( current_user_can($tax->cap->edit_terms) ) : ?>
			<div id="<?php echo $taxonomy; ?>-adder" class="wp-hidden-children">
				<h4>
					<a id="<?php echo $taxonomy; ?>-add-toggle" href="#<?php echo $taxonomy; ?>-add" class="hide-if-no-js">
						<?php
							/* translators: %s: add new taxonomy label */
							printf( __( '+ %s' ), $tax->labels->add_new_item );
						?>
					</a>
				</h4>
				<p id="<?php echo $taxonomy; ?>-add" class="category-add wp-hidden-child">
					<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>"><?php echo $tax->labels->add_new_item; ?></label>
					<input type="text" name="new<?php echo $taxonomy; ?>" id="new<?php echo $taxonomy; ?>" class="form-required form-input-tip" value="<?php echo esc_attr( $tax->labels->new_item_name ); ?>" aria-required="true"/>
					<label class="screen-reader-text" for="new<?php echo $taxonomy; ?>_parent">
						<?php echo $tax->labels->parent_item_colon; ?>
					</label>
					<?php wp_dropdown_categories( array( 'taxonomy' => $taxonomy, 'hide_empty' => 0, 'name' => 'new'.$taxonomy.'_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => '&mdash; ' . $tax->labels->parent_item . ' &mdash;' ) ); ?>
					<input type="button" id="<?php echo $taxonomy; ?>-add-submit" data-wp-lists="add:<?php echo $taxonomy ?>checklist:<?php echo $taxonomy ?>-add" class="button category-add-submit" value="<?php echo esc_attr( $tax->labels->add_new_item ); ?>" />
					<?php wp_nonce_field( 'add-'.$taxonomy, '_ajax_nonce-add-'.$taxonomy, false ); ?>
					<span id="<?php echo $taxonomy; ?>-ajax-response"></span>
				</p>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/*-------------------------------------------------------------------------------*/
/* Add Post Thumbnails and Custom Thumbnails size
/*-------------------------------------------------------------------------------*/
function easmedia_add_thumbnail_support() {
	if ( !current_theme_supports( 'post-thumbnails' ))  {
add_theme_support( 'post-thumbnails', array( 'easymediagallery' ) );
add_image_size( 'emg-admin-thumb', 70, 70, true ); // Used in the easymedia edit page
	}
}
add_action('init', 'easmedia_add_thumbnail_support');

/*-------------------------------------------------------------------------------*/
/* Add credits in admin page
/*-------------------------------------------------------------------------------*/
function easymediagallery_add_footer_credits( $text ) {
	$t = '';
	if ( get_post_type() === 'easymediagallery' ) {
		$t .= "<div id=\"credits\" style=\"line-height: 22px;\">";
		$t .= "<p>Easy Media Gallery plugin is created by <a href=\"http://www.ghozylab.com/\" target=\"_blank\">GhozyLab, Inc</a>.</p>";
		$t .= "<p>If you have some support issue, don't hesitate to <a href=\"http://ghozylab.com/submit-support-request\" target=\"_blank\">write here</a>. The GhozyLab team will be happy to support you on any issue.</p>";
		$t .= "</div>";
	}else{
		$t = $text;
	}

	return $t;
}
add_filter( 'admin_footer_text', 'easymediagallery_add_footer_credits' );

/*-------------------------------------------------------------------------------*/
/*  Get the patterns list 
/*-------------------------------------------------------------------------------*/
function easmedia_patterns_ls() {
	$patterns = array();
	$patterns_list = scandir( EMG_DIR."/css/images/patterns" );
	
	foreach( $patterns_list as $pattern_name ) {
		if ( $pattern_name != '.' && $pattern_name != '..' ) {
			$patterns[] = $pattern_name;
		}
	}
	return $patterns;	
}

/*-------------------------------------------------------------------------------*/
/*  HEX to RGB
/*-------------------------------------------------------------------------------*/
function easymedia_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return implode(",", $rgb); // returns an array with the rgb values
}

/*-------------------------------------------------------------------------------*/
/*  replace_extension
/*-------------------------------------------------------------------------------*/
function emg_replace_extension($filename) {
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$new_extension = 'emgcvr-'.$ext;
    return preg_replace('/\..+$/', '.' . $new_extension, $filename);
}

/*-------------------------------------------------------------------------------*/
/*  Get attachment image id 
/*-------------------------------------------------------------------------------*/
function get_attachment_id_from_src ($link) {
    global $wpdb;
        $link = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $link);
        return $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE guid='$link'");
}

/*-------------------------------------------------------------------------------*/
/*  Image Resize ( Aspect Ratio )
/*-------------------------------------------------------------------------------*/
function easymedia_imgresize($img, $limit, $isres, $imw, $imh) {
	
	/*if ( strpos( $img, $_SERVER['HTTP_HOST'] ) === FALSE ) {
		$img= "http://".$_SERVER['HTTP_HOST'].$img;
		}
		else {
			$img= $img;
			}*/
	
	if ( $img == '' ) {
		$img = plugins_url( 'images/no-image-available.jpg' , dirname(__FILE__) ) ;
	}
		else {
			$img = $img;
		}	
	
	if ( $isres == 'on' ) {
		if ( $imw > $limit ) {
			$tempimgratio = $imh / $imw;
			$fih = (int)($tempimgratio * $limit); // final image height
			$fiw = $limit; // fixed image width
			$allimgdata = array( EMG_THUMB_FILE . "?src=" . $img . "&h=" . $fih . "&w=" . $fiw . "&zc=1&q=100", $fiw, $fih );
			}
		else {
			$allimgdata = array( $img, $imw, $imh );
			}		
		}
	else { $allimgdata = array( $img, $imw, $imh );	
	}
return implode(",", $allimgdata);
}

/*-------------------------------------------------------------------------------*/
/*  Image Resize ( Aspect Ratio ) AJAX
/*-------------------------------------------------------------------------------*/
function easymedia_imgresize_ajax() {
	if ( !isset( $_POST['imgurl'] ) || !isset( $_POST['limiter'] ) || $_POST['imgurl'] == '' || $_POST['limiter'] == '' ) {
		echo '<p>Ajax request failed, please refresh your browser window.</p>';
		die;
		}
		else {
			
		$imgurl = $_POST['imgurl'];
		$limiter = $_POST['limiter'];
		$attid = wp_get_attachment_image_src( get_attachment_id_from_src( $imgurl ), 'full' );
	
		/*if ( strpos( $imgurl, $_SERVER['HTTP_HOST'] ) === FALSE ) {
			$imgurl = "http://".$_SERVER['HTTP_HOST'].$imgurl;
			}
			else {
				$imgurl = $imgurl;
				}*/
				
				$tmpimgratio = $attid[2] / $attid[1]; //get image aspec ratio

		if ( $attid[1] > $limiter ) {
			$tmph = (int)($tmpimgratio * $limiter); // final image height
			$tmpw = $limiter; // fixed image width
			$finimgurl = EMG_THUMB_FILE . "?src=" . $imgurl . "&h=" . $tmph . "&w=" . $tmpw . "&zc=1&q=100";
			$allimgdata = array( $finimgurl, $tmpw, $tmph );
			echo implode(",", $allimgdata);
			die;
			}
		else {
			$finimgurl = $imgurl;
			$allimgdata = array( $finimgurl, $attid[1], $attid[2] );
			echo implode(",", $allimgdata);
			die;
			}		
		}
}
add_action( 'wp_ajax_easymedia_imgresize_ajax', 'easymedia_imgresize_ajax' );

/*-------------------------------------------------------------------------------*/
/*  Get Plugin Version (@return string Plugin version)
/*-------------------------------------------------------------------------------*/
function easymedia_get_plugin_version() {
    $plugin_data = get_plugin_data( EMG_DIR . '/easy-media-gallery-pro.php' );
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}

/*-------------------------------------------------------------------------------*/
/*  Random String
/*-------------------------------------------------------------------------------*/
function RandomString($length) {
        $original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
        $original_string = implode('', $original_string);
        return substr(str_shuffle($original_string), 0, $length);
    }
	
/*-------------------------------------------------------------------------------*/
/*  Enable Sorting of the Media 
/*-------------------------------------------------------------------------------*/
function easmedia_create_easymedia_sort_page() {
    $easmedia_sort_page = add_submenu_page('edit.php?post_type=easymediagallery', 'Sorter', __('Sorter', 'easmedia'), 'edit_posts', 'easymedia-order', 'easmedia_easymedia_sort');
    
    add_action('admin_print_styles-' . $easmedia_sort_page, 'easmedia_print_sort_styles');
    add_action('admin_print_scripts-' . $easmedia_sort_page, 'easmedia_print_sort_scripts');
}
add_action( 'admin_menu', 'easmedia_create_easymedia_sort_page' );


function easmedia_easymedia_sort() {
    $easymedias = new WP_Query('post_type=easymediagallery&posts_per_page=-1&orderby=menu_order&order=ASC'); 
	if (  $easymedias->have_posts() ) :
	?>
    <div class="wrap">
        <div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>
        <h2><?php _e('Sorter', 'easmedia'); ?></h2>
        <p><?php _e('Simply drag the Media up or down and they will be saved in that order. Media at the top will appear first.', 'easmedia'); ?></p>

		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e( 'Sort Media', 'easmedia' ); ?>:</h3>


        <ul id="easymedia_list" style="padding-left:10px !important;">
            <?php while( $easymedias->have_posts() ) : $easymedias->the_post(); ?>        
                    <li id="<?php the_id(); ?>" class="menu-item">
                        <dl class="menu-item-bar">
                            <dt class="menu-item-handle">
                                <img style="float:left; vertical-align:middle;padding-top: 4px; margin-right:10px;" src="<?php echo plugins_url( 'images/sort.png' , dirname(__FILE__) ) ?>" height="28px;" width="28px;"/><span class="item-title"><?php echo esc_html( esc_js( the_title(NULL, NULL, FALSE) ) ); ?></span>
                            </dt>
                        </dl>
                        <ul class="menu-item-transport"></ul>
                    </li>
            <?php endwhile; ?>

				<?php else: ?>
<div class="wrap">
<div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>  
<h2><?php _e('Sorter', 'easmedia'); ?></h2> 
		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e( 'Sort Media', 'easmedia' ); ?>:</h3>             
<p style="padding:10px;"><?php printf( __('No items found, why not %screate one%s?	', 'easmedia'), '<a href="post-new.php?post_type=easymediagallery">', '</a>'); ?> </p></div></div></div>				
<?php endif; ?>            
            
            <?php wp_reset_postdata(); ?>
        </ul>
    </div><div style="padding-left:33px; margin-bottom:30px"><img src="<?php echo plugins_url( 'images/dragdrop.png' , dirname(__FILE__) ) ?>" height="23px;" width="161px;"/></div>
  </div>
 </div>  
	<?php 
}

/*-------------------------------------------------------------------------------*/
/*  RENAME POST BUTTON
/*-------------------------------------------------------------------------------*/
add_filter( 'gettext', 'change_publish_button', 10, 2 );
function change_publish_button( $translation, $text ) {
if ( 'easymediagallery' == get_post_type())
if ( $text == 'Publish' ) {
    return 'Save Media'; }
else if ( $text == 'Update' ) {
    return 'Update Media'; }	

return $translation;
}


/*-------------------------------------------------------------------------------*/
/*   Load News
/*-------------------------------------------------------------------------------*/

if ( easy_get_option( 'easymedia_disen_dasnews' ) == '1' ) {
function emg_register_dashboard_widgets() {
	if ( current_user_can( apply_filters( 'emg_dashboard_stats_cap', 'edit_pages' ) ) ) {
		wp_add_dashboard_widget( 'emg_dashboard_stat', __('Easy Media Gallery', 'easmedia'), 'emg_dashboard_widget' );
	}
}
add_action('wp_dashboard_setup', 'emg_register_dashboard_widgets' );

function emg_dashboard_widget() {
	
	$notifier_file_url = 'http://www.ghozylab.com/plugins/easy-media-gallery/content/ajax.php';
	
	if ( function_exists( 'curl_init' ) ) { // if cURL is available, use it...
			$ch = curl_init( $notifier_file_url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
			$plugdata = curl_exec( $ch );
			curl_close( $ch );
			echo $plugdata;
		} 	

	elseif ( ini_get('allow_url_fopen') ) { // if allow_url_fopen/file_get_contents is available, use it...
		$plugdata = file_get_contents( $notifier_file_url );
		echo $plugdata;
	}
	
	else { ?>
    
    <div class="emg_dashboard_widget">
<p class="sub">If you really love Easy Media Gallery, please recommend our plugin to your friends.</p>	
<ul class='easymedia-social' id='easymedia-cssanime'>
<li class='easymedia-facebook'>
<a onclick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=Check out the Best Wordpress Portfolio and Gallery plugin&amp;p[summary]=Easy Media Gallery for WordPress that is powerful and so easy to create portfolio or media gallery&amp;p[url]=http://ghozylab.com/&amp;p[images][0]=http://ghozylab.com/wp-content/uploads/2013/02/ghozy-logo.png', 'sharer', 'toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)" title="Share"><strong>Facebook</strong></a>
</li>
<li class='easymedia-twitter'>
<a onclick="window.open('https://twitter.com/share?text=Check out the Best Wordpress Portfolio and Gallery Plugin &url=http://ghozylab.com/', 'sharer', 'toolbar=0,status=0,width=548,height=325');" title="Twitter" class="circle"><strong>Twitter</strong></a>
</li>
</li>
<li class='easymedia-googleplus'>
<a onclick="window.open('https://plus.google.com/share?url=http://ghozylab.com/','','width=415,height=450');"><strong>Google+</strong></a>
</li>
</li>
<li class='easymedia-pinterest'>
<a onclick="window.open('http://pinterest.com/pin/create/button/?url=http://ghozylab.com/;media=http://ghozylab.com/wp-content/uploads/2013/02/ghozy-logo.png;description=Easy Media Gallery for WordPress that is powerful and so easy to create portfolio or media gallery','','width=600,height=300');"><strong>Pinterest</strong></a>
</li>
</ul>
</div>

    <?php
		
	}
}
}

/*-------------------------------------------------------------------------------*/
/*   Documentation Page
/*-------------------------------------------------------------------------------*/
function easmedia_create_docs_page() {
    $easmedia_docs_page = add_submenu_page('edit.php?post_type=easymediagallery', 'Documentation', __('Documentation', 'easmedia'), 'edit_posts', 'docs', 'easmedia_easymedia_docs');
}
add_action( 'admin_menu', 'easmedia_create_docs_page' );


function easmedia_easymedia_docs() {
	?>
    <div class="wrap">
        <div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>
        <h2><?php _e('Documentation', 'easmedia'); ?></h2>
        <p><?php _e('This plugin comes with instructional training videos that walk you through every aspect of setting up your new media gallery. We recommend following these videos to setup your media gallery. This user manual is only intended to be a reference guide.', 'easmedia'); ?></p>

		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e( 'Video Tutorials', 'easmedia' ); ?></h3>
        <div id="easymedia_docs1" style="padding-left:10px !important;">
        <ul style="list-style: square; position:relative; margin-left:15px; margin-bottom:25px">
        <li><a href="http://www.youtube.com/watch?v=TQ1MMxhsyD8" target="_blank" >How to Create Grid Gallery</a></li> 
		<li><a href="http://www.youtube.com/watch?v=OEoNB2LpnSE" target="_blank" >How to Create Filterable Media</a></li>  
        <li><a href="http://www.youtube.com/watch?v=dXFBNY5t6E8" target="_blank" >How to Create Single Image Media</a></li>
        <li><a href="http://www.youtube.com/watch?v=htxwZw_aPF0" target="_blank" >How to Create Video Media Types</a></li>  
        <li><a href="http://www.youtube.com/watch?v=Bsn-CB5Hpbw" target="_blank" >How to Create Audio (mp3) Media Types</a></li>          
        <li><a href="http://www.youtube.com/watch?v=Oee2cpKT-kE" target="_blank" >How to Create Audio Soundcloud</a></li>
        <li><a href="http://www.youtube.com/watch?v=SYH8Yl2SQd4" target="_blank" >How to Create Audio Reverbnation</a></li>    
        <li><a href="http://www.youtube.com/watch?v=PEgfleRf6hg" target="_blank" >How to Create Google Maps</a></li>   
 		<li><a href="http://www.youtube.com/watch?v=BWmWAPb_z90" target="_blank" >How to Change Image Title, Subtitle &amp; Description</a></li>                
		<li><a href="http://www.youtube.com/watch?v=skCMKvVLD5o" target="_blank" >How to Set Order of Image</a></li>             
        <li><a href="http://www.youtube.com/watch?v=9cuYyBMKx2k" target="_blank" >How to Insert Image into Media Description</a></li>            
        <li><a href="http://www.youtube.com/watch?v=Z2qwXz7GIRw" target="_blank" >How to Publish Easy Media Gallery</a></li>                  
        <li><a href="http://www.youtube.com/watch?v=2T73wvt_wOA" target="_blank" >How to Change Media Border Size and Color</a></li>
        <li><a href="http://www.youtube.com/watch?v=56f_C7OXiAE" target="_blank" >How to Change Media Columns</a></li>                
        </ul>
    </div>
    </div>     
 		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e( 'Troubleshooting', 'easmedia' ); ?></h3>
        <div id="easymedia_docs2" style="padding-left:10px !important;">
        <ul style="list-style: square; position:relative; margin-left:15px;">
        <li><strong>Images not showing up</strong><p>Sometimes you may face problem that your images are not displaying in the site, like <a target="_blank" href="<?php echo plugins_url( 'images/thumbnail-error.png' , dirname(__FILE__) ) ?>">this example</a>. We use Timthumb script to resize the images and some hosts do not allow the use of Timthumb for security reasons. Here's how to solve this problem:</p>
      <p>Send email to <a href="mailto:support@ghozylab.com">support@ghozylab.com</a> using your PayPal email with subject and message : <strong>REQ NO TIMTHUMB VERSION</strong>. We will send the download link to your email immediately. That's All...</p>      
        </li>     
        </ul>
    </div>
    </div>    

  </div>
 </div>  
	<?php 
}


/*-------------------------------------------------------------------------------*/
/*  Add WordPress Pointers 
/*-------------------------------------------------------------------------------*/

add_action( 'admin_enqueue_scripts', 'easmedia_pointer_pointer_header' );
function easmedia_pointer_pointer_header() {
    $enqueue = false;

    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'easmedia_pointer_pointer', $dismissed ) ) {
        $enqueue = true;
        add_action( 'admin_print_footer_scripts', 'easmedia_pointer_pointer_footer' );
    }

    if ( $enqueue ) {
        // Enqueue pointers
        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }
}

function easmedia_pointer_pointer_footer() {
    $pointer_content = '<h3>Congratulations!</h3>';
	  $pointer_content .= '<p>You&#39;ve just installed Easy Media Gallery Pro. Click <a class="close"href="edit.php?post_type=easymediagallery&page=docs">here</a> to watch video tutorials and user guide plugin.</p>';
?>

<script type="text/javascript">// <![CDATA[
jQuery(document).ready(function($) {
	
if (typeof(jQuery().pointer) != 'undefined') {	
    $('#menu-posts-easymediagallery').pointer({
        content: '<?php echo $pointer_content; ?>',
        position: {
            edge: 'left',
            align: 'center'
        },
        close: function() {
            $.post( ajaxurl, {
                pointer: 'easmedia_pointer_pointer',
               action: 'dismiss-wp-pointer'
            });
        }
    }).pointer('open');
	
}

});
// ]]></script>
<?php
}


?>