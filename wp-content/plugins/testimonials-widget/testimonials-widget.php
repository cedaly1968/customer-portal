<?php
/**
 * Plugin Name: Testimonials Widget
 * Plugin URI: http://wordpress.org/extend/plugins/testimonials-widget/
 * Description: Testimonials Widget plugin allows you to display random or selected portfolio, quotes, reviews, showcases, or text with images on your WordPress blog.
 * Version: 2.13.6
 * Author: Michael Cannon
 * Author URI: http://aihr.us/about-aihrus/michael-cannon-resume/
 * License: GPLv2 or later
 */


/**
 * Copyright 2013 Michael Cannon (email: mc@aihr.us)
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */
class Testimonials_Widget {
	const ID          = 'testimonials-widget-testimonials';
	const OLD_NAME    = 'testimonialswidget';
	const PLUGIN_FILE = 'testimonials-widget/testimonials-widget.php';
	const PT          = 'testimonials-widget';
	const VERSION     = '2.13.6';

	private static $base          = null;
	private static $max_num_pages = 0;
	private static $post_count    = 0;
	private static $wp_query      = null;

	public static $cpt_category    = '';
	public static $cpt_tags        = '';
	public static $css             = array();
	public static $css_called      = false;
	public static $donate_button   = '';
	public static $instance_number = 0;
	public static $instance_widget = 0;
	public static $scripts         = array();
	public static $scripts_called  = false;
	public static $settings_link   = '';
	public static $tag_close_quote = '<span class="close-quote"></span>';
	public static $tag_open_quote  = '<span class="open-quote"></span>';
	public static $use_instance    = false;
	public static $widget_number   = 100000;


	public function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_shortcode( 'testimonialswidget_list', array( $this, 'testimonialswidget_list' ) );
		add_shortcode( 'testimonialswidget_widget', array( $this, 'testimonialswidget_widget' ) );
	}


	public function admin_init() {
		self::$donate_button = <<<EOD
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="WM4F995W9LHXE">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
EOD;

		self::$settings_link = '<a href="' . get_admin_url() . 'edit.php?post_type=' . Testimonials_Widget::PT . '&page=' . Testimonials_Widget_Settings::ID . '">' . esc_html__( 'Settings', 'testimonials-widget' ) . '</a>';

		$this->add_meta_box_testimonials_widget();
		$this->update();
		add_action( 'gettext', array( $this, 'gettext_testimonials' ) );
		add_action( 'manage_' . self::PT . '_posts_custom_column', array( $this, 'manage_posts_custom_column' ), 10, 2 );
		add_action( 'right_now_content_table_end', array( $this, 'right_now_content_table_end' ) );
		add_filter( 'manage_' . self::PT . '_posts_columns', array( $this, 'manage_posts_columns' ) );
		add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 2 );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		add_filter( 'pre_get_posts', array( $this, 'pre_get_posts_author' ) );
		self::support_thumbnails();
	}


	public function init() {
		add_filter( 'the_content', array( $this, 'get_single' ) );
		load_plugin_textdomain( self::PT, false, 'testimonials-widget/languages' );
		self::$base         = plugin_basename( __FILE__ );
		self::$cpt_category = self::PT . '-category';
		self::$cpt_tags     = self::PT . '-post_tag';
		self::init_post_type();
		self::styles();
	}


	public function plugin_action_links( $links, $file ) {
		if ( $file == self::$base )
			array_unshift( $links, self::$settings_link );

		return $links;
	}


	public static function add_instance() {
		self::$use_instance = false;
		self::$instance_number++;
	}


	public static function get_instance() {
		return self::$use_instance ? self::$instance_number : self::$instance_widget;
	}


	public static function set_instance( $widget_number ) {
		self::$use_instance    = true;
		self::$instance_widget = $widget_number;
	}


	public static function support_thumbnails() {
		$feature       = 'post-thumbnails';
		$feature_level = get_theme_support( $feature );

		if ( true === $feature_level ) {
			// already enabled for all post types
			return;
		} elseif ( false === $feature_level ) {
			// none allowed, only enable for our own
			add_theme_support( $feature, array( self::PT ) );
		} else {
			// add our own to list of supported
			$feature_level[0][] = self::PT;
			add_theme_support( $feature, $feature_level[0] );
		}
	}


	public function get_single( $content ) {
		global $post;

		if ( ! is_single() || self::PT != $post->post_type )
			return $content;

		$atts                 = self::get_defaults( true );
		$atts['hide_content'] = 1;
		$atts['ids']          = $post->ID;
		$atts['type']         = 'get_single';

		$testimonials = self::get_testimonials( $atts );
		$testimonial  = $testimonials[0];

		$details = self::get_testimonial_html( $testimonial, $atts );
		$details = apply_filters( 'testimonials_widget_testimonial_html_single', $details, $testimonial, $atts );
		$content = apply_filters( 'testimonials_widget_testimonial_html_single_content', $content, $testimonial, $atts );

		return $content . $details;
	}


	public function activation() {
		if ( ! current_user_can( 'activate_plugins' ) )
			return;

		require_once 'lib/class-testimonials-widget-settings.php';
		self::init();
		flush_rewrite_rules();
	}


	public function deactivation() {
		if ( ! current_user_can( 'activate_plugins' ) )
			return;

		flush_rewrite_rules();
	}


	public function uninstall() {
		if ( ! current_user_can( 'activate_plugins' ) )
			return;

		global $wpdb;

		require_once 'lib/class-testimonials-widget-settings.php';
		$delete_data = tw_get_option( 'delete_data', false );
		if ( $delete_data ) {
			delete_option( Testimonials_Widget_Settings::ID );
			delete_option( self::OLD_NAME );
			$wpdb->query( 'OPTIMIZE TABLE `' . $wpdb->options . '`' );

			Testimonials_Widget::delete_testimonials();
		}
	}


	public static function delete_testimonials() {
		global $wpdb;

		$query = "SELECT ID FROM {$wpdb->posts} WHERE post_type = '" . self::PT . "'";
		$posts = $wpdb->get_results( $query );

		foreach ( $posts as $post ) {
			$post_id = $post->ID;
			Testimonials_Widget::delete_attachments( $post_id );

			// dels post, meta & comments
			// true is force delete
			wp_delete_post( $post_id, true );
		}

		$wpdb->query( 'OPTIMIZE TABLE `' . $wpdb->postmeta . '`' );
		$wpdb->query( 'OPTIMIZE TABLE `' . $wpdb->posts . '`' );
	}


	public static function delete_attachments( $post_id = false ) {
		global $wpdb;

		$post_id     = $post_id ? $post_id : 0;
		$query       = "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_parent = {$post_id}";
		$attachments = $wpdb->get_results( $query );

		foreach ( $attachments as $attachment ) {
			// true is force delete
			wp_delete_attachment( $attachment->ID, true );
		}
	}


	public static function plugin_row_meta( $input, $file ) {
		if ( $file != self::$base )
			return $input;

		$disable_donate = tw_get_option( 'disable_donate' );
		if ( $disable_donate )
			return $input;

		$links = array(
			'<a href="http://aihr.us/about-aihrus/donate/"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" alt="PayPal - The safer, easier way to pay online!" /></a>',
			'<a href="http://aihr.us/downloads/testimonials-widget-premium-wordpress-plugin/">Purchase Testimonials Widget Premium</a>',
		);

		$input = array_merge( $input, $links );

		return $input;
	}


	public function admin_notices_2_12_0() {
		$content  = '<div class="updated fade"><p>';
		$content .= sprintf( __( 'If your Testimonials Widget display has gone to funky town, please <a href="%s">read the FAQ</a> about possible CSS fixes.', 'testimonials-widget' ), 'https://aihrus.zendesk.com/entries/23722573-Major-Changes-Since-2-10-0' );
		$content .= '</p></div>';

		echo $content;
	}


	public function admin_notices_donate() {
		$content  = '<div class="updated fade"><p>';
		$content .= sprintf( esc_html__( 'Please donate $2 towards development and support of this Testimonials Widget plugin. %s', 'testimonials-widget' ), self::$donate_button );
		$content .= '</p></div>';

		echo $content;
	}


	public function update() {
		$prior_version = tw_get_option( 'admin_notices' );
		if ( $prior_version ) {
			if ( $prior_version < '2.12.0' )
				add_action( 'admin_notices', array( $this, 'admin_notices_2_12_0' ) );

			tw_set_option( 'admin_notices' );
		}

		// display donate on major/minor version release
		$donate_version = tw_get_option( 'donate_version', false );
		if ( ! $donate_version || ( $donate_version != self::VERSION && preg_match( '#\.0$#', self::VERSION ) ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notices_donate' ) );
			tw_set_option( 'donate_version', self::VERSION );
		}

		$options = get_option( self::OLD_NAME );
		if ( true !== $options['migrated'] )
			$this->migrate();
	}


	public function migrate() {
		global $wpdb;

		$table_name       = $wpdb->prefix . self::OLD_NAME;
		$meta_key         = '_' . self::PT . ':testimonial_id';
		$has_table_query  = "SELECT table_name FROM information_schema.tables WHERE table_schema='{$wpdb->dbname}' AND table_name='{$table_name}'";
		$has_table_result = $wpdb->get_col( $has_table_query );

		if ( ! empty( $has_table_result ) ) {
			// check that db table exists and has entries
			$query = 'SELECT `testimonial_id`, `testimonial`, `author`, `source`, `tags`, `public`, `time_added`, `time_updated` FROM `' . $table_name . '`';

			// ignore already imported
			$done_import_query = 'SELECT meta_value FROM ' . $wpdb->postmeta . ' WHERE meta_key = "' . $meta_key . '"';
			$done_import       = $wpdb->get_col( $done_import_query );

			if ( ! empty( $done_import ) ) {
				$done_import = array_unique( $done_import );
				$query      .= ' WHERE testimonial_id NOT IN ( ' . implode( ',', $done_import ) . ' )';
			}

			$results = $wpdb->get_results( $query );
			if ( ! empty( $results ) ) {
				foreach ( $results as $result ) {
					// author can contain title and company details
					$author  = $result->author;
					$company = false;

					// ex: First Last of Company!
					$author = str_replace( ' of ', ', ', $author );
					// now ex: First Last, Company!

					// ex: First Last, Company
					// ex: First Last, Web Development Manager, Topcon Positioning Systems, Inc.
					// ex: First Last, Owner, Company, LLC
					$author     = str_replace( ' of ', ', ', $author );
					$temp_comma = '^^^';
					$author     = str_replace( ', LLC', $temp_comma . ' LLC', $author );

					// now ex: First Last, Owner, Company^^^ LLC
					$author = str_replace( ', Inc', $temp_comma . ' Inc', $author );

					// ex: First Last, Web Development Manager, Company^^^ Inc.
					// it's possible to have "Michael Cannon, Senior Developer" and "Senior Developer" become the company. Okay for now
					$author = explode( ', ', $author );

					if ( 1 < count( $author ) ) {
						$company = array_pop( $author );
						$company = str_replace( $temp_comma, ',', $company );
					}

					$author = implode( ', ', $author );
					$author = str_replace( $temp_comma, ',', $author );

					$post_data = array(
						'post_type' => self::PT,
						'post_status' => ( 'yes' == $result->public ) ? 'publish' : 'private',
						'post_date' => $result->time_added,
						'post_modified' => $result->time_updated,
						'post_title' => $author,
						'post_content' => $result->testimonial,
						'tags_input' => $result->tags,
					);

					$post_id = wp_insert_post( $post_data, true );

					// track/link testimonial import to new post
					add_post_meta( $post_id, $meta_key, $result->testimonial_id );

					if ( ! empty( $company ) )
						add_post_meta( $post_id, 'testimonials-widget-company', $company );

					$source = $result->source;
					if ( ! empty( $source ) ) {
						if ( is_email( $source ) ) {
							add_post_meta( $post_id, 'testimonials-widget-email', $source );
						} else {
							add_post_meta( $post_id, 'testimonials-widget-url', $source );
						}
					}
				}
			}
		}

		$options['migrated'] = true;
		delete_option( self::OLD_NAME );
		add_option( self::OLD_NAME, $options );
	}


	public function pre_get_posts_author( $query ) {
		global $user_ID;

		// author's and below
		if ( $query->is_admin && ! empty( $query->is_main_query ) && $query->is_post_type_archive( Testimonials_Widget::PT ) && ! current_user_can( 'edit_others_posts' ) )
			$query->set( 'post_author', $user_ID );

		return $query;
	}


	public function manage_posts_custom_column( $column, $post_id ) {
		$result = false;

		switch ( $column ) {
		case 'id':
			$result = $post_id;
			break;

		case 'shortcode':
			$result  = '[testimonialswidget_list ids="';
			$result .= $post_id;
			$result .= '"]';
			$result .= '<br />';
			$result .= '[testimonialswidget_widget ids="';
			$result .= $post_id;
			$result .= '"]';
			break;

		case 'testimonials-widget-company':
		case 'testimonials-widget-location':
		case 'testimonials-widget-title':
			$result = get_post_meta( $post_id, $column, true );
			break;

		case 'testimonials-widget-email':
		case 'testimonials-widget-url':
			$url = get_post_meta( $post_id, $column, true );
			if ( ! empty( $url ) && ! is_email( $url ) && 0 === preg_match( '#https?://#', $url ) )
				$url = 'http://' . $url;

			$result = make_clickable( $url );
			break;

		case 'thumbnail':
			$email = get_post_meta( $post_id, 'testimonials-widget-email', true );

			if ( has_post_thumbnail( $post_id ) ) {
				$result = get_the_post_thumbnail( $post_id, 'thumbnail' );
			} elseif ( is_email( $email ) ) {
				$result = get_avatar( $email );
			} else {
				$result = false;
			}
			break;

		case self::$cpt_category:
		case self::$cpt_tags:
			$terms  = get_the_terms( $post_id, $column );
			$result = '';
			if ( ! empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term )
					$out[] = '<a href="' . admin_url( 'edit-tags.php?action=edit&taxonomy=' . $column . '&tag_ID=' . $term->term_id . '&post_type=' . self::PT ) . '">' . $term->name . '</a>';

				$result = join( ', ', $out );
			}
			break;
		}

		$result = apply_filters( 'testimonials_widget_posts_custom_column', $result, $column, $post_id );

		if ( $result )
			echo $result;
	}


	public function manage_posts_columns( $columns ) {
		// order of keys matches column ordering
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'id' => esc_html__( 'ID', 'testimonials-widget' ),
			'thumbnail' => esc_html__( 'Image', 'testimonials-widget' ),
			'title' => esc_html__( 'Source', 'testimonials-widget' ),
			'shortcode' => esc_html__( 'Shortcodes', 'testimonials-widget' ),
			'testimonials-widget-title' => esc_html__( 'Job Title', 'testimonials-widget' ),
			'testimonials-widget-location' => esc_html__( 'Location', 'testimonials-widget' ),
			'testimonials-widget-email' => esc_html__( 'Email', 'testimonials-widget' ),
			'testimonials-widget-company' => esc_html__( 'Company', 'testimonials-widget' ),
			'testimonials-widget-url' => esc_html__( 'URL', 'testimonials-widget' ),
			'author' => esc_html__( 'Published by', 'testimonials-widget' ),
			'date' => esc_html__( 'Date', 'testimonials-widget' ),
		);

		$use_cpt_taxonomy = tw_get_option( 'use_cpt_taxonomy', false );
		if ( ! $use_cpt_taxonomy ) {
			$columns[ 'categories' ] = esc_html__( 'Category', 'testimonials-widget' );
			$columns[ 'tags' ]       = esc_html__( 'Tags', 'testimonials-widget' );
		} else {
			$columns[ self::$cpt_category ] = esc_html__( 'Category', 'testimonials-widget' );
			$columns[ self::$cpt_tags ]     = esc_html__( 'Tags', 'testimonials-widget' );
		}

		$columns = apply_filters( 'testimonials_widget_columns', $columns );

		return $columns;
	}


	public function init_post_type() {
		$labels = array(
			'add_new' => esc_html__( 'Add New', 'testimonials-widget' ),
			'add_new_item' => esc_html__( 'Add New Testimonial', 'testimonials-widget' ),
			'edit_item' => esc_html__( 'Edit Testimonial', 'testimonials-widget' ),
			'name' => esc_html__( 'Testimonials', 'testimonials-widget' ),
			'new_item' => esc_html__( 'Add New Testimonial', 'testimonials-widget' ),
			'not_found' => esc_html__( 'No testimonials found', 'testimonials-widget' ),
			'not_found_in_trash' => esc_html__( 'No testimonials found in Trash', 'testimonials-widget' ),
			'parent_item_colon' => null,
			'search_items' => esc_html__( 'Search Testimonials', 'testimonials-widget' ),
			'singular_name' => esc_html__( 'Testimonial', 'testimonials-widget' ),
			'view_item' => esc_html__( 'View Testimonial', 'testimonials-widget' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
		);

		$allow_comments = tw_get_option( 'allow_comments', false );
		if ( $allow_comments )
			$supports[] = 'comments';

		$has_archive      = tw_get_option( 'has_archive', true );
		$rewrite_slug     = tw_get_option( 'rewrite_slug', 'testimonial' );
		$use_cpt_taxonomy = tw_get_option( 'use_cpt_taxonomy', false );

		// editor's and up
		if ( current_user_can( 'edit_others_posts' ) )
			$supports[] = 'author';

		if ( ! $use_cpt_taxonomy ) {
			$do_register_taxonomy = false;
			$taxonomies           = array(
				'category',
				'post_tag',
			);
		} else {
			$do_register_taxonomy = true;
			$taxonomies           = array(
				self::$cpt_category,
				self::$cpt_tags,
			);

			self::register_taxonomies();
		}

		$args = array(
			'label' => esc_html__( 'Testimonials', 'testimonials-widget' ),
			'capability_type' => 'post',
			'has_archive' => $has_archive,
			'hierarchical' => false,
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'rewrite' => array(
				'slug' => $rewrite_slug,
				'with_front' => false,
			),
			'show_in_menu' => true,
			'show_ui' => true,
			'supports' => $supports,
			'taxonomies' => $taxonomies,
		);

		register_post_type( self::PT, $args );

		if ( $do_register_taxonomy ) {
			register_taxonomy_for_object_type( self::$cpt_category, self::PT );
			register_taxonomy_for_object_type( self::$cpt_tags, self::PT );
		}
	}


	public static function register_taxonomies() {
		$args = array(
			'hierarchical' => true,
		);
		register_taxonomy( self::$cpt_category, self::PT, $args );

		$args = array(
			'update_count_callback' => '_update_post_term_count',
		);
		register_taxonomy( self::$cpt_tags, self::PT, $args );
	}


	public static function get_defaults( $single_view = false ) {
		if ( empty( $single_view ) )
			return apply_filters( 'testimonials_widget_defaults', tw_get_options() );
		else
			return apply_filters( 'testimonials_widget_defaults_single', tw_get_options() );
	}


	public function testimonialswidget_list( $atts ) {
		self::add_instance();

		$atts = wp_parse_args( $atts, self::get_defaults() );
		$atts = Testimonials_Widget_Settings::validate_settings( $atts );

		if ( get_query_var( 'paged' ) ) {
			$atts['paged'] = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$atts['paged'] = get_query_var( 'page' );
		} else {
			$atts['paged'] = 1;
		}

		$atts['type'] = 'testimonialswidget_list';

		$content = apply_filters( 'testimonials_widget_cache_get', false, $atts );

		if ( false === $content ) {
			$testimonials = self::get_testimonials( $atts );
			$content      = self::get_testimonials_html( $testimonials, $atts );
			$content      = apply_filters( 'testimonials_widget_cache_set', $content, $atts );
		}

		return $content;
	}


	public static function testimonialswidget_widget( $atts, $widget_number = null ) {
		if ( empty( $widget_number ) ) {
			$widget_number = self::$widget_number++;

			if ( ! isset( $atts['random'] ) )
				$atts['random'] = 1;
		}

		self::set_instance( $widget_number );

		$atts = wp_parse_args( $atts, self::get_defaults() );
		$atts = Testimonials_Widget_Settings::validate_settings( $atts );

		$atts['paging']        = false;
		$atts['type']          = 'testimonialswidget_widget';
		$atts['widget_number'] = $widget_number;

		self::scripts( $atts );

		$testimonials = self::get_testimonials( $atts );

		$content = apply_filters( 'testimonials_widget_cache_get', false, $atts );

		if ( false === $content ) {
			$content = self::get_testimonials_html( $testimonials, $atts, false, $widget_number );
			$content = apply_filters( 'testimonials_widget_cache_set', $content, $atts );
		}

		// Generate CSS
		$atts['type'] = 'testimonialswidget_widget_css';
		$css          = apply_filters( 'testimonials_widget_cache_get', false, $atts );

		if ( false === $css ) {
			$css = self::get_testimonials_html_css( $atts, $widget_number );
			$css = apply_filters( 'testimonials_widget_cache_set', $css, $atts );
		}

		if ( ! empty( $css ) ) {
			self::$css = array_merge( $css, self::$css );
			add_action( 'wp_footer', array( 'Testimonials_Widget', 'get_testimonials_css' ), 20 );
		}

		// Generate JS
		$atts['type'] = 'testimonialswidget_widget_js';
		$js           = apply_filters( 'testimonials_widget_cache_get', false, $atts );

		if ( false === $js ) {
			$js = self::get_testimonials_html_js( $testimonials, $atts, $widget_number );
			$js = apply_filters( 'testimonials_widget_cache_set', $js, $atts );
		}

		if ( ! empty( $js ) ) {
			self::$scripts = array_merge( $js, self::$scripts );
			add_action( 'wp_footer', array( 'Testimonials_Widget', 'get_testimonials_scripts' ), 20 );
		}

		return $content;
	}


	public static function scripts( $atts ) {
		if ( is_admin() )
			return;

		wp_enqueue_script( 'jquery' );

		do_action( 'testimonials_widget_scripts', $atts );
	}


	public static function styles() {
		if ( is_admin() )
			return;

		wp_register_style( 'testimonials-widget', plugins_url( 'testimonials-widget.css', __FILE__ ) );
		wp_enqueue_style( 'testimonials-widget' );

		$include_ie7_css = tw_get_option( 'include_ie7_css' );
		if ( $include_ie7_css ) {
			wp_register_style( 'testimonials-widget-ie7', plugins_url( 'testimonials-widget-ie7.css', __FILE__ ) );
			wp_enqueue_style( 'testimonials-widget-ie7' );
		}
	}


	public static function get_testimonials_html_css( $atts, $widget_number = null ) {
		// display attributes
		$height     = $atts['height'];
		$max_height = $atts['max_height'];
		$min_height = $atts['min_height'];

		if ( $height ) {
			$max_height = $height;
			$min_height = $height;
		}

		$css     = array();
		$id_base = self::ID . $widget_number;

		if ( $min_height ) {
			$css[] = <<<EOF
<style>
.$id_base {
min-height: {$min_height}px;
}
</style>
EOF;
		}

		if ( $max_height ) {
			$css[] = <<<EOF
<style>
.$id_base {
	max-height: {$max_height}px;
}
</style>
EOF;
		}

		$css = apply_filters( 'testimonials_widget_testimonials_css', $css, $atts, $widget_number );

		return $css;
	}


	public static function get_testimonials_html_js( $testimonials, $atts, $widget_number = null ) {
		// display attributes
		$refresh_interval = $atts['refresh_interval'];

		$id_base    = self::ID . $widget_number;
		$scripts    = array();
		$tw_padding = 'tw_padding' . $widget_number;
		$tw_wrapper = 'tw_wrapper' . $widget_number;

		$disable_animation = $atts['disable_animation'];
		$fade_in_speed     = $atts['fade_in_speed'];
		$fade_out_speed    = $atts['fade_out_speed'];
		$height            = $atts['height'];
		$max_height        = $atts['max_height'];
		$min_height        = $atts['min_height'];

		$enable_animation = 1;
		if ( $disable_animation || $height || $max_height || $min_height )
			$enable_animation = 0;

		if ( $refresh_interval && 1 < count( $testimonials ) ) {
			$javascript = <<<EOF
<script type="text/javascript">
if ( {$enable_animation} ) {
	var {$tw_wrapper} = jQuery('.{$id_base}');
	// tw_padding is the difference in height to take into account all styling options
	var {$tw_padding} = {$tw_wrapper}.height() - jQuery('.{$id_base} .testimonials-widget').height();
	// fixes first animation by defining height to adjust to
	{$tw_wrapper}.height( {$tw_wrapper}.height() );
}

function nextTestimonial{$widget_number}() {
	if ( ! jQuery('.{$id_base}').first().hasClass('hovered') ) {
		var active = jQuery('.{$id_base} .active');
		var next   = (jQuery('.{$id_base} .active').next().length > 0) ? jQuery('.{$id_base} .active').next() : jQuery('.{$id_base} .testimonials-widget-testimonial:first-child');

		active.fadeOut({$fade_out_speed}, function(){
			active.removeClass('active');
			next.fadeIn({$fade_in_speed});
			next.removeClass('display-none');
			next.addClass('active');

			{INTERNAL_SCRIPTS}

			if ( {$enable_animation} ) {
				// added padding
				{$tw_wrapper}.animate({ height: next.height() + {$tw_padding} });
			}
		});
	}
}

jQuery(document).ready(function(){
	jQuery('.{$id_base}').hover(function() {
		jQuery(this).addClass('hovered')
	}, function() {
		jQuery(this).removeClass('hovered')
	});
	nextTestimonial{$widget_number}interval = setInterval('nextTestimonial{$widget_number}()', {$refresh_interval} * 1000);
});
</script>
EOF;

			$scripts[ $id_base ] = $javascript;
		}

		$scripts          = apply_filters( 'testimonials_widget_testimonials_js', $scripts, $testimonials, $atts, $widget_number );
		$scripts_internal = apply_filters( 'testimonials_widget_testimonials_js_internal', array(), $testimonials, $atts, $widget_number );
		$internal_scripts = implode( "\n", $scripts_internal );
		$scripts          = str_replace( '{INTERNAL_SCRIPTS}', $internal_scripts, $scripts );

		ksort( $scripts );

		return $scripts;
	}


	public static function get_testimonials_html( $testimonials, $atts, $is_list = true, $widget_number = null ) {
		// display attributes
		$hide_not_found = $atts['hide_not_found'];
		$paging         = Testimonials_Widget_Settings::is_true( $atts['paging'] );
		$paging_before  = ( 'before' === strtolower( $atts['paging'] ) );
		$paging_after   = ( 'after' === strtolower( $atts['paging'] ) );
		$target         = $atts['target'];

		$html = '';
		$id   = self::ID;

		if ( is_null( $widget_number ) ) {
			$html .= '<div class="' . $id;

			if ( $is_list )
				$html .= ' listing';

			$html .= '">';
		} else {
			$id_base = $id . $widget_number;
			$html   .= '<div class="' . $id . ' ' . $id_base . '">';
		}

		if ( empty( $testimonials ) && ! $hide_not_found ) {
			$testimonials = array(
				array( 'testimonial_content' => esc_html__( 'No testimonials found', 'testimonials-widget' ) ),
			);
		}

		if ( $paging || $paging_before )
			$html .= self::get_testimonials_paging( $atts );

		$is_first = true;

		foreach ( $testimonials as $testimonial ) {
			$content = self::get_testimonial_html( $testimonial, $atts, $is_list, $is_first, $widget_number );
			if ( $target )
				$content = links_add_target( $content, $target );
			$content  = apply_filters( 'testimonials_widget_testimonial_html', $content, $testimonial, $atts, $is_list, $is_first, $widget_number );
			$html    .= $content;
			$is_first = false;
		}

		if ( $paging || $paging_after )
			$html .= self::get_testimonials_paging( $atts, false );

		$html .= '</div>';

		return $html;
	}


	public static function get_testimonial_html( $testimonial, $atts, $is_list = true, $is_first = false, $widget_number = null ) {
		// display attributes
		$disable_quotes  = $atts['disable_quotes'];
		$do_image        = ! $atts['hide_image'] && ! empty( $testimonial['testimonial_image'] );
		$do_image_single = ! $atts['hide_image_single'];
		$keep_whitespace = $atts['keep_whitespace'];
		$remove_hentry   = $atts['remove_hentry'];

		$class = 'testimonials-widget-testimonial';
		if ( is_single() && empty( $widget_number ) ) {
			$class .= ' single';
		} elseif ( $is_list ) {
			$class .= ' list';
		} elseif ( $is_first ) {
			$class .= ' active';
		} elseif ( ! $is_first ) {
			$class .= ' display-none';
		}

		if ( $keep_whitespace )
			$class .= ' whitespace';

		if ( ! empty( $testimonial['post_id'] ) )
			$class = join( ' ', get_post_class( $class, $testimonial['post_id'] ) );
		else
			$class = 'testimonials-widget type-testimonials-widget status-publish hentry ' . $class;

		$class    = apply_filters( 'testimonials_widget_get_testimonial_html_class', $class, $testimonial, $atts, $is_list, $is_first, $widget_number );
		$div_open = '<div class="' . $class . '">';

		if ( $remove_hentry )
			$div_open = str_replace( ' hentry', '', $div_open );

		$image = '';
		if ( $do_image ) {
			$image .= '<span class="image">';
			$image .= $testimonial['testimonial_image'];
			$image .= '</span>';
		}

		if ( ! $do_image_single && 'get_single' == $atts['type'] )
			$image = '';

		$quote = self::get_quote( $testimonial, $atts, $widget_number );
		$cite  = self::get_cite( $testimonial, $atts );

		$extra = '';
		if ( ! empty( $testimonial['testimonial_extra'] ) ) {
			$extra .= '<div class="extra">';
			$extra .= $testimonial['testimonial_extra'];
			$extra .= '</div>';
		}

		$bottom_text = '';
		if ( ! empty( $atts['bottom_text'] ) ) {
			$bottom_text  = '<div class="bottom_text">';
			$bottom_text .= $atts['bottom_text'];
			$bottom_text .= '</div>';
		}

		$div_close = '</div>';

		$html = $div_open
			. $image
			. $quote
			. $cite
			. $extra
			. $bottom_text
			. $div_close;

		$html = apply_filters( 'testimonials_widget_get_testimonial_html', $html, $testimonial, $atts, $is_list, $is_first, $widget_number, $div_open, $image, $quote, $cite, $extra, $bottom_text, $div_close );

		// not done sooner as tag_close_quote is used for Premium
		if ( $disable_quotes ) {
			$html = str_replace( self::$tag_open_quote, '', $html );
			$html = str_replace( self::$tag_close_quote, '', $html );
		}

		return $html;
	}


	public static function get_quote( $testimonial, $atts, $widget_number ) {
		$char_limit    = $atts['char_limit'];
		$content_more  = apply_filters( 'testimonials_widget_content_more', esc_html__( '…', 'testimonials-widget' ) );
		$content_more .= self::$tag_close_quote;
		$do_content    = ! $atts['hide_content'] && ! empty( $testimonial['testimonial_content'] );
		$use_quote_tag = $atts['use_quote_tag'];

		$quote = '';
		if ( $do_content ) {
			$content = $testimonial['testimonial_content'];
			$content = self::format_content( $content, $widget_number, $atts );

			if ( $char_limit ) {
				$content = self::testimonials_truncate( $content, $char_limit, $content_more );
				$content = force_balance_tags( $content );
			}

			$content = apply_filters( 'testimonials_widget_content', $content, $widget_number, $testimonial, $atts );
			$content = make_clickable( $content );

			if ( empty( $use_quote_tag ) ) {
				$quote  = '<blockquote>';
				$quote .= $content;
				$quote .= '</blockquote>';
			} else {
				$quote  = '<q>';
				$quote .= $content;
				$quote .= '</q>';
			}
		}

		return $quote;
	}


	public static function get_cite( $testimonial, $atts ) {
		$do_company    = ! $atts['hide_company'] && ! empty( $testimonial['testimonial_company'] );
		$do_email      = ! $atts['hide_email'] && ! empty( $testimonial['testimonial_email'] ) && is_email( $testimonial['testimonial_email'] );
		$do_location   = ! $atts['hide_location'] && ! empty( $testimonial['testimonial_location'] );
		$do_source     = ! $atts['hide_source'] && ! empty( $testimonial['testimonial_source'] );
		$do_title      = ! $atts['hide_title'] && ! empty( $testimonial['testimonial_title'] );
		$do_url        = ! $atts['hide_url'] && ! empty( $testimonial['testimonial_url'] );
		$use_quote_tag = $atts['use_quote_tag'];

		$cite     = '';
		$done_url = false;
		if ( $do_source && $do_email ) {
			$cite .= '<span class="author">';
			$cite .= '<a href="mailto:' . $testimonial['testimonial_email'] . '">';
			$cite .= $testimonial['testimonial_source'];
			$cite .= '</a>';
			$cite .= '</span>';
		} elseif ( $do_source && ! $do_company && $do_url ) {
			$done_url = true;

			$cite .= '<span class="author">';
			$cite .= '<a href="' . $testimonial['testimonial_url'] . '" rel="nofollow">';
			$cite .= $testimonial['testimonial_source'];
			$cite .= '</a>';
			$cite .= '</span>';
		} elseif ( $do_source ) {
			$cite .= '<span class="author">';
			$cite .= $testimonial['testimonial_source'];
			$cite .= '</span>';
		} elseif ( $do_email ) {
			$cite .= '<span class="email">';
			$cite .= make_clickable( $testimonial['testimonial_email'] );
			$cite .= '</span>';
		}

		if ( $do_title && $cite )
			$cite .= '<span class="join-title"></span>';

		if ( $do_title ) {
			$cite .= '<span class="title">';
			$cite .= $testimonial['testimonial_title'];
			$cite .= '</span>';
		}

		if ( $do_location && $cite )
			$cite .= '<span class="join-location"></span>';

		if ( $do_location ) {
			$cite .= '<span class="location">';
			$cite .= $testimonial['testimonial_location'];
			$cite .= '</span>';
		}

		if ( ( $do_company || ( $do_url && ! $done_url ) ) && $cite )
			$cite .= '<span class="join"></span>';

		if ( $do_company && $do_url ) {
			$cite .= '<span class="company">';
			$cite .= '<a href="' . $testimonial['testimonial_url'] . '" rel="nofollow">';
			$cite .= $testimonial['testimonial_company'];
			$cite .= '</a>';
			$cite .= '</span>';
		} elseif ( $do_company ) {
			$cite .= '<span class="company">';
			$cite .= $testimonial['testimonial_company'];
			$cite .= '</span>';
		} elseif ( $do_url && ! $done_url ) {
			$cite .= '<span class="url">';
			$cite .= make_clickable( $testimonial['testimonial_url'] );
			$cite .= '</span>';
		}

		$cite = apply_filters( 'testimonials_widget_cite_html', $cite, $testimonial, $atts );

		if ( ! empty( $cite ) ) {
			if ( empty( $use_quote_tag ) ) {
				$temp  = '<div class="credit">';
				$temp .= $cite;
				$temp .= '</div>';

				$cite = $temp;
			} else {
				$cite = '<cite>' . $cite . '</cite>';
			}
		}

		return $cite;
	}


	// Original PHP code as myTruncate2 by Chirp Internet: www.chirp.com.au
	public static function testimonials_truncate( $string, $char_limit = false, $pad = '…', $force_pad = false ) {
		if ( empty( $force_pad ) ) {
			if ( empty( $char_limit ) )
				return $string;

			// return with no change if string is shorter than $char_limit
			if ( strlen( $string ) <= $char_limit )
				return $string;
		}

		if ( ! empty( $char_limit ) )
			return self::truncate( $string, $char_limit, $pad, $force_pad );

		return $string . $pad;
	}


	/**
	 * Truncate HTML, close opened tags. UTF-8 aware, and aware of unpaired tags
	 * (which don't need a matching closing tag)
	 *
	 * @param string  $html
	 * @param int     $max_length      Maximum length of the characters of the string
	 * @param string  $indicator       Suffix to use if string was truncated.
	 * @param boolean $force_indicator Suffix to use if string was truncated.
	 * @return string
	 *
	 * @ref http://pastie.org/3084080
	 */
	public static function truncate( $html, $max_length, $indicator = '&hellip;', $force_indicator = false ) {
		$output_length = 0; // number of counted characters stored so far in $output
		$position      = 0;      // character offset within input string after last tag/entity
		$tag_stack     = array(); // stack of tags we've encountered but not closed
		$output        = '';
		$truncated     = false;

		/**
		 * these tags don't have matching closing elements, in HTML (in XHTML they
		 * theoretically need a closing /> )
		 *
		 * @see http://www.netstrider.com/tutorials/HTMLRef/a_d.html
		 * @see http://www.w3schools.com/tags/default.asp
		 * @see http://stackoverflow.com/questions/3741896/what-do-you-call-tags-that-need-no-ending-tag
		 */
		$unpaired_tags = array(
			'doctype',
			'!doctype',
			'area',
			'base',
			'basefont',
			'bgsound',
			'br',
			'col',
			'embed',
			'frame',
			'hr',
			'img',
			'input',
			'link',
			'meta',
			'param',
			'sound',
			'spacer',
			'wbr',
		);

		$func_strcut = function_exists( 'mb_strcut' ) ? 'mb_strcut' : 'substr';
		$func_strlen = function_exists( 'mb_strlen' ) ? 'mb_strlen' : 'strlen';

		// loop through, splitting at HTML entities or tags
		while ( $output_length < $max_length && preg_match( '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}', $html, $match, PREG_OFFSET_CAPTURE, $position ) ) {
			list( $tag, $tag_position ) = $match[0];

			// get text leading up to the tag, and store it – up to max_length
			$text = $func_strcut( $html, $position, $tag_position - $position );
			if ( $output_length + $func_strlen( $text ) > $max_length ) {
				$output       .= $func_strcut( $text, 0, $max_length - $output_length );
				$truncated     = true;
				$output_length = $max_length;
				break;
			}

			// store everything, it wasn't too long
			$output        .= $text;
			$output_length += $func_strlen( $text );

			if ( $tag[0] == '&' ) {
				// Handle HTML entity by copying straight through
				$output .= $tag;
				$output_length++; // only counted as one character
			} else {
				// Handle HTML tag
				$tag_inner = $match[1][0];
				if ( $tag[1] == '/' ) {
					// This is a closing tag.
					$output .= $tag;
					// If input tags aren't balanced, we leave the popped tag
					// on the stack so hopefully we're not introducing more
					// problems.

					if ( end( $tag_stack ) == $tag_inner )
						array_pop( $tag_stack );
				} elseif ( $tag[$func_strlen( $tag ) - 2] == '/' || in_array( strtolower( $tag_inner ), $unpaired_tags ) ) {
					// Self-closing or unpaired tag
					$output .= $tag;
				} else {
					// Opening tag.
					$output     .= $tag;
					$tag_stack[] = $tag_inner; // push tag onto the stack
				}
			}

			// Continue after the tag we just found
			$position = $tag_position + $func_strlen( $tag );
		}

		// Print any remaining text after the last tag, if there's room

		if ( $output_length < $max_length && $position < $func_strlen( $html ) )
			$output .= $func_strcut( $html, $position, $max_length - $output_length );

		$truncated = $func_strlen( $html ) - $position > $max_length - $output_length;

		// add terminator if it was truncated in loop or just above here
		if ( $truncated || $force_indicator )
			$output .= $indicator;

		// Close any open tags
		while ( !empty( $tag_stack ) )
			$output .= '</'.array_pop( $tag_stack ).'>';

		return $output;
	}


	public static function format_content( $content, $widget_number, $atts ) {
		if ( empty ( $content ) )
			return $content;

		$keep_whitespace = $atts['keep_whitespace'];
		$do_shortcode    = $atts['do_shortcode'];

		// wrap our own quote class around the content before any formatting
		// happens

		$temp_content  = self::$tag_open_quote;
		$temp_content .= $content;
		$temp_content .= self::$tag_close_quote;

		$content = $temp_content;
		$content = trim( $content );
		$content = wptexturize( $content );
		$content = convert_smilies( $content );
		$content = convert_chars( $content );

		if ( is_null( $widget_number ) || $keep_whitespace )
			$content = wpautop( $content );

		$content = shortcode_unautop( $content );

		if ( $do_shortcode )
			$content = do_shortcode( $content );
		else
			$content = strip_shortcodes( $content );

		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = trim( $content );

		return $content;
	}


	public static function get_testimonials_paging( $atts, $prepend = true ) {
		$html = '';

		if ( is_home() || 1 === self::$max_num_pages )
			return $html;

		$html .= '<div class="paging';

		if ( $prepend )
			$html .= ' prepend';
		else
			$html .= ' append';

		$html .= '">';

		if ( ! empty( $atts['paged'] ) )
			$paged = $atts['paged'];
		else
			$paged = 1;

		if ( ! function_exists( 'wp_pagenavi' ) ) {
			$html .= '	<div class="alignleft">';

			if ( 1 < $paged ) {
				$laquo = apply_filters( 'testimonials_widget_previous_posts_link_text', esc_html__( '&laquo;', 'testimonials-widget' ) );
				$html .= get_previous_posts_link( $laquo, $paged );
			}

			$html .= '	</div>';

			$html .= '	<div class="alignright">';

			if ( $paged != self::$max_num_pages ) {
				$raquo = apply_filters( 'testimonials_widget_next_posts_link_text', esc_html__( '&raquo;', 'testimonials-widget' ) );
				$html .= get_next_posts_link( $raquo, self::$max_num_pages );
			}

			$html .= '	</div>';
		} else {
			$args = array(
				'echo' => false,
				'query' => self::$wp_query,
			);
			$args = apply_filters( 'testimonials_widget_wp_pagenavi', $args );

			$html .= wp_pagenavi( $args );
		}

		$html .= '</div>';

		return $html;
	}


	public static function get_testimonials_css() {
		if ( empty( self::$css_called ) ) {
			foreach ( self::$css as $css )
				echo $css;

			self::$css_called = true;
		}
	}


	public static function get_testimonials_scripts() {
		if ( empty( self::$scripts_called ) ) {
			foreach ( self::$scripts as $script )
				echo $script;

			self::$scripts_called = true;
		}
	}


	/**
	 *
	 *
	 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
	 */
	public static function get_query_args( $atts ) {
		extract( $atts );

		if ( has_filter( 'posts_orderby', 'CPTOrderPosts' ) )
			remove_filter( 'posts_orderby', 'CPTOrderPosts', 99, 2 );

		if ( $random ) {
			$orderby = 'rand';
			$order   = false;
		}

		if ( ! empty( $type ) && 'testimonialswidget_widget' == $type && empty( $refresh_interval ) )
			$limit = 1;

		$args = array(
			'orderby' => $orderby,
			'post_status' => array(
				'publish',
				'private',
			),
			'post_type' => Testimonials_Widget::PT,
			'posts_per_page' => $limit,
		);

		if ( is_single() ) {
			$args['post_status'][] = 'pending';
			$args['post_status'][] = 'draft';
		}

		if ( $paging && ! empty( $atts['paged'] ) && is_singular() )
			$args['paged'] = $atts['paged'];

		if ( ! $random && $meta_key ) {
			$args['meta_key'] = $meta_key;
			$args['orderby']  = 'meta_value';
		}

		if ( $order )
			$args['order'] = $order;

		if ( $ids ) {
			$ids = explode( ',', $ids );

			$args['post__in'] = $ids;

			if ( 'none' == $args['orderby'] )
				add_filter( 'posts_results', array( 'Testimonials_Widget', 'posts_results_sort_none' ), 10, 2 );
		}

		if ( $exclude ) {
			$exclude              = explode( ',', $exclude );
			$args['post__not_in'] = $exclude;
		}

		$use_cpt_taxonomy = tw_get_option( 'use_cpt_taxonomy', false );
		if ( ! $use_cpt_taxonomy ) {
			if ( $category )
				$args['category_name'] = $category;

			if ( $tags ) {
				$tags = explode( ',', $tags );

				if ( $tags_all )
					$args['tag_slug__and'] = $tags;
				else
					$args['tag_slug__in'] = $tags;
			}
		} else {
			if ( $category )
				$args[ self::$cpt_category ] = $category;

			if ( $tags ) {
				if ( $tags_all ) {
					$args[ 'tax_query' ] = array(
						'relation' => 'AND',
					);

					$tags = explode( ',', $tags );
					foreach ( $tags as $term ) {
						$args[ 'tax_query' ][] = array(
							'taxonomy' => self::$cpt_tags,
							'terms' => array( $term ),
							'field' => 'slug',
						);
					}
				} else {
					$args[ self::$cpt_tags ] = $tags;
				}
			}
		}

		$args = apply_filters( 'testimonials_widget_query_args', $args, $atts );

		return $args;
	}


	public static function get_testimonials( $atts ) {
		$hide_gravatar = $atts['hide_gravatar'];

		$args          = self::get_query_args( $atts );
		$args['query'] = true;

		$testimonials = apply_filters( 'testimonials_widget_cache_get', false, $args );

		if ( false === $testimonials ) {
			$testimonials = new WP_Query( $args );
			$testimonials = apply_filters( 'testimonials_widget_cache_set', $testimonials, $args );
		}

		if ( has_filter( 'posts_results', array( 'Testimonials_Widget', 'posts_results_sort_none' ) ) )
			remove_filter( 'posts_results', array( 'Testimonials_Widget', 'posts_results_sort_none' ) );

		self::$max_num_pages = $testimonials->max_num_pages;
		self::$post_count    = $testimonials->post_count;
		self::$wp_query      = $testimonials;

		wp_reset_postdata();

		$image_size    = apply_filters( 'testimonials_widget_image_size', 'thumbnail' );
		$gravatar_size = apply_filters( 'testimonials_widget_gravatar_size', 96 );

		$testimonial_data = array();

		if ( empty( self::$post_count ) )
			return $testimonial_data;

		foreach ( $testimonials->posts as $row ) {
			$post_id = $row->ID;

			$email = get_post_meta( $post_id, 'testimonials-widget-email', true );

			if ( has_post_thumbnail( $post_id ) ) {
				$image = get_the_post_thumbnail( $post_id, $image_size );
			} elseif ( ! $hide_gravatar && is_email( $email ) ) {
				$image = get_avatar( $email, $gravatar_size );
			} else {
				$image = false;
			}

			$url = get_post_meta( $post_id, 'testimonials-widget-url', true );
			if ( ! empty( $url ) && 0 === preg_match( '#https?://#', $url ) )
				$url = 'http://' . $url;

			$data = array(
				'post_id' => $post_id,
				'testimonial_company' => get_post_meta( $post_id, 'testimonials-widget-company', true ),
				'testimonial_content' => $row->post_content,
				'testimonial_email' => $email,
				'testimonial_extra' => '',
				'testimonial_image' => $image,
				'testimonial_location' => get_post_meta( $post_id, 'testimonials-widget-location', true ),
				'testimonial_source' => $row->post_title,
				'testimonial_title' => get_post_meta( $post_id, 'testimonials-widget-title', true ),
				'testimonial_url' => $url,
			);

			$testimonial_data[] = $data;
		}

		$testimonial_data = apply_filters( 'testimonials_widget_data', $testimonial_data, $atts );

		return $testimonial_data;
	}


	public function posts_results_sort_none( $posts, $query ) {
		$order = $query->query_vars['post__in'];
		if ( empty( $order ) )
			return $posts;

		$posts_none_sorted = array();
		// put posts in same orders as post__in
		foreach ( $order as $id ) {
			foreach ( $posts as $key => $post ) {
				if ( $id == $post->ID ) {
					$posts_none_sorted[] = $post;
					unset( $posts[$key] );
				}
			}
		}

		return $posts_none_sorted;
	}


	public function widgets_init() {
		require_once 'lib/class-testimonials-widget-widget.php';

		register_widget( 'Testimonials_Widget_Widget' );
	}


	/**
	 *
	 *
	 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
	 */
	public function add_meta_box_testimonials_widget() {
		require_once 'lib/class-redrokk-metabox-class.php';

		$fields = array(
			array(
				'name' => esc_html__( 'Job Title', 'testimonials-widget' ),
				'id' => 'testimonials-widget-title',
				'type' => 'text',
				'desc' => '',
			),
			array(
				'name' => esc_html__( 'Location', 'testimonials-widget' ),
				'id' => 'testimonials-widget-location',
				'type' => 'text',
				'desc' => '',
			),
			array(
				'name' => esc_html__( 'Email', 'testimonials-widget' ),
				'id' => 'testimonials-widget-email',
				'type' => 'text',
				'desc' => '',
			),
			array(
				'name' => esc_html__( 'Company', 'testimonials-widget' ),
				'id' => 'testimonials-widget-company',
				'type' => 'text',
				'desc' => '',
			),
			array(
				'name' => esc_html__( 'URL', 'testimonials-widget' ),
				'id' => 'testimonials-widget-url',
				'type' => 'text',
				'desc' => '',
			),
		);

		$fields = apply_filters( 'testimonials_widget_meta_box', $fields );

		$meta_box = redrokk_metabox_class::getInstance(
			self::OLD_NAME,
			array(
				'title' => esc_html__( 'Testimonial Data', 'testimonials-widget' ),
				'description' => '',
				'_object_types' => 'testimonials-widget',
				'priority' => 'high',
				'_fields' => $fields,
			)
		);
	}


	/**
	 * Revise default new testimonial text
	 *
	 * Original author: Travis Ballard http://www.travisballard.com
	 *
	 * @param string  $translation
	 * @return string $translation
	 */
	public function gettext_testimonials( $translation ) {
		remove_action( 'gettext', array( $this, 'gettext_testimonials' ) );

		global $post;

		if ( is_object( $post ) && self::PT == $post->post_type ) {
			switch ( $translation ) {
			case esc_html__( 'Enter title here', 'testimonials-widget' ):
				return esc_html__( 'Enter testimonial source here', 'testimonials-widget' );
				break;
			}
		}

		add_action( 'gettext', array( $this, 'gettext_testimonials' ) );

		return $translation;
	}


	/**
	 * Update messages for custom post type
	 *
	 * Original author: Travis Ballard http://www.travisballard.com
	 *
	 * @SuppressWarnings(PHPMD.Superglobals)
	 * @param mixed   $m
	 * @return mixed $m
	 */
	public function post_updated_messages( $m ) {
		global $post;

		$m[ self::PT ] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __( 'Testimonial updated. <a href="%s">View testimonial</a>', 'testimonials-widget' ), esc_url( get_permalink( $post->ID ) ) ),
			2 => esc_html__( 'Custom field updated.', 'testimonials-widget' ),
			3 => esc_html__( 'Custom field deleted.', 'testimonials-widget' ),
			4 => esc_html__( 'Testimonial updated.', 'testimonials-widget' ),
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Testimonial restored to revision from %s', 'testimonials-widget' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __( 'Testimonial published. <a href="%s">View testimonial</a>', 'testimonials-widget' ), esc_url( get_permalink( $post->ID ) ) ),
			7 => esc_html__( 'Testimonial saved.', 'testimonials-widget' ),
			8 => sprintf( __( 'Testimonial submitted. <a target="_blank" href="%s">Preview testimonial</a>', 'testimonials-widget' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) ),
			9 => sprintf( __( 'Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview testimonial</a>', 'testimonials-widget' ), date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) ), esc_url( get_permalink( $post->ID ) ) ),
			10 => sprintf( __( 'Testimonial draft updated. <a target="_blank" href="%s">Preview testimonial</a>', 'testimonials-widget' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) )
		);

		return $m;
	}


	public function right_now_content_table_end() {
		$content = '
			<tr>
				<td class="first b b-%1$s">%4$s%2$s%5$s</td>
				<td class="t %1$s">%4$s%3$s%5$s</td>
			</tr>';
		$posts   = wp_count_posts( Testimonials_Widget::PT );
		$count   = $posts->publish;
		$name    = _n( 'Testimonial', 'Testimonials', $count, 'testimonials-widget' );
		$count_f = number_format_i18n( $count );
		$a_open  = '<a href="edit.php?post_type=' . Testimonials_Widget::PT . '">';
		$a_close = '</a>';

		if ( current_user_can( 'edit_others_posts' ) )
			$result = sprintf( $content, Testimonials_Widget::PT, $count_f, $name, $a_open, $a_close );
		else
			$result = sprintf( $content, Testimonials_Widget::PT, $count_f, $name, '', '' );

		echo $result;
	}


}


add_action( 'plugins_loaded', 'testimonialswidget_init', 99 );


/**
 *
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
function testimonialswidget_init() {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( is_plugin_active( Testimonials_Widget::PLUGIN_FILE ) ) {
		require_once 'lib/class-testimonials-widget-settings.php';
		global $Testimonials_Widget_Settings;
		if ( is_null( $Testimonials_Widget_Settings ) )
			$Testimonials_Widget_Settings = new Testimonials_Widget_Settings();

		global $Testimonials_Widget;
		if ( is_null( $Testimonials_Widget ) )
			$Testimonials_Widget = new Testimonials_Widget();
	}
}


register_activation_hook( __FILE__, array( 'Testimonials_Widget', 'activation' ) );
register_deactivation_hook( __FILE__, array( 'Testimonials_Widget', 'deactivation' ) );
register_uninstall_hook( __FILE__, array( 'Testimonials_Widget', 'uninstall' ) );


function testimonialswidget_list( $atts = array() ) {
	global $Testimonials_Widget;

	return $Testimonials_Widget->testimonialswidget_list( $atts );
}


function testimonialswidget_widget( $atts = array(), $widget_number = null ) {
	global $Testimonials_Widget;

	return $Testimonials_Widget->testimonialswidget_widget( $atts, $widget_number );
}


?>
