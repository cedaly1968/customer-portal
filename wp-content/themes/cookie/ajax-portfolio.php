<?php

if(!function_exists('wp_head')) {
	
	if(file_exists('../../../../wp-load.php')) {

		include '../../../../wp-load.php';

	} else {

		include '../../../../../wp-load.php';

	}
		
}

$post_id = $_POST['id']; ?>

<h2>Teste novo </h2>

