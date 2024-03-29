<?php
/**
 * Flickr Widget Class
 */
class Widget_Flickr extends WP_Widget {
	
	function Widget_Flickr() {
		//Constructor
		$widget_ops = array('classname' => 'widget_flickr', 'description' => __( 'Displays photos from a Flickr', 'mandrake_theme' ) );
		$this->WP_Widget('flickr', THEME_NAME.' - '.__('Flickr', 'mandrake_theme'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Flickr', 'mandrake_theme') : $instance['title'], $instance, $this->id_base);
		$flickr_id = $instance['flickr_id'];
		$count = (int)$instance['count'];
		$display = empty( $instance['display'] ) ? 'latest' : $instance['display'];
		
		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		?>
        
        <div class="flickr-wrap">
			<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $count; ?>&amp;display=<?php echo $display; ?>&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $flickr_id; ?>"></script>
		</div>
        
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flickr_id'] = strip_tags($new_instance['flickr_id']);
		$instance['count'] = (int) $new_instance['count'];
		$instance['display'] = strip_tags($new_instance['display']);
		return $instance;
	}
	
	function form($instance) {
		//widgetform in backend
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$flickr_id = isset($instance['flickr_id']) ? esc_attr($instance['flickr_id']) : '';
		$count = isset($instance['count']) ? absint($instance['count']) : 3;
		$display = isset( $instance['display'] ) ? $instance['display'] : 'latest';
		?>
        
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com" target="_blank">idGettr</a>):', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" type="text" value="<?php echo $flickr_id; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of photo to show:', 'mandrake_theme'); ?></label>
		<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
		
		<p><label for="<?php echo $this->get_field_id('display'); ?>"><?php _e('Method for display your photos:', 'mandrake_theme'); ?></label>
		<select id="<?php echo $this->get_field_id('display'); ?>" name="<?php echo $this->get_field_name('display'); ?>">
			<option<?php if($display == 'latest') echo ' selected="selected"'?> value="latest"><?php _e('Latest', 'mandrake_theme'); ?></option>
			<option<?php if($display == 'random') echo ' selected="selected"'?> value="random"><?php _e('Random', 'mandrake_theme'); ?></option>
		</select>
        
		<?php
	}
}
register_widget('Widget_Flickr');

?>