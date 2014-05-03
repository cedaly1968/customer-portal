<?php
/**
 * Twitter Widget Class
 */
class Widget_Twitter extends WP_Widget {

	function Widget_Twitter() {
		//Constructor
		$widget_ops = array('classname' => 'widget_twitter', 'description' => __( 'Displays tweets from Twitter', 'mandrake_theme' ));
		$this->WP_Widget('twitter', THEME_NAME.' - '.__('Twitter', 'mandrake_theme'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Tweets', 'mandrake_theme') : $instance['title'], $instance, $this->id_base);
		$username = $instance['username'];
		$count = (int)$instance['count'];
		
		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		$id = rand(1,100);
		?>
        
		<script type="text/javascript">
        jQuery(document).ready(function(){
			jQuery(".twitter-wrap-<?php echo $id;?>").tweet({
				username: "<?php echo $username;?>",
				count: <?php echo $count;?>,
				join_text: "auto",
				loading_text: "<?php _e('Loading tweets...','mandrake_theme');?>",
				seconds_ago_text: '<?php _e('about %d seconds ago','mandrake_theme');?>',
				a_minutes_ago_text: '<?php _e('about a minute ago','mandrake_theme');?>',
				minutes_ago_text: '<?php _e('about %d minutes ago','mandrake_theme');?>',
				a_hours_ago_text: '<?php _e('about an hour ago','mandrake_theme');?>',
				hours_ago_text: '<?php _e('about %d hours ago','mandrake_theme');?>',
				a_day_ago_text: '<?php _e('about a day ago','mandrake_theme');?>',
				days_ago_text: '<?php _e('about %d days ago','mandrake_theme');?>',
				auto_join_text_default: '<?php _e('i said,','mandrake_theme');?>',
				auto_join_text_ed: '<?php _e('i','mandrake_theme');?>',
				auto_join_text_ing: '<?php _e('i am','mandrake_theme');?>',
				auto_join_text_reply: '<?php _e('i replied to','mandrake_theme');?>',
				auto_join_text_url: '<?php _e('i was looking at','mandrake_theme');?>'
			});
        });
        </script>
        <div class="twitter-wrap-<?php echo $id;?>"></div>
            
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['count'] = (int) $new_instance['count'];
		return $instance;
	}
	
	function form($instance) {
		//widgetform in backend
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$username = isset($instance['username']) ? esc_attr($instance['username']) : '';
		$count = isset($instance['count']) ? absint($instance['count']) : 4;
		
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('How many tweets to display?', 'mandrake_theme'); ?></label>
		<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
		
		<?php
	}
}
register_widget('Widget_Twitter');

?>