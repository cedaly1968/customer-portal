<?php 

$footer_col = of_get_option('ml_footer_columns');
if($footer_col == '1') {
	$footer_class = 'ml_one_full';
}
if($footer_col == '2') {
	$footer_class = 'ml_one_half';
}
if($footer_col == '3') {
	$footer_class = 'ml_one_third';
}
if($footer_col == '4') {
	$footer_class = 'ml_one_fourth';
}

?>		

		
		
		<div class="clearfix"></div>
		
		
		
		<footer id="ml_footer">
		
			<?php /* if(!(is_page_template('template-portfolio.php'))) { */ ?>
				
				<?php if($footer_col != '1') { ?>
	
					<div class="ml_centering">
	
				<?php } ?>
	
	
		
				<?php /*--- Footer One Column ---*/ 
				if($footer_col >= '1') { ?>
	
					<section class="<?php echo $footer_class; ?> ml_footer_one ml_footer_column">
	
						<ul>
	
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Footer - One', 'meydjer')) ) ?>
	
						</ul>
	
					</section>
	
				<?php } ?>
	
	
		
				<?php /*--- Footer Two Columns ---*/
				if($footer_col >= '2') { ?>
	
				<section class="<?php echo $footer_class; ?> ml_footer_two ml_footer_column">
	
					<ul>
	
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Footer - Two', 'meydjer')) ) ?>
	
					</ul>
	
				</section>
	
				<?php } ?>
	
	
		
				<?php /*--- Footer Three Columns ---*/
				if($footer_col >= '3') { ?>
	
				<section class="<?php echo $footer_class; ?> ml_footer_three ml_footer_column">
	
					<ul>
	
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Footer - Three', 'meydjer')) ) ?>
	
					</ul>
	
				</section>
	
				<?php } ?>
	
	
				
				<?php /*--- Footer Four Columns ---*/
				if($footer_col == '4') { ?>
	
				<section class="<?php echo $footer_class; ?> ml_footer_four ml_footer_column">
	
					<ul>
	
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Footer - Four', 'meydjer')) ) ?>
	
					</ul>
	
				</section>
	
				<?php } ?>
	
	
		
				<?php if($footer_col != '1') { ?>
	
					</div><!-- END div.centering -->
	
				<?php } ?>

			<?php /* } */ ?>



			<div class="clearfix"></div>



			<div class="ml_copyright">

				<p><?php echo of_get_option('ml_footer_copy') ?></p>

			</div>

			<div class="ml_social">

				<p><?php echo of_get_option('ml_footer_social') ?></p>

			</div>

		</footer>

		<?php wp_footer(); ?>

	</div><!-- end div#ml_wrapper -->

</body>

</html>