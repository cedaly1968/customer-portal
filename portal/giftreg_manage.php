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
 * Manage giftregistry events/properties/wishlist
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v39 (xcart_4_5_5), 2013-02-04 14:14:03, giftreg_manage.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

define('USE_TRUSTED_POST_VARIABLES',1);
$trusted_post_variables = array('event_details', 'posted_mail_message');

// Save HTML card content
// (bypass to the "remove phishing" functionality in 'prepare.php')

if(isset($_POST['event_details']['html_content'])) {
    define('HTML_CARD_CONTENT', $_POST['event_details']['html_content']);
    unset($_POST['event_details']['html_content']);
}

require './auth.php';

if (empty($active_modules['Gift_Registry'])) {
    func_page_not_found();
}

if (!empty($eventid) && $eventid != 'new') {
    // Check for valid event id
    $valid_event = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[giftreg_events] WHERE event_id = '".intval($eventid)."' AND userid='$logged_userid'");
    if (!$valid_event) {
        func_403();
    }
} elseif (empty($eventid) && !empty($mode) && $REQUEST_METHOD == 'GET')
    func_header_location("giftreg_manage.php?eventid=new");

/**
 * Restore HTML card content and purify it
 */
if(defined('HTML_CARD_CONTENT') && $config["Gift_Registry"]["enable_html_cards"]=="Y") {
    $event_details['html_content'] = trim(HTML_CARD_CONTENT);

    if(!empty($event_details['html_content'])) {
        $event_details['html_content'] = func_xss_free($event_details['html_content']);
        if ($event_details['html_content'] != trim(HTML_CARD_CONTENT))
            $event_details['html_content'] = addslashes($event_details['html_content']);
    }
}

$_remember_varnames = array('mode', 'ids', 'eventid', 'post_data', 'StartMonth', 'StartDay', 'StartYear', 'EndMonth', 'EndDay', 'EndYear', 'event_details', 'event_details_Month', 'event_details_Day', 'event_details_Year', 'new_recipient_name', 'new_recipient_email', 'action', 'recipient_details', 'gb_details', 'wlitem', 'move_quantity');

require $xcart_dir.'/include/remember_user.php';

include $xcart_dir . '/include/common.php';

include $xcart_dir.'/include/security.php';

$location[] = array(func_get_langvar_by_name('lbl_gift_registry'), 'giftreg_manage.php');

if ($REQUEST_METHOD == 'POST' && $mode == 'move_product')
    include $xcart_dir.'/modules/Gift_Registry/giftreg_wishlist.php';
else {
    if (!empty($eventid) && ($mode == 'gb' || $mode == 'guestbook')) {
        $modify_mode = true;
        include $xcart_dir.'/modules/Gift_Registry/event_guestbook.php';
    }
    include $xcart_dir.'/modules/Gift_Registry/event_modify.php';
}

// Assign the current location line
$smarty->assign('location', $location);

func_display('customer/home.tpl',$smarty);
?>
