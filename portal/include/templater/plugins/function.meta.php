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
 * Templater plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     meta
 * Input:    type
 *           page_type
 *           page_id
 * -------------------------------------------------------------
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    2e4157ecd036b2f5e692a43ac7dd4ef2eb69af53, v32 (xcart_4_6_0), 2013-05-22 14:21:42, function.meta.php, random
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) { header("Location: ../../../"); die("Access denied"); }

function smarty_function_meta($params, &$smarty)
{
    global $active_modules, $sql_tbl, $config;

    if (!isset($params['type']))
        return '';

    if (!isset($params['page_type']))
        $params['page_type'] = '';

    if (!isset($params['page_id']))
        $params['page_id'] = 0;

    $meta = false;
    switch ($params['page_type']) {
        case 'P':
            // Product page
            x_load('product');
            $meta = func_get_product_meta(intval($params['page_id']));
            break;

        case 'C':
            // Category page
            x_load('category');
            $meta = func_get_category_meta(intval($params['page_id']));
            break;

        case 'M':
            // Manufacturer page
            if (empty($active_modules['Manufacturers']))
                break;

            $tmp = func_query_first("SELECT meta_description, meta_keywords FROM $sql_tbl[manufacturers] WHERE manufacturerid = '".intval($params['page_id'])."'");
            if (is_array($tmp) && count($tmp) == 2)
                $meta = array_values($tmp);

            break;

        case 'E':
            // Static page (embedded)
            $tmp = func_query_first("SELECT meta_description, meta_keywords FROM $sql_tbl[pages] WHERE pageid = '".intval($params['page_id'])."'");
            if (is_array($tmp) && count($tmp) == 2)
                $meta = array_values($tmp);

            break;

         case 'R':
            // Reviews page
            if ($params['page_id'] == 0) {
                $meta[0] = func_get_langvar_by_name('lbl_acr_products_reviews_meta_descr');
            } else {
                $meta[0] = func_get_langvar_by_name('lbl_acr_product_reviews_meta_descr') . ' ' 
                    . func_query_first_cell("SELECT product FROM $sql_tbl[products_lng_current] WHERE $sql_tbl[products_lng_current].productid='" . intval($params['page_id']) . "'");
            }
            break;

    }

    if (!is_array($meta)) {
        $meta = array($config['SEO']['meta_descr'], $config['SEO']['meta_keywords']);

    } else {

        if (!isset($meta[0]) || empty($meta[0]))
            $meta[0] = $config['SEO']['meta_descr'];

        if (!isset($meta[1]) || empty($meta[1]))
            $meta[1] = $config['SEO']['meta_keywords'];
    }

    switch ($params['type']) {
        case 'description':
            $return = $meta[0];
            break;

        case 'keywords':
            $return = $meta[1];
            break;

        default:
            return '';
    }

    if (zerolen($return))
        return '';

    // truncate
    $return = func_truncate($return);

    // escape
    $charset = $smarty->get_template_vars('default_charset') ? $smarty->get_template_vars('default_charset') : 'UTF-8';
    $return = @htmlspecialchars($return, ENT_QUOTES, $charset);

    return '<meta name="'.$params['type'].'" content="'.$return.'" />';
}
?>
