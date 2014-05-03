<?php


/*-----------------------------------------------------------------------------------*/
/*  Featured Image Meta
/*-----------------------------------------------------------------------------------*/
function customposttype_image_box() {
	remove_meta_box( 'postimagediv', 'easymediagallery', 'side' );
	remove_meta_box( 'emediagallerydiv', 'easymediagallery', 'side' );
	add_meta_box( 'categorydiv', __( 'Item Categories' ), 'easymediagallery_categories_meta_box', 'easymediagallery', 'normal', 'high' );
	//add_meta_box('emediaimagediv', __('Select Image'), 'post_thumbnail_meta_box', 'easymediagallery', 'normal', 'default');
}
add_action( 'do_meta_boxes', 'customposttype_image_box' );


/*-----------------------------------------------------------------------------------*/
/*	META VIDEO CORE
/*-----------------------------------------------------------------------------------*/
if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
	
	add_action( "admin_head", 'emg_load_ckeditor' );
	
			function emg_load_ckeditor() {
				
				if ( get_post_type( get_the_ID() ) == 'easymediagallery' ) {
					wp_enqueue_script( 'jquery-multi-sel' );
					wp_enqueue_style( 'jquery-multiselect-css' );
					wp_enqueue_style( 'jquery-ui-themes-redmond' );
					wp_enqueue_script( 'jquery-ui-custom' );
					wp_enqueue_script( 'easymedia-ckeditor' );
					wp_enqueue_script( 'easymedia-jplayer-js', plugins_url( 'js/jplayer/jquery.jplayer.min.js' , __FILE__ ) );
					wp_enqueue_script( 'cpscript', plugins_url( 'functions/funcscript.js' , __FILE__ ) );
					wp_enqueue_script( 'jquery-i-button', plugins_url( 'js/jquery/jquery.ibutton.js' , __FILE__ ) );
					wp_enqueue_style( 'metabox-ibuttoneditor', plugins_url( 'css/ibutton.css' , __FILE__ ), false, EASYMEDIA_VERSION );
					wp_enqueue_style( 'easymedia-jplayer-css', plugins_url( 'css/jplayer/skin/pink.flag/jplayer.pink.flag.css' , __FILE__ ), false, EASYMEDIA_VERSION );		
					
					wp_enqueue_style( 'jquery-messi-css' );
					wp_enqueue_script( 'jquery-messi-js' );				
					wp_enqueue_style( 'jquery-lightbox-css' );
					wp_enqueue_script( 'jquery-lightbox-js' );	
					wp_enqueue_style( 'jquery-gdakramttip-css' );
					wp_enqueue_script( 'jquery-gdakram-tooltip' );					
					
			?>
            
         <script type="text/javascript">
			/*<![CDATA[*/       
        	window.onload = function()
	{
		CKEDITOR.replace( 'easmedia_metabox_shordesc' );
	};
  	/*]]>*/
		</script>    
			<?php
			}
		}	
	
	add_action( "admin_footer", 'emg_showhide_metabox' );
	function emg_showhide_metabox() { 
	
    if ( get_post_type( get_the_ID() ) == 'easymediagallery' ) {
		
		?>
    
                <div id="easymetaimg">
                <a id="close_x" class="close" href="#">close</a>
                <p style="margin-top:21px; border-top:solid 1px #CCC; padding-top:5px;"><span>This image will use title, sub title and description based on informations below:</span></p>
                <div id="easymetaimg_form">
                    <label><strong>Title:</strong> <input id="thisttl" class=""/></label>
                    <label><strong>SubTitle:</strong> <input id="thissubttl" class=""/></label>
                    <label><strong>Description:</strong> <textarea id="thisdesc" rows="14" cols="150"></textarea> </label>
                    <input id="thisimgid" type="hidden"/></label>
                    <div id="actions">
                    	<span id="boxinf" style="margin-right:10px; color:#F63;">Image info successfully saved.</span><div class="button button-primary" id="easysave">Save</div>
                    </div>
                </div>
            </div>
            <?php
 }   
if ( get_post_type( get_the_ID() ) == 'easymediagallery' ) { 
?>

        <script type="text/javascript">
			/*<![CDATA[*/
			/* Easy Media Gallery */  
jQuery(document).ready(function(e){function t(){var e=jQuery.makeArray();jQuery("#g-img-wrap li").each(function(){var t=jQuery(this).children("input").val();e.push(t)});jQuery("#g-img-wrap ul").html('<div style="height: 30px;" class="img_loading"></div>');var t={action:"emg_sel_img_rld",images:e};jQuery.post(ajaxurl,t,function(e){jQuery("#g-img-wrap ul").html(e)})}function n(e){var t={action:"emg_gallery_list",page:e,per_page:img_perpage};jQuery("#g-img_list").html('<div style="height: 30px;" class="img_loading"></div>');jQuery.post(ajaxurl,t,function(e){jQuery("#g-img_list").html(e)});return true}function r(){var e={action:"emg_updt_gall_list",pstid:"<?php echo get_the_ID(); ?>"};jQuery.post(ajaxurl,e,function(e){jQuery("#g-img-wrap ul").html(e)})}function i(e){var t={action:"easmedia_img_media_remv",pstid:"<?php echo get_the_ID(); ?>",type:e};jQuery.post(ajaxurl,t,function(t){if(t==1&&e=="image"){jQuery("#upload_"+e+"").val("");jQuery("#imgpreviewbox").hide("slow");jQuery(".deleteimage").hide("slow")}else if(t==1&&e=="audio"){jQuery("#upload_"+e+"").val("");jQuery(".deleteaudio").hide("slow");jQuery("#audioprev").hide("slow")}else{alert("Ajax request failed, please refresh your browser window.")}})}function s(e){var t={action:"easmedia_img_dtl",imgid:e};jQuery.post(ajaxurl,t,function(t){jQuery("#boxinf").hide();jQuery("#currentimg-"+e+" img").show();jQuery("#currentspn-"+e+"").show();jQuery("#currentimg-"+e+"").removeClass("loaderimg");var n=t.split("|~|");jQuery("#easymetaimg").lightbox_me({centered:true,onLoad:function(){jQuery("#thisimgid").val(e);jQuery("#thisttl").val(n[0]);jQuery("#thissubttl").val(n[1]);jQuery("#thisdesc").val(n[2]);jQuery("#easymetaimg").find("input:first").focus()}})})}function o(e,t,n,r){var i={action:"easy_custom_save_function",imgid:e,imgttl:t,imgsbttl:n,imgdesc:r};jQuery.post(ajaxurl,i,function(e){if(e=="101"){jQuery("#boxinf").slideUp(300).fadeIn(400);setTimeout(function(){jQuery("#boxinf").slideUp("slow")},2e3)}})}function u(){jQuery("#g-img-wrap ul").sortable();jQuery("#g-img-wrap ul").disableSelection()}jQuery("#easmedia_metabox_media_video").change(function(){vdo_url=jQuery("#easmedia_metabox_media_video").val();if(vdo_url.match(/ustream\.tv/i)){vdols=vdo_url.replace(/.*src="([^&]*)\?v=.*/,"$1");jQuery("#easmedia_metabox_media_video").val(vdols)}if(vdo_url.match("http://new.livestream.com")){vdols=vdo_url.replace(/.*src="([^&]*)\/player?.*/,"$1");jQuery("#easmedia_metabox_media_video").val(vdols)}});jQuery(".gallitem").tooltip();jQuery(function(){function e(){jQuery("#easymetaimg").lightbox_me({centered:true,onLoad:function(){jQuery("#easymetaimg").find("input:first").focus()}})}});jQuery("#easmedia_metabox_media_type").multiselect({multiple:false,noneSelectedText:"Select",selectedList:1,header:false});jQuery("#easmedia_metabox_media_audio_source").multiselect({multiple:false,noneSelectedText:"",selectedList:1,header:false});jQuery("#videofrmt").on("click",function(){new Messi("<p> - <strong>Youtube 1 :</strong> http://www.youtube.com/watch?v=JaNH56Vpg-A</p><p> - <strong>Youtube 2 :</strong> http://www.youtube.com/embed/JaNH56Vpg-A</p><p> - <strong>Youtube 3 :</strong> http://youtu.be/BWmWAPb_z90</p><p> - <strong>Youtube Playlist :</strong> http://www.youtube.com/watch?v=S_Az2Zg5OLc&list=PLFrmfElpm4lwVff3JvmtSJzxYFFb2093q</p><p> - <strong>Vimeo :</strong> http://vimeo.com/798022</p><p> - <strong>DailyMotion :</strong> http://www.dailymotion.com/swf/1zR7vSr9sneRWgUqL</p><p> - <strong>MetaCafe :</strong> http://www.metacafe.com/watch/2185365/spot_electrabel_gdf_suez_happy_new_year_2009/</p><p> - <strong>Facebook :</strong> https://www.facebook.com/video/embed?video_id=557900707562656</p><p> - <strong>Veoh :</strong> http://www.veoh.com/watch/v20943320Dz9Z45Qj</p><p> - <strong>Flickr video :</strong> http://www.flickr.com/photos/bhl1/2402027765/in/pool-video</p><p> - <strong>Google video :</strong> http://video.google.com/videoplay?docid=-8111235669135653751</p><p> - <strong>Quietube + Youtube :</strong> http://quietube.com/v.php/http://www.youtube.com/watch?v=b5Ff2X_3P_4</p><p> - <strong>Quietube + Vimeo :</strong> http://quietube.com/v.php/http://vimeo.com/2295261</p><p> - <strong>Tudou :</strong> http://www.tudou.com/programs/view/KG2UG_U4DMY/</p><p> - <strong>YouKu :</strong> http://v.youku.com/v_show/id_XNDI1MDkyMDQ</p>",{title:"Sample video format",modal:true})});jQuery("#medvidtut").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/htxwZw_aPF0" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});jQuery("#medsingimgtut").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/dXFBNY5t6E8" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});jQuery("#medgmaptut").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/PEgfleRf6hg" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});jQuery("#medgalltut").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/TQ1MMxhsyD8" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});jQuery("#medgalltut1").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/OEoNB2LpnSE" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});jQuery("#medaump3").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/Bsn-CB5Hpbw" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});jQuery("#medausndcld").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/Oee2cpKT-kE" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});jQuery("#medaurevrb").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/SYH8Yl2SQd4" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});jQuery("#medgallindividual").on("click",function(){new Messi('<iframe width="853" height="480" src="http://www.youtube.com/embed/BWmWAPb_z90" frameborder="0" allowfullscreen></iframe>',{title:"Video Tutorial",modal:true})});easymedia_TBOX=0;jQuery(".easymedia_TBOX").on("click",function(){easymedia_TBOX=1;if(jQuery(this).hasClass("easy_upload")){easymedia_TBOX_type="img"}post_id=jQuery("#post_ID").val();if(easymedia_TBOX_type=="img"){tb_show("","<?php echo admin_url(); ?>media-upload.php?post_id="+post_id+"&type=image&TB_iframe=1")}setInterval(function(){if(easymedia_TBOX==1){if(jQuery("#TB_iframeContent").contents().find("#tab-type_url").is("hidden")){return false}jQuery("#TB_iframeContent").contents().find("#tab-type_url").hide();jQuery("#TB_iframeContent").contents().find("#tab-gallery").hide()}},1)});jQuery(window).bind("tb_unload",function(){if(easymedia_TBOX==1){if(easymedia_TBOX_type=="img"){n(1)}easymedia_TBOX=0}});img_perpage=8;n(1);jQuery("#g-img_list").on("click",".prev_page, .next_page",function(){var e=jQuery(this).attr("id").substr(7);n(e)});jQuery("#imgbutperpage").on("change",function(){var e=jQuery(this).val();if(e.length>=2){if(parseInt(e)<8){img_perpage=8}else{img_perpage=e}n(1)}});jQuery("#g-img_list").on("click","li",function(){var e=jQuery(this).children("img").attr("id");var t=jQuery(this).children("img").attr("src");if(jQuery("#g-img-wrap ul > p").size()>0){jQuery("#g-img-wrap ul").empty()}var n=jQuery('			<li>				<input type="hidden" name="easmedia_meta[easmedia_metabox_media_gallery][]" value="'+e+'" />				<img src="'+t+'" />				<span title="remove image"></span>			</li>').hide();jQuery("#g-img-wrap ul").append(n);n.fadeIn(400);u()});jQuery("#g-img-wrap").on("click","ul li span",function(){jQuery(this).parent().css("background","red").fadeOut(600,function(){jQuery(this).remove();if(jQuery("#g-img-wrap ul li").size()==0){r()}})});jQuery("a.deleteimage").click(function(){var e=confirm("Are you sure you want to delete this image?");if(e){var t="image";i(t)}else{}});jQuery("a.deleteaudio").click(function(){var e=confirm("Are you sure you want to delete this audio?");if(e){var t="audio";i(t)}else{}});jQuery("#g-img-wrap ul li img").hover(function(){jQuery(this).css("opacity",.8)},function(){jQuery(this).css("opacity",1)});jQuery("#g-img-wrap").on("click","ul li img",function(e){var t=jQuery(this).parent().find("[type=hidden]").attr("value");jQuery("#currentimg-"+t+" img").hide();jQuery("#currentspn-"+t+"").hide();jQuery("#currentimg-"+t+"").addClass("loaderimg");s(t);jQuery("#thisttl").val("");jQuery("#thissubttl").val("");jQuery("#thisdesc").val("");jQuery("#thisimgid").val("");e.preventDefault()});jQuery("#easysave").on("click",function(){o(jQuery("#thisimgid").val(),jQuery("#thisttl").val(),jQuery("#thissubttl").val(),jQuery("#thisdesc").val())});u();jQuery("#notifynovalidaudio").hide("slow");jQuery("#upload_audio").change(function(){aud_url=jQuery("#upload_audio").val();if(jQuery("#upload_audio").val().length>0&&jQuery("#easmedia_metabox_media_audio_source").val().length<=3){IsValidAuUrl(aud_url)}else if(jQuery("#upload_audio").val().length>0&&jQuery("#easmedia_metabox_media_audio_source").val().length>3){var e=document.getElementById("easmedia_metabox_media_audio_source").selectedIndex;var t=jQuery("#upload_audio").val();if(e=="1"&&t.match("http://api.soundcloud.com")){soundcloud_id=t.split(/tracks\//)[1].split(/[&"]/)[0];jQuery("#upload_audio").val("https://w.soundcloud.com/player/?url=http://api.soundcloud.com/tracks/"+soundcloud_id)}if(e=="2"&&t.match("http://www.reverbnation.com")){reverb_id=t.split(/html_widget\//)[1].split(/[&?]/)[0];jQuery("#upload_audio").val("http://www.reverbnation.com/widget_code/html_widget/"+reverb_id)}if(e=="3"&&t.match("http://www.4shared.com")){fshared_id=t.split(/embed\//)[1].split(/[&"]/)[0];jQuery("#upload_audio").val("http://www.4shared.com/embed/"+fshared_id)}}else if(jQuery("#upload_audio").val().length<=0){jQuery("#notifynovalidaudio").hide("slow");jQuery(".deleteaudio").hide("fast");jQuery("#audioprev").hide("fast")}})})
									
function IsValidAuUrl1(e){jQuery("#jquery_jplayer_1").jPlayer("destroy");jQuery("#jquery_jplayer_1").jPlayer({ready:function(t){jQuery(this).jPlayer("setMedia",{mp3:e})},swfPath:"<?php echo plugins_url( 'swf/' , __FILE__ ); ?>",supplied:"mp3",volume:100,wmode:"window"})}function IsValidAuUrl(e){jQuery(function(){jQuery.ajax({url:e,success:function(){IsValidAuUrl1(e);jQuery("#notifynovalidaudio").hide("slow");jQuery(".deleteaudio").show("fast");jQuery("#audioprev").show("slow")},fail:function(e,t,n){if(e.status!=200){jQuery("#notifynovalidaudio").show("slow");jQuery("#notifynovalidaudio").html("Unable to load audio from url above. Please make sure it's the <strong>full</strong> URL and a valid one at that.");jQuery(".deleteaudio").hide("fast");jQuery("#audioprev").hide("fast")}}})})}function IsValidImageUrl(e){jQuery("<img>",{src:e,fail:function(){jQuery("#notifynovalidimg").show("slow");jQuery("#notifynovalidimg").html("Unable to load image from url above. Please make sure it's the <strong>full</strong> URL and a valid one at that.");jQuery("#imgpreviewbox").hide("slow");jQuery(".deleteimage").hide("slow")},load:function(){var e={action:"easymedia_imgresize_ajax",imgurl:jQuery("#upload_image").val(),limiter:"210"};jQuery("#imgthumbnailprv").html('<div style="height: 30px;" class="img_loading"></div>');jQuery.post(ajaxurl,e,function(e){jQuery("#imgpreviewbox").hide();var t=e.split(",");jQuery("#imgpreviewbox").css("width",t[1]+"px");jQuery("#imgpreviewbox").css("height",t[2]+"px");jQuery("#imgpreviewbox").fadeIn(500);jQuery("#notifynovalidimg").hide("slow");jQuery("#imgthumbnailprv").attr("src",t[0]);jQuery("#imgpreviewbox").show("slow");jQuery(".deleteimage").show("fast")});return true}})}
  	/*]]>*/
		</script> 
		<?php
		}
	}	
} 

/**
 * Add a custom Meta Box
 *
 * @param array $meta_box Meta box input data
 */
 
function easmedia_add_meta_box( $meta_box )
{
    if ( !is_array( $meta_box ) ) return false;
    
    // Create a callback function
    $callback = create_function( '$post,$meta_box', 'easmedia_create_meta_box( $post, $meta_box["args"] );' );
    add_meta_box( $meta_box['id'], $meta_box['title'], $callback, $meta_box['page'], $meta_box['context'], $meta_box['priority'], $meta_box );
}

/**
 * Create content for a custom Meta Box
 *
 * @param array $meta_box Meta box input data
 */
function easmedia_create_meta_box( $post, $meta_box )
{
	
    if ( !is_array( $meta_box ) ) return false;
    
    if ( isset( $meta_box['description'] ) && $meta_box['description'] != '' ){
    	echo '<p>'. $meta_box['description'] .'</p>';
    }
    
	wp_nonce_field( basename( __FILE__ ), 'easmedia_meta_box_nonce' );
	echo '<table class="form-table easmedia-metabox-table">';
 
	foreach ( $meta_box['fields'] as $field ){
		// Get current post meta data
		$meta = get_post_meta( $post->ID, $field['id'], true );
		echo '<tr class="'. $field['id'] .'"><th><label for="'. $field['id'] .'"><strong>'. $field['name'] .' '. ( $field['defflimit'] == '1' ? '<br>(Default limit : ' .easy_get_option( 'easymedia_img_size_limit' ) . 'px)': ''  ).'</strong>
			  <span>'. $field['desc'] .'</span></label></th>';
		
		switch( $field['type'] ){	
			case 'text':
				echo '<td><input type="text" name="easmedia_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'" size="30" /></td>';
				break;	
				
			case 'video':
				echo '<td>
				<input type="text" name="easmedia_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'" size="30" />
<div style="color:red; display:none;" id="emgvideopreview"></div>				
<div class="videobox" id="" style="display:none;">
<span class="roll" ></span>
<img id="videothumbnailprv" style="display:none;" src="http://placehold.it/300x190" height="190" width="300"/></div>
				</td>';
				break;	
				

			case 'gmap':
				echo '<div id="medgmaptut" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important; margin-bottom:8px;">Video Tutorial</div><td>
				<p>You can learn more how to embed Google Maps through <a target="_blank" href="http://youtu.be/PEgfleRf6hg">this tutorials</a>.</p> 
				<input type="text" name="easmedia_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'" size="30" />
				</td>';
				break;	

				
			case 'link':
				echo '<td>
				<input type="text" name="easmedia_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'" size="30" />
				</td>';
				break;				
				
			case 'textarea':
				echo '<td><textarea name="easmedia_meta['. $field['id'] .']" id="'. $field['id'] .'" rows="10" cols="5">'. ($meta ? $meta : $field['std']) .'</textarea></td>';
				break;
	
				
			case 'gallery':
			
			$images = get_post_meta( $post->ID, 'easmedia_metabox_media_gallery', true ); 
			
				echo '<td></tr>
            <div id="g-img-wrap">
			<div class="emgtooltip_description" style="display:none">You can drag-drop this image to re-order or click to edit image title, subtitle and description. Do not forget to switch ON <strong>Use information of each image</strong> option first.</div>			
            	<ul>';
 
				if ( is_array( $images ) ) {
					foreach( $images as $img_id ) {
						$img_data = get_post( $img_id );
						$img_url = $img_data->guid;
						
						echo '
						<li class="gallitem" id="currentimg-'.$img_id.'">
							<input type="hidden" name="easmedia_meta[easmedia_metabox_media_gallery][]" value="'.$img_id.'" />
							<img src="'.EMG_THUMB_FILE.'?src='.$img_url.'&w=90&h=90" />
							<span id="currentspn-'.$img_id.'" title="remove image"></span>
						</li>';			
					}
				}
				else {echo '<p>No images selected... </p>';}
				
            	echo'</ul>	
            	<br class="metagal_clear">
            </div>
            <div style="clear: both; height: 20px; border-top: 1px solid #DDD; margin-top:5px;"></div>
			<div id="medgalltut" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important; margin-bottom:8px;">Video Tutorial</div>
            <h4>Choose your current images bellow or you can <a href="#" class="easymedia_TBOX easy_upload"> upload another image.</a></h4> 
            <div id="g-img_list"></div><input type="hidden" name="easmedia_meta['. $field['gallid'] .']" value="gallery-'. $post->ID .'" />	
          </div></td>';
				break;				
							
				
			case 'textareackeditor':
			
			if ( is_super_admin() ) {
			
				echo '<td><textarea name="easmedia_meta['. $field['id'] .']" id="'. $field['id'] .'" rows="10" cols="5">'. ($meta ? $meta : $field['std']) .'</textarea>
				</td>';				
			}
			else {
				echo '<td><p>Sorry, you are not allowed to use this item.</p>
				</td>';					
			}		
				
				break;								
						
			case 'file':
				echo '<td><input type="text" name="easmedia_meta['. $field['id'] .']" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['std']) .'" size="30" class="file" /> <input type="button" class="button" name="'. $field['id'] .'_button" id="'. $field['id'] .'_button" value="Browse" /></td>';
				break;

			case 'images': 
			
global $wp_version;			
if ( version_compare($wp_version, "3.5", "<" ) ) {	
$uploaderclass = 'thickbox button add_media';} else {$uploaderclass = 'button insert-media add_media';}			

$dsplynone = 'display:none;';
if ( get_post_meta( $post->ID, 'easmedia_metabox_img', true ) ) {
$attid = wp_get_attachment_image_src( get_attachment_id_from_src( get_post_meta( $post->ID, 'easmedia_metabox_img', true ) ), 'full' );
$curimgpth = easymedia_imgresize( $attid[0], '210', 'on', $attid[1], $attid[2] );
$curimgpth = explode(",", $curimgpth);

( $curimgpth[0] > '10' ) ? $curimgpth[0] = $curimgpth[0] : $curimgpth[0] = '';
( $curimgpth[0] > '10' ) ? $dsplynone = '' : $dsplynone = 'display:none;';	
} else {
	 $dsplynone = 'display:none;';
	 $curimgpth[0] = '';
	 $curimgpth[1] = '';
	 $curimgpth[2] = '';
	}		

echo '<div id="medsingimgtut" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important; margin-bottom:8px;">Video Tutorial</div><td id="imgupld"><input id="upload_image" type="text" name="easmedia_meta['. $field['id'] .']" value="'. ($meta ? $meta : $field['std']) .'" style="margin-bottom:5px;"/><div style="color:red;" id="notifynovalidimg"></div><div class="addmed"><a rel="image" class="' . $uploaderclass . '" title="Add Media" data-editor="content" href="media-upload.php?type=image&TB_iframe=1"><span class="emg-media-buttons-icon"></span>Add Media</a></div>
<a onClick="return false;" style="'. $dsplynone .';" class="deleteimage button" title="Delete Image" href="#"><span class="emg-media-buttons-icon-del"></span>Delete Image</a>

<div style="'. $dsplynone .' width:'.$curimgpth[1].'px; height:'.$curimgpth[2].'px" id="imgpreviewbox" class="imgpreviewboxc">
<img id="imgthumbnailprv" src="' . $curimgpth[0] . '"/></div>
</td>';
			    break;

			case 'audio': 
			
global $wp_version;			
if ( version_compare($wp_version, "3.5", "<" ) ) {	
$uploaderclass = 'thickbox button add_media';} else {$uploaderclass = 'button insert-media add_media';}			

$adsplynone = 'display:none;';
$curaudiopth = get_post_meta($post->ID, 'easmedia_metabox_media_audio', true);
$curaudiosrc = get_post_meta($post->ID, 'easmedia_metabox_media_audio_source', true);
( $curaudiopth != '' && strlen( $curaudiosrc ) <= 3 ) ? $adsplynone = '' : $adsplynone = 'display:none;';	

if ( $curaudiopth != '' && strlen( $curaudiosrc ) <= 3 ) { echo '
<script type="text/javascript">
    jQuery(function () {
		var thisaudiourl = "' .$curaudiopth. '";
    IsValidAuUrl1(thisaudiourl);
    });
    </script>	
'; }

echo '<div id="medaump3" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important; margin-bottom:8px;">Video Tutorial (Embed mp3)</div>
<div id="medausndcld" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important; margin-bottom:8px;">Video Tutorial (Embed Soundcloud)</div>
<div id="medaurevrb" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important; margin-bottom:8px;">Video Tutorial (Embed Reverbnation)</div>
<td id="audioupld"><input id="upload_audio" type="text" name="easmedia_meta['. $field['id'] .']" value="'. ($meta ? $meta : $field['std']) .'" style="margin-bottom:5px;"/><div style="color:red;" id="notifynovalidaudio"></div><div class="addmed"><a rel="audio" class="' . $uploaderclass . '" title="Add Media" data-editor="content" href="media-upload.php?type=image&TB_iframe=1"><span class="emg-media-buttons-icon"></span>Add Media</a></div>
<a onClick="return false;" style="'. $adsplynone .';" class="deleteaudio button" title="Delete Audio" href="#"><span class="emg-media-buttons-icon-del"></span>Delete Audio</a>

<div style="'. $adsplynone .';" id="audioprev" class="vidpreviewboxc">
	<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div id="jp_container_1" class="jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<ul class="jp-controls">
						<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
						<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
						<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
					</ul>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<div class="jp-current-time"></div>
					<div class="jp-duration"></div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>

</div>
</td>';
			    break;				
	
			case 'select':
				echo'<td><select style="width:200px;" name="easmedia_meta['. $field['id'] .']" id="'. $field['id'] .'">';
				foreach ( $field['options'] as $key => $option ){
					echo '<option value="' . $option . '"';
					if ( $meta ){ 
						if ( $meta == $option ) echo ' selected="selected"'; 
					}
					echo'>'. $option .'</option>';
				}
				echo'</select></td>';
				break;

			case 'radio':
				echo '<td>';
				foreach ( $field['options'] as $key => $option ){
					echo '<label class="radio-label"><input type="radio" name="easmedia_meta['. $field['id'] .']" value="'. $key .'" class="radio"';
					if ( $meta ){ 
						if ( $meta == $key ) echo ' checked="checked"'; 
					} else {
						if ( $field['std'] == $key ) echo ' checked="checked"';
					}
					echo ' /> '. $option .'</label> ';
				}
				echo '</td>';
				break;
			
			case 'color':
			    if ( array_key_exists('val', $field) ) $val = ' value="' . $field['val'] . '"';
			    if ( $meta ) $val = ' value="' . $meta . '"';
			    echo '<td>';
                echo '<div class="colorpicker-wrapper">';
                echo '<input type="text" id="'. $field['id'] .'_cp" name="easmedia_meta[' . $field['id'] .']"' . $val . ' />';
                echo '<div id="' . $field['id'] . '" class="colorpicker"></div>';
                echo '</div>';
                echo '</td>';
			    break;
				
			case 'checkbox':
			    echo '<td>';
			    $val = '';
                if ( $meta ) {
                    if ( $meta == 'on' ) $val = ' checked="checked"';
                } else {
                    if ( $field['std'] == 'on' ) $val = ' checked="checked"';
                }

                echo '<input type="hidden" name="easmedia_meta['. $field['id'] .']" value="off" />
                <input class="switch" type="checkbox" id="'. $field['id'] .'" name="easmedia_meta['. $field['id'] .']" value="on"'. $val .' /> ';
			    echo '</td>';
			    break;


			case 'checkboxoptdef':
			    echo '<td>';
			    $val = '';
                if ( $meta ) {
                    if ( $meta == 'on' ) { $val = ' checked="checked"';
					}
                } else {

                    if ( $field['std'] == 'on' ) { $val = ' checked="checked"';
					}
                }

                echo '<div style="margin-bottom:15px !important;"><input type="hidden" name="easmedia_meta['. $field['id'] .']" value="off" />
                <input class="switch" type="checkbox" id="'. $field['id'] .'" name="easmedia_meta['. $field['id'] .']" value="on" '. $val .' /></div>
				';
			    echo '</td>';
			    break;	
				
			case 'checkboxopt':
			    echo '<td>';
			    $val = '';
                if ( $meta ) {
                    if ( $meta == 'on' ) { $val = ' checked="checked"';
					
					echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#vidcustomsize").hide("slow");
    });
    </script>'; }
	
		else {
		
	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#vidcustomsize").show("slow");
    });
    </script>';
	}
                } else {
						echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#vidcustomsize").show("slow");
    });
    </script>';
					
                    if ( $field['std'] == 'on' ) { $val = ' checked="checked"';
					
	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#vidcustomsize").hide("slow");
    });
    </script>';
					}
	else {	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#vidcustomsize").show("slow");
    });
    </script>';
	}
                }

                echo '<div style="margin-bottom:15px !important;"><input type="hidden" name="easmedia_meta['. $field['id'] .']" value="off" />
                <input class="switch" type="checkbox" id="'. $field['id'] .'" name="easmedia_meta['. $field['id'] .']" value="on" '. $val .' /></div>
			<div id="vidcustomsize" style="border-top: 1px solid #ccc; padding-top: 10px;">
				 	Video custom size : <div style="margin-top:10px; margin-bottom:10px;"><strong>Width</strong> <input style="margin-right:5px !important; margin-left:3px; width:43px !important; float:none !important;" name="easmedia_meta['. $field['id'] .'_'.$field['width'].']" id="'. $field['id'] .'[width]" type="text" value="' .get_post_meta($post->ID, 'easmedia_metabox_media_video_size_'. $field['width'] .'', true).'" />  ' .$field['pixopr']. '

<span style="border-right:solid 1px #CCC;margin-left:9px; margin-right:10px !important; "></span>

 	<strong>Height</strong> <input style="margin-left:3px; margin-right:5px !important; width:43px !important; float:none !important;" name="easmedia_meta['. $field['id'] .'_'.$field['height'].']" id="'. $field['id'] .'[height]" type="text" value="' .get_post_meta($post->ID, 'easmedia_metabox_media_video_size_'. $field['height'] .'', true).'" /> ' .$field['pixopr']. ' </div></div>

				';
			    echo '</td>';
			    break;
				
				
				
			case 'checkboxoptmap':
			    echo '<td>';
			    $val = '';
                if ( $meta ) {
                    if ( $meta == 'on' ) { $val = ' checked="checked"';
					
					echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#gmapcustomsize").hide("slow");
    });
    </script>'; }
	
		else {
		
	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#gmapcustomsize").show("slow");
    });
    </script>';
	}
                } else {
						echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#gmapcustomsize").show("slow");
    });
    </script>';
					
                    if ( $field['std'] == 'on' ) { $val = ' checked="checked"';
					
	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#gmapcustomsize").hide("slow");
    });
    </script>';
					}
	else {	echo '<script type="text/javascript">
    jQuery(function () {
	jQuery("#gmapcustomsize").show("slow");
    });
    </script>';
	}
                }

                echo '<div style="margin-bottom:15px !important;"><input type="hidden" name="easmedia_meta['. $field['id'] .']" value="off" />
                <input class="switch" type="checkbox" id="'. $field['id'] .'" name="easmedia_meta['. $field['id'] .']" value="on" '. $val .' /></div>
			<div id="gmapcustomsize" style="border-top: 1px solid #ccc; padding-top: 10px;">
				 	Maps custom size : <div style="margin-top:10px; margin-bottom:10px;"><strong>Width</strong> <input style="margin-right:5px !important; margin-left:3px; width:43px !important; float:none !important;" name="easmedia_meta['. $field['id'] .'_'.$field['width'].']" id="'. $field['id'] .'[width]" type="text" value="' .get_post_meta($post->ID, 'easmedia_metabox_media_gmap_size_'. $field['width'] .'', true).'" />  ' .$field['pixopr']. '

<span style="border-right:solid 1px #CCC;margin-left:9px; margin-right:10px !important; "></span>

 	<strong>Height</strong> <input style="margin-left:3px; margin-right:5px !important; width:43px !important; float:none !important;" name="easmedia_meta['. $field['id'] .'_'.$field['height'].']" id="'. $field['id'] .'[height]" type="text" value="' .get_post_meta($post->ID, 'easmedia_metabox_media_gmap_size_'. $field['height'] .'', true).'" /> ' .$field['pixopr']. ' </div></div>

				';
			    echo '</td>';
			    break;						
								
		}
		
		echo '</tr>';
	}
 
	echo '</table>';
}

/*-----------------------------------------------------------------------------------*/
/*	Register related Scripts and Styles
/*-----------------------------------------------------------------------------------*/
function easmedia_metabox_media_scripts() {
	wp_enqueue_script( 'thickbox' );
}
function easmedia_metabox_media_styles() {
	wp_enqueue_style( 'thickbox' );
}
add_action( 'admin_enqueue_scripts', 'easmedia_metabox_media_scripts' );
add_action( 'admin_print_styles', 'easmedia_metabox_media_styles' );


	// SELECT MEDIA METABOX
add_action( 'add_meta_boxes', 'easmedia_metabox_work' );
function easmedia_metabox_work(){
	    $meta_box = array(
		'id' => 'easmedia_metaboxmediatypeselect',
		'title' =>  __( 'Media Options', 'easmedia' ),
		'description' => __( 'Select videos, images, gallery or audio files.', 'easmedia' ),
		'page' => 'easymediagallery',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array(
		
					'name' => __( 'Media Type', 'easmedia' ),
					'desc' => __( 'Choose the item type.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_type',
					'type' => 'select',
					'defflimit' => '0',
					'options' => array( 'Select', 'Single Image', 'Multiple Images (Slider)', 'Video', 'Audio', 'Google Maps', 'Link' ),
					'std' => 'Select')
				),				
				
	);
    easmedia_add_meta_box( $meta_box );	
	
	
	// VIDEO METABOX
	    $meta_box = array(
		'id' => 'easmedia_metaboxmediavideo',
		'title' =>  __( 'Video Options', 'easmedia' ),
		'description' => __( '<div id="videofrmt" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important; margin-bottom:8px;">Sample video format</div>
				<div id="medvidtut" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important; margin-bottom:8px;">Video Tutorial</div><br>Paste video URL to field below.', 'easmedia' ),
		'page' => 'easymediagallery',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
		
			array(
		
					'name' => __( 'Video URL (Embed/MP4/WMV)', 'easmedia' ),
					'desc' => __( 'Use this field to embed video, MP4 video type or WMV video type.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_video',
					'type' => 'video',
					'defflimit' => '0',
					'std' => ''
					
				),
				
			array(				
					
					'name' => __( 'WebM Video Type', 'easmedia' ),
					'desc' => __( 'Use this field if you want to add WebM Video Type, or leave blank if no need it.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_video_webm',
					'type' => 'video',
					'defflimit' => '0',
					'std' => '',
					
				),	
								
			array(						
					'name' => __( 'Ogg/Vorbis Video Type', 'easmedia' ),
					'desc' => __( 'Use this field if you want to add Ogg/Vorbis Video Type, or leave blank if no need it.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_video_ogg',
					'type' => 'video',
					'defflimit' => '0',
					'std' => ''										
					
				 ),
							
			array(
					'name' => __( 'Video Size', 'easmedia' ),
					'desc' => __( 'If ON, video size will use the default settings on the control panel.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_video_size',
					'type' => 'checkboxopt',
					'defflimit' => '0',
					'width' => 'vidw',
					'height' => 'vidh',
					'std' => 'on',
					"pixopr" => 'px',
					)
				)
	);
    easmedia_add_meta_box( $meta_box );
	
	
	// GALLERY METABOX
	    $meta_box = array(
		'id' => 'easmedia_metaboxmediagallery',
		'title' =>  __( 'Gallery Options', 'easmedia' ),
		'description' => __( '', 'easmedia' ),
		'page' => 'easymediagallery',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
		
			array(
		
					'name' => __( '', 'easmedia' ),
					'desc' => __( '', 'easmedia' ),
					'id' => 'easmedia_metabox_media_gallery',
					'gallid' => 'easmedia_metabox_media_gallery_id',
					'type' => 'gallery',
					'defflimit' => '0',
					'std' => ''
					
				 ),
							
			array(
					'name' => __( 'Full-size image control', 'easmedia' ),
					'desc' => __( 'If ON, image which exceeds the specified size limit will be automatically resized. You can change image size limit through plugin control panel.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_gallery_opt1',
					'type' => 'checkboxoptdef',
					'defflimit' => '1',
					'std' => 'on'
					),
					
			array(
					'name' => __( 'Use information of each image', 'easmedia' ),
					'desc' => __( 'If ON, each image will use individual title, sub title and description based on Wordpress Media informations. If OFF, this gallery will use title, sub title and description from Media Informations below.<div id="medgallindividual" style="text-decoration:underline;font-weight:bold;cursor:Pointer; color:#1A91F2 !important;">Learn More Here</div>', 'easmedia' ),
					'id' => 'easmedia_metabox_media_gallery_opt2',
					'type' => 'checkboxoptdef',
					'defflimit' => '0',
					'std' => 'off'
					)					
					
					
				)
	);
    easmedia_add_meta_box( $meta_box );		


	// GOOGLE MAPS METABOX
	    $meta_box = array(
		'id' => 'easmedia_metaboxmediagmap',
		'title' =>  __( 'Map Options', 'easmedia' ),
		'description' => __( 'Paste Google Maps URL to field below.', 'easmedia' ),
		'page' => 'easymediagallery',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
		
			array(
		
					'name' => __( 'Google Maps URL', 'easmedia' ),
					'desc' => __( '', 'easmedia' ),
					'id' => 'easmedia_metabox_media_gmap',
					'type' => 'gmap',
					'defflimit' => '0',
					'std' => ''
					
				 ),
							
			array(
					'name' => __( 'Maps Size', 'easmedia' ),
					'desc' => __( 'If ON, maps size will use the default settings on the control panel.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_gmap_size',
					'type' => 'checkboxoptmap',
					'width' => 'gmidw',
					'height' => 'gmidh',
					'defflimit' => '0',
					'std' => 'on',
					"pixopr" => 'px',
					)
				)
	);
    easmedia_add_meta_box( $meta_box );

	
	// LINK METABOX	
	    $meta_box = array(
		'id' => 'easmedia_metaboxmedialink',
		'title' =>  __( 'Link Options', 'easmedia' ),
		'description' => __( 'Paste internal or external URL / LINK on field below.', 'easmedia' ),
		'page' => 'easymediagallery',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
		
			array(
		
					'name' => __( 'Link / URL', 'easmedia' ),
					'desc' => __( '', 'easmedia' ),
					'id' => 'easmedia_metabox_media_link',
					'type' => 'link',
					'defflimit' => '0',
					'std' => ''
					
				 ),
							
			array(
					'name' => __( 'Open link in new window', 'easmedia' ),
					'desc' => __( 'If ON, your link will open in new window.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_link_opt1',
					'type' => 'checkboxoptdef',
					'defflimit' => '0',
					'std' => 'on'
					)
				)
	);
    easmedia_add_meta_box( $meta_box );		
	
	
	// AUDIO METABOX		
	    $meta_box = array(
		'id' => 'easmedia_metaboxmediaaudio',
		'title' =>  __( 'Audio Options', 'easmedia' ),
		'description' => __( 'Upload audio or paste audio URL on field below.', 'easmedia' ),
		'page' => 'easymediagallery',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
		
			array(
		
					'name' => __( 'Audio Source', 'easmedia' ),
					'desc' => __( 'Choose the audio source.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_audio_source',
					'type' => 'select',
					'defflimit' => '0',
					'options' => array( 'MP3', 'soundcloud.com', 'reverbnation.com' ),
					'std' => 'MP3'
				),
		
			array(
		
					'name' => __( 'Audio Path / ID', 'easmedia' ),
					'desc' => __( '', 'easmedia' ),
					'id' => 'easmedia_metabox_media_audio',
					'type' => 'audio',
					'defflimit' => '0',
					'std' => ''
					)
				 
				)
	);
    easmedia_add_meta_box( $meta_box );		
			

	// SINGLE IMAGE/GALLERY IMAGE THUMBNAIL (FOR ALL MEDIA) 
	    $meta_box = array(
		'id' => 'emediaimagediv',
		'title' =>  __( 'Select Image', 'easmedia' ),
		'description' => __( 'You can upload image with supported file types: jpg, jpeg, gif, png.', 'easmedia' ),
		'page' => 'easymediagallery',
		'context' => 'normal',
		'priority' => 'default',
		'fields' => array(
			array(
					'name' => __( 'Image URL', 'easmedia' ),
					'desc' => __( 'Select or upload your image.', 'easmedia' ),
					'id' => 'easmedia_metabox_img',
					'type' => 'images',
					'defflimit' => '0',
					'std' => ''
				 ),
							
			array(
					'name' => __( 'Full-size image control', 'easmedia' ),
					'desc' => __( 'If ON, image which exceeds the specified size limit will be automatically resized. You can change image size limit through plugin control panel.', 'easmedia' ),
					'id' => 'easmedia_metabox_media_image_opt1',
					'type' => 'checkboxoptdef',
					'defflimit' => '1',
					'std' => 'on'
					)
				)					
				
	);
    easmedia_add_meta_box( $meta_box );		


	// MEDIA DESC METABOX
    $meta_box = array(
		'id' => 'easmedia_metabox_media_desc',
		'title' =>  __( 'Media Informations', 'easmedia' ),
		'description' => __( 'Input basic info for this media.', 'easmedia' ),
		'page' => 'easymediagallery',
		'context' => 'normal',
		'priority' => 'low',
		'fields' => array(
			array(
					'name' => __( 'Media Title', 'easmedia' ),
					'desc' => __( 'Enter a media title.', 'easmedia' ),
					'id' => 'easmedia_metabox_title',
					'type' => 'text',
					'defflimit' => '0',
					'std' => ''
				),
				
			array(
					'name' => __( 'Media Sub Title', 'easmedia' ),
					'desc' => __( 'You can use this sub title field for (ex: author, title track, etc...)', 'easmedia' ),
					'id' => 'easmedia_metabox_sub_title',
					'type' => 'text',
					'defflimit' => '0',
					'std' => ''
				),				
				

			array(
					'name' => __( 'Media Description', 'easmedia' ),
					'desc' => __( 'Enter description for your media.', 'easmedia' ),
					'id' => 'easmedia_metabox_shordesc',
					'type' => 'textareackeditor',
					'defflimit' => '0',
					'std' => __( '', 'easmedia' )
				)
		)
	);
    easmedia_add_meta_box( $meta_box );

}


//-----------------------------------------------------------------------------------------------------------------

/**
 * Save custom Meta Box
 *
 * @param int $post_id The post ID
 */
function easmedia_save_meta_box( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	
	if ( !isset( $_POST['easmedia_meta'] ) || !isset( $_POST['easmedia_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['easmedia_meta_box_nonce'], basename( __FILE__ ) ) )
		return;
	
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) return;
	} else {
		if ( !current_user_can( 'edit_post', $post_id ) ) return;
	}
			foreach( $_POST['easmedia_meta'] as $key => $val ) {
			if ( !is_array( $val ) ) {
				$_POST['easmedia_meta'][$key] = stripslashes( $val );
			}
			else {
				$_POST['easmedia_meta'][$key] = array();
				foreach( $val as $arr_val ) {$_POST['easmedia_meta'][$key][] = stripslashes( $arr_val );}
			}
		}
		// save data
		foreach( $_POST['easmedia_meta'] as $key => $val ) {
			delete_post_meta( $post_id, $key );
			add_post_meta( $post_id, $key, $_POST['easmedia_meta'][$key], true ); 
		}
}
add_action( 'save_post', 'easmedia_save_meta_box' );

?>