<?php
// Added Demo Landing on Install
add_action('init', 'inbound_create_default_post_type');
function inbound_create_default_post_type(){
    // NEED to insert custom meta as well
    $option_name = "lp_settings_general";
    $option_key = "default_landing_page";
    $current_user = wp_get_current_user();
    add_option( $option_name, '' );
    //update_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice', 0 ); // Clean dismiss settings
    //delete_option( 'lp_settings_general' );
    $lp_default_options = get_option($option_name);
    // Create Default if it doesn't exist
    if ( ! isset( $lp_default_options[$option_key] ) ) {
        $default_lander = wp_insert_post(
                array(
                    'post_title'     => 'A/B Testing Landing Page Example',
                    'post_content'   => '<p>This is the first paragraph of your landing page where you want to draw the viewer in and quickly explain your value proposition.</p><p><strong>Use Bullet Points to:</strong><ul><li>Explain why they should fill out the form</li><li>What they will learn if they download</li><li>A problem this form will solve for them</li></ul></p><p>Short ending paragraph reiterating the value behind the form</p>',
                    'post_status'    => 'publish',
                    'post_author'    => $current_user->ID,
                    'post_type'      => 'landing-page',
                    'comment_status' => 'closed'
                )
            ); 
        // Variation A
        add_post_meta($default_lander, 'lp-main-headline', 'Main Catchy Headline (A)');
        add_post_meta($default_lander, 'lp-selected-template', 'svtle');
        add_post_meta($default_lander, 'lp-conversion-area', '<h2>Form A</h2><form action="" method="post">First Name: <input name="first-name" type="text" /><br>Last Name: <input name="last-name" type="text" /><br>Email:<input name="email" type="text" /><br><input name="submit" type="submit" value="Submit" /></form>');
        // Varaition B
        add_post_meta($default_lander, 'lp-main-headline-1', 'Main Catchy Headline Two (B)');
        add_post_meta($default_lander, 'lp-selected-template-1', 'svtle');
        add_post_meta($default_lander, 'landing-page-myeditor-1', '<h2>Form B</h2><form action="" method="post">First Name: <input name="first-name" type="text" /><br>Last Name: <input name="last-name" type="text" /><br>Email:<input name="email" type="text" /><br><input name="submit" type="submit" value="Submit" /></form>');
        add_post_meta($default_lander, 'content-1', '<p>(Version B) This is the first paragraph of your landing page where you want to draw the viewer in and quickly explain your value proposition.</p><p><strong>Use Bullet Points to:</strong><ul><li>Explain why they should fill out the form</li><li>What they will learn if they download</li><li>A problem this form will solve for them</li></ul></p><p>Short ending paragraph reiterating the value behind the form</p>');
        
        // Add A/B Testing meta
        add_post_meta($default_lander, 'lp-ab-variations', '0,1');
        add_post_meta($default_lander, 'lp-ab-variation-impressions-0', 30);
        add_post_meta($default_lander, 'lp-ab-variation-impressions-1', 35);
        add_post_meta($default_lander, 'lp-ab-variation-conversions-0', 10);
        add_post_meta($default_lander, 'lp-ab-variation-conversions-1', 15);
        // Add template meta A
        add_post_meta($default_lander, 'svtle-submit-button-color', '5baa1e');
        add_post_meta($default_lander, 'svtle-display-social', '0');
        add_post_meta($default_lander, 'svtle-logo', '/wp-content/plugins/landing-pages/templates/svtle/assets/images/inbound-logo.png');
        add_post_meta($default_lander, 'svtle-body-color', 'ffffff');
        add_post_meta($default_lander, 'svtle-sidebar', 'left');
        add_post_meta($default_lander, 'svtle-page-text-color', '4d4d4d');
        add_post_meta($default_lander, 'svtle-sidebar-color', 'ffffff');
        add_post_meta($default_lander, 'svtle-sidebar-text-color', '000000');
        add_post_meta($default_lander, 'svtle-header-color', 'ffffff');
        // Add template meta B
        add_post_meta($default_lander, 'svtle-submit-button-color-1', 'ff0c00');
        add_post_meta($default_lander, 'svtle-display-social-1', '0');
        add_post_meta($default_lander, 'svtle-logo-1', '/wp-content/plugins/landing-pages/templates/svtle/assets/images/inbound-logo.png');
        add_post_meta($default_lander, 'svtle-body-color-1', '51b0ef');
        add_post_meta($default_lander, 'svtle-sidebar-1', 'left');
        add_post_meta($default_lander, 'svtle-page-text-color-1', '000000');
        add_post_meta($default_lander, 'svtle-sidebar-color-1', '51b0ef');
        add_post_meta($default_lander, 'svtle-sidebar-text-color-1', '000000');
        add_post_meta($default_lander, 'svtle-header-color-1', '51b0ef');

        // Store our page IDs
        $options = array(
            $option_key => $default_lander
        );

        update_option( $option_name, $options );        
    }
}

/**
 * Debug Activation errors */
//update_option('plugin_error',  ''); //clear
/*
add_action('activated_plugin','activation_save_error');

function activation_save_error(){
    update_option('plugin_error',  ob_get_contents());
}*/
//echo "Errors:" . get_option('plugin_error');

/**
 * Include the TGM_Plugin_Activation class.
 */

require_once(LANDINGPAGES_PATH."/libraries/class-tgm-plugin-activation.php");
add_action( 'tgmpa_register', 'lp_install_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function lp_install_register_required_plugins() {
 
    /**
     * Array of plugin arrays. Required keys are name, slug and required.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
 
        // This is an example of how to include a plugin pre-packaged with a theme
      /*  array(
            'name'                  => 'TGM Example Plugin', // The plugin name
            'slug'                  => 'tgm-example-plugin', // The plugin slug (typically the folder name)
            'source'                => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ), */
 
        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      => 'WordPress Leads <span style=\'color:red !important; display:block;\'>This free landing page addon will give you the ability to track and manage incoming web leads. Gather Lead Intelligence on all Leads and Close more deals. <a href=\'http://wordpress.org/plugins/leads/\'> Learn more about WordPress Leads.</a></span>',
            'slug'      => 'leads',
            'required'  => false,
        ),
       /* array(
            'name'      => 'WordPress Leads <span style=\'color:red !important; display:block;\'>This free landing page addon will give you the ability to manage leads, see the pages viewed by the lead before converting, geolocation data, and much more. <a href=\'http://wordpress.org/plugins/leads/\'> Learn more about WordPress Leads.</a></span>',
            'slug'      => 'title-split-testing-for-wordpress',
            'required'  => false,
        ),*/
 
    );
 
    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'tgmpa';
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'            => $theme_text_domain,           // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                           // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
        'parent_url_slug'   => 'themes.php',         // Default parent URL slug
        'menu'              => 'install-required-plugins',   // Menu slug
        'has_notices'       => true,                         // Show admin notices or not
        'is_automatic'      => false,            // Automatically activate plugins after installation or not
        'message'           => '',               // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => __( 'Install Required Plugins', $theme_text_domain ),
            'menu_title'                                => __( 'Install Plugins', $theme_text_domain ),
            'installing'                                => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
            'oops'                                      => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
            'notice_can_install_required'               => _n_noop( 'WordPress Landing Pages requires the following plugin: %1$s', 'WordPress Landing Pages highly requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'WordPress Landing Pages highly recommends the following plugin: %1$s', 'WordPress Landing Pages highly recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s', 'The following required plugins are currently inactive: %1$s' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s', 'The following recommended plugins are currently inactive: %1$s' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                    => __( 'Return to Required Plugins Installer', $theme_text_domain ),
            'plugin_activated'                          => __( 'Plugin activated successfully.', $theme_text_domain ),
            'complete'                                  => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ),
             // %1$s = dashboard link
        )
    );
 
    tgmpa( $plugins, $config );
 
}