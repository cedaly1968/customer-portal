<?php
/**
* Register Custom Post Types - Dashboards
*/
function register_dashboards_post_type(){
	register_post_type('dashboards', array(
		'labels' => array(
			'name' => _x('Dashboards', 'post type general name', 'mandrake_theme' ),
			'singular_name' => _x('Dashboards', 'post type singular name', 'mandrake_theme' ),
			'add_new' => _x('Add New', 'dashboards', 'mandrake_theme' ),
			'add_new_item' => __('Add New Dashboard Item', 'mandrake_theme' ),
			'edit_item' => __('Edit Dashboard', 'mandrake_theme' ),
			'new_item' => __('New Dashboard', 'mandrake_theme' ),
			'view_item' => __('View Dashboard', 'mandrake_theme' ),
			'search_items' => __('Search Dashbaords', 'mandrake_theme' ),
			'not_found' =>  __('No dashboards found', 'mandrake_theme' ),
			'not_found_in_trash' => __('No dashboards found in Trash', 'mandrake_theme' ), 
			'parent_item_colon' => '',
		),
		'singular_label' => __('dashboard', 'mandrake_theme' ),
		'public' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array( 'with_front' => false ),
		'query_var' => false,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments')
	));

	//register taxonomy for dashboards
	register_taxonomy('dashboard_category','dashboard',array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Dashboard Categories', 'taxonomy general name', 'mandrake_theme' ),
			'singular_name' => _x( 'Dashboard Category', 'taxonomy singular name', 'mandrake_theme' ),
			'search_items' =>  __( 'Search Categories', 'mandrake_theme' ),
			'popular_items' => __( 'Popular Categories', 'mandrake_theme' ),
			'all_items' => __( 'All Categories', 'mandrake_theme' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Dashboard Category', 'mandrake_theme' ), 
			'update_item' => __( 'Update Dashboard Category', 'mandrake_theme' ),
			'add_new_item' => __( 'Add New Dashboard Category', 'mandrake_theme' ),
			'new_item_name' => __( 'New Dashboard Category Name', 'mandrake_theme' ),
			'separate_items_with_commas' => __( 'Separate Dashboard category with commas', 'mandrake_theme' ),
			'add_or_remove_items' => __( 'Add or remove dashboard category', 'mandrake_theme' ),
			'choose_from_most_used' => __( 'Choose from the most used dashboard category', 'mandrake_theme' )
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => false,
	));
}

add_action('init','register_dashboard_post_type');

?>