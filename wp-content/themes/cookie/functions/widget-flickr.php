<?php
class ThemeFlickr extends WP_Widget {

			function ThemeFlickr() {
				wp_register_script('jflickrfeed', get_template_directory_uri() . '/js/libs/jflickrfeed.min.js', 'jquery');
				wp_enqueue_script('jquery-ui-tabs');
				wp_enqueue_script('jflickrfeed', '','','',true);
				// Instantiate the parent object
				parent::WP_Widget(false, __('Theme - Flickr', 'meydjer'));
			}

      function widget($args, $instance) {
			extract($args);
			$flickrtitle = $instance['flickrtitle'];
			$flickrid = $instance['flickrid'];
			$flickrthumbs = $instance['flickrthumbs'];
			?>
			<li id="ml_flickr-widget" class="widget">
				<h3 class="widgettitle"><?php echo $flickrtitle; ?></h3>
				<div id="flickr">
					<ul id="ml_jflickrfeed"></ul>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#ml_jflickrfeed').jflickrfeed({
						limit: <?php echo $flickrthumbs; ?>,
						qstrings: {
							id: '<?php echo $flickrid; ?>'
						},
						itemTemplate: '<li> <a href="http://www.flickr.com/photos/<?php echo $flickrid; ?>" target="_blank"><img src="{{image_s}}" alt="{{title}}" width="57" height="57" /></a> </li>'
						});
					});
				</script>
			</li>
       
		<?php }
		
		function update ($new_instance, $old_instance) {
		 $instance = $old_instance;
		
		 $instance['flickrtitle'] = $new_instance['flickrtitle'];
		 $instance['flickrid'] = $new_instance['flickrid'];
		 $instance['flickrthumbs'] = $new_instance['flickrthumbs'];
		
		 return $instance;
		}
		
		function form($instance) {
		$defaults = array('numbertweets' => '2');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
				
		<h3>Flickr</h3>
		<p>
			<label for="<?php echo $this->get_field_id('flickrtitle'); ?>"><?php _e('Widget Title', 'meydjer'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('flickrtitle') ?>" id="<?php echo $this->get_field_id('flickrtitle') ?> " value="<?php echo $instance['flickrtitle'] ?>" > <br />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('flickrid'); ?>">Flickr ID:</label>
			<input type="text" name="<?php echo $this->get_field_name('flickrid') ?>" id="<?php echo $this->get_field_id('flickrid') ?> " value="<?php echo $instance['flickrid'] ?>" size="15"> <br />
			<h5><?php _e('To get your Flickr ID go to <a href="http://idgettr.com/" target="_blank">http://idgettr.com/</a>.', 'meydjer'); ?></h5>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('flickrthumbs'); ?>"><?php _e('Number of thumbnails to display:', 'meydjer'); ?></label>
			<input type="text" name="<?php echo $this->get_field_name('flickrthumbs') ?>" id="<?php echo $this->get_field_id('flickrthumbs') ?> " value="<?php echo $instance['flickrthumbs'] ?>" size="1"> <br />
		</p><br />
		<?php }
}
register_widget('ThemeFlickr');
?>