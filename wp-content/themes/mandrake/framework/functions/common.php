<?php

function theme_get_option($page, $name) {
	global $theme_options;
	$theme_options = get_option(THEME_NAME . '_' . $page);
	return $theme_options[$name];
}

?>
