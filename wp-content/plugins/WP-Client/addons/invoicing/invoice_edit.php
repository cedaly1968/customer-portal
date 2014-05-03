<?php
global $wpdb, $wpc_client;

$error = '';

//save data
if ( isset( $_POST['wpc_data'] ) ) {
    $error = $this->save_data( $_POST['wpc_data'] );
}


//save payment
if ( isset( $_POST['wpc_payment'] ) ) {
    $error = $this->save_payment( $_POST['wpc_payment'] );
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


$items              = $this->get_items();
$num_items          = 0;

//get data
if ( isset( $_POST['data'] ) ) {
    $data = $_POST['data'];
} elseif ( isset( $_GET['id'] ) && 0 < $_GET['id'] ) {
    $data = $this->get_data( $_GET['id'], 'inv' );

    //wrong ID
    if ( !$data ) {
        do_action( 'wp_client_redirect', get_admin_url(). 'admin.php?page=wpclients_invoicing' );
        exit;
    }


    if ( '' != $data['items'] ) {
        $data['items'] = unserialize( $data['items'] );
    }

    if ( '' != $data['tax'] ) {
        $data['tax'] = unserialize( $data['tax'] );
    } else {
        $data['tax'] = array();
    }

    $payment_amount = '';
    if ( isset( $data['order_id'] ) && '' != $data['order_id'] ) {
       $payment_amount = $this->get_amount_paid( $_GET['id'] );
    }

} else {
    if ( isset( $inv_settings['templates']['ter_con'] ) ) {
        $data['terms'] = $inv_settings['templates']['ter_con'];
    }

    if ( isset( $inv_settings['templates']['not_cus'] ) ) {
        $data['note'] = $inv_settings['templates']['not_cus'];
    }
}

$status = '';
if ( isset( $data['status'] ) && '' != $data['status'] )
    $status = $data['status'];


$can_edit = ( 'paid' == $status || 'partial' == $status ) ? 0 : 1;

if ( 'partial' == $status ) {
    $can_add_payment = 1;
}



//set return url
$return_url = get_admin_url(). 'admin.php?page=wpclients_invoicing';
if ( isset( $_SERVER['HTTP_REFERER'] ) && '' != $_SERVER['HTTP_REFERER'] ) {
    $return_url = $_SERVER['HTTP_REFERER'];
}

?>

<style type="text/css">

.wrap input[type=text] {
    width:400px;

}.wrap textarea {
    width:400px;
}

.wrap input[type=password] {
    width:400px;
}

</style>

<div class='wrap'>

    <?php echo $wpc_client->get_plugin_logo_block() ?>

    <div class="clear"></div>

    <div id="container23">
        <ul class="menu">
            <?php echo $this->gen_tabs_menu() ?>
        </ul>
        <span class="clear"></span>
        <div class="content23 news">

            <div id="message" class="error fade" <?php echo ( empty( $error ) )? 'style="display: none;" ' : '' ?> ><?php echo $error; ?></div>

            <form name="edit_data" id="edit_data" method="post" >
                <input type="hidden" name="wpc_data[send]" id="wpc_data_send" value="" />
                <input type="hidden" name="return_url" id="return_url" value="<?php echo $return_url ?>" />
                <?php if ( isset( $_GET['id'] ) && '' != $_GET['id'] ) { ?>
                <input type="hidden" name="wpc_data[id]" value="<?php echo ( isset( $_GET['id'] ) ) ? $_GET['id'] : '' ?>" />
                <?php } ?>


                <h2>
                <?php

                    if ( isset( $_GET['id'] ) && '' != $_GET['id'] ) {
                        _e( 'Invoice', WPC_CLIENT_TEXT_DOMAIN );
                        echo ' #' . $data['prefix'] . $data['number'];
                        //display status
                        if ( $this->display_status_name( $data['status'] ) )
                            echo ' (' . $this->display_status_name( $data['status'] ) . ')';

                    } else {
                        _e( 'Create Invoice', WPC_CLIENT_TEXT_DOMAIN );
                    }
                ?>

                </h2>

                <?php if ( $can_edit ) { ?>
                <input type="button" name="save_data" id="save_data" class="button-primary" value="<?php _e( 'Save Invoice', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                <?php } ?>
                <input type="button" name="data_cancel" id="data_cancel" class="button" value="<?php _e( 'Cancel', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                <?php if ( $can_edit ) { ?>
                <input type="button" name="save_data_send" id="save_data_send" class="button-primary" value="<?php _e( 'Save & Send Invoice', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                <?php } ?>
                <?php if ( isset( $_GET['id'] ) && '' != $_GET['id'] && $can_add_payment ) { ?>
                <input type="button" name="" id="open_add_payment" class="button" value="<?php _e( 'Add Payment', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                <?php } ?>
                <?php if ( isset( $_GET['id'] ) && '' != $_GET['id'] ) { ?>
                <a href="admin.php?page=wpclients_invoicing&wpc_action=download_pdf&id=<?php echo $data['id'] ?>" title="" ><input type="button" name="" id="" class="button" value="<?php _e( 'Download PDF', WPC_CLIENT_TEXT_DOMAIN ) ?>" /></a>
                <?php } ?>

                <hr />

                <table>
                    <tr>
                        <td valign="top">
                            <table>

                                <?php if ( !isset( $_GET['id'] ) ) { ?>
                                <tr>
                                    <td>
                                        <label><?php _e( 'Client(s)', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                        <input type="hidden" name="wpc_data[clients_id]" id="clients" value="<?php echo ( isset( $data['clients_id'] ) ) ? $data['clients_id'] : '' ?>" />
                                        <br />
                                        <span class="edit"><a href="#popup_block2" rel="clients" class="fancybox_link" title="assign clients to estimate" ><?php _e( 'Assign To Client(s)', WPC_CLIENT_TEXT_DOMAIN ) ?></a></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label><?php _e( 'Client Circle(s)', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                        <input type="hidden" name="wpc_data[groups_id]" id="circles" value="<?php echo ( isset( $data['groups_id'] ) ) ? $data['groups_id'] : '' ?>" />
                                        <br />
                                        <span class="edit"><a href="#circles_popup_block" rel="circles" class="fancybox_link" title="assign Client's from Circles to invoice" ><?php _e( 'Assign To Client Circle(s)', WPC_CLIENT_TEXT_DOMAIN ) ?></a></span>
                                    </td>
                                </tr>
                                <?php } else { ?>
                                <tr>
                                    <td>
                                        <label><?php _e( 'Client', WPC_CLIENT_TEXT_DOMAIN ) ?>:</label>
                                        <b>
                                        <?php
                                        if ( 0 < $data['client_id'] ) {
                                            if ( false != $user = get_userdata( $data['client_id'] ) ) {
                                                echo $user->get( 'user_login' );
                                            } else {
                                                echo __( '(deleted user)', WPC_CLIENT_TEXT_DOMAIN );
                                            }
                                        }
                                        ?>
                                        </b>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td>
                                        <label>
                                            <?php _e( 'Description:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                            <br />
                                            <textarea name="wpc_data[description]" cols="67" rows="3" id="wpc_data_description" <?php echo ( !$can_edit ) ? 'readonly' : '' ?> ><?php echo ( isset( $data['description'] ) ) ? $data['description'] : '' ?></textarea>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                <label>
                                                        <?php _e( 'Due Date:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                        <br />
                                                        <input type="text" style="width: 75px" id="wpc_data_due_date" name="wpc_data[due_date]" value="<?php echo ( isset( $data['due_date'] ) && '' != $data['due_date'] ) ? date( 'm/d/Y', $data['due_date'] ) : '' ?>" <?php echo ( !$can_edit ) ? 'readonly' : '' ?> />
                                                    </label>
                                                </td>
                                                <td>
                                                <?php if ( $can_edit ) { ?>
                                                <div style="margin: 15px 0px 0px 0px;">
                                                    <a href="javascript:;" class="wpc_set_due_date" rel="<?php echo date( 'm/d/Y', ( time() + 3600*24*15 ) ) ?>">15 <?php _e( 'Day(s)', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                                                    |
                                                    <a href="javascript:;" class="wpc_set_due_date" rel="<?php echo date( 'm/d/Y', ( time() + 3600*24*30 ) ) ?>">30 <?php _e( 'Day(s)', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                                                    |
                                                    <a href="javascript:;" class="wpc_set_due_date" rel="<?php echo date( 'm/d/Y', ( time() + 3600*24*45 ) ) ?>">45 <?php _e( 'Day(s)', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                                                    |
                                                    <a href="javascript:;" class="wpc_set_due_date" rel="<?php echo date( 'm/d/Y', ( time() + 3600*24*60 ) ) ?>">60 <?php _e( 'Day(s)', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                                                    |
                                                    <a href="javascript:;" class="wpc_set_due_date" rel="<?php echo date( 'm/d/Y', ( time() + 3600*24*90 ) ) ?>">90 <?php _e( 'Day(s)', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                                                </div>
                                                <?php } ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label>
                                                        <?php _e( 'LateFee($):', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                        <br />
                                                        <input type="text" style="width: 75px" name="wpc_data[late_fee]" id="wpc_data_late_fee" value="<?php echo ( isset( $data['late_fee'] ) ) ? $data['late_fee'] : '0' ?>" <?php echo ( !$can_edit ) ? 'readonly' : '' ?> />
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <?php _e( 'Tax:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                        <br>
                                                        <select name="wpc_data[tax]" id="data_tax" <?php echo ( !$can_edit ) ? 'disabled' : '' ?> >
                                                            <option value="" ><?php _e( 'No Tax', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                            <?php
                                                            if ( isset( $data['tax'] ) && 0 < count(  $data['tax'] ) ) {
                                                                $value = $data['tax'][key( $data['tax'] )]['rate'] . '_' . base64_encode( serialize( $data['tax'] ) );
                                                                echo '<option value="' . $value . '" selected >' . key( $data['tax'] ) . ' (' . $data['tax'][key( $data['tax'] )]['rate'] . '%)</option>';
                                                                echo '<option value="" >--------------</option>';
                                                            }
                                                            if ( isset( $inv_settings['taxes'] ) && 0 < count( $inv_settings['taxes'] ) ) {
                                                                foreach( $inv_settings['taxes'] as $key => $tax ) {
                                                                    $value = $tax['rate'] . '_' . base64_encode( serialize( array( $key => $tax ) ) );
                                                                    echo '<option value="' . $value . '" ' . $selected . ' >' . $key . ' (' . $tax['rate'] . '%)</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <?php _e( 'Discount:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                        <br />
                                                        <input type="text" style="width: 75px" name="wpc_data[discount]" id="wpc_data_discount" value="<?php echo ( isset( $data['discount'] ) ) ? $data['discount'] : '0' ?>" <?php echo ( !$can_edit ) ? 'readonly' : '' ?> />
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <?php _e( 'Discount Type:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                        <br />
                                                        <select name="wpc_data[discount_type]" id="wpc_data_discount_type" <?php echo ( !$can_edit ) ? 'disabled' : '' ?> >
                                                            <option value="percent" <?php echo ( isset( $data['discount_type'] ) && 'percent' == $data['discount_type'] ) ? 'selected' : '' ?> ><?php _e( 'Percentage', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                            <option value="fixed" <?php echo ( isset( $data['discount_type'] ) && 'fixed' == $data['discount_type'] ) ? 'selected' : '' ?> ><?php _e( 'Dollar Amount', WPC_CLIENT_TEXT_DOMAIN ) ?></option>
                                                        </select>
                                                    </label>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <br />
                                        <label>
                                            <b><?php _e( 'Price:', WPC_CLIENT_TEXT_DOMAIN ) ?></b>
                                            <br>
                                            <?php _e( 'Items:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                            <?php echo $currency_symbol['left'] ?><span id="total_items2">0</span><?php echo $currency_symbol['right'] ?>
                                            <br>
                                            <?php _e( 'Discount:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                            <?php echo $currency_symbol['left'] ?><span id="total_discount">0</span><?php echo $currency_symbol['right'] ?>
                                            <br>
                                            <?php _e( 'Tax:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                            <?php echo $currency_symbol['left'] ?><span id="total_tax">0</span><?php echo $currency_symbol['right'] ?>
                                            <br>
                                            <?php _e( 'Total:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                            <?php echo $currency_symbol['left'] ?><span id="total">0</span><?php echo $currency_symbol['right'] ?>

                                            <br>

                                            <?php if ( !$can_edit && '' != $payment_amount ) { ?>
                                                <br>
                                                <?php _e( 'Amount Paid:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                <?php echo $currency_symbol['left'] ?><span id="wpc_amount_paid"><?php echo number_format( $payment_amount, 2, '.', '' ) ?></span><?php echo $currency_symbol['right'] ?>
                                            <?php } ?>

                                            <?php if ( !$can_edit && '' != $payment_amount ) { ?>
                                                <br>
                                                <?php _e( 'Total Remaining:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                                <?php echo $currency_symbol['left'] ?><span id="total_remaining"><?php echo number_format( $data['total'] - $payment_amount, 2, '.', '' ) ?></span><?php echo $currency_symbol['right'] ?>
                                            <?php } ?>

                                        </label>
                                        <br />
                                        <br />
                                        <hr />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <?php _e( 'Terms & Conditions:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                            <br />
                                            <textarea name="wpc_data[terms]" cols="67" rows="5" id="wpc_data_tc" <?php echo ( !$can_edit ) ? 'readonly' : '' ?> ><?php echo ( isset( $data['terms'] ) ) ? $data['terms'] : '' ?></textarea>
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            <?php _e( 'Note to Customer:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                            <br />
                                            <textarea name="wpc_data[note]" cols="67" rows="5" id="wpc_data_note" <?php echo ( !$can_edit ) ? 'readonly' : '' ?> ><?php echo ( isset( $data['note'] ) ) ? $data['note'] : '' ?></textarea>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top">
                            <div id="wizard_box">
                                <div class="widgets-holder-wrap">
                                    <div class="sidebar-name">
                                        <h3><span style="float: left;"><?php _e( 'Invoice Items', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                            <span style="float: right;"><?php _e( 'Total:', WPC_CLIENT_TEXT_DOMAIN ) ?> <?php echo $currency_symbol['left'] ?><span id="total_items">0</span><?php echo $currency_symbol['right'] ?></span>
                                       </h3>

                                    </div>
                                    <div class="box-holder" style="height: 575px;">

                                        <?php if ( $can_edit ) { ?>
                                        <span style="margin: -3px 0px 3px 5px; display: block; float: right;">
                                        <a rel="" href="#edit_item" class=" various"><?php _e( 'Add New Item', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                                        </span>
                                        <hr />
                                        <?php } ?>

                                        <p class="description"><?php _e( 'Drag Items here.', WPC_CLIENT_TEXT_DOMAIN ) ?></p>
                                        <br class="clear">

                                        <div id="wizard_item_list" class="connectedSortable">
                                            <?php
                                            if ( isset( $data['items'] ) && is_array( $data['items'] ) && 0 < count( $data['items'] ) ) {
                                                foreach( $data['items'] as $item ) {
                                                    $num_items++;
                                            ?>
                                            <div class="item" style="height: auto;">
                                                <div class="postbox">
                                                    <input type="hidden" name="wpc_data[items][]" id="item_values_block_<?php echo $num_items ?>" value="<?php echo base64_encode( json_encode( $item ) ) ?>" />
                                                    <input type="hidden" name="rate[]" id="item_rate1_block_<?php echo $num_items ?>" value="<?php echo $item['rate'] ?>" />
                                                    <h3 class='hndle'>
                                                        <span id="item_name_block_<?php echo $num_items ?>"><?php echo stripslashes( $item['name'] ) ?></span>

                                                        <?php if ( $can_edit ) { ?>
                                                        <span style="float: right;">
                                                            <a class="various" href="#edit_item" title="" rel="<?php echo $num_items ?>" ><?php _e( 'Edit', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                                                        </span>
                                                        <?php } ?>

                                                    </h3>
                                                    <div class="item_description" style="padding: 5px 5px 5px 5px; min-height: 150px; height: auto;">
                                                        <p>
                                                            <strong><?php _e( 'Description:', WPC_CLIENT_TEXT_DOMAIN ) ?></strong>
                                                            <span id="item_description_block_<?php echo $num_items ?>"><?php echo stripslashes( $item['description'] ) ?></span>
                                                        </p>
                                                        <p>
                                                            <strong><?php _e( 'Rate:', WPC_CLIENT_TEXT_DOMAIN ) ?></strong>
                                                            <?php echo $currency_symbol['left'] ?><span id="item_rate2_block_<?php echo $num_items ?>"><?php echo number_format( $item['rate'], 2, '.', '' ) ?></span><?php echo $currency_symbol['right'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </td>

                        <?php if ( $can_edit ) { ?>
                        <td valign="top">
                            <div id="item_box" style="width: 250px;">
                                <div class="widgets-holder-wrap ui-droppable" id="available-widgets">
                                    <div class="sidebar-name">
                                        <h3><?php _e( 'Available Items', WPC_CLIENT_TEXT_DOMAIN ) ?></h3>
                                    </div>
                                    <div class="box-holder" style="height: 575px;">
                                        <p class="description"><?php _e( 'Drag Items from here to a Invoice on the right. Drag Items back here to delete them from Invoice.', WPC_CLIENT_TEXT_DOMAIN ) ?></p>
                                        <br class="clear">

                                        <div id="item_list" class="connectedSortable">
                                            <?php
                                            if ( is_array( $items ) && 0 < count( $items ) ) {
                                                foreach( $items as $item ) {
                                                    unset( $item['id'] );

                                                    $num_items++;
                                            ?>
                                            <div class="item" style="height: auto;">
                                                <div class="postbox">
                                                    <input type="hidden" name="wpc_data[items][]" id="item_values_block_<?php echo $num_items ?>" value="<?php echo base64_encode( json_encode( $item ) ) ?>" />
                                                    <input type="hidden" name="rate[]" id="item_rate1_block_<?php echo $num_items ?>" value="<?php echo $item['rate'] ?>" />
                                                    <h3 class='hndle'>
                                                        <span id="item_name_block_<?php echo $num_items ?>"><?php echo stripslashes( $item['name'] ) ?></span>
                                                        <span style="float: right;">
                                                            <a class="various" href="#edit_item" title="" rel="<?php echo $num_items ?>" ><?php _e( 'Edit', WPC_CLIENT_TEXT_DOMAIN ) ?></a>
                                                        </span>
                                                    </h3>
                                                    <div class="item_description" style="padding: 5px 5px 5px 5px; min-height: 150px; height: auto;">
                                                        <p>
                                                            <strong><?php _e( 'Description:', WPC_CLIENT_TEXT_DOMAIN ) ?></strong>
                                                            <span id="item_description_block_<?php echo $num_items ?>"><?php echo stripslashes( $item['description'] ) ?></span>
                                                        </p>
                                                        <p>
                                                            <strong><?php _e( 'Rate:', WPC_CLIENT_TEXT_DOMAIN ) ?></strong>
                                                            <?php echo $currency_symbol['left'] ?><span id="item_rate2_block_<?php echo $num_items ?>"><?php echo number_format( $item['rate'], 2, '.', '' ) ?></span><?php echo $currency_symbol['right'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>

                                        <br class="clear">
                                    </div>
                                    <br class="clear">
                                </div>
                            </div>
                        </td>
                        <?php } ?>

                    </tr>
                </table>

                <hr />

                <?php if ( $can_edit ) { ?>
                <input type="button" name="save_data" id="save_data2" class="button-primary" value="<?php _e( 'Save Invoice', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                <?php } ?>
                <input type="button" name="data_cancel" id="data_cancel2" class="button" value="<?php _e( 'Cancel', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                <?php if ( $can_edit ) { ?>
                <input type="button" name="save_data_send" id="save_data_send2" class="button-primary" value="<?php _e( 'Save & Send Invoice', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                <?php } ?>
                <?php if ( isset( $_GET['id'] ) && '' != $_GET['id'] && $can_add_payment ) { ?>
                <input type="button" name="" id="open_add_payment2" class="button" value="<?php _e( 'Add Payment', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                <?php } ?>
                <?php if ( isset( $_GET['id'] ) && '' != $_GET['id'] ) { ?>
                <a href="admin.php?page=wpclients_invoicing&wpc_action=download_pdf&id=<?php echo $data['id'] ?>" title="" ><input type="button" name="" id="" class="button" value="<?php _e( 'Download PDF', WPC_CLIENT_TEXT_DOMAIN ) ?>" /></a>
                <?php } ?>

                <?php
                global $wpc_client;
                $current_page = isset( $_GET['page'] ) ? $_GET['page'] : '';
                $wpc_client->get_assign_clients_popup( $current_page );
                $wpc_client->get_assign_circles_popup( $current_page );
                ?>

            </form>


            <?php if ( $can_edit ) { ?>
            <div class="wpc_edit_item" id="edit_item" style="display: none;">
                <h3><?php _e( 'Item:', WPC_CLIENT_TEXT_DOMAIN ) ?> <span id="edit_item"></span></h3>
                <form method="post" name="wpc_edit_item" id="wpc_edit_item">
                    <input type="hidden" id="item_id" value="" />
                    <table>
                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Item Name:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                                    <br />
                                    <input type="text" size="70" name="item_name" id="item_name"  value="" />

                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <?php _e( 'Description:', WPC_CLIENT_TEXT_DOMAIN ) ?>
                                    <br />
                                    <textarea cols="67" rows="5" maxlength="300" id="item_description" ></textarea>
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
                                    <input type="text" size="70" id="item_rate"  value="" />

                                </label>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <div style="clear: both; text-align: center;">
                        <input type="button" class='button-primary' id="save_item" value="<?php _e( 'Save Item', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                        <input type="button" class='button' id="close_edit_item" value="<?php _e( 'Close', WPC_CLIENT_TEXT_DOMAIN ) ?>" />
                    </div>
                </form>
            </div>
            <?php } ?>


            <?php if ( isset( $_GET['id'] ) && '' != $_GET['id'] && $can_add_payment ) { ?>

            <div class="wpc_add_payment" id="add_payment" style="display: none;">
                <h3><?php _e( 'Add Payment:', WPC_CLIENT_TEXT_DOMAIN ) ?></h3>
                <form method="post" name="wpc_add_payment" id="wpc_add_payment">
                    <input type="hidden" name="wpc_payment[inv_id]" id="wpc_payment_inv_id" value="<?php echo $_GET['id'] ?>" />
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

            <?php } ?>

        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    var site_url = '<?php echo site_url();?>';
    var num_items = '<?php echo $num_items + 1 ?>' * 1;

    jQuery( document ).ready( function( ) {

        <?php if ( $can_edit ) { ?>
        //drag and drop items
        jQuery( '#item_list, #wizard_item_list' ).sortable({
            connectWith: ".connectedSortable",
            items: '.item',
            update: function( event, ui ) {
                jQuery( this ).calcTotal();
            },
        }).disableSelection();
        <?php } ?>

        <?php if ( $can_edit ) { ?>
        //data piker
        jQuery( '#wpc_data_due_date' ).datepicker({
            dateFormat : 'mm/dd/yy'
        });
        <?php } ?>

        //Set pre-set due data
        jQuery( '.wpc_set_due_date' ).click( function() {
            jQuery( '#wpc_data_due_date' ).val( jQuery( this ).attr( 'rel' ) );
        });


        //Save data
        jQuery( '#save_data, #save_data2' ).click( function() {
            var errors = 0;

            if ( jQuery( "#clients" ).val() != '' || jQuery( "#circles" ).val() != '' ) {
                jQuery( '#clients' ).parent().parent().attr( 'class', '' );
                jQuery( '#circles' ).parent().parent().attr( 'class', '' );
            } else {
                errors = 1
                jQuery( '#clients' ).parent().parent().attr( 'class', 'wpc_error' );
                jQuery( '#circles' ).parent().parent().attr( 'class', 'wpc_error' );
                jQuery( '#save_data' ).focus();
            }

            if ( 0 == errors ) {
                //remove item id from Available Items block
                jQuery( '#item_box input[type="hidden"]' ).remove();

                jQuery( '#edit_data' ).submit();
            }
            return false;
        });


        //Save & send data
        jQuery( '#save_data_send, #save_data_send2' ).click( function() {
            var errors = 0;

            if ( jQuery( "#clients" ).val() != '' || jQuery( "#circles" ).val() != '' ) {
                jQuery( '#clients' ).parent().parent().attr( 'class', '' );
                jQuery( '#circles' ).parent().parent().attr( 'class', '' );
            } else {
                errors = 1
                jQuery( '#clients' ).parent().parent().attr( 'class', 'wpc_error' );
                jQuery( '#circles' ).parent().parent().attr( 'class', 'wpc_error' );
                jQuery( '#save_data' ).focus();
            }

            if ( 0 == errors ) {
                //set send flag
                jQuery( '#wpc_data_send' ).val( '1' );

                //remove item id from Available Items block
                jQuery( '#item_box input[type="hidden"]' ).remove();

                jQuery( '#edit_data' ).submit();
            }
            return false;
        });


        //cancel edit INV
        jQuery( '#data_cancel, #data_cancel2' ).click( function() {
            self.location.href="<?php echo $return_url ?>";
            return false;
        });


        //change discount %
        jQuery( '#wpc_data_discount' ).change( function() {
            jQuery( this ).calcTotal();
        });


        //change discount type
        jQuery( '#wpc_data_discount_type' ).change( function() {
            jQuery( this ).calcTotal();
        });


        //change Tax
        jQuery( '#data_tax' ).change( function() {
            jQuery( this ).calcTotal();
        });


        //calculate total
        jQuery.fn.calcTotal = function () {

            var tax;
            var discount = jQuery( '#wpc_data_discount' ).val();
            var discount_type = jQuery( '#wpc_data_discount_type' ).val();
            var total_items = 0;
            var total_discount = 0;
            var total_tax = 0;
            var total = 0;

            jQuery( '#wizard_item_list input[name="rate[]"]' ).each( function(){
                total_items = total_items + ( jQuery( this ).val() * 1 );

            });


            if ( 0 < total_items && 0 < discount ) {
                if ( 'fixed' == discount_type ) {
                    total_discount = discount *1;
                } else {
                    total_discount = total_items / 100 * discount;
                }

            }

            if ( 0 < total_items && '' != jQuery( '#data_tax' ).val() ) {
                tax = jQuery( '#data_tax' ).val();
                tax = tax.split( '_' );
                total_tax = ( total_items - total_discount ) / 100 * tax[0];
                total_tax = Math.floor( total_tax * 100) / 100;
            }

            total = total_items - total_discount + total_tax;

            jQuery( '#total_items' ).html( total_items.toFixed(2) );
            jQuery( '#total_items2' ).html( total_items.toFixed(2) );
            jQuery( '#total_discount' ).html( total_discount.toFixed(2) );
            jQuery( '#total_tax' ).html( total_tax.toFixed(2) );
            jQuery( '#total' ).html( total.toFixed(2) );
        };






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

                var item_description = jQuery( '#item_description_block_' + id ).html();

                //check if there are more characters then allowed
                if ( item_description.length > limit ){
                    //and if there are use substr to get the text before the limit
                    item_description = item_description.substr( 0, limit );

                }
                jQuery( '#count_chars' ).html( ( limit - item_description.length ) );

                var item_rate = jQuery( '#item_rate2_block_' + id ).html();
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
                if  ( 0 != jQuery( '#item_id' ).val() ) {
                    var id = jQuery( '#item_id' ).val();
                } else {
                    var html = '';
                    html = '<div class="item"><div class="postbox">';
                    html = html + '<input type="hidden" name="wpc_data[items][]" id="item_values_block_' + num_items + '" value="" />';
                    html = html + '<input type="hidden" name="rate[]" id="item_rate1_block_' + num_items + '" value="" />';
                    html = html + '<h3 class="hndle"><span id="item_name_block_' + num_items + '"></span><span style="float: right;">';
                    html = html + '<a class="various" href="#edit_item" title="" rel="' + num_items + '" ><?php _e( 'Edit', WPC_CLIENT_TEXT_DOMAIN ) ?></a>';
                    html = html + '</span></h3><div class="item_description" style="padding: 5px 5px 5px 5px;">';
                    html = html + '<p><strong><?php _e( 'Description:', WPC_CLIENT_TEXT_DOMAIN ) ?></strong>';
                    html = html + ' <span id="item_description_block_' + num_items + '"></span>';
                    html = html + '</p><p><strong><?php _e( 'Rate:', WPC_CLIENT_TEXT_DOMAIN ) ?></strong>';
                    html = html + ' <?php echo $currency_symbol['left'] ?><span id="item_rate2_block_' + num_items + '"></span><?php echo $currency_symbol['right'] ?>';
                    html = html + '</p></div></div></div>';

                    jQuery( '#wizard_item_list' ).prepend( html );

                    var id = num_items;
                    num_items = num_items + 1;
                }

                var item_rate = jQuery( '#item_rate' ).val() * 1;

                jQuery( '#item_name_block_' + id ).html( jQuery( '#item_name' ).val() );

                jQuery( '#item_description_block_' + id ).html( jQuery( '#item_description' ).val() );
                jQuery( '#item_rate1_block_' + id ).val( item_rate.toFixed(2) );
                jQuery( '#item_rate2_block_' + id ).html( item_rate.toFixed(2) );

                var item =  new Object();
                item.name = jQuery( '#item_name' ).val();
                item.description = jQuery( '#item_description' ).val();
                item.rate = jQuery( '#item_rate' ).val();

                var json = JSON.stringify( item );
                jQuery( '#item_values_block_' + id ).val( jQuery.base64Encode( json ) );

                jQuery( '#item_id' ).val( '' );
                jQuery( '#item_name' ).val( '' );
                jQuery( '#item_description' ).val( '' );
                jQuery( '#item_rate' ).val( '' );

                jQuery( this ).calcTotal();

                jQuery.fancybox.close();
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





        //open Add Payment
        jQuery( '#open_add_payment, #open_add_payment2' ).click( function() {

            //set payment amount
            if ( jQuery( '#total_remaining' ).length ) {
                jQuery( '#wpc_payment_amount' ).val( jQuery( '#total_remaining' ).html() );
            } else {
                jQuery( '#wpc_payment_amount' ).val( jQuery( '#total' ).html() );
            }

            jQuery( '#wpc_add_payment_total' ).html( jQuery( '#total' ).html() );
            jQuery( '#wpc_add_payment_amount_paid' ).html( jQuery( '#wpc_amount_paid' ).html() );

            jQuery( '#wpc_payment_date' ).val( '<?php echo date( 'm/d/Y', time() ) ?>' );

            jQuery.fancybox({
                'type'        : 'inline',
                'fitToView'   : 'false',
                'autoSize'    : 'true',
                'openEffect'  : 'none',
                'closeEffect' : 'none',
                'href'        : '#add_payment'
            });
        });

        //close Add Payment
        jQuery( '#close_add_payment' ).click( function() {
            jQuery.fancybox.close();
        });


        jQuery( '#wpc_payment_date' ).datepicker({
            dateFormat : 'mm/dd/yy'
        });


        //Save payment
        jQuery( '#save_add_payment' ).click( function() {

            var errors = 0;

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





        jQuery( this ).calcTotal();

    });



</script>