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
 * Save statistic about Advertising campaigns
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v34 (xcart_4_5_5), 2013-02-04 14:14:03, adv_info.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

x_session_register ('adv_campaignid');

if (
    empty($adv_campaignid)
    && !empty($_COOKIE['adv_campaignid'])
    && !empty($_COOKIE['adv_campaignid_time'])
) {
    if ($_COOKIE['adv_campaignid_time'] >= XC_TIME) {

        $adv_campaignid = 'Y';

    } else {

        func_setcookie('adv_campaignid');

        func_setcookie('adv_campaignid_time');

    }
}

$_campaignid = 0;

/**
 * For type 'G' (use GET parameter(s))
 */
if ($_GET && $REQUEST_METHOD == 'GET' && empty($adv_campaignid)) {

    $gets = func_query("SELECT campaignid, data, type FROM $sql_tbl[partner_adv_campaigns] USE INDEX (type) WHERE type = 'G'");

    if ($gets) {

        foreach ($gets as $v) {

            $tmp = func_parse_str($v['data']);

            if (!empty($tmp)) {

                $cnt = 0;

                foreach ($tmp as $key => $value) {
                    if (
                        isset($_GET[$key])
                        && $_GET[$key] == $value
                    ) {
                        $cnt++;
                    }
                }

                if ($cnt == count($tmp)) {

                    $QUERY_STRING = implode("&", array_diff(explode("&", $QUERY_STRING), explode("&", $v['data'])));

                    $_campaignid = $v['campaignid'];

                    $_type = $v['type'];

                    break;

                }

            }

        }

    }

}

/**
 * For type 'R' (use HTTP referer parameter)
 */
if (
    $HTTP_REFERER
    && $REQUEST_METHOD == 'GET'
    && !$_campaignid
    && empty($adv_campaignid)
) {
    $refs = func_query("SELECT campaignid, data FROM $sql_tbl[partner_adv_campaigns] USE INDEX (type) WHERE type IN ('R','L')");

    if ($refs) {

        foreach ($refs as $v) {

            if ($HTTP_REFERER == $v['data']) {

                $_campaignid = $v['campaignid'];
                $_type = 'R';

                break;

            }

        }

    }

}

/**
 * Save campaignid if not empty
 */
if ($_campaignid) {

    if ($_type != 'L')
        func_array2insert(
            'partner_adv_clicks',
            array(
                'campaignid' => $_campaignid,
                'add_date'   => XC_TIME,
            ),
            true
        );

    $adv_campaignid = $_campaignid;

    $partner_cookie_length = $config['XAffiliate']['partner_cookie_length']
        ? $config['XAffiliate']['partner_cookie_length'] * 3600 * 24
        : 0;

    if ($partner_cookie_length) {

        $expiry = mktime(0, 0, 0, date('m'), date('d'), date('Y') + 1);

        func_setcookie('adv_campaignid', $adv_campaignid, $expiry);
        func_setcookie('adv_campaignid_time', XC_TIME + $partner_cookie_length, $expiry);

    }

    func_header_location($php_url['url'] . ($QUERY_STRING ? "?" . $QUERY_STRING : ''));

}

?>
