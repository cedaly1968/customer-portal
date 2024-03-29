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
 * Checkout by Amazon
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    357e2f2716a0895d93d0950886794a03f8aecabd, v17 (xcart_4_6_0), 2013-02-26 11:26:41, checkout.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 *
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

set_time_limit(86400);

define('ALL_CARRIERS', 1);

if (defined('CHECKOUT_STARTED')) {
// Start Amazon Checkout

    if ($func_is_cart_empty)
        return;
    
    x_load('xml');
    func_acheckout_debug('*** XML REQUEST SENDING');
    $xml_Order = func_amazon_xml1_Order($cart, $userinfo);
    func_acheckout_debug("*** XML REQUEST:\n\n" . $xml_Order . "\n\n", true);
    $encoded_cart = func_amazon_encode_cart($xml_Order);


    //Save session data
    x_session_register('gcheckout_saved_ips');
    $gcheckout_saved_ips = array('ip' => $CLIENT_IP, 'proxy_ip' => $PROXY_IP);

    func_acheckout_debug("\t+ Sending message: order-input");
    func_amazon_submit_encoded_cart($encoded_cart);
    x_session_save();
    exit;        
}
elseif (defined('IS_STANDALONE')) {
// Handle callbacks from Amazon Checkout

    if (empty($active_modules['Amazon_Checkout']))
        func_header_location($xcart_catalogs['customer']."/cart.php");

    x_load('xml','cart');
    func_amazon_log_raw_post_get_data();

    if ($mode == 'cancel') {
        // Customer canceled the checkout by amazon
        func_amazon_handle_cancel(@$skey);
    } elseif ($mode == 'continue') {
        // Customer returned to store from Amazon Checkout
        func_amazon_handle_return(@$skey, @$amznPmtsOrderIds);
    } else {

        if (!func_amazon_is_validated_callback()) {
            func_acheckout_debug("\t+ Signature test for callback is not passed");
            func_amazon_header_exit(403);
        }

        $allowed_post_requests = $trusted_post_variables;
        // Resolve type of callback
        $request_data = $request_type = '';
        foreach ($allowed_post_requests as $name) {
            if (!empty($_POST[$name])) {
                $request_type = $name;
                $request_data = stripslashes($_POST[$name]);
                break;
            }
        }

        $options = array(
            'XML_OPTION_CASE_FOLDING' => 1,
            'XML_OPTION_TARGET_ENCODING' => 'ISO-8859-1'
        );
        $parse_error = false;
        $parsed = func_xml_parse($request_data, $parse_error, $options);

        define('AMAZON_CHECKOUT_CALLBACK', 1);

        func_acheckout_debug('*** CALLBACK RECEIVED');
        func_acheckout_debug("\t+ Message received: $request_type");

        if ($request_type == 'order-calculations-request') {
            include_once $xcart_dir.'/modules/Amazon_Checkout/checkout_callback.php';
        } elseif ($request_type == 'NotificationData') {
            include_once $xcart_dir.'/modules/Amazon_Checkout/order_notifications.php';
        } else {
            func_acheckout_debug("\t+ unhandled callback request: $request_type");
        }
    }
}

exit;

?>
