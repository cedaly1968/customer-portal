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
 * "PayByCheck - XML" payment module (check processor)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v27 (xcart_4_5_5), 2013-02-04 14:14:03, ch_pbcxml.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

x_load('http');

$pp_procid = $module_params['param01'];
$pp_pass = $module_params['param02'];
$pp_mid = $module_params['param03'];
$pp_cur = $module_params['param04'];
$pp_ordr = $module_params['param09'].join("-",$secure_oid);

if($module_params['testmode']=="Y") {
    $pp_procid = '00000000';
    $pp_pass = 'jerry';
    $pp_mid = '00000000';
    $pp_cur = 'USD';
    $userinfo['check_brn'] = '226070555';
    $userinfo['check_ban'] = '1234567890';
    $userinfo['check_number'] = sprintf("%05d",rand(100,9999));
}

$post = array();
$post[] = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$post[] = "<!DOCTYPE Query SYSTEM \"ism.dtd\">";
$post[] = "<Query>";
$post[] = "<Version>ISM XML 1.0</Version>";
$post[] = "<Service>PRE</Service>";
$post[] = "<Processor><ProcessorID>".$pp_procid."</ProcessorID><Password>".$pp_pass."</Password></Processor>";
$post[] = "<Request>";
$post[] = "<Payment>";
$post[] = "<MerchantID>".$pp_mid."</MerchantID> ";
$post[] = "<Account>PCK:".$userinfo['check_brn'].":".$userinfo['check_ban'].":".$userinfo['check_number']."</Account> ";
$post[] = "<Amount>".$cart['total_cost']."</Amount> ";
$post[] = "<Currency>".$pp_cur."</Currency> ";
$post[] = "<Presentment>VTL</Presentment> ";
$post[] = "<ConsumerMemo>".$pp_ordr."</ConsumerMemo> ";
$post[] = "</Payment>";
$post[] = "<Consumer>";
$post[] = "<Name>".$bill_name."</Name> ";
$post[] = "<Address>".$userinfo['b_address']."</Address> ";
$post[] = "<City>".$userinfo['b_city']."</City> ";
$post[] = "<State>".$userinfo['b_state']."</State> ";
$post[] = "<Zip>".$userinfo['b_zipcode']."</Zip> ";
$post[] = "<Phone>".$userinfo['phone']."</Phone> ";
$post[] = "<Email>".$userinfo['email']."</Email> ";
$post[] = "</Consumer>";
$post[] = "<Authorization>";
$post[] = "<AuthType>DIG</AuthType> ";
$post[] = "<Signature>".$userinfo['check_name']."</Signature> ";
$post[] = "<AuthAddress>".func_get_valid_ip($REMOTE_ADDR)."</AuthAddress> ";
$post[] = "</Authorization>";
$post[] = "</Request>";
$post[] = "</Query>";
$pst = "xmldoc=".join('',$post);

list($a, $ret) = func_https_request('POST', "https://secure.itinternet.net:443/ism/", array($pst));

preg_match("/<Results>(.*)<\/Results>/ims",$ret,$out);$return = $out[1];

if(preg_match("/<MiscInfo>(.*)<\/MiscInfo>/i",$return,$out)) {
    $bill_output['code'] = 2;
    $bill_output['billmes'] = $out[1];

} elseif(preg_match("/<Status>INVALID<\/Status>/i",$return)) {

    $bill_output['code'] = 2;
    if(preg_match("/<Reason>(.*)<\/Reason>/i",$return,$out))
        $bill_output['billmes'] = "INVALID: ".$out[1];

    if(preg_match("/<BankName>(.*)<\/BankName>/i",$return,$out))
        $bill_output['billmes'].= " (BankName: ".trim($out[1]).")";

} elseif(preg_match("/<Status>VALID<\/Status>/i",$return) && preg_match("/<RefNumber>(\d+)<\/RefNumber>/i",$return,$out)) {

    $pp_refnum = $out[1];
    $post = array();
    $post[] = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $post[] = "<!DOCTYPE Query SYSTEM \"ism.dtd\">";
    $post[] = "<Query>";
    $post[] = "<Version>ISM XML 1.0</Version>";
    $post[] = "<Service>POST</Service>";
    $post[] = "<Processor><ProcessorID>".$pp_procid."</ProcessorID><Password>".$pp_pass."</Password></Processor>";
    $post[] = "<Request>";
    $post[] = "<MerchantID>".$pp_mid."</MerchantID> ";
    $post[] = "<RefNumber>".$pp_refnum."</RefNumber> ";
    $post[] = "</Request>";
    $post[] = "</Query>";
    $pst = "xmldoc=".join('',$post);

    list($a, $ret) = func_https_request('POST', "https://secure.itinternet.net:443/ism/", array($pst));

    preg_match("/<Results>(.*)<\/Results>/ims",$ret,$out);$return = $out[1];

    preg_match("/<Status>(.*)<\/Status>/i",$return,$status);$status = $status[1];

    if($status=="APPROVED") {
        $bill_output['code'] = 1;
    } else {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = $status;
    }

    preg_match("/<Code>(.*)<\/Code>/i",$return,$out);
    $bill_output['billmes'].= ($out[1] ? ": ".$out[1] : '');
    $bill_output['billmes'].=" (RefNumber: ".$pp_refnum.")";

} else {
    $bill_output['code'] = 2;
    $bill_output['billmes'] = "response error";
}

?>
