<?php
/**
 * The template for displaying a single post
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php 
			// Get the post's featured image
			$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'blog-post-image');
			$src = $src[0];

			printf('
			<div class="blog-title-box" > 
				<div class="bloglevel1hover-reg"> 
					<div class="blog-article-left">
						<span class="blog-article-date"><time class="entry-date" datetime="%1$s" pubdate>%2$s</time></span>
					</div><!-- .blog-article-left -->
					<div class="blog-article-right">
						<h2 class="blog-article-title"> %3$s </h2> 				
					</div> <!-- .blog-article-right -->
				</div><!-- .bloglevel1hover-reg -->
			</div><!-- .blog-title-box -->
			<div class="blog-article-container"> 					
				<div class="blog-article-content"> 
					<div class="blog-article-left">
						<span class="author vcard blog-article-meta">by<a class="url fn n" href="%4$s" title="%5$s"> %6$s</a></span>
							<br />
							<span class="comments-link">%7$s</span>
					</div><!-- .blog-article-left -->',
			get_the_date( 'c' ),
			get_the_date( 'M j, Y'),
			get_the_title(),
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'demagician' ), get_the_author() ),
			get_the_author(),
			dm_postfooter_postcomments()	
			);
		?>
					<div class="blog-article-right border-bottom">
						<div class="responsive-meta">
							<time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>" pubdate><?php echo get_the_date( 'M j, Y'); ?></time> &nbsp;&nbsp;
							<span class="author vcard ">by<a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php sprintf( esc_attr__( 'View all posts by %s', 'demagician' ), get_the_author() ); ?>"> <?php echo get_the_author(); ?></a></span> &nbsp;&nbsp;
							<span class="rcomments-link"><?php echo dm_postfooter_postcomments(); ?> </span>
						</div><!-- .responsive-meta -->
                        <div class="single-article-content">
							<?php
                            if (isset($src)){
                            ?>
                                <img class="blog-article" src="<?php echo $src; ?>" alt="' . get_the_title() . '"/>
                                
                            <?php } ?>
                        
                            <?php
                                the_content(); 
                            ?>
						</div>			
					</div><!-- #blog-article-right -->
				</div> <!-- #blog-article-content -->
			</div>	<!-- #blog-article-container -->
		<div style="clear:both;"></div>
	</article><!-- #post-<?php the_ID(); ?> -->
	