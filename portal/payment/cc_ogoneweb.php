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
 * "Ogone - Web Based" payment module (credit card processor)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v40 (xcart_4_5_5), 2013-02-04 14:14:03, cc_ogoneweb.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!isset($REQUEST_METHOD))
        $REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

if ($REQUEST_METHOD == 'GET' && isset($_GET['oid']) && preg_match('/accept|cancel|exception|decline/s', $_GET["mode"])) {

    require './auth.php';

    if (!func_is_active_payment('cc_ogoneweb.php'))
        exit;

    if (defined('OGONE_DEBUG')) {
        func_pp_debug_log('ogoneweb', 'B', $_GET);
    }

    $skey = $oid;

    if ($mode == 'accept') {
        require($xcart_dir.'/payment/payment_ccview.php');
    } else {
        // Acquirer rejects the authorisation more than the maximum of authorised tries (mode=decline) OR
        // Customer cancels the payment (mode=cancel) OR
        // The payment result is uncertain. (mode=exception)
        $bill_output['billmes'].= " (Return code: ".$mode.")";

        $bill_output['code'] = 2;
        require($xcart_dir.'/payment/payment_ccend.php');
    }

} else {

    if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

    func_pm_load('cc_ogone_common'); // Define Func_ogone_generate_signature function

    $pp_merch = $module_params['param01'];
    $pp_secret = $module_params['param03'];
    $pp_curr = $module_params['param04'];
    $pp_test = ($module_params['testmode']=='Y') ?
        "https://secure.ogone.com:443/ncol/test/orderstandard.asp" :
        "https://secure.ogone.com:443/ncol/prod/orderstandard.asp";
    $ordr = $module_params['param06'].join("-",$secure_oid);

    if(!$duplicate)
        db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref,sessid,trstat) VALUES ('".addslashes($ordr)."','".$XCARTSESSID."','GO|".implode('|',$secure_oid)."')");

    $l = array(
        'en' => 'en_US',
        'fr' => 'fr_FR',
        'nl' => 'nl_NL',
        'it' => 'it_IT',
        'de' => 'de_DE',
        'es' => 'es_ES',
        'no' => 'no_NO'
    );

    $post = array(
        'PSPID' => $pp_merch,
        'orderID' => $ordr,
        'amount' => (100*$cart['total_cost']),
        'currency' => $pp_curr,
        'EMAIL' => $userinfo['email'],
        'Owneraddress' => $userinfo['b_address'],
        'OwnerZip' => $userinfo['b_zipcode'],
        'language' => isset($l[$store_language]) ? $l[$store_language] : 'en_US'
    );

    $post['accepturl'] = $post['declineurl'] = $post['exceptionurl'] = $post['cancelurl'] = $current_location."/payment/cc_ogoneweb.php?oid=$ordr&mode=";
    $post['accepturl'] .= 'accept';
    $post['cancelurl'] .= 'cancel';
    $post['exceptionurl'] .= 'exception';
    $post['declineurl'] .= 'decline';

    // For security checking
    $post['COMPLUS'] = md5($pp_curr . $pp_merch . $pp_secret . $XCARTSESSID);

    // Generate SHAsignature based on previous defined $post var
    $post['SHASign'] = func_ogone_generate_signature($post, 'associative_array', $pp_secret);

    if (defined('OGONE_DEBUG')) {
        func_pp_debug_log('ogoneweb', 'I', $post);
    }
    
    func_create_payment_form($pp_test, $post, 'Ogone');
}
exit;

?>
