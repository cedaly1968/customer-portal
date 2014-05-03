<?php

//remove buttons for editor
//todelete?
//remove_all_filters( 'mce_external_plugins' );


if(isset($_POST['upd_sets1'])) {
    update_option("hub_template",$_POST['hub_template']);
    echo '<div id="message" class="updated fade"><p> '. __( 'Settings updated Successfully.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';
}

if(isset($_POST['upd_sets2'])) {
    update_option("client_template",$_POST['client_template']);
    echo '<div id="message" class="updated fade"><p>' . __( 'Settings updated Successfully.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';

}

if ( isset( $_POST['upd_sets3']) ) {
    update_option('sender_name',$_POST['sender_name']);
    update_option('sender_email',$_POST['sender_email']);
    update_option('wpc_reply_email',$_POST['reply_email']);

    $wpc_templates = get_option( 'wpc_templates' );
    $wpc_templates['emails'] = $_POST['wpc_templates']['emails'];
    update_option( 'wpc_templates', $wpc_templates );

    //do_action( "wp_settings_update", $_POST['settings );
    echo '<div id="message" class="updated fade"><p>' . __( 'Settings updated Successfully.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';
}

if( isset($_POST['wpc_action']) && $_POST['wpc_action'] == 'reset_to_default' && isset($_POST['code']) && !empty($_POST['code'])) {
    $template_name = $_POST['code'];
    $templates_data = get_option( 'wpc_templates' );
    $templates_data['wpc_shortcodes'][$template_name] = file_get_contents( $this->plugin_dir . 'includes/templates/' . $template_name . '.tpl' );
    update_option('wpc_templates', $templates_data);

    do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_templates&set_tab=' . $_POST['set_tab'] );
    exit;
}

//feedback wizard
if ( defined( 'WPC_CLIENT_ADDON_FEEDBACK_WIZARD' ) ) {
    if ( isset( $_POST['update_fbw']) ) {
        update_option( 'wpc_fbw_templates', $_POST['wpc_fbw_templates'] );

        echo '<div id="message" class="updated fade"><p>' . __( 'Settings updated Successfully.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';
    }
}




$wpc_templates      = get_option( 'wpc_templates' );

$hub_template       = get_option("hub_template");
$client_template    = get_option("client_template");

$hub_template       = html_entity_decode($hub_template);
$client_template    = html_entity_decode($client_template);

$sender_name        = get_option("sender_name");
$sender_email       = get_option("sender_email");
$reply_email        = get_option("wpc_reply_email");

?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

<style type="text/css">
    .wp-editor-container {
        background-color: #fff;
    }

    input[type="text"]{
        width: 780px!important;
    }
    .clear{
        clear: both;
        height: 0;
        visibility: hidden;
        display: block;
    }
    a{
        text-decoration: none;
    }
    /******* GENERAL RESET *******/

    /******* MENU *******/
    #container23{

        width: 99%;
    }
    #container23 ul{
        list-style: none;
        list-style-position: outside;
    }
    #container23 ul.menu li{
        float: left;
        margin-right: 5px;
        margin-bottom: -1px;
    }
    #container23 ul.menu li{
        font-weight: 700;
        display: block;
        padding: 5px 10px 5px 10px;
        background: #efefef;
        margin-bottom: -1px;
        border: 1px solid #d0ccc9;
        border-width: 1px 1px 1px 1px;
        position: relative;
        color: #898989;
        cursor: pointer;
    }
    #container23 ul.menu li.active{
        background: #fff;
        top: 1px;
        border-bottom: 0;
        color: #5f95ef;
    }
    /******* /MENU *******/
    /******* CONTENT *******/
    .content23{
        margin: 0pt auto;
        background: #efefef;
        background: #fff;
        border: 1px solid #d0ccc9;
        text-align: left;
        padding: 10px;
        padding-bottom: 20px;
        font-size: 11px;
    }
    .content23 h1{
        line-height: 1em;
        vertical-align: middle;
        height: 48px;
        padding: 10px 10px 10px 52px;
        font-size: 32px;
    }
    /******* /CONTENT *******/
    /******* NEWS *******/
    .content23.news h1{
        background: transparent url(images/news.jpg) no-repeat scroll left top;
    }
    .content23.news{
        display: block;
    }
    /******* /NEWS *******/
    /******* TUTORIALS *******/
    .content23.tutorials h1{
        background: transparent url(images/tuts.jpg) no-repeat scroll left top;
    }
    .content23.tutorials{
        display: none;
    }
    /******* /TUTORIALS *******/
    /******* LINKS *******/
    .content23.links h1{
        background: transparent url(images/links.jpg) no-repeat scroll left top;
    }
    .content23.links{
        display: none;
    }

    .content23.links a{
        color: #5f95ef;
    }
    /******* /LINKS *******/
    /******* Feedback Wizard *******/
    .content23.fbw_tempaltes h1{
        background: transparent no-repeat scroll left top;
    }
    .content23.fbw_tempaltes{
        display: none;
    }
    .content23.fbw_tempaltes a{
        color: #5f95ef;
    }
    .other {
        display: none;
    }
    #tabs, #email_tabs {
        width: 100%;
        border: 0 !important;
    }
    #tabs ul, #email_tabs ul {
        padding-right: 5px;
        background: #ccc;
    }
    #tabs > div, #email_tabs > div {
        float: left;
        padding-top: 0px;
        padding-right: 8px;
/*        width: 83%;*/
    }
    .ui-tabs-vertical { width: 55em; }
    .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 17em; }
    .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
    .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
    .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
    .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 68em;}
    .ui-tabs .ui-tabs-hide {display: none;}

    /******* /LINKS *******/
</style>
<script type="text/javascript" language="javascript">
    var site_url = '<?php echo site_url();?>';

    jQuery(document).ready(function(){
        jQuery(".menu > li").click(function(e){
            switch(e.target.id){
                case "news":
                    //change status & style menu
                    jQuery(".menu li").removeClass("active");
                    jQuery("#news").addClass("active");
                    jQuery("#tutorials").removeClass("active");
                    jQuery("#links").removeClass("active");
                    jQuery("#fbw_tempaltes").removeClass("active");
                    //display selected division, hide others
                    jQuery("div.content23").css("display", "none");
                    jQuery("div.news").fadeIn();
                    /*jQuery("div.tutorials").css("display", "none");
                    jQuery("div.links").css("display", "none");
                    jQuery("div.fbw_tempaltes").css("display", "none"); */
                break;
                case "tutorials":
                    //change status & style menu
                    jQuery(".menu li").removeClass("active");
                    jQuery("#news").removeClass("active");
                    jQuery("#tutorials").addClass("active");
                    jQuery("#links").removeClass("active");
                    jQuery("#fbw_tempaltes").removeClass("active");
                    //display selected division, hide others
                    jQuery("div.content23").css("display", "none");
                    jQuery("div.tutorials").fadeIn();
                    /*jQuery("div.news").css("display", "none");
                    jQuery("div.links").css("display", "none");
                    jQuery("div.fbw_tempaltes").css("display", "none"); */
                break;
                case "links":
                    //change status & style menu
                    jQuery(".menu li").removeClass("active");
                    jQuery("#news").removeClass("active");
                    jQuery("#tutorials").removeClass("active");
                    jQuery("#links").addClass("active");
                    jQuery("#fbw_tempaltes").removeClass("active");
                    //display selected division, hide others
                    jQuery("div.content23").css("display", "none");
                    jQuery("div.links").fadeIn();
                    /*jQuery("div.news").css("display", "none");
                    jQuery("div.tutorials").css("display", "none");
                    jQuery("div.fbw_tempaltes").css("display", "none"); */
                break;
                case "other":
                    //change status & style menu
                    jQuery(".menu li").removeClass("active");
                    jQuery(this).addClass("active");
                    //display selected division, hide others
                    /*if(jQuery(this).parent().hasClass('submenu')) {
                        jQuery("div.content24").css("display", "none");
                    } else {
                        jQuery(".submenu li:first").addClass('active');*/
                        jQuery("div.content23").css("display", "none");
                    //}
                    jQuery("div."+jQuery(this).attr('id')).fadeIn();
                break;
                case "fbw_tempaltes":
                    //change status & style menu
                    jQuery(".menu li").removeClass("active");
                    jQuery("#news").removeClass("active");
                    jQuery("#tutorials").removeClass("active");
                    jQuery("#links").removeClass("active");
                    jQuery("#fbw_tempaltes").addClass("active");
                    //display selected division, hide others
                    jQuery("div.content23").css("display", "none");
                    jQuery("div.fbw_tempaltes").fadeIn();
                    /*jQuery("div.news").css("display", "none");
                    jQuery("div.tutorials").css("display", "none");
                    jQuery("div.links").css("display", "none");  */
                break;
            }
            //alert(e.target.id);
            return false;
        });

        jQuery( "#tabs" ).tabs({ selected : <?php echo ( (isset( $_GET['set_tab'] ) && is_numeric( $_GET['set_tab'] ) ? $_GET['set_tab'] : 0 ) ) ?> }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
        jQuery( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

        jQuery( "#email_tabs" ).tabs({ selected : <?php echo ( (isset( $_GET['set_tab'] ) && is_numeric( $_GET['set_tab'] ) ? $_GET['set_tab'] : 0 ) ) ?> }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
        jQuery( "#email_tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

        jQuery(".submit_email").click(function() {
            var name    = jQuery(this).attr('name');
            var id      = jQuery(this).attr('name')+"_body";

            //get content from editor
            if ( jQuery( '#wp-' + id + '-wrap' ).hasClass( 'tmce-active' ) ) {
                var content = tinyMCE.activeEditor.getContent();
            } else {
                var content = jQuery( '#' + id ).val();

            }

            var subject = jQuery( '#' + jQuery(this).attr('name') + '_subject' ).val();

            jQuery("#ajax_result_"+name).html('');
            jQuery("#ajax_result_"+name).show();
            jQuery("#ajax_result_"+name).css('display', 'inline');
            jQuery("#ajax_result_"+name).html('<div class="wpc_ajax_loading"></div>');
            var crypt_content    = jQuery.base64Encode( content );
            crypt_content        = crypt_content.replace(/\+/g, "-");

            var crypt_subject    = jQuery.base64Encode( subject );
            crypt_subject        = crypt_subject.replace(/\+/g, "-");
            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=wpc_save_template&wpc_templates[emails][" + name.replace( 'wpc_', '' ) + "][subject]=" + crypt_subject + "&wpc_templates[emails][" + name.replace( 'wpc_', '' ) + "][body]=" + crypt_content,
                dataType: "json",
                success: function(data){
                    if(data.status) {
                        jQuery("#ajax_result_"+name).css('color', 'green');
                    } else {
                        jQuery("#ajax_result_"+name).css('color', 'red');
                    }
                    jQuery("#ajax_result_"+name).html(data.message);
                    setTimeout(function() {
                        jQuery("#ajax_result_"+name).fadeOut(1500);
                    }, 2500);
                },
                error: function(data) {
                    jQuery("#ajax_result_"+name).css('color', 'red');
                    jQuery("#ajax_result_"+name).html('Unknown error.');
                    setTimeout(function() {
                        jQuery("#ajax_result_"+name).fadeOut(1500);
                    }, 2500);
                }
            });
        });


        jQuery(".submit").click(function() {
            var name = jQuery(this).attr('name');
            var id = jQuery(this).attr('name')+"_editor";

            //get content from editor
            if ( jQuery( '#wp-' + id + '-wrap' ).hasClass( 'tmce-active' ) ) {
                var content = tinyMCE.activeEditor.getContent();
            } else {
                var content = jQuery('#' + id ).val();
            }
            jQuery("#ajax_result_"+name).html('');
            jQuery("#ajax_result_"+name).show();
            jQuery("#ajax_result_"+name).css('display', 'inline');
            jQuery("#ajax_result_"+name).html('<div class="wpc_ajax_loading"></div>');
            var crypt_content    = jQuery.base64Encode( content );
            crypt_content        = crypt_content.replace(/\+/g, "-");
            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=wpc_save_template&wpc_templates[wpc_shortcodes]["+name+"]=" + crypt_content,
                dataType: "json",
                success: function(data){
                    if(data.status) {
                        jQuery("#ajax_result_"+name).css('color', 'green');
                    } else {
                        jQuery("#ajax_result_"+name).css('color', 'red');
                    }
                    jQuery("#ajax_result_"+name).html(data.message);
                    setTimeout(function() {
                        jQuery("#ajax_result_"+name).fadeOut(1500);
                    }, 2500);
                },
                error: function(data) {
                    jQuery("#ajax_result_"+name).css('color', 'red');
                    jQuery("#ajax_result_"+name).html('Unknown error.');
                    setTimeout(function() {
                        jQuery("#ajax_result_"+name).fadeOut(1500);
                    }, 2500);
                }
            });
        });

        <?php if ( isset( $_GET['set_tab'] ) && '' != $_GET['set_tab'] ) { ?>
            jQuery("#other").trigger('click');
        <?php } ?>

    });

    function reset_form(code, set_tab) {
        jQuery("#code").val(code);
        jQuery("#set_tab").val(set_tab);
        jQuery("#other_tab_form").submit();
    }

</script>

<?php echo $this->get_plugin_logo_block() ?>

<div class="clear"></div>

<div id="container23">

    <ul class="menu">
        <li id="news" class="active"><?php _e( 'Hub Page Templates', WPC_CLIENT_TEXT_DOMAIN ) ?></li>
        <li id="tutorials"><?php _e( 'Portal Page Templates', WPC_CLIENT_TEXT_DOMAIN ) ?></li>
        <li id="links"><?php _e( 'Email Templates', WPC_CLIENT_TEXT_DOMAIN ) ?></li>
        <li id="other"><?php _e( 'Shortcode Templates', WPC_CLIENT_TEXT_DOMAIN ) ?></li>

        <?php
            //feedback wizard tab
            if ( defined( 'WPC_CLIENT_ADDON_FEEDBACK_WIZARD' ) ) {
                echo '<li id="fbw_tempaltes">' . __( 'Feedback Wizard Templates', WPC_CLIENT_TEXT_DOMAIN ) . '</li>';
            }
        ?>

    </ul>
    <span class="clear"></span>

    <div class="content23 news">
        <!-- HUB PAGE TEMPLATES -->
        <style type="text/css">
        .wrap input[type=text] {
            width:400px;
        }
        .wrap input[type=password] {
            width:400px;
        }
        </style>

        <div class='wrap'>
            <div class="icon32" id="icon-link-manager"></div>
            <h2><?php _e( 'Hub Page Template', WPC_CLIENT_TEXT_DOMAIN ) ?></h2>
            <p><?php _e( 'From here you can edit the template of the newly created hub pages.', WPC_CLIENT_TEXT_DOMAIN ) ?></p>

            <form action="" method="post">
                <div style="float: left;">
                    <label for="hub_template">
                       <b><?php _e( 'New hub page template', WPC_CLIENT_TEXT_DOMAIN ) ?>: </b>
                    </label>
                </div>

                <div class="clear"></div>

                <?php wp_editor( stripslashes( $hub_template ), 'hub_template', array( 'wpautop' => false ) ); ?>
                <br />

                <input type='submit' name='upd_sets1' id="upd_sets1" class='button-primary' value='<?php _e( 'Update', WPC_CLIENT_TEXT_DOMAIN ) ?>' />
            </form>
        </div>
        <!--END HUB PAGE TEMPLATES -->
    </div>


    <div class="content23 tutorials">

        <div class='wrap'>
            <div class="icon32" id="icon-link-manager"></div>
            <h2><?php _e( 'Portal Page Template', WPC_CLIENT_TEXT_DOMAIN ) ?></h2>
            <p><?php _e( 'From here you can edit the template of the newly created Portal Pages.', WPC_CLIENT_TEXT_DOMAIN ) ?></p>

            <form action="" method="post">
                <div style="float: left;">
                    <label for="hub_template">
                       <b><?php _e( 'New Portal Page template', WPC_CLIENT_TEXT_DOMAIN ) ?>: </b>
                    </label>
                </div>

                <div class="clear"></div>

                <?php wp_editor( stripslashes( $client_template ), 'client_template', array( 'wpautop' => false ) ); ?>
                <br />

                <input type='submit' name='upd_sets2' id="upd_sets2" class='button-primary' value='<?php _e( 'Update', WPC_CLIENT_TEXT_DOMAIN ) ?>' />
            </form>
        </div>
    </div>


    <div class="content23 links">

        <div class='wrap'>
            <div class="icon32" id="icon-link-manager"></div>
            <h2><?php _e( 'WP Client Emails Settings', WPC_CLIENT_TEXT_DOMAIN ) ?></h2>
            <p><?php _e( 'From here you can edit the emails templates and settings.', WPC_CLIENT_TEXT_DOMAIN ) ?></p>

       </div>

            <form action="" method="post">
                <div class="postbox">
                    <h3 class='hndle'><span><?php _e( 'Sender Information', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                    <div class="inside">
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label for="sender_name"><?php _e( 'Sender Name', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                </th>
                                <td>
                                    <input type="text" name="sender_name" id="sender_name" value="<?php echo $sender_name; ?>" />
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="sender_email"><?php _e( 'Sender Email', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                </th>
                                <td>
                                    <input type="text" name="sender_email" id="sender_email" value="<?php echo $sender_email; ?>" />
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="reply_email"><?php _e( 'Reply to Email', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                </th>
                                <td>
                                    <input type="text" name="reply_email" id="reply_email" value="<?php echo $reply_email; ?>" />
                                </td>
                            </tr>
                        </table>
                        <input type='submit' name='upd_sets3' id="upd_sets3" class='button-primary' value='<?php _e( 'Update', WPC_CLIENT_TEXT_DOMAIN ) ?>' />
                    </div>
                </div>

                <div id="email_tabs">
                    <ul>
                        <li><a href="#wpc_new_client_password"><?php _e( 'New Client Created', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_client_updated"><?php _e( 'Client Password Updated', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_new_client_registered"><?php _e( 'New Client Registers', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_account_is_approved"><?php _e( 'Client Account is approved', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_staff_created"><?php _e( 'Staff Created', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_staff_registered"><?php _e( 'Staff Registered', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_manager_created"><?php _e( 'Manager Created', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_client_page_updated"><?php _e( 'Portal Page Updated', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_new_file_for_client_staff"><?php _e( 'Admin uploads new file', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_client_uploaded_file"><?php _e( 'Client Uploads new file', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_notify_client_about_message"><?php _e( 'PM: Notify To Client', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                        <li><a href="#wpc_notify_admin_about_message"><?php _e( 'PM: Notify To Admin/Manager', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    </ul>

                    <div id="wpc_new_client_password">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'New Client Created by Admin', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Client (if "Send Password" is checked)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_new_client_password_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" size="50" name="wpc_templates[emails][new_client_password][subject]" id="wpc_new_client_password_subject" value="<?php echo stripslashes( $wpc_templates['emails']['new_client_password']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_new_client_password_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['new_client_password']['body'] ), 'wpc_new_client_password_body', array( 'textarea_name' => 'wpc_templates[emails][new_client_password][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_new_client_password" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_new_client_password" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_client_updated">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Client Password Updated', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Client (if "Send Password" is checked)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_client_updated_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][client_updated][subject]" id="wpc_client_updated_subject" value="<?php echo stripslashes( $wpc_templates['emails']['client_updated']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_client_updated_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['client_updated']['body'] ), 'wpc_client_updated_body', array( 'textarea_name' => 'wpc_templates[emails][client_updated][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_client_updated" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_client_updated" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_new_client_registered">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'New Client registers using Self-Registration Form', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Admin after a new Client registers with client registration form', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_new_client_registered_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][new_client_registered][subject]" id="wpc_new_client_registered_subject" value="<?php echo stripslashes( $wpc_templates['emails']['new_client_registered']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_new_client_registered_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['new_client_registered']['body'] ), 'wpc_new_client_registered_body', array( 'textarea_name' => 'wpc_templates[emails][new_client_registered][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{site_title} and {approve_url} will not be change as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_new_client_registered" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_new_client_registered" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_account_is_approved">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Client Account is approved', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Client after their account will approved (if "Send approval email" is checked).', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_account_is_approved_d_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][account_is_approved][subject]" id="wpc_account_is_approved_d_subject" value="<?php echo stripslashes( $wpc_templates['emails']['account_is_approved']['subject'] ) ?>" />
                                             <br>
                                            <span class="description"><?php _e( '{site_title} and {contact_name} will not be changed as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_account_is_approved_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['account_is_approved']['body'] ), 'wpc_account_is_approved_body', array( 'textarea_name' => 'wpc_templates[emails][account_is_approved][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{site_title}, {contact_name} and {login_url} will not be change as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_account_is_approved" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_account_is_approved" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_staff_created">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Staff Created by website Admin', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Staff (if "Send Password" is checked)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_staff_created_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][staff_created][subject]" id="wpc_staff_created_subject" value="<?php echo stripslashes( $wpc_templates['emails']['staff_created']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_staff_created_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['staff_created']['body'] ), 'wpc_staff_created_body', array( 'textarea_name' => 'wpc_templates[emails][staff_created][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{contact_name}, {user_name}, {password} and {admin_url} will not be changed as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_staff_created" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_staff_created" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_staff_registered">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Staff Registered by Client', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Staff after Client registered him (if "Send Password" is checked)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_staff_registered_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][staff_registered][subject]" id="wpc_staff_registered_subject" value="<?php echo stripslashes( $wpc_templates['emails']['staff_registered']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_staff_registered_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['staff_registered']['body'] ), 'wpc_staff_registered_body', array( 'textarea_name' => 'wpc_templates[emails][staff_registered][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{contact_name}, {user_name}, {password} and {admin_url} will not be changed as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_staff_registered" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_staff_registered" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_manager_created">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Manager Created', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Manager (if "Send Password" is checked)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_manager_created_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][manager_created][subject]" id="wpc_manager_created_subject" value="<?php echo stripslashes( $wpc_templates['emails']['manager_created']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_manager_created_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['manager_created']['body'] ), 'wpc_manager_created_body', array( 'textarea_name' => 'wpc_templates[emails][manager_created][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{contact_name}, {user_name}, {password} and {admin_url} will not be changed as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_manager_created" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_manager_created" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_client_page_updated">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Portal Page Updated', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Client (if "Send Update to selected Client(s) is checked") when Portal Page updating', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_client_page_updated_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][client_page_updated][subject]" id="wpc_client_page_updated_subject" value="<?php echo stripslashes( $wpc_templates['emails']['client_page_updated']['subject'] ) ?>" />
                                            <br>
                                            <span class="description"><?php _e( '{contact_name}, {user_name}, {password} and {page_id} will not be changed as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_client_page_updated_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['client_page_updated']['body'] ), 'wpc_client_page_updated_body', array( 'textarea_name' => 'wpc_templates[emails][client_page_updated][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{contact_name} and {page_id} will not be change as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_client_page_updated" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_client_page_updated" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_new_file_for_client_staff">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Admin uploads new file for Client', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Client and his Staff when Admin or Manager will upload new file for Client.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_new_file_for_client_staff_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][new_file_for_client_staff][subject]" id="wpc_new_file_for_client_staff_subject" value="<?php echo stripslashes( $wpc_templates['emails']['new_file_for_client_staff']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_new_file_for_client_staff_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['new_file_for_client_staff']['body'] ), 'wpc_new_file_for_client_staff_body', array( 'textarea_name' => 'wpc_templates[emails][new_file_for_client_staff][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{site_title}, {file_name}, {file_category} and {login_url} will not be change as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_new_file_for_client_staff" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_new_file_for_client_staff" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_client_uploaded_file">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Client Uploads new file', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( "  >> This email will be sent to Admin and Client's Manager when Client will upload file(s)", WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_client_uploaded_file_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][client_uploaded_file][subject]" id="wpc_client_uploaded_file_subject" value="<?php echo stripslashes( $wpc_templates['emails']['client_uploaded_file']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_client_uploaded_file_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['client_uploaded_file']['body'] ), 'wpc_client_uploaded_file_body', array( 'textarea_name' => 'wpc_templates[emails][client_uploaded_file][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{user_name}, {site_title}, {file_name}, {file_category} and {admin_file_url} will not be change as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_client_uploaded_file" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_client_uploaded_file" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_notify_client_about_message">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Private Message: Notify Message To Client', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Client when Admin/Manager sent private message (if "Receive email notification of private messages from admin" in selected in plugin settings).', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_notify_client_about_message_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][notify_client_about_message][subject]" id="wpc_notify_client_about_message_subject" value="<?php echo stripslashes( $wpc_templates['emails']['notify_client_about_message']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_notify_client_about_message_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['notify_client_about_message']['body'] ), 'wpc_notify_client_about_message_body', array( 'textarea_name' => 'wpc_templates[emails][notify_client_about_message][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{user_name}, {site_title}, {message} and {login_url} will not be change as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_notify_client_about_message" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_notify_client_about_message" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="wpc_notify_admin_about_message">
                        <div class="postbox">
                            <h3 class="hndle"><span><?php _e( 'Private Message: Notify Message To Admin/Manager', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                            <span class="description"><?php _e( '  >> This email will be sent to Admin/Manager when Client sent private message (if "Receive email notification of private messages from clients" is selected in plugin settings).', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            <div class="inside">
                                <table class="form-table">
                                    <tbody>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_notify_admin_about_message_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <input type="text" name="wpc_templates[emails][notify_admin_about_message][subject]" id="wpc_notify_admin_about_message_subject" value="<?php echo stripslashes( $wpc_templates['emails']['notify_admin_about_message']['subject'] ) ?>" />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2">
                                            <label for="wpc_notify_admin_about_message_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                            <br>
                                            <?php wp_editor( stripslashes( $wpc_templates['emails']['notify_admin_about_message']['body'] ), 'wpc_notify_admin_about_message_body', array( 'textarea_name' => 'wpc_templates[emails][notify_admin_about_message][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false  ) ); ?>
                                            <span class="description"><?php _e( '{user_name}, {site_title}, {message} and {admin_url} will not be change as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="left">
                                            <input type="button" name="wpc_notify_admin_about_message" class="button-primary submit_email" value="Update" />
                                            <div id="ajax_result_wpc_notify_admin_about_message" style="display: inline;"></div>
                                        </td>
                                        <td valign="middle" align="right">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </form>

    </div>

    <div class="content23 other">
        <form action="" method="post" id="other_tab_form">
            <input type="hidden" name="wpc_action" value="reset_to_default" />
            <input type="hidden" name="set_tab" id="set_tab" value="" />
            <input type="hidden" name="code" id="code" value="" />
            <div id="tabs">
                <ul>
                    <li><a href="#wpc_client_pagel"><?php _e( 'List of Client Portals', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_client_fileslu"><?php _e( 'Files Client Have Uploaded', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_client_filesla"><?php _e( 'Files Client Have Access To', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_client_com"><?php _e( 'Private Messages', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_client_registration_form"><?php _e( 'Client Registration', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_client_registration_successful"><?php _e( 'Registration Successful', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_client_loginf"><?php _e( 'Login Form', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_client_logoutb"><?php _e( 'Logout Link', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                </ul>
                <div id="wpc_client_pagel">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'List of Client Portals', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for [wpc_client_pagel] shortcode', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <span class="description"><?php _e( 'Advanced users only should attempt changes here. Please only edit html, and don\'t change anything inside curly brackets {}', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <span class="description"><?php _e( '-- If you run into a problem, then please click "Reset to default" button at bottom right', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <br>
                                        <?php
                                            if ( !( isset($wpc_templates['wpc_shortcodes']['wpc_client_pagel']) && !empty($wpc_templates['wpc_shortcodes']['wpc_client_pagel']) ) ) {
                                                global $wpc_client;
                                                if ( file_exists($wpc_client->plugin_dir . 'includes/templates/wpc_client_pagel.tpl') ) {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_pagel'] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_pagel.tpl' );
                                                } else {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_pagel'] = '';
                                                }
                                            }
                                        ?>
                                        <?php wp_editor( stripslashes( $wpc_templates['wpc_shortcodes']['wpc_client_pagel'] ), 'wpc_client_pagel_editor', array( 'textarea_name' => 'wpc_templates[wpc_shortcodes][wpc_client_pagel][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false ) ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_client_pagel" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_client_pagel" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('wpc_client_pagel', 0);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="wpc_client_fileslu">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Files Client Have Uploaded', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for [wpc_client_fileslu] shortcode', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <span class="description"><?php _e( 'Advanced users only should attempt changes here. Please only edit html, and don\'t change anything inside curly brackets {}', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <span class="description"><?php _e( '-- If you run into a problem, then please click "Reset to default" button at bottom right', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <br>
                                        <?php
                                            if( !( isset($wpc_templates['wpc_shortcodes']['wpc_client_fileslu']) && !empty($wpc_templates['wpc_shortcodes']['wpc_client_fileslu']) ) ) {
                                                global $wpc_client;
                                                if( file_exists($wpc_client->plugin_dir . 'includes/templates/wpc_client_fileslu.tpl') ) {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_fileslu'] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_fileslu.tpl' );
                                                } else {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_fileslu'] = '';
                                                }
                                            }
                                        ?>
                                        <?php wp_editor( stripslashes( $wpc_templates['wpc_shortcodes']['wpc_client_fileslu'] ), 'wpc_client_fileslu_editor', array( 'textarea_name' => 'wpc_templates[wpc_shortcodes][wpc_client_fileslu][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false ) ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_client_fileslu" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_client_fileslu" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('wpc_client_fileslu', 1);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="wpc_client_filesla">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Files Client Have Access To', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for [wpc_client_filesla] shortcode', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <span class="description"><?php _e( 'Advanced users only should attempt changes here. Please only edit html, and don\'t change anything inside curly brackets {}', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <span class="description"><?php _e( '-- If you run into a problem, then please click "Reset to default" button at bottom right', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <br>
                                        <?php
                                            if( !( isset($wpc_templates['wpc_shortcodes']['wpc_client_filesla']) && !empty($wpc_templates['wpc_shortcodes']['wpc_client_filesla']) ) ) {
                                                global $wpc_client;
                                                if( file_exists($wpc_client->plugin_dir . 'includes/templates/wpc_client_filesla.tpl') ) {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_filesla'] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_filesla.tpl' );
                                                } else {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_filesla'] = '';
                                                }
                                            }
                                        ?>
                                        <?php wp_editor( stripslashes( $wpc_templates['wpc_shortcodes']['wpc_client_filesla'] ), 'wpc_client_filesla_editor', array( 'textarea_name' => 'wpc_templates[wpc_shortcodes][wpc_client_filesla][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false ) ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_client_filesla" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_client_filesla" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('wpc_client_filesla', 2);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_client_com">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Private Messages', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for [wpc_client_com] shortcode', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <span class="description"><?php _e( 'Advanced users only should attempt changes here. Please only edit html, and don\'t change anything inside curly brackets {}', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <span class="description"><?php _e( '-- If you run into a problem, then please click "Reset to default" button at bottom right', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <br>
                                        <?php
                                            if( !( isset($wpc_templates['wpc_shortcodes']['wpc_client_com']) && !empty($wpc_templates['wpc_shortcodes']['wpc_client_com']) ) ) {
                                                global $wpc_client;
                                                if( file_exists($wpc_client->plugin_dir . 'includes/templates/wpc_client_com.tpl') ) {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_com'] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_com.tpl' );
                                                } else {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_com'] = '';
                                                }
                                            }
                                        ?>
                                        <?php wp_editor( stripslashes( $wpc_templates['wpc_shortcodes']['wpc_client_com'] ), 'wpc_client_com_editor', array( 'textarea_name' => 'wpc_templates[wpc_shortcodes][wpc_client_com][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false  ) ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_client_com" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_client_com" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('wpc_client_com', 3);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_client_registration_form">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Client Registration', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for [wpc_client_registration_form] shortcode', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <span class="description"><?php _e( 'Advanced users only should attempt changes here. Please only edit html, and don\'t change anything inside curly brackets {}', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <span class="description"><?php _e( '-- If you run into a problem, then please click "Reset to default" button at bottom right', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <br>
                                        <?php
                                            if( !( isset($wpc_templates['wpc_shortcodes']['wpc_client_registration_form']) && !empty($wpc_templates['wpc_shortcodes']['wpc_client_registration_form']) ) ) {
                                                global $wpc_client;
                                                if( file_exists($wpc_client->plugin_dir . 'includes/templates/wpc_client_registration_form.tpl') ) {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_registration_form'] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_registration_form.tpl' );
                                                } else {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_registration_form'] = '';
                                                }
                                            }
                                        ?>
                                        <?php wp_editor( stripslashes( $wpc_templates['wpc_shortcodes']['wpc_client_registration_form'] ), 'wpc_client_registration_form_editor', array( 'textarea_name' => 'wpc_templates[wpc_shortcodes][wpc_client_registration_form][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false  ) ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_client_registration_form" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_client_registration_form" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('wpc_client_registration_form', 4);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_client_registration_successful">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Registration Successful', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for [wpc_client_registration_successful] shortcode', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <span class="description"><?php _e( 'Advanced users only should attempt changes here. Please only edit html, and don\'t change anything inside curly brackets {}', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <span class="description"><?php _e( '-- If you run into a problem, then please click "Reset to default" button at bottom right', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <br>
                                        <?php
                                            if( !( isset($wpc_templates['wpc_shortcodes']['wpc_client_registration_successful']) && !empty($wpc_templates['wpc_shortcodes']['wpc_client_registration_successful']) ) ) {
                                                global $wpc_client;
                                                if( file_exists($wpc_client->plugin_dir . 'includes/templates/wpc_client_registration_successful.tpl') ) {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_registration_successful'] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_registration_successful.tpl' );
                                                } else {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_registration_successful'] = '';
                                                }
                                            }
                                        ?>
                                        <?php wp_editor( stripslashes( $wpc_templates['wpc_shortcodes']['wpc_client_registration_successful'] ), 'wpc_client_registration_successful_editor', array( 'textarea_name' => 'wpc_templates[wpc_shortcodes][wpc_client_registration_successful][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false  ) ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_client_registration_successful" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_client_registration_successful" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('wpc_client_registration_successful', 5);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_client_loginf">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Login Form', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for [wpc_client_loginf] shortcode', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <span class="description"><?php _e( 'Advanced users only should attempt changes here. Please only edit html, and don\'t change anything inside curly brackets {}', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <span class="description"><?php _e( '-- If you run into a problem, then please click "Reset to default" button at bottom right', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <br>
                                        <?php
                                            if( !( isset($wpc_templates['wpc_shortcodes']['wpc_client_loginf']) && !empty($wpc_templates['wpc_shortcodes']['wpc_client_loginf']) ) ) {
                                                global $wpc_client;
                                                if( file_exists($wpc_client->plugin_dir . 'includes/templates/wpc_client_loginf.tpl') ) {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_loginf'] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_loginf.tpl' );
                                                } else {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_loginf'] = '';
                                                }
                                            }
                                        ?>
                                        <?php wp_editor( stripslashes( $wpc_templates['wpc_shortcodes']['wpc_client_loginf'] ), 'wpc_client_loginf_editor', array( 'textarea_name' => 'wpc_templates[wpc_shortcodes][wpc_client_loginf][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false  ) ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_client_loginf" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_client_loginf" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('wpc_client_loginf', 6);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_client_logoutb">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Logout Link', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for [wpc_client_logoutb] shortcode', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <span class="description"><?php _e( 'Advanced users only should attempt changes here. Please only edit html, and don\'t change anything inside curly brackets {}', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <span class="description"><?php _e( '-- If you run into a problem, then please click "Reset to default" button at bottom right', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                        <br>
                                        <br>
                                        <?php
                                            if( !( isset($wpc_templates['wpc_shortcodes']['wpc_client_logoutb']) && !empty($wpc_templates['wpc_shortcodes']['wpc_client_logoutb']) ) ) {
                                                global $wpc_client;
                                                if( file_exists($wpc_client->plugin_dir . 'includes/templates/wpc_client_logoutb.tpl') ) {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_logoutb'] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_logoutb.tpl' );
                                                } else {
                                                    $wpc_templates['wpc_shortcodes']['wpc_client_logoutb'] = '';
                                                }
                                            }
                                        ?>
                                        <?php wp_editor( stripslashes( $wpc_templates['wpc_shortcodes']['wpc_client_logoutb'] ), 'wpc_client_logoutb_editor', array( 'textarea_name' => 'wpc_templates[wpc_shortcodes][wpc_client_logoutb][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false  ) ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_client_logoutb" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_client_logoutb" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('wpc_client_logoutb', 7);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </form>
    </div>


<?php
   //feedback wizard
   if ( defined( 'WPC_CLIENT_ADDON_FEEDBACK_WIZARD' ) ) {
       $wpc_fbw_templates = get_option( 'wpc_fbw_templates' );
?>

    <div class="content23 fbw_tempaltes">

        <div class='wrap'>
            <div class="icon32" id="icon-link-manager"></div>
            <h2><?php _e( 'Feedback Wizard Template', WPC_CLIENT_TEXT_DOMAIN ) ?></h2>
            <p><?php _e( 'From here you can edit the template of Feedback Wizard', WPC_CLIENT_TEXT_DOMAIN ) ?></p>

            <form action="" method="post">

                <div class="postbox">
                    <h3 class='hndle'><span><?php _e( 'Email: Send Client Notification', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                    <span class="description"><?php _e( '  >> This email will be sent Clients when Admin click on "Send Email to Client(s)" on Wizards page.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                    <div class="inside">
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpc_fbw_templates_wizard_notify_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                </th>
                                <td>
                                    <input type="text" name="wpc_fbw_templates[emails][wizard_notify][subject]" id="wpc_fbw_templates_wizard_notify_subject" value="<?php echo $wpc_fbw_templates['emails']['wizard_notify']['subject']; ?>" />
                                    <br>
                                    <span class="description"><?php _e( '{wizard_name} will not be changed as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row">
                                    <label for="wpc_wizard_notify_body"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                </th>
                                <td>
                                    <?php wp_editor( stripslashes( $wpc_fbw_templates['emails']['wizard_notify']['body'] ), 'wpc_wizard_notify_body', array( 'textarea_name' => 'wpc_fbw_templates[emails][wizard_notify][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                    <span class="description"><?php _e( '{user_name} and {wizard_url} will not be change as these placeholders will be used in the email.', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <input type='submit' name='update_fbw' id="update_fbw" class='button-primary' value='<?php _e( 'Update', WPC_CLIENT_TEXT_DOMAIN ) ?>' />
            </form>
        </div>
    </div>

<?php
   }
?>






</div>