<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart Software license agreement                                           |
| Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>            |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
| AT THE FOLLOWING URL: http://www.x-cart.com/license.php                     |
|                                                                             |
| THIS AGREEMENT EXPRESSES THE TERMS AND CONDITIONS ON WHICH YOU MAY USE THIS |
| SOFTWARE PROGRAM AND ASSOCIATED DOCUMENTATION THAT QUALITEAM SOFTWARE LTD   |
| (hereinafter referred to as "THE AUTHOR") OF REPUBLIC OF CYPRUS IS          |
| FURNISHING OR MAKING AVAILABLE TO YOU WITH THIS AGREEMENT (COLLECTIVELY,    |
| THE "SOFTWARE"). PLEASE REVIEW THE FOLLOWING TERMS AND CONDITIONS OF THIS   |
| LICENSE AGREEMENT CAREFULLY BEFORE INSTALLING OR USING THE SOFTWARE. BY     |
| INSTALLING, COPYING OR OTHERWISE USING THE SOFTWARE, YOU AND YOUR COMPANY   |
| (COLLECTIVELY, "YOU") ARE ACCEPTING AND AGREEING TO THE TERMS OF THIS       |
| LICENSE AGREEMENT. IF YOU ARE NOT WILLING TO BE BOUND BY THIS AGREEMENT, DO |
| NOT INSTALL OR USE THE SOFTWARE. VARIOUS COPYRIGHTS AND OTHER INTELLECTUAL  |
| PROPERTY RIGHTS PROTECT THE SOFTWARE. THIS AGREEMENT IS A LICENSE AGREEMENT |
| THAT GIVES YOU LIMITED RIGHTS TO USE THE SOFTWARE AND NOT AN AGREEMENT FOR  |
| SALE OR FOR TRANSFER OF TITLE. THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY  |
| GRANTED BY THIS AGREEMENT.                                                  |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * Users-related functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    078ff42e933b8eef8a49274bef74bfbb7e849482, v264 (xcart_4_6_1), 2013-08-16 17:21:34, func.user.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

/**
 * Delete profile from customers table + all associated information
 */
function func_delete_profile($user, $usertype, $is_redirect = true, $not_in_list = true, $next_provider = false)
{
    global $files_dir_name, $single_mode, $sql_tbl;

    global $active_modules, $xcart_dir, $smarty;

    x_load(
        'files',
        'product'
    );

    if (
        (
            $usertype == 'A'
            || (
                !empty($active_modules['Simple_Mode'])
                && $usertype == 'P'
            )
        ) && $not_in_list
    ) {
        $flag = func_query_first_cell("SELECT flag FROM $sql_tbl[customers] LEFT JOIN $sql_tbl[memberships] ON $sql_tbl[customers].membershipid = $sql_tbl[memberships].membershipid WHERE $sql_tbl[customers].usertype='$usertype' AND $sql_tbl[customers].id = '$user'");

        $flag_condition = ($flag == '')
            ? "(flag IS NULL)"
            : "(flag='$flag')";

        $users_count = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[customers] LEFT JOIN $sql_tbl[memberships] ON $sql_tbl[customers].membershipid = $sql_tbl[memberships].membershipid WHERE $sql_tbl[customers].usertype='$usertype' AND $flag_condition AND $sql_tbl[customers].status = 'Y' AND $sql_tbl[customers].activity = 'Y'");

        if ($users_count == 1) {

            if ($is_redirect)
                func_header_location("error_message.php?last_admin");

            return false;

        }

    }

    if (
        $usertype == 'P'
        && !$single_mode
    ) {
        // If user is provider delete some associated info to keep DB integrity
        // Delete products

        $products = func_query("SELECT productid FROM $sql_tbl[products] WHERE provider='$user'");

        if (!empty($products)) {

            foreach($products as $product) {

                func_delete_product($product['productid']);

            }

        }

        // Delete Shipping, Discounts, Coupons, States/Tax, Countries/Tax

        db_query("DELETE FROM $sql_tbl[shipping_rates] WHERE provider='$user'");
        db_query("DELETE FROM $sql_tbl[discounts] WHERE provider='$user'");
        db_query("DELETE FROM $sql_tbl[discount_coupons] WHERE provider='$user'");
        db_query("DELETE FROM $sql_tbl[tax_rates] WHERE provider='$user'");
        db_query("DELETE FROM $sql_tbl[provider_commissions] WHERE userid='$user'");
        db_query("DELETE FROM $sql_tbl[seller_addresses] WHERE userid='$user'");

        // Extra fields to delete
        $extra_fields_to_delete = db_query("SELECT fieldid FROM $sql_tbl[extra_fields] WHERE provider='$user'");

        if ($extra_fields_to_delete) {

            while ($value = db_fetch_array($extra_fields_to_delete)) {
                db_query("DELETE FROM $sql_tbl[extra_fields_lng] WHERE fieldid='$value[fieldid]'");
            }

            db_query("DELETE FROM $sql_tbl[extra_fields] WHERE provider='$user'");

            db_free_result($extra_fields_to_delete);

        }



        // Search the zones created by provider...
        $zones_to_delete = db_query("SELECT zoneid FROM $sql_tbl[zones] WHERE provider='$user'");

        if ($zones_to_delete) {

            while ($value = db_fetch_array($zones_to_delete)) {
                // Delete zone related information...

                db_query("DELETE FROM $sql_tbl[zone_element] WHERE zoneid='$value[zoneid]'");

            }

            // Delete zone information...
            db_query("DELETE FROM $sql_tbl[zones] WHERE provider='$user'");

            db_free_result($zones_to_delete);
        }

        // Delete provider's file dir

        x_load('backoffice');

        @func_rm_dir(func_get_files_location($user, $usertype));

    } elseif (in_array($usertype, array('P', 'A'))) {

        if (!is_numeric($next_provider)) {

            $next_provider = func_get_next_provider($user);

        }

        $next_provider_data = array(
            'provider' => $next_provider,
        );

        $tables_to_update = array(
            'products',
            'shipping_rates',
            'discounts',
            'discount_coupons',
            'extra_fields',
            'tax_rates',
            'zones',
            'manufacturers',
            'order_details',
        );

        if (func_is_defined_module_sql_tbl('Product_Configurator', 'pconf_product_types')) {
            $tables_to_update[] = 'pconf_product_types';
        }

        if (func_is_defined_module_sql_tbl('Feature_Comparison', 'feature_classes')) {
            $tables_to_update[] = 'feature_classes';
        }

        if (func_is_defined_module_sql_tbl('Special_Offers', 'offer_bonuses')) {
            $tables_to_update[] = 'offer_bonuses';
            $tables_to_update[] = 'offer_conditions';
            $tables_to_update[] = 'offers';
        }

        foreach ($tables_to_update as $table) {

            func_array2update($table, $next_provider_data, "provider = '$user'");

        }

    }

    // If it is partner, then remove all his information

    if (
        $usertype == 'B'
        && func_is_defined_module_sql_tbl('XAffiliate', 'partner_clicks')
    ) {
        db_query("DELETE FROM $sql_tbl[partner_clicks] WHERE userid='$user'");
        db_query("DELETE FROM $sql_tbl[partner_commissions] WHERE userid='$user'");
        db_query("DELETE FROM $sql_tbl[partner_payment] WHERE userid='$user'");
        db_query("DELETE FROM $sql_tbl[partner_views] WHERE userid='$user'");

        db_query("UPDATE $sql_tbl[customers] SET parent = '0' WHERE parent = '$user' AND usertype = '$usertype'");
    }

    db_query("DELETE FROM $sql_tbl[register_field_values] WHERE userid='$user'");
    db_query("DELETE FROM $sql_tbl[old_passwords] WHERE userid='$user'");
    db_query("DELETE FROM $sql_tbl[customers] WHERE id='$user'");
    db_query("DELETE FROM $sql_tbl[stats_cart_funnel] WHERE userid='$user'");
    db_query("DELETE FROM $sql_tbl[login_history] WHERE userid='$user'");
    db_query("DELETE FROM $sql_tbl[stats_customers_products] WHERE userid='$user'");
    db_query("DELETE FROM $sql_tbl[wishlist] WHERE userid = '$user'");
    db_query("DELETE av.* FROM $sql_tbl[register_field_address_values] AS av INNER JOIN $sql_tbl[address_book] AS bk ON av.addressid=bk.id WHERE bk.userid = '$user'");
    db_query("DELETE FROM $sql_tbl[address_book] WHERE userid = '$user'");
    db_query("DELETE FROM $sql_tbl[export_ranges] WHERE userid = '$user'");

    if (func_is_defined_module_sql_tbl('Special_Offers', 'customer_bonuses')) {
        db_query("DELETE FROM $sql_tbl[customer_bonuses] WHERE userid = '$user'");
    }

    if (func_is_defined_module_sql_tbl('PayPalAuth', 'ppa')) {
        db_query("DELETE FROM $sql_tbl[ppa] WHERE userid = '$user'");
    }
    
    if (func_is_defined_module_sql_tbl('TwoFactorAuth', 'twofactor_users')) {
        db_query("DELETE FROM $sql_tbl[twofactor_users] WHERE userid = '$user'");
    }

    return true;
}

function func_get_next_provider($exclude)
{

    $list = func_get_next_providers($exclude);

    if (count($list) == 0)
        return 0;

    $list = array_shift($list);

    return $list['id'];
}

function func_get_next_providers($exclude)
{
    global $sql_tbl;

    if (is_numeric($exclude)) {

        $where = "!= '$exclude'";

    } elseif (is_array($exclude)) {

        $where = "NOT IN ('".implode("', '", $exclude)."')";

    } else {

        return array();

    }

    $list = func_query("SELECT * FROM $sql_tbl[customers] WHERE id $where AND usertype = 'P' AND activity = 'Y' AND status = 'Y'");

    if (empty($list)) {

        $list = func_query("SELECT * FROM $sql_tbl[customers] WHERE id $where AND usertype = 'P'");

    }

    return empty($list)
        ? array()
        : $list;
}

function func_get_provider_counters($provider)
{
    global $sql_tbl;

    $return = array(
        'parts' => array(
            'products'         => func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[products] WHERE provider = '$provider'"),
            'shipping_rates'   => func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[shipping_rates] WHERE provider = '$provider'"),
            'discounts'        => func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[discounts] WHERE provider = '$provider'"),
            'discount_coupons' => func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[discount_coupons] WHERE provider = '$provider'"),
            'extra_fields'     => func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[extra_fields] WHERE provider = '$provider'"),
            'tax_rates'        => func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[tax_rates] WHERE provider = '$provider'"),
            'zones'            => func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[zones] WHERE provider = '$provider'")
        )
    );

    $return['total'] = array_sum($return['parts']);

    return $return;
}

/**
 * Gets information about user profile
 *
 * @param int   $user          User ID
 * @param mixed $usertype      Usertype (A,P,B,C)
 * @param bool  $need_password Flag to include password inforamtion
 * @param bool  $need_cc       Fake unsed flag
 * @param mixed $profile_area  Profile area (A,P,B,C,H)
 * @param bool $merge_cart_info Flag to merge userinfo with cart user_info
 *
 * @return mixed
 * @see    ____func_see____
 */
function func_userinfo($user, $usertype = '', $need_password = false, $need_cc = '', $profile_area = NULL, $merge_cart_info = true, $use_cache = USE_CACHE)
{
    global $sql_tbl, $single_mode, $shop_language, $config;

    global $active_modules;

    // $cart['used_s_address'] can be changed in Func_adjust_customer_address when $merge_cart_info is true
    // $cart['used_*_address'] in Func_adjust_customer_address when $merge_cart_info is true
    global $cart;

    static $result = array();
    $cart_used_b_address = func_get_cart_address('b');
    $cart_used_s_address = func_get_cart_address('s');

    $_anonymous_userinfo = func_get_anonymous_userinfo();

    $need_password = (bool)$need_password;
    $user = abs(intval($user));
    $usertype = (string)$usertype;
    $merge_cart_info = (bool)$merge_cart_info;

    if ( 0 === $user) {
        // Anonymous profile
        $need_password = false;
    }        

   if ($use_cache == USE_CACHE) {
       $md5_args = md5(serialize(array(
            $user, 
            $usertype, 
            $need_password, 
            $profile_area, 
            $_anonymous_userinfo, 
            $merge_cart_info, 
            $cart_used_b_address,
            $cart_used_s_address
        )));

        if (isset($result[$md5_args])) {
            return $result[$md5_args];
        }
    } else {
        $md5_args = '';
    }

    if ( 
        0 === $user
        || defined('XAOM') // Treat the current user as anonymous for XAOM
    ) {

        // Anonymous profile or use _anonymous_userinfo array from AOM

        if (
            empty($_anonymous_userinfo)
            || !$_anonymous_userinfo
        ) {
            $result[$md5_args] = false;
            return false;
        }

        $userinfo = $_anonymous_userinfo = func_stripslashes($_anonymous_userinfo);

    } else {

        // Get info about registered user

        if ($need_password) {
            x_load('crypt');
            assert('false /* $need_password param is obsolete for ' . __FUNCTION__ . ' function from XC4.5.5 version*/');
        }

        $usertype_query = (empty($usertype))
            ? ''
            : " AND $sql_tbl[customers].usertype='$usertype'";

        $userinfo = func_query_first("SELECT $sql_tbl[customers].*, $sql_tbl[memberships].membership, pm.membership as pending_membership, $sql_tbl[memberships].flag FROM $sql_tbl[customers] LEFT JOIN $sql_tbl[memberships] ON $sql_tbl[memberships].membershipid = $sql_tbl[customers].membershipid LEFT JOIN $sql_tbl[memberships] as pm ON pm.membershipid = $sql_tbl[customers].pending_membershipid WHERE $sql_tbl[customers].id='$user' $usertype_query");

        if (!$userinfo) {

            $result[$md5_args] = false;
            return false;

        }

    }

    if (
        !empty($userinfo)
        && empty($usertype)
    ) {
        $usertype = $userinfo['usertype'];
    }

    if (
        is_null($profile_area)
        || empty($profile_area)
    ) {
        $profile_area = $usertype;
    }

    if (!is_array($profile_area)) {

        $profile_area = array($profile_area);

    }

    if (!empty($userinfo)) {

        if (!empty($userinfo['title'])) {
            $userinfo['titleid'] = func_detect_title(addslashes($userinfo['title']));
            $userinfo['title']   = func_get_title($userinfo['titleid']);
        }            

        if (
            $need_password
            && !empty($userinfo['password'])
        ) {

            $userinfo['passwd1'] = $userinfo['passwd2'] = $userinfo['password'] = text_decrypt($userinfo['password']);

            if (is_null($userinfo['password'])) {
                x_log_flag('log_decrypt_errors', 'DECRYPT', "Could not decrypt password for the user " . $userinfo['login'], true);
            }

        }
    }

    // Get seller address if user is provider

    if (
        $usertype == 'P'
        && !$single_mode
    ) {
        $seller_address = func_query_first("SELECT * FROM $sql_tbl[seller_addresses] WHERE userid='$user'");

        if (!empty($seller_address)) {

            func_unset($seller_address, 'userid');

            list(
                $seller_address['address'],
                $seller_address['address_2']
            ) = func_split_by_eol($seller_address['address'], 2);

            foreach($seller_address as $k => $v) {

                $_seller_address['seller_' . $k] = $v;

            }

            $_seller_address['seller_statename']   = func_get_state($_seller_address['seller_state'], $_seller_address['seller_country']);
            $_seller_address['seller_countryname'] = func_get_country($_seller_address['seller_country']);
        }

        $_seller_address['need_arb_info'] = (func_query_first_cell("SELECT active FROM $sql_tbl[shipping] WHERE active='Y' AND code='ARB'") == 'Y')
            && ($config['Shipping']['realtime_shipping'] == 'Y');

        $userinfo = func_array_merge($userinfo, $_seller_address);

    }

    if (
        $userinfo['usertype'] == 'B'
        && !empty($active_modules['XAffiliate'])
    ) {

        $userinfo['plan_id'] = func_query_first_cell("SELECT plan_id FROM $sql_tbl[partner_commissions] WHERE userid = '$userinfo[id]'");

    }

    if (isset($userinfo['email']))
        $email = $userinfo['email'];

    // Get additional fields
    $additional_fields = func_get_additional_fields($profile_area, $user);
    $userinfo['additional_fields'] = $additional_fields;

    // Get default fields
    $default_fields = func_get_default_fields($profile_area, 'user_profile', true, true);
    $userinfo['default_fields'] = $default_fields;

    func_clean_user_profile($userinfo, $profile_area);

    // Get default address fields
    $default_address_fields = func_get_default_fields($profile_area, 'address_book', true, true);
    $userinfo['default_address_fields'] = $default_address_fields;

    // Get field sections
    if (
        $default_fields
        || $additional_fields
        || $default_address_fields
    ) {
        $userinfo['field_sections'] = func_get_profile_areas($profile_area);
    }

    // Get default address information and fill profile
    if ($usertype == 'C') {

        if (
            $user > 0
            && !defined('XAOM') // Treat the current user as anonymous for XAOM
        ) {

            $address_def = func_get_default_address($user);
            if (!empty($active_modules['Klarna_Payments'])) {
                func_klarna_update_addresses($cart, $address_def);
            }

            if (!empty($address_def)) {

                $userinfo['address'] = $address_def;

                foreach ($address_def as $type => $address) {

                    $userinfo = func_array_merge(
                        $userinfo, 
                        func_extract_address($address, $type, $default_address_fields)
                    );
                }

                if (!empty($userinfo['additional_fields'])) {
                    $address_def_ids = array('B' => $address_def['B']['id']);
                    if (!empty($address_def['S']['id'])) {
                        $address_def_ids['S'] = $address_def['S']['id'];
                    } else {
                        $address_def_ids['S'] = $address_def_ids['B'];
                    }
                    list($userinfo['additional_fields'], $unused) = func_adjust_address_additional_values($userinfo['additional_fields'], $address_def_ids);
                }

            }

        } elseif (
            isset($_anonymous_userinfo['address'])
            && !empty($_anonymous_userinfo['address'])
        ) {

            // Prepare address information

            foreach ($_anonymous_userinfo['address'] as $type => $address) {

                $address = $userinfo['address'][$type] = func_prepare_address($address);

                $userinfo = func_array_merge(
                    $userinfo,
                    func_extract_address($address, $type, $default_address_fields)
                );

            }

            // Prefill shipping address with billing one
            // in case shipping address is empty (ship2diff not checked)

            if (
                !isset($userinfo['address']['S'])
                || empty($userinfo['address']['S'])
            ) {
                $userinfo['address']['S'] = $userinfo['address']['B'];

                $userinfo = func_array_merge(
                    $userinfo,
                    func_extract_address($userinfo['address']['S'], 'S', $default_address_fields)
                );

                if (!empty($userinfo['additional_fields'])) {
                    foreach ($userinfo['additional_fields'] as $a_id => $additional_field) {
                        if ($additional_field['section'] == 'B' && isset($userinfo['additional_fields'][$a_id]['value']['B'])) {
                            $userinfo['additional_fields'][$a_id]['value']['S'] = $userinfo['additional_fields'][$a_id]['value']['B'];
                        }
                    }
                }
            }
        }

    }


    if (
        $user > 0 
        && $merge_cart_info
        && 
            (
                !empty($cart_used_b_address)
                || !empty($cart_used_s_address)
            )
        && !defined('XAOM') // Treat the current user as anonymous for XAOM
    ) {
        // Adjust addresses for logged in customer ($cart can be changed)
        list($cart, $userinfo) = func_adjust_customer_address($cart, $userinfo);

        if (!empty($userinfo['additional_fields'])) {
            list($userinfo['additional_fields'], $unused) = func_adjust_address_additional_values($userinfo['additional_fields']);
        }
    }

    // Add these fields for backward compatibility with 43x code like payment gateways
    $userinfo['phone'] = empty($userinfo['b_phone']) ? @$userinfo['s_phone'] : $userinfo['b_phone'];
    $userinfo['fax'] = empty($userinfo['b_fax']) ? @$userinfo['s_fax'] : $userinfo['b_fax'];

    if (empty($userinfo['language']) && (!empty($shop_language))) {
        $userinfo['language'] = $shop_language;
    }

    $result[$md5_args] = $userinfo;

    return $userinfo;
}

/**
 * This function suspends account
 */
function func_suspend_account($userid, $usertype, $reason = '')
{
    global $sql_tbl, $config, $active_modules;
    global $mail_smarty;

    $userid = func_query_first_cell("SELECT id FROM $sql_tbl[customers] WHERE id='$userid' AND usertype='$usertype' AND status='Y'");

    if (empty($userid))
        return false;

    do {

        $activation_key = func_get_secure_random_key(32);

    } while (func_query_first_cell("SELECT COUNT(activation_key) FROM $sql_tbl[customers] WHERE activation_key='$activation_key'"));
    $updated_data = array(
        'status'         => 'N',
        'activation_key' => $activation_key,
        'autolock'       => ($reason == 'autolock') ? 'Y' : '',
        'suspend_date'   => XC_TIME,
    );
    $_old_user_data = func_query_first("SELECT * FROM $sql_tbl[customers] WHERE id='$userid'");

    func_update_user_signature($_old_user_data, $updated_data);
    func_array2update(
        'customers',
        $updated_data,
        "id = '$userid'"
    );

    $userinfo = func_userinfo($userid, $usertype);
    $lock_login_attempts = in_array($usertype, array('A', 'P')) ? 3 : $config['Security']['lock_login_attempts'];

    $mail_smarty->assign('activation_key', $activation_key);
    $mail_smarty->assign('userinfo',       $userinfo);
    $mail_smarty->assign('reason',         $reason);
    $mail_smarty->assign('usertype',       $usertype);
    $mail_smarty->assign('lock_login_attempts', $lock_login_attempts);

    $mail_template = 'account_activation_key';

    if (!empty($active_modules['Email_Activation']) && func_email_activation_check_suspend_reason($reason)) {
        $mail_template = func_email_activation_get_template_name();
    }

    return func_send_mail(
        $userinfo['email'],
        'mail/' . $mail_template . '_subj.tpl',
        'mail/' . $mail_template . '.tpl',
        $config['Company']['users_department'],
        false
    );
}

/**
 * This function enables account
 */
function func_enable_account($activation_key = '', $userid = false)
{
    global $sql_tbl;

    if (
        !$userid
        && !empty($activation_key)
    ) {
        $userid = func_query_first_cell("SELECT id FROM $sql_tbl[customers] WHERE activation_key='$activation_key'");
    }

    if (empty($userid)) {

        return false;

    }

    $update = array(
        'status'         => 'Y',
        'activation_key' => '',
        'autolock'       => 'N',
        'suspend_date'   => 0,
    );

    $where = "id='$userid'";

    if (!empty($activation_key)) {

        $where .= " AND activation_key='$activation_key'";

    }

    $_old_user_data = func_query_first("SELECT * FROM $sql_tbl[customers] WHERE $where");
    if (!empty($_old_user_data)) {
        func_update_user_signature($_old_user_data, $update);
        func_array2update('customers', $update, $where);
    }

    return $userid;
}

/**
 * This function checks password strength
 */
// Returns true if password is weak.

function func_is_password_weak($password)
{
    global $config;

    $default_passwords = array(
        'admin',
        'provider',
        'master',
        'root',
    );

    return 
        in_array($password, $default_passwords)
        || !(
            preg_match('/.{7,}/s', $password)
            && preg_match('/[a-z]/is', $password)
            && preg_match('/[0-9]/s', $password)
            && preg_match('/\S/s', $password)
        );
}

/** 
 * Checking whether the password entered by the user is the same as any of the four previously used passwords
 */
function func_has_same_old_passwords($userid, $test_password) { // {{{
    global $sql_tbl, $config;

    $performance_limit = 4;
    $old_passwords = func_query_column("SELECT password FROM $sql_tbl[old_passwords] WHERE userid='$userid' ORDER BY id DESC LIMIT $performance_limit");

    if (empty($old_passwords))
        return FALSE;

    foreach ($old_passwords as $old_password) {
        if (text_verify($test_password, text_decrypt($old_password)))
            return TRUE;
    }

    return FALSE;
} // }}}

/**     
 * Change password for user,save old password if not empty
 */         
function func_change_user_password($xuserid, $new_password, $_old_password = '') { // {{{
    global $sql_tbl;

    if (!empty($_old_password)) {
        $old_passwords_ids = func_query_column("SELECT id FROM $sql_tbl[old_passwords] WHERE userid='$xuserid' ORDER BY id DESC LIMIT 2");
            
        if (!func_array_empty($old_passwords_ids)) {
        
            $old_passwords_ids = implode("', '", $old_passwords_ids);
            
            db_query("DELETE FROM $sql_tbl[old_passwords] WHERE id NOT IN ('$old_passwords_ids') AND userid='$xuserid'");
            
        }
            
        func_array2insert(
            'old_passwords',
            array(
                'userid'    => $xuserid,
                'password'  => addslashes($_old_password),
            ),
            true
        );
        
        db_query("DELETE FROM $sql_tbl[reset_passwords] WHERE userid='$xuserid'");
    }
        
    $updated_data = array(
        'password'              => addslashes(text_crypt(text_hash($new_password))),
        'change_password'       => 'N',
        'change_password_date'  => XC_TIME,
    );
    $_old_user_data = func_query_first("SELECT * FROM $sql_tbl[customers] WHERE id='$xuserid'");

    func_update_user_signature($_old_user_data, $updated_data);
    func_array2update(
        'customers',
        $updated_data,
        "id='$xuserid'"
    );

    return TRUE;
} // }}}

/**
 * This function validate accordance a county ID to a state and country code
 */
function func_check_county($countyid, $statecode, $countrycode)
{
    global $sql_tbl;

    $return = true;

    if (is_numeric($countyid)) {

        $statecode = addslashes($statecode);

        if (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[states] WHERE code='$statecode' AND country_code='$countrycode'") > 0) {

            $return = (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[counties], $sql_tbl[states] WHERE $sql_tbl[counties].stateid=$sql_tbl[states].stateid AND $sql_tbl[counties].countyid='$countyid' AND $sql_tbl[states].code='$statecode' AND $sql_tbl[states].country_code='$countrycode'") == 1);

        }

    }

    return $return;
}

/**
 * This function validate accordance a postal code to a country code
 */
function func_check_zip($zipcode, $countrycode, $substr = true)
{

    $countrycode = trim($countrycode);

    if (!$zipcode || !$countrycode) return false;

    $zip_code_rules = array();

    // Update check_zipcode_js.tpl after any changes
    $zip_code_rules['AT'] = '/^(.{4})$/Si';
    $zip_code_rules['CA'] = '/^(.{6,7})$/Si';
    $zip_code_rules['CH'] = '/^(.{4})$/Si';
    $zip_code_rules['DE'] = '/^(\d{5})$/Si';
    $zip_code_rules['LU'] = '/^(\d{4})$/Si';
    $zip_code_rules['US'] = '/^(\d{5})$/Si';

    $rule = @$zip_code_rules[$countrycode];

    if (empty($rule))
        return $zipcode;

    if ($substr) {
        // The same is $zipcode = substr(0,$maxlen,$zipcode)    ;

        $_zipcode = preg_replace($rule, "\\1", $zipcode);

        $zipcode = empty($_zipcode) ? $zipcode : $_zipcode;

    } else {
        // Do check instead of substr

        if (!preg_match($rule, $zipcode, $arr))
            $zipcode = false;

    }

    if ($substr && $zipcode)
        $zipcode = substr($zipcode, 0, 32);

    return $zipcode;
}

/**
 * This function validate accordance a state code to a country code
 */
function func_check_state($states, $statecode, $countrycode)
{

    $country_flag = $state_flag = false;

    $return = true;

    foreach ($states as $val) {

        if ($val['country_code'] == $countrycode) {

            $country_flag = true;

            if ($val['state_code'] == $statecode)
                $state_flag = true;

        }

    }

    if ($country_flag && !$state_flag)
        $return = false;

    return $return;
}

function func_detect_state_by_zipcode($country, $zipcode) { // {{{
    global $sql_tbl;

    if (empty($zipcode))
        return '';

    $sub_zipcode = explode(' ', $zipcode, 2);
    if (empty($sub_zipcode[1])) {
        $sub_zipcode = substr($sub_zipcode[0], 0, 3);
    } else {
        $sub_zipcode = trim($sub_zipcode[0]);
    }
           
    if (   
        !empty($sub_zipcode)
        && ($s_code = func_query_first_cell("SELECT code FROM $sql_tbl[states_districts] WHERE country_code='$country' AND code_district='$sub_zipcode'"))
    ) {
        return $s_code;
    }

    return '';
} // }}}

/**
 * Get default register fields settings
 */
function func_get_default_fields($fields_area, $page = 'user_profile', $avail_only = false, $quick_hash = false) { // {{{
    global $config;
    global $default_user_profile_fields;
    global $default_address_book_fields;
    global $default_contact_us_fields;

    global $shop_language;

    global $xcart_dir;
    require_once "$xcart_dir/include/data_cache.php";

    settype($page, 'string');
    settype($avail_only, 'boolean');
    settype($quick_hash, 'boolean');

    $md5_args = md5(serialize(array(
        $default_user_profile_fields, $default_address_book_fields, $default_contact_us_fields,
        $fields_area, $page, $avail_only, $quick_hash, 
        $config['User_Profiles']['register_fields'], 
        $config['User_Profiles']['address_book_fields'], 
        $config['Contact_Us']['contact_us_fields'],
        $config['default_customer_language'],
        $config['default_admin_language'],
        $config['General']['zip4_support'],
        $shop_language // To work cache correctly for the function call stack:func_get_default_field->func_get_langvar_by_name
    )));

    if ($data = func_get_cache_func($md5_args, 'get_default_fields')) {
        return $data;
    }

    static $_default_register_fields = null;
    static $_default_address_book_fields = null;
    static $_default_contact_us_fields = null;

    if (is_null($_default_register_fields)) {
        $_default_register_fields =
            isset($config['User_Profiles']['register_fields'])
            ? unserialize($config['User_Profiles']['register_fields'])
            : false;
    }

    if (is_null($_default_address_book_fields)) {
        $_default_address_book_fields =
            isset($config['User_Profiles']['address_book_fields'])
            ? unserialize($config['User_Profiles']['address_book_fields'])
            : false;
    }

    if (is_null($_default_contact_us_fields)) {
        $_default_contact_us_fields =
            isset($config['Contact_Us']['contact_us_fields'])
            ? unserialize($config['Contact_Us']['contact_us_fields'])
            : false;
    }

    switch ($page) {

        case 'user_profile':
            $default_fields = $_default_register_fields;
            $init_fields = $default_user_profile_fields;
            break;

        case 'address_book':
            $default_fields = $_default_address_book_fields;
            $init_fields = $default_address_book_fields;
            if ($config['General']['zip4_support'] == 'Y' && isset($init_fields['zipcode'])) {
                $init_fields['zip4'] = $init_fields['zipcode'];
                foreach ($init_fields['zip4']['required'] as $rk => $rv) {
                    $init_fields['zip4']['required'][$rk] = 'N';
                }
            }
            break;

        case 'contact_us':
            $default_fields = $_default_contact_us_fields;
            $init_fields = $default_contact_us_fields;
    }

    if (!$default_fields) {

        $default_fields = array();

        foreach ($init_fields as $k => $v) {

            $tmp = array();
            $tmp['title'] = func_get_default_field($k);
            $tmp['field'] = $k;

            foreach (array('avail', 'required') as $fn) {

                if (is_array($v[$fn]) && is_array($fields_area)) {

                    foreach ($fields_area as $fa) {
                        $tmp[$fn] = 'N';
                        if ($v[$fn][$fa] == 'Y') {
                            $tmp[$fn] = 'Y';
                            break;
                        }
                    }

                } else {

                    $tmp[$fn] = is_array($v[$fn]) ? $v[$fn][$fields_area] : $v[$fn];

                }

            }

            if (
                !$avail_only
                || $tmp['avail'] == 'Y'
            ) {
                $default_fields[$k] = (!$quick_hash) ? $tmp : 1;
            }

        }

    } else {

        $tmp = array();

        foreach ($default_fields as $k => $v) {

            $is_avail = false;
            $is_required = false;

            if (is_array($fields_area)) {

                foreach ($fields_area as $fa) {

                    if (!empty($fa) && strpos($v['avail'], $fa) !== FALSE)
                        $is_avail = true;

                    if (!empty($fa) && strpos($v['required'], $fa) !== FALSE)
                        $is_required = true;
                }

            } else {

                $is_avail    = !empty($fields_area) && strpos($v['avail'], $fields_area) !== FALSE;
                $is_required = !empty($fields_area) && strpos($v['required'], $fields_area) !== FALSE;

            }

            if (
                !$avail_only
                || $is_avail
            ) {

                if (!$quick_hash) {

                    $tmp[$v['field']] = array(
                        'avail'    => $is_avail ? 'Y' : '',
                        'required' => $is_required ? 'Y' : '',
                        'title'    => func_get_default_field($v['field'])
                    );

                } else {

                    $tmp[$v['field']] = true;

                }

            }

        }

        $default_fields = $tmp;

        unset($tmp);
    }

    func_save_cache_func($default_fields, $md5_args, 'get_default_fields');
    return $default_fields;
} // }}}

/**
 * Detect available profile areas
 *
 * @param mixed $profile_area Profile area
 *                            P - Personal info
 *                            B - Billing address
 *                            S - Shipping address
 *                            A - Additional info
 *
 * @return void
 * @see    ____func_see____
 */
function func_get_profile_areas($profile_area = false)
{
    global $sql_tbl, $config;

    if (
        !$profile_area
        || empty($profile_area)
    ) {

        return array();

    }

    $profile_fields      = func_get_default_fields($profile_area, 'user_profile', true, true);
    $address_book_fields = func_get_default_fields($profile_area, 'address_book', true, true);
    $additional_fields   = func_get_additional_fields($profile_area);

    $is_areas = array(
        'P' => !empty($profile_fields),
        'B' => !empty($address_book_fields),
        'S' => !empty($address_book_fields) && $config['Shipping']['need_shipping_section'] == 'Y',
        'A' => false,
    );

    if ($additional_fields) {

        foreach ($is_areas as $k => $v) {

            if ($v)
                continue;

            foreach ($additional_fields as $v2) {

                if (
                    $v2['section'] == $k
                    && $v2['avail'] == 'Y'
                ) {

                    $is_areas[$k] = true;
                    if ($k == 'B') {
                        $is_areas['S'] = true;
                    }

                    break;

                }

            }

        }

    }

    return $is_areas;

}

/**
 * Get additional register fields settings
 */
function func_get_additional_fields($area = '', $user = '', $section = '')
{
    global $sql_tbl, $shop_language, $is_anonymous;

    $_anonymous_userinfo = func_get_anonymous_userinfo();

    if ($area) {

        if (!is_array($area))
            $area = array($area);

        $avail_condition     = "($sql_tbl[register_fields].avail LIKE '%" . implode("%' OR $sql_tbl[register_fields].avail LIKE '%", $area) . "%')";

        if (!empty($section)) {
            $avail_condition .= " AND $sql_tbl[register_fields].section = '$section'";
        }

        $required_condition = "($sql_tbl[register_fields].required LIKE '%" . implode("%' OR $sql_tbl[register_fields].required LIKE '%", $area) . "%')";

        $fields = func_query("SELECT $sql_tbl[register_fields].*, IF($avail_condition, 'Y', '') as avail, IF($required_condition, 'Y', '') as required, $sql_tbl[register_field_values].value FROM $sql_tbl[register_fields] LEFT JOIN $sql_tbl[register_field_values] ON $sql_tbl[register_fields].fieldid = $sql_tbl[register_field_values].fieldid AND $sql_tbl[register_field_values].userid = '$user' ORDER BY $sql_tbl[register_fields].section, $sql_tbl[register_fields].orderby");

    } else {

        $fields = func_query("SELECT * FROM $sql_tbl[register_fields] ORDER BY section, orderby");

    }

    if ($fields) {

        foreach ($fields as $k => $v) {

            if ( 
                $is_anonymous
                && $area
                && isset($_anonymous_userinfo['additional_values'][$v['fieldid']]) 
            ) {
                // Anonymous profile
                $fields[$k]['value'] = func_stripslashes($_anonymous_userinfo['additional_values'][$v['fieldid']]);

                if (
                    $fields[$k]['section'] == 'B'
                    && isset($fields[$k]['value']['B'])
                    && (!isset($_anonymous_userinfo['address']['S']) || empty($_anonymous_userinfo['address']['S']))
                ) {
                    // presume ship2diff is disabled, clone values from B to S address like in func_userinfo
                    $fields[$k]['value']['S'] = $fields[$k]['value']['B'];
                }

            }    

            $fields[$k]['title'] = func_get_languages_alt("lbl_register_field_" . $v['fieldid'], $shop_language);

            if (!$area) {

                $fields[$k]['avail']     = func_keys2hash($v['avail']);
                $fields[$k]['required'] = func_keys2hash($v['required']);

            } elseif (
                $v['type'] == 'S'
                && $v['variants']
            ) {

                $fields[$k]['variants'] = @explode(";", $v['variants']);

            }

        }

    }

    return $fields;

}

/**
 * Get additional register fields settings
 */
function func_get_add_contact_fields($area = '')
{
    global $sql_tbl, $shop_language, $config;

    if (!empty($area)) {

        $fields = func_query("SELECT *, IF(avail LIKE '%$area%', 'Y', '') as avail, IF(required LIKE '%$area%', 'Y', '') as required FROM $sql_tbl[contact_fields] ORDER BY orderby");

    } else {

        $fields = func_query("SELECT * FROM $sql_tbl[contact_fields] ORDER BY orderby");

    }

    if (empty($fields))
        return false;

    foreach ($fields as $k => $v) {
        // Compatibility with old XC 4.1.8 format

        if ($v['variants']) {

            $probe = @unserialize($v['variants']);

            if (
                !is_array($probe)
                || count($probe) <= 0
            ) {

                $v['variants'] = @serialize(
                    array(
                        $shop_language => $v['variants'],
                    )
                );

            }

        }

        $fields[$k]['title'] = func_get_languages_alt("lbl_contact_field_" . $v['fieldid']);

        if (empty($area)) {
            $fields[$k]['avail']    = func_keys2hash($v['avail']);
            $fields[$k]['required'] = func_keys2hash($v['required']);
        }

        if (
            $v['type'] == 'S'
            && !empty($v['variants'])
        ) {

            $v['variants'] = unserialize($v['variants']);

            if (
                is_array($v['variants'])
                && !empty($v['variants'])
            ) {

                if (!empty($v['variants'][$shop_language])) {

                    $fields[$k]['variants'] = explode(";", $v['variants'][$shop_language]);

                } elseif (!empty($v['variants'][$config['default_customer_language']])) {

                    $fields[$k]['variants'] = explode(";", $v['variants'][$config['default_customer_language']]);

                } else {

                    $key = key($v['variants']);

                    $fields[$k]['variants'] = empty($key)
                        ? array()
                        : explode(";", $v['variants'][$key]);

                }

            } else {

                unset($fields[$k]);

            }

        }

    }

    return $fields;
}

/**
 * Transform key string to hash-array
 */
function func_keys2hash($str)
{
    $tmp = array();

    if (strlen($str) == 0)
        return $tmp;

    for ($x = 0; $x < strlen($str); $x++)
        $tmp[$str[$x]] = 'Y';

    return $tmp;
}

/**
 * Update seller address for provider user
 */
function func_update_seller_address($data)
{
    global $sql_tbl;

    // Check all required fields
    if (
        empty($data['userid'])
        || empty($data['city'])
        || empty($data['country'])
        || empty($data['zipcode'])
    ) {

        return false;

    } elseif (empty($data['state'])) {

        // Check if state is empty and country marked as 'country without states'
        $has_states = func_is_display_states($data['country']);

        if ($has_states == 'Y')
            return false;

    }

    if (!empty($data['address_2']))
        $data['address'] .= "\n".$data['address_2'];

    func_unset($data, 'address_2');

    func_array2insert(
        'seller_addresses',
        $data,
        true
    );

    return true;
}


function func_update_user_signature($old_user_data, $updated_data) { // {{{
    global $xcart_dir;

    require_once $xcart_dir . '/include/classes/class.XCSignature.php';

    $obj_user = new XCUserSignature($old_user_data);
    if ($obj_user->checkSignature()) {

        $obj_user = new XCUserSignature(func_array_merge($old_user_data, $updated_data));
        $obj_user->updateSignature();
    }

    return TRUE;
} // }}}

function func_update_user_status($userinfo, $_new_status) { // {{{
    global $sql_tbl;
    $userinfo['id'] = intval($userinfo['id']);

    func_update_user_signature($userinfo, array('status'=>$_new_status));

    return db_query("UPDATE $sql_tbl[customers] SET status = '$_new_status' WHERE id = '$userinfo[id]'");
} // }}}

/**
 * Check required fields (Contact US page/Checkout, cart pages)
 *
 * @param array  $userinfo Profile data
 * @param string $area     Area (C/P/A/H)
 * @param string $page     Page (Profile/Address book/Contact US)
 *
 * @return bool
 * @see    ____func_see____
 */
function func_check_required_fields($userinfo = array(), $area = 'H', $page = 'user_profile')
{
    global $config;

    // Get default fields for required area and page

    switch ($page) {

        case 'user_profile':
            $default_fields    = func_get_default_fields($area, $page);
            $additional_fields = func_get_additional_fields($area, @$userinfo['id']);
            break;

        case 'address_book':
            $default_fields    = func_get_default_fields($area, $page);
            $additional_fields = array();
            break;

        case 'contact_us':
            $default_fields    = func_get_default_fields($area, 'contact_us');
            $additional_fields = func_get_add_contact_fields($area);

    }

    // Check additional fields
    if (
        !empty($additional_fields)
        && is_array($additional_fields)
    ) {

        foreach ($additional_fields as $k => $v) {

            if (
                $v['required'] == "Y"
                && empty($userinfo['additional_fields'][$k]["value"])
            ) {

                return false;

            }

        }

    }

    // Do not take required county fields into account if the county feature is disabled bt:89518
    if ($config['General']['use_counties'] != 'Y') {

        if (isset($default_fields['county'])) {

            $default_fields['county']['required'] = '';

        }

    }

    // Process input

    if (
        !empty($default_fields)
        && is_array($default_fields)
    ) {

        foreach ($default_fields as $k => $v) {

            if (
                $v['required'] == 'Y'
                && empty($userinfo[$k])
            ) {

                if (
                    $k == 'state'
                    || (
                        $k == 'county'
                        && $config['General']['use_counties'] == 'Y'
                    )
                ) {

                    $display_states = func_is_display_states($userinfo['country']);

                    if ($display_states) {
                        continue;
                    }

                } else {

                    return false;

                }

            }

        }

    }

    return true;
}

/**
 * Write last login/logout attempt to the database
 *
 * @param integer $userid   Userid
 * @param char    $usertype Usertype (C,P,A,B)
 * @param string  $action   Action (login, logout)
 * @param string  $status   Action status (failure, success, restricted)
 *
 * @return bool
 * @see    ____func_see____
 */
function func_store_login_action($userid, $usertype = 'C', $action = 'login', $status = 'success')
{
    global $REMOTE_ADDR;

    if (empty($userid)) {
        return false;
    }

    // Prepare data
    $login_history_data = array(
        'userid'    => $userid,
        'date_time' => XC_TIME,
        'usertype'  => $usertype,
        'action'    => addslashes($action),
        'status'    => $status,
        'ip'        => sprintf("%u", ip2long($REMOTE_ADDR)),//INET_ATON
    );

    return func_array2insert(
        'login_history',
        $login_history_data,
        true
    );
}

/**
 * Returns id by user login
 *
 * @param string $login User login
 *
 * @return integer
 * @see    ____func_see____
 */
function func_get_userid_by_login($login = '')
{
    global $sql_tbl;

    if (!empty($login))
        $id = func_query_first_cell("SELECT id FROM $sql_tbl[customers] WHERE login='" . addslashes($login). "'");

    return !empty($id) ? $id : 0;
}

/**
 * Returns login by userid
 *
 * @param integer $userid User ID
 *
 * @return string
 * @see    ____func_see____
 */
function func_get_login_by_userid($userid = 0)
{
    global $sql_tbl;

    $login = func_query_first_cell("SELECT login FROM $sql_tbl[customers] WHERE id='" . intval($userid). "'");

    return ($login) ? $login : '';
}

/**
 * Find different user accounts with similar emails
 *
 * @param  mixed $usertype Search only in certain usertype(s)
 * @param  bool  $detailed Return a detailed result about these accounts
 *
 * @return mixed
 * @see    ____func_see____
 */
function func_find_similar_emails($usertype = array(), $detailed = true, $limit = 100)
{
    global $sql_tbl;

    $usertype_condition = '';
    if (!empty($usertype)) {

        if (is_string($usertype)) {

            $usertype = array($usertype);

        }

        $usertype_condition = "usertype IN ('" . implode("','", $usertype) . "')";
    }

    $limit = intval($limit);
    $limit_sql  = empty($limit) ? '' : ' LIMIT ' .  $limit;
    $limit_sql2 = empty($limit) ? '' : ' LIMIT ' . ($limit*5);

    // First check: just find these emails
    $nonuniq_emails = func_query_column("SELECT email FROM $sql_tbl[customers] " . ($usertype_condition ? "WHERE $usertype_condition" : '') . "GROUP BY email, usertype HAVING COUNT(*) > 1 ORDER BY login ASC, last_login DESC $limit_sql");

    // Secondly, get a detailed info if needed
    if (!empty($nonuniq_emails) && $detailed) {

        $accounts = array();

        foreach ($nonuniq_emails as $email) {

            $accounts[$email] = func_query("SELECT id, firstname, lastname, login, last_login, usertype FROM $sql_tbl[customers] WHERE email='" . addslashes($email). "' $limit_sql2");

        }

    } else {

        $accounts = $nonuniq_emails;

    }

    return (!empty($accounts)) ? $accounts : false;
}

/**
 * Return details about the specified error code
 *
 * @param mixed  $num      Error code
 * @param string $alt_text Alternative text to describe an error
 *
 * @return array
 * @see    ____func_see____
 */
function func_reg_error($num, $alt_text = '')
{
    global $config;

    // Define an array of all possible errors
    $error_types = array(
        1  => array(
            'fields' => array( $config['email_as_login'] == 'Y' ? 'email' : 'uname' ),
            'error'  => defined('IS_ADMIN_USER')
                        ? 'txt_user_already_exists_in_orders'
                        : $config['email_as_login'] == 'Y' ? 'txt_email_already_exists' : 'txt_user_already_exists',
        ),
        2 => array(
            'fields' => array('email'),
            'error'  => 'txt_email_invalid'
        ),
        3 => array(
            'fields' => array('antibot_input_str'),
            'error'  => 'msg_err_antibot'
        ),
        4 => array(
            'fields' => array('passwd1', 'passwd2'),
            'error'  => 'txt_chpass_another_one'
        ),
        5 => array(
            'fields' => array('passwd1', 'passwd2'),
            'error'  => 'txt_simple_password'
        ),
        6  => array(
            'fields' => array('uname'),
            'error'  => 'err_username_invalid'
        ),
        7  => array(
            'fields' => array('b_state'),
            'error'  => 'err_billing_state'
        ),
        8  => array(
            'fields' => array('s_state'),
            'error'  => 'err_shipping_state'
        ),
        9  => array(
            'fields' => array('b_county'),
            'error'  => 'err_billing_county'
        ),
        10 => array(
            'fields' => array('s_county'),
            'error'  => 'err_shipping_county'
        ),
        11 => array(
            'fields' => array('s_zipcode'),
            'error'  => ''
        ),
        12 => array(
            'fields' => array('b_zipcode'),
            'error'  => ''
        ),
        13 => array(
            'fields' => array(),
            'error'  => 'txt_ups_av_reenter'
        ),
        14 => array(
            'fields' => array(),
            'error'  => 'txt_registration_error'
        ),
        15 => array(
            'fields' => array('passwd1', 'passwd2'),
            'error'  => 'txt_error_passwords'
        ),
        16 => array(
            'fields' => array('county'),
            'error'  => 'err_address_county'
        ),
        17 => array(
            'fields' => array('state'),
            'error'  => 'err_address_state'
        ),
        18 => array(
            'fields' => array('zipcode'),
            'error'  => ''
        ),
    );

    if (empty($num) || !$error_types[$num]) {
        return array(
            'fields' => array(),
            'error'  => func_get_langvar_by_name('msg_err_profile_upd')
        );
    }

    $return = $error_types[$num];

    // Prepare error description
    $return['error'] = !empty($alt_text) ? $alt_text : func_get_langvar_by_name($return['error'], false, false, true);

    return $return;
}

/**
 * Return error messages and fields
 *
 * @param array $errors Array
 *
 * @return mixed
 * @see    ____func_see____
 */
function func_prepare_error($errors = array())
{

    if (empty($errors) || !is_array($errors)) {
        return false;
    }

    $errfields = $errtext = array();

    foreach ($errors as $err) {

        foreach ($err['fields'] as $ef) {

            $errfields[$ef] = true;

        }

        $errtext[] = $err['error'];
    }

    $errtext = implode("<br />\n\r", $errtext);

    return array(
        'fields'  => $errfields,
        'errdesc' => $errtext
    );
}

/**
 * Get all addresses for a certain user
 *
 * @param int   $userid User ID
 *
 * @return mixed
 * @see    ____func_see____
 */
function func_get_address_book($userid = 0)
{
    global $sql_tbl;

    if (!is_numeric($userid) || $userid <= 0) {
        return false;
    }

    $query = 'SELECT * FROM ' . $sql_tbl['address_book']
             . ' WHERE userid = ' . $userid
             . ' ORDER BY default_s DESC, default_b DESC, id DESC';

    $data = func_query($query);

    $return = array();
    if (!empty($data)) {
        foreach ($data as $k => $v) {
            $return[$v['id']] = func_prepare_address($v);
        }
    }

    return $return;
}

function func_get_address_book_additional_fields($address_book, $additional_fields) { //{{{

    assert('is_array($address_book) && is_array($additional_fields) /*return '.__FUNCTION__.'*/');

    $result = array();

    foreach ($address_book as $addressid => $address) {

        $address_additional_values = func_get_address_additional_values($addressid);
        $result[$addressid] = func_set_address_additional_values($additional_fields, $address_additional_values, true);

    }

    return $result;

} //}}}

/**
 * Get address details from address book entry
 *
 * @param int   $addressid Address ID
 *
 * @return mixed
 * @see    ____func_see____
 */
function func_get_address($addressid = 0)
{
    global $sql_tbl;

    if (!is_numeric($addressid) || $addressid <= 0) {
        return false;
    }

    $query = 'SELECT * FROM ' . $sql_tbl['address_book']
             . ' WHERE id = ' . $addressid;

    $result = func_query_first($query);

    if (!empty($result)) {
        $result = func_prepare_address($result);
    }

    return $result;
}

/**
 * Check address book entry
 *
 * @param mixed $data        Posted data
 * @param mixed $fields_area Fields area
 *
 * @return array
 * @see    ____func_see____
 */
function func_check_address($data, $fields_area, $is_reg_section = false)
{
    global $sql_tbl, $default_address_book_fields, $login_type;
    global $config, $states, $countries, $current_area, $active_modules;

    $return = array(
        'status'    => true,
        'errors'    => array(),
    );

    // Skip empty address
    $filled = false;

    foreach ($default_address_book_fields as $fname => $v) {

        if (
            $fname == 'state'
            || $fname == 'country'
            || $fname == 'title'
            || $fname == 'county'
        ) {
            continue;
        }

        if (
            isset($data[$fname])
            && !empty($data[$fname])
        ) {
            $filled = true;
            break;
        }

    }
    
    // Skip new address if not filed in
    if (
        !$filled
        && $current_area != 'C'
    ) {
        $return['not_filled'] = true;

        return $return;
    }

    // Check input, pass 1: required fields
    $filled = func_check_required_fields($data, $fields_area, 'address_book');

    if (!$filled) {
        $errors[] = func_reg_error(14);
    }

    // Check input, pass 2: substitute default fields
    $default_fields = func_get_default_fields($fields_area, 'address_book', true, true);

    if (!$default_fields['country']) {
        $country = $config['General']['default_country'];
    }

    if (
        !$default_fields['state']
        && $data['country'] == $config['General']['default_country']
    ) {
        $data['state'] = $config['General']['default_state'];
    }

    foreach (
        array(
            'city',
            'state',
            'country',
            'zipcode',
        ) as $v
    ) {
        if (!$default_fields[$v]) {
            $data[$v] = addslashes($config['General']['default_'.$v]);
        }
    }

    // Check state/county
    if (
        $default_fields['state']
        && $default_fields['country']
    ) {
        $display_states = func_is_display_states($data['country']);

        if (
            is_array($states)
            && !func_check_state($states, stripslashes($data['state']), $data['country'])
            && $display_states
        ) {

            $errors[] = func_reg_error(
                !$is_reg_section
                    ? 17
                    : (
                        $is_reg_section == 'B'
                            ? 7
                            : 8
                    )
            );

        } elseif (
            $config['General']['use_counties'] == 'Y'
            && $default_fields['county']
        ) {

            if (!func_check_county($data['county'], stripslashes($data['state']), $data['country'])) {

                 $errors[] = func_reg_error(
                    !$is_reg_section
                        ? 16
                        : (
                            $is_reg_section == 'B'
                                ? 9
                                : 10
                        )
                );

            }

        }

    }

    // Check zipcode
    if (
        $default_fields['zipcode']
        && !empty($data['zipcode'])
        && !func_check_zip($data['zipcode'], $data['country'], false)
    ) {
        $section_title = '';

        if ($is_reg_section) {
            $section_title = func_get_langvar_by_name(
                'lbl_' . (!$is_reg_section == 'S' ? 'shipping' : 'billing') . '_address',
                false,
                false,
                true
            );
        }

        $error_desc = func_get_langvar_by_name(
            'txt_error_' . strtolower($data['country']) . '_zip_code',
            array(
                'address' => $section_title . ' ',
                'zip4_format' => ($config['General']['zip4_support'] == 'Y')
                    ? '(' . func_get_langvar_by_name('lbl_or', false, NULL, true) . ' 5+4) '
                    : ''
            ),
            false,
            true
        );

        if (empty($error_desc)) {

            $error_desc = func_get_langvar_by_name(
                'txt_error_common_zip_code',
                array(
                    'address' => $section_title . ' ',
                ),
                false,
                true
            );

        }

        $errors[] = func_reg_error(
            !$is_reg_section
                ? 18
                : (
                    $is_reg_section == 'S'
                        ? 11
                        : 12
                ),
            $error_desc
        );

    }

    // Shipping Address Validation by UPS OnLine Tools module
    if (
        !empty($active_modules['UPS_OnLine_Tools'])
        && $current_area == 'C'
        && empty($errors)
        && !defined('AV_PROCESSED')
    ) {

        global $av_error;
        func_ups_av_validate($data);

        if (!empty($av_error)) {
            $errors[] = func_reg_error(13);
        }
    }

    if (!empty($active_modules['TwoFactorAuth'])) {
        $tfa_error = func_twofactor_validate_phone($data);
        if (!empty($tfa_error)) {
            $errors[] = $tfa_error;
        }
    }

    if (!empty($errors)) {

        $return['errors'] = $errors;
        $return['status'] = false;

    }

    if ($current_area == 'C' && !empty($active_modules['AvaTax'])) {
        if (empty($errors)) {
            $return = func_avatax_validate_address($data);
        }
    }

    return $return;
}


function func_check_address_additional_fields($data, $fields_area, $additional_fields = array()) { //{{{

    $return = array(
        'status'    => true,
        'errors'    => array(),
    );

    $filled = true;

    if (empty($additional_fields)) {
        $additional_fields = func_get_additional_fields($fields_area, '', 'B');
    }

    // Check required fields
    foreach ($additional_fields as $v) {
        if ($v['section'] == 'B') {
            // Check only address book additional fields
            if (
                $v['required'] == 'Y' 
                && empty($data[$v['fieldid']])
                && $v['avail'] == 'Y'
            ) {
                $filled = false;
            }

        }
    }

    if (!$filled) {
        $errors[] = func_reg_error(14);
    }

    if (!empty($errors)) {

        $return['errors'] = $errors;
        $return['status'] = false;

    }

    return $return;

} //}}}

/**
 * Add/update address entry
 *
 * @param int   $userid    Address ID
 * @param int   $addressid Address ID
 * @param array $data      Address details
 *
 * @return mixed
 * @see    ____func_see____
 */
function func_save_address($userid = 0, $addressid = 0, $data = array())
{
    global $sql_tbl, $default_address_book_fields, $login_type;
    global $config, $states, $countries;

    if (empty($data) || !is_array($data)) {
        return false;
    }

    if (
        abs(intval($userid)) != $userid
        || $userid <= 0
    ) {
        return false;
    }

    if (!isset($data['state'])) {
        $data['state'] = '';
    }

    // Prepare default address mark
    $default_marks = array();

    foreach (array('B', 'S') as $suffix) {

        $fname = 'default_' . strtolower($suffix);

        if (!empty($data[$fname])) {

            $default_marks[] = $suffix;

            func_unset($data, $fname);

        }

    }

    // Prepare general data
    $possible_fields = array_keys($default_address_book_fields);

    if ($config['General']['zip4_support'] == 'Y') {

        $possible_fields[] = 'zip4';

    }

    foreach ($data as $k => $v) {

        if (!in_array($k, $possible_fields)) {

            func_unset($data, $k);

        } else {

            $data[$k] = trim($v);

        }

    }

    if (!empty($data['address_2'])) {

        $data['address'] .= "\n" . $data['address_2'];

    }

    func_unset($data, 'address_2');

    // Save zip+4 data
    if (
        $config['General']['zip4_support'] == 'Y'
        && $data['country'] == 'US'
        && isset($data['zip4'])
        && !empty($data['zip4'])
    ) {

        $data['zip4'] = substr(trim($data['zip4']), 0, 4);

    } else {

        $data['zip4'] = '';

    }

    // Perform add/update
    if ($addressid > 0) {

        // Update existing address
        func_array2update('address_book', $data, 'id = '. $addressid);

    } elseif ($userid > 0) {

        // Add new address
        $data['userid'] = $userid;

        $addressid = func_array2insert('address_book', $data);

        $data['addressid'] = $addressid;

    }

    // Mark default address(es)
    if (!empty($default_marks) && $userid > 0) {

        // Change default address for registered user
        foreach ($default_marks as $mark) {

            func_mark_default_address($addressid, $userid, $mark);
        }
    }

    return $data;

}

/**
 * Delete address entry
 *
 * @param int   $addressid Address ID
 *
 * @return bool
 * @see    ____func_see____
 */
function func_delete_address($addressid = 0)
{
    global $sql_tbl;

    if (!is_numeric($addressid) || $addressid < 0) {

        return false;

    }

    $res1 = db_query("DELETE FROM $sql_tbl[address_book] WHERE id='$addressid'");
    $res2 = db_query("DELETE FROM $sql_tbl[register_field_address_values] WHERE addressid='$addressid'");

    return ($res1 && $res2);
}

/**
 * Mark address default
 *
 * @param int   $addressid Address ID
 * @param int   $userid    User ID
 * @param char  $flag      Flag B/S
 *                         B - billing address
 *                         S - shipping address
 *
 * @return bool
 * @see    ____func_see____
 */
function func_mark_default_address($addressid = 0, $userid = 0, $flag = '')
{
    global $sql_tbl;

    if (
        !is_numeric($addressid)
        || $addressid <= 0
        || !is_numeric($userid)
        || $userid <= 0
    ) {

        return false;

    }

    if (!in_array($flag, array('B', 'S'))) {

        return false;

    }

    $suffix = strtolower($flag);

    // Remove flag from old addresses
    db_query("UPDATE $sql_tbl[address_book] SET default_" . $suffix ."='N' WHERE userid='$userid'");

    // Set new flag
    return db_query("UPDATE $sql_tbl[address_book] SET default_" . $suffix ."='Y' WHERE userid='$userid' AND id='$addressid'");
}

/**
 * Prepare information about address to display/edit
 *
 * @param array $address Address
 *
 * @return Array
 * @see    ____func_see____
 */
function func_prepare_address($address = array())
{
    global $config;

    if (!empty($address['title'])) {
        $address['titleid']     = func_detect_title(addslashes($address['title']));
        $address['title']       = func_get_title($address['titleid']);
    }        

    if (isset($address['address'])) {
        $_tmp = func_split_by_eol($address['address']);
        $address['address']     = @$_tmp[0];
        
        if (isset($_tmp[1]))
            $address['address_2']   = @$_tmp[1];
    }    

    if (!empty($address['state']))
        $address['statename']   = func_get_state($address['state'], $address['country']);

    $address['countryname'] = func_get_country($address['country']);

    if ($config['General']['use_counties'] == 'Y') {
        $address['countyname'] = func_get_county($address['county']);
    }

    return $address;

}

/**
 * Check if address record belongs to specified user
 *
 * @param int $userid User ID
 * @param int $id     Address ID
 *
 * @return mixed
 * @see    ____func_see____
 */
function func_check_address_owner($userid = 0, $id = 0)
{
    global $sql_tbl;

    if (
        !is_numeric($id)
        || $id <= 0
        || !is_numeric($userid)
        || $userid <= 0
    ) {
        return false;
    }

    return func_query_first_cell("SELECT userid FROM $sql_tbl[address_book] WHERE userid='$userid' AND id='$id'");
}

/**
 * Get default address information
 *
 * @param int  $user User ID
 * @param char $type Address type (B/S)
 *
 * @return array
 * @see    ____func_see____
 */
function func_get_default_address($userid = 0, $type = NULL)
{
    global $sql_tbl, $default_address_book_fields;

    $address = array();

    if (!is_numeric($userid) || $userid <= 0) {

        return $address;

    }

    // Get records count
    $tmp = func_query_first("
SELECT COUNT(a.id) AS cnt, COUNT(b.default_b) AS cnt_b, COUNT(c.default_s) AS cnt_s
FROM $sql_tbl[address_book] a
LEFT JOIN $sql_tbl[address_book] b ON a.id = b.id AND b.default_b = 'Y'
LEFT JOIN $sql_tbl[address_book] c ON a.id = c.id AND c.default_s = 'Y'
WHERE a.userid='$userid'
GROUP BY a.userid ORDER BY NULL
    ");

    // Validate
    if (empty($tmp)) {

        return $address;

    }

    foreach (array('s', 'b') as $prefix) {

        if ($tmp['cnt_' . $prefix] == 1) {

            // correct
            continue;

        } else if ($tmp['cnt_' . $prefix] < 1) {

            // none of addresses marked as default
            db_query("UPDATE $sql_tbl[address_book] SET default_" . $prefix . " = 'Y' WHERE userid='$userid'");

        } else if ($tmp['cnt_' . $prefix] > 1) {

            // more than one record marked as default
            $limit = $tmp['cnt_' . $prefix] - 1;
            db_query($q = "UPDATE $sql_tbl[address_book] SET default_" . $prefix . " = 'N' WHERE userid='$userid' AND default_" . $prefix . " = 'Y' LIMIT $limit");
        }

    }

    // Prepare the query

    $base_query = "SELECT * FROM $sql_tbl[address_book] WHERE userid='$userid'";

    $condition = '';

    if (!empty($type) && in_array($type, array('S', 'B'))) {

        $condition = " AND default_" . strtolower($type) . " = 'Y'";

    } else {

        $condition = " AND (default_s = 'Y' OR default_b = 'Y')";

    }

    $result = func_query($base_query.$condition);

    if (!empty($result)) {

        $address = array();
        $one_default_b_s_address = false;

        foreach ($result as $k => $a) {

            if ($a['default_s'] == 'Y') {

                $address['S'] = func_prepare_address($a);

            }

            if ($a['default_b'] == 'Y') {

                $address['B'] = func_prepare_address($a);

            }

            if (
                count($result) == 1
                && $a['default_b'] == 'Y'
                && $a['default_s'] == 'Y'
            ) {
                $one_default_b_s_address = true;
            }

        }

        // Assign id only to B address if address is one in adress book
        if ($one_default_b_s_address) {
            func_unset($address['S'], 'id');
        }
    }

    return $address;
}

/**
 * Extract address into profile fields with address prefix
 *
 * @param array  $data Address data
 * @param string $type Address type (B/S)
 *
 * @return array
 * @see    ____func_see____
 */
function func_extract_address($data = array(), $type = 'B', $fields = null)
{
    $result = array();

    $prefix = strtolower($type) . '_';

    $fields = is_null($fields) ? array_keys($data) : array_keys($fields);

    if (isset($data['countryname']))
        $fields[] = 'countryname';

    if (isset($data['statename']))
        $fields[] = 'statename';

    foreach ($data as $field => $val) {

        if (
            !in_array(
                $field,
                array(
                    'id',
                    'userid',
                    'default_s',
                    'default_b',
                )
            ) 
            && in_array($field, $fields)
        ) {

            $result[$prefix . $field] = $val;

        }

    }

    return $result;
}

/**
 * Grab address fields from profile data and prepare
 * address book records
 *
 * @param array  $data Address data
 * @param string $type Address type (B/S)
 *
 * @return array
 * @see    ____func_see____
 */
function func_create_address($data = array(), $type = 'B')
{

    $result = array();
    $prefix = strtolower($type) . '_';

    foreach ($data as $field => $val) {

        if (substr($field, 0, 2) == $prefix) {

            $result[substr($field, 2)] = $val;

        }

    }

    return $result;

}

/**
 * Check if address book contain no records
 *
 * @param int $userid ____param_comment____
 *
 * @return void
 * @see    ____func_see____
 */
function func_is_address_book_empty($userid = 0)
{
    global $sql_tbl;
    static $res;

    if (!is_numeric($userid) || $userid <= 0) {

        return TRUE;

    }

    if (isset($res))
        return $res;

    $addr_count = func_query_first_cell("SELECT COUNT(id) FROM $sql_tbl[address_book] WHERE userid='$userid'");
    $res = ($addr_count == 0);

    return $res;
}

function func_tpl_is_address_book_empty()
{
    global $logged_userid;

    if (empty($logged_userid))
        return TRUE;


    return func_is_address_book_empty($logged_userid);
}

/**
 * Error during login
 *
 * @param int    $num            Error code
 * @param string $redirect_to    Redirect URI
 * @param string $force_redirect Perform forced redirect
 *
 * @return void
 * @see    ____func_see____
 */
function func_login_error($num = 0, $redirect_to = 'login.php', $force_redirect = true)
{
    global $config, $sql_tbl, $top_message, $userid, $usertype, $login_field_name;
    global $active_modules, $mail_smarty, $login_antibot_on, $REMOTE_ADDR;

    // Define errors

    $error_desc = array(
        0   =>  array(
                    'txt_login_email_not_match',
                    array(
                        'login_field_name' => $login_field_name
                    )
                ),
        1   =>  'txt_already_logged_in',
        2   =>  'txt_wrong_username_len',
        3   =>  'txt_wrong_password_len',
        4   =>  'msg_err_antibot',
        5   =>  'err_account_temporary_disabled',
        6   =>  array(
                    'txt_account_suspended',
                    array(
                        'days' => $config['Security']['suspend_admin_after'],
                    ),
                ),
        7   =>  'txt_old_password',
        8   =>  'txt_bf_key_internal_error',
        9   =>  'lbl_ip_blocked_for_admin_area_note',
        10  =>  'txt_fake_admin_account_blocked',
        11  =>  'lbl_ip_blocked_for_admin_from_config',
    );

    // Prepare message

    $lbl = isset($error_desc[$num])
        ? $error_desc[$num]
        : 'txt_login_email_not_match';

    if (is_array($lbl)) {

        list($lbl, $substitute) = $lbl;

    }

    $top_message = array(
        'type'    => 'E',
        'content' => func_get_langvar_by_name($lbl, @$substitute, false, true),
    );

    // Save in log
    $login_status = $num == 9 ? 'restricted' : 'failure';

    func_store_login_action($userid, $usertype, 'login', $login_status);

    if (in_array($usertype, array('A', 'P'))) {
        global $username;

        x_log_flag(
            'log_activity',
            'ACTIVITY',
            "Someone tried to login as '$username' with '$usertype' usertype and got '$login_status' login status. Remote IP '$REMOTE_ADDR'"
        );
    }

    // Send emails to admin
    $is_admin_user = $usertype == 'A' || (!empty($active_modules['Simple_Mode']) && $usertype == 'P');

    $need_alert = (
        (
            $is_admin_user
            && $config['Email_Note']['eml_login_error'] == 'Y'
            && $num != 9
        )
        || (
            !$is_admin_user
            && $config['Email_Note']['eml_customer_login_error'] == 'Y'
        )
    );

    if ($need_alert) {

        $mail_smarty->assign('failed_login', $_POST['username']);
        $mail_smarty->assign('failed_password', $_POST['password']);
        $mail_smarty->assign('shown_front_message', $top_message['content']);

        if (!$is_admin_user) {

            switch ($usertype) {

                case 'P':
                    $userarea = 'provider';
                    break;

                case 'B':
                    $userarea = 'partner';
                    break;

                default:
                    $userarea = 'customer';

            }

            $mail_smarty->assign('usertype', $usertype);
            $mail_smarty->assign('userarea', $userarea);

            $template_file = '';

        } else {

            $template_file = 'admin_';

        }

        func_send_mail(
            $config['Company']['site_administrator'],
            'mail/login_error_' . $template_file . 'subj.tpl',
            'mail/login_error.tpl',
            $config['Company']['site_administrator'],
            true
        );

    }

    // Track login attempts and lock user (optional)
    $attempt = func_store_login_attempt($userid, $usertype);

    if (!empty($attempt['redirect'])) {

        $redirect_to = $attempt['redirect'];

    }

    if (!empty($attempt['message'])) {

        $top_message['content'] .= '<br /><br />' . $attempt['message'];

    }

    if (func_is_ajax_request()) {

        if ($num > 0 || $login_antibot_on) {

            // Fatal, redirect to login page
            func_reload_parent_window('login.php');

        } else {

            // Prepare ajax message
            func_register_ajax_message(
                'popupDialogCall',
                array(
                    'action'  => 'message',
                    'message' => $top_message
                )
            );

            $top_message = '';

        }

    }

    // Redirect
    if ($force_redirect) {

        func_header_location($redirect_to);

    }

    return true;
}

/**
 * Initialize session vars on login
 *
 * @param int    $userid   User ID
 * @param string $usertype Usertype
 *
 * @return void
 * @see    ____func_see____
 */
function func_start_user_session($userid = 0)
{
    global $login, $login_type, $logged_userid, $identifiers, $active_modules;

    $user_data = func_userinfo($userid);

    if (!$user_data) {
        return false;
    }

    $usertype = $user_data['usertype'];

    $login = $user_data['login'];
    $login_type = $user_data['usertype'];
    $logged_userid = $userid;

    $identifiers[$usertype] = array (
        'userid'     => $userid,
        'login'      => $login,
        'login_type' => $login_type,
    );

    if (!empty($active_modules['Simple_Mode'])) {

        if ($usertype == 'A') {

            $identifiers['P'] = $identifiers['A'];

        }

        if ($usertype == 'P') {

            $identifiers['A'] = $identifiers['P'];

        }

    }

    return true;
}

/**
 * Clean user identifiers session vars
 *
 * @return void
 * @see    ____func_see____
 */
function func_end_user_session()
{
    global $login, $login_type, $logged_userid, $identifiers, $active_modules, $current_area;

    func_unset($identifiers, $current_area);

    if (!empty($active_modules['Simple_Mode'])) {

        if ($current_area == 'A') {

            func_unset($identifiers,'P');

        }

        if ($current_area == 'P') {

            func_unset($identifiers,'A');

        }

    }

    $login = $login_type = '';

    $logged_userid = 0;

    return true;
}

/**
 * Check account activity
 *
 * @param array $user_data Userinfo
 *
 * @return bool
 * @see    ____func_see____
 */
function func_check_account_activity($userid = 0)
{
    global $config, $top_message;

    $user_data = func_userinfo($userid);

    if (!$user_data) {

        return false;

    } elseif ($user_data['status'] == 'Y') {

        return true;

    }

    $status = false;

    if (
        $config['Security']['auto_unlock'] > 0
        && $user_data['autolock'] == 'Y'
        && $user_data['suspend_date'] > 0
    ) {

        $lock_login_attempts = in_array($user_data['usertype'], array('A', 'P')) ? 3 : $config['Security']['lock_login_attempts'];

        if (XC_TIME > ($user_data['suspend_date'] + 60*$config['Security']['auto_unlock'])) {

            // Automatic account unlock
            if (func_enable_account('', $user_data['id'])) {

                $top_message = array(
                    'type'    => 'I',
                    'content' => func_get_langvar_by_name(
                        'txt_account_automatically_activated',
                        array(
                            'username' => $user_data['login']
                        ),
                        false,
                        true
                    )
                );
            }

            $status = true;

        } elseif ($lock_login_attempts > 0) { // Check, if the lock feature is on

            // Inform customer about the auto unlock

            $minutes = intval(date('i',($user_data['suspend_date'] + 60*$config['Security']['auto_unlock']) - XC_TIME));

            if ($minutes < 1) {

                $minutes = func_get_langvar_by_name('txt_less_than_1_minute');

            } else {

                $minutes = $minutes.' '.func_get_langvar_by_name($minutes > 1 ? 'lbl_minutes': 'lbl_minute');

            }

            $top_message = array(
                'type'    => 'I',
                'content' => func_get_langvar_by_name(
                    'txt_account_automatically_locked',
                    array(
                        'times'   => $lock_login_attempts,
                        'minutes' => $minutes
                    ),
                    false,
                    true
                )
            );

        }

    }

    return $status;
}

/**
 * Checks if the password correct
 *
 * @param mixed $password Entered password
 * @param mixed $crypted  Crypted right password
 * @param mixed $allow_old_password_format
 *
 * @return array
 * @see    ____func_see____
 */
function func_is_password_correct($password, $crypted, $allow_old_password_format = FALSE)
{
    global $username, $mail_smarty, $active_modules, $usertype, $config, $top_message, $xcart_dir;

    $password = trim(stripslashes($password));

    if (empty($password)) {

        return false;

    }

    $right_hash = text_decrypt($crypted);

    if (is_null($right_hash)) {

        // Could not decrypt password
        x_log_flag(
            'log_decrypt_errors',
            'DECRYPT',
            func_get_langvar_by_name('lbl_cannot_decrypt_password', array('user' => $username), false, true),
            true
        );

        if (!func_check_blowfish_key()) {

            // Blowfish error

            x_log_add('BLOWFISH', func_get_langvar_by_name('txt_bf_key_internal_error', null, false, true));

            if (
                $usertype == 'A'
                || (
                    $usertype == 'P'
                    && !empty($active_modules['Simple_Mode'])
                )
            ) {
                // Show error for admin

                $top_message = array(
                    'type'    => 'E',
                    'content' => func_get_langvar_by_name('txt_bf_key_internal_error')
                );

            } elseif ($config['Email_Note']['eml_wrong_bf_key'] == 'Y') {

                // Send email to admin

                $mail_smarty->assign('username', $username);

                func_send_mail(
                    $config['Company']['site_administrator'],
                    'mail/wrong_bf_key_subj.tpl',
                    'mail/wrong_bf_key.tpl',
                    $config['Company']['site_administrator'],
                    true
                );

            }

        }

        return false;

    }
    
    $is_password_correct = text_verify($password, $right_hash);
    $password_has_old_format = FALSE;
    require_once $xcart_dir . '/include/classes/class.XCPasswordHash.php';
    if (
        $allow_old_password_format
        && !$is_password_correct
        && !XCPasswordHash::isPasswordHash($right_hash)
    ) {
        $is_password_correct = ($password == $right_hash);
        if ($is_password_correct)
            $password_has_old_format = TRUE;
    }

    return array($is_password_correct, $password_has_old_format);
}

/**
 * Process failed login attempt action
 *
 * @param mixed $userid   User ID
 * @param mixed $usertype Usertype
 *
 * @return array
 * @see    ____func_see____
 */
function func_store_login_attempt($userid, $usertype)
{
    global $config, $login_attempt, $top_message, $antibot_err, $login_antibot_on, $sql_tbl, $active_modules;

    $return = array();

    // After 3 failures redirects to Recover password page
    $login_attempt++;

    $max_login_attempts = 0;

    if (!empty($active_modules['Image_Verification'])) {

        $max_login_attempts = intval($config['Image_Verification']['spambot_arrest_login_attempts']);

    }

    if (empty($max_login_attempts))
        $max_login_attempts = 3;

    $autolock = intval($config['Security']['auto_unlock']) > 0
        ? 'autolock'
        : '';

    // Get incremented login attempts counter so that it includes current attempt
    $invalid_login_attempts = func_query_first_cell("SELECT invalid_login_attempts+1 FROM $sql_tbl[customers] WHERE id='$userid'");

    $lock_login_attempts = in_array($usertype, array('A', 'P')) ? 3 : $config['Security']['lock_login_attempts'];

    if (
        $lock_login_attempts > 0
        && $invalid_login_attempts >= $lock_login_attempts
        && func_suspend_account($userid, $usertype, $autolock)
    ) {

        if ($autolock) {

            $minutes = intval(date('i',(60*$config['Security']['auto_unlock'])));

            if ($minutes < 1) {

                $minutes = func_get_langvar_by_name('txt_less_than_1_minute');

            } else {

                $minutes = $minutes . ' ' . func_get_langvar_by_name($minutes > 1 ? 'lbl_minutes': 'lbl_minute');

            }

            $return['status'] = 'locked';

            $return['message'] = func_get_langvar_by_name(
                'txt_account_automatically_locked',
                array('times' => $lock_login_attempts, 'minutes' => $minutes),
                false,
                true
            );

        } else {

            $return['status'] = 'disabled';
            $return['message'] = func_get_langvar_by_name('err_account_temporary_disabled', false, false, true);

        }

        func_array2update(
            'customers',
            array(
                'invalid_login_attempts' => 0,
            ),
            "id='$userid'"
        );

    } else {

        func_array2update(
            'customers',
            array(
                'invalid_login_attempts' => 'invalid_login_attempts+1'
            ),
            "id='$userid' AND status='Y'",
            true
        );

    }

    if (
        $max_login_attempts > 0
        && $login_attempt >= $max_login_attempts
    ) {

        $login_attempt = 0;
        $login_antibot_on = 1;

        if (!$antibot_err) {

            $return['redirect'] = 'help.php?section=Password_Recovery';

        }

    }

    return $return;
}

/**
 * Perform necessary actions on login
 *
 * @param int $userid ____param_comment____
 *
 * @return void
 * @see    ____func_see____
 */
function func_authenticate_user($userid = 0)
{
    global $active_modules, $login_redirect, $REMOTE_ADDR;
    global $login_antibot_on, $login_attempt;

    $user_data = func_userinfo($userid);

    if (!$user_data) {
        return false;
    }

    $usertype = $user_data['usertype'];

    func_start_user_session($userid);
    
    $login_antibot_on = false;
    $login_attempt = "";
    func_check_change_password($user_data);

    if ($usertype == 'C') {

        x_session_register('login_redirect');

        $login_redirect = 1;

    }

    // Log first login in the customer profile
    if (empty($user_data['first_login'])) {

        func_array2update(
            'customers',
            array(
                'first_login' => XC_TIME,
            ),
            "id='$userid'"
        );

    }

    global $previous_login_date;
    x_session_register('previous_login_date');

    // Log last login in the customer profile
    $previous_login_date = $user_data['last_login'];

    if ($previous_login_date == 0) {

        $previous_login_date = XC_TIME;

    }

    func_array2update(
        'customers',
        array(
            'invalid_login_attempts' => 0,
            'last_login' => XC_TIME
        ),
        'id = ' . $userid
    );

    if (
        empty($active_modules['TwoFactorAuth'])
        || !func_twofactor_on_authenticate($userid, $usertype, $user_data['login'])
    ) {

        // Save into login history
        func_store_login_action($userid, $usertype, 'login', 'success');

        // Save into log file admin/provider login
        if (in_array($usertype, array('A', 'P'))) {

            x_log_flag(
                'log_activity',
                'ACTIVITY',
                "'" . $user_data['login'] . "' user (ID: $userid) with '$usertype' usertype has logged in. Remote IP '$REMOTE_ADDR'"
            );

        }

    }

    // Set cookie with username if Greet visitor module enabled
    if (
        !empty($active_modules['Greet_Visitor'])
        && $usertype == 'C'
    ) {
        func_store_greeting($user_data);
    }

    return true;
}

/**
 * Remove fields from user profile according User Profiles Personal Information section
 * 
 * @param array  $userinfo     user profile array
 * @param string $profile_area profile area
 *  
 * @return void
 * @see    ____func_see____
 * @since  1.0.0
 */
function func_clean_user_profile(&$userinfo, $profile_area)
{
    $all_fields = array_keys(func_get_default_fields($profile_area, 'user_profile', false, true));
    $avail_only = array_keys(func_get_default_fields($profile_area, 'user_profile', true, true));

    foreach ($all_fields as $field) {

        if (!in_array($field, $avail_only)) {

            unset($userinfo[$field]);

        }

    }
}


/**
 * Adjust customer address
 *
 * @param mixed $cart     Cart
 * @param mixed $userinfo User info
 *
 * @return void
 * @see    ____func_see____
 */
function func_adjust_customer_address($l_cart, $l_userinfo)
{

    // Prefill shipping address with billing address
    $cart_used_s_address = func_get_cart_address('s');
    $cart_used_b_address = func_get_cart_address('b');

    if (
        !empty($cart_used_b_address)
        && empty($cart_used_s_address)
    ) {
        $cart_used_s_address = $cart_used_b_address;
        func_unset($cart_used_s_address, 'id');
        $l_cart = func_set_cart_address($l_cart, 's', $cart_used_s_address);
    }

    // Check alternatively selected addresses

    foreach (array('B', 'S') as $prefix) {

        $fname = 'cart_used_' . strtolower($prefix) . '_address';

        if (!empty($$fname)) {

            $addr = array();
            if (!is_array($$fname)) {

                // Get address by ID
                $addr = func_get_address($$fname);

            } else {

                // Restore previously saved address data from cart
                $addr = func_prepare_address($$fname);
            }
            $l_userinfo['address'][$prefix] = $addr;
            $l_userinfo = func_array_merge($l_userinfo, func_extract_address($addr, $prefix));
        }
    }

    return array($l_cart, $l_userinfo);
}

/*
 * Generate complete customer userinfo based on some partial userinfo (for example from data from payment callback)
 */
function func_userinfo_from_scratch($userinfo, $userinfo_type = 'userinfo_for_payment')
{
    global $current_area, $logged_userid, $user_account;

    $params = array(
        'userinfo_for_payment' => array( // Params values are the same as from include/payment_method.php
            'usertype' => 'C', 
            'need_password' => false, 
            'need_cc' => true, 
            'profile_area' => array('C','H')
        ),
        'userinfo_for_cart' => array( // Params values are the same as from include/checkout_init.php
            'usertype' => @$user_account['usertype'], 
            'need_password' => false, 
            'need_cc' => false, 
            'profile_area' => 'H'
        ),
    );

    if (
        $current_area == 'C'
        && isset($params[$userinfo_type])
    ) {
        $var = $params[$userinfo_type];

        if (!empty($logged_userid)) {
            $userinfo_from_scratch = func_userinfo($logged_userid, $var['usertype'], $var['need_password'], $var['need_cc'], $var['profile_area']);
        } else{
            $userinfo_from_scratch = func_userinfo(0, $var['usertype'], $var['need_password'], $var['need_cc'], $var['profile_area']);
        }

        settype($userinfo, 'array');
        $userinfo = func_array_merge($userinfo_from_scratch, $userinfo);
    }

    return $userinfo;
}

function func_check_change_password($user_data)
{
    assert('isset($user_data["change_password"]) /*'.__FUNCTION__.'*/');
    global $require_change_password, $login_change;
    
    if ($user_data["change_password"] == "Y") {
        $usertype = $user_data['usertype'];
        x_session_register("login_change");
        x_session_register('require_change_password');
        $require_change_password[$usertype] = true;
        $login_change[$usertype] = $user_data["id"];
    } else {
        x_session_unregister("login_change");
    }

    return true;
}

function func_add_password_reset_key($userid) { // {{{
    global $sql_tbl, $xcart_dir;

    db_query("LOCK TABLES $sql_tbl[reset_passwords] WRITE");

    db_query("DELETE FROM $sql_tbl[reset_passwords] WHERE userid='$userid'");

    $password_reset_key = func_get_secure_random_key(32);
    $update_data = array(
        'userid' => $userid,
        'password_reset_key' => addslashes(text_crypt(text_hash($password_reset_key))),
        'password_reset_key_date' => XC_TIME
    );

    func_array2insert(
        'reset_passwords',
        $update_data,
        true
    );

    db_query('UNLOCK TABLES');


    require_once $xcart_dir . '/include/classes/class.XCSignature.php';
    $objPassReset = new XCResetPasswordSignature($update_data);
    $objPassReset->updateSignature();

    return $password_reset_key;
} // }}}

/*
 * Getter for anonymous_userinfo session var. 
 * Use only this function to get global $anonymous_userinfo var
 */
function func_get_anonymous_userinfo()
{
    global $anonymous_userinfo;

    if (!isset($anonymous_userinfo))
        x_session_register('anonymous_userinfo', array());
    
    assert('is_array($anonymous_userinfo) /*return '.__FUNCTION__.'*/');
    return $anonymous_userinfo;        
}

/*
 * Setter for anonymous_userinfo session var. 
 * Use only this function to change global $anonymous_userinfo var
 */
function func_set_anonymous_userinfo($userinfo, $session_save_flag = 'run_save', $is_complete = 'complete')
{
    global $anonymous_userinfo;

    if (!empty($userinfo)) {
        $anonymous_userinfo = $userinfo;
        $anonymous_userinfo['usertype'] = empty($userinfo['usertype']) ? 'C' : $userinfo['usertype'];
    } else {
        $anonymous_userinfo = array();
    }

    if ($is_complete == 'complete')
        unset($anonymous_userinfo['is_incomplete']);
    else        
        $anonymous_userinfo['is_incomplete'] = true;

    x_session_register('anonymous_userinfo', $anonymous_userinfo);

    if ($session_save_flag == 'run_save') {
        // Use this block to avoid race condition with userinfo with multithreading script like AJAX get_profile call
        x_session_save('anonymous_userinfo');
    }

    return true;
}

/**
 * Delete address from address book
 */
function func_delete_from_address_book($address_book, $address_to_delete)
{

    // Prepare an array of addresses to delete
    $address_to_delete = (isset($address_to_delete) && !empty($address_to_delete))
        ? array_keys($address_to_delete)
        : false;

    if (
        !is_array($address_book)    
        || !is_array($address_to_delete)
    ) {
        return $address_book;
    }

    foreach ($address_book as $addrid => $data) {

        if (in_array($addrid, $address_to_delete)) {
          
            // Delete address
            func_delete_address($addrid);
            $address_book[$addrid] = array();
        }
    }

    return $address_book;
}

/**
 * Prepare address book to save
 */
function func_prepare_address_book_data_for_save($address_book)
{
    assert('!empty($address_book) && is_array($address_book) /*param '.__FUNCTION__.'*/'); 

    foreach ($address_book as $addrid => $data) {
        if (!empty($data['address_2'])) {
            $data['address'] .= "\n" . $data['address_2'];
        }
        func_unset($data, 'address_2');
        $address_book[$addrid] = $data;
    }

    return $address_book;
}

/**
 * Save customer address book from admin area
 */
function func_admin_save_address_book($address_book, $userid, $additional_values_hash = array())
{
    assert('!empty($address_book) && is_array($address_book) /*param '.__FUNCTION__.'*/'); 

    $new_addressid = null;
    foreach ($address_book as $addrid => $data) {
        if (empty($data))
            continue;

        $_res = func_save_address($userid, $addrid, $data);

        if (empty($addrid)) {
            $new_addressid = $_res['addressid'];
        }

        if (!empty($additional_values_hash[$addrid])) {
            func_save_address_additional_values((!empty($addrid)) ? $addrid : $new_addressid, $additional_values_hash[$addrid]);
        }
    }

    return array($address_book, $new_addressid);
}

/**
 * Save customer address book from checkout page in session var
 */
function func_customer_save_address_book_insession($l_cart, $address_book, $ship2diff, $additional_values_hash = array())
{
    assert('!empty($address_book) && is_array($address_book) /*param '.__FUNCTION__.'*/'); 
    
    global $is_anonymous;

    foreach ($address_book as $addrid => $data) {
        // Add/update address

        // Store address record during registration at checkout
        if ($addrid == 'S' && @$ship2diff != 'Y') {
            $l_cart = func_set_cart_address($l_cart, 's', '', '', false);
            continue;
        }

        if ($is_anonymous) {
            $_anonymous_userinfo = func_get_anonymous_userinfo();
            @$_anonymous_userinfo['address'][$addrid] = $data;

            // Merge address book additional fields
            if (!empty($additional_values_hash)) {

                if (empty($_anonymous_userinfo['additional_values']) || !is_array($_anonymous_userinfo['additional_values'])) {
                    $_anonymous_userinfo['additional_values'] = array();
                }

                foreach ($_anonymous_userinfo['additional_values'] as $k => $v) {
                    if (is_array($v)) {
                        if (isset($additional_values_hash[$addrid][$k])) {
                            $_anonymous_userinfo['additional_values'][$k][$addrid] = $additional_values_hash[$addrid][$k];

                        } elseif ($addrid == 'S' && !isset($additional_values_hash['B'][$k])) {
                            unset($_anonymous_userinfo['additional_values'][$k]);

                        } else {
                            unset($_anonymous_userinfo['additional_values'][$k][$addrid]);

                        }
                    }
                }

            }
            func_set_anonymous_userinfo($_anonymous_userinfo, 'run_save');
        } else {
            $l_cart = func_set_cart_address($l_cart, $addrid, func_stripslashes($data), '', func_stripslashes($additional_values_hash[$addrid]));
        }

    }

    return $l_cart;
} 

/**
 * Save customer address book from checkout page in database
 */
function func_customer_save_address_book_indb($address_book, $ship2diff, $existing_address, $new_address, $additional_values_hash = array())
{
    global $is_anonymous, $logged_userid;

    if ($is_anonymous)
        return $address_book;

    $is_address_book_empty = func_is_address_book_empty($logged_userid);

    $previous_added_address = array();
    $previous_added_address_additional_values = array();

    foreach ($address_book as $addrid => $data) {
        // Add/update address

        $is_first_registration = $is_address_book_empty && func_is_addresses_different($previous_added_address, $data, 'H', $previous_added_address_additional_values, $additional_values_hash[$addrid]);

        $data['default_' . strtolower($addrid)] = 'Y';

        if (empty($ship2diff) || $ship2diff != 'Y') {
            if ($addrid == 'S') {
                continue;
            } else {
                $data['default_s'] = $data['default_b'] = 'Y';
            }
        } 

        if (
            (
                $is_first_registration
                || isset($new_address[$addrid])
            )
        ) {
            // Add new address book row from checkout
            $previous_added_address = $data;
            $previous_added_address_additional_values = $additional_values_hash[$addrid];
            func_unset($previous_added_address, 'default_s', 'default_b');

            $_res = func_save_address($logged_userid, 0, $data);
            $address_book[$addrid]['id'] = $_res['addressid'];
            if (!empty($additional_values_hash[$addrid])) {
                func_save_address_additional_values($address_book[$addrid]['id'], $additional_values_hash[$addrid]);
            }
        } elseif (@$existing_address[$addrid] > 0) {
            // Update address book from checkout
            func_save_address($logged_userid, $existing_address[$addrid], $data);
            if (!empty($additional_values_hash[$addrid])) {
                func_save_address_additional_values($existing_address[$addrid], $additional_values_hash[$addrid]);
            }
        }
    }

    return $address_book;
}

function func_admin_mark_default_addresses($logged_userid, $new_addressid)
{
    if (!empty($logged_userid)) {
        foreach (array('B', 'S') as $suffix) {
            $fieldname = 'default_' . strtolower($suffix);
            if (isset($_POST[$fieldname])) {
                $addressid = ($_POST[$fieldname] == 0 && isset($new_addressid))
                    ? $new_addressid
                    : abs(intval($_POST[$fieldname]));
                func_mark_default_address($addressid, $logged_userid, $suffix);
            }
        }
    }

    return true;
}

/**
 * Convert array(fieldid => array('B' => $b_data, 'S' => $s_data))
 * to array('B' => array(fieldid => $b_data), 'S' => array(fieldid => $s_data))
 * ignoring non-array entries
 * Used to prepare data received from registration form
 */
function func_address_additional_values_hash_by_type($additional_values) { //{{{

    $result = array();

    if (empty($additional_values) || !is_array($additional_values)) {
        return $result;
    }

    foreach ($additional_values as $fieldid => $field) {
        if (!empty($field) && is_array($field)) {
            foreach ($field as $addrid => $value) {
                $result[$addrid][$fieldid] = $value;
            }
        }
    }

    return $result;

} //}}}

function func_adjust_address_additional_values($additional_fields, $addressids = array()) { //{{{

    assert('!empty($additional_fields) /*' . __FUNCTION__ . '*/');

    global $sql_tbl;

    $values_hash = array('B' => '', 'S' => '');

    $is_filled_in = false;

    foreach (array('B', 'S') as $prefix) {

        // Get address book additional field values from session

        if (empty($addressids[$prefix])) {
            $values_hash[$prefix] = func_get_cart_address_additional_fields($prefix);
        } else {
            $values_hash[$prefix] = $addressids[$prefix];
        }

        if (!empty($values_hash[$prefix]) && !is_array($values_hash[$prefix])) {

            // Presume it is addressid value, get values from DB

            $values_hash[$prefix] = func_get_address_additional_values($values_hash[$prefix]);

        }

        $is_filled_in = $is_filled_in || !empty($values_hash[$prefix]);

    }

    if ($is_filled_in) {

        if (!empty($values_hash['B']) && empty($values_hash['S'])) {
            // presume $ship2diff is disabled
            $values_hash['S'] = $values_hash['B'];

        }

        foreach ($additional_fields as $k => $v) {

            if ($v['section'] == 'B') {
                foreach (array('B', 'S') as $prefix) {
                    if (!empty($values_hash[$prefix][$v['fieldid']])) {
                        $additional_fields[$k]['value'][$prefix] = $values_hash[$prefix][$v['fieldid']];
                    } else {
                        $additional_fields[$k]['value'] = null;
                    }
                }
            }

        }

    }

    return array($additional_fields, $values_hash);

} //}}}

function func_get_address_additional_values($addressid) { //{{{

    global $sql_tbl;

    return func_query_hash("SELECT fieldid, value FROM $sql_tbl[register_field_address_values] WHERE addressid = '$addressid'", 'fieldid', false, true);

} //}}}

function func_save_address_additional_values($addressid, $address_additional_values) { //{{{

    global $sql_tbl;

    if (empty($address_additional_values) || !is_array($address_additional_values) || empty($addressid)) {
        return false;
    }

    db_query("DELETE FROM $sql_tbl[register_field_address_values] WHERE addressid = '$addressid'");

    foreach ($address_additional_values as $fieldid => $v) {
        func_array2insert(
            'register_field_address_values',
            array(
                'fieldid'    => $fieldid,
                'addressid'  => $addressid,
                'value'      => $v,
            )
        );
    }

    return true;

} //}}}

function func_set_address_additional_values($additional_fields, $additional_values, $remove_non_address_fields = false) { //{{{

    assert('is_array($additional_values) && is_array($additional_fields) /*' . __FUNCTION__ . '*/');

    foreach ($additional_fields as $k => $v) {
        if (isset($additional_values[$v['fieldid']])) {
            $additional_fields[$k]['value'] = $additional_values[$v['fieldid']];
        } elseif ($v['section'] != 'B' && $remove_non_address_fields) {
            unset($additional_fields[$k]);
        }
    }

    return $additional_fields;

} //}}}

/**
 * Compare b_address with s_address on checkout pages
 * return false if is equal
 * return true if is different
 */
function func_is_addresses_different($b_address, $s_address, $fields_area = 'H', $b_additional_values = array(), $s_additional_values = array())
{
    $is_different = false;

    func_unset($b_address, 'id');
    func_unset($s_address, 'id');

    $addr_intersect = array_intersect_assoc($b_address, $s_address);
    $address_fields = func_get_default_fields($fields_area, 'address_book');

    if (
        empty($s_address)
        || count($b_address) != count($s_address)
        || count($b_address) != count($addr_intersect)
    ) {
       $is_different = true;
    }

    if (
        !$is_different
        && $address_fields['zipcode']['avail'] == 'Y'
        && !empty($s_address['zipcode'])
        && !empty($s_address['country'])
    ) {
        $is_different = !func_check_zip($s_address['zipcode'], $s_address['country'], false);
    }

    if (!$is_different && (!empty($b_additional_values) || !empty($s_additional_values))) {

        $is_different = func_is_address_additional_fields_different($b_additional_values, $s_additional_values);

    }

    return $is_different;
}

function func_is_address_additional_fields_different($b_additional_values, $s_additional_values)
{

    $is_different = false;

    $intersect = array_intersect_assoc($b_additional_values, $s_additional_values);

    if (
        empty($s_additional_values)
        || count($b_additional_values) != count($s_additional_values)
        || count($b_additional_values) != count($intersect)
    ) {
       $is_different = true;
    }

    return $is_different;

}

/**
 * Setter for $cart['used_s(b)_address'] global session var. 
 * Setter for $l_cart['used_s(b)_address'] local var
 * Use only this function to change the vars
 */
function func_set_cart_address($l_cart, $type, $data, $run_save = '', $additional_fields = array())
{
    // x_session_register('cart') should be run before func_set_cart_address in global scope
    global $cart;

    settype($type, 'string');

    if (func_is_cart_empty($cart))
        return $cart;

    $field = 'used_' . strtolower($type) . '_address';

    $cart[$field] = $l_cart[$field] = $data;

    if (!empty($additional_fields)) {
        $cart[$field . '_additional'] = $l_cart[$field . '_additional'] = $additional_fields;
    } elseif ($additional_fields === FALSE) {
        unset($cart[$field . '_additional']);
        unset($l_cart[$field . '_additional']);
    }

    x_session_register('cart', $cart);

    if (!empty($run_save)) {
        x_session_save('cart');
    }
    
    return $l_cart;
} 

/*
 * Getter for $cart['used_s(b)_address'] session vars. 
 * Use only this function to get these vars
 */
function func_get_cart_address($type, $get_additional = false)
{
    global $cart;
    settype($type, 'string');

    if (!isset($cart))
        x_session_register('cart');

    $field = 'used_' . strtolower($type) . '_address';

    if ($get_additional) {
        $field .= '_additional';
    }

    if (isset($cart[$field]))        
        return $cart[$field]; 
    else         
        return '';
}

function func_get_cart_address_additional_fields($type) {
    return func_get_cart_address($type, true);
}

function func_is_completed_userinfo($userinfo)
{
    return !empty($userinfo) && empty($userinfo['is_incomplete']);
}

/**
 * Send mail to registered user (do not send to anonymous)
 */
function func_do_signin_email_notification($userinfo, $send_to_cust_dept = false)
{

    global $mail_smarty, $config, $active_modules;

    $email = (!empty($userinfo['email'])) ? $userinfo['email'] : '';

    x_load('mail');

    $mail_smarty->assign('userinfo', $userinfo);

    $mail_smarty->assign('full_usertype', func_get_langvar_by_name($userinfo['usertype'] == 'B' ? 'lbl_partner' : ($userinfo['usertype'] == 'P' ? 'lbl_provider' : 'lbl_customer')));

    $send_to_user = !empty($email) && !$send_to_cust_dept;

    if ($send_to_user) {

        if ($userinfo['usertype'] == 'B') {

            if (!empty($active_modules['XAffiliate']) && $config['XAffiliate']['eml_signin_partner_notif'] == 'Y') {

                func_send_mail(
                    $email,
                    'mail/signin_notification_subj.tpl',
                    'mail/signin_partner_notif.tpl',
                    $config['Company']['users_department'],
                    false
                );

            }

        } elseif ($userinfo['usertype'] == 'P') {

            if ($config['Email_Note']['eml_signin_provider_notif'] == 'Y') {

                func_send_mail(
                    $email,
                    'mail/signin_notification_subj.tpl',
                    'mail/signin_provider_notif.tpl',
                    $config['Company']['users_department'],
                    false
                );

            }

        } else {

            if ($config['Email_Note']['eml_signin_notif'] == 'Y') {

                func_send_mail(
                    $email,
                    'mail/signin_notification_subj.tpl',
                    'mail/signin_notification.tpl',
                    $config['Company']['users_department'],
                    false
                );

            }

        }

    }

    if ($send_to_cust_dept && $config['Email_Note']['eml_signin_notif_admin'] == 'Y') {

        // Send mail to customers department

        func_send_mail(
            $config['Company']['users_department'],
            'mail/signin_admin_notif_subj.tpl',
            'mail/signin_admin_notification.tpl',
            $email,
            true
        );

    }

}

function func_do_signin_email_notification_cust_dept($userinfo) {
    return func_do_signin_email_notification($userinfo, true);
}

?>
