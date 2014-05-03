<?php
/**
 * Contact Form Widget Class
 */
class Widget_Contact_Form extends WP_Widget {

	function Widget_Contact_Form() {
		//Constructor
		$widget_ops = array('classname' => 'widget_contact_form', 'description' => __( 'Displays a email contact form', 'mandrake_theme' ) );
		$this->WP_Widget('contact_form', THEME_NAME.' - '.__('Contact Form', 'mandrake_theme'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Email Us', 'mandrake_theme') : $instance['title'], $instance, $this->id_base);
		$email= $instance['email'];
		
		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		$id = rand(1,100);
		?>
        
        <div class="contact-form-wrap">
        <div class="contact-success"><p><?php _e('Your message was successfully sent. <strong>Thank You!</strong>', 'mandrake_theme'); ?></p></div>
        <form class="contact-form" action="<?php echo THEME_INCLUDES; ?>/sendmail.php" method="post">
			<p><input type="text" id="contact-name-<?php echo $id; ?>" name="contact_name" class="contact-name" />
			<label for="contact-name-<?php echo $id; ?>"><?php _e('Name *', 'mandrake_theme'); ?></label></p>
			
			<p><input type="text" id="contact-email-<?php echo $id; ?>" name="contact_email" class="contact-email" />
			<label for="contact-email-<?php echo $id; ?>"><?php _e('Email *', 'mandrake_theme'); ?></label></p>
			
			<p><textarea name="contact_message" class="contact-message" cols="20" rows="5"></textarea></p>
			
			<p><button type="submit" class="button small active"><span><?php _e('Submit', 'mandrake_theme'); ?></span></button></p>
			<input type="hidden" value="<?php echo $email;?>" name="contact_to" class="contact-to"/>
		</form>
        </div>
              
        <?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['email'] = strip_tags($new_instance['email']);
		return $instance;
	}
	
	function form($instance) {
		//widgetform in backend
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$email = isset($instance['email']) ? esc_attr($instance['email']) :get_bloginfo('admin_email');
		?>
        
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Your Email:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" /></p>
		
		<?php
	}
	
}
register_widget('Widget_Contact_Form');

?>