<?php
/**
 * Contact Info Widget Class
 */
class Widget_Contact_Info extends WP_Widget {

	function Widget_Contact_Info() {
		//Constructor
		$widget_ops = array('classname' => 'widget_contact_info', 'description' => __( 'Displays a list of contact info', 'mandrake_theme' ) );
		$this->WP_Widget('contact_info', THEME_NAME.' - '.__('Contact Info', 'mandrake_theme'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Contact Info', 'mandrake_theme') : $instance['title'], $instance, $this->id_base);
		$text = $instance['text'];
		$name = $instance['name'];
		$phone = $instance['phone'];
		$cellphone = $instance['cellphone'];
		$email= $instance['email'];
		$address = $instance['address'];
		
		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		?>
        
        <?php if(!empty($text)):?><p><?php echo $text;?></p><?php endif;?>
        <ul>
            <?php if(!empty($name)):?><li class="person"><?php echo $name;?></li><?php endif;?>
            <?php if(!empty($phone)):?><li class="phone"><?php echo $phone;?></li><?php endif;?>
            <?php if(!empty($cellphone)):?><li class="mobile"><?php echo $cellphone;?></li><?php endif;?>
            <?php if(!empty($email)):?><li class="email"><?php echo $email;?></li><?php endif;?>
            <?php if(!empty($address)):?><li class="address"><?php echo $address;?></li><?php endif;?>
        </ul>
        
        <?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['name'] = strip_tags($new_instance['name']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['cellphone'] = strip_tags($new_instance['cellphone']);
		$instance['email'] = strip_tags($new_instance['email']);
		$instance['address'] = strip_tags($new_instance['address']);
		return $instance;
	}
	
	function form($instance) {
		//widgetform in backend
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$text = isset($instance['text']) ? esc_attr($instance['text']) : '';
		$name = isset($instance['name']) ? esc_attr($instance['name']) : '';
		$phone = isset($instance['phone']) ? esc_attr($instance['phone']) : '';
		$cellphone = isset($instance['cellphone']) ? esc_attr($instance['cellphone']) : '';
		$email = isset($instance['email']) ? esc_attr($instance['email']) : '';
		$address = isset($instance['address']) ? esc_attr($instance['address']) : '';
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Introduce text:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Name:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo $name; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo $phone; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('cellphone'); ?>"><?php _e('Cell phone:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('cellphone'); ?>" name="<?php echo $this->get_field_name('cellphone'); ?>" type="text" value="<?php echo $cellphone; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" /></p>
		
        <?php
	}
}
register_widget('Widget_Contact_Info');

?>