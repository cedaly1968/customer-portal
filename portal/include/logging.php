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
 * Logging subsystem
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v57 (xcart_4_5_5), 2013-02-04 14:14:03, logging.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

x_load('logging');

set_error_handler('func_error_handler');

/**
 * Set internal php values
 */
if (
    $debug_mode == 2
    || $debug_mode == 0
) {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
} elseif (defined('DEVELOPMENT_MODE')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

if (
    $debug_mode == 2
    || $debug_mode == 3
) {
    ini_set('log_errors', 1);
    ini_set('error_log', x_log_check_file($var_dirs['log'] . "/x-errors_php-" . func_date('ymd') . ".php"));
    ini_set('ignore_repeated_errors', 1);
}

// Remove empty log for previous day. Purging/checking all empty logs from
// previuos days can reduce performance
$_prev_logfile = $var_dirs['log'] . "/x-errors_php-" . func_date('ymd', XC_TIME - SECONDS_PER_DAY) . ".php";

if (
    file_exists($_prev_logfile)
    && @filesize($_prev_logfile) <= X_LOG_SIGNATURE_LENGTH
) {
    @unlink($_prev_logfile);
}

// Logging PHP IDS statistics
if (
    defined('X_PHPIDS_MSG')
    && constant('X_PHPIDS_MSG')
) {
    x_log_add('SECURITY', "Input data, recognized by PHPIDS as a possible hacking attempt:\n" . X_PHPIDS_MSG);

    if (
        defined('X_USE_ACCESS_DENIED')
        && constant('X_USE_ACCESS_DENIED')
    ) {
        func_header_location('home.php');
    }
}

//Enable assertions
if (defined('DEVELOPMENT_MODE')) {
    assert_options(ASSERT_ACTIVE,   true);
    assert_options(ASSERT_BAIL,     false);
    assert_options(ASSERT_WARNING,  false);
    assert_options(ASSERT_CALLBACK, 'func_assert_failure_handler');
} else {
    assert_options(ASSERT_ACTIVE,   false);
}

?>
