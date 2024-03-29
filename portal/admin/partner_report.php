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
 * Partner report
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    bed7007031cf286a4daf9cbad5388eec6e7640ab, v51 (xcart_4_6_0), 2013-04-24 12:17:07, partner_report.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

require './auth.php';
require $xcart_dir.'/include/security.php';

if (empty($active_modules['XAffiliate']))
    func_403(11);

$location[] = array(func_get_langvar_by_name('lbl_partner_accounts'), '');

/**
 * Define data for the navigation within section
 */
$dialog_tools_data['right'][] = array('link' => 'partner_orders.php', 'title' => func_get_langvar_by_name('lbl_partners_orders'));
$dialog_tools_data['right'][] = array('link' => 'payment_upload.php', 'title' => func_get_langvar_by_name('lbl_payment_upload'));

if($mode == 'paid' && $paid && $REQUEST_METHOD == 'POST') {
    foreach($paid as $k => $v) {
        $orders = func_query("SELECT $sql_tbl[orders].orderid FROM $sql_tbl[orders], $sql_tbl[partner_payment] WHERE $sql_tbl[partner_payment].userid = '$k' AND $sql_tbl[partner_payment].orderid = $sql_tbl[orders].orderid AND $sql_tbl[orders].status IN ('P', 'C') AND $sql_tbl[partner_payment].paid <> 'Y'");
        $ids = array();
        if($orders) {
            for($x = 0; $x < count($orders); $x++)
                $ids[] = $orders[$x]['orderid'];
            if(!empty($ids))
                db_query("UPDATE $sql_tbl[partner_payment] SET paid = 'Y' WHERE userid = '$k' AND orderid IN ('".implode("','", $ids)."')");
        }
    }
    func_header_location('partner_report.php');

} elseif($mode == 'export') {

    $smarty->assign ('delimiter', $delimiter);

    $report = func_query("SELECT $sql_tbl[customers].*, $sql_tbl[partner_plans].min_paid, SUM(IF($sql_tbl[orders].status NOT IN ('P', 'C'), $sql_tbl[partner_payment].commissions, 0)) as sum, SUM(IF($sql_tbl[partner_payment].paid = 'Y' AND $sql_tbl[orders].status IN ('P', 'C'), $sql_tbl[partner_payment].commissions, 0)) as sum_paid, SUM(IF($sql_tbl[partner_payment].paid <> 'Y' AND $sql_tbl[orders].status IN ('P', 'C'), $sql_tbl[partner_payment].commissions, 0)) as sum_nopaid, IF(SUM(IF(($sql_tbl[partner_payment].paid <> 'Y' AND $sql_tbl[orders].status IN ('P', 'C')), $sql_tbl[partner_payment].commissions, 0)) >= $sql_tbl[partner_plans].min_paid, 'Y', '') as is_paid FROM $sql_tbl[customers], $sql_tbl[partner_payment], $sql_tbl[partner_commissions], $sql_tbl[partner_plans], $sql_tbl[orders] WHERE $sql_tbl[partner_commissions].userid = $sql_tbl[customers].id AND $sql_tbl[partner_plans].plan_id = $sql_tbl[partner_commissions].plan_id AND $sql_tbl[customers].id = $sql_tbl[partner_payment].userid AND $sql_tbl[orders].orderid = $sql_tbl[partner_payment].orderid AND $sql_tbl[customers].usertype = 'B' AND $sql_tbl[customers].status = 'Y' GROUP BY $sql_tbl[customers].id".($use_limit == 'Y'?" HAVING is_paid = 'Y'":"") . " ORDER BY NULL");

    if ($report) {
        foreach ($report as $key=>$value) {
            foreach ($value as $rk=>$rv)
                $report[$key][$rk] = '"' . str_replace ("\"", "\"\"", $report[$key][$rk]) . '"';
        }
    }
    $smarty->assign ('report', $report);

    header ("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=partner_report.csv");
    func_display('admin/main/partner_report_export.tpl',$smarty);
    exit;
}

$result = func_query("SELECT $sql_tbl[customers].id, $sql_tbl[customers].login, $sql_tbl[customers].firstname, $sql_tbl[customers].lastname, $sql_tbl[partner_plans].min_paid, SUM(IF($sql_tbl[orders].status NOT IN ('P', 'C'), $sql_tbl[partner_payment].commissions, 0)) as sum, SUM(IF($sql_tbl[partner_payment].paid = 'Y' AND $sql_tbl[orders].status IN ('P', 'C'), $sql_tbl[partner_payment].commissions, 0)) as sum_paid, SUM(IF($sql_tbl[partner_payment].paid <> 'Y' AND $sql_tbl[orders].status IN ('P', 'C'), $sql_tbl[partner_payment].commissions, 0)) as sum_nopaid, IF(SUM(IF(($sql_tbl[partner_payment].paid <> 'Y' AND $sql_tbl[orders].status IN ('P', 'C')), $sql_tbl[partner_payment].commissions, 0)) >= $sql_tbl[partner_plans].min_paid, 'Y', '') as is_paid FROM $sql_tbl[customers], $sql_tbl[partner_payment], $sql_tbl[partner_commissions], $sql_tbl[partner_plans], $sql_tbl[orders] WHERE $sql_tbl[partner_commissions].userid = $sql_tbl[customers].id AND $sql_tbl[partner_plans].plan_id = $sql_tbl[partner_commissions].plan_id AND $sql_tbl[customers].id = $sql_tbl[partner_payment].userid AND $sql_tbl[orders].orderid = $sql_tbl[partner_payment].orderid AND $sql_tbl[customers].usertype = 'B' AND $sql_tbl[customers].status = 'Y' GROUP BY $sql_tbl[customers].id".($use_limit == 'Y'?" HAVING is_paid = 'Y'":"") . " ORDER BY NULL");
if($result) {
    foreach($result as $k=>$v) {
        if($v['is_paid'])
            $is_paid = 'Y';
    }
    $smarty->assign ('is_paid', $is_paid);
}
$smarty->assign ('result', $result);

$smarty->assign ('main', 'partner_report');

$smarty->assign('use_limit', $use_limit);

$smarty->assign('dialog_tools_data', $dialog_tools_data);

// Assign the current location line
$smarty->assign('location', $location);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl',$smarty);
?>
