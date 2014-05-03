<?php
	if(!function_exists('wp_head')) {
		
		if(file_exists('../../../../wp-load.php')) {
			include '../../../../wp-load.php';
		} else {
			include '../../../../../wp-load.php';
		}
			
	}

echo sanitize_title($_GET['slug']);
?>