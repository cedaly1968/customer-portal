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
 * Compatibility functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v30 (xcart_4_5_5), 2013-02-04 14:14:03, func.compat.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

if (!function_exists('func_chmod')) {
function func_chmod($entity, $entity_type, $mode = NULL)
{
    // Input validation
    if (
        strlen($entity) == 0
        || !in_array($entity_type, array('dir', 'file'))
    ) {
        return NULL;
    }

    $old_umask = umask(0000);

    if (is_null($mode)) {

        if (!function_exists('func_fs_get_entity_permissions'))
            return false;

        $permissions = func_fs_get_entity_permissions($entity, $entity_type);

        $mode = !is_null($permissions) ? $permissions : 0666;

    }

    $result = @chmod($entity, $mode);

    umask($old_umask);

    return $result;
}
}

if (!function_exists('func_chmod_file')) {
function func_chmod_file($filename, $mode = NULL)
{
    if (strlen($filename) == 0 || defined('X_DEF_OS_WINDOWS') && X_DEF_OS_WINDOWS)
        return NULL;

    return func_chmod($filename, 'file', $mode);
}
}

/**
 * Check php memory limit and set it to new value if required
 */
if (!function_exists('func_check_memory_limit')) {
function func_check_memory_limit($current_limit, $required_limit)
{
    $limit = func_convert_to_byte($current_limit);

    $required = func_convert_to_byte($required_limit);

    if ($limit < $required) {
        ini_set('memory_limit', $required_limit);

        $limit = ini_get('memory_limit');

        return (strcasecmp($limit, $required_limit) == 0);
    }

    return true;
}
}

/**
 * Set php memory limit in Mb
 */
if (!function_exists('func_set_memory_limit')) {
function func_set_memory_limit($new_limit)
{
    $current_limit = ini_get('memory_limit');

    return func_check_memory_limit($current_limit, $new_limit);
}
}

/**
 * This function converts a data size to bytes
 */
if (!function_exists('func_convert_to_byte')) {
function func_convert_to_byte($file_size)
{
    $val = trim($file_size);

    $size_type = strtolower(substr($val, -1));

    if ('g' == $size_type) {

        $val *= 1073741824;

    } elseif ('m' == $size_type) {

        $val *= 1048576;

    } elseif ('k' == $size_type) {

        $val *= 1024;

    }

    return $val;
}
}

/**
 * This function converts a data size to megabytes/gigabytes/kilobytes
 */
if (!function_exists('func_convert_to_megabyte')) {
function func_convert_to_megabyte($val)
{
    if (!is_numeric($val))
        $val = func_convert_to_byte($val);

    if ($val >= 1073741824) {

        $val = round($val / 1073741824, 1) . 'G';

    } elseif ($val >= 1048576) {

        $val = round($val / 1048576, 1) . 'M';

    } elseif ($val >= 1024) {

        $val = round($val / 1024, 1) . 'K';

    }

    return $val;
}
}

if (!function_exists('func_date')) {
function func_date($format, $time = false)
{
    if (!is_int($time))
        $time = XC_TIME;

    return @date($format, $time);
}
}

if (!function_exists('func_strftime')) {
function func_strftime($format, $time = false)
{
    if (!is_int($time))
        $time = XC_TIME;

    return @strftime($format, $time);
}
}

if (!function_exists('func_parse_ini')) {
function func_parse_ini($file)
{
    if (defined('X_PHP530_COMPAT')) {
        return parse_ini_file($file, true, INI_SCANNER_RAW);
    }

    return parse_ini_file($file, true);
}
}

if (!function_exists('func_http_build_query')) {
function func_http_build_query($data, $prefix = '', $sep = '', $key = '')
{
    if (empty($sep)) {
        $sep = ini_get('arg_separator.output');
    }

    if (function_exists('http_build_query')) {
        return http_build_query($data, $prefix, $sep);
    }

    $ret = array();

    foreach ((array)$data as $k => $v) {

        if (is_int($k) && $prefix != null) {
            $k = urlencode($prefix . $k);
        }

        if ((!empty($key)) || ($key === 0)) {

            $k = $key . '[' . urlencode($k) . ']';

        }

        if (is_array($v) || is_object($v)) {

            array_push($ret, func_http_build_query($v, '', $sep, $k));

        } else {

            array_push($ret, $k . '=' . urlencode($v));

        }

    }

    return implode($sep, $ret);
}
}


?>
