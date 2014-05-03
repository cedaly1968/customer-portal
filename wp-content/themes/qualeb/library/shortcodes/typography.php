<?php
/**
 * Typography Shortcodes
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
 
/*-------------------------------------------------------------------------------------*/
/*		1.		Dropcap 
/*-------------------------------------------------------------------------------------*/

function dm_dropcap($atts, $content = null){
	return '<span class="dropcap">' . do_shortcode($content) . '</span>';
	}
add_shortcode("dropcap", "dm_dropcap");	

/*-------------------------------------------------------------------------------------*/
/*		2.		Back to top 
/*-------------------------------------------------------------------------------------*/

function dm_backtotop($atts, $content = null) {

	return '<div class="back-to-top"> <a href="#top">top</a> </div>';
}
add_shortcode('backtotop', 'dm_backtotop');

/*-------------------------------------------------------------------------------------*/
/*		3.		Divider
/*-------------------------------------------------------------------------------------*/

function dm_divider($atts, $content = null) {

	return '<div class="back-to-top"> </div>';
}
add_shortcode('divider', 'dm_divider');

/*-------------------------------------------------------------------------------------*/
/*		4.		Aside
/*-------------------------------------------------------------------------------------*/

function dm_aside($atts, $content = null) {

	return '<p><span class="aside">' . do_shortcode($content) . '</span></p>';
}
add_shortcode('aside', 'dm_aside');


/*-------------------------------------------------------------------------------------*/
/*		5.		Tab Content
/*-------------------------------------------------------------------------------------*/

function dm_tab_group( $atts, $content ){
$GLOBALS['tab_count'] = 0;

do_shortcode( $content );

if( is_array( $GLOBALS['tabs'] ) ){
	foreach( $GLOBALS['tabs'] as $tab ){
		$tabs[] = '<li><a class="'.$tab['class'].'" href="#'.$tab['id'].'">'.$tab['title'].'</a></li>';
		$panes[] = '<li id="'.$tab['id'].'" class="'.$tab['class'].'">'.$tab['content'].'</li>';
	}	
		$return = "\n".'<ul class="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<ul class="tabs-content">'.implode( "\n", $panes ).'</ul>'."\n";
	}
	return $return;
}
add_shortcode( 'tabgroup', 'dm_tab_group' );


function dm_tab( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => '',
	'id' => '',
	'class' => ''
	), $atts));

	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'id' => sprintf( $id, $GLOBALS['tab_count'] ), 'class' => sprintf( $class, $GLOBALS['tab_count'] ), 'content' =>  $content );

	$GLOBALS['tab_count']++;
}
add_shortcode( 'tab', 'dm_tab' );


/*-------------------------------------------------------------------------------------*/
/*		6.		Alert Boxes
/*-------------------------------------------------------------------------------------*/

function dm_box($atts, $content = null){
	extract(shortcode_atts(array(
	"color" => 'none',
	), $atts));
	return '
	<div class="sbox"><span class="box-line box-'.$color.'"></span>'.do_shortcode($content).'</div>';
	}
add_shortcode("box", "dm_box");	


/*-------------------------------------------------------------------------------------*/
/*		7.		Clear
/*-------------------------------------------------------------------------------------*/

function dm_clear($atts, $content = null){
	return '<div class="clear"></div>';
}
add_shortcode("clear", "dm_clear");


/*-------------------------------------------------------------------------------------*/
/*		8.		Displays a link with arrow
/*-------------------------------------------------------------------------------------*/

function dm_arrow_link($atts, $content = null){
	extract(shortcode_atts(array(
	"link" => '#'
	), $atts));
	return '<a href="'.$link.'" class="more-link">' . do_shortcode($content) . ' &rarr;</a>';
	}
add_shortcode("arrowlink", "dm_arrow_link");	


?>