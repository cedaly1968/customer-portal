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
 * Clean URLs dispatcher
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v33 (xcart_4_5_5), 2013-02-04 14:14:03, dispatcher.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('DISPATCHED_REQUEST', 1);

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'preauth.php';

$request_uri_info = @parse_url(stripslashes(func_get_request_uri()));

if (
    !isset($request_uri_info['path'])
    || zerolen($request_uri_info['path'])
    ) {

    func_page_not_found();
}

$dispatched_request = preg_replace('/^' . preg_quote($xcart_web_dir . DIR_CUSTOMER . '/', '/') . '/', '', $request_uri_info['path']);

$smarty->assign('canonical_url', $dispatched_request);

$dispatched_request = $ext_dispatched_request = rtrim($dispatched_request, '/');
$dispatched_request = preg_replace("/\.html$/i", '', $dispatched_request);
$dispatched_request_end = substr($request_uri_info['path'], -1) == '/' ? '/' : '';

if (zerolen($dispatched_request)) {

    func_page_not_found();
}

if ($dispatched_request == 'clean-url-test') {

    die('Clean URLs system test completed successfully.');
}

// Perform lookup in clean urls table.
$clean_url_data = func_clean_url_lookup_resource($dispatched_request, array('clean_url'));

if (
    empty($clean_url_data)
    || !is_array($clean_url_data)
    || !isset($clean_url_data['resource_type'])
    || !isset($clean_url_data['resource_id'])
    ) {

    // We got no matches in clean urls table. Let's check if the URL exists in URLs history.
    $history_url_data = func_clean_url_history_lookup_resource($dispatched_request);

    if (
        !empty($history_url_data)
        && is_array($history_url_data)
        && isset($history_url_data['resource_type'])
        && isset($history_url_data['resource_id'])
    ) {

        $redirect_url = func_get_resource_url($history_url_data['resource_type'], $history_url_data['resource_id']);

        if ($redirect_url) {
            func_header_location($redirect_url, true, 301);
        }
    }

    func_page_not_found();
}

switch ($config['SEO']['clean_urls_ext_'.strtolower($clean_url_data['resource_type'])]) {
    case '.html':
        $redirect_to_canonical_url = !preg_match("/\.html$/Ssi", $ext_dispatched_request) || $dispatched_request_end == '/';
        break;
    case '/':
        $redirect_to_canonical_url = preg_match("/\.html$/Ssi", $ext_dispatched_request) || $dispatched_request_end != '/';
        break;
    default:
        $redirect_to_canonical_url = false;
}

if (!$redirect_to_canonical_url) 
    $redirect_to_canonical_url = $clean_url_data['clean_url'] != $dispatched_request;

// Perform permanent redirect to the corresponding dynamic page 
// if Clean URLs functionality is disabled
// - or -
// perform permanent redirect to the canonical URL if the path is incorrect.
if ($config['SEO']['clean_urls_enabled'] != 'Y' || $redirect_to_canonical_url) {

    $redirect_url = func_get_resource_url($clean_url_data['resource_type'], $clean_url_data['resource_id'], $QUERY_STRING);

    if ($redirect_url) {
        assert("false/*$GLOBALS[HTTP_REFERER], $QUERY_STRING, $dispatched_request, $request_uri_info[path]::Correct is $clean_url_data[clean_url]".$config['SEO']['clean_urls_ext_'.strtolower($clean_url_data['resource_type'])]."*/");
        func_header_location($redirect_url, true, 301);
    }

    func_page_not_found();
}

switch ($clean_url_data['resource_type']) {

case 'C':
    // Category page case
    $_GET['cat'] = $cat = intval($clean_url_data['resource_id']);
    $QUERY_STRING = 'cat=' . $cat . (!empty($QUERY_STRING) ? '&' . $QUERY_STRING : '');
    $PHP_SELF = dirname($PHP_SELF).'/home.php';

    require $xcart_dir.DIR_CUSTOMER.'/home.php';
    break;

case 'P':
    // Product page case
    $_GET['productid'] = $productid = intval($clean_url_data['resource_id']);
    $QUERY_STRING = 'productid=' . $productid . (!empty($QUERY_STRING) ? '&' . $QUERY_STRING : '');
    $PHP_SELF = dirname($PHP_SELF) . '/product.php';

    require $xcart_dir.DIR_CUSTOMER.'/product.php';
    break;

case 'M':
    // Manufacturer page case
    $_GET['manufacturerid'] = $manufacturerid = intval($clean_url_data['resource_id']);
    $QUERY_STRING = 'manufacturerid=' . $manufacturerid . (!empty($QUERY_STRING) ? '&' . $QUERY_STRING : '');
    $PHP_SELF = dirname($PHP_SELF) . '/manufacturers.php';

    require $xcart_dir.DIR_CUSTOMER.'/manufacturers.php';
    break;

case 'S':
    // Static page case
    $_GET['pageid'] = $pageid = intval($clean_url_data['resource_id']);
    $QUERY_STRING = 'pageid=' . $pageid . (!empty($QUERY_STRING) ? '&' . $QUERY_STRING : '');
    $PHP_SELF = dirname($PHP_SELF) . '/pages.php';

    require $xcart_dir.DIR_CUSTOMER.'/pages.php';
    break;

default:

    func_page_not_found();
}

?>
