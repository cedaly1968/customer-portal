<?php
global $wpc_client, $wpc_gateway_plugins;

//save tax
if ( isset( $_POST['tax'] ) ) {
    $this->save_tax();
}

//delete tax
if ( isset( $_REQUEST['action'] ) && 'delete_tax' == $_REQUEST['action'] ) {
    $this->delete_tax();
}

//save settings
if ( isset( $_POST['update_settings'] ) && '' != $_POST['update_settings'] ) {
    $inv_settings = $this->get_settings();
    $inv_settings['preferences']['prefix']                  = ( isset( $_POST['settings']['prefix'] ) && '' != $_POST['settings']['prefix'] ) ? $_POST['settings']['prefix'] : '';
    $inv_settings['preferences']['send_for_review']         = ( isset( $_POST['settings']['send_for_review'] ) && '1' == $_POST['settings']['send_for_review'] ) ? 1 : 0;
    $inv_settings['preferences']['notify_payment_made']     = ( isset( $_POST['settings']['notify_payment_made'] ) && '1' == $_POST['settings']['notify_payment_made'] ) ? 1 : 0;
    $inv_settings['preferences']['currency_symbol']         = $_POST['settings']['currency_symbol'];
    $inv_settings['preferences']['currency_symbol_align']   = ( isset( $_POST['settings']['currency_symbol_align'] ) ) ? $_POST['settings']['currency_symbol_align'] : 'left';
    $inv_settings['gateways'] = ( isset( $_POST['settings']['gateways'] ) ) ? $_POST['settings']['gateways'] : array();

    $this->save_settings( $inv_settings );

    do_action( 'wp_client_redirect', get_admin_url() . 'admin.php?page=wpclients_invoicing&tab=invoicing_settings&msg=u_s' );
    exit;
}


$inv_settings       = $this->get_settings();
$wpc_settings   = get_option( 'wpc_settings' );

//Set date format
if ( get_option( 'date_format' ) ) {
    $date_format = get_option( 'date_format' );
} else {
    $date_format = 'm/d/Y';
}

if ( get_option( 'time_format' ) ) {
    $time_format = get_option( 'time_format' );
} else {
    $time_format = 'g:i:s A';
}


$wpnonce_tax = wp_create_nonce( 'wpc_delete_tax' );





$error = "";

?>

<?php echo $wpc_client->get_plugin_logo_block() ?>

<?php
if ( isset( $_GET['msg'] ) ) {
    $msg = $_GET['msg'];
    switch( $msg ) {
        case 'u_s':
            echo '<div id="message" class="updated fade"><p>' . __( 'Settings <strong>updated</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';
            break;
        case 't_s':
            echo '<div id="message" class="updated fade"><p>' . __( 'Tax <strong>Saved</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';
            break;
        case 't_d':
            echo '<div id="message" class="updated fade"><p>' . __( 'Tax is <strong>deleted</strong>.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';
            break;
    }
}
?>

<div class="clear"></div>

<div id="container23">
    <ul class="menu">
        <?php echo $this->gen_tabs_menu() ?>
    </ul>
    <span class="clear"></span>
    <div class="content23 news">

        <div id="message" class="updated fade" <?php echo ( empty( $error ) )? 'style="display: none;" ' : '' ?> ><?php echo $error; ?></div>

        <h3><?php _e( 'Invoicing Settings', WPC_CLIENT_TEXT_DOMAIN ) ?>:</h3>

        <form action="" method="post" name="wpc_settings" id="wpc_settings" >
            <input type="hidden" name="key" value="login_alerts" />

            <div class="postbox">
                <h3 class='hndle'><span><?php _e( 'Preferences', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                <div class="inside">
                    <table class="form-table">

                        <tr valign="top">
                            <th scope="row">
                                <label for="prefix"><?php _e( 'Invoice/Estimate Prefix:', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                            </th>
                            <td>
                                <input type="text" name="settings[prefix]" id="prefix" value="<?php echo ( isset( $inv_settings['preferences']['prefix'] ) ) ? $inv_settings['preferences']['prefix'] : '' ?>" />
                                <span class="description"><?php _e( 'This prefix will be added to Invoice/Estimate number', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="currency_symbol"><?php _e( 'Currency Symbol:', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                            </th>
                            <td>
                                <input type="text" name="settings[currency_symbol]" id="currency_symbol" value="<?php echo ( isset( $inv_settings['preferences']['currency_symbol'] ) ) ? $inv_settings['preferences']['currency_symbol'] : '' ?>" />
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="currency_symbol_align"><?php _e( 'Display Currency Symbol:', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                            </th>
                            <td>
                                <select name="settings[currency_symbol_align]" id="currency_symbol_align">
                                    <option value="left" <?php echo ( isset( $inv_settings['preferences']['currency_symbol_align'] ) && 'left' == $inv_settings['preferences']['currency_symbol_align'] ) ? 'selected' : '' ?> ><?php _e( 'On The Left', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                    <option value="right" <?php echo ( isset( $inv_settings['preferences']['currency_symbol_align'] ) && 'right' == $inv_settings['preferences']['currency_symbol_align'] ) ? 'selected' : '' ?>><?php _e( 'On The Right', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                </select>
                                <span class="description"><span id="symbol_left"></span>10.00<span id="symbol_right"></span></span>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="send_for_review"><?php _e( 'Send Estimates/Invoices to me for Review?', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                            </th>
                            <td>
                                <select name="settings[send_for_review]" id="send_for_review" style="width: 100px;">
                                    <option value="0"><?php _e( 'No', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                    <option value="1" <?php echo ( isset( $inv_settings['preferences']['send_for_review'] ) && '1' == $inv_settings['preferences']['send_for_review'] ) ? 'selected' : '' ?> ><?php _e( 'Yes', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">
                                <label for="notify_payment_made"><?php _e( 'Notify when online payment is made', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                            </th>
                            <td>
                                <select name="settings[notify_payment_made]" id="notify_payment_made" style="width: 100px;">
                                    <option value="0"><?php _e( 'No', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                    <option value="1" <?php echo ( isset( $inv_settings['preferences']['notify_payment_made'] ) && '1' == $inv_settings['preferences']['notify_payment_made'] ) ? 'selected' : '' ?> ><?php _e( 'Yes', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label><?php _e( 'Payment Gateways', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                            </th>
                            <td>
                                <?php
                                foreach ( (array)$wpc_gateway_plugins as $code => $plugin ) {
                                    if ( isset( $wpc_settings['gateways']['allowed'] ) && in_array( $code, (array) $wpc_settings['gateways']['allowed'] ) ) {
                                        $checked = '';
                                        if ( isset( $inv_settings['gateways'] ) && in_array( $code, $inv_settings['gateways'] ) ) {
                                            $checked = 'checked';
                                        }
                                        echo '<label><input type="checkbox" name="settings[gateways][]" value="' . $code .'" ' . $checked .' /> ' . esc_attr( $plugin[1] ) . '</label><br>';
                                    }
                                }
                                ?>
                                <span class="description"><?php echo sprintf( __( 'To add or change payments gateway settings, please look in "%s"', WPC_CLIENT_TEXT_DOMAIN ), '<a href="admin.php?page=wpclients_payments&tab=payment_settings" >' . __( 'Payment Settings', WPC_CLIENT_TEXT_DOMAIN ) . '</a>' ) ?></span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <input type='submit' name='update_settings' class='button-primary' value='<?php _e( 'Update Settings', WPC_CLIENT_TEXT_DOMAIN ) ?>' />
            <br />
            <br />


            <div class="postbox">
                <h3 class='hndle'><span><?php _e( 'Taxes', WPC_CLIENT_TEXT_DOMAIN ) ?></span></h3>
                <div class="inside">


                    <input type="button" class="button" name="" id="add_tax" value="<?php _e( '+ Add Tax', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                    <br />
                    <br />

                    <table class="widefat">

                        <thead>
                            <tr>
                                <th class="manage-column column-title" id="title" scope="col">
                                    <?php _e( 'Tax Name', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </th>
                                <th class="manage-column column-title" id="title" scope="col">
                                    <?php _e( 'Tax Description', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </th>
                                <th style="text-align: center !important;" class="manage-column" id="" scope="col">
                                    <?php _e( 'Tax Rate (%)', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </th>
                                <th style="text-align: center !important;" class="manage-column" id="comments" scope="col">
                                    <?php _e( 'Actions', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th class="manage-column column-title" id="title" scope="col">
                                    <?php _e( 'Tax Name', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </th>
                                <th class="manage-column column-title" id="title" scope="col">
                                    <?php _e( 'Tax Description', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </th>
                                <th style="text-align: center !important;" class="manage-column" id="" scope="col">
                                    <?php _e( 'Tax Rate (%)', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </th>
                                <th style="text-align: center !important;" class="manage-column" id="comments" scope="col">
                                    <?php _e( 'Actions', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if ( isset( $inv_settings['taxes'] ) && 0 < count( $inv_settings['taxes'] ) ) {
                                $i = 0;
                                foreach( $inv_settings['taxes'] as $key => $tax ) {
                                    $i++;
                            ?>
                                <tr valign="top">
                                    <td><span id="tax_name_<?php echo $i ?>"><?php echo $key ?></span></td>
                                    <td><span id="tax_desc_<?php echo $i ?>"><?php echo $tax['description'] ?></span></td>
                                    <td align="center"><span id="tax_rate_<?php echo $i ?>"><?php echo $tax['rate'] ?></span></td>
                                    <td align="center">
                                      <span class="delete"><a onclick='return confirm("<?php _e( 'Are you sure to delete this Tax? ', WPC_CLIENT_TEXT_DOMAIN ) ?>");' href='admin.php?page=wpclients_invoicing&tab=invoicing_settings&action=delete_tax&_wpnonce=<?php echo $wpnonce_tex ?>&id=<?php echo $key ?>'><?php _e( 'Delete', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                      <span class="edit"><a class="various" rel="<?php echo $i ?>" href='#edit_tax'><?php _e( 'Edit', WPC_CLIENT_TEXT_DOMAIN ) ?></a></span>
                                    </td>
                                </tr>
                            <?php
                                }
                            }
                             ?>

                        </tbody>
                    </table>

                </div>
            </div>

        </form>


        <div class="wpc_edit_tax" id="edit_tax" style="display: none;">
            <h3><?php _e( 'Tax:', WPC_CLIENT_TEXT_DOMAIN ) ?> <span id="edit_file_name"></span></h3>
            <form method="post" name="wpc_edit_tax" id="wpc_edit_tax">
                <table>
                    <tr>
                        <td>
                            <label>
                                <?php _e( 'Tax Name:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                <br />
                                <input type="text" name="tax[name]" size="70" id="tax_name"  value="" />
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>
                                <?php _e( 'Tax Description:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                <br />
                                <textarea name="tax[description]" cols="67" rows="5" id="tax_description" ></textarea>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>
                                <?php _e( 'Tax Rate:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                <br />
                                <input type="text" name="tax[rate]" size="70" id="tax_rate"  value="" />
                            </label>
                        </td>
                    </tr>
                </table>
                <br />
                <div style="clear: both; text-align: center;">
                    <input type="button" class='button-primary' id="save_tax" name="save_tax" value="<?php _e( 'Save Tax', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                    <input type="button" class='button' id="close_edit_tax" value="<?php _e( 'Close', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                </div>
            </form>
        </div>

    </div>
</div>

<script type="text/javascript" language="javascript">

    jQuery(document).ready(function(){

        //change currency symbol
        jQuery( '#currency_symbol' ).change( function() {
            jQuery( this ).display_symbol();
        });

        //change display currency symbol
        jQuery( '#currency_symbol_align' ).change( function() {
            jQuery( this ).display_symbol();
        });


        //display currency symbol
        jQuery.fn.display_symbol = function () {
            var symbol = jQuery( '#currency_symbol' ).val();
            var align = jQuery( '#currency_symbol_align' ).val();

             jQuery( '#symbol_left' ).html( '' );
             jQuery( '#symbol_right' ).html( '' );

            if ( 'right' != align ) {
                align = 'left';
            }

            jQuery( '#symbol_' + align ).html( symbol );

        };

        jQuery( this ).display_symbol();



        //open Add Tax
        jQuery( '#add_tax' ).click( function() {
            jQuery.fancybox({
                'type'        : 'inline',
                'fitToView'   : 'false',
                'autoSize'    : 'true',
                'openEffect'  : 'none',
                'closeEffect' : 'none',
                'href'        : '#edit_tax'
            });
        });


        //show edit Tax form
        jQuery( '.various' ).click( function() {
            var id = jQuery(this).attr('rel');

            //show content for edit file
            jQuery( '.various' ).fancybox({
                fitToView   : false,
                autoSize    : true,
                closeClick  : false,
                openEffect  : 'none',
                closeEffect : 'none'
            });

            var tax_name        = jQuery( '#tax_name_' + id ).html();
            var tax_description = jQuery( '#tax_desc_' + id ).html();
            var tax_rate        = jQuery( '#tax_rate_' + id ).html();

            jQuery( '#tax_name' ).val( tax_name );
            jQuery( '#tax_description' ).val( tax_description );
            jQuery( '#tax_rate' ).val( tax_rate );

        });


        //Save Tax
        jQuery( '#save_tax' ).click( function() {
            jQuery( '#wpc_edit_tax' ).submit();
        });


        //close edit Tax
        jQuery( '#close_edit_tax' ).click( function() {
            jQuery( '#tax_name' ).val( '' );
            jQuery( '#tax_description' ).val( '' );
            jQuery( '#tax_rate' ).val( '' );
            jQuery.fancybox.close();
        });

    });

</script>