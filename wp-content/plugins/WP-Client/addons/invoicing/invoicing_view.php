<?php

global $wpdb, $wp_query, $wpc_client, $wpc_invoicing;

//reset session for payment process
if ( isset( $_SESSION['wpc_payment'] ) ) {
    unset( $_SESSION['wpc_payment'] );
}

$inv_settings = $wpc_invoicing->get_settings();

/*
* Show Feedback wizard
*/
if ( isset( $wp_query->query_vars['wpc_page_value'] ) && '' != $wp_query->query_vars['wpc_page_value'] ) {
    $invoice_id = $wp_query->query_vars['wpc_page_value'];
}

$invoice_data = $wpdb->get_row( $wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}wpc_client_invoicing WHERE CONCAT(prefix, number) = '%s' AND client_id = %d",
    $invoice_id, $client_id ), ARRAY_A
);

//have not access
if ( !isset( $invoice_data['id'] )  )
    return 'err';


$wpnonce            = wp_create_nonce( 'wpc_invoice_view' . $invoice_id );
?>

    <div class="wrap">


        <?php if ( is_array( $invoice_data ) ) { ?>

            <h1 class="wizard_title">
                <?php echo ( 'inv' == $invoice_data['type'] ) ? __( 'Invoice #', WPC_CLIENT_TEXT_DOMAIN ) : __( 'Estimate #', WPC_CLIENT_TEXT_DOMAIN ) ?>
                <?php echo $invoice_data['prefix'] . $invoice_data['number'] ?>
                <?php echo ( isset( $invoice_data['status'] ) && 'paid' == $invoice_data['status'] ) ? '(' . $this->display_status_name( $invoice_data['status'] ) . ')' : '' ?>
            </h1>
            <a href="<?php echo wpc_client_get_slug( 'invoicing_page_id' ) . $invoice_data['prefix'] . $invoice_data['number'] . '/?wpc_action=download_pdf&id=' . $invoice_data['id'] ?>">
                <?php _e( 'Download PDF', WPC_CLIENT_TEXT_DOMAIN ) ?>
            </a>

            <?php if ( 'paid' != $invoice_data['status'] && 'inv' == $invoice_data['type'] ) { ?>
            |
            <a href="<?php echo wpc_client_get_slug( 'invoicing_page_id' ) . $invoice_data['prefix'] . $invoice_data['number'] . '/payment-step-checkout' ?>">
                <?php _e( 'Pay now!', WPC_CLIENT_TEXT_DOMAIN ) ?>
            </a>
            <?php } ?>

            <hr>
            <br>

            <div class="">
            <?php
                echo $wpc_invoicing->invoicing_put_values( $invoice_data);
            ?>
            </div>

        <?php } ?>

    </div><!--/wrap-->


<script type="text/javascript">

    jQuery( document ).ready( function(){


    });

</script>