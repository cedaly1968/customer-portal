<?php
global $wpc_client;
//value for $user_id - from wpc_client_shortcode_comments() function

if(isset($_POST['submit'])) {


    $sent_from  = get_current_user_id();

    $sent_to    = get_user_meta( $user_id, 'admin_manager', true );
    if ( 1 > $sent_to )
        $sent_to = 0;

    $wpdb->query( $wpdb->prepare(
        "INSERT INTO {$wpdb->prefix}wpc_client_comments SET user_id = %d, page_id = %d, time=%d, comment='%s', sent_from=%d, sent_to=%d, new_flag=1"
        , $user_id
        , $post->ID
        , time()
        , $_POST['comment']
        , $sent_from
        , $sent_to
    ) );

    $notify_message = get_option("wpc_notify_message");

    if($notify_message == "yes") {
        $sender_name    = get_option("sender_name");
        $sender_email   = get_option("sender_email");
        $username       = get_userdata( $sent_from )->get( 'user_login' );
        $admin_url      = get_admin_url() . "admin.php?page=wpclients_messages&user_id=" . $sent_from . "&from_id=" . $sent_from . "&to_id=" . $sent_to;

        $headers = "From: " . get_option("sender_name") . " <" . get_option("sender_email") . "> \r\n";
        $headers .= "Reply-To: " . ( get_option( 'wpc_reply_email' ) ) ? get_option( 'wpc_reply_email' ) : get_option( 'admin_email' ) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        //get email template
        $wpc_templates = get_option( 'wpc_templates' );

        $args = array( 'client_id' => $user_id, 'user_name' => $username, 'message' => nl2br( htmlspecialchars( stripslashes( $_POST['comment'] ) ) )  );
        $subject = $wpc_client->replace_placeholders( $wpc_templates['emails']['notify_admin_about_message']['subject'], $args, 'notify_admin_about_message' );
        $subject = htmlentities( $subject, ENT_QUOTES, 'UTF-8' );
        $message = $wpc_client->replace_placeholders( $wpc_templates['emails']['notify_admin_about_message']['body'], $args, 'notify_admin_about_message' );

        //send notify
        $manager_id = get_user_meta( $user_id, 'admin_manager', true );
        if ( 0 < $manager_id ) {
            //send notify message to client manager
            $manager_email = get_userdata( $manager_id )->get( 'user_email' );
            wp_mail( $manager_email, $subject, $message, $headers );
        } else {
            //send notify message to admin
            wp_mail( get_option('admin_email'), $subject, $message, $headers );
        }



    }

    do_action( 'wp_client_redirect', '' );
}




//Set date format
if ( get_option( 'date_format' ) ) {
    $time_format = get_option( 'date_format' );
} else {
    $time_format = 'm/d/Y';
}
if ( get_option( 'time_format' ) ) {
    $time_format .= ' ' . get_option( 'time_format' );
} else {
    $time_format .= ' g:i:s A';
}



$count_messages = $wpdb->get_var( $wpdb->prepare( "SELECT count(user_id) FROM {$wpdb->prefix}wpc_client_comments WHERE user_id=%d", $user_id ) );
$message_n      = 10;
$messages       = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpc_client_comments WHERE user_id=%d ORDER BY time DESC LIMIT 0, %d", $user_id, $message_n ), "ARRAY_A" );
$code           = md5( 'wpc_client_' . $user_id . '_get_client_mess' );

foreach($messages as $k=>$message) {
    $text = '';
    if ( $current_user->ID == $message['sent_from'] ) {
        $text .= __( 'You', WPC_CLIENT_TEXT_DOMAIN );
    } elseif ( 0 == $message['sent_from'] ) {
        $text .= __( 'Administrator', WPC_CLIENT_TEXT_DOMAIN );
    } else {
        $user = get_userdata( $message['sent_from'] );
        if ( '' != $user->get( 'display_name' ) ) {
            $text .= $user->get( 'display_name' );
        } else {
            $text .= get_user_meta( $message['sent_from'], 'nickname', true );
        }
    }
    $messages[$k]['sent_from_name'] = $text;
    $messages[$k]['date'] = $wpc_client->date_timezone( $time_format, $message['time']);
    $messages[$k]['comment'] =  nl2br( htmlspecialchars( stripslashes( $message['comment'] ) ) );
}

$data['count_messages'] = $count_messages;
$data['message_n']      = $message_n;
$data['more_button']    = "<input type=\"button\" id=\"wpc_show_more_mess\" value=\"" . __( 'Show more messages', WPC_CLIENT_TEXT_DOMAIN ) . "\" />";
$data['messages']       = $messages;
$data['javascript']     = '<input type="hidden" id="wpc_show_more_params" value="'.site_url().','.$user_id.','.$code.','.$count_messages.'" />';
$data['textarea']       = '<textarea style="width: 90%;" name="comment" placeholder="' . __( 'Type your private message here', WPC_CLIENT_TEXT_DOMAIN ) . '"></textarea>';
$data['submit_form']    = '<input type="submit" name="submit" id="submit" class="button-primary" value="' . __( 'Send private message', WPC_CLIENT_TEXT_DOMAIN ) . '" />';
$data['more_messages']  =  __( 'Show more messages', WPC_CLIENT_TEXT_DOMAIN );
$data['messages_title'] =  __( 'Private Message History', WPC_CLIENT_TEXT_DOMAIN );

?>

<?php

$out2 =  $wpc_client->getTemplateContent( 'wpc_client_com', $data );

return $out2;

?>
