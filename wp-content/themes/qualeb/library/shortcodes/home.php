<?php
/**
 * HomePage elements shortcodes
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
 
/*-------------------------------------------------------------------------------------*/
/*		1.		Home Page Slider Shortcode
/*-------------------------------------------------------------------------------------*/

function dm_homeSlider($atts, $content = null){
	extract(shortcode_atts(array(
	"class" => ''
	), $atts));
	$return = '<div id="slider" class="flexslider clearfix '.$class.'"><ul class="slides">';
	global $wp_query;
	global $post;
	$wp_query = new WP_Query("post_type=slider_items&post_status=publish&orderby=menu_order&order=ASC"); 
	while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'home-slider');
		$src = $src[0]; 
		$link = get_post_meta($post->ID, 'dm_slide_link', true);
		if ($link) {
			$return .= '<li> <a href="'.$link.'"  target="_blank" ><img src="'.$src.'" /> </a></li>';
		}
		else {
			$return .= '<li><img src="'.$src.'" /></li>';
		}
	endwhile;
	
	$return .= '</ul> </div>';
	return $return;
	}
add_shortcode("homeslider", "dm_homeSlider");	


/*-------------------------------------------------------------------------------------*/
/*		2.		Home Portfolio Items Display
/*-------------------------------------------------------------------------------------*/

function dm_portfolioitems($atts, $content = null){
	extract(shortcode_atts(array(
	"count" => '9',
	"cat" => '',
	"order" => 'ASC',
	"orderby" => ''
	), $atts));
	
	$return = '<div id="home-portfolio"> <ul> ';
	
	$tax_query_arr = '';
	if ($cat){ // If a category is specified, define the content of the tax_query
	$tax_query_arr = array(
						array( //Display Posts from the given category only
							'taxonomy' => 'portfolio_category',
							'field' => 'slug',
							'terms' => array($cat)
						)
					);
	}
	
	$wp_query = new WP_Query();
	$wp_query->query( array('post_type' => 'portfolio','order' => $order, 'orderby' => $orderby,'posts_per_page' => $count, 'tax_query' => $tax_query_arr ));
	$count = 1;
	global $post;
	while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'portfolio-home');
		$src = $src[0];
		$post_terms = wp_get_post_terms($post->ID,'portfolio_category', 'hide_empty=1');
		$term_class = '';
		foreach($post_terms as $post_term) {
			$term_class .= $post_term->slug . ' ';
		}		
		$postId = get_the_ID();
		$permalink = get_permalink();
		$perm = esc_attr($permalink);
		$postTitle = get_the_title();
		$excerpt =  item_text(40);
		$template_url = get_bloginfo('template_url');
		if ($count % 3 == 0){
			$last = '_last';
		}
		else{
			$last = '';
		}
		$return .= ' <li class="home_portfolio_item'.$last.'">
						<a href="'.$perm.'" class="portfolio-item-link">
							<img class="itemimg" src="'.$src.'" />
							<div class="home-portfolio-hover"><!-- Appears on hover -->
							<h2 class="portfolio-entry-title">'.$postTitle.'</h2>
							'.$excerpt.'
							<img src="'.$template_url.'/css/images/portfolio-hover-arr.png" />
						</div><!-- .home-portfolio-hover -->
						</a>
						
					</li> ';
		$term_class = '';			
		$count++;
		
	endwhile;
	
	$return .= '</ul></div>';

	return $return;
	}
add_shortcode("portfolioitems", "dm_portfolioitems");	


/*-------------------------------------------------------------------------------------*/
/*		3.		Home Sidebar Shortcode (include contents of sidebar inside the tags)
/*-------------------------------------------------------------------------------------*/

function dm_home_sidebar($atts, $content = null){
	return '<div id="home-sidebar">' . do_shortcode($content) . '</div><!-- #home-sidebar-->';
	}
add_shortcode("homesidebar", "dm_home_sidebar");	


/*-------------------------------------------------------------------------------------*/
/*		4.		Home Intro + Title (underlined h2 title located in home sidebar)
/*-------------------------------------------------------------------------------------*/

function dm_home_intro_title($atts, $content = null){
	return '<h2 class="home-sidebar-title">' . do_shortcode($content) . '</h2>';
	}
add_shortcode("hometitle", "dm_home_intro_title");	

function dm_home_intro($atts, $content = null){
	return '<div class="home-intro">' . do_shortcode($content) . '</div><!-- #home-intro-->';
	}
add_shortcode("homeintro", "dm_home_intro");	


/*-------------------------------------------------------------------------------------*/
/*		5.		Display posts from the blog
/*-------------------------------------------------------------------------------------*/

function dm_show_post($atts, $content = null){
	extract(shortcode_atts(array(
	'ids' => '',
	'count' => '2',
	'order' => 'popular' // popular, random, recent
	), $atts));
	
	if ($ids){
		$delimiter=",";
		$ids = explode($delimiter, $ids);
	}
	
	if ($order == 'random'){
		$order = 'rand';
	}
	elseif($order == 'popular'){
		$order = 'comment_count';
	}
	elseif($order == 'recent'){
		$order = 'date';
	}

	$args=array(
		'posts_per_page' => $count,
		'orderby' => $order,
		'post__in' => $ids
	);

	$pp = new WP_Query($args); 
	$print = '';
	while ($pp->have_posts()) : $pp->the_post(); 
	
	$postId = get_the_ID();
	$permalink = get_permalink();
	$postTitle = get_the_title();
	$excerpt =  intro_text(120);
	$date = get_the_date( 'M j, Y');
	
	$print .= '<h3 class="home-article-title">'.$postTitle.' </h3>
	<span class="home-article-date">'.$date.'</span><br /> 	'.$excerpt.'';
				
	endwhile; 

	return $print;
	}
	
add_shortcode("showposts", "dm_show_post");	


?>