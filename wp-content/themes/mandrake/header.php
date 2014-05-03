<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php theme_builder('title'); ?></title>

<?php if($theme_favicon = theme_get_option('general','theme_favicon')) { ?>
<!-- Icon -->
<link rel="shortcut icon" href="<?php echo $theme_favicon; ?>" type="image/x-icon" />
<?php } ?>

<!-- Stylesheets -->
<link href="<?php echo bloginfo('template_url'); ?>/styles/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo bloginfo('template_url'); ?>/styles/nivo-slider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo bloginfo('template_url'); ?>/styles/kwicks-slider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo bloginfo('template_url'); ?>/styles/anythingslider.css" rel="stylesheet" type="text/css" />
<link href="<?php echo bloginfo('template_url'); ?>/styles/colorbox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo bloginfo('template_url'); ?>/styles/<?php echo theme_get_option('general','theme_color'); ?>.css" rel="stylesheet" type="text/css" class="theme-color" />

<!-- Feeds and Pingback -->
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php
$font = theme_get_option('general','theme_font');
?>
<link href='http://fonts.googleapis.com/css?family=<?php echo $font; ?>' rel='stylesheet' type='text/css' class="theme-font" />
<style type="text/css">
h1, h2, h3, h4, h5, h6, .dropcap1, .dropcap2, .site-name, .main-menu a, .button, .tabbed-menu a, .accordion-tab a, .expand-tab a, .toggle-title, #cboxTitle {font-family:'<?php echo str_replace("+", " ", $font); ?>';}
</style>

<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div id="mandrake-web">
    <div id="header">
        <div class="inner">
        	<?php if ($theme_logo = theme_get_option('general','theme_logo')) : ?>
            <div id="logo">
                <a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo $theme_logo; ?>" alt="<?php bloginfo('name'); ?>" /></a>
            </div>
            <!-- / logo -->
            <?php else : ?>
            <div id="logo-text">
            	<a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" class="site-name"><?php bloginfo('name'); ?></a>
                <span class="site-description"><?php bloginfo('description'); ?></span>
            </div>
            <!-- / logo-text -->
            <?php endif; ?>
            <div id="navigation">          	
                <?php wp_nav_menu(array('theme_location' => 'main-menu', 'container' => 'false', 'menu_class' => 'main-menu', 'link_before' => '<span>', 'link_after' => '</span>', 'depth' => '3')); ?>
            </div>
            <!-- / navigation --> 
        </div>
    </div>
    <!-- / header -->