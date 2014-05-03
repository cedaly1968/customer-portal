<?php
	if(!function_exists('wp_head')) {
		
		if(file_exists('../../../../wp-load.php')) {
			include '../../../../wp-load.php';
		} else {
			include '../../../../../wp-load.php';
		}
			
	}

query_posts( 'post_type=ml_portfolio&posts_per_page=-1'); ?>


<script type="text/javascript">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	
			if(!jQuery.cookie('ml_likes_<?php echo $post->ID ?>')) {
				jQuery.cookie('ml_likes_<?php echo $post->ID ?>','no',{expires:3650});
			}
	

<?php endwhile; endif; ?>

</script>



<?php wp_reset_query(); ?>