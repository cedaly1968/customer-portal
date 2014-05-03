  jQuery( document ).ready( function() {
        var wpc_offset = 10;
        // AJAX - get more messages
        jQuery( '#wpc_show_more_mess' ).click( function() {
            jQuery( 'body' ).css( 'cursor', 'wait' );

            var data            = jQuery( '#wpc_show_more_params' ).val();
            var data            = data.split(',');

            var site_url        = data[0];
            var user_id         = data[1];
            var code            = data[2];
            var count_messages  = data[3];

            jQuery.ajax({
                type: 'POST',
                url: site_url + '/wp-admin/admin-ajax.php',
                data: 'action=wpc_get_more_messages&user_id=' + user_id + '&offset=' + wpc_offset + '&code=' + code,
                success: function( html ){
                    jQuery( 'body' ).css( 'cursor', 'default' );
                    if ( '' == html || 0 == html ) {
                        jQuery( '#wpc_show_more_mess' ).parent().parent().remove();
                    } else {
                        wpc_offset = wpc_offset + 10;
                        jQuery( '#wpc_show_more_mess' ).parent().parent().before( html );
                        if ( count_messages <= wpc_offset )
                            jQuery( '#wpc_show_more_mess' ).parent().parent().remove();
                    }
                }
             });

        });
    });