<?php
/**
 * sidebarBuilder class
 */
class sidebarBuilder {
	var $sidebar_names = array();
	var $footer_sidebar_names = array();
	
	function sidebarBuilder(){
		$this->sidebar_names = array(
			'home'=>__('Homepage Widget Area','mandrake_theme'),
			'page'=>__('Page Widget Area','mandrake_theme'),
			'blog'=>__('Blog Widget Area','mandrake_theme'),
		);
		$this->footer_sidebar_names = array(
			__('First Footer Widget Area','mandrake_theme'),
			__('Second Footer Widget Area','mandrake_theme'),
			__('Third Footer Widget Area','mandrake_theme'),
			__('Fourth Footer Widget Area','mandrake_theme'),
			__('Fifth Footer Widget Area','mandrake_theme'),
			__('Sixth Footer Widget Area','mandrake_theme'),
		);
	}

	function register_sidebar(){
		foreach ($this->sidebar_names as $name){
			register_sidebar(array(
				'name' => $name,
				'description' => $name,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			));
		}
		
		foreach ($this->footer_sidebar_names as $name){
			register_sidebar(array(
				'name' =>  $name,
				'description' => $name,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			));
		}

		$custom_sidebars = theme_get_option('sidebar','sidebars');
		if(!empty($custom_sidebars)){
			$custom_sidebar_names = explode(',',$custom_sidebars);
			foreach ($custom_sidebar_names as $name){
				register_sidebar(array(
					'name' =>  $name,
					'description' => $name,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>',
				));
			}
		}
	}
	
	function get_sidebar($post_id){
		
		if(is_page()){
			$sidebar = $this->sidebar_names['page'];
		}
		if($post_id == 'home'){
			$sidebar = $this->sidebar_names['home'];
		}
		if($post_id == 'blog' || is_singular('post') || is_search() || is_archive()){
			$sidebar = $this->sidebar_names['blog'];
		}
		if(!empty($post_id)){
			$custom = get_post_meta($post_id, '_sidebar', true);
			if(!empty($custom)){
				$sidebar = $custom;
			}
		}
		if(isset($sidebar)){
			dynamic_sidebar($sidebar);
		}
	}
}
global $_sidebarBuilder;
$_sidebarBuilder = new sidebarBuilder;

add_action('widgets_init', array($_sidebarBuilder,'register_sidebar'));

function sidebar_builder($function){
	global $_sidebarBuilder;
	$args = array_slice(func_get_args(), 1 );
	return call_user_func_array(array( &$_sidebarBuilder, $function ), $args);
}
?>