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
 * Payment history
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Partner interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v40 (xcart_4_5_5), 2013-02-04 14:14:03, payment_history.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require "./auth.php";
require $xcart_dir."/include/security.php";

$location[] = array(func_get_langvar_by_name("lbl_payment_history"), "");

/**
 * Define data for the navigation within section
 */
$dialog_tools_data["right"][] = array("link" => "stats.php", "title" => func_get_langvar_by_name("lbl_summary_statistics"));

$date_condition = "";

if ($start_date) {
    $start_date = func_prepare_search_date($start_date);
    $end_date   = func_prepare_search_date($end_date, true);
} else {
    $start_date = mktime (0, 0, 0, date("m",XC_TIME), 1, date("Y",time()));
    $end_date = XC_TIME;
}

$date_condition = " AND ($sql_tbl[partner_payment].add_date >= '$start_date' AND $sql_tbl[partner_payment].add_date <= '$end_date') ";

$query_string = "SELECT * FROM $sql_tbl[partner_payment] WHERE userid = '$logged_userid' AND paid = 'Y' $date_condition ORDER BY add_date";
$smarty->assign ("paid_total", func_query_first_cell ("SELECT SUM(commissions) FROM $sql_tbl[partner_payment] WHERE userid = '$logged_userid' AND paid = 'Y' " . $date_condition));

$total_payments = count (func_query ($query_string));

$objects_per_page = 50;

$total_items = $total_payments;
include $xcart_dir."/include/navigation.php";

$payments = func_query ($query_string);

$smarty->assign ("payments", func_query ($query_string . " LIMIT $first_page, $objects_per_page"));
$smarty->assign ("navigation_script", "payment_history.php?mode=$mode&start_date=$start_date&end_date=$end_date");

// Assign the current location line
$smarty->assign("location", $location);

// Assign the section navigation data
$smarty->assign("dialog_tools_data", $dialog_tools_data);

$smarty->assign("start_date", $start_date);
$smarty->assign("end_date", $end_date);
$smarty->assign("main", "payment_history");
func_display("partner/home.tpl", $smarty);
?>
