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
 * Manage advertising campaigns
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    81879468e233b88f57fb4e95041b7a5332dc50ee, v30 (xcart_4_6_0), 2013-04-22 17:13:56, partner_adv_campaigns.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('NUMBER_VARS', "add['per_visit'],add['per_period']");
require './auth.php';
require $xcart_dir.'/include/security.php';

if (empty($active_modules['XAffiliate']))
    func_403(29);

$location[] = array(func_get_langvar_by_name('lbl_adv_campaigns_management'), "");

/**
 * Define data for the navigation within section
 */
$dialog_tools_data['right'][] = array('link' => 'partner_adv_stats.php', 'title' => func_get_langvar_by_name('lbl_adv_statistics'));

if ($close) {
    func_header_location('partner_adv_campaigns.php');

} elseif ($mode == 'add' && !empty($add['campaign']) && ($add['per_visit'] > 0 || $add['per_period'] > 0)) {

    if ($start_date) {
        $add['start_date'] = func_prepare_search_date($start_date);
        $add['end_date']   = func_prepare_search_date($end_date, true);
    }

    $data = array(
        'campaign' => $add['campaign'],
        'type' => $add['type'],
        'data' => $add['data'],
        'per_visit' => $add['per_visit'],
        'per_period' => $add['per_period'],
        'start_period' => $add['start_date'],
        'end_period' => $add['end_date']
    );

    if ($campaignid) {
        func_array2update('partner_adv_campaigns', $data, "campaignid = '$campaignid'");

    } else {
        $campaignid = func_array2insert('partner_adv_campaigns', $data);
    }

    func_header_location("partner_adv_campaigns.php?campaignid=".$campaignid);

} elseif ($mode == 'delete' && $campaignid) {

    db_query("DELETE FROM $sql_tbl[partner_adv_campaigns] WHERE campaignid = '$campaignid'");
    func_header_location('partner_adv_campaigns.php');
}

if ($campaignid) {
    $smarty->assign('campaign', func_query_first("SELECT * FROM $sql_tbl[partner_adv_campaigns] WHERE campaignid = '$campaignid'"));
}

$smarty->assign('campaigns', func_query("SELECT * FROM $sql_tbl[partner_adv_campaigns]"));

$smarty->assign ('main', 'partner_adv_campaigns');

$smarty->assign ('month_begin', mktime(0, 0, 0, date('m'), 1, date('Y')));

// Assign the current location line
$smarty->assign('location', $location);

// Assign the section navigation data
$smarty->assign('dialog_tools_data', $dialog_tools_data);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl', $smarty);
?>
