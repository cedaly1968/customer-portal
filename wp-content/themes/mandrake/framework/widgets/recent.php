<?php
/**
 * Recent Posts Widget Class
 */
class Widget_Recent_Posts extends WP_Widget {

	function Widget_Recent_Posts() {
		//Constructor
		$widget_ops = array('classname' => 'widget_recent_posts', 'description' => __( 'Displays the recent posts', 'mandrake_theme' ) );
		$this->WP_Widget('recent_posts', THEME_NAME.' - '.__('Recent Posts', 'mandrake_theme'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';
		add_action('save_post', array(&$this, 'flush_widget_cache'));
        add_action('deleted_post', array(&$this, 'flush_widget_cache'));
        add_action('switch_theme', array(&$this, 'flush_widget_cache'));
	}
	
	function widget($args, $instance) {
		// prints the widget
		$cache = wp_cache_get('widget_recent_posts', 'widget');
        if (!is_array($cache))
                $cache = array();
        if ( isset($cache[$args['widget_id']]) ) {
                echo $cache[$args['widget_id']];
                return;
        }
        ob_start();
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'mandrake_theme') : $instance['title'], $instance, $this->id_base);
        if (!$number = (int) $instance['number'])
                $number = 10;
        else if ($number < 1)
                $number = 1;
        else if ($number > 15)
                $number = 15;
		$query = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1);
		if(!empty($instance['cat'])){
			$query['cat'] = implode(',', $instance['cat']);
		}
		$r = new WP_Query($query);
		if ($r->have_posts()) : ?>
        <?php echo $before_widget; ?>
        <?php if ($title) echo $before_title . $title . $after_title; ?>
        <ul>
        <?php  while ($r->have_posts()) : $r->the_post(); ?>
        <li>
        	<div class="post-image">
                <a href="<?php echo get_permalink() ?>" title="<?php the_title();?>">
                <?php the_post_thumbnail(array(50,50),array('title'=>get_the_title(),'alt'=>get_the_title())); ?>	
                </a>
			</div>
            <div class="post-text">
                <div class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></div>
                <div class="post-date"><?php echo get_the_date(); ?></div>
          </div>
        </li>
        <?php endwhile; ?>
        </ul>
        <?php echo $after_widget; ?>
		<?php
        	wp_reset_query();
        endif;
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_add('widget_recent_posts', $cache, 'widget');
	}
	
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['cat'] = $new_instance['cat'];
		$this->flush_widget_cache();
		$alloptions = wp_cache_get('alloptions', 'options');
		if (isset($alloptions['widget_recent_entries']))
			delete_option('widget_recent_entries');
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}
	
	function form($instance) {
		//widgetform in backend
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$cat = isset($instance['cat']) ? $instance['cat'] : array();
		if ( !isset($instance['number']) || !$number = (int) $instance['number'])
			$number = 5;
		$categories = get_categories('orderby=name&hide_empty=0');
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mandrake_theme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', 'mandrake_theme'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		<p><label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Categorys:' , 'mandrake_theme'); ?></label>
			<select style="height:100px;" name="<?php echo $this->get_field_name('cat'); ?>[]" id="<?php echo $this->get_field_id('cat'); ?>" class="widefat" multiple="multiple">
				<?php foreach($categories as $category):?>
				<option value="<?php echo $category->term_id;?>"<?php echo in_array($category->term_id, $cat)? ' selected="selected"':'';?>><?php echo $category->name;?></option>
				<?php endforeach;?>
			</select></p>
		<?php
	}
	
}
register_widget('Widget_Recent_Posts');

?>