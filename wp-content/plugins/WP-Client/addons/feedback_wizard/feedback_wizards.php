<?php
global $wpdb, $wpc_client;

// delete wizard
if ( isset( $_REQUEST['wpc_action'] ) && 'delete_wizard' == $_REQUEST['wpc_action'] && wp_verify_nonce( $_REQUEST['_wpnonce'], 'wpc_wizard_form' ) && isset( $_REQUEST['wizard_id'] ) ) {

    $wizard_ids = ( is_array( $_REQUEST['wizard_id'] ) ) ? $_REQUEST['wizard_id'] : (array) $_REQUEST['wizard_id'];
    foreach ( $wizard_ids as $wizard_id) {
        //delete wizard_id
        $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}wpc_client_feedback_wizards WHERE wizard_id = %d", $wizard_id ) );

        //delete items from wizard
        $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}wpc_client_feedback_wizard_items WHERE wizard_id = %d", $wizard_id ) );
    }

    do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_feedback_wizard&tab=wizards&msg=d' );
    exit;
}

//send emails to clients
if ( isset( $_REQUEST['wpc_action'] ) && 'send_wizard' == $_REQUEST['wpc_action'] && wp_verify_nonce( $_REQUEST['_wpnonce'], 'wpc_wizard_form' ) && isset( $_REQUEST['wizard_id'] ) ) {
    $wizard_id = ( isset( $_REQUEST['wizard_id'] ) ) ? $_REQUEST['wizard_id'] : 0;
    if ( 0 < $wizard_id ) {
        $wizard_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpc_client_feedback_wizards WHERE wizard_id = %d", $wizard_id ), ARRAY_A );

        $send_client_ids = array();
        //get clients id
        if ( '' != $wizard_data['clients_id'] ) {
            $send_client_ids = explode( ',', str_replace( '#', '', $wizard_data['clients_id'] ) );
        }

        //get clients id from Client Circles
        if ( '' != $wizard_data['groups_id'] ) {
            $send_group_ids = explode( ',', str_replace( '#', '', $wizard_data['groups_id'] ) );
            if ( is_array( $send_group_ids ) )
                foreach( $send_group_ids as $group_id )
                    $send_client_ids = array_merge( $send_client_ids, $wpc_client->get_group_clients_id( $group_id ) );

            $send_client_ids = array_unique( $send_client_ids );
        }


        //send email
        if ( is_array( $send_client_ids ) && 0 < count( $send_client_ids ) ) {

            //get email template
            $wpc_fbw_templates = get_option( 'wpc_fbw_templates' );

            $sender_name    = get_option("sender_name");
            $sender_email   = get_option("sender_email");

            $headers = "From: " . get_option("sender_name") . " <" . get_option("sender_email") . "> \r\n";
            $headers .= "Reply-To: " . ( get_option( 'wpc_reply_email' ) ) ? get_option( 'wpc_reply_email' ) : get_option( 'admin_email' ) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $send1 = 0;
            $send2 = 0;
            foreach( $send_client_ids as $send_client_id ) {
                if ( '' != $send_client_id ) {
                    //there are any assigned clients
                    $send1 = 1;

                    //check if client not left feedback for this version
                    $sql = "SELECT result_id FROM {$wpdb->prefix}wpc_client_feedback_results WHERE wizard_id = %d AND client_id = %d AND wizard_version = '%s' ";
                    $result_id = $wpdb->get_var( $wpdb->prepare( $sql, $wizard_data['wizard_id'], $send_client_id, $wizard_data['version'] ) );
                    if ( empty( $result_id ) || 0 > $result_id  ) {
                        //there are any clients for leave feedback
                        $send2 = 1;

                        $args = array( 'client_id' => $send_client_id, 'wizard_name' => $wizard_data['name'], 'wizard_url' => wpc_client_get_slug( 'feedback_wizard_page_id' ) . $wizard_data['wizard_id'] . '/' );
                        $subject = $wpc_client->replace_placeholders( $wpc_fbw_templates['emails']['wizard_notify']['subject'], $args, 'wizard_notify' );
                        $subject = htmlentities( $subject, ENT_QUOTES, 'UTF-8' );
                        $message = $wpc_client->replace_placeholders( $wpc_fbw_templates['emails']['wizard_notify']['body'], $args, 'wizard_notify' );

                        $client_email = get_userdata( $send_client_id )->get( 'user_email' );
                        //send email to client
                        wp_mail( $client_email, $subject, $message, $headers );
                    }
                }
            }

            if ( 0 == $send1 && 0 == $send2 ) {
                //no any clients
                $msg = 'ns1';
            } else if ( 1 == $send1 && 0 == $send2 ) {
                //all left feedback
                $msg = 'ns2';
            } else {
                //sent email for clients
                $msg = 's';
            }

        } else {
            //no any clients
            $msg = 'ns1';
        }

        do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_feedback_wizard&tab=wizards&msg=' . $msg );
        exit;
    }

    //do nothing
    do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_feedback_wizard&tab=wizards' );
    exit;

}


$wizards = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpc_client_feedback_wizards", ARRAY_A );
$wpnonce = wp_create_nonce( 'wpc_wizard_form' );

$msg = '';
if ( isset( $_GET['msg'] ) ) {
  $msg = $_GET['msg'];
}


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




?>

<div class='wrap'>

    <?php echo $wpc_client->get_plugin_logo_block() ?>

    <div class="clear"></div>
    <?php
    if ( '' != $msg ) {
    ?>
        <div id="message" class="updated fade">
            <p>
            <?php
                switch( $msg ) {
                    case 'a':
                        echo  __( 'Wizard <strong>Created</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'u':
                        echo __( 'Wizard <strong>Updated</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'd':
                        echo __( 'Wizard(s) <strong>Deleted</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'ac':
                        echo __( 'Clients are assigned', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'ag':
                        echo __( 'Client Circles are assigned!', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'ae':
                        echo __( 'Some error with assigning permission for wizard.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 's':
                        echo __( 'Email sent to Client(s)', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'ns1':
                        echo __( 'Email are not sent: no assigned Clients.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'ns2':
                        echo __( 'Email are not sent: Clients already left feedback for this wizard version.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                }
            ?>
            </p>
        </div>
    <?php
    }
    ?>

    <div id="container23">

        <ul class="menu">
            <?php echo $this->gen_feedback_tabs_menu() ?>
        </ul>
        <span class="clear"></span>

        <div class="content23 news">

            <br>
            <div>
                <a href="admin.php?page=wpclients_feedback_wizard&tab=create_wizard " class="add-new-h2"><?php _e( 'Create New Wizard', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
            </div>

            <hr />

            <form method="post" name="wizards_form" id="wizards_form">
                <input type="hidden" value="<?php echo $wpnonce ?>" name="_wpnonce" id="_wpnonce" />
                <input type="hidden" value="" name="wpc_action" id="wpc_action" />

                <table cellspacing="0" class="wp-list-table widefat media">
                    <thead>
                        <tr>
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col">
                                <input type="checkbox">
                            </th>
                            <th style="" class="manage-column column-title sortable desc" id="title" scope="col" width="330">
                                <span><?php _e( 'Wizard Name', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column column-title sortable desc" id="title" scope="col">
                                <span><?php _e( 'Version', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Items', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Clients', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column sortable desc" id="comments" scope="col">
                                <span><?php _e( 'Client Circles', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column column-date sortable asc" id="date" scope="col">
                                <span><?php _e( 'Date', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col">
                                <input type="checkbox">
                            </th>
                            <th style="" class="manage-column column-title sortable desc" id="title" scope="col">
                                <span><?php _e( 'Wizard Name', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column column-title sortable desc" id="title" scope="col">
                                <span><?php _e( 'Version', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Items', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Clients', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column sortable desc" id="comments" scope="col">
                                <span><?php _e( 'Client Circles', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column column-date sortable asc" id="date" scope="col">
                                <span><?php _e( 'Date', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                        </tr>
                    </tfoot>
                    <?php
                    if ( is_array( $wizards ) && 0 < count( $wizards ) ):
                        foreach( $wizards as $wizard ):
                    ?>
                       <tr valign="top" id="post-11" class="alternate author-other status-inherit">
                            <th scope="row" class="check-column">
                                <input type="checkbox" name="wizard_id[]" value="<?php echo $wizard['wizard_id'] ?>">
                            </th>
                            <td class="title column-title">
                                <input type="hidden" id="assign_name_block_<?php echo $wizard['wizard_id'] ?>" value="<?php echo $wizard['name'] ?>" />
                                <strong>
                                    <a href="admin.php?page=wpclients_feedback_wizard&tab=edit_wizard&wizard_id= <?php echo '' . $wizard['wizard_id'] ?>" title="edit '<?php echo $wizard['name'] ?>'"><?php echo $wizard['name'] ?></a>
                                </strong>
                                <div class="row-actions">
                                        <span class="edit"><a href="admin.php?page=wpclients_feedback_wizard&tab=edit_wizard&wizard_id= <?php echo '' . $wizard['wizard_id'] ?>" title="edit '<?php echo $wizard['name'] ?>'" ><?php _e( 'Edit', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                        <span class="delete"><a class="submitdelete" onclick="return showNotice.warn();" href="admin.php?page=wpclients_feedback_wizard&tab=wizards&wpc_action=delete_wizard&wizard_id=<?php echo $wizard['wizard_id']  ?>&_wpnonce=<?php echo $wpnonce ?>"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                        <span class="send"><a class="submitsend" href="admin.php?page=wpclients_feedback_wizard&tab=wizards&wpc_action=send_wizard&wizard_id=<?php echo $wizard['wizard_id']  ?>&_wpnonce=<?php echo $wpnonce ?>"><?php _e( 'Send Email to Client(s)', WPC_CLIENT_TEXT_DOMAIN ) ?></a> </span>
                                </div>
                            </td>
                            <td class="title column-title">
                                <?php echo ( isset( $wizard['version'] ) && '' != $wizard['version'] ) ? $wizard['version'] : '1.0.0' ?>
                            </td>
                            <td class="author column-author">
                            <?php echo $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(item_id) FROM {$wpdb->prefix}wpc_client_feedback_wizard_items WHERE wizard_id = %d", $wizard['wizard_id'] ) ); ?>
                            </td>
                            <td class="author column-author">
                                <?php
                                $client_ids = array();
                                $ids = explode( ',', str_replace( '#', '', $wizard['clients_id'] ) );
                                if ( is_array( $ids ) && 0 < count( $ids ) ) {
                                    foreach ( $ids as $id ) {
                                        if ( 0 < $id ) {
                                            $client_ids[] = $id;
                                        }
                                    }
                                }
                                ?>
                                <span class="edit"><a href="#popup_block2" rel="clients<?php echo $wizard['wizard_id'] ?>" class="fancybox_link" title="assign clients to '<?php echo $wizard['name'] ?>'" ><?php _e( 'Assign', WPC_CLIENT_TEXT_DOMAIN ) ?></a></span>
                                <span class="edit action_links" id="counter_clients<?php echo $wizard['wizard_id'];?>">(<?php echo count( $client_ids ) ?>)</span>
                                <input type="hidden" name="<?php echo $wizard['wizard_id'] ?>" id="clients<?php echo $wizard['wizard_id'] ?>" class="change_clients" value="<?php echo implode( ',', $client_ids ) ?>" />
                            </td>
                            <td class="author column-author">
                                <?php
                                $group_ids = array();
                                $ids = explode( ',', str_replace( '#', '', $wizard['groups_id'] ) );
                                if ( is_array( $ids ) && 0 < count( $ids ) ) {
                                    foreach ( $ids as $id ) {
                                        if ( 0 < $id ) {
                                            $group_ids[] = $id;
                                        }
                                    }
                                }
                                ?>
                                <span class="edit"><a href="#circles_popup_block" rel="circles<?php echo $wizard['wizard_id'] ?>" class="fancybox_link" title="assign Client Circles to '<?php echo $wizard['name'] ?>'" ><?php _e( 'Assign', WPC_CLIENT_TEXT_DOMAIN ) ?></a></span>
                                <span class="edit action_links" id="counter_circles<?php echo $wizard['wizard_id'];?>">(<?php echo count( $group_ids ) ?>)</span>
                                <input type="hidden" name="<?php echo $wizard['wizard_id'] ?>" id="circles<?php echo $wizard['wizard_id'] ?>" class="change_circles" value="<?php echo implode( ',', $group_ids ) ?>" />
                            </td>
                            <td class="date column-date">
                                <?php echo $wpc_client->date_timezone( $date_format, $wizard['time'] ) ?>
                                <br>
                                <?php echo $wpc_client->date_timezone( $time_format, $wizard['time'] ) ?>
                            </td>
                        </tr>

                    <?php
                        endforeach;
                    endif;
                    ?>
                </table>

                <?php
                $current_page = isset( $_GET['page'] ) ? $_GET['page'] : '';
                $wpc_client->get_assign_clients_popup( $current_page );
                $wpc_client->get_assign_circles_popup( $current_page );
                ?>

                <div class="tablenav bottom">

                    <div class="alignleft actions">
                        <select name="action" id="action">
                            <option selected="selected" value="-1"><?php _e( 'Bulk Actions', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                            <option value="delete_wizards"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
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




        </div>
    </div>


</div>

<script type="text/javascript">
    var site_url = '<?php echo site_url();?>';

    jQuery( document ).ready( function() {

        //delete wizard from Bulk Actions
        jQuery( '#doaction' ).click( function() {
            if ( 'delete_wizards' == jQuery( '#action' ).val() ) {
                jQuery( '#wpc_action' ).val( 'delete_wizard' );
                jQuery( '#wizards_form' ).submit();
            }
            return false;
        });

    });
</script>
