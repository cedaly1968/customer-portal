<?php 
//Make it a CSS file
header("Content-type: text/css");
if(file_exists('../../../../wp-load.php')) {
	include '../../../../wp-load.php';
}
else {
	include '../../../../../wp-load.php';
}


?>



/*-------------------------------------------------*/
/*	Portfolio
/*-------------------------------------------------*/	
#ml_header,
#ml_welcome_screen,
#ml_sidebar,
#ml_footer,
.ml_portfolio_blog {
	display: none;
}

.ml_initial_loader {
	left: 50%;
	position: absolute;
	top: 66%;
}



/*-------------------------------------------------*/
/*	Sidebar
/*-------------------------------------------------*/
	
<?php if(of_get_option('ml_portfolio_layout') == 'left') { ?>
	
	#ml_main_area {
		float:right;
	}
	
	#ml_sidebar {
		float:left;
	}
	.ml_portfolio_item_title div {
		background: transparent url(<?php echo get_template_directory_uri() ?>/images/portfolio_item_arrow_right.png) no-repeat right bottom;
	}
	.ml_portfolio_item_title {
		text-align: left;
	}

<?php } else { ?>
	
	#ml_main_area {
		float:left;
	}
	
	#ml_sidebar {
		float:right;
	}
	.ml_portfolio_item_title div {
		background: transparent url(<?php echo get_template_directory_uri() ?>/images/portfolio_item_arrow_left.png) no-repeat left bottom;
	}
	.ml_portfolio_item_title {
		text-align: right;
	}

<?php } ?>