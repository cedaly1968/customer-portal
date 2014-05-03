<?php
global $wpdb, $wpc_client;

$filter     = '';
$filter2    = '';
$where      = '';
$target     = '';

// delete invoice
if ( isset( $_REQUEST['wpc_action'] ) && 'delete_invoice' == $_REQUEST['wpc_action'] && isset( $_REQUEST['id'] ) ) {
    $this->delete_data( $_REQUEST['id'] );

    do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_invoicing&msg=d' );
    exit;
}

//save payment
if ( isset( $_POST['wpc_payment'] ) ) {
    $errors = $this->save_payment( $_POST['wpc_payment'] );
}


//filter by clients
if ( isset( $_GET['filter']  ) ) {
    $filter = $_GET['filter'];

    if ( is_numeric( $filter ) && 0 < $filter )
        $where .= " AND client_id = '$filter' " ;

    $target .= '&filter=' . $filter;
}

//filter by status
if ( isset( $_GET['filter2']  ) ) {
    $filter2 = $_GET['filter2'];

    if ( 'new' == $filter2 )
        $where .= " AND ( status='new' OR status IS NULL ) ";
    elseif ( 'in_process' == $filter2 )
        $where .= " AND status='inprocess' ";
    elseif ( 'paid' == $filter2 )
        $where .= " AND status='paid' ";

    $target .= '&filter2=' . $filter2;
}

//search
if ( isset( $_REQUEST['s'] ) && '' != $_REQUEST['s'] ) {
    $search = strtolower( trim( $_REQUEST['s'] ) );
    $where = "
        AND ( CONCAT(LOWER(prefix), number) LIKE '%" . $search . "%'
        OR LOWER(description) LIKE '%" . $search . "%'
        OR total LIKE '%" . $search . "%'
        )
    ";
    $target = '&s=' . $search;
}


/*
* Pagination
*/
if ( !class_exists( 'pagination' ) )
    include_once( $wpc_client->plugin_dir . 'forms/pagination.php' );

$items = $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='inv' " . $where . " " );

$p = new pagination;
$p->items( $items );
$p->limit( 25 );
$p->target( 'admin.php?page=wpclients_invoicing' . $target );
$p->calculate();
$p->parameterName( 'p' );
$p->adjacents( 2 );

if( !isset( $_GET['p'] ) ) {
    $p->page = 1;
} else {
    $p->page = $_GET['p'];
}

$limit = "LIMIT " . ( $p->page - 1 ) * $p->limit . ", " . $p->limit;


//get invoices
$invoices = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='inv' " . $where . " ORDER BY id DESC " . $limit, 'ARRAY_A' );

$wpnonce = wp_create_nonce( 'wpc_invoices_form' );


$count_all          = $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='inv'" );
$count_new          = $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='inv' AND ( status='new' OR status IS NULL ) " );
$count_in_process   = $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='inv' AND status='inprocess' " );
$count_paid         = $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='inv' AND status='paid' " );


//get all clients for INV
$clients = $wpdb->get_col( "SELECT client_id FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='inv' GROUP BY client_id" );


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
                        echo  __( 'Invoice <strong>Created</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'as':
                        echo  __( 'Invoice <strong>Created & Sent</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'pa':
                        echo  __( 'Payment <strong>Added</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'u':
                        echo __( 'Invoice <strong>Updated</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'us':
                        echo __( 'Invoice <strong>Updated & Sent</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'd':
                        echo __( 'Invoice(s) <strong>Deleted</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
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
            <?php echo $this->gen_tabs_menu() ?>
        </ul>
        <span class="clear"></span>

        <div class="content23 news">

            <br>
            <div>
                <a href="admin.php?page=wpclients_invoicing&tab=invoice_edit" class="add-new-h2"><?php _e( 'Create New Invoice', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
            </div>

            <hr />


            <form method="post" name="invoices_form" id="invoices_form" action="admin.php?page=wpclients_invoicing">
                <input type="hidden" value="<?php echo $wpnonce ?>" name="_wpnonce" id="_wpnonce" />
                <input type="hidden" value="" name="wpc_action" id="wpc_action" />


                <ul class="subsubsub" style="margin: 0px 0px 0px 0px;" >
                    <li class="all"><a class="<?php echo ( '' == $filter2 ) ? 'current' : '' ?>" href="admin.php?page=wpclients_invoicing<?php echo ( '' != $filter ) ? '&filter=' . $filter : '' ?>"  ><?php _e( 'All', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="count">(<?php echo $count_all ?>)</span></a> |</li>
                    <li class="image"><a class="<?php echo ( 'new' == $filter2 ) ? 'current' : '' ?>" href="admin.php?page=wpclients_invoicing<?php echo ( '' != $filter ) ? '&filter=' . $filter : '' ?>&filter2=new"><?php _e( 'New', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="count">(<?php echo $count_new ?>)</span></a> |</li>
                    <li class="image"><a class="<?php echo ( 'in_process' == $filter2 ) ? 'current' : '' ?>" href="admin.php?page=wpclients_invoicing<?php echo ( '' != $filter ) ? '&filter=' . $filter : '' ?>&filter2=in_process"><?php _e( 'In-Process', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="count">(<?php echo $count_in_process ?>)</span></a></li>
                    <li class="image"><a class="<?php echo ( 'in_process' == $filter2 ) ? 'current' : '' ?>" href="admin.php?page=wpclients_invoicing<?php echo ( '' != $filter ) ? '&filter=' . $filter : '' ?>&filter2=partial"><?php _e( 'Partial', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="count">(<?php echo $count_in_process ?>)</span></a></li>
                    <li class="image"><a class="<?php echo ( 'paid' == $filter2 ) ? 'current' : '' ?>" href="admin.php?page=wpclients_invoicing<?php echo ( '' != $filter ) ? '&filter=' . $filter : '' ?>&filter2=paid"><?php _e( 'Paid', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="count">(<?php echo $count_paid ?>)</span></a></li>
                </ul>

                <p class="search-box">
                    <label for="search-input" class="screen-reader-text"><?php _e( 'Search', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                    <input type="text" value="<?php echo ( isset( $_REQUEST['s'] ) && '' != $_REQUEST['s'] ) ? $_REQUEST['s'] : '' ?>" name="s" id="search-input" />
                    <input type="submit" value="<?php _e( 'Search', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button" id="search-submit" name="" />
                </p>

                <div class="tablenav top">

                    <div class="alignleft actions">
                        <select name="action" id="action">
                            <option selected="selected" value="-1"><?php _e( 'Bulk Actions', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                            <option value="delete_invoices"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                        </select>
                        <input type="button" value="<?php _e( 'Apply', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button-secondary action" id="doaction" name="" />
                    </div>

                    <div class="alignleft actions">
                        <select name="filter" id="client_filter">
                            <option value="-1" selected="selected"><?php _e( 'Select Client', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                            <?php
                            if ( is_array( $clients ) && 0 < count( $clients ) ) {
                                foreach( $clients as $client_id ) {
                                    $selected = ( isset( $filter ) && $client_id == $filter ) ? 'selected' : '';
                                    echo '<option value="' . $client_id . '" ' . $selected . ' >' .  get_userdata( $client_id )->user_login . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <?php
                        if ( '' != $filter ) {
                        ?>
                        <a href="admin.php?page=wpclients_invoicing<?php echo ( '' != $filter2 ) ? '&filter2=' . $filter2 : '' ?>"><span style="color: #BC0B0B;"> x </span><?php _e( "client's filter", WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                        <?php } ?>
                        <input type="button" value="<?php _e( 'Filter', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button-secondary" id="client_filter_button" name="" />
                    </div>


                    <div class="tablenav-pages one-page">
                        <span class="displaying-num"><?php echo $items ?> item(s)</span>
                    </div>

                    <br class="clear">

                </div>



                <table cellspacing="0" class="wp-list-table widefat media">
                    <thead>
                        <tr>
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col">
                                <input type="checkbox">
                            </th>
                            <th style="text-align: left;" class="manage-column column-title sortable desc" id="title" scope="col" width="330">
                                <span><?php _e( 'Invoice Number', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column column-title sortable desc" id="title" scope="col" width="330">

                            </th>
                            <th style="text-align: left;" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Client', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="text-align: right;" class="manage-column  sortable desc" id="" scope="col" >
                                <span><?php _e( 'Total', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="text-align: center;" width="100" class="manage-column column-date sortable asc" id="date" scope="col">
                                <span><?php _e( 'Status', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th class="manage-column column-date sortable asc" id="date" scope="col">
                                <span><?php _e( 'Date', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col">
                                <input type="checkbox">
                            </th>
                            <th style="text-align: left;" class="manage-column column-title sortable desc" id="title" scope="col" width="330">
                                <span><?php _e( 'Invoice Number', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column column-title sortable desc" id="title" scope="col" width="330">

                            </th>
                            <th style="text-align: left;" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Client', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="text-align: right;" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Total', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="text-align: center;" class="manage-column column-date sortable asc" id="date" scope="col">
                                <span><?php _e( 'Status', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th class="manage-column column-date sortable asc" id="date" scope="col">
                                <span><?php _e( 'Date', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                        </tr>
                    </tfoot>
                    <?php
                    if ( is_array( $invoices ) && 0 < count( $invoices ) ):
                        foreach( $invoices as $invoice ):
                        $number = $invoice['prefix'] . $invoice['number'];


                    ?>
                       <tr valign="top" class="alternate author-other status-inherit">
                            <th scope="row" class="check-column">
                                <input type="checkbox" name="id[]" value="<?php echo $invoice['id'] ?>">
                            </th>
                            <td class="title column-title" colspan="2">
                                <strong>
                                    <a href="admin.php?page=wpclients_invoicing&tab=invoice_edit&id=<?php echo $invoice['id'] ?>" title="edit '<?php echo $number ?>'"><?php echo $number ?></a>
                                </strong>
                                <div>
                                    <?php
                                    if ( 100 > strlen( $invoice['description'] ) ) {
                                        echo wp_trim_words( $invoice['description'], 25 );
                                    } elseif ( 140 > strlen( $invoice['description'] ) ) {
                                        echo wp_trim_words( $invoice['description'], 20 );
                                    } else {
                                        echo wp_trim_words( $invoice['description'], 15 );
                                    }
                                    ?>
                                </div>


                                <div class="row-actions">
                                    <?php if ( 'paid' != $invoice['status'] ) { ?>
                                    <span class="edit"><a href="admin.php?page=wpclients_invoicing&tab=invoice_edit&id=<?php echo $invoice['id'] ?>" title="Edit '<?php echo $number ?>'" ><?php _e( 'Edit', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                    <span class="edit"><a href="#add_payment" rel="<?php echo $invoice['id'] ?>" class="various" title="Add Payment '<?php echo $number ?>'" ><?php _e( 'Add Payment', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                    <?php } else { ?>
                                    <span class="edit"><a href="admin.php?page=wpclients_invoicing&tab=invoice_edit&id=<?php echo $invoice['id'] ?>" title="view '<?php echo $number ?>'" ><?php _e( 'View', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                    <?php } ?>
                                    <span class="edit"><a href="admin.php?page=wpclients_invoicing&wpc_action=download_pdf&id=<?php echo $invoice['id'] ?>" title="Download PDF '<?php echo $number ?>'" ><?php _e( 'Download PDF', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                    <span class="delete"><a class="submitdelete" onclick="return showNotice.warn();" href="admin.php?page=wpclients_invoicing&wpc_action=delete_invoice&id=<?php echo $invoice['id']  ?>&_wpnonce=<?php echo $wpnonce ?>"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></a></span>
                                </div>
                            </td>
                            <td class="date column-date">
                                <?php
                                if ( 0 < $invoice['client_id'] ) {
                                    if ( false != $user = get_userdata( $invoice['client_id'] ) ) {
                                        echo $user->get( 'user_login' );
                                    } else {
                                        echo __( '(deleted user)', WPC_CLIENT_TEXT_DOMAIN );
                                    }
                                }
                                ?>
                            </td>
                            <td class="date column-date" align="right">
                                <?php echo $currency_symbol['left'] ?><span id="total_<?php echo $invoice['id'] ?>"><?php echo number_format( $invoice['total'], 2, '.', '' ) ?></span><?php echo $currency_symbol['right'] ?>
                                <br />
                                <span class="description">
                                    <?php
                                    $amount_paid = $this->get_amount_paid( $invoice['id'] );
                                    echo ( 0 < $amount_paid ) ? '(' . $currency_symbol['left'] . number_format( $amount_paid, 2, '.', '' ) . $currency_symbol['right'] . ')' : '';
                                    ?>
                                </span>
                                <input type="hidden" id="total_amount_paid_<?php echo $invoice['id'] ?>" value="<?php echo number_format( $amount_paid, 2, '.', '' ) ?>">
                            </td>
                            <td class="date column-date" style="text-align: center;">
                                <?php echo $this->display_status_name( $invoice['status'] ) ?>
                            </td>
                            <td class="date column-date">
                                <?php echo $wpc_client->date_timezone( $date_format, $invoice['date'] ) ?>
                                <br>
                                <?php echo $wpc_client->date_timezone( $time_format, $invoice['date'] ) ?>
                            </td>
                        </tr>

                    <?php
                        endforeach;
                    endif;
                    ?>
                </table>

                <div class="tablenav bottom">

                    <div class="alignleft actions">
                        <select name="action" id="action">
                            <option selected="selected" value="-1"><?php _e( 'Bulk Actions', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                            <option value="delete_invoices"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                        </select>
                        <input type="button" value="<?php _e( 'Apply', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button-secondary action" id="doaction" name="" />
                    </div>

                    <div class="alignleft actions"></div>

                    <div class="tablenav-pages one-page">
                        <div class="tablenav">
                            <div class='tablenav-pages'>
                                <?php  echo $p->show(); ?>
                            </div>
                        </div>
                    </div>

                    <br class="clear">
                </div>

            </form>




            <div class="wpc_add_payment" id="add_payment" style="display: none;">
                <h3><?php _e( 'Add Payment:', WPC_CLIENT_TEXT_DOMAIN ) ?></h3>
                <form method="post" name="wpc_add_payment" id="wpc_add_payment">
                    <input type="hidden" name="wpc_payment[inv_id]" id="wpc_payment_inv_id" value="" />
                    <table>
                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Invoice Total:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <?php echo $currency_symbol['left'] ?><span id="wpc_add_payment_total"></span><?php echo $currency_symbol['right'] ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Amount Paid:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <?php echo $currency_symbol['left'] ?><span id="wpc_add_payment_amount_paid"></span><?php echo $currency_symbol['right'] ?>
                                </label>
                                <br />
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Amount Received:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                    <br />
                                    <input type="text" size="70" name="wpc_payment[amount]" id="wpc_payment_amount"  value="" />
                                </label>
                                <br />
                                <span class="description"><?php _e( "Can't be more then Total.", WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                <br />
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <label>
                                                <?php _e( 'Payment date:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                                <br />
                                                <input type="text" name="wpc_payment[date]" id="wpc_payment_date" value="<?php echo ( isset( $data['due_date'] ) ) ? $data['due_date'] : '' ?>"/>
                                            </label>
                                            <br />
                                            <br />
                                        </td>
                                        <td width="50"></td>
                                        <td>
                                            <label>
                                                <?php _e( 'Payment Method:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                                <br />
                                                <select name="wpc_payment[method]" id="wpc_payment_method" >
                                                    <option value="p_cash" selected ><?php _e( 'Cash', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                    <option value="p_check"><?php _e( 'Check', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                    <option value="p_wire_transfer"><?php _e( 'Wire Transfer', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                    <option value="p_credit_card"><?php _e( 'Credit Card', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                    <option value="p_paypal" ><?php _e( 'PayPal', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                    <option value="p_barter"><?php _e( 'Barter', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                    <option value="p_contribution"><?php _e( 'Contribution', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                    <option value="p_other"><?php _e( 'Other', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                </select>
                                            </label>
                                            <br />
                                            <br />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Notes:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <br />
                                    <textarea cols="67" rows="3" name="wpc_payment[notes]" id="wpc_payment_notes" ></textarea>
                                </label>
                                <br />
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" size="70" name="wpc_payment[thanks]" id="wpc_payment_thanks"  value="1" />
                                    <?php _e( 'Send a "thank you" note for this payment', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <div style="clear: both; text-align: center;">
                        <input type="button" class='button-primary' id="save_add_payment" value="<?php _e( 'Add Payment', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                        <input type="button" class='button' id="close_add_payment" value="<?php _e( 'Close', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                    </div>
                </form>
            </div>





        </div>
    </div>


</div>

<script type="text/javascript">

    jQuery( document ).ready( function() {

        //delete invoice from Bulk Actions
        jQuery( '#doaction' ).click( function() {
            if ( 'delete_invoices' == jQuery( '#action' ).val() ) {
                jQuery( '#wpc_action' ).val( 'delete_invoice' );
                jQuery( '#invoices_form' ).submit();
            }
            return false;
        });


        //filter by clients
        jQuery( '#client_filter_button' ).click( function() {
            if ( '-1' != jQuery( '#client_filter' ).val() ) {
                window.location = 'admin.php?page=wpclients_invoicing<?php echo ( '' != $filter2 ) ? '&filter2=' . $filter2 : '' ?>&filter=' + jQuery( '#client_filter' ).val();
            }
            return false;
        });




        //open Add Payment
        jQuery( '.various' ).click( function() {
            var id = jQuery( this ).attr( 'rel' );

            //set payment amount
            if ( 0 < jQuery( '#total_amount_paid_' + id ).val() ) {
                jQuery( '#wpc_payment_amount' ).val( jQuery( '#total_' + id ).html() - jQuery( '#total_amount_paid_' + id ).val() );
            } else {
                jQuery( '#wpc_payment_amount' ).val( jQuery( '#total_' + id ).html() );
            }

            jQuery( '#wpc_add_payment_total' ).html( jQuery( '#total_' + id ).html() );
            jQuery( '#wpc_add_payment_amount_paid' ).html( jQuery( '#total_amount_paid_' + id ).val() );

            jQuery( '#wpc_payment_date' ).val( '<?php echo date( 'm/d/Y', time() ) ?>' );

            jQuery( '#wpc_payment_inv_id' ).val( id );

            //show content for edit file
            jQuery( '.various' ).fancybox({
                helpers : {
                    title : null,
                }
            });

        });

        //close Add Payment
        jQuery( '#close_add_payment' ).click( function() {
            jQuery( '#wpc_payment_inv_id' ).val( '' );
            jQuery.fancybox.close();
        });


        jQuery( '#wpc_payment_date' ).datepicker({
//            dateFormat : '<?php echo $date_format ?>'
            dateFormat : 'mm/dd/yy'
        });


        //check payment amount
        jQuery( '#wpc_payment_amount' ).live( 'keypress', function(e) {
            var val = jQuery(this).val();

            if ( val > jQuery( '#wpc_add_payment_total' ).html() * 1 ) {
                jQuery( '#wpc_payment_amount' ).parent().parent().attr( 'class', 'wpc_error' );
            } else {
                jQuery( '#wpc_payment_amount' ).parent().parent().attr( 'class', '' );
            }

            if ( e.which == 8 || e.which == 0 ) {
                return true;
            }

            if ( ( e.which >= 48 && e.which <= 57 ) || e.which == 44 || e.which == 46 ) {
              //  if( val.length == 0 ) {
//                    jQuery(this).val('0');
//                }

                return true;
            }

            return false;
        });

        //check payment amount
       // jQuery( '#wpc_payment_amount' ).keyup( function( e ) {

//            if ( val > jQuery( '#wpc_add_payment_total' ).html() * 1 ) {
//                jQuery( '#wpc_payment_amount' ).parent().parent().attr( 'class', 'wpc_error' );
//            } else {
//                jQuery( '#wpc_payment_amount' ).parent().parent().attr( 'class', '' );
//            }

//        });

        //Save payment
        jQuery( '#save_add_payment' ).click( function() {
            var errors = 0;

            if ( jQuery( '#wpc_payment_amount' ).val() > jQuery( '#wpc_add_payment_total' ).html() * 1 ) {
                errors = 1

                jQuery( '#wpc_payment_amount' ).parent().parent().attr( 'class', 'wpc_error' );
            } else {
                jQuery( '#wpc_payment_amount' ).parent().parent().attr( 'class', '' );
            }

            if ( '' == jQuery( "#wpc_payment_amount" ).val() ) {
                jQuery( '#wpc_payment_amount' ).parent().parent().attr( 'class', 'wpc_error' );
                errors = 1;
            } else {
                jQuery( '#wpc_payment_amount' ).parent().parent().attr( 'class', '' );
            }

            if ( '' == jQuery( "#wpc_payment_date" ).val() ) {
                jQuery( '#wpc_payment_date' ).parent().parent().attr( 'class', 'wpc_error' );
                errors = 1;
            } else {
                jQuery( '#wpc_payment_date' ).parent().parent().attr( 'class', '' );
            }

            if ( '' == jQuery( "#wpc_payment_method" ).val() ) {
                jQuery( '#wpc_payment_method' ).parent().parent().attr( 'class', 'wpc_error' );
                errors = 1;
            } else {
                jQuery( '#wpc_payment_method' ).parent().parent().attr( 'class', '' );
            }

            if ( 0 == errors ) {
                jQuery( '#wpc_add_payment' ).submit();
            }

        });





    });

</script>
