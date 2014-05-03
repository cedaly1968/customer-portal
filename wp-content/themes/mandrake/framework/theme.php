<?php
/* Load theme class */
class Theme {
	
	function Theme() {
		$this->constants();
		$this->options();
		$this->classes();
		$this->functions();
		$this->types();
		$this->plugins();
		$this->tinymce();
		$this->shortcodes();
		$this->metaboxes();
		add_action('widgets_init',array(&$this, 'widgets'));
		add_action('after_setup_theme', array(&$this, 'support'));
		add_action('admin_init', array(&$this,'admin_head'));
		add_action('admin_menu', array(&$this,'option_menus'));
		add_action('init',array(&$this, 'language'));	
	}
	
	/* Define theme constants */
	function constants() {
		define('THEME_NAME', 'Mandrake');
		define('THEME_DIR', get_template_directory());
		define('THEME_URI', get_template_directory_uri());
		define('THEME_IMAGES', THEME_URI . '/images');
		define('THEME_CSS', THEME_URI . '/styles');
		define('THEME_JS', THEME_URI . '/js');
		define('THEME_INCLUDES', THEME_URI . '/framework/includes');
		define('THEME_ASSETS', THEME_URI . '/framework/assets');
		define('THEME_FRAMEWORK', THEME_DIR . '/framework');
		define('THEME_CLASSES', THEME_FRAMEWORK . '/classes');
		define('THEME_FUNCTIONS', THEME_FRAMEWORK . '/functions');
		define('THEME_METABOXES', THEME_FRAMEWORK . '/metaboxes');
		define('THEME_OPTIONS', THEME_FRAMEWORK . '/options');
		define('THEME_PLUGINS', THEME_FRAMEWORK . '/plugins');
		define('THEME_SHORTCODES', THEME_FRAMEWORK . '/shortcodes');
		define('THEME_TINYMCE', THEME_FRAMEWORK . '/tinymce');
		define('THEME_TYPES', THEME_FRAMEWORK . '/types');
		define('THEME_WIDGETS', THEME_FRAMEWORK . '/widgets');
	}
	
	/* Load theme options */
	function options() {
		$files = array('option_general','option_slideshow','option_home','option_blog','option_portfolio','option_sidebar','option_footer');
		foreach($files as $file){
			$page = include(THEME_OPTIONS .'/'. $file .'.php');
			$options[$page['name']] = array();
			foreach($page['options'] as $option) {
				if (isset($option['default'])) {
					$options[$option['id']] = $option['default'];
				}
			}
			add_option(THEME_NAME .'_'. $page['name'], $options);
		}
	}
	
	/* Load theme classes */
	function classes() {
		require_once (THEME_CLASSES . '/themeBuilder.php');
		require_once (THEME_CLASSES . '/sidebarBuilder.php');
		require_once (THEME_CLASSES . '/metaboxBuilder.php');
		include_once (THEME_CLASSES . '/optionBuilder.php');
	}

	
	/* Load theme functions */
	function functions() {
		require_once (THEME_FUNCTIONS . '/common.php');
		require_once (THEME_FUNCTIONS . '/header.php');
		require_once (THEME_FUNCTIONS . '/filter.php');
	}
	
	/* Load custom post types */
	function types() {
		require_once (THEME_TYPES . '/portfolio.php');
		require_once (THEME_TYPES . '/slideshow.php');
	}
	
	/* Load theme plugins */
	function plugins() {
		require_once (THEME_PLUGINS . '/breadcrumbs-plus/breadcrumbs-plus.php');
	}
	/* Load TinyMCE plugin */
	function tinymce() {
		require_once(THEME_TINYMCE .'/tinymce.php');
	}
	
	/* Load theme shortcodes */
	function shortcodes() {
		require_once(THEME_SHORTCODES . '/boxes.php');
		require_once(THEME_SHORTCODES . '/buttons.php');
		require_once(THEME_SHORTCODES . '/columns.php');
		require_once(THEME_SHORTCODES . '/dividers.php');
		require_once(THEME_SHORTCODES . '/images.php');
		require_once(THEME_SHORTCODES . '/tables.php');
		require_once(THEME_SHORTCODES . '/tabs.php');
		require_once(THEME_SHORTCODES . '/typography.php');
		require_once(THEME_SHORTCODES . '/video.php');
		require_once(THEME_SHORTCODES . '/widgets.php');
	}
	
	/* Load theme metaboxes */
	function metaboxes(){
		require_once(THEME_METABOXES . '/header.php');
		require_once(THEME_METABOXES . '/blog_cat.php');
		require_once(THEME_METABOXES . '/portfolio_cat.php');
		require_once(THEME_METABOXES . '/sidebar.php');
		require_once(THEME_METABOXES . '/portfolio.php');
		require_once(THEME_METABOXES . '/slideshow.php');
	}
	
	/* Load theme widgets */
	function widgets() {
		require_once (THEME_WIDGETS . '/advertisement.php');
		require_once (THEME_WIDGETS . '/contactform.php');
		require_once (THEME_WIDGETS . '/contactinfo.php');
		require_once (THEME_WIDGETS . '/flickr.php');
		require_once (THEME_WIDGETS . '/popular.php');
		require_once (THEME_WIDGETS . '/recent.php');
		require_once (THEME_WIDGETS . '/related.php');
		require_once (THEME_WIDGETS . '/social.php');
		require_once (THEME_WIDGETS . '/testimonials.php');
		require_once (THEME_WIDGETS . '/twitter.php');
		register_widget('Widget_Advertisement');
		register_widget('Widget_Contact_Form');
		register_widget('Widget_Contact_Info');
		register_widget('Widget_Flickr');
		register_widget('Widget_Popular_Posts');
		register_widget('Widget_Recent_Posts');
		register_widget('Widget_Related_Posts');
		register_widget('Widget_Social');
		register_widget('Widget_Testimonials');
		register_widget('Widget_Twitter');
	}
	
	/* Load theme support */
	function support() {
		if (function_exists('add_theme_support')) {
			add_image_size('blog_large', 620, 260, true);
    		add_image_size('blog_small', 220, 260, true);
			add_image_size('portfolio_one_column', 620, 350, true);
			add_image_size('portfolio_two_column', 460, 260, true);
			add_image_size('portfolio_three_column', 300, 170, true);
			add_image_size('portfolio_four_column', 220, 125, true);
			add_image_size('slideshow', 940, 400, true);
			add_image_size('portfolio_slider', 130, 70, true);
			add_image_size('lightbox', 800, 600, false);
			add_image_size('gallery', 220, 125, true);
			add_theme_support('post-thumbnails', array('post', 'page', 'portfolio', 'slideshow'));
			add_theme_support('automatic-feed-links');
			add_theme_support('editor-style');
			add_theme_support('menus');
			register_nav_menus(array(
				'main-menu' => __(THEME_NAME . ' Main menu', 'mandrake_theme' ), 
				'footer-menu' => __(THEME_NAME . ' Footer menu', 'mandrake_theme' )
			));
		}
	}
	
	/* Load admin styles and scripts */
	function admin_head() {
		wp_enqueue_style('admin-style', THEME_ASSETS . '/css/style.css');
		wp_enqueue_script('iphone-style-checkboxes',THEME_ASSETS . '/js/iphone-checkboxes.js',array('jquery'));
		wp_enqueue_script('sidebar-builder',THEME_ASSETS . '/js/sidebar-builder.js',array('jquery'));
	}
	
	/* Load options menu */
	function option_menus() {
		add_menu_page(THEME_NAME, THEME_NAME, 'administrator', 'option_general', array(&$this, 'load_options'));
		add_submenu_page('option_general', 'General', 'General', 'administrator', 'option_general', array(&$this, 'load_options'));
		add_submenu_page('option_general', 'Slideshow', 'Slideshow', 'administrator', 'option_slideshow', array(&$this, 'load_options'));
		add_submenu_page('option_general', 'Home', 'Home', 'administrator', 'option_home', array(&$this, 'load_options'));
		add_submenu_page('option_general', 'Blog', 'Blog', 'administrator', 'option_blog', array(&$this, 'load_options'));
		add_submenu_page('option_general', 'Portfolio', 'Portfolio', 'administrator', 'option_portfolio', array(&$this,'load_options'));
		add_submenu_page('option_general', 'Sidebar', 'Sidebar', 'administrator', 'option_sidebar', array(&$this, 'load_options'));
		add_submenu_page('option_general', 'Footer', 'Footer', 'administrator', 'option_footer', array(&$this, 'load_options'));
	}
	
	/* Load options page */
	function load_options() {
		$page = include(THEME_OPTIONS .'/'. $_GET['page'] .'.php');
		new optionBuilder($page['name'], $page['options']);
	}
	
	/* Load translation files */
	function language() {
		$locale = get_locale();
		load_theme_textdomain('mandrake_theme', THEME_DIR . '/languages');
		$locale_file = THEME_DIR . "/languages/$locale.php";
		if (is_readable($locale_file)){
			require_once($locale_file);
		}
	}
}

?>