<?php

/**
 * Register Portfolio Post Type
 *
 * @package Qualeb
 * @since Qualeb 1.0
 *
 -------------------------------------
 */

 /*-------------------------------------------------------------------------------------*/
/*		1.		Create the Portfolio Post Type
/*-------------------------------------------------------------------------------------*/

function dm_create_portfolio_post_type() {
	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Portfolio Item' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Item' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Item' ),
				'new_item' => __( 'New Item' ),
				'view' => __( 'View ' ),
				'view_item' => __( 'View Item' ),
				'search_items' => __( 'Search Portfolio' ),
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
			'menu_position' => null,
			'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
			'menu_icon' => get_stylesheet_directory_uri() . '/css/images/posttypes/gallery.png',
		)
	);
}

add_action( 'init', 'dm_create_portfolio_post_type' );

/*-------------------------------------------------------------------------------------*/
/*		2.		Create Portfolio Items Columns
/*-------------------------------------------------------------------------------------*/

function portfolio_columns($columns)
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Item Title",
		"thumbnail" => "Thumbnail",
		"cats" => "Categories",
		"order" => "Order",
	);
	
	return $columns;
}
add_filter("manage_edit-portfolio_columns", "portfolio_columns");

add_action ("manage_posts_custom_column", "portfolio_custom_columns");

function portfolio_custom_columns($column) {
	global $post;
	$post_terms = wp_get_post_terms($post->ID,'portfolio_category', 'hide_empty=1');
	$term_list = '';
	foreach($post_terms as $post_term) {
		$term_list .= '- '. $post_term->slug . ' <br />';
	}		
	if ("cats" == $column) echo $term_list;
}

/*-------------------------------------------------------------------------------------*/
/*		3.		Create Portfolio Taxonomy (Categories)
/*-------------------------------------------------------------------------------------*/

add_action('init', 'dm_create_portfolio_taxonomy');

function dm_create_portfolio_taxonomy(){
	register_taxonomy('portfolio_category', 'portfolio',
                        array('hierarchical' => true,
                              'label' => 'Portfolio Category',
                              'query_var'  => true,
                              'rewrite' => true));
							  }				

							  

/*-------------------------------------------------------------------------------------*/
/*		4.		Add Metaboxes (Link to Project, Twitter, Facebook)
/*-------------------------------------------------------------------------------------*/							  

/*-------------------------------------------------------------------------------------*/
/*		4.1		Create Array
/*-------------------------------------------------------------------------------------*/		

$prefix = 'dm_po_';

$dm_mb_portfolio_item = array(
	'id' => 'dm-portfolio-item-mb',
	'title' => 'Project Display Options',
	'page' => 'portfolio',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		
		array(
			'name' => 'Link to project title',
			'desc' => 'Enter the phrase to use for the link to the project (Default is "Launch project") ',
			'id' => $prefix . 'phrase',
			'type' => 'text',
			'std' => 'Launch Project'
		),
		
		array(
			'name' => 'Link to Project',
			'desc' => 'Enter a full (include http:// ) link to the project (optional)',
			'id' => $prefix . 'link',
			'type' => 'text',
			'std' => ''
		),
		
		array(
			'name' => 'Disable Twitter',
			'desc' => 'Select if you want to disable the Tweet button.',
			'id' => $prefix . 'tweet',
			'type' => 'checkbox',
			'std' => ''
		),
		
		array(
			'name' => 'Disable Facebook',
			'desc' => 'Select if you want to disable the Like button.',
			'id' => $prefix . 'like',
			'type' => 'checkbox',
			'std' => ''
		),

	)
);

/*-------------------------------------------------------------------------------------*/
/*		4.1		Create Metabox
/*-------------------------------------------------------------------------------------*/	

function dm_dm_mb_portfolio_item() {
	global $dm_mb_portfolio_item;
	add_meta_box($dm_mb_portfolio_item['id'], $dm_mb_portfolio_item['title'], 'dm_po_show_fields', $dm_mb_portfolio_item['page'], $dm_mb_portfolio_item['context'], $dm_mb_portfolio_item['priority']);
}

add_action('admin_menu', 'dm_dm_mb_portfolio_item');


/*-------------------------------------------------------------------------------------*/
/*		4.1		Show Fields in Metabox
/*-------------------------------------------------------------------------------------*/	

function dm_po_show_fields() {
	global $dm_mb_portfolio_item, $post;

	echo '<input type="hidden" name="dm_mb_portfolio_item_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	echo '<table class="form-table">';

	foreach ($dm_mb_portfolio_item['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		
		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
				'<td>';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
					'<br />', $field['desc'];
				break;
			case 'textarea':
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
					'<br />', $field['desc'];
				break;
			case 'select':
				echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo '</select>';
				break;
			case 'radio':
				foreach ($field['options'] as $option) {
					echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
				break;
		}
		echo 	'<td>',
			'</tr>';
	}
	
	echo '</table>';
}

add_action('save_post', 'dm_po_save_data');

/*-------------------------------------------------------------------------------------*/
/*		4.1		Save Data From Metabox
/*-------------------------------------------------------------------------------------*/	

function dm_po_save_data($post_id) {
	global $dm_mb_portfolio_item;

	// Nonce verification
	if (!wp_verify_nonce( isset($_POST['dm_mb_portfolio_item_nonce']), basename(__FILE__))) {
		return $post_id;
	}

	// Autosaving
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// Permissions Checking
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($dm_mb_portfolio_item['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}

?>