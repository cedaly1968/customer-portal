<?php
/**
 *
 * Template Name: Portfolio Index
 *
 * This template is used to display all portfolio Items.
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */

get_header(); ?>

			<div id="header-description">
					<h1 class="page-title">
						<?php
						$page_title = get_post_meta($post->ID, 'dm_he_title', true);
						if ($page_title){
							echo $page_title;
						}
						else{
							echo get_the_title().'.';
						}
						?>
					</h1>
					<span class="header-desc"><?php echo get_post_meta($post->ID, 'dm_he_desc', true); ?></span>
			</div><!-- #header-description -->
		</div><!-- #header-content -->
	</div><!-- #header -->

	<div id="content-portfolio" class="clearfix" role="main">
		<div id="pindex-nav">
			<div id="filter-nav">
				<a href="#" data-value="all" class="all">All</a>
				<?php 
					//Show all the portfolio categories in the nav, except the excluded one
					$exclude_cat = get_post_meta($post->ID, 'dm_exclude_cat', true);
					$terms = get_terms('portfolio_category', 'hide_empty=1'); 
					foreach($terms as $term) {
						if ($term->slug != $exclude_cat){
							?>
							<a href="#" data-value="<?php echo  $term->slug; ?>"><?php echo  $term->name; ?></a>
							<?php 
						}
					}
				?>
			</div><!-- #filter-nav -->
		</div><!-- #pindex-nav -->
		<div id="portfolio-items">
			<ul class="portfolio-list">
				<?php
					// Get order value from metabox
					$order = get_post_meta($post->ID, 'dm_order', true); 
					
					// Get orderby value from metabox
					$orderby = get_post_meta($post->ID, 'dm_orderby', true);
					
					$wp_query = new WP_Query();
					$wp_query->query( array( 'post_type' => 'portfolio','order' => $order, 'orderby' => $orderby, 'posts_per_page' => 9999, 'post_status' => 'publish') );

					$itemId = 1;
					$count = 1;
					
					while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
						
						//Get the featured image of the portfolio item
						$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'portfolio-index');
						$src = $src[0];
						/* 
						Create the classes for each item, depending on which categories they are in,
						Classes are used by the filter nav, to filter the items. 
						*/
						$post_terms = wp_get_post_terms($post->ID,'portfolio_category', 'hide_empty=1');
						$term_class = '';
						foreach($post_terms as $post_term) {
							$term_class .= $post_term->slug . ' ';
						}
						
						//Add _last to the class, for each fourth item
						if ($count % 4 == 0){
							$last = '_last';
						}
						else{
							$last = '';
						}
						?>
						<li data-id='id<?php echo $itemId; ?>' class="pindex_item<?php echo $last; ?> <?php echo $term_class; $term_class = '';?>" id="post-<?php the_ID(); ?>">
							<div class="portfolio-entry">
                            <?php $perm = get_permalink(); ?>
								<a href="<?php echo esc_attr($perm);  ?>" class="portfolio-item-link" id="portfolioItem-<?php the_ID(); ?>">
									<img class="item" src="<?php echo $src; ?>" />
									<div class="portfolio-hover"><!-- Appears on hover -->
										<h2 class="portfolio-entry-title"><?php  echo substr(get_the_title(), 0,26); ?></h2>
										<?php echo item_text(40);?>
										<img src="<?php bloginfo('template_url');?>/css/images/portfolio-hover-arr.png" />
									</div><!-- .portfolio-hover -->
								</a><!-- a.portfolio-item-link -->
							</div><!-- .portfolio-entry -->
						</li>
						<?php
						$count++;
						$itemId++;
					endwhile;
				?>
			</ul><!-- .portfolio-list -->
		</div><!-- #portfolio-items-->
<?php get_footer(); ?>