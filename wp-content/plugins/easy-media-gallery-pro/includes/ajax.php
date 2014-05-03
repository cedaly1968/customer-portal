<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

if ( isset( $_GET['id'] ) && !empty( $_GET['id'] ) ) {
	$devmedia = '';
	if ( strpos( $_GET['id'],'-' ) ) {
		$devmedia = explode("-", $_GET['id']);
		ajax_req_handle( $devmedia[0] , $devmedia[1] );
	}
	else {
		ajax_req_handle( $_GET['id'], "" );
	}
}

else {
}

function ajax_req_handle( $id, $isdinamccntn ) {
	
	global $post;
	

	$usegalleryinfo = get_post_meta( $id, 'easmedia_metabox_media_gallery_opt2', true );

	if ( $isdinamccntn != '' ) {
		
		if ( $usegalleryinfo == 'on' ) {
			$img_info = get_post( $isdinamccntn );
			$boxmediattl = $img_info->post_title;
			$boxmediasbttl = $img_info->post_excerpt;
			$boxshortdecs =  $img_info->post_content;
			$boxshortdecs =  str_replace("\r","",$boxshortdecs);
			$boxshortdecs =  str_replace("\n","",$boxshortdecs);			
		}
		else {
			$boxshortdecs = get_post_meta( $id, 'easmedia_metabox_shordesc', true );
			$boxmediattl = get_post_meta( $id, 'easmedia_metabox_title', true );
			$boxmediasbttl = get_post_meta( $id, 'easmedia_metabox_sub_title', true );
		}
	}
	else {
		$boxshortdecs = get_post_meta( $id, 'easmedia_metabox_shordesc', true );
		$boxmediattl = get_post_meta( $id, 'easmedia_metabox_title', true );
		$boxmediasbttl = get_post_meta( $id, 'easmedia_metabox_sub_title', true );
		}
	
	
	$imgsrc = get_post_meta( $id, 'easmedia_metabox_img', true );
	$mediatype = get_post_meta( $id, 'easmedia_metabox_media_type', true );
	$domname = preg_replace( '/^www\./','',$_SERVER['SERVER_NAME'] );	
	
	
	switch ( $mediatype ) {
		case 'Single Image':
		$boxlink = $imgsrc;
	        break;
			
		case 'Multiple Images (Slider)':
		$boxlink = wp_get_attachment_image_src($isdinamccntn, 'full');
		$imgsrc = $boxlink[0];
		$boxlink = $boxlink[0];
		//$boxlink = $imgsrc;
	        break;			
			
		case 'Video':
		$boxlink = get_post_meta( $id, 'easmedia_metabox_media_video', true );
	        break;
			
		case 'Audio':
		$boxlink = get_post_meta( $id, 'easmedia_metabox_media_audio', true );
	        break;		
			
		case 'Google Maps':
		$boxlink = get_post_meta( $id, 'easmedia_metabox_media_gmap', true );
	        break;				
			
		case 'Link':
		$boxlink = get_post_meta( $id, 'easmedia_metabox_media_link', true );
		$link_type = get_post_meta( $id, 'easmedia_metabox_media_link_opt1', true );		
		if ( $boxlink !='' ) {
			$media_link_fin = $boxlink; } else {
			$media_link_fin = $post->guid;
		}
		
		$boxlink = $media_link_fin;
	        break;			
	}
	
	$isfb = easy_get_option( 'easymedia_disen_fb' ); $istwt = easy_get_option( 'easymedia_disen_twt' ); $ispin = easy_get_option( 'easymedia_disen_pin' );

	$tempdesc = strlen( $boxshortdecs );
	$trim_length = 200;
			if ( $boxshortdecs ) {
				
		if ( $tempdesc>$trim_length ) {
			$shortenerdesc = rtrim( substr( $boxshortdecs,0,$trim_length-3 ) );	
        $shortenerdesc = $shortenerdesc . "...";
   			}	else {
			$shortenerdesc = rtrim( substr( $boxshortdecs,0,$trim_length ) );	
			}
		}
		else {
		$shortenerdesc = "Description goes here...";
		} 

	if ( $boxmediattl == '' && get_the_title( $id ) == '' ) {$sharemediattl = 'Media';}
	else if ( $boxmediattl == '' && get_the_title( $id ) != '' ) {$sharemediattl = get_the_title( $id );}	
	

ob_start();	

if ( $isfb || $istwt || $ispin ): ?>

              <div id="mbsosmed">
            	<ul>
                <?php if ( $isfb ): ?>
                  <li id="sosmedfb">
					<a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo urlencode( $sharemediattl ); ?>&amp;p[summary]=<?php echo strip_tags( $shortenerdesc ); ?>&amp;p[url]=***&amp;&amp;p[images][0]=<?php echo urlencode( $imgsrc ); ?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><span title="Share it!"></span></a>
                  </li>
                  <?php endif; ?>

                <?php if ( $istwt ): ?>
                  <li id="sosmedtw">
					<a onClick="window.open('https://twitter.com/share?text=<?php echo urlencode( 'Check out "'.$sharemediattl.'" on '.get_bloginfo( 'name' ) ); ?>&url=***','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"><span title="Tweet it!"></span></a>
                  </li>
                  <?php endif; ?>
                  
                <?php if ( $ispin ): ?>                  
                  <li id="sosmedpn">
                  	<a onClick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo urlencode( $boxlink ); ?>&media=<?php echo urlencode( $imgsrc ); ?>&description=<?php echo strip_tags( $shortenerdesc ); ?>','sharer','toolbar=0,status=0,width=575,height=330');" href="javascript: void(0)"><span title="Pin it!"></span></a>
                  </li>
                  <?php endif; ?>                  
                </ul>
              </div>
            <?php endif;;

$content = ob_get_clean();

	if ( $boxmediattl == '' ) {$boxmediattl = 'none';}
	if ( $content =='' ) {$content = 'none';}
	if ( $boxmediasbttl =='' ) {$boxmediasbttl = 'none';}
	if ( $boxshortdecs =='' ) {$boxshortdecs = 'none';}
	
$therest = array( $boxmediattl,$boxmediasbttl,html_entity_decode(htmlspecialchars($boxshortdecs)),$content );
echo json_encode( $therest );
exit;
}

?>