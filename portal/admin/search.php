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
 * Products search interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    9c3dbeffab542029a053110213ecd3dab930fca5, v69 (xcart_4_6_0), 2013-04-25 11:54:59, search.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('NUMBER_VARS', "posted_data['price_min'],posted_data['price_max'],posted_data['avail_min'],posted_data['avail_max'],posted_data['weight_min'],posted_data['weight_max']");

require './auth.php';

require $xcart_dir . '/include/security.php';

x_session_register('search_data');

/**
 * Define data for the navigation within section
 */
$dialog_tools_data['left'][] = array(
    'link'  => 'search.php', 
    'title' => func_get_langvar_by_name('lbl_search_products'),
);
$dialog_tools_data['left'][] = array(
    'link'  => 'product_modify.php', 
    'title' => func_get_langvar_by_name('lbl_add_product'),
);

if (
    $current_area == 'A' 
    || !empty($active_modules['Simple_Mode'])
) {
    $dialog_tools_data['right'][] = array(
        'link'  => 'categories.php', 
        'title' => func_get_langvar_by_name('lbl_categories'),
    );
}

if (!empty($active_modules['Manufacturers'])) {
    $dialog_tools_data['right'][] = array(
        'link'  => 'manufacturers.php', 
        'title' => func_get_langvar_by_name('lbl_manufacturers'),
    );
}

$dialog_tools_data['right'][] = array(
    'link'  => 'orders.php', 
    'title' => func_get_langvar_by_name('lbl_orders'),
);

// The list of the fields allowed for searching
$allowable_search_fields = array (
    'substring',
    'by_title',
    'by_shortdescr',
    'by_fulldescr',
    'extra_fields',
    'by_keywords',
    'categoryid',
    'category_main',
    'category_extra',
    'search_in_subcategories',
    'price_max',
    'price_min',
    'price_max',
    'avail_min',
    'avail_max',
    'weight_min',
    'weight_max',
    'manufacturers',
);

if (
    $REQUEST_METHOD == 'GET' 
    && $mode == 'search'
) {
    // Check the variables passed from GET-request
    $get_vars = array();

    foreach ($_GET as $k => $v) {

        if (in_array($k, $allowable_search_fields))
            $get_vars[$k] = $v;

    }

    // Prepare the search data
    if (!empty($get_vars))
        $search_data['products'] = $get_vars;

    unset($get_vars);
}

if (empty($search_data['products'])) {

    $search_data['products'] = array(
        'category_main'  => true,
        'category_extra' => true,
        'by_title'       => true,
        'by_shortdescr'  => true,
        'by_fulldescr'   => true,
        'by_keywords'    => true,
    );

    $search_data['products']['search_in_subcategories'] = true;

}

include $xcart_dir . '/include/search.php';

if (
    $REQUEST_METHOD == 'GET' 
    && $mode == 'search' 
    && empty($products) 
    && empty($top_message['content'])
) {

    $no_results_warning = array(
        'type'      => 'W', 
        'content'   => func_get_langvar_by_name("lbl_warning_no_search_results", false, false, true),
    );

    $smarty->assign('top_message', $no_results_warning);
}

$location[] = array(func_get_langvar_by_name('lbl_products_management'), 'search.php');

// Assign the current location line
$smarty->assign('location', $location);

// Assign the section navigation data
$smarty->assign('dialog_tools_data', $dialog_tools_data);

if (is_readable($xcart_dir . '/modules/gold_display.php')) {
    include $xcart_dir . '/modules/gold_display.php';
}

func_display('admin/home.tpl', $smarty);

?>
