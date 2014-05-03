<?php
/**
 * Social Widget Class
 */
class Widget_Social extends WP_Widget {
	
	var $sites = array(
		'Add-this','Amazon','AOL','Apple','Bebo','Behance','Bing','Blip','Blogger',
		'Coroflot','Daytum','Delicious','Design-bump','Designfloat','Deviant-art','Digg','Dribbble',
		'Dropplr','Drupal','Ebay','Email','Ember','Facebook','Feedburner','Flickr',
		'Forrst','Foursquare','Friendfeed','Friendster','Gdgt','Github','Google','Google-buzz',
		'Google-talk','Gowalla','Heart','Hyves','Icondock','Icq','Identi','iTune','Lastfm',
		'Linkedin','Meetup','Metacafe','Microsoft','Mister-wong','Mixx','Mobileme','Msn','Myspace',
		'Netvibes','Newsvine','Paypal','Photobucket','Picasa','Podcast','Posterous','Qik','Reddit',
		'Retweet','Rss','Scribd','Sharethis','Skype','Slashdot','Slideshare','Smugmug','Soundcloud','Spotify',
		'Squidoo','Star','Stumbleupon','Technorati','Tumblr','Twitter','W3','Viddler','Wikipedia','Vimeo',
		'Virb','Wordpress','Xing','Yahoo','Yahoo-buzz','Yelp','Youtube'
	);
	
	var $packages = array(
		'icondock_16' => array(
			'name'=>'Social Media Icons 16px',
			'path'=>'social-icons/16px/{:name}.png',
		),
		'icondock_24' => array(
			'name'=>'Social Media Icons 24px',
			'path'=>'social-icons/24px/{:name}.png',
		),
		'icondock_32' => array(
			'name'=>'Social Media Icons 32px',
			'path'=>'social-icons/32px/{:name}.png',
		),
	);
	
	function Widget_Social() {
		//Constructor
		$widget_ops = array('classname' => 'widget_social', 'description' => __( 'Displays a list of Social Icons', 'mandrake_theme' ) );
		$this->WP_Widget('social', THEME_NAME.' - '.__('Social Icon', 'mandrake_theme'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$alt = isset($instance['alt'])?$instance['alt']:'';
		$package = $instance['package'];
		$custom_count = $instance['custom_count'];

		if(!empty($instance['enable_sites'])) {
			foreach($instance['enable_sites'] as $site) {
				$path = str_replace('{:name}',strtolower($site),$this->packages[$package]['path']);
				$link = isset($instance[strtolower($site)])?$instance[strtolower($site)]:'#';
				if(file_exists(THEME_DIR . '/images/'.$path)) {
					$output .= '<a href="'.$link.'" rel="nofollow" target="_blank"><img src="'.THEME_IMAGES.'/'.$path.'" alt="'.$alt.' '.$site.'" title="'.$alt.' '.$site.'"/></a>';
				}
			}
		}
		
		if($custom_count > 0) {
			for($i=1; $i<= $custom_count; $i++) {
				$name = isset($instance['custom_'.$i.'_name'])?$instance['custom_'.$i.'_name']:'';
				$icon = isset($instance['custom_'.$i.'_icon'])?$instance['custom_'.$i.'_icon']:'';
				$link = isset($instance['custom_'.$i.'_url'])?$instance['custom_'.$i.'_url']:'#';
				if(!empty($icon)) {
					$output .= '<a href="'.$link.'" rel="nofollow" target="_blank"><img src="'.$icon.'" alt="'.$alt.' '.$name.'" title="'.$alt.' '.$name.'"/></a>';
				}
			}
		}
		
		if (!empty( $output)) {
			echo $before_widget;
			if ($title) {
				echo $before_title . $title . $after_title;
			}
		?>
		<div class="social-wrap">
			<?php echo $output; ?>
		</div>
		<?php
			echo $after_widget;
		}
	}
	
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['alt'] = strip_tags($new_instance['alt']);
		$instance['package'] = strip_tags($new_instance['package']);
		$instance['enable_sites'] = $new_instance['enable_sites'];
		$instance['custom_count'] = (int) $new_instance['custom_count'];

		if(!empty($instance['enable_sites'])){
			foreach($instance['enable_sites'] as $site){
				$instance[strtolower($site)] = isset($new_instance[strtolower($site)])?strip_tags($new_instance[strtolower($site)]):'';
			}
		}
		
		for($i=1;$i<=$instance['custom_count'];$i++){
			$instance['custom_'.$i.'_name'] = strip_tags($new_instance['custom_'.$i.'_name']);
			$instance['custom_'.$i.'_url'] = strip_tags($new_instance['custom_'.$i.'_url']);
			$instance['custom_'.$i.'_icon'] = strip_tags($new_instance['custom_'.$i.'_icon']);
		}
		return $instance;
	}
	
	function form($instance) {
		//widgetform in backend
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$alt = isset($instance['alt']) ? esc_attr($instance['alt']) : 'Follow Us on';
		$package = isset($instance['package']) ? $instance['package'] : '';
		$enable_sites = isset($instance['enable_sites']) ? $instance['enable_sites'] : array();
		foreach($this->sites as $site){
			$$site = isset($instance[strtolower($site)]) ? esc_attr($instance[strtolower($site)]) : '';
		}

		$custom_count = isset($instance['custom_count']) ? absint($instance['custom_count']) : 0;
		for($i=1;$i<=10;$i++){
			$custom_name = 'custom_'.$i.'_name';
			$$custom_name = isset($instance[$custom_name]) ? $instance[$custom_name] : '';
			$custom_url = 'custom_'.$i.'_url';
			$$custom_url = isset($instance[$custom_url]) ? $instance[$custom_url] : '';
			$custom_icon = 'custom_'.$i.'_icon';
			$$custom_icon = isset($instance[$custom_icon]) ? $instance[$custom_icon] : '';
		}
		?>
        
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mandrake_theme'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Icon Alt Title:', 'mandrake_theme'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" name="<?php echo $this->get_field_name('alt'); ?>" type="text" value="<?php echo $alt; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('package'); ?>"><?php _e('Icon Package:' , 'mandrake_theme'); ?></label>
			<select class="widefat" name="<?php echo $this->get_field_name('package'); ?>" id="<?php echo $this->get_field_id('package'); ?>">
				<?php foreach($this->packages as $name => $value):?>
				<option value="<?php echo $name;?>"<?php selected($package,$name);?>><?php echo $value['name'];?></option>
				<?php endforeach;?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('enable_sites'); ?>"><?php _e('Enable Social Icon:', 'mandrake_theme' ); ?></label>
			<select name="<?php echo $this->get_field_name('enable_sites'); ?>[]" style="height:10em" id="<?php echo $this->get_field_id('enable_sites'); ?>" class="widefat" multiple="multiple">
				<?php foreach($this->sites as $site):?>
				<option value="<?php echo strtolower($site);?>"<?php echo in_array(strtolower($site), $enable_sites)? 'selected="selected"':'';?>><?php echo $site;?></option>
				<?php endforeach;?>
			</select>
		</p>
		
		<p><em><?php _e("Note: Please input FULL URL <br/>(e.g. <code>http://www.example.com</code>)", 'mandrake_theme');?></em></p>
      
		<div class="social-icon-wrap">
		<?php foreach($this->sites as $site):?>
		<p class="social-icon-<?php echo strtolower($site);?>" <?php if(!in_array(strtolower($site), $enable_sites)):?>style="display:none"<?php endif;?>>
			<label for="<?php echo $this->get_field_id( strtolower($site) ); ?>"><?php echo $site.' '.__('URL:', 'mandrake_theme')?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( strtolower($site) ); ?>" name="<?php echo $this->get_field_name( strtolower($site) ); ?>" type="text" value="<?php echo $$site; ?>" />
		</p>
		<?php endforeach;?>
		</div>

		<p><label for="<?php echo $this->get_field_id('custom_count'); ?>"><?php _e('How many custom icons to add?', 'mandrake_theme'); ?></label>
		<input id="<?php echo $this->get_field_id('custom_count'); ?>" name="<?php echo $this->get_field_name('custom_count'); ?>" type="text" value="<?php echo $custom_count; ?>" size="3" /></p>

		<div class="social-custom-icon-wrap">
		<?php for($i=1;$i<=10;$i++): $custom_name='custom_'.$i.'_name';$custom_url='custom_'.$i.'_url'; $custom_icon='custom_'.$i.'_icon'; ?>
			<div class="social_icon_custom_<?php echo $i;?>" <?php if($i>$custom_count):?>style="display:none"<?php endif;?>>
				<p><label for="<?php echo $this->get_field_id( $custom_name ); ?>"><?php printf(__('Custom %s Name:', 'mandrake_theme'),$i);?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $custom_name ); ?>" name="<?php echo $this->get_field_name( $custom_name ); ?>" type="text" value="<?php echo $$custom_name; ?>" /></p>
				<p><label for="<?php echo $this->get_field_id( $custom_url ); ?>"><?php printf(__('Custom %s URL:', 'mandrake_theme'),$i);?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $custom_url ); ?>" name="<?php echo $this->get_field_name( $custom_url ); ?>" type="text" value="<?php echo $$custom_url; ?>" /></p>
				<p><label for="<?php echo $this->get_field_id( $custom_icon ); ?>"><?php printf(__('Custom %s Icon:', 'mandrake_theme'),$i);?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $custom_icon ); ?>" name="<?php echo $this->get_field_name( $custom_icon ); ?>" type="text" value="<?php echo $$custom_icon; ?>" /></p>
			</div>

		<?php endfor;?>
		</div>	
	<?php
	}
	
}
register_widget('Widget_Social');

?>