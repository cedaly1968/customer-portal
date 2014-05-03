<?php
/**
 * Template Name: Contact
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
		</div>
	</div><!-- #header -->
	
	<div id="content-blog" class="clearfix" role="main">
		<section id="primary">
			<div id="page-content">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>

					<div id="contact-form">	

                        <form id="contact" method="post" action="">
                            <fieldset>	
                            
                                <label for="name">Name<span class="required">*</span></label>
                                <input type="text" name="name" title="Enter your name" class="required">
 
                            	<label for="email">E-mail<span class="required">*</span></label>
                                <input type="email" name="email" title="Enter your e-mail address" class="required email">
                               
                                <label for="message">Message<span class="required">*</span></label>
                                <textarea name="message" title="Enter a message" class="required"></textarea>
                                <br />
                            	<input type="submit" name="submit" class="button" id="submit" value="Send Message" />
                                <input type="hidden" name="subject" value="<?php echo of_get_option('qua_contact_subject'); ?>" />
								<input type="hidden" name="toemail" value="<?php echo of_get_option('qua_contact_email'); ?>" />
                            </fieldset>
                        </form>
                    
                    </div><!-- /end #contact-form -->

				<?php endwhile; // end of the loop. ?>
			</div><!-- #page-content -->
			
		</section><!-- #primary -->	
		
		<?php get_sidebar('page'); ?>

<?php get_footer(); ?>