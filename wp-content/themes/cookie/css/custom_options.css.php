<?php 
session_start();


//Make it a CSS file
header("Content-type: text/css");
if(file_exists('../../../../wp-load.php')) {
	include '../../../../wp-load.php';
}
else {
	include '../../../../../wp-load.php';
}

$main_color = of_get_option('ml_main_color','#f23b8d');

$font_family = of_get_option('ml_google_font_css_key','Oswald');

$text_transform = of_get_option('ml_google_font_text_transform','uppercase');

$apply_google_font_to = of_get_option('ml_apply_google_font_to','h1, h2, h3, h4, .sf-menu a, .nav-prev, .nav-next, .ml_portfolio-categories, .ml_comment-author, .ml_comment-reply, button, .ml_button, .wpcf7-submit, .input[type=submit]');



$header_background = of_get_option('ml_header_background',get_template_directory_uri().'/images/light/pattern-header.jpg');

$body_background = of_get_option('ml_body_background',get_template_directory_uri().'/images/light/pattern-body.jpg');

$body_typo = '';
if(of_get_option('ml_body_typo')) {
	$body_typo = of_get_option('ml_body_typo');
}

$header_typo = '';
if(of_get_option('ml_header_typo')) {
	$header_typo = of_get_option('ml_header_typo');
}

$header_active = of_get_option('ml_header_active','#f166ac');



function custom_typography($typo) {

	if($typo == 'georgia') 		{ return 'Georgia, serif'; }
	if($typo == 'helvetica') 	{ return '"Helvetica Neue", Helvetica, Arial, Clean, sans-serif'; }
	if($typo == 'palatino') 	{ return '"Palatino Linotype", "Book Antiqua", Palatino, serif'; }
	if($typo == 'tahoma') 		{ return 'Tahoma, Geneva, sans-serif'; }
	if($typo == 'times') 		{ return '"Times New Roman", Times, serif'; }
	if($typo == 'trebuchet') 	{ return '"Trebuchet MS", sans-serif'; }
	if($typo == 'verdana') 		{ return 'Verdana, Geneva, sans-serif'; }

}



?>



/*-------------------------------------------------*/
/*	Colors
/*-------------------------------------------------*/

blockquote {
	border-color: <?php echo $main_color; ?>;
}

#ml_top_border {	
	background-color: <?php echo $main_color; ?>;
}

a,
button,
.button,
a:hover,
a:active,
a:visited,
blockquote,
button:hover,
button:active,
.wpcf7-submit,
.button:hover,
.button:active,
.nav-next a:hover,
.nav-prev a:hover,
.input[type=submit],
.wpcf7-submit:hover,
.wpcf7-submit:active,
.ml_post-info a:hover,
.ml_post-tags a:hover,
.input[type=submit]:hover,
.input[type=submit]:active,
.ml_post_index .ml_post-title:hover,
.ml_portfolio-categories > ul > li:hover > a,
.ml_portfolio-categories > ul > li.selected > a {
	color: <?php echo $main_color; ?>;
}

/*--- Replace some settings... ---*/
.nav-prev a,
.nav-next a {
  	color: #3f4547;
}



<?php if(of_get_option('ml_header_align') == 'right') { ?>
/*-------------------------------------------------*/
/*	Header Logo Align
/*-------------------------------------------------*/
.ml_header_main_logo {
	float: right;
}
.sf-menu {
	float: left;
}
<?php } ?>



<?php if(of_get_option('ml_sidebar') == 'left') { ?>

/*-------------------------------------------------*/
/*	Sidebar
/*-------------------------------------------------*/

#ml_main_area {
	float:right;
}

#ml_sidebar {
	float:left;
}

<?php } ?>



<?php if(!of_get_option('ml_show_like_hearts')) { ?>

/*-------------------------------------------------*/
/*	Hide Like Heards
/*-------------------------------------------------*/
.ml_portfolio_item {
	margin: 0 10px 10px 0;
}

<?php } ?>



<?php if($header_background) { ?>

/*-------------------------------------------------*/
/*	Header Background
/*-------------------------------------------------*/
#ml_header,
.sf-menu ul {
	background-color: <?php echo $header_background['color'] ?>;
	background-image: url(<?php echo $header_background['image'] ?>);
	background-repeat: <?php echo $header_background['repeat'] ?>;
	background-position: <?php echo $header_background['position'] ?>;
	background-attachment: <?php echo $header_background['attachment'] ?>;
}

<?php } ?>



<?php if($body_background) { ?>
/*-------------------------------------------------*/
/*	Body Background
/*-------------------------------------------------*/
body {
	background-color: <?php echo $body_background['color'] ?>;
	background-image: url(<?php echo $body_background['image'] ?>);
	background-repeat: <?php echo $body_background['repeat'] ?>;
	background-position: <?php echo $body_background['position'] ?>;
	background-attachment: <?php echo $body_background['attachment'] ?>;
}

<?php } ?>



/*-------------------------------------------------*/
/*	Typography
/*-------------------------------------------------*/

<?php if($body_typo){ ?>
/*--- Body Typography ---*/
body {
	font: <?php echo $body_typo['style'] ?> <?php echo $body_typo['size'] ?> <?php echo custom_typography($body_typo['face']) ?>;
	color: <?php echo $body_typo['color'] ?>;
}
<?php } ?>

<?php if($header_typo){ ?>
/*--- Header Typography ---*/
.sf-menu a {
	font: <?php echo $header_typo['style'] ?> <?php echo $header_typo['size'] ?> <?php echo custom_typography($header_typo['face']) ?>;
	color: <?php echo $header_typo['color'] ?>;
}
.sf-menu > li {
	border-color: <?php echo $header_typo['color'] ?>;
}

<?php } ?>

<?php if($header_active){ ?>
.sf-menu > li > a:hover,
.sf-menu ul li > a:hover,
.sf-menu > li.sfHover > a,
.sf-menu ul li.sfHover > a,
.sf-menu > li.current-menu-item > a,
.sf-menu > li.current-menu-parent > a,
.sf-menu > li.current_page_parent > a,
.sf-menu > li.current-menu-ancestor > a {
	color:<?php echo $header_active ?>;
}
<?php } ?>

/*--- Google Webfonts ---*/
<?php echo $apply_google_font_to ?> {
	font-family: '<?php echo $font_family ?>', sans-serif;
	font-weight: normal;
	text-transform: <?php echo $text_transform ?>;
}



<?php if(of_get_option('ml_disable_white_shadows')) { ?>
/*-------------------------------------------------*/
/*	Disable White Shadows
/*-------------------------------------------------*/

.input-text,
.wpcf7-text,
input[type=text],
textarea {
	box-shadow: inset 0px 1px 2px rgba(0,0,0,.1);
		-moz-box-shadow: inset 0px 1px 2px rgba(0,0,0,.1);
		-webkit-box-shadow: inset 0px 1px 2px rgba(0,0,0,.1);
}

.input-text:focus,
.wpcf7-text:focus,
input[type=text]:focus,
textarea:focus {
	box-shadow: inset 0px 1px 2px rgba(0,0,0,.2);
		-moz-box-shadow: inset 0px 1px 2px rgba(0,0,0,.2);
		-webkit-box-shadow: inset 0px 1px 2px rgba(0,0,0,.2);
}

button,
.button,
.wpcf7-submit,
.input[type=submit] {
	box-shadow: inset 0px 1px 0px #fff;
		-moz-box-shadow: inset 0px 1px 0px #fff;
		-webkit-box-shadow: inset 0px 1px 0px #fff;
}

button:active,
.button:active,
.wpcf7-submit:active,
.input[type=submit]:active {
	box-shadow: inset 0 0 4px rgba(0,0,0,.15), inset 0 0 17px rgba(0,0,0,.02);
		-moz-box-shadow: inset 0 0 4px rgba(0,0,0,.15), inset 0 0 17px rgba(0,0,0,.02);
		-webkit-box-shadow: inset 0 0 4px rgba(0,0,0,.15), inset 0 0 17px rgba(0,0,0,.02);
}
<?php } ?>



/*-------------------------------------------------*/
/*	Custom CSS
/*-------------------------------------------------*/
<?php echo of_get_option('ml_custom_css'); ?>
<?php print_r(of_get_option('ml_header_typography')) ?>