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
 * OpenSSL HTTPS module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v25 (xcart_4_5_5), 2013-02-04 14:14:03, func.https_openssl.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

// INPUT:
//
// $method          [string: POST|GET]
//
// $url             [string]
//  www.yoursite.com:443/path/to/script.asp
//
// $data            [array]
//  $data[] = "parametr=value";
//
// $join            [string]
//  $join = "\&";
//
// $cookie          [array]
//  $cookie = "parametr=value";
//
// $conttype        [string]
//  $conttype = 'text/xml';
//
// $referer         [string]
//  $conttype = "http://www.yoursite.com/index.htm";
//
// $cert            [string]
//  $cert = "../certs/demo-cert.pem";
//
// $kcert           [string]
//  $keyc = "../certs/demo-keycert.pem";
//
// $rhead           [string]
//  $rhead = '...';
//
// $rbody           [string]
//  $rbody = '...';
//
// [15:53][mclap@rrf:S4][~]$ openssl version
// OpenSSL 0.9.7a Feb 19 2003

function func_https_request_openssl($method, $url, $data="", $join="&", $cookie="", $conttype="application/x-www-form-urlencoded", $referer="", $cert="", $kcert="", $headers="", $timeout = 0, $use_ssl3 = false)
{
    global $xcart_dir;

    if ($method != 'POST' && $method != 'GET')
        return array('0',"X-Cart HTTPS: Invalid method");

    if (!preg_match("/^(https?:\/\/)(.*\@)?([a-z0-9_\.\-]+):(\d+)(\/.*)$/Ui",$url,$m))
        return array('0',"X-Cart HTTPS: Invalid URL");

    $openssl_binary = func_find_executable('openssl');
    if (!$openssl_binary)
        return array('0',"X-Cart HTTPS: openssl executable is not found");

    if (!X_DEF_OS_WINDOWS)
        putenv("LD_LIBRARY_PATH=".getenv('LD_LIBRARY_PATH').":".dirname($openssl_binary));

    $ui = @parse_url($url);

    // build args
    $args[] = "-connect $ui[host]:$ui[port]";
    if ($cert) $args[] = '-cert '.func_shellquote($cert);
    if ($kcert) $args[] = '-key '.func_shellquote($kcert);

    if ($use_ssl3)
        $args[] = '-ssl3';

    if (
        defined('USE_CURLOPT_SSL_VERIFYPEER')
        && file_exists($xcart_dir . '/payment/certs/curl-ca-bundle.crt')
    ) {
        $args[] = "-CAfile '$xcart_dir/payment/certs/curl-ca-bundle.crt'";
    }

    $request = func_https_prepare_request($method, $ui,$data,$join,$cookie,$conttype,$referer,$headers);
    $tmpfile = func_temp_store($request);
    $tmpignore = func_temp_store('');

    if (empty($tmpfile)) {
        @unlink($tmpignore);
        return array(0, "X-Cart HTTPS: cannot create temporaly file");
    }

    $cmdline = func_shellquote($openssl_binary)." s_client ".join(' ',$args)." -quiet < ".func_shellquote($tmpfile)." 2>".func_shellquote($tmpignore);

    // make pipe
    $fp = popen($cmdline, 'r');

    x_log_tmp_file($tmpignore);

    if( !$fp ) {
        @unlink($tmpfile);
        @unlink($tmpignore);
        return array(0, "X-Cart HTTPS: openssl execution failed");
    }

    $res = func_https_receive_result($fp);
    pclose($fp);

    @unlink($tmpfile);
    @unlink($tmpignore);

    return $res;
}

?>
