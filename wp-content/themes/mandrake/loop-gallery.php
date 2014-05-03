<?php
/**
 * The template for displaying gallery images
 */
?>
<?php if (have_posts()) while (have_posts()) : the_post(); ?>
<?php 
$args = array(
	'order' => 'ASC',
	'post_type' => 'attachment',
	'post_parent' => $post->ID,
	'post_mime_type' => 'image',
	'post_status' => null,
	'numberposts' => -1,
);
$attachments = get_posts($args);
if ($attachments) {
	foreach ($attachments as $attachment) {
		$image_url = wp_get_attachment_image_src($attachment->ID, 'lightbox');
		?>
        <li class="gallery-item">
        <div class="image-holder">
            <div class="image-shadow">
                <a href="<?php echo $image_url[0]; ?>" class="lightbox" title="<?php echo $attachment->post_title; ?>" rel="gallery">
				<?php echo wp_get_attachment_image($attachment->ID, 'gallery'); ?><span class="zoom-image"></span></a>
                <div class="shadow"><img src="<?php echo THEME_URI; ?>/images/image-shadow.png" alt="" /></div>
            </div>
        </div>
        </li>
		<?php
	}
}
?>
<?php endwhile; ?>