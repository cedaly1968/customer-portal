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
 * iDEAL: Postbank payment gateway
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v25 (xcart_4_5_5), 2013-02-04 14:14:03, cc_ideala.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

function ideala_test()
{
    return function_exists('openssl_x509_read') &&
        function_exists('openssl_x509_export') &&
        function_exists('openssl_get_privatekey') &&
        function_exists('openssl_sign') &&
        function_exists('openssl_free_key');
}

function ideala_iso8601_time()
{
    list($usec,$sec) = explode(" ", microtime());
    $utc = mktime (date('H',$sec),date('i',$sec),date('s',$sec)-date('Z',$sec),date('m',$sec),date('d',$sec),date('Y',$sec));
    return date("Y-m-d\TH:i:s", $utc).substr($usec, strpos($usec, '.'), 4).'Z';
}

function ideala_token($fn)
{
    $fp = @fopen($fn, 'rb');
    if (!$fp)
        return false;

    $certificate = fread($fp, filesize($fn));
    fclose($fp);

    $x509 = @openssl_x509_read($certificate);
    @openssl_x509_export($x509, $str);

    $str = str_replace("-----BEGIN CERTIFICATE-----",'',$str);
    $str = str_replace("-----END CERTIFICATE-----",'',$str);

    return strtoupper(sha1(base64_decode($str)));
}

function ideala_sign($fn, $password, $message)
{
    $fp = @fopen($fn, 'rb');
    if (!$fp)
        return false;

    $certificate = fread($fp, filesize($fn));
    fclose($fp);

    $message = preg_replace("/\s/", '', $message);

    if ($key = openssl_get_privatekey($certificate, $password)) {
        $signature = '';
        openssl_sign($message, $signature, $key);
        openssl_free_key($key);
        return base64_encode($signature);
    }

    return '';
}

function ideala_tags($return_, $checkme, $line = 0)
{
    $ret = array();
    if ($checkme) {
        foreach ($checkme as $k => $v) {
            if (preg_match("/<".quotemeta($k).">(.*)<\/".quotemeta($k).">/Usi", $return_, $out))
                $ret[$k] = ($line ? $k.": " : '').$out[1];
        }
    }
    return $line ? join("; ",$ret) : $ret;
}

if (isset($_GET) && isset($_GET['ec']) && $_GET['ec'] && isset($_GET['trxid']) && $_GET['trxid']) {

    // Return from gateway
    require_once './auth.php';

    if (!func_is_active_payment('cc_ideala.php'))
        exit;

    x_load('http');

    $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref = '".$_GET["ec"]."'");

    $module_params = func_get_pm_params('cc_ideala.php');

    if (!ideala_test()) {
        include $xcart_dir.'/payment/payment_ccend.php';
        exit;
    }

    $time = ideala_iso8601_time();
    $url = "https://ideal".($module_params['testmode']=="N" ? '' : 'test').".secure-ing.com:443/ideal/iDeal";

    $token = ideala_token($module_params['param03']);
    $tokenCode = ideala_sign(
        $module_params['param04'],
        $module_params['param05'],
        $time.$module_params['param01'].$module_params['param02'].$trxid
    );

    $post = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<AcquirerStatusReq xmlns="http://www.idealdesk.com/Message" version="1.1.0">
    <createDateTimeStamp>$time</createDateTimeStamp>
    <Merchant>
        <merchantID>$module_params[param01]</merchantID>
        <subID>$module_params[param02]</subID>
        <authentication>SHA1_RSA</authentication>
        <token>$token</token>
        <tokenCode>$tokenCode</tokenCode>
    </Merchant>
    <Transaction>
        <transactionID>$trxid</transactionID>
    </Transaction>
</AcquirerStatusReq>
XML;

    list($a, $return) = func_https_request('POST', $url, array($post), '', '', 'text/xml');

    $tags = array(
        'errorcode' => '',
        'errormessage' => '',
        'errordetail' => '',
        'status' => '',
        'transactionid' => '',
        'consumername' => '',
        'consumeraccountnumber' => '',
        'consumercity' => ''
    );
    $ret = ideala_tags($return, $tags);

    if (strtolower($ret['status']) == 'success' || strtolower($ret['status']) == 'open') {
        $bill_output['code'] = strtolower($ret['status'])=="success" ? 1 : 3;
        $bill_output['billmes'] = ideala_tags($return,$tags,1);

    } else {
        $bill_output['code'] = 2;
        if ($ret['errormessage']) {
            $bill_output['billmes'] = $ret['errormessage']."; error code: ".$ret['errorcode'];
            if ($ret['errordetail'])
                $bill_output['billmes'] .= "; error details: ".$ret['errordetail'];

        } else {
            $bill_output['billmes'] = ideala_tags($return, $tags, 1);
        }
    }

    include($xcart_dir.'/payment/payment_ccend.php');
    exit;

} elseif (isset($_POST) && isset($_POST['iid']) && $_POST['iid']) {

    // Issuer is selected: redirect to gateway
    require_once './auth.php';
    if (!func_is_active_payment('cc_ideala.php'))
        exit;

    x_load('http');

    x_session_register('cart');
    x_session_register('secure_oid');

    $module_params = func_get_pm_params('cc_ideala.php');

    if (!ideala_test()) {
        include $xcart_dir.'/payment/payment_ccend.php';
        exit;
    }

    $time = ideala_iso8601_time();
    $url = "https://ideal".($module_params['testmode']=="N" ? '' : 'test').".secure-ing.com:443/ideal/iDeal";
    $ordr = $module_params['param09'].join('x',$secure_oid);
    $rurl = $http_location.'/payment/cc_ideala.php';
    $descr = 'Order'.(count($secure_oid) > 1 ? 's' : '')." ".join(", ",$secure_oid);

    $total_cost = (100*$cart['total_cost']);
    $token = ideala_token($module_params['param03']);
    $tokenCode = ideala_sign(
        $module_params['param04'],
        $module_params['param05'],
        $time.$iid.$module_params['param01'].$module_params['param02'].$rurl.$ordr.$total_cost.$module_params['param06'].$module_params['param07'].$descr.$ordr
    );

    $post = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<AcquirerTrxReq xmlns="http://www.idealdesk.com/Message" version="1.1.0">
    <createDateTimeStamp>$time</createDateTimeStamp>
    <Issuer><issuerID>$iid</issuerID></Issuer>
    <Merchant>
        <merchantID>$module_params[param01]</merchantID>
        <subID>$module_params[param02]</subID>
        <authentication>SHA1_RSA</authentication>
        <token>$token</token>
        <tokenCode>$tokenCode</tokenCode>
        <merchantReturnURL>$rurl</merchantReturnURL>
    </Merchant>
    <Transaction>
        <purchaseID>$ordr</purchaseID>
        <amount>$total_cost</amount>
        <currency>$module_params[param06]</currency>
        <expirationPeriod>PT10M</expirationPeriod>
        <language>$module_params[param07]</language>
        <description>$descr</description>
        <entranceCode>$ordr</entranceCode>
    </Transaction>
</AcquirerTrxReq>
XML;

    list($a, $return) = func_https_request('POST', $url, array($post), '', '', 'text/xml');

    $tags = array(
        'errorcode' => '',
        'errormessage' => '',
        'errordetail' => '',
        'issuerauthenticationurl' => ''
    );
    $ret = ideala_tags($return, $tags);

    if ($ret['issuerauthenticationurl'])    {
        db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref,sessid) VALUES ('".$ordr."','".$XCARTSESSID."')");
        func_header_location(html_entity_decode($ret['issuerauthenticationurl']));

    } else {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = $ret['errormessage']."; error code: ".$ret['errorcode'];
        if ($ret['errordetail'])
            $bill_output['billmes'] .= "; error details: ".$ret['errordetail'];
        $bill_output['sessid'] = $XCARTSESSID;

        include $xcart_dir.'/payment/payment_ccend.php';
    }

    exit;

} else {

    // Get issuers list and select the issuer
    if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

    x_load('http');

    func_set_time_limit(100);

    if (!ideala_test()) {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = func_get_langvar_by_name('lbl_cc_ideal_openssl_not_found', array(), false, true);
        return;
    }

    $url = "https://ideal".($module_params['testmode']=="N" ? '' : 'test').".secure-ing.com:443/ideal/iDeal";

    if (!file_exists($module_params['param03']) || !is_readable($module_params['param03'])) {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = func_get_langvar_by_name('lbl_cc_ideal_public_key_not_found', array(), false, true);
        return;
    }

    if (!file_exists($module_params['param04']) || !is_readable($module_params['param04'])) {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = func_get_langvar_by_name('lbl_cc_ideal_private_key_not_found', array(), false, true);
        return;
    }

    $time = ideala_iso8601_time();

    $token = ideala_token($module_params['param03']);
    $tokenCode = ideala_sign(
        $module_params['param04'],
        $module_params['param05'],
        $time.$module_params['param01'].$module_params['param02']
    );

    $post = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<DirectoryReq xmlns="http://www.idealdesk.com/Message" version="1.1.0">
    <createDateTimeStamp>$time</createDateTimeStamp>
    <Merchant>
        <merchantID>$module_params[param01]</merchantID>
        <subID>$module_params[param02]</subID>
        <authentication>SHA1_RSA</authentication>
        <token>$token</token>
        <tokenCode>$tokenCode</tokenCode>
    </Merchant>
</DirectoryReq>
XML;

    list($a, $return) = func_https_request('POST', $url, array($post), '', '', 'text/xml');

    $tags = array(
        'errorcode' => '',
        'errormessage' => '',
        'errordetail' => '',
        'acquirerid' => ''
    );
    $ret = ideala_tags($return, $tags);

    if ($ret['acquirerid']) {
        $issuers = array();
        $tags = array(
            'issuerid' => '',
            'issuername' => '',
            'issuerlist' => ''
        );
        if (preg_match_all("/<issuerID>.*<\/issuerList>/Uis",$return,$out)) {
            foreach ($out[0] as $o)
                $issuers[] = ideala_tags($o, $tags);
        }

?>

<form action="cc_ideala.php" method="post" name="iidgo">

<div style="width: 100%; text-align: center;">
<table>
<tr>
    <td><?php echo func_get_langvar_by_name('lbl_issuers_list', false, false, true); ?>:</td>
    <td align="center" valign="middle">
<select name="iid" onchange="javascript: if (document.iidgo.iid.value) document.iidgo.submit();">
    <option value=""><?php echo func_get_langvar_by_name('lbl_select', false, false, true); ?></option>
<?php
    foreach($issuers as $i) {
?>
    <option value="<?php echo $i['issuerid']; ?>"><?php echo $i['issuername']; ?></option>
<?php
    }
?>
</select>
    </td>
    <td><noscript><input type="submit" /></noscript></td>
</tr>
</table>
</div>

</form>

<?php
        exit;

    } else {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = $ret['errormessage']."; error code: ".$ret['errorcode'];
        if ($ret['errordetail'])
            $bill_output['billmes'] .= "; error details: ".$ret['errordetail'];
    }
}

?>
