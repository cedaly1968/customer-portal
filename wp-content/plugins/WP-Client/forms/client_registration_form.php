<?php

$wpc_settings = get_option( 'wpc_settings' );
if ( 'no' == $wpc_settings['client_registration'] ) {
    return __( 'Registration is disabled!', WPC_CLIENT_TEXT_DOMAIN );
}

//unset($_SESSION);

//paid registration
if ( defined( 'WPC_CLIENT_ADDON_PAID_REGISTRATION' ) ) {
    $p_registration_settings = get_option( 'wpc_p_registration_settings' );
    //paid registration enabled
    if ( isset( $p_registration_settings['enable'] ) && '1' == $p_registration_settings['enable'] ) {
        //if client created redirect on checkout page
        if ( isset( $_SESSION['wpc_payment']['client_id'] ) && 0 < $_SESSION['wpc_payment']['client_id'] ) {
            $step = ( isset( $_SESSION['wpc_payment']['step'] ) && 0 < $_SESSION['wpc_payment']['step'] ) ? $_SESSION['wpc_payment']['step'] : 'checkout';
            do_action( 'wp_client_redirect', wpc_client_get_slug( 'client_registration_page_id', false ) . '-step-' . $step );
            exit;
        }
    }
}



extract($_REQUEST);

$error = "";

if ( isset( $btnAdd ) ) {

	// validate at php side
	if ( empty( $contact_name ) ) // empty username
		$error .= __('A Contact Name is required.<br/>', WPC_CLIENT_TEXT_DOMAIN);

	if ( empty( $contact_username ) ) // empty username
		$error .= __('A username is required.<br/>', WPC_CLIENT_TEXT_DOMAIN);

    if ( empty( $contact_email ) ) // empty email
        $error .= __('A email is required.<br/>', WPC_CLIENT_TEXT_DOMAIN);

	if ( username_exists( $contact_username ) ) //  already exsits user name
		$error .= __('Sorry, that username already exists!<br/>', WPC_CLIENT_TEXT_DOMAIN);

	if ( email_exists( $contact_email ) ) // email already exists
		$error .= __('Email address is already in use another Client or standard WordPress user. Please use a unique email address.<br/>', WPC_CLIENT_TEXT_DOMAIN);

	if ( empty( $contact_password ) || empty( $contact_password2 ) ) {
			if ( empty( $contact_password ) ) // password
				$error .= __("Sorry, password is required.<br/>", WPC_CLIENT_TEXT_DOMAIN);
			elseif ( empty( $contact_password2 ) ) // confirm password
				$error .= __("Sorry, confirm password is required.<br/>", WPC_CLIENT_TEXT_DOMAIN);
			elseif ( $contact_password != $contact_password2 )
				$error .= __("Sorry, Passwords are not matched! .<br/>", WPC_CLIENT_TEXT_DOMAIN);
	}


	if ( empty( $error ) ) {
		$userdata = array(
			'user_pass'     => esc_attr ( $contact_password2 ),
			'user_login'    => esc_attr( $contact_username ),
			'nickname'      => esc_attr( $contact_name ),
			'user_email'    => esc_attr( $contact_email ),
            'role'          => 'wpc_client',
			'first_name'    => esc_attr( $business_name ),
            'contact_phone' => esc_attr( $contact_phone ),
            'send_password' => ( isset( $_REQUEST['user_data']['send_password'] ) ) ? esc_attr( $_REQUEST['user_data']['send_password'] ) : '',
		);

        //approve the new client
        if ( isset( $wpc_settings['auto_client_approve'] ) && '1' == $wpc_settings['auto_client_approve'] ) {
            $userdata['to_approve'] = 'auto';
        } else {
            $userdata['to_approve'] = '1';
        }

        //set custom fields
        if ( isset( $custom_fields ) )
            $userdata['custom_fields'] = $custom_fields;

		do_action( 'wp_clients_update', $userdata );


        do_action( 'wp_client_redirect', wpc_client_get_slug( 'successful_client_registration_page_id' ) );
		exit;
	}
}


$data['error']          = $error;
$data['required_text']  = __( '(required)', WPC_CLIENT_TEXT_DOMAIN );

$data['labels']['business_name']        = __( 'Business or Client Name', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['contact_name']         = __( 'Contact Name', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['contact_email']        = __( 'Email', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['contact_phone']        = __( 'Phone', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['contact_username']     = __( 'Username', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['contact_password']     = __( 'Password', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['contact_password2']    = __( 'Confirm Password', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['password_indicator']   = __( 'Strength indicator', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['password_hint']        = __( '>> HINT: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ & ).', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['send_password']        = __( 'Send this password to email?', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['send_password_desc']   = __( 'Check to Enable', WPC_CLIENT_TEXT_DOMAIN );
$data['labels']['send_button']          = __( 'Submit Registration', WPC_CLIENT_TEXT_DOMAIN );


$data['vals']['business_name']        = isset( $_REQUEST['business_name'] ) ? esc_html( $_REQUEST['business_name'] ) : '';
$data['vals']['contact_name']         = isset( $_REQUEST['contact_name'] ) ? esc_html( $_REQUEST['contact_name'] ) : '';
$data['vals']['contact_email']        = isset( $_REQUEST['contact_email'] ) ? esc_html( $_REQUEST['contact_email'] ) : '';
$data['vals']['contact_phone']        = isset( $_REQUEST['contact_phone'] ) ? esc_html( $_REQUEST['contact_phone'] ) : '';
$data['vals']['contact_username']     = isset( $_REQUEST['contact_username'] ) ? esc_html( $_REQUEST['contact_username'] ) : '';
$data['vals']['send_password']        = isset( $_REQUEST['send_password'] ) ? esc_html( $_REQUEST['send_password'] ) : '';

$data['custom_fields'] = wpc_client_get_custom_fields();

?>

<?php

global $wpc_client;
$out2 =  $wpc_client->getTemplateContent( 'wpc_client_registration_form', $data );

return $out2;

?>
