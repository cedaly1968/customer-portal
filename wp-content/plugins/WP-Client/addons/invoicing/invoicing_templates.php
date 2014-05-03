<?php
global $wpc_client;

if( isset($_POST['wpc_action']) && $_POST['wpc_action'] == 'reset_to_default' && isset($_POST['code']) && !empty($_POST['code'])) {
    $template_name = $_POST['code'];
    $inv_settings   = $this->get_settings();
    $inv_settings['templates'][$template_name] = file_get_contents( $wpc_client->plugin_dir . 'includes/templates/wpc_client_inv_' . $template_name . '.tpl' );
    $this->save_settings( $inv_settings );

    do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_invoicing&tab=invoicing_templates&set_tab=' . $_POST['set_tab'] );
    exit;
}


$inv_settings   = $this->get_settings();
$templates  = $inv_settings['templates'];

$error = "";

$placeholders_list = '
    {site_title}, {client_name}, {login_url},
    {business_logo_url}, {business_name}, {business_address},
    {business_mailing_address}, {business_website},
    {business_email}, {business_phone}, {business_fax}';

?>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />

<style type="text/css">

    input[type="text"]{
        width: 778px!important;
    }

    #tabs {
        width: 100%;
        border: 0 !important;
    }
    #tabs ul {
        padding-right: 5px;
        background: #ccc;
    }
    #tabs > div {
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

        jQuery( "#tabs" ).tabs({ selected : <?php echo ( (isset( $_GET['set_tab'] ) && is_numeric( $_GET['set_tab'] ) ? $_GET['set_tab']:0 ) ) ?> }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
        jQuery( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

        jQuery(".submit").click(function() {
            var name    = jQuery(this).attr('name');
            var id      = jQuery(this).attr('name')+"_editor";

            //get content from editor
            if ( jQuery( '#wp-' + id + '-wrap' ).hasClass( 'tmce-active' ) ) {
                var content = tinyMCE.activeEditor.getContent();
            } else {
                var content = jQuery('#' + id ).val();
            }

            var crypt_content    = jQuery.base64Encode( content );
            crypt_content        = crypt_content.replace(/\+/g, "-");

            //get subject if exist
            if ( jQuery( '#' + name + '_subject' ).length ) {
                var subject = jQuery( '#' + name + '_subject' ).val();
                subject     = jQuery.base64Encode( subject );
                subject     = subject.replace(/\+/g, "-");
                var vars    = "&wpc_inv_templates[templates][" + name.replace( 'wpc_', '' ) + "][body]=" + crypt_content + "&wpc_inv_templates[templates][" + name.replace( 'wpc_', '' ) + "][subject]=" + subject
            } else {
                var vars = "&wpc_inv_templates[templates][" + name.replace( 'wpc_', '' ) + "]=" + crypt_content;
            }

            jQuery("#ajax_result_"+name).html('');
            jQuery("#ajax_result_"+name).show();
            jQuery("#ajax_result_"+name).css('display', 'inline');
            jQuery("#ajax_result_"+name).html('<div class="wpc_ajax_loading"></div>');

            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=wpc_save_template" + vars,
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

    });


    function reset_form(code, set_tab) {
        jQuery("#code").val(code);
        jQuery("#set_tab").val(set_tab);
        jQuery("#other_tab_form").submit();
    }


</script>


<?php echo $wpc_client->get_plugin_logo_block() ?>

<div class="clear"></div>

<div id="container23">
    <ul class="menu">
        <?php echo $this->gen_tabs_menu() ?>
    </ul>
    <span class="clear"></span>

    <div class="content23 other">
        <form action="" method="post" id="other_tab_form">
            <input type="hidden" name="wpc_action" value="reset_to_default" />
            <input type="hidden" name="set_tab" id="set_tab" value="" />
            <input type="hidden" name="code" id="code" value="" />
            <div id="tabs">

                <ul>
                    <li><a href="#wpc_inv_not"><?php _e( 'Invoice Notification', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_est_not"><?php _e( 'Estimate Notification', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_pay_tha"><?php _e( 'Payment Thank-You', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_admin_notify"><?php _e( 'Notify Admin of Payment', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_pay_rem"><?php _e( 'Payment Reminders', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_ter_con"><?php _e( 'Terms & Conditions', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_not_cus"><?php _e( 'Note to Customer', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_inv"><?php _e( 'Invoice Template', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>
                    <li><a href="#wpc_est"><?php _e( 'Estimate Template', WPC_CLIENT_TEXT_DOMAIN ) ?></a></li>

                </ul>


                <div id="wpc_inv_not">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Email: Invoice Notification', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for notifying the client(s) that they have a new Invoice', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tr valign="top">
                                <td>
                                    <label for="wpc_inv_templates_inv_not_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                <br />
                                    <input type="text" name="wpc_inv_templates[inv_not][subject]" id="wpc_inv_not_subject" value="<?php echo stripslashes( $templates['inv_not']['subject'] ) ?>" />
                                </td>
                            </tr>

                            <tr valign="top">
                                <td>
                                    <label for="wpc_inv_not_editor"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                    <br />
                                    <?php wp_editor( stripslashes( $templates['inv_not']['body'] ), 'wpc_inv_not_editor', array( 'textarea_name' => 'wpc_inv_templates[inv_not][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                    <span class="description">
                                        <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                        <?php echo $placeholders_list ?>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td valign="middle" align="left">
                                    <input type="button" name="wpc_inv_not" class="button-primary submit" value="Update" />
                                    <div id="ajax_result_wpc_inv_not" style="display: inline;"></div>
                                </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_est_not">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Email: Estimate Notification', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for notifying the client(s) that they have a new Estimate', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tr valign="top">
                                <td>
                                    <label for="wpc_inv_templates_est_not_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                <br />
                                    <input type="text" name="wpc_inv_templates[est_not][subject]" id="wpc_est_not_subject" value="<?php echo stripslashes( $templates['est_not']['subject'] ) ?>" />
                                </td>
                            </tr>

                            <tr valign="top">
                                <td>
                                    <label for="wpc_est_not_editor"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                    <br />
                                    <?php wp_editor( stripslashes( $templates['est_not']['body'] ), 'wpc_est_not_editor', array( 'textarea_name' => 'wpc_inv_templates[est_not][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                    <span class="description">
                                        <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                        <?php echo $placeholders_list ?>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td valign="middle" align="left">
                                    <input type="button" name="wpc_est_not" class="button-primary submit" value="Update" />
                                    <div id="ajax_result_wpc_est_not" style="display: inline;"></div>
                                </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_pay_tha">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Email: Payment Thank-You', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for sending the client(s) a thank you for payment', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tr valign="top">
                                <td>
                                    <label for="wpc_inv_templates_pay_tha_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                <br />
                                    <input type="text" name="wpc_inv_templates[pay_tha][subject]" id="wpc_pay_tha_subject" value="<?php echo stripslashes( $templates['pay_tha']['subject'] ) ?>" />
                                </td>
                            </tr>

                            <tr valign="top">
                                <td>
                                    <label for="wpc_pay_tha_editor"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                    <br />
                                    <?php wp_editor( stripslashes( $templates['pay_tha']['body'] ), 'wpc_pay_tha_editor', array( 'textarea_name' => 'wpc_inv_templates[pay_tha][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                    <span class="description">
                                        <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                        <?php echo $placeholders_list ?>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td valign="middle" align="left">
                                    <input type="button" name="wpc_pay_tha" class="button-primary submit" value="Update" />
                                    <div id="ajax_result_wpc_pay_tha" style="display: inline;"></div>
                                </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_admin_notify">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Email: Notify Admin of Payment', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for notifying the admin of successful online payment', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tr valign="top">
                                <td>
                                    <label for="wpc_inv_templates_admin_notify_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                <br />
                                    <input type="text" name="wpc_inv_templates[admin_notify][subject]" id="wpc_admin_notify_subject" value="<?php echo stripslashes( $templates['admin_notify']['subject'] ) ?>" />
                                </td>
                            </tr>

                            <tr valign="top">
                                <td>
                                    <label for="wpc_admin_notify_editor"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                    <br />
                                    <?php wp_editor( stripslashes( $templates['admin_notify']['body'] ), 'wpc_admin_notify_editor', array( 'textarea_name' => 'wpc_inv_templates[admin_notify][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                   <span class="description">
                                        <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                        <?php echo $placeholders_list ?>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td valign="middle" align="left">
                                    <input type="button" name="wpc_admin_notify" class="button-primary submit" value="Update" />
                                    <div id="ajax_result_wpc_admin_notify" style="display: inline;"></div>
                                </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_pay_rem">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Email: Payment Reminders', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for notifying the client(s) of overdue invoices', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tr valign="top">
                                <td>
                                    <label for="wpc_inv_templates_pay_rem_subject"><?php _e( 'Email Subject', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                <br />
                                    <input type="text" name="wpc_inv_templates[pay_rem][subject]" id="wpc_pay_rem_subject" value="<?php echo stripslashes( $templates['pay_rem']['subject'] ) ?>" />
                                </td>
                            </tr>

                            <tr valign="top">
                                <td>
                                    <label for="wpc_pay_rem_editor"><?php _e( 'Email Body', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                    <br />
                                    <?php wp_editor( stripslashes( $templates['pay_rem']['body'] ), 'wpc_pay_rem_editor', array( 'textarea_name' => 'wpc_inv_templates[pay_rem][body]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                    <span class="description">
                                        <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                        <?php echo $placeholders_list ?>
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td valign="middle" align="left">
                                    <input type="button" name="wpc_pay_rem" class="button-primary submit" value="Update" />
                                    <div id="ajax_result_wpc_pay_rem" style="display: inline;"></div>
                                </td>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>


                <div id="wpc_ter_con">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Terms & Conditions', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for use in the Estimates/Invoices - will be pre-loaded with this content', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td>
                                        <?php wp_editor( stripslashes( $templates['ter_con'] ), 'wpc_ter_con_editor', array( 'textarea_name' => 'wpc_inv_templates[ter_con]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                        <span class="description">
                                            <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                            <?php echo $placeholders_list ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_ter_con" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_ter_con" style="display: inline;"></div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_not_cus">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Note to Customer', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for use in the Estimates/Invoices - will be pre-loaded with this content', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td>
                                        <?php wp_editor( stripslashes( $templates['not_cus'] ), 'wpc_not_cus_editor', array( 'textarea_name' => 'wpc_inv_templates[not_cus]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false ) ); ?>
                                        <span class="description">
                                            <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                            <?php echo $placeholders_list ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_not_cus" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_not_cus" style="display: inline;"></div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_inv">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Invoice Template', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for use in generating an Invoice - will be created in this format', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <?php wp_editor( stripslashes( $templates['inv'] ), 'wpc_inv_editor', array( 'textarea_name' => 'wpc_inv_templates[inv]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false  ) ); ?>
                                        <span class="description">
                                            <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                            <?php echo $placeholders_list ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_inv" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_inv" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('inv', 7);" name="" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="wpc_est">
                    <div class="postbox">
                        <h3 class="hndle"><span><?php _e( 'Estimate Template', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                        <span class="description"><?php _e( '  >> This template for use in generating an Estimate- will be created in this format', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                        <div class="inside">
                            <table class="form-table">
                                <tbody>
                                <tr valign="top">
                                    <td colspan="2">
                                        <?php wp_editor( stripslashes( $templates['est'] ), 'wpc_est_editor', array( 'textarea_name' => 'wpc_inv_templates[est]', 'textarea_rows' => 15, 'wpautop' => false, 'media_buttons' => false, 'tinymce' => false  ) ); ?>
                                        <span class="description">
                                            <?php _e( 'Placeholders', WPC_CLIENT_TEXT_DOMAIN ) ?>:
                                            <?php echo $placeholders_list ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left">
                                        <input type="button" name="wpc_est" class="button-primary submit" value="Update" />
                                        <div id="ajax_result_wpc_est" style="display: inline;"></div>
                                    </td>
                                    <td valign="middle" align="right">
                                        <input type="button" value="<?php _e( 'Reset to default', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" onclick="reset_form('est', 8);" name="" />
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

</div>