<?php

global $wpc_client;

$data['logout_url']  = $wpc_client->get_logout_url();
$data['labels']['logout'] = __( 'LOGOUT', WPC_CLIENT_TEXT_DOMAIN );

$out2 =  $wpc_client->getTemplateContent( 'wpc_client_logoutb', $data );

return $out2;
?>