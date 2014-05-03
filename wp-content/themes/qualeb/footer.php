<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the main div and all content that comes after
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
?>

	</div><!-- #main -->
	<?php 
	$display_fwidgets = of_get_option('qua_fwidgets');
	
	// Displaying footer widgets, if option is checked
	if( $display_fwidgets == 'yes') { ?>
		<div id="upper-footer">
			<div id="footer-widget-wrap">
			<?php
					dynamic_sidebar( 'sidebar-footer1' );
				?>
				
			</div><!-- #footer-widget-wrap -->
		</div><!-- #upper-footer -->
	<?php } else {} ?>
	
	<div id="footer" role="contentinfo">		
		<div id="social-links">
				<?php 
				$social_links = of_get_option('slinks_show', 'none' );
				
				if ($social_links[one] == 1){
				?>
				<a href="<?php echo of_get_option('slink1_link', '#'); ?>" id="slink1" data-color="<?php echo of_get_option('slink1_color'); ?>"><div class="social-link"> <?php echo of_get_option('slink1_name'); ?><div class="social-color"></div></div></a>
				<?php
				};
				
				if ($social_links[two] == 1){
				?>
				<a href="<?php echo of_get_option('slink2_link', '#'); ?>" id="slink2" data-color="<?php echo of_get_option('slink2_color'); ?>"><div class="social-link"> <?php echo of_get_option('slink2_name'); ?><div class="social-color"></div></div></a>
				<?php
				};
				
				if ($social_links[three] == 1){
				?>
				<a href="<?php echo of_get_option('slink3_link', '#'); ?>" id="slink3" data-color="<?php echo of_get_option('slink3_color'); ?>"><div class="social-link"> <?php echo of_get_option('slink3_name'); ?><div class="social-color"></div></div></a>
				<?php
				};
				
				if ($social_links[four] == 1){
				?>
				<a href="<?php echo of_get_option('slink4_link', '#'); ?>" id="slink4" data-color="<?php echo of_get_option('slink4_color'); ?>"><div class="social-link"> <?php echo of_get_option('slink4_name'); ?><div class="social-color"></div></div></a>
				<?php
				};
				
				if ($social_links[five] == 1){
				?>
				<a href="<?php echo of_get_option('slink5_link', '#'); ?>" id="slink5" data-color="<?php echo of_get_option('slink5_color'); ?>"><div class="social-link"> <?php echo of_get_option('slink5_name'); ?><div class="social-color"></div></div></a>
				<?php
				};
				
				if ($social_links[six] == 1){
				?>
				<a href="<?php echo of_get_option('slink6_link', '#'); ?>" id="slink6" data-color="<?php echo of_get_option('slink6_color'); ?>"><div class="social-link"> <?php echo of_get_option('slink6_name'); ?><div class="social-color"></div></div></a>
				<?php
				};
				
				if ($social_links[seven] == 1){
				?>
				<a href="<?php echo of_get_option('slink7_link', '#'); ?>" id="slink7" data-color="<?php echo of_get_option('slink7_color'); ?>"><div class="social-link"> <?php echo of_get_option('slink7_name'); ?><div class="social-color"></div></div></a>
				<?php
				};
				
				if ($social_links[eight] == 1){
				?>
				<a href="<?php echo of_get_option('slink8_link', '#'); ?>" id="slink8" data-color="<?php echo of_get_option('slink8_color'); ?>"><div class="social-link"> <?php echo of_get_option('slink8_name', 'no name'); ?><div class="social-color"></div></div></a>
				<?php
				};
				?>
			</div>
			
			<p class="copyright">
				<?php echo of_get_option('qua_copyright', 'no entry' ); ?>
			</p>
		<a href="<?php echo get_bloginfo('url') ?>">
			<?php if ( of_get_option('qua_footer_logo') ) { ?>
			<img class="footerlogo" src="<?php echo of_get_option('qua_footer_logo'); ?>" />
			<?php } ?>
		</a>
	</div><!-- #footer -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/library/cufon/cabin.font.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/library/cufon/Qlassik_Bold_700.font.js"></script>

<script type="text/javascript">
//<![CDATA[
jQuery(window).load(function() {
	jQuery('#slider').flexslider({
		animation: "<?php echo of_get_option('qua_slider_animation', 'fade'); ?>",    
		slideshow:  <?php echo of_get_option('qua_slider_slideshow', 'true'); ?>,
		slideshowSpeed:  <?php echo of_get_option('qua_slider_speed', '5000'); ?>,
		animationDuration: <?php echo of_get_option('qua_slider_duration', '600'); ?>,
		directionNav: <?php echo of_get_option('qua_slider_direction', 'true'); ?>,
		controlNav: <?php echo of_get_option('qua_slider_control', 'true'); ?>,
		keyboardNav: true,
		touchSwipe: true,
		pausePlay: false,
		randomize: false,
		animationLoop: true,
		pauseOnAction: true,
		pauseOnHover: true
	});
	jQuery('.flex-direction-nav li a').hide();
});
//]]>
</script>

<script type="text/javascript">
//<![CDATA[
jQuery(window).load(function() {
	jQuery('#portfolioslider').flexslider({
		animation: "slide",    
		slideshow:  false,
		slideshowSpeed:  5000,
		animationDuration: 600,
		directionNav: true,
		controlNav: false,
		keyboardNav: true,
		touchSwipe: true,
		pausePlay: false,
		randomize: false,
		animationLoop: true,
		pauseOnAction: true,
		pauseOnHover: true
	});
	jQuery('.flex-direction-nav li a').hide();
	jQuery('.flex-control-nav').hide();
	
});
//]]>
</script>
<script>
 //<![CDATA[
jQuery(function(){
	jQuery('#contact').validate({
	submitHandler: function(form) {
		jQuery(form).ajaxSubmit({
		url: '<?php bloginfo( 'template_directory' ); ?>/library/tools/process.php',
		success: function() {
		jQuery('#contact').hide();
		jQuery('#contact-form').append("<p class='thanks'><?php echo of_get_option('qua_contact_success', 'Thanks! Your request has been sent.'); ?></p>")
		}
		});
		}
	});         
});
//]]>
</script>
</body>
</html>