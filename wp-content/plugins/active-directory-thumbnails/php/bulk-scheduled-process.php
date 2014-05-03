<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Omar
 * Date: 26/06/12
 * Time: 7:18 PM
 * To change this template use File | Settings | File Templates.
 */

require( '../../../../wp-load.php' );

echo 'Starting.....';

adt_bulk_get_users_and_save_pics();

function adt_bulk_get_users_and_save_pics() {

    /*
        First we set how we'll want to sort the user list.
        You could sort them by:
        ------------------------
        * ID - User ID number.
        * user_login - User Login name.
        * user_nicename - User Nice name ( nice version of login name ).
        * user_email - User Email Address.
        * user_url - User Website URL.
        * user_registered - User Registration date.
    */
    $szSort = "user_nicename";
    /*
         Now we build the custom query to get the ID of the users.
     */
    global $wpdb;

    $aUsersID = $wpdb->get_col( $wpdb->prepare(
        "SELECT $wpdb->users.ID FROM $wpdb->users ORDER BY %s ASC"
        , $szSort ));
    /*
         Once we have the IDs we loop through them with a Foreach statement.
     */

    $count = 0;

    foreach ( $aUsersID as $iUserID ) :
        adt_get_user_photo($iUserID);
    endforeach; // end the users loop.
}

function adt_get_user_photo($user_id) {
    global $wpdb;
    $user = get_userdata( $user_id );

    $ad_field_name = get_option('adt_ad_thumbnail');
    $pic_str = $user->$ad_field_name;

    echo $user->user_nicename;
    $file_name = ABSPATH . 'wp-content/uploads/active-directory-thumbnails'  . $user->user_nicename . $user_id . '.jpeg';
    $file_url = get_site_url() . '/wp-content/uploads/active-directory-thumbnails/' . $user->user_nicename . $user_id . '.jpeg';
    if ($pic_str) {
        $data = base64_decode($pic_str);
        $img_data = imagecreatefromstring($data);
        imagejpeg($img_data, $file_name);
        imagedestroy($img_data);
        update_user_meta( $user_id, 'adt_user_photo_url', $file_url );
    } else {
        echo 'User does not have a picture in WordPress.';
    }
}

echo 'Done....';