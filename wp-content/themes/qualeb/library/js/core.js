/*-------------------------------------------------------------------------------------*/
/*		1.		Navigation Drops
/*-------------------------------------------------------------------------------------*/

$(function(){
	$('.menu ul').superfish();
});


$(document).ready(function(){
						   
/* Load Fade In */
$('#page').fadeIn(50);

/*-------------------------------------------------------------------------------------*/
/*		2.	Cufon font replacement
/*-------------------------------------------------------------------------------------*/

	Cufon.replace('#crumbs, h1.psingle-sidebar, h2.home-sidebar-title, h1.page-title, span.header-desc, span.header-title-light, h1, h2:not(.blog-article-title, .blog-article-title-reg #home-slogan, .portfolio-entry-title), h3:not(.widget-title), h4, h5 , h6',{fontFamily : "Cabin"} );
	Cufon.replace('h2#home-slogan, h2.title, h2#page-title',{fontFamily : "Qlassik Bold"} );
	Cufon.now();
	$("h2#home-slogan, h1.page-title, span.header-desc, span.header-title-light, #crumbs a, #crumbs span.current, h1.psingle-sidebar").css("display", "inline");
	

/*-------------------------------------------------------------------------------------*/
/*		2.	Hover animations
/*-------------------------------------------------------------------------------------*/


	// Hover for the Slider
	$(".flexslider").hoverIntent({
		over: sliderOn, 
		timeout: 0, 
		sensitivity: 800,
		out: sliderOut
	});
	
	// Hover for the Main Menu Navigation Links
	$("div.menu ul a").hoverIntent({
		over: navIn, 
		timeout: 0, 
		sensitivity: 800,
		out: navOut
	});
	$("div.menu ul li.current_page_item a").hoverIntent({
		over: navIn, 
		timeout: 0, 
		sensitivity: 1000,
		out: navIn
	});

	// Hover for the Portfolio Index Items
	$("a.portfolio-item-link").hoverIntent({
		over: makeitFadein, 
		timeout: 20, 
		interval: 0,  
		sensitivity: 1000,
		out: makeitFadeout
		});
	

	// Hover for Blog Index Image
	$("a.blog-entry-img").hoverIntent({
		over: blogImgFadein, 
		timeout: 20, 
		interval: 0,  
		sensitivity: 10,
		out: blogImgFadeout
		});
		
	
	// This prevents the hover to happen, while quicksand is doing its thing
	$("#pindex-nav a").click(function() {
		$('span.portfolio-hover').remove();
		
	});
	
	var mainColor = $("#page").attr("data-color");
	
	function navIn(){ $(this).animate({color:mainColor}, 400);}
	function navOut(){ $(this).animate({color:'#999'}, 400);}
	function makeitFadein(){ $(this).children('div.portfolio-hover, div.home-portfolio-hover').fadeIn(100, 'easeInOutCubic'); }
	function makeitFadeout(){ $(this).children('div.portfolio-hover, div.home-portfolio-hover').fadeOut(100, 'easeInOutCubic' );}
	function blogImgFadein(){ $(this).children('span.blog-img-hover').fadeIn(200, 'easeInOutCubic'); }
	function blogImgFadeout(){ $(this).children('span.blog-img-hover').fadeOut(200, 'easeInOutCubic' );}
	function sliderOn(){ $('.flex-direction-nav li a ').fadeIn(200);}
	function sliderOut(){ $('.flex-direction-nav li a ').fadeOut(200);}


/*-------------------------------------------------------------------------------------*/
/*		3.	Portfolio Filter Nav
/*-------------------------------------------------------------------------------------*/

	var cache_list =$('ul.portfolio-list').clone();
	
	$('#pindex-nav a.all').addClass('current');
	$('#pindex-nav a').click(function(e) {
		$('#pindex-nav a').removeClass('current');
		$(this).addClass('current');
		$dataValue = $(this).attr('data-value');
		if ($dataValue != 'all'){
			$dataValue = '.'+$dataValue;
		}
		else {
			$dataValue = '';
		}
		$('.portfolio-list').quicksand( cache_list.find('li'+$dataValue), {
		  duration: 500
		});
		e.preventDefault();
	});

/*-------------------------------------------------------------------------------------*/
/*		4.	Blog Accordion
/*-------------------------------------------------------------------------------------*/

$('.blog-article-container').hide(); 
$('.blog-title-box:first').addClass('active').next().show();
$('h2.blog-article-title:first').addClass('clic');
$('.blog-title-box').click(function(){
	//Fix for Slide-down 
	$('.blog-article-container').each(function(){
	$(this).css('height', $(this).height());
});
	$('h2.blog-article-title').removeClass('clic');
	hasNext = $(this).next();
	if( $(this).next().is(':hidden') ) {
		$('.blog-title-box').removeClass('active').next().slideUp(700, ''); 
		$(this).toggleClass('active').next().slideDown(700, ''); 
		$(this).children().children().children("h2.blog-article-title").addClass('clic');
	}
	var new_position = $(this).prev().offset();
	window.scrollTo(new_position.left,new_position.top);
	return false; 
});

$("h2.blog-article-title").hover(
	function () {
		$(this).addClass("hover", 300);
	},
	function () {
		$(this).removeClass("hover", 300);
	}
);
$(".bloglevel1hover").click(
function () {
		$(".bloglevel1hover").removeClass("clic");
		$(this).addClass("clic");
	}
);


/*-------------------------------------------------------------------------------------*/
/*		5.	Tabs Activiation (From Skeleton)
/*-------------------------------------------------------------------------------------*/

	var tabs = $('ul.tabs');

	tabs.each(function(i) {
		//Get all tabs
		var tab = $(this).find('> li > a');
		tab.click(function(e) {

			//Get Location of tab's content
			var contentLocation = $(this).attr('href');

			//Let go if not a hashed one
			if(contentLocation.charAt(0)=="#") {

				e.preventDefault();

				//Make Tab Active
				tab.removeClass('active');
				$(this).addClass('active');

				//Show Tab Content & add active class
				$(contentLocation).show().addClass('active').siblings().hide().removeClass('active');

			}
		});
	});
	
	
/*-------------------------------------------------------------------------------------*/
/*		5.	Social Media
/*-------------------------------------------------------------------------------------*/

$("#social-links a").hover(
	function () {
		borderColor = $(this).attr("data-color");
		linkId = $(this).attr("id");
		$('#social-links a#' + linkId + ' div.social-link div.social-color').css("border-color", borderColor).animate({width:100},100);
		
	},
	function () {
		linkId = $(this).attr("id");
		$('#social-links a#' + linkId + ' div.social-link div.social-color').animate({width:0},100);
	}
)
});

/*-------------------------------------------------------------------------------------*/
/*		7.	Twitter Init
/*-------------------------------------------------------------------------------------*/

jQuery(function($){
	// Get the number of tweets to display from the data attribute (data-count)
	var tweetCount = $("#tweet").attr("data-count");
	// Get the username from the data attribute (data-user)
	var tweetUser = $("#tweet").attr("data-user");
	
	$(".tweet").tweet({
		username: tweetUser,
		join_text: "auto",
		avatar_size: 32,
		count: tweetCount,
		auto_join_text_default: "we said,", 
		auto_join_text_ed: "we",
		auto_join_text_ing: "we were",
		auto_join_text_reply: "we replied to",
		auto_join_text_url: "we were checking out",
		loading_text: "loading tweets..."
	});
});


