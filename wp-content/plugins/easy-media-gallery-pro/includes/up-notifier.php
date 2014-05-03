<?php

/**************************************************************
 *                                                            *
 *   Provides a notification to the user everytime            *
 *   your WordPress plugin is updated                          *
 *                                                            *
 *   Author: Joao Araujo                                      *
 *   Profile: http://themeforest.net/user/unisphere           *
 *   Follow me: http://twitter.com/unispheredesign            *
 *                                                            *
 **************************************************************/
 
// Constants for the plugin name, folder and remote XML url
define( 'EMG_NOTIFIER_PLUGIN_NAME', 'Easy Media Gallery Pro' ); // The plugin name
define( 'EMG_DAS_PLUGIN_NAME', 'Easy Media' ); // The plugin name
define( 'EMG_NOTIFIER_PLUGIN_FOLDER_NAME', 'easy-media-gallery-pro' ); // The plugin folder name
define( 'EMG_NOTIFIER_PLUGIN_XML_FILE', 'http://update.ghozylab.com/plugins/easy-media-gallery/notifier.xml' ); // The remote notifier XML file containing the latest version of the plugin and changelog
define( 'EMG_NOTIFIER_CACHE_INTERVAL', 900 ); // The time interval for the remote XML cache in the database (21600 seconds = 6 hours)
define( 'EMG_NOTIFIER_PLUGIN_FILE_NAME', 'easy-media-gallery-pro.php' ); // The plugin folder name


// Adds an update notification to the WordPress Dashboard menu
function emg_update_notifier_menu() {  
	if ( function_exists( 'simplexml_load_string' ) ) { // Stop if simplexml_load_string funtion isn't available
	    $xml = emg_get_latest_plugin_version( EMG_NOTIFIER_CACHE_INTERVAL ); // Get the latest remote XML file on our server
		$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . EMG_NOTIFIER_PLUGIN_FOLDER_NAME . '/' . EMG_NOTIFIER_PLUGIN_FILE_NAME );
		
		if( (string)$xml->latest > (string)$plugin_data['Version']) { // Compare current plugin version with the remote XML version
			add_dashboard_page( EMG_NOTIFIER_PLUGIN_NAME . ' Plugin Updates', EMG_DAS_PLUGIN_NAME . ' <span class="update-plugins count-1"><span class="update-count">New</span></span>', 'administrator', 'emg-update-notifier', 'emg_update_notifier');
		}
	}	
}
add_action( 'admin_menu', 'emg_update_notifier_menu' );  


// Adds an update notification to the WordPress 3.1+ Admin Bar
function emg_update_notifier_bar_menu() {
	if ( function_exists( 'simplexml_load_string' ) ) { // Stop if simplexml_load_string funtion isn't available
		global $wp_admin_bar, $wpdb;
	
		if ( !is_super_admin() || !is_admin_bar_showing() ) // Don't display notification in admin bar if it's disabled or the current user isn't an administrator
		return;
		
		$xml = emg_get_latest_plugin_version(EMG_NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . EMG_NOTIFIER_PLUGIN_FOLDER_NAME . '/' . EMG_NOTIFIER_PLUGIN_FILE_NAME);
		
			if ( !$xml ){
				return;
				}
	
			if ( version_compare( $plugin_data['Version'], $xml->latest ) == -1 ) {
			$wp_admin_bar->add_menu( array( 'id' => 'emg_update_notifier', 'title' => '<span>' . EMG_NOTIFIER_PLUGIN_NAME . ' <span id="ab-updates">New Update v'.$xml->latest.'</span></span>', 'href' => get_admin_url() . 'index.php?page=emg-update-notifier' ) );
		}
	}
}


if ( is_admin() ) add_action( 'admin_bar_menu', 'emg_update_notifier_bar_menu', 1000 );

// The notifier page
function emg_update_notifier() { 
	$xml = emg_get_latest_plugin_version(EMG_NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
	$plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . EMG_NOTIFIER_PLUGIN_FOLDER_NAME . '/' . EMG_NOTIFIER_PLUGIN_FILE_NAME);
	?>
	<style>
	.update-nag { display: none; }
	#instructions { width: 100%;}
	h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
    </style>

	<div class="wrap">
	
		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo EMG_NOTIFIER_PLUGIN_NAME ?> Plugin Updates</h2>
	    <div id="message" class="updated below-h2" style="margin-bottom:35px;"><p><strong>There is a new version of the <?php echo EMG_NOTIFIER_PLUGIN_NAME; ?> plugin available.</strong> You have version <?php echo $plugin_data['Version']; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>

		<div id="instructions">	    
	    	<?php echo $xml->updateinstruct; ?>
		</div>      
        
		<div id="instructions">	    
	    	<h3 class="title">Changelog</h3>
	    	<?php echo $xml->changelog; ?>
		</div>
	</div>
   
    
<?php } 



// Get the remote XML file contents and return its data (Version and Changelog)
// Uses the cached version if available and inside the time interval defined
function emg_get_latest_plugin_version( $interval ) {
	$notifier_file_url = EMG_NOTIFIER_PLUGIN_XML_FILE;	
	$db_cache_field = 'emg-notifier-cache';
	$db_cache_field_last_updated = 'emg-notifier-cache-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || ( ( $now - $last ) > $interval ) ) {
		// cache doesn't exist, or is old, so refresh it
		if ( function_exists( 'curl_init' ) ) { // if cURL is available, use it...
			$ch = curl_init( $notifier_file_url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
			$cache = curl_exec( $ch );
			curl_close( $ch );
		} else {
			
			$cache = @file_get_contents( $notifier_file_url ); // ...if not, use the common file_get_contents()
	
		}
		 
		if ( $cache ) {			
			// we got good results	
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );
		} 
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}

	// Load the remote XML data into a variable and return it
	
	$use_errors = libxml_use_internal_errors( true );
	$xml = simplexml_load_string( $notifier_data ); 
	libxml_clear_errors();
	libxml_use_internal_errors( $use_errors );

	return $xml;
	
}

?>