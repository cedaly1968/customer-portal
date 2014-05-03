<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */

get_header(); ?>
		<div id="header-description">
					<div id="pheader-content">
						<h1 class="page-title">
							<?php _e( 'Error 404', 'demagician' ) ?>
						</h1>
						<span class="header-desc">- &nbsp;&nbsp;<?php _e( 'NOT FOUND', 'demagician' ) ?></span>
					</div><!-- #pheader-content -->
				</div><!-- #header-description -->
			</div><!-- #header-content -->
		</div><!-- #header -->

		<div id="content-blog" class="clearfix" role="main">
			<section id="primary">
				<div id="page-content">
					<center><?php _e( 'The Page you are looking for cannot be found', 'demagician' ) ?>.</center>
				</div><!-- #page-content -->
			</section>	<!-- #primary -->
			<?php get_sidebar('blog'); ?>
	<?php get_footer(); ?>