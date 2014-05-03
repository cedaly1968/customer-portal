<?php
global $wpdb, $wpc_client;

$filter     = '';
$filter2    = '';
$where      = '';
$target     = '';

// Convert to INV
if ( isset( $_REQUEST['wpc_action'] ) && 'convert' == $_REQUEST['wpc_action'] && isset( $_REQUEST['id'] ) ) {
    if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'wpc_invoices_form' )) {
        $this->convert_to_inv( $_REQUEST['id'] );
        do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_invoicing&tab=estimates&msg=c' );
        exit;

    }
    do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_invoicing&tab=estimates' );
    exit;
}

// delete estimate
if ( isset( $_REQUEST['wpc_action'] ) && 'delete_estimate' == $_REQUEST['wpc_action'] && isset( $_REQUEST['id'] ) ) {
    $this->delete_data( $_REQUEST['id'] );

    do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_invoicing&tab=estimates&msg=d' );
    exit;
}


//filter by clients
if ( isset( $_GET['filter']  ) ) {
    $filter = $_GET['filter'];

    if ( is_numeric( $filter ) && 0 < $filter )
        $where .= " AND client_id = '$filter' " ;

    $target .= '&filter=' . $filter;
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

$items = $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='est' " . $where . " " );

$p = new pagination;
$p->items( $items );
$p->limit( 25 );
$p->target( 'admin.php?page=wpclients_invoicing&tab=estimates' . $target );
$p->calculate();
$p->parameterName( 'p' );
$p->adjacents( 2 );

if( !isset( $_GET['p'] ) ) {
    $p->page = 1;
} else {
    $p->page = $_GET['p'];
}

$limit = "LIMIT " . ( $p->page - 1 ) * $p->limit . ", " . $p->limit;




//get estimates
$estimates = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='est' " . $where . " ORDER BY id DESC " . $limit, 'ARRAY_A' );


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

$wpnonce = wp_create_nonce( 'wpc_invoices_form' );


//get all clients for INV
$clients = $wpdb->get_col( "SELECT client_id FROM {$wpdb->prefix}wpc_client_invoicing WHERE type='est' GROUP BY client_id" );



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
                        echo  __( 'Estimate <strong>Created</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'as':
                        echo  __( 'Estimate <strong>Created & Sent</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'u':
                        echo __( 'Estimate <strong>Updated</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'us':
                        echo __( 'Estimate <strong>Updated & Sent</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'c':
                        echo __( 'Estimate <strong>Converted</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
                        break;
                    case 'd':
                        echo __( 'Estimate(s) <strong>Deleted</strong> Successfully.', WPC_CLIENT_TEXT_DOMAIN );
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
                <a href="admin.php?page=wpclients_invoicing&tab=estimate_edit" class="add-new-h2"><?php _e( 'Create New Estimate', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
            </div>

            <hr />

            <form method="post" name="estimates_form" id="estimates_form" action="admin.php?page=wpclients_invoicing&tab=estimates">
                <input type="hidden" value="<?php echo $wpnonce ?>" name="_wpnonce" id="_wpnonce" />
                <input type="hidden" value="" name="wpc_action" id="wpc_action" />

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
                        <a href="admin.php?page=wpclients_invoicing&tab=estimates"><span style="color: #BC0B0B;"> x </span><?php _e( "client's filter", WPC_CLIENT_TEXT_DOMAIN ) ?></a>
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
                                <span><?php _e( 'Estimate Number', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
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
                    </thead>

                    <tfoot>
                        <tr>
                            <th style="" class="manage-column column-cb check-column" id="cb" scope="col">
                                <input type="checkbox">
                            </th>
                            <th style="text-align: left;" class="manage-column column-title sortable desc" id="title" scope="col" width="330">
                                <span><?php _e( 'Estimate Number', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="" class="manage-column column-title sortable desc" id="title" scope="col" width="330">

                            </th>
                            <th style="text-align: left;" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Client', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="text-align: right;" class="manage-column  sortable desc" id="" scope="col">
                                <span><?php _e( 'Total', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th style="text-align: center;" width="100" class="manage-column column-date sortable asc" id="date" scope="col">
                                <span><?php _e( 'Status', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                            <th class="manage-column column-date sortable asc" id="date" scope="col">
                                <span><?php _e( 'Date', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                            </th>
                        </tr>
                    </tfoot>
                    <?php
                    if ( is_array( $estimates ) && 0 < count( $estimates ) ):
                        foreach( $estimates as $estimate ):
                        $number = $estimate['prefix'] . $estimate['number'];
                    ?>
                       <tr valign="top" id="post-11" class="alternate author-other status-inherit">
                            <th scope="row" class="check-column">
                                <input type="checkbox" name="id[]" value="<?php echo $estimate['id'] ?>">
                            </th>
                            <td class="title column-title" colspan="2">
                                <strong>
                                    <a href="admin.php?page=wpclients_invoicing&tab=estimate_edit&id=<?php echo $estimate['id'] ?>" title="edit '<?php echo $number ?>'"><?php echo $number ?></a>
                                </strong>

                                <div>
                                    <?php
                                    if ( 100 > strlen( $estimate['description'] ) ) {
                                        echo wp_trim_words( $estimate['description'], 25 );
                                    } elseif ( 140 > strlen( $estimate['description'] ) ) {
                                        echo wp_trim_words( $estimate['description'], 20 );
                                    } else {
                                        echo wp_trim_words( $estimate['description'], 15 );
                                    }
                                    ?>
                                </div>


                                <div class="row-actions">
                                    <?php if ( 'paid' != $estimate['status'] ) { ?>
                                    <span class="edit"><a href="admin.php?page=wpclients_invoicing&tab=estimate_edit&id=<?php echo $estimate['id'] ?>" title="Edit '<?php echo $number ?>'" ><?php _e( 'Edit', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                    <span class="edit"><a href="admin.php?page=wpclients_invoicing&tab=estimates&id=<?php echo $estimate['id'] ?>&wpc_action=convert&_wpnonce=<?php echo $wpnonce ?>"  title="Convert to invoice '<?php echo $number ?>'" ><?php _e( 'Convert to Invoice', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                    <?php } else { ?>
                                    <span class="edit"><a href="admin.php?page=wpclients_invoicing&tab=estimate_edit&id=<?php echo $estimate['id'] ?>" title="view '<?php echo $number ?>'" ><?php _e( 'View', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                    <?php } ?>
                                    <span class="edit"><a href="admin.php?page=wpclients_invoicing&wpc_action=download_pdf&id=<?php echo $estimate['id'] ?>" title="Download PDF '<?php echo $number ?>'" ><?php _e( 'Download PDF', WPC_CLIENT_TEXT_DOMAIN ) ?></a> | </span>
                                    <span class="delete"><a class="submitdelete" onclick="return showNotice.warn();" href="admin.php?page=wpclients_invoicing&tab=estimates&wpc_action=delete_estimate&id=<?php echo $estimate['id']  ?>&_wpnonce=<?php echo $wpnonce ?>"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></a></span>
                                </div>
                            </td>
                            <td class="date column-date">
                                <?php
                                if ( 0 < $estimate['client_id'] ) {
                                    if ( false != $user = get_userdata( $estimate['client_id'] ) ) {
                                        echo $user->get( 'user_login' );
                                    } else {
                                        echo __( '(deleted user)', WPC_CLIENT_TEXT_DOMAIN );
                                    }
                                }
                                ?>
                            </td>
                            <td class="date column-date" align="right">
                                <?php echo $currency_symbol['left'] ?><?php echo number_format( $estimate['total'], 2, '.', '' ) ?><?php echo $currency_symbol['right'] ?>
                            </td>
                            <td class="date column-date" style="text-align: center;">
                                <?php echo $this->display_status_name( $estimate['status'] ) ?>
                            </td>
                            <td class="date column-date" >
                                <?php echo $wpc_client->date_timezone( $date_format, $estimate['date'] ) ?>
                                <br>
                                <?php echo $wpc_client->date_timezone( $time_format, $estimate['date'] ) ?>
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
                            <option value="delete_estimates"><?php _e( 'Delete Permanently', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
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

        </div>
    </div>


</div>

<script type="text/javascript">

    jQuery( document ).ready( function() {

        //delete estimate from Bulk Actions
        jQuery( '#doaction' ).click( function() {
            if ( 'delete_estimates' == jQuery( '#action' ).val() ) {
                jQuery( '#wpc_action' ).val( 'delete_estimate' );
                jQuery( '#estimates_form' ).submit();
            }
            return false;
        });


        //filter by clients
        jQuery( '#client_filter_button' ).click( function() {
            if ( '-1' != jQuery( '#client_filter' ).val() ) {
                window.location = 'admin.php?page=wpclients_invoicing&tab=estimates&filter=' + jQuery( '#client_filter' ).val();
            }
            return false;
        });



    });

</script>
