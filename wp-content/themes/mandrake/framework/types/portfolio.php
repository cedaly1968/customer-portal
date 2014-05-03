<?php
/**
* Register Custom Post Types - Portfolio
*/
function register_portfolio_post_type(){
	register_post_type('portfolio', array(
		'labels' => array(
			'name' => _x('Portfolios', 'post type general name', 'mandrake_theme' ),
			'singular_name' => _x('Portfolio', 'post type singular name', 'mandrake_theme' ),
			'add_new' => _x('Add New', 'portfolio', 'mandrake_theme' ),
			'add_new_item' => __('Add New Portfolio Item', 'mandrake_theme' ),
			'edit_item' => __('Edit Portfolio', 'mandrake_theme' ),
			'new_item' => __('New Portfolio', 'mandrake_theme' ),
			'view_item' => __('View Portfolio', 'mandrake_theme' ),
			'search_items' => __('Search Portfolios', 'mandrake_theme' ),
			'not_found' =>  __('No portfolios found', 'mandrake_theme' ),
			'not_found_in_trash' => __('No portfolios found in Trash', 'mandrake_theme' ), 
			'parent_item_colon' => '',
		),
		'singular_label' => __('portfolio', 'mandrake_theme' ),
		'public' => true,
		'exclude_from_search' => false,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array( 'with_front' => false ),
		'query_var' => false,
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'comments')
	));

	//register taxonomy for portfolio
	register_taxonomy('portfolio_category','portfolio',array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Portfolio Categories', 'taxonomy general name', 'mandrake_theme' ),
			'singular_name' => _x( 'Portfolio Category', 'taxonomy singular name', 'mandrake_theme' ),
			'search_items' =>  __( 'Search Categories', 'mandrake_theme' ),
			'popular_items' => __( 'Popular Categories', 'mandrake_theme' ),
			'all_items' => __( 'All Categories', 'mandrake_theme' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Portfolio Category', 'mandrake_theme' ), 
			'update_item' => __( 'Update Portfolio Category', 'mandrake_theme' ),
			'add_new_item' => __( 'Add New Portfolio Category', 'mandrake_theme' ),
			'new_item_name' => __( 'New Portfolio Category Name', 'mandrake_theme' ),
			'separate_items_with_commas' => __( 'Separate Portfolio category with commas', 'mandrake_theme' ),
			'add_or_remove_items' => __( 'Add or remove portfolio category', 'mandrake_theme' ),
			'choose_from_most_used' => __( 'Choose from the most used portfolio category', 'mandrake_theme' )
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => false,
	));
}

add_action('init','register_portfolio_post_type');

?>