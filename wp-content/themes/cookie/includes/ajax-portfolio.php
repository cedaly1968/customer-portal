<?php

if(!function_exists('wp_head')) {
	
	if(file_exists('../../../../wp-load.php')) {
		include '../../../../wp-load.php';
	}
	
	else {
		include '../../../../../wp-load.php';
	}

	$post_id = $_POST['id'];

	query_posts( array (
		'post_type' => 'ml_portfolio',
		'p' => $post_id,
		)
	);		
}



if (have_posts()) : while (have_posts()) : the_post();

//get the images
global $wpdb, $post;

$meta = get_post_meta(get_the_ID(), 'ml_portfolio_images', false);

$images_array = array();

$timthumb = get_template_directory_uri() . '/includes/timthumb.php?src=';

if (!is_array($meta)) $meta = (array) $meta;

if (!empty($meta)) {

    $meta = implode(',', $meta);

    $images = $wpdb->get_col("
        SELECT ID FROM $wpdb->posts
        WHERE post_type = 'attachment'
        AND ID in ($meta)
        ORDER BY menu_order ASC
    ");

    foreach ($images as $att) {

        // get image's source based on size, can be 'thumbnail', 'medium', 'large', 'full' or registed post thumbnails sizes
        $src = wp_get_attachment_image_src($att, 'full');
        $images_array[] = $src[0];

    }
}

$embedded_html = get_post_meta($post->ID, 'ml_portfolio_embedded_html', true);

if(get_adjacent_post(false,'',false)) {
	$nav_prev = get_adjacent_post(false,'',false);
	$nav_prev_id = $nav_prev->ID;
	$nav_prev_title = $nav_prev->post_title;
	$nav_prev_link = '<a href="#" data-id="'.$nav_prev_id.'" class="ml_portfolio_nav">&larr; '.$nav_prev_title.'</a>';
} else {
	$nav_prev_link = '';
}

if(get_adjacent_post(false,'',true)) {
	$nav_next = get_adjacent_post(false,'',true);
	$nav_next_id = $nav_next->ID;
	$nav_next_title = $nav_next->post_title;
	$nav_next_link = '<a href="#" data-id="'.$nav_next_id.'" class="ml_portfolio_nav">'.$nav_next_title.' &rarr;</a>';
} else {
	$nav_next_link = '';
}
?>



<style type="text/css" media="screen">

.ml_slides_container {
width:640px;
}

.ml_slides_container div {
width:640px;
display:block;
}

</style>


	
	<article id="portfolio_item-<?php echo $post_id ?>" class="ml_portfolio_container">
		
		<div class="nav-prev"><?php echo $nav_prev_link ?></div>
		<div class="nav-next"><?php echo $nav_next_link ?></div>
		
		
		
		<div class="clearfix"></div>
		
		
		
		<?php
		
		/*if have HTML content, use it*/
		if($embedded_html) { 
		
			echo $embedded_html;
			echo '<br />';
			echo '<br />';
		
		}
		
		/*if note, use images*/
		else { ?>
		
			<div class="ml_slides">
	
				<div class="ml_slides_container <?php echo $post_id ?>">
				
					<?php foreach ($images_array as $image) {
	
						$images_height = get_post_meta($post->ID, 'ml_portfolio_images_height', true);
	
						if(!$images_height) {
							$images_height = '360';
						}
	
						$slide_image = $timthumb . $image . '&w=640&h='.$images_height.'&q=100';
		
						?>
				
					    <div>
					    
					    	<a href="<?php echo $image ?>" data-rel="prettyPhoto[portfolio-<?php echo $post_id ?>]">
					
								<img src="<?php echo $slide_image ?>" width="640" height="<?php echo $images_height ?>" />
							
							</a>
					
					    </div>
					
					<?php
					} ?>
				
				</div><!-- end div.slides_container -->
				
				<?php
				
				/*only show thumbs list if there is more than one image*/	
				if(count($images_array) > 1) {
				
				?>

					<ul class="ml_pagination">
					
					  	<?php foreach ($images_array as $image) { ?>
					
						    <li>
						    
						    	<a href="#">
						    	
									<img src="<?php echo $timthumb . $image . '&w=50&h=50&q=100' ?>" width="50" height="50" />
					
						    	</a>	
					
						    </li>
					
					    <?php } ?>
					
					</ul>

				<?php }
				
				else {
				
					echo '<br />';
				
				}/*end count condition*/ ?>
	
			</div>
	
	
			
			<script>
			jQuery(document).ready(function() {
				
				jQuery(".ml_slides").slides({
					
					autoHeight: true,
					container: 'ml_slides_container',
					crossfade: true,
					effect: 'slide',
					generatePagination: false,
					paginationClass: 'ml_pagination',
					slideSpeed: 600,
					slideEasing: 'easeInOutBack'
					
				});
	
			});
			
			jQuery(document).ready(function() {
	
				jQuery('.slides_control').css('height','<?php $first_image_height ?>px');
				
			});
			
			/*-------------------------------------------------*/
			/*	prettyPhoto
			/*-------------------------------------------------*/
			jQuery(document).ready(function(){
				jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
					slideshow:5000,
					autoplay_slideshow:false
				});	
			});

			</script>
		<?php } /*end images*/ ?>
				
		<h2 class="ml_portfolio_title"><?php the_title(); ?></h2>
		
		<?php the_content() ?>
		
		<br /><br /><br /><br />

		<div class="nav-prev"><?php echo $nav_prev_link ?></div>
		<div class="nav-next"><?php echo $nav_next_link ?></div>		

	</article>

<?php endwhile; endif; wp_reset_query(); ?>