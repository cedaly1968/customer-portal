<?php



$primary_color = of_get_option('ml_primary_color','#ffffff');
$secondary_color = of_get_option('ml_secondary_color','#000000');



/*-------------------------------------------------*/
/*	Add Shortcodes Button
/*-------------------------------------------------*/

/* button function */
function ml_add_shortcode_button() {
 
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
		return;
	}
	
	if ( get_user_option('rich_editing') == 'true' ) {
		add_filter( 'mce_external_plugins', 'add_plugin' );
		add_filter( 'mce_buttons', 'register_button' );
	}
 
}

add_action('init', 'ml_add_shortcode_button');



/* register button */
function register_button( $buttons ) {
	array_push( $buttons, "|", "ml_add_shortcode_button" );
	return $buttons;
}



/* register TinyMCE plugin */
function add_plugin( $plugin_array ) {
   $plugin_array['ml_add_shortcode_button'] = get_template_directory_uri() . '/js/add_shortcode.js.php';
   return $plugin_array;
}





/*
    // ========================================== \\
   ||                                              ||
   ||                  Shortcodes                  ||
   ||                                              ||
    \\ ========================================== //
*/

/*--- Code ---*/
function ml_shortcode_code( $atts, $content ) {

	$out = '<code>' . $content . '</code>';

	return $out;

}

add_shortcode('ml_code', 'ml_shortcode_code');



/*--- Clearfix ---*/
function ml_shortcode_clearfix() {

    return '<div class="clearfix"></div>';

} 

add_shortcode('ml_clearfix', 'ml_shortcode_clearfix');



/*--- Columns ---*/
function ml_shortcode_column( $atts, $content ) {

    extract(shortcode_atts(array(

        'width'      => '',
        'last'      => ''

    ), $atts));
  
	if(($last == 'true') || ($last == 'yes') || ($last == 'last')) {
		$last_column = ' last';
	}

	else {
		$last_column = '';
	}

	$out = '<div class="ml_column '.$width.$last_column.'">'.
				 do_shortcode($content).
				 '</div>';

	return $out;

}

add_shortcode('ml_column', 'ml_shortcode_column');

?>