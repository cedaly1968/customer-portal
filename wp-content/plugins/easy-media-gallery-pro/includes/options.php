<?php

/*------------------------------------------------------------------------------------*/
/*  Easy Media Gallery
/*  Option Control Panel
/*  require_once settings.php
/*------------------------------------------------------------------------------------*/

// VARIABLES
$emgplugname = "Easy Media Gallery Pro";
$theshort = "easymedia";

// Set the Options Array
$theopt = array (
 
array( "name" => $emgplugname." Options",
	"type" => "title"),
 
array( "name" => "General",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Columns",
	"desc" => "Select default Column for each media block, you can also set this manually when adding shortcode.",
	"id" => $theshort."_columns",
	"type" => "select",
	"options" => array("1", "2", "3", "4", "5", "6", "7", "8"),
	"std" => "3"),	
	
array( "name" => "Alignment",
	"desc" => "Select image block or single image alignment. Default: Center",
	"id" => $theshort."_alignstyle",
	"type" => "select",
	"options" => array( "none", "Left", "Center", "Right" ),
	"std" => "Center"),		

array( "name" => "Media Box Margin",
	"desc" => "Set the space between media. Default margin for each media : 12px.",
	"id" => $theshort."_margin_box",
	"type" => "slider",
	"usestep" => "0",
	"max" => "35",
	"pixopr" => "px",	
	"std" => "12"),
	
array( "name" => "Full-size image limit",
	"desc" => "Set the limit for image width on full-size, image height will adjust automatically. Default: 940px.",
	"id" => $theshort."_img_size_limit",
	"type" => "slider",
	"usestep" => "0",
	"max" => "2560",
	"pixopr" => "px",	
	"std" => "940"),	
	
array( "name" => "Video Size",
	"desc" => "Adjust the video size. Default size for all video : width 700px,  height 400px.",
	"id" => $theshort."_vid_size",
	"type" => "size",
	'std' => array( 'width' => '700', 'height' => '400' ),
	"pixopr" => "px"),	
	
array( "name" => "Google Maps Size",
	"desc" => "Adjust the maps size. Default size for all maps : width 600px,  height 350px.",
	"id" => $theshort."_gmap_size",
	"type" => "size",
	'std' => array( 'width' => '600', 'height' => '350' ),
	"pixopr" => "px"),
			
array( "name" => "Video Auto Play",
	"desc" => "Use this to enable/disable video auto play. This option only work on Youtube, Vimeo, Google Video and Veoh.",
	"id" => $theshort."_disen_autoplv",
	"type" => "checkbox",
	"std" => "1"),	
			
array( "name" => "Audio Auto Play",
	"desc" => "Use this to enable/disable audio auto play.",
	"id" => $theshort."_disen_autopl",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Audio Loop",
	"desc" => "Use this to enable/disable audio loop.",
	"id" => $theshort."_disen_audio_loop",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Audio Volume",
	"desc" => "Set the default volume for audio media.",
	"id" => $theshort."_audio_vol",
	"type" => "slider",
	"usestep" => "0",
	"max" => "100",
	"pixopr" => "",	
	"std" => "75"),	
	
array( "type" => "close"),
array( "name" => "Style Options",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Media Box Style",
	"desc" => "Select media box style. Default: Light",
	"id" => $theshort."_box_style",
	"type" => "select",
	"options" => array( "Light", "Dark", "Transparent" ),
	"std" => "1"),	

array( "name" => "Cursor",
	"desc" => "Move the mouse pointer on top the media to see the effect. Default: Pointer",
	"id" => $theshort."_cur_style",
	"type" => "select",
	"options" => array( "Pointer", "Crosshair", "Move", "Default" ),
	"std" => "3"),	
	
array( "name" => "Thumbnail Size",
	"desc" => "Allow for editing thumbnail sizes, you can also set this manually when adding shortcode. Default sizes width 180px, height : 180px",
	"id" => $theshort."_frm_size",
	"type" => "size",
	'std' => array( 'width' => '180', 'height' => '180' ),
	"pixopr" => "px"),	
		
array( "name" => "Thumbnail Border Size",
	"desc" => "Set the border size for the Thumbnail. Default border size : 5px.",
	"id" => $theshort."_frm_border",
	"type" => "slider",
	"usestep" => "0",	
	"pixopr" => "px",		
	"max" => "20",
	"std" => "5"),
	
array( "name" => "Thumbnail Border Radius",
	"desc" => "Set the border radius for the image box. Default : 3px",
	"id" => $theshort."_brdr_rds",
	"type" => "slider",
	"usestep" => "0",	
	"max" => "100",
	"pixopr" => "px",		
	"std" => "3"),	

array( "name" => "Thumbnail Border Color",
	"desc" => "Please define your custom Border Color. Default color is white (#FFF)",
	"id" => $theshort."_frm_col",
	"type" => "color",
	"std" => "#FFFFFF"),
	
array( "name" => "Thumbnail Border Opacity",
	"desc" => "Opacity of the media Thumbnail border. Default : 100%",
	"id" => $theshort."_thumb_border_opcty",
	"type" => "slider",
	"max" => "100",
	"step" => "10",
	"usestep" => "1",
	"pixopr" => "%",		
	"std" => "100"),		

array( "name" => "Thumbnail Shadow Color",
	"desc" => "Please define your custom Color Shadow. Default color is dark grey (#4A4A4A)",
	"id" => $theshort."_shdw_col",
	"type" => "color",
	"std" => "#4A4A4A"),
	
array( "name" => "Thumbnail Icon Color",
	"desc" => "Please define your background Icon Color. Default color is (#474747)",
	"id" => $theshort."_icon_col",
	"type" => "color",
	"std" => "#474747"),	
	
array( "name" => "Thumbnail Title Color",
	"desc" => "Please define your Title Color. Default color is dark grey",
	"id" => $theshort."_ttl_col",
	"type" => "color",
	"std" => "#C7C7C7"),	
	
	
array( "name" => "Thumbnail Hover Color",
	"desc" => "Please define your Thumbnail Hover Color. Default color is dark (#000000). NOTE : This function may not work on IE browser.",
	"id" => $theshort."_thumb_col",
	"type" => "color",
	"std" => "#000000"),
	
array( "name" => "Media Filter Link Color",
	"desc" => "Please define Media Filter Link Color. Default color is Green (#A0CE4E).",
	"id" => $theshort."_filter_col",
	"type" => "color",
	"std" => "#A0CE4E"),	
	
array( "name" => "Thumbnail Hover Opacity",
	"desc" => "Opacity of the Thumbnail that appears on media mouseover. Default : 40%",
	"id" => $theshort."_hover_opcty",
	"type" => "slider",
	"max" => "100",
	"step" => "10",
	"usestep" => "1",
	"pixopr" => "%",		
	"std" => "40"),	

array( "name" => "Close Button Position",
	"desc" => "Please define your Close Button Position. Default Bottom",
	"id" => $theshort."_cls_pos",
	"type" => "select",
	"options" => array( "Top", "Bottom" ),
	"std" => "Bottom"),
		
array( "name" => "Thumbnail Title Position",
	"desc" => "Please define your Title Position. Default Top",
	"id" => $theshort."_ttl_pos",
	"type" => "select",
	"options" => array( "Top", "Bottom" ),
	"std" => "Top"),
	
array( "name" => "Share Button Position",
	"desc" => "Please define your Social Media Share Button Position. Default Bottom",
	"id" => $theshort."_sos_pos",
	"type" => "select",
	"options" => array( "Top", "Bottom" ),
	"std" => "Bottom"),					
	
array( "name" => "Thumbnail Hover Style",
	"desc" => "NOTE : This feature only work on IE version <= 8.",
	"id" => $theshort."_hover_style",
	"type" => "select",
	"options" => array( "Dark", "Light" ),
	"std" => "Dark"),
	
array( "name" => "Zoom Icon",
	"desc" => "Select Zoom Icon. Default: Icon-1",
	"id" => $theshort."_mag_icon",
	"type" => "select",
	"options" => array( "Icon-1", "Icon-2", "Icon-3", "Icon-4" ),
	"std" => "Icon-1"),	
	
array( "name" => "Overlay Color",
	"desc" => "Color of the fullpage overlay when an media opened. Default color is (#F7F0D7)",
	"id" => $theshort."_overlay_col",
	"type" => "color",
	"std" => "#F7F0D7"),
	
array( "name" => "Overlay Opacity",
	"desc" => "Opacity of the fullpage overlay when an media is opened. Default : 80%",
	"id" => $theshort."_overlay_opcty",
	"type" => "slider",
	"max" => "100",
	"step" => "10",
	"usestep" => "1",
	"pixopr" => "%",		
	"std" => "80"),	
	
array( "name" => "Pattern Overlay",
	"desc" => "Please define pattern for box overlay. Default pattern is pattern-11",
	"id" => $theshort."_style_pattern",
	"type" => "pattern",
	"std" => "pattern-11.png"),	
	
array( "name" => "Thumbnail Icon",
	"desc" => "Enable or disable Thumbnail Icon.",
	"id" => $theshort."_disen_ticon",
	"type" => "checkbox",
	"std" => "0"),	
	
array( "name" => "Thumbnail Icon Backgound",
	"desc" => "Enable or disable Background color for Thumbnail Icon.",
	"id" => $theshort."_disen_icocol",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Hover Style",
	"desc" => "Enable or disable image hover effect.",
	"id" => $theshort."_disen_hovstyle",
	"type" => "checkbox",
	"std" => "1"),
	
array( "name" => "Gallery Navigation",
	"desc" => "Enable or disable gallery navigation buttons.",
	"id" => $theshort."_disen_galnav",
	"type" => "checkbox",
	"std" => "1"),	
		
array( "name" => "Thumbnail Shadow",
	"desc" => "Enable or disable Shadow effect. You also can hide the shadow by set the value to 0.",
	"id" => $theshort."_disen_sdw",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Thumbnail Border",
	"desc" => "Enable or disable border. You also can hide the border by set the value to 0.",
	"id" => $theshort."_disen_bor",
	"type" => "checkbox",
	"std" => "1"),
	
array( "name" => "Preload Image Effect",
	"desc" => "Use this option for enable or disable preload image effect.",
	"id" => $theshort."_disen_preload_ef",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Can use Style Manually",
	"desc" => "If enable, you can apply style for each media (per shortcode).",
	"id" => $theshort."_disen_style_man",
	"type" => "checkbox",
	"std" => "1"),			
	
array( "name" => "Custom CSS",
	"desc" => "Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}",
	"id" => $theshort."_custom_css",
	"type" => "textarea",
	"std" => ""),	
	
array( "type" => "close"),
array( "name" => "Miscellaneous",
	"type" => "section"),
array( "type" => "open"),

array( "name" => "Facebook share button",
	"desc" => "If ON, the Facebook button will display on media box.",
	"id" => $theshort."_disen_fb",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Twitter share button",
	"desc" => "If ON, the Twitter button will display on media box.",
	"id" => $theshort."_disen_twt",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Pinterest share button",
	"desc" => "If ON, the Pinterest button will display on media box.",
	"id" => $theshort."_disen_pin",
	"type" => "checkbox",
	"std" => "1"),		
	
array( "name" => "Update Check",
	"desc" => "Enable or temporarily disable automatic update check.",
	"id" => $theshort."_disen_upchk",
	"type" => "checkbox",
	"std" => "1"),
	
array( "name" => "Dashboard News",
	"desc" => "Enable or temporarily disable dashboard news.",
	"id" => $theshort."_disen_dasnews",
	"type" => "checkbox",
	"std" => "1"),	
	
	
array( "name" => "Keep data when uninstall/update",
	"desc" => "Enable this option to keep all plugin data and settings before you uninstall for update this plugin.",
	"id" => $theshort."_disen_databk",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Enable AJAX support",
	"desc" => "Turn this on if your site use AJAX page load plugin.",
	"id" => $theshort."_disen_ajax",
	"type" => "checkbox",
	"std" => ""),	

array( "name" => "Ajax container ID",
	"desc" => "Provide the id of the parent tag that handled by AJAX. Commonly used are #content or #main. Please contact us if you have any problems.",
	"id" => $theshort."_ajax_con_id",
	"type" => "text",
	"std" => "#content"),
		
array( "name" => "Enable Plugin",
	"desc" => "Enable or temporarily disable this plugin.",
	"id" => $theshort."_disen_plug",
	"type" => "checkbox",
	"std" => "1"),	
	
array( "name" => "Plugin Core Compatibility Mode",
	"desc" => "Could solve issues on old plugin core versions, Use it ONLY IF you notice some issues. Default: core-1.4.5-min",
	"id" => $theshort."_plugin_core",
	"type" => "select",
	"options" => array( "core-1.4.5-min", "core-1.4.5-full-compat-yc", "core-1.2.5-core-yc", "none" ),
	"std" => "core-1.4.5-min"),		
	
array( "type" => "close")
	
);


/*------------------------------------------------------------------------------------*/
/*  RESTORE DEFAULT SETTINGS
/*------------------------------------------------------------------------------------*/

function easymedia_restore_to_default($cmd) {
	
	if ( $cmd == 'reset' ) {
		
		delete_option( 'easy_media_opt' );
		
				$arr = array(
				$theshort.'_deff_init' => '1',
				$theshort.'_box_style' => 'Light',				
				$theshort.'_frm_col' => '#FFFFFF',
				$theshort.'_ttl_col' => '#C7C7C7',
				$theshort.'_ttl_pos' => 'Top',	
				$theshort.'_cls_pos' => 'Bottom',	
				$theshort.'_sos_pos' => 'Bottom',										
				$theshort.'_shdw_col' => '#4A4A4A',
				$theshort.'_thumb_col' => '#000000',
				$theshort.'_filter_col' => '#A0CE4E',				
				$theshort.'_overlay_col' => '#F7F0D7',
				$theshort.'_overlay_opcty' => '80',	
				$theshort.'_thumb_border_opcty' => '100',							
				$theshort.'_icon_col' => '#474747',				
				$theshort.'_hover_style' => 'Dark',
				$theshort.'_mag_icon' => 'Icon-1',				
				$theshort.'_hover_opcty' => '40',
				$theshort.'_img_size_limit' => '940',
				$theshort.'_columns' => '2',
				$theshort.'_margin_box' => '12',
				$theshort.'_audio_vol' => '75',
				$theshort.'_disen_audio_loop' => '1',				
				$theshort.'_frm_border' => '5',
				$theshort.'_plugin_core' => 'core-1.4.5-min',
				$theshort.'_cur_style' => 'Pointer',
				$theshort.'_alignstyle' => 'Center',
				$theshort.'_style_pattern' => 'pattern-11.png',
				$theshort.'_disen_fb' => '1',
				$theshort.'_disen_twt' => '1',
				$theshort.'_disen_pin' => '1',
				$theshort.'_disen_ticon' => '1',
				$theshort.'_disen_icocol' => '1',	
				$theshort.'_disen_style_man' => '1',					
				$theshort.'_brdr_rds' => '3',
				$theshort.'_disen_bor' => '1',
				$theshort.'_disen_upchk' => '1',
				$theshort.'_disen_ajax' => '',				
				$theshort.'_disen_dasnews' => '1',
				$theshort.'_disen_sdw' => '1',
				$theshort.'_disen_galnav' => '1',				
				$theshort.'_disen_databk' => '1',				
				$theshort.'_disen_autopl' => '1',
				$theshort.'_ajax_con_id' => '#content',				
				$theshort.'_disen_autoplv' => '1',				
				$theshort.'_disen_hovstyle' => '1',
				$theshort.'_disen_preload_ef' => '1',				
				$theshort.'_disen_plug' => '1',
				$theshort.'_frm_size' => array('width' => '180','height' => '180',),
				$theshort.'_vid_size' => array('width' => '700','height' => '400',),
				$theshort.'_gmap_size' => array('width' => '600','height' => '350',)		
													
				);
				update_option('easy_media_opt', $arr);
				return;
	}
}



/*------------------------------------------------------------------------------------*/
/*  1ST CONFIGURATION
/*------------------------------------------------------------------------------------*/

function easymedia_1st_config() {

				$thshort = "easymedia";
				
				$arr = array(
				$thshort.'_deff_init' => '1',
				$thshort.'_frm_col' => '#FFFFFF',
				$thshort.'_ttl_col' => '#C7C7C7',
				$thshort.'_ttl_pos' => 'Top',	
				$thshort.'_cls_pos' => 'Bottom',
				$thshort.'_sos_pos' => 'Bottom',											
				$thshort.'_shdw_col' => '#4A4A4A',
				$thshort.'_icon_col' => '#474747',
				$thshort.'_filter_col' => '#A0CE4E',				
				$thshort.'_box_style' => 'Light',
				$thshort.'_overlay_col' => '#F7F0D7',
				$thshort.'_thumb_col' => '#000000',
				$thshort.'_hover_style' => 'Dark',
				$thshort.'_mag_icon' => 'Icon-1',				
				$thshort.'_plugin_core' => 'core-1.4.5-min',			
				$thshort.'_hover_opcty' => '40',
				$thshort.'_overlay_opcty' => '80',	
				$thshort.'_thumb_border_opcty' => '100',				
				$thshort.'_img_size_limit' => '940',
				$thshort.'_columns' => '2',
				$thshort.'_margin_box' => '12',
				$thshort.'_audio_vol' => '75',
				$thshort.'_disen_audio_loop' => '1',								
				$thshort.'_frm_border' => '5',
				$thshort.'_cur_style' => 'Pointer',
				$thshort.'_alignstyle' => 'Center',
				$thshort.'_brdr_rds' => '3',
				$thshort.'_disen_bor' => '1',
				$thshort.'_disen_sdw' => '1',
				$thshort.'_style_pattern' => 'pattern-11.png',
				$thshort.'_disen_fb' => '1',
				$thshort.'_disen_twt' => '1',
				$thshort.'_disen_pin' => '1',
				$thshort.'_disen_ticon' => '1',
				$thshort.'_disen_icocol' => '1',
				$thshort.'_disen_databk' => '1',					
				$thshort.'_disen_dasnews' => '1',
				$thshort.'_ajax_con_id' => '#content',				
				$thshort.'_disen_ajax' => '',					
				$thshort.'_disen_galnav' => '1',							
				$thshort.'_disen_style_man' => '1',				
				$thshort.'_disen_upchk' => '1',				
				$thshort.'_disen_hovstyle' => '1',
				$thshort.'_disen_preload_ef' => '1',				
				$thshort.'_disen_plug' => '1',
				$thshort.'_disen_autopl' => '1',
				$thshort.'_disen_autoplv' => '1',								
				$thshort.'_frm_size' => array( 'width' => '180','height' => '180', ),
				$thshort.'_gmap_size' => array( 'width' => '600','height' => '350', ),
				$thshort.'_vid_size' => array( 'width' => '700','height' => '400', ));
				
				update_option( 'easy_media_opt', $arr, '', 'yes' );
				return;
}


?>