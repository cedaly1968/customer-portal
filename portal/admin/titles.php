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
 * Titles management
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    7d202a27df2a5a23e54717255f3b8ae6ac447877, v26 (xcart_4_6_0), 2013-04-24 17:11:44, titles.php, random
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('IS_MULTILANGUAGE', 1);

require './auth.php';
require $xcart_dir.'/include/security.php';

x_load('backoffice');

$location[] = array(func_get_langvar_by_name('lbl_titles_management'), '');

// Add title
if ($mode == 'add' && !empty($add['title'])) {
    if (empty($add['orderby']))
        $add['orderby'] = func_query_first_cell("SELECT MAX(orderby) FROM $sql_tbl[titles]")+1;
    $id = func_array2insert('titles', $add);
    func_languages_alt_insert('title_'.$id, $add['title'], $shop_language);

// Update title(s)
} elseif ($mode == 'update' && !empty($data)) {
    foreach ($data as $id => $v) {
        $v['active'] = $v['active'];
        func_languages_alt_insert('title_'.$id, $v['title'], $shop_language);
        if ($shop_language != $config['default_admin_language']) {
            unset($v['title']);
        }
        func_array2update('titles', $v, "titleid = '$id'");
    }

// Delete title(s)
} elseif ($mode == 'delete' && !empty($ids)) {
    $string = "titleid IN ('".implode("','", $ids)."')";
    db_query("DELETE FROM $sql_tbl[titles] WHERE ".$string);
    db_query("DELETE FROM $sql_tbl[languages_alt] WHERE name IN ('title_".implode("','title_", $ids)."')");
}

if (!empty($mode)) {
    func_header_location('titles.php');
}

$smarty->assign('titles', func_get_titles(false));

/**
 * Assign Smarty variables and show template
 */
$smarty->assign('main', 'titles');

// Assign the current location line
$smarty->assign('location', $location);

// Assign the section navigation data
$dialog_tools_data = array('help' => true);
$smarty->assign('dialog_tools_data', $dialog_tools_data);

if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl',$smarty);
?>
