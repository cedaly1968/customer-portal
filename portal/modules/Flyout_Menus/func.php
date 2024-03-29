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
 * Functions for Flyout menus module
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    e6417f1e702355c06d20734fed9d95754df7150f, v39 (xcart_4_6_1), 2013-06-26 18:00:03, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../../"); die("Access denied"); }

define('X_FANCYCAT_CACHE_HEADER', "<?php if (!defined('XCART_START')) die(); ?>\n");

/**
 * Check whether caching is enabled for the 
 * generated categories tree 
 * 
 * @param mixed $skin Flyout menus skin name
 *  
 * @return bool
 * @see    ____func_see____
 */
function func_fc_use_cache($skin = false)
{
    global $fcat_module_path, $config, $xcart_dir, $smarty_skin_dir, $cat, $current_area;

    if (!$skin)
        $skin = $config['Flyout_Menus']['fancy_categories_skin'];

    $path = $xcart_dir . $smarty_skin_dir . XC_DS . $fcat_module_path . XC_DS . $skin . XC_DS . 'config.ini';

    if (!file_exists($path))
        return false;

    $ini = func_parse_ini($path, true);

    // WA for bug related to Flyout_Menus-cache and 'root_categories' feature
    $force_disable_cache = (!empty($cat) && $config['Appearance']['root_categories'] != 'Y' && $current_area == 'C');

    return $ini['cache'] && $config["Flyout_Menus"]['fancy_cache'] == 'Y' && !$force_disable_cache;
}

/**
 * Build subcategories data cache as JS-code 
 * 
 * @param int   $tick         Iteration counter (display dot)
 * @param mixed $membershipids Membership ids
 * @param mixed $languages    Languages
 *  
 * @return bool
 * @see    ____func_see____
 */
function func_fc_build_categories($tick = 0, $membershipids = false, $languages = false, $display_header = true)
{
    global $sql_tbl, $shop_language, $xcart_dir, $all_languages, $current_area, $smarty, $var_dirs, $config, $fcat_module_path;
    global $user_account, $HTTPS, $xcart_web_dir, $alt_skin_dir;

    $path = $var_dirs['cache'];

    $tpl = $fcat_module_path . '/' . $config['Flyout_Menus']['fancy_categories_skin'] . '/';

    if (
        $config['Flyout_Menus']['fancy_categories_skin'] == 'Icons'
        && $config['Flyout_Menus']['icons_mode'] == 'C'
    ) {
        $tpl .= 'fancy_subcategories_exp.tpl';

    } else {

        $tpl .= 'fancy_subcategories.tpl';
    }

    $cat = 0;
    x_load('category');


    // Get memberships list
    if (!is_array($membershipids)) {
        $tmp = func_get_memberships('C');
        $membershipids = array(0);
        if (!empty($tmp)) {
            foreach ($tmp as $mid) {
                $membershipids[] = $mid['membershipid'];
            }
        }
        unset($tmp);

    }

    // Get languages list
    if (!is_array($languages)) {

        $languages = array();

        foreach ($all_languages as $l) {
            $languages[] = $l['code'];
        }
    }

    if (count($membershipids) == 0 || count($languages) == 0) {
        return false;
    }

    // Display service header
    if ($display_header) {
        func_display_service_header(
            func_get_langvar_by_name(
                'lbl_rebuilding_subcategory_cache',
                array(
                    'mcount' => count($membershipids),
                    'lcount' => count($languages)
                ),
                false,
                true
            ),
            true
        );
    }

    $shop_language_old = $shop_language;
    $user_account_old  = $user_account;
    $current_area_old  = $current_area;
    $current_area      = 'C';

    // Disable 'fancy_cache' option
    $old_fancy_cache = func_query_first_cell("SELECT value FROM $sql_tbl[config] WHERE name = 'fancy_cache'");

    if ($old_fancy_cache == 'Y') {
        func_array2update('config', array('value' => 'N'), "name = 'fancy_cache'");
    }

    $i = 0;

    $cache_pre_path = $path . '/fc.' . $config['Flyout_Menus']['fancy_categories_skin'] . '.';
    $cache_pre_path .= basename($alt_skin_dir) . '.';
    $cache_pre_path .= preg_replace('/[^a-zA-Z0-9_-]/s', '', basename($xcart_web_dir)) . '.';

    foreach ($languages as $shop_language) {

        foreach ($membershipids as $mid) {

            $user_account['membershipid'] = $mid;

            $categories = func_fc_prepare_categories();
            $base_cache_path = $cache_pre_path . $user_account['membershipid'] . "." . $shop_language . ".";

            $cache_path = $base_cache_path . intval($HTTPS) . ".php";
            if ($HTTPS) {
                // remove cache related to http protocol
                @unlink($base_cache_path . '0.php');
            } else {
                // remove cache related to https protocol
                @unlink($base_cache_path . '1.php');
            }

            $fp = @fopen($cache_path, 'w');
            if (!$fp) {
                break;
            }

            $smarty->assign('categories_menu_list', $categories);
            $smarty->assign('level', 0);

            fwrite($fp, X_FANCYCAT_CACHE_HEADER . func_display($tpl, $smarty, false));
            fclose($fp);
            func_chmod_file($cache_path, 0644);

            $i++;

            if ($tick > 0 && $i % $tick == 0) {
                func_flush('. ');
            }
        }
    }

    // Enable 'fancy_cache' option
    if ($old_fancy_cache == 'Y') {
        func_array2update('config', array('value' => 'Y'), "name = 'fancy_cache'");
    }

    $shop_language = $shop_language_old;
    $user_account  = $user_account_old;
    $current_area  = $current_area_old;

    return true;
}

/**
 * Remove subcategories cache 
 * 
 * @param int   $tick          Iteration counter (display dot)
 * @param mixed $categories    Categories array
 * @param mixed $membershipids Membership id
 * @param mixed $languages     Languages array
 *  
 * @return bool
 * @see    ____func_see____
 */
function func_fc_remove_cache($tick = 0, $membershipids = false, $languages = false)
{
    global $xcart_dir, $var_dirs;

    $path = $var_dirs['cache'];
    $dir = @opendir($path);

    if ($dir) {

        func_display_service_header('lbl_deleting_subcategory_cache');

        $i = 0;

        while ($file = readdir($dir)) {

            if ($file == '.' || $file == '..' || !preg_match("/^fc\.([^\.]+)\.(\d+)\.([\w]{2})\.(\d?)\.php$/S", $file, $match))
                continue;

            if (
                (!empty($membershipids) && !in_array($match[2], $membershipids)) ||
                (!empty($languages) && !in_array($match[3], $languages))
            ) {
                continue;
            }

            @unlink($path . XC_DS . $file);

            $i++;

            if ($tick > 0 && $i % $tick == 0) {
                func_flush('. ');
            }
        }

        closedir($dir);

        return true;
    }

    return false;
}

/**
 * Returns path to categories cache file 
 * 
 * @return string 
 * @see    ____func_see____
 */
function func_fc_get_cache_path()
{
    global $shop_language, $user_account, $var_dirs, $fcat_module_path, $config, $HTTPS, $xcart_web_dir, $config, $alt_skin_dir;

    return 
        $var_dirs['cache'] . 
        '/fc.' . 
        $config['Flyout_Menus']['fancy_categories_skin'] . '.' . 
        basename($alt_skin_dir) . '.' . 
        preg_replace('/[^a-zA-Z0-9_-]/s', '', basename($xcart_web_dir)) . '.' . 
        intval($user_account['membershipid']) . '.' . 
        $shop_language . '.' . 
        intval($HTTPS) . '.php';
}

/**
 * Check if the categories tree is already in cache 
 * 
 * @return bool
 * @see    ____func_see____
 */
function func_fc_has_cache()
{
    return file_exists(func_fc_get_cache_path());
}

/**
 * Prepare categories tree
 * 
 * @param array $all_categories All categories array
 * @param array $categories     Categories array
 * @param array $catexp_path    Explode path
 *  
 * @return array
 * @see    ____func_see____
 */
function func_fc_prepare_categories($categories = array(), $catexp_path = array())
{
    global $config;

    x_load('category');

    if (empty($categories)) {
        $categories = func_get_categories_list(0, false);
    }

    $all_categories = func_get_categories_list(0, false, true, $config['Flyout_Menus']['icons_levels_limit']);

    if (
        is_array($all_categories) 
        && !empty($all_categories)
    ) {

        foreach ($all_categories as $k => $v) {

            if (in_array($k, $catexp_path)) {

                $all_categories[$k]['expanded'] = true;

                if (isset($categories[$k]))
                    $categories[$k]['expanded'] = true;
            }

            if (empty($v['parentid'])) {
                continue;
            }

            if (
                isset($all_categories[$v['parentid']]['childs'])
                && !is_array($all_categories[$v['parentid']]['childs'])
            ) {

                $all_categories[$v['parentid']]['childs'] = array(
                    $k => &$all_categories[$k],
                );

            } else {

                $all_categories[$v['parentid']]['childs'][$k] = &$all_categories[$k];

            }

            if (isset($categories[$v['parentid']])) {

                $categories[$v['parentid']]['childs'] = $all_categories[$v['parentid']]['childs'];

            }

        }

    }

    func_mark_last_categories($categories);

    return $categories;
}

/**
 * Mark last categories
 * 
 * @param mixed $categories Categories
 * @param array $columns    Columns
 *  
 * @return void
 * @see    ____func_see____
 */
function func_mark_last_categories(&$categories, $columns = array())
{
    if (
        empty($categories)
        || !is_array($categories)
    ) {
        return false;
    }

    end($categories);

    $last = key($categories);

    reset($categories);

    $categories[$last]['last'] = true;

    foreach ($categories as $k => $v) {

        if (
            isset($v['childs']) 
            && !empty($v['childs']) 
            && is_array($v['childs'])
        ) {

            $c = $columns;

            $c[] = isset($v['last']) ? !$v['last'] : true;

            func_mark_last_categories($categories[$k]['childs'], $c);
        }

        $categories[$k]['columns'] = $columns;
    }
}

/**
 * Check if category thumbnails should be regenerated
 * 
 * @return bool
 * @see    ____func_see____
 */
function func_fc_need_regenerate_catthumbn($new_alt_skin_key)
{
    global $config, $alt_skin_info, $altSkinsInfo;

    if (!in_array($new_alt_skin_key, array_keys($altSkinsInfo)))
        return false;

    $new_skin = $altSkinsInfo[$new_alt_skin_key];
    $old_skin = $alt_skin_info;

    // Get skins icons dimensions
    x_load('image');
    $new_skin = func_array_merge($new_skin, func_ic_get_size_catthumbn(null, null, $new_skin['alt_schemes_skin_name']));
    $old_skin = func_array_merge($old_skin, func_ic_get_size_catthumbn(null, null, $old_skin['alt_schemes_skin_name']));

    if (
        $new_skin['width'] != $old_skin['width']
        || $new_skin['height'] != $old_skin['height']
    ) {
        return min($new_skin['width'], $new_skin['height']) > 0;
    }

    return false;
}

function func_fc_init() {

    global $config, $smarty, $fancy_prefix, $sql_tbl;

    if (!defined('AREA_TYPE') || constant('AREA_TYPE') != 'C') {
        return true;
    }

    // Define confugaration variables for current skin
    $fc_config = array();
    foreach ($config['Flyout_Menus'] as $k => $v) {
        if (strpos($k, $fancy_prefix) === 0) {
            $fc_config[substr($k, strlen($fancy_prefix))] = $k;
        }
    }

    $tmp = func_query_hash("SELECT name, type FROM $sql_tbl[config] WHERE name IN ('".implode("','", $fc_config)."')", "name", false, true);
    if ($tmp) {
        foreach ($fc_config as $k => $v) {
            if (!isset($tmp[$v])) {
                unset($fc_config[$k]);

            } else {
                $fc_config[$k] = array('name' => $v, 'type' => $tmp[$v]);
            }
        }

    } else {
        unset($fc_config);
    }

    unset($tmp);

    if (!empty($fc_config)) {
        $smarty->assign('fc_config', $fc_config);
    }

}

?>
