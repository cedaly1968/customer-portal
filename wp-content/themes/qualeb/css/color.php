<?php 
require_once( '../../../../wp-load.php' );
Header("content-type: text/css");
$color = of_get_option('qua_color', '#3FBFFF');if (of_get_option('qua_skin') == 'dark'){	$slogan = $color; $hover = $color;}else{	$slogan = ''; $hover = '';}
echo <<<CSS

h2#home-slogan{	color: $slogan;}
#page{ border-color: $slogan; }

.more-link,
a,
div.menu ul li.current-cat a,
div.menu ul li.current_page_item a,
div.menu ul li.current-menu-item a,
#filter-nav a.current,
#filter-nav a:hover,
span.comments-link a,
#blog-accordion a.more-link,
#blogreg-index a.more-link,
div.nav-previous a, div.nav-next a,
aside.widget a:hover, #upper-footer a:hover,
#searchform input#searchsubmit:hover,
div.comment-author span.fn a:hover, a.comments-date:hover, a.comment-reply-link:hover{
	color:$color;  
}
.Popular_Widget ul li a:hover{ color:$hover;}
.color, a.color{ color:$color !important;  }

input#submit,
#contact-form #submit-button,
a.sbutton {
	background: $color;
}

CSS;
?>