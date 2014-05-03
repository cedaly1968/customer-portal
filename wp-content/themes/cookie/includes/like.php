<?php
	if(!function_exists('wp_head')) {
		
		if(file_exists('../../../../wp-load.php')) {
			include '../../../../wp-load.php';
		} else {
			include '../../../../../wp-load.php';
		}
			
	}


/*the post id*/
$post_id = $_POST['id'];

/*to know if the user already liked it - via cookie*/
$ml_already_liked = $_COOKIE['ml_likes_'.$post_id];

/*current number of likes*/
$ml_likes = get_post_meta($post_id, '_ml_likes');

/*add one more like*/
$ml_likes_plus_one = $ml_likes[0] + 1;

/*get off one like*/
$ml_likes_minus_one = $ml_likes[0] - 1;



if($ml_already_liked == 'no') {

	/*save*/
	update_post_meta($post_id, '_ml_likes', $ml_likes_plus_one, $ml_likes[0]);

	/*display the new number*/
	$ml_likes_updated = get_post_meta($post_id, '_ml_likes');

} else {

	/*save*/
	update_post_meta($post_id, '_ml_likes', $ml_likes_minus_one, $ml_likes[0]);

	/*display the new number*/
	$ml_likes_updated = get_post_meta($post_id, '_ml_likes');

}







echo '<span>'.$ml_likes_updated[0].'</span>';

?>