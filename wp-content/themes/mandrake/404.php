<?php get_header() ?>
	<?php theme_builder('introduce'); ?>
    <div class="container sidebar-left">
        <div class="inner">
        	<div class="content">
            	<div class="text-404">
            	<?php echo stripslashes(theme_get_option('general','theme_404')); ?>
                </div>
            </div>
            <!-- / content -->
            <div id="sidebar">
            	<div class="sidebar-content">
                    <div class="error-404">
                    	<img src="<?php echo bloginfo('template_url'); ?>/images/404.png" alt="404" />
                    </div>
                </div>
            </div>
            <!-- / sidebar -->
            <div class="clear"></div>
        </div>
    </div>
    <!-- / container -->
<?php get_footer() ?>