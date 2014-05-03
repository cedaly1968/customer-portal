<?php
/**
 * Testimonials Widget Class
 */
class Widget_Testimonials extends WP_Widget {

	function Widget_Testimonials() {
		//Constructor
		$widget_ops = array('classname' => 'widget_testimonials', 'description' => __( 'Displays a list of testimonials', 'mandrake_theme' ) );
		$this->WP_Widget('testimonials', THEME_NAME.' - '.__('Testimonials', 'mandrake_theme'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Testimonials', 'mandrake_theme') : $instance['title'], $instance, $this->id_base);
		$count = (int)$instance['count'];
		
		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
		}
		
		echo '<div class="navigation">';
		for ($i=1; $i<= $count; $i++) {
			echo '<a href="#"></a>';
		}
		echo '</div>';
		
		echo '<ul class="blockquote">';
		if ($count > 0) {
			for ($i=1; $i<= $count; $i++) {
				$testimonial = isset($instance['testimonial_'.$i])?$instance['testimonial_'.$i]:'';
				$cite = isset($instance['cite_'.$i])?$instance['cite_'.$i]:'';
				$output .= '<li><blockquote><p>'.$testimonial.'</p><p><cite>'.$cite.'</cite></p></blockquote></li>';
			}
		}
		echo $output;
		echo '</ul>';
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = (int) $new_instance['count'];
		for($i=1;$i<=$instance['count'];$i++){
			$instance['testimonial_'.$i] = strip_tags($new_instance['testimonial_'.$i]);
			$instance['cite_'.$i] = strip_tags($new_instance['cite_'.$i]);
		}
		return $instance;
	}
	
	function form($instance) {
		//widgetform in backend
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$count = isset($instance['count']) ? absint($instance['count']) : 3;
		for($i=1;$i<=10;$i++){
			$a_testimonial = 'testimonial_'.$i;
			$$a_testimonial = isset($instance[$a_testimonial]) ? $instance[$a_testimonial] : '';
			$a_cite = 'cite_'.$i;
			$$a_cite = isset($instance[$a_cite]) ? $instance[$a_cite] : '';
		}
		?>
        
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('How many testimonials to display?', 'mandrake_theme'); ?></label>
		<input id="<?php echo $this->get_field_id('count'); ?>" class="testimonials_count" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
        
        <div class="testimonial-wrap">
		<?php for($i=1;$i<=10;$i++): $a_testimonial = 'testimonial_'.$i;$a_cite = 'cite_'.$i; ?>
			<div class="testimonial_<?php echo $i;?>" <?php if($i>$count):?>style="display:none"<?php endif;?>>
				<p><label for="<?php echo $this->get_field_id( $a_testimonial ); ?>"><?php printf(__('#%s Testimonial:', 'mandrake_theme'),$i);?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id( $a_testimonial ); ?>" name="<?php echo $this->get_field_name( $a_testimonial ); ?>" cols="20" rows="10"><?php echo $$a_testimonial; ?></textarea></p>
				<p><label for="<?php echo $this->get_field_id( $a_cite ); ?>"><?php printf(__('#%s Cite:', 'mandrake_theme'),$i);?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $a_cite ); ?>" name="<?php echo $this->get_field_name( $a_cite ); ?>" type="text" value="<?php echo $$a_cite; ?>" /></p>
			</div>
		<?php endfor;?>
		</div>
		
		<?php
	}
}
register_widget('Widget_Testimonials');

?>