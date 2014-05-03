<?php

/**
 * Register Slider Post Type
 *
 * @package Qualeb
 * @since Qualeb 1.0
 *
 -------------------------------------
 */
 
/*-------------------------------------------------------------------------------------*/
/*		1.		Create Slider Post Type
/*-------------------------------------------------------------------------------------*/

function create_slider_post_type() {
	register_post_type( 'slider_items',
		array(
			'labels' => array(
				'name' => __( 'Slider Items' ),
				'singular_name' => __( 'Slider Item' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Item' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Item' ),
				'new_item' => __( 'New Item' ),
				'view' => __( 'View ' ),
				'view_item' => __( 'View Item' ),
				'search_items' => __( 'Search Slider Items' ),
				'not_found' => __( 'No Items found' ),
				'not_found_in_trash' => __( 'No Items found in Trash' ),
			),
			'public' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => false,
			'exclude_from_search' => true,
			'rewrite' => false,
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'supports' => array('title','thumbnail','page-attributes'),
			'menu_icon' => get_stylesheet_directory_uri() . '/css/images/posttypes/slides.png',
		)
	);
	
}

add_action( 'init', 'create_slider_post_type' );


/*-------------------------------------------------------------------------------------*/
/*		2.		Create Slider Items Columns
/*-------------------------------------------------------------------------------------*/


function slider_items_columns($columns)
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Item Title",
		"thumbnail" => "Thumbnail",
		"order" => "Order",
	);
	
	return $columns;
}
add_filter("manage_edit-slider_items_columns", "slider_items_columns");

add_action ("manage_posts_custom_column", "slider_custom_columns");

function slider_custom_columns($column) {
	global $post;
	$thumb = get_the_post_thumbnail($post->ID, 'medium');
	$order = get_post_field('menu_order', $post->ID); 

	if ("thumbnail" == $column) echo $thumb;
	elseif ("order" == $column) echo $order;
}
	  
?>