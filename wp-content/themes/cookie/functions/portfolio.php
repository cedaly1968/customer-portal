<?php

/*-------------------------------------------------*/
/*	Portfolio Custom Post Type
/*-------------------------------------------------*/

/*--- Custom Taxonomy - Skill (For Portfolio) ---*/

add_action( 'init', 'register_taxonomy_ml_skill' );



function register_taxonomy_ml_skill() {

    $labels = array( 

        'name' => __( 'Skills', 'meydjer'),

        'singular_name' => __( 'Skill', 'meydjer'),

        'search_items' => __( 'Search Skills', 'meydjer'),

        'popular_items' => __( 'Popular Skills', 'meydjer'),

        'all_items' => __( 'All Skills', 'meydjer'),

        'parent_item' => __( 'Parent Skill', 'meydjer'),

        'parent_item_colon' => __( 'Parent Skill:', 'meydjer'),

        'edit_item' => __( 'Edit Skill', 'meydjer'),

        'update_item' => __( 'Update Skill', 'meydjer'),

        'add_new_item' => __( 'Add New Skill', 'meydjer'),

        'new_item_name' => __( 'New Skill Name', 'meydjer'),

        'separate_items_with_commas' => __( 'Separate skills with commas', 'meydjer'),

        'add_or_remove_items' => __( 'Add or remove skills', 'meydjer'),

        'choose_from_most_used' => __( 'Choose from the most used skills', 'meydjer'),

        'menu_name' => __( 'Skills', 'meydjer'),

    );



    $args = array( 

        'labels' => $labels,

        'public' => true,

        'show_in_nav_menus' => true,

        'show_ui' => true,

        'show_tagcloud' => true,

        'hierarchical' => true,

        'rewrite' => true,

        'query_var' => true

    );

    register_taxonomy( 'ml_skill', array('ml_portfolio'), $args );

}



/*--- Custom Post Type - Portfolio ---*/

add_action( 'init', 'register_cpt_ml_portfolio' );



function register_cpt_ml_portfolio() {

    $labels = array( 

        'name' => __( 'Portfolio Items', 'meydjer'),

        'singular_name' => __( 'Portfolio Item', 'meydjer'),

        'add_new' => __( 'Add New', 'meydjer'),

        'add_new_item' => __( 'Add New Portfolio Item', 'meydjer'),

        'edit_item' => __( 'Edit Portfolio Item', 'meydjer'),

        'new_item' => __( 'New Portfolio Item', 'meydjer'),

        'view_item' => __( 'View Portfolio Item', 'meydjer'),

        'search_items' => __( 'Search Portfolio Items', 'meydjer'),

        'not_found' => __( 'No portfolio items found', 'meydjer'),

        'not_found_in_trash' => __( 'No portfolio items found in Trash', 'meydjer'),

        'parent_item_colon' => __( 'Parent Portfolio Item:', 'meydjer'),

        'menu_name' => __( 'Portfolio Items', 'meydjer'),

    );



    $args = array( 

        'labels' => $labels,

        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'custom-fields' ),

        'taxonomies' => array( 'ml_skill' ),

        'public' => true,

        'show_ui' => true,

        'show_in_menu' => true,        
        
        'show_in_nav_menus' => true,

        'publicly_queryable' => true,

        'exclude_from_search' => true,

        'has_archive' => false,

        'query_var' => true,

        'can_export' => true,

        'rewrite' => array( 

            'slug' => 'portfolio', 

            'with_front' => true,

            'feeds' => true,

            'pages' => true

        ),

        'capability_type' => 'post'

    );

    register_post_type( 'ml_portfolio', $args );

}



/*-------------------------------------------------*/
/*	Portfolio Meta Boxes
/*-------------------------------------------------*/

/*--- Extend RW_Meta_Box class. Add field type: 'taxonomy' ---*/
class RW_Meta_Box_Taxonomy extends RW_Meta_Box {
	
	function add_missed_values() {

		parent::add_missed_values();
		
		// add 'multiple' option to taxonomy field with checkbox_list type
		foreach ($this->_meta_box['fields'] as $key => $field) {

			if ('taxonomy' == $field['type'] && 'checkbox_list' == $field['options']['type']) {

				$this->_meta_box['fields'][$key]['multiple'] = true;

			}

		}

	}
	
	// show taxonomy list
	function show_field_taxonomy($field, $meta) {

		global $post;
		
		if (!is_array($meta)) $meta = (array) $meta;
		
		$this->show_field_begin($field, $meta);
		
		$options = $field['options'];

		$terms = get_terms($options['taxonomy'], $options['args']);
		
		// checkbox_list
		if ('checkbox_list' == $options['type']) {

			foreach ($terms as $term) {

				echo "<input type='checkbox' name='{$field['id']}[]' value='$term->slug'" . checked(in_array($term->slug, $meta), true, false) . " /> $term->name<br/>";

			}

		}

		// select
		else {

			echo "<select name='{$field['id']}" . ($field['multiple'] ? "[]' multiple='multiple' style='height:auto'" : "'") . ">";
		
			foreach ($terms as $term) {

				echo "<option value='$term->slug'" . selected(in_array($term->slug, $meta), true, false) . ">$term->name</option>";

			}

			echo "</select>";

		}
		
		$this->show_field_end($field, $meta);

	}

}

/*--- Metaboxes ---*/
$prefix = 'ml_portfolio_';

$meta_boxes = array();

/* Image */
$meta_boxes[] = array(

	'id' => $prefix . 'image',			// meta box id, unique per meta box
	'title' => __('Image', 'meydjer'),	// meta box title
	'pages' => array('ml_portfolio'),	// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',				// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',				// order of meta box: high (default), low; optional
	'fields' => array(

		array(
			'name' => __('Images', 'meydjer'),
			'id' => $prefix . 'images',
			'type' => 'image'						// image upload
		),

		array(
			'name' => __('Images Height', 'meydjer'),
			'id' => $prefix . 'images_height',
			'desc' => __('In Pixels. Default: 360', 'meydjer'),
			'std' => '360',
			'type' => 'text'
		),

		array(
			'name' => __('HTML Content', 'meydjer'),
			'desc' => __('Use this space to embed videos, audios or any other HTML content. <br /> <span style="color:#dd4b39;font-weight:bold;">WARNING:</span> if you fill this textarea, your images above will be overwritten. <br /> <span style="color:#36c; font-weight:bold;">NOTE:</span> Maximum content width is 640px.', 'meydjer'),
			'id' => $prefix . 'embedded_html',
			'type' => 'textarea'
		),

	)

);



foreach ($meta_boxes as $meta_box) {
	new RW_Meta_Box_Taxonomy($meta_box);
}


?>