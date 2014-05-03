<?php
/**
* Register Custom Post Types - Slideshow
*/
function register_slideshow_post_type(){
	register_post_type('slideshow', array(
		'labels' => array(
			'name' => _x('Slideshows', 'post type general name', 'mandrake_theme'),
			'singular_name' => _x('Slideshow', 'post type singular name', 'mandrake_theme'),
			'add_new' => _x('Add New', 'slideshow', 'mandrake_theme'),
			'add_new_item' => __('Add New Slideshow Item', 'mandrake_theme'),
			'edit_item' => __('Edit Slideshow Item', 'mandrake_theme'),
			'new_item' => __('New Slideshow Item', 'mandrake_theme'),
			'view_item' => __('View Slideshow Item', 'mandrake_theme'),
			'search_items' => __('Search Slideshow Items', 'mandrake_theme'),
			'not_found' =>  __('No Slideshow item found', 'mandrake_theme'),
			'not_found_in_trash' => __('No Slideshow items found in Trash', 'mandrake_theme'), 
			'parent_item_colon' => ''
		),
		'singular_label' => __('slideshow', 'mandrake_theme'),
		'public' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => false,
		'query_var' => false,
		'supports' => array('title', 'editor', 'thumbnail' , 'page-attributes')
	));
}

add_action('init','register_slideshow_post_type');

?>