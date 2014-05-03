<?php

ob_start();

global $wpdb, $wpc_client;

if ( !is_user_logged_in() ) {
    do_action( 'wp_client_redirect', $wpc_client->get_login_url() );
    exit;
}

if ( !current_user_can( 'wpc_client' ) )
   return __( 'Sorry, you do not have permission to see this page!', WPC_CLIENT_TEXT_DOMAIN );

$wpc_settings = get_option( 'wpc_settings' );
if ( 'no' == $wpc_settings['staff_registration'] ) {
    return __( 'Staff registration is disabled!', WPC_CLIENT_TEXT_DOMAIN );
}

$error = "";

//save user data
if ( isset( $_REQUEST['update_user'] ) ) {

    // validate at php side

    //empty username
    if ( empty( $_REQUEST['user_data']['user_login'] ) )
        $error .= __( 'A username is required.<br/>', WPC_CLIENT_TEXT_DOMAIN );

    if ( !isset( $_REQUEST['user_data']['ID'] ) ) {
    //already exsits user name
    if ( username_exists( $_REQUEST['user_data']['user_login'] ) )
        $error .= __( 'Sorry, that username already exists!<br/>', WPC_CLIENT_TEXT_DOMAIN );
    }

    // email already exists
    if ( email_exists( $_REQUEST['user_data']['email'] ) ) {
        if ( !isset( $_REQUEST['user_data']['ID'] ) || $_REQUEST['user_data']['ID'] != get_user_by( 'email',  $_REQUEST['manager_data']['email'] )->ID ) {
            // email already exist
            $error .= __( 'Email address already uses.<br/>', WPC_CLIENT_TEXT_DOMAIN );
        }
    }

    if ( empty( $error ) ) {

        $userdata = array(
            'user_pass'         => esc_attr( $_REQUEST['user_data']['pass2'] ),
            'user_login'        => esc_attr( $_REQUEST['user_data']['user_login'] ),
            'user_email'        => esc_attr( $_REQUEST['user_data']['email'] ),
            'first_name'        => esc_attr( $_REQUEST['user_data']['first_name'] ),
            'last_name'         => esc_attr( $_REQUEST['user_data']['last_name'] ),
            'send_password'     => ( isset( $_REQUEST['user_data']['send_password'] ) ) ? esc_attr( $_REQUEST['user_data']['send_password'] ) : '',

        );

        if ( isset( $_REQUEST['user_data']['ID'] ) ) {
            $userdata['ID'] = $_REQUEST['user_data']['ID'];
        } else {
            $userdata['role'] = 'wpc_client_staff';
        }

        if ( isset( $_REQUEST['user_data']['ID'] ) && !isset( $_REQUEST['update_password'] ) ) {
            unset( $userdata['user_pass'] );
        }


        if ( !isset( $userdata['ID'] ) ) {
            //insert new Employee
            $user_id = wp_insert_user( $userdata );

            if ( 'on' == $userdata['send_password'] || '1' == $userdata['send_password'] ) {

                //get email template
                $wpc_templates = get_option( 'wpc_templates' );

                $subject = $wpc_templates['emails']['staff_registered']['subject'];

                $headers = "From: " . get_option("sender_name") . " <" . get_option("sender_email") . "> \r\n";
                $headers .= "Reply-To: " . ( get_option( 'wpc_reply_email' ) ) ? get_option( 'wpc_reply_email' ) : get_option( 'admin_email' ) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $args = array( 'client_id' => $user_id, 'user_password' => $userdata['user_pass'] );
                $subject = $wpc_client->replace_placeholders( $wpc_templates['emails']['staff_registered']['subject'], $args, 'staff_registered' );
                $subject = htmlentities( $subject, ENT_QUOTES, 'UTF-8' );
                $message = $wpc_client->replace_placeholders( $wpc_templates['emails']['staff_registered']['body'], $args, 'staff_registered' );

                wp_mail( $userdata['user_email'], $subject, $message, $headers );
            }

        }

        //assign Employee to client
        update_user_meta( $user_id, 'parent_client_id', get_current_user_id() );
        update_user_meta( $user_id, 'to_approve', '1' );

        //redirect
        if( get_option( 'permalink_structure' ) ) {
            $hub_url = wpc_client_get_hub_link() . '?staff=a';
        } else {
            $hub_url = wpc_client_get_hub_link() . '&staff=a';
        }
        do_action( 'wp_client_redirect', $hub_url );
        exit;
    }
}


//get Employee data
if ( isset( $_REQUEST['user_data'] ) ) {
    $user_data = $_REQUEST['user_data'];
}

?>

<div class='registration_form'>

    <div id="message" class="updated fade" <?php echo ( empty( $error ) )? 'style="display: none;" ' : '' ?> ><?php echo $error; ?></div>

    <form name="edit_employee" id="edit_employee" method="post" >

        <table class="form-table">
                <tr>
                    <td scope="row">
                        <label for="user_login"><?php _e( 'Employee Login', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span></label>
                        <br />
                        <input type="text" name="user_data[user_login]" id="user_login" value="<?php echo ( isset( $user_data['user_login'] ) ) ? $user_data['user_login'] : ''  ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <label for="email"><?php _e( 'E-mail', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span></label>
                        <br />
                        <input type="text" name="user_data[email]" id="email" value="<?php echo ( isset( $user_data['email'] ) ) ? $user_data['email'] : ''  ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <label for="first_name"><?php _e( 'First Name', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                        <br />
                        <input type="text" name="user_data[first_name]" id="first_name" value="<?php echo ( isset( $user_data['first_name'] ) ) ? $user_data['first_name'] : ''  ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <label for="last_name"><?php _e( 'Last Name', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                        <br />
                        <input type="text" name="user_data[last_name]" id="last_name" value="<?php echo ( isset( $user_data['last_name'] ) ) ? $user_data['last_name'] : ''  ?>" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <label for="pass1"><?php _e( 'Password', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span></label>
                        <br />
                        <input type="password" name="user_data[pass1]" autocomplete="off" id="pass1" value="" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <label for="pass1"><?php _e( 'Confirm Password', WPC_CLIENT_TEXT_DOMAIN ) ?> <span class="description"><?php _e( '(required)', WPC_CLIENT_TEXT_DOMAIN ) ?></span></label>
                        <br>
                        <input type="password" name="user_data[pass2]" autocomplete="off" id="pass2" value="" />
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <div id="pass-strength-result" style="display: block;"><?php _e( 'Strength indicator', WPC_CLIENT_TEXT_DOMAIN ) ?></div>
                        <span class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', WPC_CLIENT_TEXT_DOMAIN ) ?></span>
                    </td>
                </tr>
                <tr>
                    <td scope="row">
                        <label for="send_password"><?php _e( 'Send Password?', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                        <br />
                        <label for="send_password"><input type="checkbox" name="user_data[send_password]" id="send_password" /><?php _e( 'Send this password to the new Employee by email.', WPC_CLIENT_TEXT_DOMAIN ) ?></label>
                    </td>
                </tr>
        </table>

        <p class="submit">
            <input type="submit" value="<?php _e( 'Add new Employee', WPC_CLIENT_TEXT_DOMAIN ) ?>" class="button-primary" id="update_user" name="update_user">
        </p>
    </form>

</div>

<?php

$out3 = ob_get_contents();

ob_end_clean();

return $out3;
?>
