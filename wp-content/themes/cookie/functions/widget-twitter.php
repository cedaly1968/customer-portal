<?php
class ThemeTwitter extends WP_Widget {

	function ThemeTwitter() {
		// Instantiate the parent object
		wp_register_script('tweet', get_template_directory_uri() . '/js/libs/jquery.tweet.min.js', 'jquery');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('tweet', '','','',true);
		parent::WP_Widget(false, 'Theme - Twitter');
	}
	
	/* call the widget settings */
  function widget($args, $instance) {
	extract($args);
	$twittertitle = $instance['twittertitle'];
	$twitterusername = $instance['twitterusername'];
	$numbertweets = $instance['numbertweets'];
	?>
	
	
	<li id="ml-twitter" class="widget widget_text">
				<h3 class="widgettitle"><?php echo $twittertitle; ?></h3>
				
				<?php /* load the widget script (js/libs/jquery.tweet.js) */ ?>
				<div id="twitter">
					<div class="tweets"></div>
				</div>
	</li>
	<script type='text/javascript'>
	    jQuery(document).ready(function(){
	        jQuery(".tweets").tweet({
	            username: "<?php echo $twitterusername; ?>",
	            count: <?php echo $numbertweets; ?>,
	            loading_text: "<?php _e('Loading tweets...', 'meydjer'); ?>"
	        });
	    });
	</script>
     
	<?php }
	
	/* update the widget settiings */
	function update ($new_instance, $old_instance) {
	 $instance = $old_instance;
	
	 $instance['twittertitle'] = $new_instance['twittertitle'];
	 $instance['twitterusername'] = $new_instance['twitterusername'];
	 $instance['numbertweets'] = $new_instance['numbertweets'];
	
	 return $instance;
	}
	
	/* widget settings form */
	function form($instance) {
	$defaults = array('numbertweets' => '2');
	$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
	<h3>Twitter</h3>

	<?php /* widget title */ ?>
	<p>
		<label for="<?php echo $this->get_field_id('twittertitle'); ?>"><?php _e('Title', 'meydjer'); ?>:</label>
		<input type="text" name="<?php echo $this->get_field_name('twittertitle') ?>" id="<?php echo $this->get_field_id('twittertitle') ?> " value="<?php echo $instance['twittertitle'] ?>" size="27">
	</p>

	<?php /* twitter username */ ?>
	<p>
		<label for="<?php echo $this->get_field_id('twitterusername'); ?>"><?php _e('Username', 'meydjer'); ?>:</label>
		<input type="text" name="<?php echo $this->get_field_name('twitterusername') ?>" id="<?php echo $this->get_field_id('twitterusername') ?> " value="<?php echo $instance['twitterusername'] ?>" size="27">
	</p>

	<?php /* number of tweets */ ?>
	<p>
		<label for="<?php echo $this->get_field_id('numbertweets'); ?>"><?php _e('Number of tweets to display', 'meydjer'); ?>:</label>
		<select id="<?php echo $this->get_field_id('numbertweets'); ?>" name="<?php echo $this->get_field_name('numbertweets'); ?>">
		<?php for ($i=1;$i<=10;$i++) {
		    echo '<option value="'.$i.'"';
		    if ($i==$instance['numbertweets']) echo ' selected="selected"';
		    echo '>'.$i.'</option>';
		 } ?>
		</select>
	</p><br />
	<?php }
}
register_widget('ThemeTwitter');
?>