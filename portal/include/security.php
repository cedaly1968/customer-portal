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
 * Security-related checks and operations
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v52 (xcart_4_5_5), 2013-02-04 14:14:03, security.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

if (empty($login)) {

    func_header_location('login.php');

}

/**
 * Form id checking
 */
if (
    defined('AREA_TYPE')
    && !empty($login)
    && in_array(constant('AREA_TYPE'), array('A', 'P'))
    && function_exists('func_generate_formid')
    && !defined('FORMID_CHECKED')
) {
    // Check posted form id
    $posted_formid = true;

    if (
        !defined('FORM_ID_DISABLED')
        && $REQUEST_METHOD == 'POST'
        && !empty($_POST)
    ) {
        if (!func_check_formid()) {

            $top_message = array(
                'content' => func_get_langvar_by_name('txt_formid_is_wrong', array('length' => $formids_length)),
                'type'    => 'W'
            );

            func_header_location(func_is_internal_url($HTTP_REFERER) ? $HTTP_REFERER : 'home.php');
        }

        $posted_formid = $_POST['_formid'];

        func_unset($_POST, '_formid');

        if (isset($GLOBALS['_formid']))
            unset($GLOBALS['_formid']);
    }

    // Form id order checking
    $formids_length = intval(XCSecurity::FORM_ID_ORDER_LENGTH);

    if ($formids_length < 1) {
        $formids_length = 100;
    }

    if ($formids_length < 2) {

        db_query("DELETE FROM $sql_tbl[form_ids]");

    } else {

        $expire = func_query_first_cell("SELECT expire FROM $sql_tbl[form_ids] WHERE sessid = '$XCARTSESSID' ORDER BY expire DESC LIMIT ".($formids_length-1).", 1");
        if (!empty($expire))
            db_query("DELETE FROM $sql_tbl[form_ids] WHERE expire <= '$expire'");

    }

    define('FORMID_CHECKED', true);
}

if ($user_account['flag'] == 'FS') {

    $_fulfillment_scripts = array(
        'orders.php',
        'order.php',
        'generator.php',
        'statistics.php',
        'register.php',
        'help.php',
        'process_order.php',
        'popup_product.php',
        'popup_category.php',
        'anti_fraud.php',
        'import.php',
        'get_export.php',
        'home.php',
        'quick_search.php',
    );

    if (
        !preg_match("/(?:^|\/)([\w\d_]+\.php)\??(.*)/", $REQUEST_URI, $_fulfillment_match)
        || !in_array($_fulfillment_match[1], $_fulfillment_scripts)
        || (
            $_fulfillment_match[1] == 'statistics.php'
            && $mode == 'logins'
        )
        || (
            $_fulfillment_match[1] == 'register.php'
            && $mode != 'update'
        )
    ) {
        func_403(37);
    }

}

if (!empty($user_account['flag'])) {

    $smarty->assign('current_membership_flag', $user_account['flag']);

}

?>
