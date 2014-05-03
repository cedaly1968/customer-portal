    <?php if (theme_get_option('footer','display_twitter')) : ?>
    <div id="twitter-bar">
		<script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery("#twitter").tweet({
                username: "<?php echo theme_get_option('footer','twitter_username'); ?>",
                count: <?php echo theme_get_option('footer','twitter_count'); ?>,
                join_text: "auto",
                loading_text: "<?php _e('Loading tweets...','mandrake_theme');?>",
                seconds_ago_text: '<?php _e('about %d seconds ago','mandrake_theme');?>',
                a_minutes_ago_text: '<?php _e('about a minute ago','mandrake_theme');?>',
                minutes_ago_text: '<?php _e('about %d minutes ago','mandrake_theme');?>',
                a_hours_ago_text: '<?php _e('about an hour ago','mandrake_theme');?>',
                hours_ago_text: '<?php _e('about %d hours ago','mandrake_theme');?>',
                a_day_ago_text: '<?php _e('about a day ago','mandrake_theme');?>',
                days_ago_text: '<?php _e('about %d days ago','mandrake_theme');?>',
                auto_join_text_default: '<?php _e('i said,','mandrake_theme');?>',
                auto_join_text_ed: '<?php _e('i','mandrake_theme');?>',
                auto_join_text_ing: '<?php _e('i am','mandrake_theme');?>',
                auto_join_text_reply: '<?php _e('i replied to','mandrake_theme');?>',
                auto_join_text_url: '<?php _e('i was looking at','mandrake_theme');?>'
            }).bind("loaded",function(){
				jQuery('#twitter .tweet_list').carouFredSel({
					auto: {
						pauseOnHover: true,
						play: true,
						pauseDuration: 4000,
						fx: "fade"
					}
				});
			});
        });
        </script>
        <div class="inner">
            <div class="twitter-icon"></div>
            <div id="twitter"></div>
        </div>
    </div>
    <!-- / twitter-bar -->
    <?php endif; ?>
    
    <?php if (theme_get_option('footer','display_footer')) : ?>
    <div id="footer">
        <div class="background">
            <div class="inner">
			<?php
        	$footer_layout = theme_get_option('footer','footer_layout');
            switch ($footer_layout ) {
            case 2:
                ?>
                <div class="one-half"><?php dynamic_sidebar('first-footer-widget-area'); ?></div>
                <div class="one-half last"><?php dynamic_sidebar('second-footer-widget-area'); ?></div>
                <?php
                break;
            case 3:
                ?>
                <div class="one-third"><?php dynamic_sidebar('first-footer-widget-area'); ?></div>
                <div class="one-third"><?php dynamic_sidebar('second-footer-widget-area'); ?></div>
                <div class="one-third last"><?php dynamic_sidebar('third-footer-widget-area'); ?></div>
                <?php
                break;
            case 4:
                ?>
                <div class="one-fourth"><?php dynamic_sidebar('first-footer-widget-area'); ?></div>
                <div class="one-fourth"><?php dynamic_sidebar('second-footer-widget-area'); ?></div>
                <div class="one-fourth"><?php dynamic_sidebar('third-footer-widget-area'); ?></div>
                <div class="one-fourth last"><?php dynamic_sidebar('fourth-footer-widget-area'); ?></div>
                <?php
                break;
            case 5:
                ?>
                <div class="one-fifth"><?php dynamic_sidebar('first-footer-widget-area'); ?></div>
                <div class="one-fifth"><?php dynamic_sidebar('second-footer-widget-area'); ?></div>
                <div class="one-fifth"><?php dynamic_sidebar('third-footer-widget-area'); ?></div>
                <div class="one-fifth"><?php dynamic_sidebar('fourth-footer-widget-area'); ?></div>
                <div class="one-fifth last"><?php dynamic_sidebar('fifth-footer-widget-area'); ?></div>
                <?php
                break;
            case 6:
                ?>
                <div class="one-sixth"><?php dynamic_sidebar('first-footer-widget-area'); ?></div>
                <div class="one-sixth"><?php dynamic_sidebar('second-footer-widget-area'); ?></div>
                <div class="one-sixth"><?php dynamic_sidebar('third-footer-widget-area'); ?></div>
                <div class="one-sixth"><?php dynamic_sidebar('fourth-footer-widget-area'); ?></div>
                <div class="one-sixth"><?php dynamic_sidebar('fifth-footer-widget-area'); ?></div>
                <div class="one-sixth last"><?php dynamic_sidebar('sixth-footer-widget-area'); ?></div>
                <?php
                break;
            }	
        	?>
            </div>
        </div>
    </div>
    <!-- / footer -->
    <?php endif; ?>
    
    <?php if (theme_get_option('footer','display_sub_footer')) : ?>
    <div id="copyrights">
        <div class="inner">
            <div class="copy-text"><?php echo stripslashes(theme_get_option('footer','footer_copyright')); ?></div>
            <div class="copy-menu">
            	<?php wp_nav_menu(array('theme_location' => 'footer-menu', 'container' => 'false', 'menu_class' => 'footer-menu', 'depth' => '1')); ?>
            </div>
        </div>
    </div>
    <!-- / copyrights --> 
    <?php endif; ?>
</div>
<!-- / mandrake-web --> 

<?php wp_footer(); ?>
<?php if (theme_get_option('general','theme_analytics')) : echo stripslashes(theme_get_option('general','theme_analytics')); endif; ?>

<!-- <script src="https://getfirebug.com/firebug-lite-beta.js" type="text/javascript" charset="utf-8"></script> -->
</body>
</html>