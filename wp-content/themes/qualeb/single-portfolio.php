<?php
/**
 *
 * Template Name: Portfolio Single
 *
 * This template is used to display all portfolio Items.
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */

get_header(); ?>
			<div id="crumbs">
				<?php 
				// Get the Portfolio Index Page ID from the specified page in the Options Panel
				$indexId = of_get_option('qua_portfolio_index'); 
			
				if ($indexId){
					$indexTitle = get_post_meta($indexId, 'dm_he_title', true);
						//If there is one, make it the title
						if ($indexTitle){
							$theindexTitle = $indexTitle;
						}
						//If the field is empty, use the portfolio index page title
						else{
							$theindexTitle = get_the_title($indexId).'.';
						}
					$indexLink = get_page_link($indexId);
				}
				else{
					$theindexTitle = 'Portfolio';
					$indexLink = '';
				}
				?>
				<a href="<?php echo $indexLink; ?>"><?php echo $theindexTitle; ?></a> / &nbsp;<span class="current"><?php the_title(); ?></span>
			</div>
		</div><!-- #header-content -->
	</div><!-- #header -->
	<div id="content-portfolio" class="clearfix" role="main">
		<section id="primary">
			<div id="portfolio-content">
				<?php 
					setup_postdata($post);
					the_content(); 
				?>
			</div><!-- #blog-index -->
		</section><!-- #primary -->	
		<div id="secondary" class="portfolio-single-sidebar" role="complementary">
			<?php 
					// Getting values for Next & Previous Nav
					$nextpo=get_next_post(); 
					$nextpoid = '';
					if ($nextpo) {$nextpoid=$nextpo->ID;}
					$next_post_url = get_permalink($nextpoid); 
					$nstyle = '';
					$pstyle = '';
					if ($nextpoid == ''){ 
						$next_post_url = '#';
						$nstyle = 'display:none;';
					}
					$prevpo=get_previous_post(); 
					$prevpoid = '';
					if ($prevpo) {$prevpoid=$prevpo->ID;}
					$prev_post_url = get_permalink($prevpoid);
					if ($prevpoid == ''){ 
						$prev_post_url = '#';
						$pstyle = 'display:none;';
					}
				?>
			<div id="psingle-nav">
				<a href="<?php echo esc_attr($prev_post_url); ?>" class="prevp" style="<?php echo $pstyle; ?>">&nbsp;&nbsp;Previous Project</a>
				<span style="<?php echo $nstyle; echo $pstyle; ?>">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
				<a href="<?php echo esc_attr($next_post_url); ?>" class="nextp" style="<?php echo $nstyle; ?>">Next Project&nbsp;&nbsp;</a>
			</div><!-- #psingle-nav -->	
			
			<div id="psingle-sidebar-content">
				<h1 class="psingle-sidebar"><?php the_title(); ?></h1>
                <br />  <br />
				<?php the_excerpt(); 
				
				$launchLink = get_post_meta($post->ID, 'dm_po_link', true);
						if ($launchLink){
						?>
						<br />
						<a href="<?php echo $launchLink; ?>" class="more-link" target="_blank"><?php echo get_post_meta($post->ID, 'dm_po_phrase', true); ?> &rarr;</a>
				
						<?php
							}	
						?>
				<div id="item-social-interact">
					<?php
						$dmTweet = get_post_meta($post->ID, 'dm_po_tweet', true);
						if ($dmTweet != true){
					?>
					<div class="twitter-share">
						<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="demagician">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
					</div>
					<?php } 
						$dmLike = get_post_meta($post->ID, 'dm_po_like', true);
						if ($dmLike != true){
					?>
					<div class="facebook-like">
						<div id="fb-root"></div>
						<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) {return;}
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
						<div class="fb-like" data-href="" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="verdana"></div>
					</div>
					<?php } ?>
				</div><!-- #item-social-interact -->	
			</div><!-- #psingle-sidebar-content -->	
		</div><!-- #secondary -->

<?php get_footer(); ?>