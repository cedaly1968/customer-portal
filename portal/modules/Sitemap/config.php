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
 * Module configuration
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Sitemap
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    6c80cceda830944e13066f1fcb8a9f4b1d2b8b1f, v18 (xcart_4_6_0), 2013-05-15 15:59:21, config.php, random
 * @since      4.4.0
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header('Location: ../../'); die('Access denied');}

// Db table added by the module
$sql_tbl['sitemap_extra'] = XC_TBL_PREFIX . 'sitemap_extra';

// Instead of %s the language code will be used
$config['Sitemap']['cache_filename'] = 'sitemap.%s.html';
// Number of items generated by one pass (categories use separate number)
$config['sitemap']['cache_limit_general'] = 1000;
// Number of root categories generated by one pass
$config['sitemap']['cache_limit_categories'] = 1;

// Avail items
$config['Sitemap']['items'] = array('categories', 'products', 'manufacturers', 'pages', 'extra');

if (defined('SITEMAP_PAGE')) {
    // Additional css files
    $css_files['Sitemap'][] = array();
    // Page template filename
    $template_main['sitemap_customer'] = 'modules/Sitemap/customer.tpl';
}

if (isset($_POST['process_sitemap']) && $_POST['process_sitemap'] == 'Y' && (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mode']) && $_POST['mode'] == 'catalog_gen') || ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_POST['mode']) && $_POST['mode'] == 'continue'))) {
    $additional_hc_data[] = array(
        'generation_script' => $xcart_dir . '/modules/Sitemap/html_catalog.php',
        'page_url'          => 'sitemap.php',
        'name_func'         => 'sitemap',
        'name_func_params'  => array('Sitemap.html'),
        'src_func'          => 'sitemap_process_page'
    );
}

$_module_dir  = $xcart_dir . XC_DS . 'modules' . XC_DS . 'Sitemap';
/*
 Load module functions
*/
if (!empty($include_func)) {
    require_once $_module_dir . XC_DS . 'func.php';
    if (!empty($include_init)) {
        func_sitemap_init();
    }
}

?>
