<?php 

//Make it a JavaScript file
header("Content-type: text/javascript");

if(file_exists('../../../../wp-load.php')) {

	include '../../../../wp-load.php';

}

else {

	include '../../../../../wp-load.php';

}



$animation_time = of_get_option('ml_animation_time','5.4');



if(of_get_option('ml_portfolio_layout') == 'left') {

	$portfolio_layout = 'right'; /*main area side*/

} else {

	$portfolio_layout = 'left'; /*main area side*/

}

$animation_effect = of_get_option('ml_animation_effect','easeOutBack');

?>


/*-------------------------------------------------*/
/*	Fade Hover
/*-------------------------------------------------*/
jQuery(document).ready(function() {

	//prevent to load the fade effect on IE8 (poor quality)
	//add the class "fade-hover" to any element you want to add the Fade effect
	if (!($.browser.msie  && parseInt($.browser.version) < 9)) {

		jQuery(".ml_fade-hover").hover(

			function() {
				jQuery(this).fadeTo(300, 0.5, 'easeInOutQuad');
			},

			function() {
				jQuery(this).fadeTo(400, 1, 'easeInOutQuad');
			}

		);

	}

});




/*-------------------------------------------------*/
/*	Menu Margin Top
/*-------------------------------------------------*/
jQuery(document).ready(function() {
	
	/*get the website logo image height*/
	<?php $ml_website_logo_size = getimagesize(of_get_option('ml_website_logo')); ?>

	/*store the height into a variable*/
	var logoHeight = '<?php echo $ml_website_logo_size[1]; ?>';

	/*get the website main menu height*/
	var menuHeight = 16;
	
	/*calc the margin top*/
	var menuMarginTop = parseInt((logoHeight - menuHeight) / 2) + 2; /*+2px for a better alignment*/
	
	/*apply the margin top*/
	jQuery('.sf-menu > li').css('margin-top',menuMarginTop);
	
});



/*-------------------------------------------------*/
/*	Welcome Screen Animation
/*-------------------------------------------------*/
jQuery(window).load(function() {
	
	animationTime = (<?php echo $animation_time; ?> * 1000) / 18;
	
	<?php
	
	/*get the welcome image and logo dimensions, via PHP*/
	
	$ml_welcome_image_size = getimagesize(of_get_option('ml_welcome_image'));
	
	$ml_welcome_image_width = $ml_welcome_image_size[0];
	
	$ml_welcome_image_height = $ml_welcome_image_size[1];
	
	$ml_website_logo_size = getimagesize(of_get_option('ml_website_logo'));
	
	$ml_website_logo_height = $ml_website_logo_size[1];
	
	?>
	
	/*store dimensions into JS variables*/
	var welcomeImageWidth = '<?php echo $ml_welcome_image_width ?>';
	
	var welcomeImageHeight = '<?php echo $ml_welcome_image_height ?>';
		
	var sidebarHeight = jQuery('#ml_sidebar').outerHeight();
	
	var alignWelcomeImageToSidebar = parseInt((Number(sidebarHeight) - Number(welcomeImageHeight)) / 2);
	
	var higherHeight = Math.max(welcomeImageHeight,sidebarHeight);
		
	var logoHeight = '<?php echo $ml_website_logo_height ?>';
	
	var windowWidth = jQuery(window).width();

	var windowHeight = jQuery(window).height();
	
	var welcomeImageHorizontalCenter = parseInt((windowWidth - welcomeImageWidth) / 2);
	
	var headerHeight = parseInt(jQuery('#ml_header').outerHeight());
	
	var headerMarginBottom = parseInt(jQuery('#ml_header').css('margin-bottom'));
	
	var filterHeight = parseInt(jQuery('.ml_portfolio-categories').outerHeight());
	
	var mainAreaVerticalAlign = Number(headerHeight) + Number(headerMarginBottom);
	
	var wrapperAlign = parseInt((jQuery(window).width() - 980) / 2);
		
	var mainAreaAlign = parseInt((640 - welcomeImageWidth) / 2);
	
	var alignToMainArea = Number(wrapperAlign) + Number(mainAreaAlign);
	
	/*if the welcome image is bigger than sidebar, align it to the main area*/
	if(welcomeImageHeight > sidebarHeight) {
		welcomeAligner = Number(mainAreaVerticalAlign) + 40; /*40px for thefilter height*/
	}
	/*if is smaller, align the welcome image to the center of the sidebar */
	else {
		welcomeAligner = Number(mainAreaVerticalAlign) + Number(alignWelcomeImageToSidebar);
	}
	
	if(jQuery('#ml_main_area').is('.ml_has_welcome_image')){
		
		/*hide the header, the sidebar and the footer*/
		jQuery('#ml_header, #ml_sidebar, #ml_footer, .ml_portfolio_blog').hide();
		
		/*remove the initial loading gif*/
		jQuery('.ml_initial_loader').fadeOut(

			600,
			'easeInOutQuad',
			function(){
				jQuery(this).remove();
			}

			);
		
		/*fit the main area height to higher height between welcome image and sidebar*/
		jQuery('#ml_main_area').css('height',higherHeight);		
		
		/*fadeOut welcome image and align to center*/
		jQuery('#ml_welcome_screen').delay(600).css({	'<?php echo $portfolio_layout; ?>':welcomeImageHorizontalCenter + 'px',
											'top':'-' + welcomeImageHeight + 'px',
											'display':'inline'});

		/*start the animation*/
		jQuery('#ml_welcome_screen').animate(
		
			{top: Number(welcomeAligner) + 'px'},
			animationTime * 7,
			'<?php echo $animation_effect ?>'
		
		).delay(animationTime * 3).animate(
		
			{<?php echo $portfolio_layout; ?>: alignToMainArea + 'px'},
			animationTime * 2,
			'easeInOutQuad',
			function(){

				jQuery('#ml_header, #ml_sidebar, #ml_footer, .ml_portfolio_blog').delay(animationTime).fadeIn(animationTime * 5,'easeInOutQuad');

			}
		
		);
	
	}	



/*-------------------------------------------------*/
/*	AJAX Portfolio
/*-------------------------------------------------*/

	if(jQuery('#ml_sidebar').is('.ml_ajax_portfolio_enabled')) {
		
		//start when the link is clicked //using live to use prev/next ajax loaded links too
		jQuery(".ml_link_to, .ml_portfolio_nav").live('click', function() {
			
			//get the link data-id value
			var postId = jQuery(this).attr('data-id');

			//add selected class to the thumbnail
			jQuery(".ml_portfolio_item.selected").removeClass("selected");
			jQuery("#post-" + postId).addClass("selected");
			
			//set the path to the AJAX Portfolio
			var ajaxPortfolio = '<?php echo get_template_directory_uri().'/includes/ajax-portfolio.php'; ?>';
			
			//Add AJAX Loading Gif
			jQuery('#ml_main_area').addClass('ml_loading');
			
			//if the browser is NOT < IE9
			if (!($.browser.msie  && parseInt($.browser.version) < 9)) {

				//FadeOut the welcome screen and the current portfolio item container
				jQuery('#ml_welcome_screen, .ml_portfolio_container').fadeTo(600, 0, 'easeInOutQuad', function(){
					
					//Reset height
					jQuery('#ml_main_area').animate(
						{height: higherHeight},
						600,
						'easeInOutQuad'
					);

					//request the portfolio item content via AJAX
					jQuery('#ml_main_area').load(ajaxPortfolio, {id: postId}, function(){
						
						//store the portfolio item containter height into a variable
						var portfolioContainerHeight = jQuery('.ml_portfolio_container').outerHeight();
						
						//fit the portfolio container height
						jQuery(this).animate(
							{height: portfolioContainerHeight},
							900,
							'easeOutQuad',
							function(){

								//Remove AJAX Loading Gif
								jQuery('#ml_main_area').removeClass('ml_loading');

								//FadeIn the current portfolio item container
								jQuery('#ml_main_area, .ml_portfolio_container').fadeTo(600, 1, 'easeInOutQuad');
							}
						);
					
					});
				
				})
			
			}

			//if the browser IS < IE9
			else {

				//FadeOut the main area
				jQuery('#ml_main_area').fadeTo(600, 0, 'easeInOutQuad', function(){
	
					//request the portfolio item content via AJAX
					jQuery(this).load(ajaxPortfolio, {id: postId}, function(){
						
						//set the main area height to 'auto', with a little CSS Hack ;)
						jQuery('#ml_main_area').addClass('auto_height');

						//show the new content
						jQuery('#ml_main_area').fadeTo(600, 1,'easeInOutQuad')
					
						//Remove AJAX Loading Gif
						jQuery('#ml_main_area').removeClass('ml_loading');

					});
				
				})

			
			}

			return false;

		});

	}
	
	/*-------------------------------------------------*/
	/*	Portfolio Filter
	/*-------------------------------------------------*/

	jQuery(".ml_portfolio-categories a").click(function() {

		jQuery(".ml_portfolio-categories .selected").removeClass("selected");
		jQuery(this).parent().addClass("selected");
		
		//get the link value
		var preFilterVal = jQuery(this).text();
		//set the path to the AJAX sanitizer
		var sanitizeUrl = '<?php echo get_template_directory_uri().'/includes/sanitize.php'; ?>';
		
		//get the sanitized link via AJAX and start the magic
		jQuery.get(sanitizeUrl, {slug: preFilterVal}, function (data) {

			var filterVal = data;
			//no conflict
			var filterVal = 'skill_' + filterVal;
			
			//when click All, show all :P
			if(filterVal == "skill_<?php echo sanitize_title(__('All', 'meydjer')) ?>") {
				jQuery('#ml_portfolio').isotope({ filter: '*' });
			} 
			
			//show portfolio items by skill
			else {
				jQuery('#ml_portfolio').isotope({ filter: '.' + filterVal });
			}

		});

		return false;
	});


});



/*-------------------------------------------------*/
/*	Portfolio Items Thumbnails effects
/*-------------------------------------------------*/
jQuery(document).ready(function() {
	jQuery('.ml_portfolio_item').hover(
	
		function(){
		
			jQuery(this).find('.ml_portfolio_item_title div span').animate(
			
				{right: '5px'},
				300,
				'easeOutQuad'
			
			)
		
		},
	
		function(){
			
			jQuery(this).find('.ml_portfolio_item_title div span').animate(
			
				{right: '95px'},
				300,
				'easeInQuad',
				function(){

					jQuery(this).css('right','-85px');

				}
			
			)
		
		}
	
	);
});



/*-------------------------------------------------*/
/*	Likes
/*-------------------------------------------------*/

	
/*--- create a cookie for each portfolio item ---*/
/*--- if the item was already liked, add 'ml_already_liked' class ---*/
jQuery(document).ready(function() {

<?php
query_posts( 'post_type=ml_portfolio&posts_per_page=-1');

if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


	
	if(!jQuery.cookie('ml_likes_<?php echo $post->ID ?>')) {

		jQuery.cookie('ml_likes_<?php echo $post->ID ?>','no',{expires:3650, path: '/' });

	}

	if(jQuery.cookie('ml_likes_<?php echo $post->ID; ?>') == 'yes') {

		jQuery('.ml_portfolio_item-<?php echo $post->ID; ?>').addClass('ml_already_liked');
		
	}



<?php endwhile; endif;

wp_reset_query(); ?>

});



jQuery(document).ready(function() {

	jQuery('.ml_like_heart span').live('click',function(){
	
		var postId = jQuery(this).parent().attr('data-id');
		
		var likeScript = '<?php echo get_template_directory_uri().'/includes/like.php'; ?>';
		
		//request the portfolio item content via AJAX
		jQuery(this).parent().load(likeScript, {id: postId}, function(){
		
			clicks = 0;

			alreadyLiked = jQuery.cookie('ml_likes_' + postId);
			
			if(alreadyLiked == 'yes') {

				jQuery(this).removeClass('ml_already_liked');
				
				jQuery.cookie('ml_likes_' + postId,'no',{expires:3650, path: '/' });

			} else {

				jQuery(this).addClass('ml_already_liked');
				
				jQuery.cookie('ml_likes_' + postId,'yes',{expires:3650, path: '/' });

			}
			
		});
			
		jQuery(this).parent().html('...');
		
	});

});



/*-------------------------------------------------*/
/*	Custom Javascripts
/*-------------------------------------------------*/
<?php echo of_get_option('ml_custom_js'); ?>