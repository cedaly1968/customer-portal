<?php
global $wpdb, $wpc_client;

//Save items
if ( isset( $_POST['item'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'wpc_inv_items' ) ) {
    $errors = $this->save_items( $_POST['item'] );
}

//Delete items
if ( isset( $_REQUEST['wpc_action'] ) && 'delete_inv_item' == $_REQUEST['wpc_action'] && isset( $_REQUEST['item_id'] ) ) {
    $this->delete_items( $_REQUEST['item_id'] );
}

$inv_settings    = $this->get_settings();
$currency_symbol = array(
    'left'  => ( isset( $inv_settings['preferences']['currency_symbol'] )
        && ( !isset( $inv_settings['preferences']['currency_symbol_align'] )
        || 'left' == $inv_settings['preferences']['currency_symbol_align'] ) )
        ? $inv_settings['preferences']['currency_symbol'] : '',
    'right' => ( isset( $inv_settings['preferences']['currency_symbol'] )
        && isset( $inv_settings['preferences']['currency_symbol_align'] )
        && 'right' == $inv_settings['preferences']['currency_symbol_align'] )
        ? $inv_settings['preferences']['currency_symbol'] : '',
);

$wpnonce = wp_create_nonce( 'wpc_inv_items' );

$items = $this->get_items();

?>

<div class='wrap'>

    <?php echo $wpc_client->get_plugin_logo_block() ?>

    <div class="clear"></div>
    <?php
    if ( isset( $_GET['msg'] ) && '' != $_GET['msg'] ) {
        switch( $_GET['msg'] ) {
            case 's':
                echo '<div id="message" class="updated fade"><p>' . __( 'Item is <strong>Saved</strong>.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';
                break;
            case 'd':
                echo '<div id="message" class="updated fade"><p>' . __( 'Item(s) <strong>Deleted</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN ) . '</p></div>';
                break;
        }
    }
    ?>

    <div id="container23">
        <ul class="menu">
            <?php echo $this->gen_tabs_menu() ?>
        </ul>
        <span class="clear"></span>

        <div class="content23 news">

            <div id="message" class="updated fade" <?php echo ( empty( $errors ) )? 'style="display: none;" ' : '' ?> ><?php echo $errors; ?></div>


            <br>
            <div>
                <a rel="" href="#edit_item" class="add-new-h2 various"><?php _e( 'Add New Item', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
            </div>

            <hr />

            <form method="post" name="items_form" id="items_form">
                <input type="hidden" value="<?php echo $wpnonce ?>" name="_wpnonce" id="_wpnonce" />
                <input type="hidden" value="" name="wpc_action" id="wpc_action" />

                <table cellspacing="0" class="wp-list-table widefat media">
                    <thead>
                        <tr>
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col">
                                <input type="checkbox">
                            </th>
                            <th style="width: 230px;" class="manage-column column-title sortable desc" id="title" scope="col">
                                <span><?php _e( 'Item Name', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Description', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="width: 100px;" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Rate', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col">
                                <input type="checkbox">
                            </th>
                            <th style="" class="manage-column column-title sortable desc" id="title" scope="col">
                                <span><?php _e( 'Item Name', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Description', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Rate', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                        </tr>
                    </tfoot>

                    <tbody id="the-list">
                    <?php
                    if ( is_array( $items ) && 0 < count( $items ) ):
                        foreach( $items as $item ):
                    ?>
                     <tr valign="top" id="post-11" class="alternate author-other status-inherit">
                            <th scope="row" class="check-column">
                                <input type="checkbox" name="item_id[]" value="<?php echo $item['id'] ?>">
                            </th>
                            <td class="title column-title">
                                <strong>
                                     <span id="item_name_block_<?php echo $item['id'] ?>"><?php echo $item['name'] ?></span>
                                </strong>
                                <div class="row-actions">
                                        <span class="edit"><a class="various" href="#edit_item" title="" rel="<?php echo $item['id'] ?>" ><?php _e( 'Edit', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                        <span class="delete"><a class="submitdelete" onclick="return showNotice.warn();" href="admin.php?page=wpclients_invoicing&tab=invoicing_items&wpc_action=delete_inv_item&item_id=<?php echo $item['id']  ?>&_wpnonce=<?php echo $wpnonce ?>"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></a> </span>
                                </div>
                            </td>
                            <td class="author column-author">
                                <?php echo isset( $item['description'] ) ? $item['description'] : '' ?>
                                <input type="hidden" id="item_description_block_<?php echo $item['id'] ?>" value="<?php echo isset( $item['description'] ) ? $item['description'] : '' ?>" />

                            </td>
                            <td class="author column-author">
                                <?php echo $currency_symbol['left'] ?><span id="item_rate_block_<?php echo $item['id'] ?>"><?php echo isset( $item['rate'] ) ? $item['rate'] : '' ?></span><?php echo $currency_symbol['right'] ?>
                            </td>
                        </tr>

                    <?php
                        endforeach;
                    endif;
                    ?>
                    </tbody>

                </table>

                <div class="tablenav bottom">

                    <div class="alignleft actions">
                        <select name="action" id="action">
                            <option selected="selected" value="-1"><?php _e( 'Bulk Actions', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                            <option value="delete_items"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                        </select>
                        <input type="button" value="<?php _e( 'Apply', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button-secondary action" id="doaction" name="" />
                    </div>

                    <div class="alignleft actions"></div>

                    <div class="tablenav-pages one-page">
                        <div class="tablenav">
                            <div class='tablenav-pages'>
                                <?php // echo $p->show(); ?>
                            </div>
                        </div>
                    </div>

                    <br class="clear">
                </div>

            </form>


            <div class="wpc_edit_item" id="edit_item" style="display: none;">
                <h3><?php _e( 'Item:', WPC_CLIENT_TEXT_DOMAIN ) ?> <span id="edit_item"></span></h3>
                <form method="post" name="wpc_edit_item" id="wpc_edit_item">
                    <input type="hidden" value="<?php echo $wpnonce ?>" name="_wpnonce" id="_wpnonce" />
                    <input type="hidden" name="item[id]" id="item_id" value="<?php echo isset( $_POST['item']['id'] ) ? $_POST['item']['id'] : '' ?>" />
                    <table>
                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Item Name:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                    <br />
                                    <input type="text" name="item[name]" size="70" id="item_name"  value="<?php echo isset( $_POST['item']['name'] ) ? $_POST['item']['name'] : '' ?>" />

                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Description:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <br />
                                    <textarea name="item[description]" cols="67" rows="5" maxlength="300" id="item_description" ><?php echo isset( $_POST['item']['description'] ) ? $_POST['item']['description'] : '' ?></textarea>
                                </label>
                                <p style="text-align: right;">
                                    <?php _e( 'characters remaining:', WPC_CLIENT_TEXT_DOMAIN ) ?> <span id="count_chars">300</span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Rate:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                    <br />
                                    <input type="text" name="item[rate]" size="70" id="item_rate"  value="<?php echo isset( $_POST['item']['rate'] ) ? $_POST['item']['rate'] : '' ?>" />

                                </label>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <div style="clear: both; text-align: center;">
                        <input type="button" class='button-primary' id="save_item" name="save_item" value="<?php _e( 'Save Item', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                        <input type="button" class='button' id="close_edit_item" value="<?php _e( 'Close', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                    </div>
                </form>
            </div>


        </div>
    </div>


</div>



<script type="text/javascript">
    jQuery( document ).ready( function() {


        //show edit item form
        jQuery( '.various' ).click( function() {
            var limit = 300;
            var id = jQuery(this).attr('rel');

            jQuery( '#item_id' ).val( '' );
            jQuery( '#item_name' ).val( '' );
            jQuery( '#item_description' ).val( '' );
            jQuery( '#item_rate' ).val( '' );
            jQuery( '#count_chars' ).html( limit );

            //show content for edit file
            jQuery( '.various' ).fancybox({
                fitToView   : false,
                autoSize    : true,
                closeClick  : false,
                openEffect  : 'none',
                closeEffect : 'none'
            });

            if ( '' != id ) {


                var item_name = jQuery( '#item_name_block_' + id ).html();
                item_name = item_name.replace( /(^\s+)|(\s+$)/g, "" );

                var item_description = jQuery( '#item_description_block_' + id ).val();
                item_description = item_description.replace( 'Description: ', '' );

                //check if there are more characters then allowed
                if ( item_description.length > limit ){
                    //and if there are use substr to get the text before the limit
                    item_description = item_description.substr( 0, limit );

                }
                jQuery( '#count_chars' ).html( ( limit - item_description.length ) );


                var item_rate = jQuery( '#item_rate_block_' + id ).html();
                item_rate = item_rate.replace( /(^\s+)|(\s+$)/g, "" );

                jQuery( '#item_id' ).val( id );
                jQuery( '#item_name' ).val( item_name );
                jQuery( '#item_description' ).val( item_description );
                jQuery( '#item_rate' ).val( item_rate );

            }

        });

        //Save item
        jQuery( '#save_item' ).click( function() {
            var errors = 0;

            if ( '' == jQuery( "#item_name" ).val() ) {
                jQuery( '#item_name' ).parent().parent().attr( 'class', 'wpc_error' );
                errors = 1;
            } else {
                jQuery( '#item_name' ).parent().parent().attr( 'class', '' );
            }

            if ( '' == jQuery( "#item_rate" ).val() ) {
                jQuery( '#item_rate' ).parent().parent().attr( 'class', 'wpc_error' );
                errors = 1;
            } else {
                jQuery( '#item_rate' ).parent().parent().attr( 'class', '' );
            }

            if ( 0 == errors ) {
                jQuery( '#wpc_edit_item' ).submit();
            }

            return false;

        });

        //close edit item
        jQuery( '#close_edit_item' ).click( function() {
            jQuery( '#item_id' ).val( '' );
            jQuery( '#item_name' ).val( '' );
            jQuery( '#item_description' ).val( '' );
            jQuery( '#item_rate' ).val( '' );
            jQuery.fancybox.close();
        });

        //delete items from Bulk Actions
        jQuery( '#doaction' ).click( function() {
            if ( 'delete_items' == jQuery( '#action' ).val() ) {
                jQuery( '#wpc_action' ).val( 'delete_inv_item' );
                jQuery( '#items_form' ).submit();
            }
            return false;
        });



        //set maxlength
        jQuery('textarea[maxlength]').keyup(function(){
            //get the limit from maxlength attribute
            var limit = parseInt( jQuery( this ).attr( 'maxlength' ) );
            //get the current text inside the textarea
            var text = jQuery( this ).val();
            //count the number of characters in the text
            var chars = text.length;

            //check if there are more characters then allowed
            if ( chars > limit ){
                //and if there are use substr to get the text before the limit
                var new_text = text.substr( 0, limit );

                //and change the current text with the new text
                jQuery( this ).val( new_text );
            }
            jQuery( '#count_chars' ).html( ( limit - text.length ) );

        });






    });
</script>