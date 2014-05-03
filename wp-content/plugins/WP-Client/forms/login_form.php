<?php

global $wpc_client;

$data['login_url']  = '';

$data['labels']['username'] = __( 'Username', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['password'] = __( 'Password', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['remember'] = __( 'Remember Me', WPC_CLIENT_TEXT_DOMAIN );
$data['somefields']         = '<input type="hidden" name="wpc_login" value="login_form">';

if ( isset( $GLOBALS['wpclient_login_msg'] ) && '' != $GLOBALS['wpclient_login_msg'] ) {
    $data['error_msg'] = $GLOBALS['wpclient_login_msg'];
    unset( $GLOBALS['wpclient_login_msg'] );
} else {
    $data['error_msg'] = '';
}

$out2 = $wpc_client->getTemplateContent( 'wpc_client_loginf', $data );

return $out2;
?>