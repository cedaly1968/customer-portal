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
 * Server-Hosted payment
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v36 (xcart_4_5_5), 2013-02-04 14:14:03, cc_anz.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!isset($_GET['vpc_TxnResponseCode'])) {

    if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }
    x_session_register('is_processed');

    $vpc_amount = ($module_params['param05'] == 'Y') ? $cart['total_cost']*100 : floor($cart['total_cost']);

    $is_processed = false;
    $post = array();
    $post['vpc_AccessCode'] = $module_params["param02"];
    $post['vpc_Amount'] = $vpc_amount;
    $post['vpc_Command'] = "pay";
    $post['vpc_Locale'] = "en";
    $post['vpc_MerchTxnRef'] = $module_params["param04"].join("-",$secure_oid);
    $post['vpc_Merchant'] = $module_params["param01"];
    $post['vpc_OrderInfo'] = substr("Order #".join("-",$secure_oid), 0, 34);
    $post['vpc_ReturnURL'] = $current_location."/payment/cc_anz.php?".$XCART_SESSION_NAME."=".$XCARTSESSID;
    $post['vpc_Version'] = "1";

    $md5_value = $module_params['param03'];
    foreach ($post as $k => $v) {
        $md5_value .= $v;
    }
    $post['vpc_SecureHash'] = strtoupper(md5($md5_value));

    func_create_payment_form("https://migs.mastercard.com.au/vpcpay", $post, "ANZ eGate Server-Hosted");
    exit;

} else {
    require './auth.php';

    x_session_register('is_processed');
    if ($is_processed)
        exit;
    $is_processed = true;

    if (!func_is_active_payment('cc_anz.php'))
        exit;

    $bill_output = array();
    $bill_output['sessid'] = $XCARTSESSID;
    if ($vpc_TxnResponseCode == '0') {
        $bill_output['code'] = 1;
        $bill_output['billmes'] = "Approved. Transaction ID: $vpc_TransactionNo;";

    } else {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = "Declined: Result code: $vpc_TxnResponseCode / $vpc_AcqResponseCode; Message: $vpc_Message; Transaction ID: $vpc_TransactionNo;";
    }

    if (isset($vpc_Amount)) {
        $payment_return = array(
            'total' => (empty($vpc_Amount) ? 0 : $vpc_Amount / 100)
        );
    }

    require($xcart_dir.'/payment/payment_ccend.php');
}
?>
