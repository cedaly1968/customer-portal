<?php
/**
 * Qualeb Theme Custom Widgets
 *
 * @package Qualeb
 * @since Qualeb 1.0
 *
 -------------------------------------
 */
 
/*-------------------------------------------------------------------------------------*/
/*		0.	Contents
/*-------------------------------------------------------------------------------------*/
/*
		1.	Register widgetized areas and update sidebar with default widgets
		2.	Initialize Widgets Function
		3.	Flickr Widget
		4.	Popular Posts Widget
		5.	Random Posts Widget
		6.	Subnav Widget
		7.	Twitter Widget
		8.  Portfolio Widget
*/

/*-------------------------------------------------------------------------------------*/
//		1. 	Register widgetized areas and update sidebar with default widgets
/*-------------------------------------------------------------------------------------*/

function demagician_widgetareas_init() {
	register_sidebar( array (
		'name' => __( 'Blog', 'demagician' ),
		'id' => 'sidebar-blog',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
	register_sidebar( array (
		'name' => __( 'Pages', 'demagician' ),
		'id' => 'sidebar-pages',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
	register_sidebar( array (
		'name' => __( 'Footer', 'demagician' ),
		'id' => 'sidebar-footer1',
		'description' => __( 'First footer column from the left', 'demagician' ),
		'before_widget' => '<aside data-id="%1$s" class="footer-w %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
}
add_action( 'init', 'demagician_widgetareas_init' );


/*-------------------------------------------------------------------------------------*/
//		2.	Initialize Widgets Function
/*-------------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'demagician_widgets_init' );

function demagician_widgets_init() {
	register_widget('Flickr_Widget');
	register_widget('Popular_Widget');
	register_widget('Random_Widget');
	register_widget('Subnav_Widget');
	register_widget('Twitter_Widget');
	register_widget('Portfolio_Widget');
}

/*-------------------------------------------------------------------------------------*/
//		3.	Flickr Widget 
/*-------------------------------------------------------------------------------------*/

class Flickr_Widget extends WP_Widget {

	function Flickr_Widget() {
		/* Widget options */
		$widget_options = array( 'classname' => 'Flickr_Widget', 'description' => 'Display your Flickr photos using your Flickr ID.' );
		$control_options = array( 'id_base' => 'flickr-widget' );

		/* Create widget */
		$this->WP_Widget( 'flickr-widget', 'DeMagician Flickr Widget', $widget_options, $control_options );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Retrieve Settings */
		$title = apply_filters('widget_title', $instance['title'] );
		$flickr_id = $instance['flickr_id'];
		$count = $instance['count'];
		$type = $instance['type'];
		$display = $instance['display'] ;

		/* Before widget */
		echo $before_widget;

		/* Widget Title */
		if ( $title )
			echo $before_title . $title . $after_title;
				
		?>
        <div class="flickr_widget">
			<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $count; ?>&amp;display=<?php echo $display; ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type;?>&amp;<?php echo $type;?>=<?php echo $flickr_id; ?>"></script>
		</div>

		<?php
		/* After widget */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Update settings */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickr_id'] = $new_instance['flickr_id'];
		$instance['count'] = $new_instance['count'];
		$instance['type'] = $new_instance['type'];
		$instance['display'] = $new_instance['display'];
		return $instance;}
		
		function form( $instance ) {

		/* Default widget settings */
		$defaults = array( 'title' => 'Flickr', 'type' => 'Choose Type', 'count' => '8', 'display' => 'Choose Display');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flickr_id' ); ?>">Flickr ID(<a href="http://idgettr.com/" target="_blank">Find your Flickr ID</a>):</label>
			<input id="<?php echo $this->get_field_id( 'flickr_id' ); ?>" name="<?php echo $this->get_field_name( 'flickr_id' ); ?>" value="<?php echo $instance['flickr_id']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>">Type:</label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat" style="width:100%;">
				<option>Choose Type</option>
				<option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
				<option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>	
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>">Number of Photos Displayed:</label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:20px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>">Diplay Random or Latest? :</label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat" style="width:100%;">
				<option>Choose Display</option>
				<option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
				<option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
			</select>
		</p>
		
		<?php
	}
}

/*-------------------------------------------------------------------------------------*/
//		4.	Popular Posts Widget 
/*-------------------------------------------------------------------------------------*/

class Popular_Widget extends WP_Widget {

	function Popular_Widget() {
		/* Widget options */
		$widget_options = array( 'classname' => 'Popular_Widget', 'description' => 'A list of the most popular posts.' );
		$control_options = array( 'id_base' => 'popular-widget' );

		/* Create Widget */
		$this->WP_Widget( 'popular-widget', 'DeMagician Popular Posts', $widget_options, $control_options );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Retrieve Settings */
		$title = apply_filters('widget_title', $instance['title'] );
		$count = $instance['count'];

		/* Before widget  */
		echo $before_widget;

		/* Widget Title */
		if ( $title )
			echo $before_title . $title . $after_title;
				
		?>

		<ul class="popular-comments">
			<?php
				$args=array(
				   'orderby'=>'comment_count',
				   'posts_per_page' => $count
				);
				$dm_pp = new WP_Query($args); 
			?>
			<?php 
				global $post;
				while ($dm_pp->have_posts()) : $dm_pp->the_post(); 
			?>
					<li>
						<a class="title" href="<?php echo str_replace("&", "&amp;", get_permalink($post->ID)); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</li>
			<?php
				endwhile; 
			?>
		</ul>
        
		<?php
		/* After widget */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Update settings */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];

		return $instance;
	}
		
	function form( $instance ) {

		/* Default widget settings */
		$defaults = array( 'title' => 'Popular Entries', 'count' => '6');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>">Number of posts displayed:</label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:20px;" />
		</p>

		<?php
	}
}


/*-------------------------------------------------------------------------------------*/
//		5.	Random Posts Widget
/*-------------------------------------------------------------------------------------*/

class Random_Widget extends WP_Widget {

	function Random_Widget() {
		/* Widget options */
		$widget_options = array( 'classname' => 'Random_Widget', 'description' => 'Displays random posts from the blog.' );
		$control_options = array( 'id_base' => 'random-widget' );

		/* Create Widget */
		$this->WP_Widget( 'random-widget', 'DeMagician Random Posts Widget', $widget_options, $control_options );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Retrieve Settings */
		$title = apply_filters('widget_title', $instance['title'] );
		$count = $instance['count'];

		/* Before widget  */
		echo $before_widget;

		/* Widget Title */
		if ( $title )
			echo $before_title . $title . $after_title;
				
		?>

        
		<ul id="random-comments">
			<?php
			$args=array(
			   'orderby'=>'rand',
			   'posts_per_page' => $count
			);
			$pp = new WP_Query($args); 
			global $post;
			while ($pp->have_posts()) : $pp->the_post(); 
			?>
				<li>
					<a class="title" href="<?php echo str_replace("&", "&amp;", get_permalink($post->ID)); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a><br/>
				</li>
			<?php
			endwhile; 
			?>
		</ul>
        

		<?php
		/* After widget */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Update settings */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];

		return $instance;}
		
		function form( $instance ) {

		/* Default widget settings */
		$defaults = array( 'title' => 'Random Posts', 'count' => '2');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>">Number of Posts Displayed:</label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:20px;" />
		</p>

		<?php
	}
}

/*-------------------------------------------------------------------------------------*/
//		6.	Subnav Widget
/*-------------------------------------------------------------------------------------*/

class Subnav_Widget extends WP_Widget {

	function Subnav_Widget() {
		/* Widget options */
		$widget_options = array( 'classname' => 'SubNav_Widget', 'description' => 'Displays a Sub navigation.' );
		$control_options = array( 'id_base' => 'subnav-widget' );

		/* Create Widget */
		$this->WP_Widget( 'subnav-widget', 'DeMagician Subnav Widget', $widget_options, $control_options );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Retrieve Settings */
		$title = '';
		global $post;
		$parent_title = get_the_title($post->post_parent);
		
		/* Before widget  */
		echo $before_widget;

		/* Widget Title */
		if ( $title )
		echo $before_title . '<span class="subnav-title">' .$parent_title. '</span> ' . $after_title;
		
		$children = wp_list_pages("sort_column=menu_order&depth=1&title_li=&child_of=".$post->ID."&echo=0");
		if ($children) {$mypost = 'ID';} else{ $mypost = 'post_parent'; if(!$mypost){ $mypost = 'ID';}}		
		$children = wp_list_pages("sort_column=menu_order&depth=1&title_li=&child_of=".$post->$mypost."&echo=0"); 
		if ($children) { 
		?>
		<ul class="widget-subnav">
			<?php 
				echo $children;
			?>
		</ul>
		<?php 
		} 
		?>
	
		<?php

		/* After widget */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Update settings */
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;}
		
		function form( $instance ) {

		/* Default settings */
		$defaults = array( 'title' => 'Sub Nav');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		

		<?php
	}
}

/*-------------------------------------------------------------------------------------*/
//		7.	Twitter Widget
/*-------------------------------------------------------------------------------------*/

class Twitter_Widget extends WP_Widget {

	function Twitter_Widget() {
		/* Widget options */
		$widget_options = array( 'classname' => 'Twitter_Widget', 'description' => 'Display your latests Tweets.' );
		$control_options = array( 'id_base' => 'twitter-widget' );

		/* Create Widget */
		$this->WP_Widget( 'twitter-widget', 'DeMagician Twitter Widget', $widget_options, $control_options );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Retrieve Settings */
		$title = apply_filters('widget_title', $instance['title'] );
		$twitter_user = $instance['twitter_user'];
		$count = $instance['count'];

		/* Before widget  */
		echo $before_widget;

		/* Widget Title */
		if ( $title )
			echo $before_title . $title . $after_title;
				
		?>
        <div class="tweet" data-count="<?php echo $count; ?>" data-user="<?php echo $twitter_user; ?>">
		</div>

		<?php

		/* After widget */
		echo $after_widget;
		}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Update settings */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['twitter_user'] = $new_instance['twitter_user'];
		$instance['count'] = $new_instance['count'];

		return $instance;}
		
		function form( $instance ) {

		/* Default widget settings */
		$defaults = array( 'title' => 'Twitter', 'count' => '2');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_user' ); ?>">Twitter Username:</label>
			<input id="<?php echo $this->get_field_id( 'twitter_user' ); ?>" name="<?php echo $this->get_field_name( 'twitter_user' ); ?>" value="<?php echo $instance['twitter_user']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>">Number of Tweets to display:</label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:20px;" />
		</p>

		<?php
	}
}

/*-------------------------------------------------------------------------------------*/
//		8.	Portfolio Widget
/*-------------------------------------------------------------------------------------*/

class Portfolio_Widget extends WP_Widget {

	function Portfolio_Widget() {
		/* Widget options */
		$widget_options = array( 'classname' => 'Portfolio_Widget', 'description' => 'Display Portfolio items.' );
		$control_options = array( 'id_base' => 'portfolio-widget' );

		/* Create Widget */
		$this->WP_Widget( 'portfolio-widget', 'DeMagician Portfolio Widget', $widget_options, $control_options );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Retrieve Settings */
		$title = apply_filters('widget_title', $instance['title'] );
		$count = $instance['count'];
		$category = $instance['category'];
		$order = $instance['order'];
		$orderby = $instance['orderby'];

		/* Before widget  */
		echo $before_widget;

		/* Widget Title */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		
		/*---Getting the portfolio Items to display ---*/
		?>
		<div id="portfolioslider" class="flexslider clearfix" style="padding-bottom:0px; border:none;"><ul class="slides">
		<?php
		$tax_query_arr = '';
		if ($category){ // If a category is specified, define the content of the tax_query
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
		
		while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
			$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'portfolio-home');
			$src = $src[0];
			$permalink = get_permalink();
		
			if ($permalink) {
			?>
				<li> <a href="<?php echo esc_attr($permalink);  ?>"  target="_blank" ><img src="<?php echo $src ?>" /> </a></li>
			<?php	
			}
			else {
			?>
				<li><img src="<?php echo $src ?>" /> </a></li>
			<?php
			}
		endwhile;
		?>
		
		</ul> </div>

		<?php

		/* After widget */
		echo $after_widget;
		}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Update settings */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = $new_instance['count'];
		$instance['category'] = $new_instance['category'];
		$instance['order'] = $new_instance['order'];
		$instance['orderby'] = $new_instance['orderby'];

		return $instance;}
		
		function form( $instance ) {

		/* Default widget settings */
		$defaults = array( 'title' => 'Portfolio Widget', 'count' => '4', 'order' => 'DESC');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>">Number of Items to display:</label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" style="width:20px;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>">Category (Specific category - <em>optional</em>):</label>
			<input id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" value="<?php echo $instance['category']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>">Order (ASC / DESC):</label>
			<input id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" value="<?php echo $instance['order']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>">Orderby (Options: none, ID, menu_order, author, title, date, modified, rand - <em>Optional</em>):</label>
			<input id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" value="<?php echo $instance['orderby']; ?>" style="width:100%;" />
		</p>
		

		<?php
	}
}



?>