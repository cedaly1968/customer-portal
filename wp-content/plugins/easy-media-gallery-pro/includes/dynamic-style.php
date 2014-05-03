<?php header("Content-type: text/css; charset: UTF-8"); ?>
<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

//Get Plugin settings
$frmcol = easy_get_option( 'easymedia_frm_col' );
$shdcol = easy_get_option( 'easymedia_shdw_col' );
$mrgnbox = easy_get_option( 'easymedia_margin_box' );
$imgborder = easy_get_option( 'easymedia_frm_border' );
$curstyle = strtolower( easy_get_option( 'easymedia_cur_style' ) );
$cuscss = easy_get_option( 'easymedia_custom_css' );
$imgbbrdrradius = easy_get_option( 'easymedia_brdr_rds' );
$disenbor = easy_get_option( 'easymedia_disen_bor' );
$disenshadow = easy_get_option( 'easymedia_disen_sdw' );
$brdrbtm = $mrgnbox * 2;
$marginhlf = $mrgnbox / 2;
$theoptstl = easy_get_option( 'easymedia_frm_size' );
$globalwidth = stripslashes( $theoptstl[ 'width' ] );
$pattover = easy_get_option( 'easymedia_style_pattern' );
$overcol = easy_get_option( 'easymedia_overlay_col' );
$fltrcol = easymedia_hex2rgb( easy_get_option( 'easymedia_filter_col' ) );
$ttlcol = easy_get_option( 'easymedia_ttl_col' );
$thumbhov = ucfirst( easy_get_option( 'easymedia_hover_style' ) ) . '.png';
$thumbhov = plugins_url( 'css/images/' . $thumbhov . '', dirname(__FILE__) );
$thumbhovcol = easymedia_hex2rgb( easy_get_option( 'easymedia_thumb_col' ) );
$thumbhovcolopcty = easy_get_option( 'easymedia_hover_opcty' ) / 100;
$thumbiconcol = easy_get_option( 'easymedia_icon_col' );
$disenico = easy_get_option( 'easymedia_disen_ticon' );
$borderrgba = easymedia_hex2rgb( easy_get_option( 'easymedia_frm_col' ) );
$borderrgbaopcty = easy_get_option( 'easymedia_thumb_border_opcty' ) / 100;
$thumbttlpos = easy_get_option( 'easymedia_ttl_pos' );


// IMAGES
echo '.view {margin-bottom:'.$mrgnbox.'px; margin-right:'.$marginhlf.'px; margin-left:'.$marginhlf.'px;}';
echo '.da-thumbs article.da-animate p{color:'.$ttlcol.' !important;}';
if ( easy_get_option( 'easymedia_disen_icocol' ) == '1' ) {
echo 'span.link_post, span.zoom {background-color:'.$thumbiconcol.';}';
}

if ( easy_get_option( 'easymedia_disen_hovstyle' ) == '1' ) {
echo '.da-thumbs article.da-animate {cursor: '.$curstyle.';}';
}
else {
echo '.da-thumbs img {cursor: '.$curstyle.';}';
}

( $imgbbrdrradius != '' ) ? $addborradius = '.view,.view img,.da-thumbs,.da-thumbs article.da-animate {border-radius:'.$imgbbrdrradius.'px;}' : $addborradius = '';
echo $addborradius;

( $disenbor == 1 ) ? $addborder = '.view {border: '.$imgborder.'px solid rgba('.$borderrgba.','.$borderrgbaopcty.');}' : $addborder = '';
echo $addborder; 

( $disenico == 1 ) ? $showicon = '' : $showicon = '.forspan {display: none !important;}' ;
echo $showicon; 

( $disenshadow == 1 ) ? $addshadow = '.view {-webkit-box-shadow: 1px 1px 3px '.$shdcol.';
   -moz-box-shadow: 1px 1px 3px '.$shdcol.';
   box-shadow: 1px 1px 3px '.$shdcol.';}' : $addshadow = '.view { box-shadow: none !important; -moz-box-shadow: none !important; -webkit-box-shadow: none !important;}';
echo $addshadow; 

// MEDIA BOX Patterns
if ( $pattover != '' || $pattover != 'no_pattern' ) {	
echo '#mbOverlay {background: url(../css/images/patterns/'.$pattover.'); background-repeat: repeat;}';
}

// MEDIA BOX Color Overlay
if ( $overcol != '' ) {	
echo '#mbOverlay {background-color:'.$overcol.';}';
}

// MEDIA BOX Title Position
if ( $thumbttlpos == 'Top' ) {	
echo '.da-thumbs article.da-animate p{margin-top: 0px !important; top:0px;}';
}
else if ( $thumbttlpos == 'Bottom' ) {	
echo '.da-thumbs article.da-animate p{margin-bottom: 0px !important; bottom:0px;}';
}

// MEDIA FILTER
echo '#emgoptions .portfolio-tabs a:hover, #emgoptions a.selected {color: rgb('.$fltrcol.') !important;}';
echo '#emgoptions a.selected {border-top: 3px solid rgb('.$fltrcol.') !important;}';

// IE <8 Handle

		preg_match( '/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches );
		if ( count( $matches )>1 && $disenbor == 1 ){
			$version = explode(".", $matches[1]);
			switch(true){
				case ( $version[0] <= '8' ):
				echo '.view {border: 1px solid '.$shdcol.';}';
				echo '.iehand {border: '.$imgborder.'px solid '.$frmcol.';}';
				echo '.da-thumbs article{position: absolute; background-image:url('.$thumbhov.'); background-repeat:repeat; width: 100%; height: 100%;}';
			break; 
			  
				case ( $version[0] > '8' ):

( $disenbor == 1 ) ? $addborder = '.view {border: '.$imgborder.'px solid rgba('.$borderrgba.','.$borderrgbaopcty.');}' : $addborder = '';
echo $addborder; 			  
echo '.da-thumbs article{position: absolute; background: rgba('.$thumbhovcol.','.$thumbhovcolopcty.'); background-repeat:repeat; width: 100%; height: 100%;}';			  
			  
			break; 			  
			  
			  
			  default:
			}
		}
		
		else if ( count( $matches )>1 && $disenbor != '1' ) {
			echo '.da-thumbs article{position: absolute; background-image:url('.$thumbhov.'); background-repeat:repeat; width: 100%; height: 100%;}';
			}
		  
		else {
				echo '.da-thumbs article{position: absolute; background: rgba('.$thumbhovcol.','.$thumbhovcolopcty.'); background-repeat:repeat; width: 100%; height: 100%;}';
			} 


// Gallery Nav
if ( easy_get_option( 'easymedia_disen_galnav' ) == '1' ) {

echo '#mbPrevLink {
    	background: url("../css/images/prev.png") no-repeat scroll 0% 0% transparent !important;
    	width: 40px !important;
    	height: 80px !important;
		position: absolute !important;
		left: 15px !important;
		z-index:100000;
		opacity: 0.7;
		outline: none !important;
		margin-top:-100px !important;
}

#mbNextLink {
    	background: url("../css/images/next.png") no-repeat scroll 0% 0% transparent !important;
    	width: 40px !important;
    	height: 80px !important;
		position: absolute !important;
		right: 15px !important;
		z-index:100000;	
		opacity: 0.7;
		outline: none !important;
		margin-top:-100px !important;
}';

}

// Share Button Style
if ( easy_get_option( 'easymedia_sos_pos' ) == 'Top' ) {

echo '#mbsosmed ul #sosmedfb span {
	background: url(../css/images/sprite_sosmed.png) no-repeat -53px 0px transparent;}

#mbsosmed ul #sosmedfb span:hover {
	background: url(../css/images/sprite_sosmed.png) no-repeat -53px -25px transparent;}

#mbsosmed ul #sosmedtw span {
	background: url(../css/images/sprite_sosmed.png) no-repeat -27px 0px transparent;}

#mbsosmed ul #sosmedtw span:hover {
	background: url(../css/images/sprite_sosmed.png) no-repeat -27px -25px transparent;}

#mbsosmed ul #sosmedpn span {
	background: url(../css/images/sprite_sosmed.png) no-repeat -1px 0px transparent;		
	opacity: 0.7;}

#mbsosmed ul #sosmedpn span:hover {
	background: url(../css/images/sprite_sosmed.png) no-repeat -1px -25px transparent;}';
}

// Magnify Icon
if ( easy_get_option( 'easymedia_mag_icon' ) != '' && $disenico == 1 ) {	
echo '	
span.zoom{
background-image:url(../css/images/magnify/'.easy_get_option( 'easymedia_mag_icon' ).'.png); background-repeat:no-repeat; background-position:center;
}';	
}


// CUSTOM CSS
if ( $cuscss != '' ) {
echo $cuscss ; 
echo "\n"; 
}
?>