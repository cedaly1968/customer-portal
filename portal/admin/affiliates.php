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
 * Display for partner pyramid of his affiliates
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    81879468e233b88f57fb4e95041b7a5332dc50ee, v32 (xcart_4_6_0), 2013-04-22 17:13:56, affiliates.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require './auth.php';
require $xcart_dir.'/include/security.php';

if (empty($active_modules['XAffiliate']))
    func_403(26);

$location[] = array(func_get_langvar_by_name('lbl_affiliates_tree'), '');

/**
 * Define data for the navigation within section
 */
$dialog_tools_data['left'][] = array('link' => 'banner_info.php', 'title' => func_get_langvar_by_name('lbl_banners_statistics'));
$dialog_tools_data['left'][] = array('link' => 'referred_sales.php', 'title' => func_get_langvar_by_name('lbl_referred_sales'));
$dialog_tools_data['left'][] = array('link' => 'partner_top_performers.php', 'title' => func_get_langvar_by_name('lbl_top_performers'));
$dialog_tools_data['left'][] = array('link' => 'affiliates.php', 'title' => func_get_langvar_by_name('lbl_affiliates_tree'));
$dialog_tools_data['left'][] = array('link' => 'partner_adv_stats.php', 'title' => func_get_langvar_by_name('lbl_adv_statistics'));

if($affiliate) {
    $_logged_userid = $logged_userid;
    $logged_userid = intval($affiliate);
    include $xcart_dir.'/include/affiliates.php';
    $logged_userid = $_logged_userid;
    $smarty->assign('affiliate', $affiliate);
}

$partners = func_query("SELECT * FROM $sql_tbl[customers] WHERE usertype = 'B' AND status = 'Y'");
if(!empty($partners))
    $smarty->assign('partners', $partners);

$smarty->assign('main', 'affiliates');

// Assign the current location line
$smarty->assign('location', $location);

// Assign the section navigation data
$smarty->assign('dialog_tools_data', $dialog_tools_data);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl',$smarty);
?>
