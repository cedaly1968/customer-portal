<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Omar
 * Date: 25/06/12
 * Time: 10:53 PM
 * To change this template use File | Settings | File Templates.
 */
require( '../../../../wp-load.php' );

$user_id = $_GET['user_id'];

adt_get_user_photo($user_id);

function adt_get_user_photo($user_id) {
    global $wpdb;
    $user = get_userdata( $user_id );

    $ad_field_name = get_option('adt_ad_thumbnail');
    $pic_str = $user->$ad_field_name;

    echo $user->user_nicename;
    $file_name = ABSPATH . 'wp-content/uploads/active-directory-thumbnails/'  . $user->user_nicename . $user_id . '.jpeg';
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

?>