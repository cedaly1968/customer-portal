<?php
/**
 * Worpdess filters
 */

// Search form filter
function theme_search_form($form) {
	$form = '<div class="search-wrap"><form action="' . home_url( '/' ) . '" method="get" id="search-form">
			<input type="text" value="'. __('Search...', 'mandrake_theme') .'" class="search-input" name="s" id="s" />
			<button class="button small active" type="submit"><span>'. __('Search', 'mandrake_theme') .'</span></button>
	</form></div>';
    return $form;
}
add_filter('get_search_form', 'theme_search_form');

// Search results filter
function search_exclude($query) {
	if ($query->is_search) {
		$query->set('post_type', array('post','page'));
	}
	return $query;
}
add_filter('pre_get_posts','search_exclude');

// Excerpt more filter
function theme_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'theme_excerpt_more');

// Excerpt length filter
function theme_excerpt_length($length) {
	return 66;
}
add_filter('excerpt_length', 'theme_excerpt_length');

// Read more link filter
function theme_more_link($more_link, $more_link_text) {
	$offset = strpos($more_link, '#more-');
	if ($offset) {
		$end = strpos($more_link, '"',$offset);
	}
	if ($end) {
		$more_link = substr_replace($more_link, '', $offset, $end-$offset);
	}
	$more_link = str_replace('more-link', 'button more active', $more_link);
	return '<p>'. $more_link .'</p>';
}
add_filter('the_content_more_link', 'theme_more_link', 10, 2);

//Replace wp_trim_excerpt with a commented out strip_shortcodes()
function improved_trim_excerpt($text) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
		$text = strip_tags($text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '...');
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}
	return apply_filters('improved_trim_excerpt', $text, $raw_excerpt);
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');

// Disable Automatic Formatting on Posts
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

?>