<?php
/**
 * themeBuilder class
 */
class themeBuilder {
	
	// Title
	function title() {
		if (is_front_page()) {
			bloginfo('description');
			echo " &laquo; ";
		} else {
			wp_title('&laquo;', true, 'right');
		}
		bloginfo('name');
	}
	
	// Breadcrubs
	function breadcrumbs($post_id = NULL) {
		if(theme_get_option('general','display_breadcrumb')){
			breadcrumbs_plus(array(
				'prefix' => '',
				'suffix' => '',
				'title' => false,
				'home' => __('Home', 'breadcrumbs-plus'),
				'sep' => '»',
				'front_page' => false,
				'bold' => false,
				'show_blog' => false,
				'echo' => true
			));
		}
	}
	
	// Credits to : http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
	function pagination($pages = '', $range = 2) {
		 $showitems = ($range * 2) + 1;  
		 global $paged;
		 if(empty($paged)) $paged = 1;
		 if($pages == '') {
			 global $wp_query;
			 $pages = $wp_query->max_num_pages;
			 if(!$pages) { $pages = 1; }
		 }   
		 if(1 != $pages) {
			 echo '<div class="clear"></div>';
			 echo '<div class="page-navigation">';
			 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo '<div><a href="'.get_pagenum_link(1).'" class="button small white"><span>'. __('&laquo; First','mandrake_theme') .'</span></a></div>';
			 if($paged > 1 && $showitems < $pages) echo '<div><a href="'.get_pagenum_link($paged - 1).'" class="button small white"><span>&laquo;</span></a></div>';
			 for ($i=1; $i <= $pages; $i++) {
				 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					 echo ($paged == $i)? '<div><a class="button small active"><span>'.$i.'</span></a></div>':'<div><a href="'.get_pagenum_link($i).'" class="button small white" ><span>'.$i.'</span></a></div>';
				 }
			 }
			 if ($paged < $pages && $showitems < $pages) echo '<div><a href="'.get_pagenum_link($paged + 1).'" class="button small white"><span>&raquo;</span></a></div>';  
			 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo '<div><a href="'.get_pagenum_link($pages).'" class="button small white"><span>'. __('Last &raquo;','mandrake_theme') .'</span></a></div>';
			 echo "</div>\n";
		 }
	}
	
	// Introduce
	function introduce($post_id = NULL) {
		$type = get_post_meta($post_id, '_introduce_text_type', true);
		if ($type == 'disable') { return; }
		if (empty($type)) { $type = 'title'; }
		if ($type == 'title') { $title = get_the_title($post_id); }
		if ($type == 'custom') { $text = get_post_meta($post_id, '_custom_introduce_text', true); }
		if (is_404()) {
			$title = __('Page not Found', 'mandrake_theme');
			$text .= '<h5>';
			$text .= __('Our Apologies, but the page you requested could not be found.', 'mandrake_theme');
			$text .= '</h5>';
		}
		if (is_search()) {
			$title = __('Search','mandrake_theme');
			$text .= '<h5>';
			$text .= sprintf(__("Search Results for: %s",'mandrake_theme'),stripslashes(strip_tags( get_search_query())));
			$text .= '</h5>';
		}
		if (is_archive()){
			$title = __('Archives','mandrake_theme');
			$text .= '<h5>';
			if(is_category()){
				$text .= sprintf(__("Category Archive for: %s",'mandrake_theme'),single_cat_title('',false));
			}elseif(is_tag()){
				$text .= sprintf(__("Tag Archives for: %s",'mandrake_theme'),single_tag_title('',false));
			}elseif(is_day()){
				$text .= sprintf(__("Daily Archive for: %s",'mandrake_theme'),get_the_time('F jS, Y'));
			}elseif(is_month()){
				$text .= sprintf(__("Monthly Archive for: %s",'mandrake_theme'),get_the_time('F, Y'));
			}elseif(is_year()){
				$text .= sprintf(__("Yearly Archive for: %s",'mandrake_theme'),get_the_time('Y'));
			}elseif(is_author()){
				if(get_query_var('author_name')){
					$curauth = get_user_by('slug', get_query_var('author_name'));
				} else {
					$curauth = get_userdata(get_query_var('author'));
				}
				$text .= sprintf(__("Author Archive for: %s",'mandrake_theme'),$curauth->nickname);
			}elseif(isset($_GET['paged']) && !empty($_GET['paged'])) {
				$text .= __('Blog Archives','mandrake_theme');
			}elseif(is_tax()){
				$term .= get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				$text .= sprintf(__("Archives for: %s",'mandrake_theme'),$term->name);
			}
			$text .= '</h5>';
		}
		echo '<div id="features">';
		echo '<div class="inner">';
		echo '<div class="features-text">';	
		if (isset($title)) { echo '<h1>' . $title . '</h1>'; }
		if (isset($text)) { echo $text; }
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '<!-- / features -->';
	}
	
	// Portfolio
	function portfolio($layout, $count, $post_id = NULL) {
		$display_title = theme_get_option('portfolio','display_title');
		$display_content = theme_get_option('portfolio','display_content');
		$categories = get_the_terms($post_id, 'portfolio_category');
		if (!empty($categories)) {
			foreach ($categories as $category) {
				$category_name = $category->slug;
			}
		}
		echo '<li class="portfolio-item" data-id="'. $count .'" data-type="'. $category_name .'">';
		// One column
		if ($layout == 'portfolio_one_column') { ?>
                 <div class="two-third">
                    <div class="image-holder">
                        <div class="image-shadow">
                        	<?php $this->portfolio_image($layout, $post_id); ?>
                            <div class="shadow"><img src="<?php echo THEME_URI; ?>/images/image-shadow.png" alt="" /></div>
                        </div>
                    </div>
                </div>
                <div class="one-third last">
                    <?php if ($display_title): ?>
                    <h2><?php the_title(); ?></h2>
                    <?php endif; ?>
                    <?php if ($display_content): ?>
                    <?php the_content(); ?>
                    <?php endif; ?>
                </div>
            <?php
		}
		// Two column
		if ($layout == 'portfolio_two_column') { ?>
            <div class="image-holder">
                <div class="image-shadow">
                    <?php $this->portfolio_image($layout, $post_id); ?>
                    <div class="shadow"><img src="<?php echo THEME_URI; ?>/images/image-shadow.png" alt="" /></div>
                </div>
            </div>
            <?php if ($display_title): ?>
            <h2><?php the_title(); ?></h2>
            <?php endif; ?>
            <?php if ($display_content): ?>
            <?php the_content(); ?>
            <?php endif; ?>
        	<?php
		}
		// Three column
		if ($layout == 'portfolio_three_column') { ?>
            <div class="image-holder">
                <div class="image-shadow">
                    <?php $this->portfolio_image($layout, $post_id); ?>
                    <div class="shadow"><img src="<?php echo THEME_URI; ?>/images/image-shadow.png" alt="" /></div>
                </div>
            </div>
            <?php if ($display_title): ?>
            <h2><?php the_title(); ?></h2>
            <?php endif; ?>
            <?php if ($display_content): ?>
            <?php the_content(); ?>
            <?php endif; ?>
            <?php
		}
		// Four column
		if ($layout == 'portfolio_four_column') { ?>
            <div class="image-holder">
                <div class="image-shadow">
                    <?php $this->portfolio_image($layout, $post_id); ?>
                    <div class="shadow"><img src="<?php echo THEME_URI; ?>/images/image-shadow.png" alt="" /></div>
                </div>
            </div>
            <?php if ($display_title): ?>
            <h2><?php the_title(); ?></h2>
            <?php endif; ?>
            <?php if ($display_content): ?>
            <?php the_content(); ?>
            <?php endif; ?>
            <?php
		}
		echo '</li>';
		echo '<!-- / portfolio-item -->';
	}	
	
	// Portfolio images
	function portfolio_image($layout, $post_id = NULL) {
		$type = get_post_meta($post_id, '_type', true);
		$image_url = get_post_meta($post_id, '_image', true);
		$video_url = get_post_meta($post_id, '_video', true);
		$document_url = get_post_meta($post_id, '_document', true);
		if ($type == "image") {
			$large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'lightbox'); ?>
            <a href="<?php if ($image_url) { echo $image_url; } else { echo $large_image_url[0]; } ?>" class="lightbox" title="<?php the_title(); ?>" rel="<?php echo $type; ?>">
            <?php the_post_thumbnail($layout); ?>
            <span class="zoom-<?php echo $type; ?>"></span></a>
			<?php
		}
		if ($type == "video") { ?>
            <a href="<?php echo $video_url;  ?>" class="videobox" title="<?php the_title(); ?>" rel="<?php echo $type; ?>">
            <?php the_post_thumbnail($layout); ?>
            <span class="zoom-<?php echo $type; ?>"></span></a>
			<?php
		}
		if ($type == "document") { ?>
            <a href="<?php echo $document_url; ?>" title="<?php the_title(); ?>">
            <?php the_post_thumbnail($layout); ?>
            <span class="zoom-<?php echo $type; ?>"></span></a>
			<?php
		}
	}
	
	// Portfolio filter
	function portfolio_filter($post_id = NULL) {
		$display_filter = theme_get_option('portfolio','display_filter');
		if ($display_filter) { ?>
            	<div class="portfolio-filter">
                    <div class="filter-title"><h5><?php _e('Show:','mandrake_theme'); ?></h5></div>
                    <div class="filter-category">
                        <a href="#" class="button small active" data-value="all"><span><?php _e('All','mandrake_theme'); ?></span></a>			
						<?php
						$cat = get_post_meta($post_id, '_porfolio_cat', true);
						$category_id = get_term_by( 'slug', $cat,  'portfolio_category')->term_id;
						if (!isset($category_id)) { $category_id = 0; }
                        $categories = get_terms('portfolio_category', array('parent' => $category_id));
                        if (!empty($categories)) {
                        	foreach($categories as $category) {
								echo '<a href="#" class="button small white" data-value="'. $category->slug .'"><span>'. $category->name .'</span></a>';
							}
                        } ?>
                    </div>
                </div>
                <!-- / portfolio-filter -->
            <?php
		}
	}
	
	// Homepage porfolio slider
	function portfolio_slider() {
		if (! theme_get_option('homepage', 'display_slider')) { return; }
		?>
        <div id="portfolio-slider">
            <div class="portfolio-holder">
            	<div class="portfolio-panel">
				<?php
                $count = 0;
				$category_name = theme_get_option('homepage', 'portfolio_category');
                $loop = new WP_Query(array('post_type' => 'portfolio', 'portfolio_category' => $category_name, 'posts_per_page'=>'-1', 'order'=>'ASC'));
                while ($loop->have_posts()) : $loop->the_post();
            
                    $type = get_post_meta(get_the_ID(), '_type', true);
                    $image_url = get_post_meta(get_the_ID(), '_image', true);
                    $video_url = get_post_meta(get_the_ID(), '_video', true);
                    $document_url = get_post_meta(get_the_ID(), '_document', true);
                    
                    ?>
                    <div class="portfolio-item">
                        <div class="image-border">
                    <?php
                    
                    if ($type == "image") {
                        $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'lightbox'); ?>
                            <a href="<?php if ($image_url) { echo $image_url; } else { echo $large_image_url[0]; } ?>" class="lightbox" title="<?php the_title(); ?>" rel="<?php echo $type; ?>">
                            <?php the_post_thumbnail('portfolio_slider'); ?>
                            <span class="zoom-<?php echo $type; ?>"></span></a>
                        <?php
                    }
                    if ($type == "video") { ?>
                            <a href="<?php echo $video_url;  ?>" class="videobox" title="<?php the_title(); ?>" rel="<?php echo $type; ?>">
                            <?php the_post_thumbnail('portfolio_slider'); ?>
                            <span class="zoom-<?php echo $type; ?>"></span></a>
                        <?php
                    }
                    if ($type == "document") { ?>
                            <a href="<?php echo $document_url; ?>" title="<?php the_title(); ?>">
                            <?php the_post_thumbnail('portfolio_slider'); ?>
                            <span class="zoom-<?php echo $type; ?>"></span></a>
                        <?php
                    }
                    
                    ?>
                        </div>
                    </div>
                    <?php
                    $count++;
                endwhile;
                ?>
            </div>
            <a id="portfolio-prev"></a>
			<a id="portfolio-next"></a>
        	</div>
        </div>
        <!-- / portfolio-slider -->
        <?php
	}
	
	// Slideshow
	function slideshow($type) {
		if (! theme_get_option('homepage', 'display_slideshow')) {
			return;
		}
		switch($type){
			case 'nivo':
				$this->slideshow_nivo();
				break;
			case '3d':
				$this->slideshow_3d();
				break;
			case 'kwicks':
				$this->slideshow_kwicks();
				break;
			case 'anything':
				$this->slideshow_anything();
				break;
		}
	}
	
	// Slideshow images
	function slideshow_images(){
		$loop = new WP_Query(array('post_type' => 'slideshow', 'posts_per_page'=>'-1', 'orderby'=>'menu_order', 'order'=>'ASC'));
		$images = array();
		while ($loop->have_posts()) : $loop->the_post();
			$content = get_the_content();
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$link = get_post_meta(get_the_ID(), '_link', true);
			$image = get_the_post_thumbnail(get_the_ID(), 'slideshow');
			$src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'slideshow');
			$position = theme_get_option('slideshow', 'anything_position');
			$images[] = array(
				'title' => get_the_title(),
				'desc'  => $content,
				'image' => $image,
				'src' => $src[0],
				'link' => $link,
				'position' => $position
 			);
		endwhile;
		return $images;
	}
	
	// Slideshow Nivo
	function slideshow_nivo() {
		?>
		<div id="features">
			<div class="background">
				<div class="inner">
					<div class="slider">
                    	<div class="slideshow">
                            <div id="nivoSlider">
                            <?php
                            $images = $this->slideshow_images();
                            foreach($images as $image) {
                                if ($image['link'] != '') {
                                    echo "\n".'<a href="'. $image['link'] .'">'. $image['image'] .'</a>';
                                } else {
                                    echo "\n".$image['image'];
                                }
                            }
                            ?>
                            </div>
                            <!-- / nivoSlider -->
                        </div>
                        <!-- / slideshow -->
					</div>
					<!-- / slider -->
				</div>
			</div>
		</div>
		<!-- / features -->
        
        <script type="text/javascript">
		// Nivo Slider Settings
		jQuery(window).load(function() {
			jQuery('#nivoSlider').nivoSlider({
			<?php
				echo "effect:'". theme_get_option('slideshow', 'nivo_effect'). "',";
				echo "animSpeed:". theme_get_option('slideshow', 'nivo_speed'). ",";
				echo "pauseTime:". theme_get_option('slideshow', 'nivo_pause'). ",";
				if (theme_get_option('slideshow', 'nivo_buttons')) { echo "directionNav:true"; } else { echo "directionNav:false"; }
			?>
			});
		});
		jQuery(document).ready(function(){
			jQuery("#features .slideshow").show();
		});
		</script>
		<?php
	}
	
	// Slideshow 3D
	function slideshow_3d() {
		?>
		<div id="features">
			<div class="background">
				<div class="inner">
					<div class="piecemaker-slider">
                        <div id="piecemaker"></div>
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery('#piecemaker').flash({
									swf:"<?php echo THEME_URI ?>/piecemaker/piecemaker.swf",
									wmode:"transparent",
									height:460,
									width:940,
									hasVersion:10,
									menu:false,
									expressInstaller:"<?php echo THEME_URI ?>/piecemaker/expressInstall.swf",
									flashvars: {
										xmlSource:"<?php echo THEME_URI ?>/piecemaker/piecemaker.php",
										cssSource:"<?php echo THEME_URI ?>/piecemaker/piecemaker.css"
									}
								});
							});          
                        </script>
					</div>
					<!-- / piecemaker-slider -->
				</div>
			</div>
		</div>
		<!-- / features -->
		<?php
	}
	
	// Slideshow Kwicks
	function slideshow_kwicks() {
		?>
		<div id="features">
			<div class="background">
				<div class="inner">
					<div class="slider">
                    	<div class="slideshow">
                            <ul id="kwicks" class="horizontal">
                            <?php
                            $images = $this->slideshow_images();
                            foreach($images as $image) {
								$result = 940 / count($images);
								echo '<li style="width:'. $result .'px">';
                                if ($image['link'] != '') {
                                 	echo '<a href="'. $image['link'] .'">'. $image['image'] .'</a>';
                                    if ($image['desc'] != '') {
                                        echo '<div class="kwicks-caption">';
                                        echo $image['desc'];
                                        echo '</div>';
                                    }
                                } else {
                                    echo $image['image'];
                                    if ($image['desc'] != '') {
                                        echo '<div class="kwicks-caption">';
                                        echo $image['desc'];
                                        echo '</div>';
                                    }
                                }
								echo '<div class="kwicks-shadow"></div>';
								echo '</li>';
                            }
                            ?>
                            </ul>
                            <!-- / kwicks -->
                        </div>
                        <!-- / slideshow -->
					</div>
					<!-- / slider -->
				</div>
			</div>
		</div>
		<!-- / features -->
		
		<script type="text/javascript">
		// Accordion Slider Settings
		jQuery(document).ready(function() {
			jQuery('#kwicks').kwicks({
			<?php
				echo "easing:'". theme_get_option('slideshow', 'accordion_effect'). "',";
				echo "duration:". theme_get_option('slideshow', 'accordion_speed'). ",";
				echo "max:760";
			?>
			});
		});
		jQuery(document).ready(function(){
			jQuery("#features .slideshow").show();
		});
		</script>
		<?php
	}
	
	// Slideshow Anything
	function slideshow_anything() {
		?>
		<div id="features">
			<div class="background">
				<div class="inner">
					<div class="slider">
                    	<div class="slideshow">
                            <ul id="anything-slider">
                            <?php
                            $images = $this->slideshow_images();
                            foreach($images as $image) {
                                if ($image['link'] != '') {
                                    echo "\n".'<li>';
                                    echo "\n".'<a href="'. $image['link'] .'">'. $image['image'] .'</a>';
                                    if ($image['desc'] != '') {
                                        echo "\n".'<div class="caption-'. $image['position'] .'">';
                                        echo "\n".$image['desc'];
                                        echo "\n".'</div>';
                                    }
                                    echo "\n".'</li>';
                                } else {
                                    echo "\n".'<li>';
                                    echo "\n".$image['image'];
                                    if ($image['desc'] != '') {
                                        echo "\n".'<div class="caption-'. $image['position'] .'">';
                                        echo "\n".$image['desc'];
                                        echo "\n".'</div>';
                                    }
                                    echo "\n".'</li>';
                                }
                            }
                            ?>
                            </ul>
                            <!-- / anything-slider -->
                        </div>
                        <!-- / slideshow -->
					</div>
					<!-- / slider -->
				</div>
			</div>
		</div>
		<!-- / features -->
		
		<script type="text/javascript">
		// Anything Slider Settings
		jQuery(document).ready(function() {
			jQuery('#anything-slider').anythingSlider({
			<?php
				echo "easing:'". theme_get_option('slideshow', 'anything_effect'). "',";
				echo "animationTime:". theme_get_option('slideshow', 'anything_speed'). ",";
				echo "delay:". theme_get_option('slideshow', 'anything_pause'). ",";
				if (theme_get_option('slideshow', 'anything_autoplay')) { echo "autoPlay:true,"; } else { echo "autoPlay:false,"; }
				echo "hashTags:false,";
				echo "width:940,";
				echo "height:400";
			?>
			});
		});
		jQuery(document).ready(function(){
			jQuery("#features .slideshow").show();
		});
		</script>
		<?php		
	}
	
	// Homepage teaser
	function teaser() {
		if (! theme_get_option('homepage', 'display_teaser')) { return; }
		?>
		<div id="call-to-action">
			<div class="inner">
				<div class="action-text">
                <?php echo stripslashes(theme_get_option('homepage', 'teaser_text')); ?>
				</div>
				<div class="action-button">
                	<?php echo '<a href="'. theme_get_option('homepage', 'teaser_url') .'" class="button large active"><span style="width:120px;">'. theme_get_option('homepage', 'teaser_button') .'</span></a>'; ?>
				</div>
			</div>
		</div>
		<!-- / call-to-action -->
        <?php
	}
}

function theme_builder($function){
	global $_themeBuilder;
	$_themeBuilder = new themeBuilder;
	$args = array_slice(func_get_args(), 1);
	return call_user_func_array(array( &$_themeBuilder, $function ), $args );
}

?>