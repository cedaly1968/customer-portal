<?php
/**
 * Columns Adder For TinyMCE
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
 
if(!class_exists('ColumnsAdder')):

class ColumnsAdder{
	var $colsButton = 'ColumnsAdderButton';
	function dm_ColumnSelector(){
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	 
	   // Add only in Rich Editor mode
	    if ( get_user_option('rich_editing') == 'true') {
	      add_filter('mce_external_plugins', array($this, 'addColumnsAdder'));
	      add_filter('mce_buttons', array($this, 'registerColumnsButton'));
	    }
	}
	
	function registerColumnsButton($buttons){
		array_push($buttons, "separator", $this->colsButton);
		return $buttons;
	}
	
	// Load the TinyMCE plugin 
	function addColumnsAdder( $ColsAdder_array ) {
		$ColsAdder_array[$this->colsButton] = get_bloginfo( 'template_url' ) . '/library/shortcodes/js/columns_adder.js.php';
		return $ColsAdder_array;
	}
}
endif;

if(!isset($dmColumns)){
	$dmColumns = new ColumnsAdder();
	add_action('admin_head', array($dmColumns, 'dm_ColumnSelector'));
}

?>