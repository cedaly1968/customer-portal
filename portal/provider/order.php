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
 * Order details interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Provder interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    81879468e233b88f57fb4e95041b7a5332dc50ee, v84 (xcart_4_6_0), 2013-04-22 17:13:56, order.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require './auth.php';
require $xcart_dir.'/include/security.php';

x_load('order');

if (!empty($active_modules['Simple_Mode']))
    func_header_location($xcart_catalogs['admin']."/order.php?$QUERY_STRING");

/**
 * Collect infos about ordered products
 */
require $xcart_dir.'/include/history_order.php';

if (!empty($active_modules['Google_Checkout']))
    include $xcart_dir.'/modules/Google_Checkout/gcheckout_admin.php';

$order = $order_data['order'];
$userinfo = $order_data['userinfo'];
$products = $order_data['products'];
$giftcerts = $order_data['giftcerts'];

/**
 * Security protection from updating another's order
 */

if(!$single_mode && $order_data['products'][0]['provider']!=$logged_userid) {
    func_403(46);
}

if ($REQUEST_METHOD=="POST") {

    // Update order.
    // Providers don't have full access to orders as admins
    // order_notes & tracking_number can be modified +
    // providers can set 'C' order status (complete order)

    if ($mode == 'status_change') {
        $query_data = array (
            'tracking' => $tracking,
            'notes'    => $notes,
        );

        if (isset($customer_notes)) {
            $query_data['customer_notes'] = $customer_notes;
        }
        func_array2update('orders', $query_data, "orderid = '$orderid'");

        // Save in the changes history
        if (!empty($active_modules['Advanced_Order_Management'])) {

            $diff = func_aom_prepare_diff('X', $query_data, $order);

            if (!empty($diff) || !empty($history_comment)) {
                $details = array(
                    'old_status' => $order['status'],
                    'new_status' => $order['status'],
                    'diff' => $diff,
                    'comment' => $history_comment,
                    'is_public' => $history_is_public
                );
                func_aom_save_history($orderid, 'X', $details);
            }
        }
    } elseif ($mode == 'cnote') {

    // Update customer notes
    func_array2update(
        'orders',
        array(
            'customer_notes' => $customer_notes,
        ),
        "orderid = '$orderid'"
    );

    if (!empty($active_modules['Advanced_Order_Management'])) {

        $diff = func_aom_prepare_diff(
            'X',
            array(
                'customer_notes' => $customer_notes,
            ),
            $order
        );

        if (!empty($diff)) {

            $details = array(
                'new_status' => $order['status'],
                'diff'       => $diff,
            );

            func_aom_save_history($orderid, 'X', $details);

        }

    }

    exit;

    } elseif ($mode == 'complete_order')    {

        func_change_order_status($orderid, 'C');

        // Save in the changes history
        if (!empty($active_modules['Advanced_Order_Management']) && $order['status'] != $status) {
            define('STATUS_CHANGE_REF', 1);
            $details = array(
                'old_status' => $order['status'],
                'new_status' => 'C'
            );
            func_aom_save_history($orderid, 'X', $details);
        }
    }

    $top_message = array(
        'content' => func_get_langvar_by_name('txt_order_has_been_changed')
    );
    func_header_location("order.php?orderid=".$orderid);
}

/**
 * Delete order
 */
if ($mode == 'delete') {

    func_delete_order($orderid);

    func_header_location("orders.php?".$query_string);
}

$smarty->assign('main','history_order');

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('provider/home.tpl',$smarty);
?>
