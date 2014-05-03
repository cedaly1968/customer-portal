<?php
/**
 * The template for displaying search forms
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'demagician' ); ?>" />
	<input type="submit" class="submit" name="submit" id="searchsubmit" value="&raquo;" />
</form>