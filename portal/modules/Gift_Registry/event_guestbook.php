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
 * Event guestbook details
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    939e52e42aa767ab074283b88517c141e2db220b, v35 (xcart_4_6_0), 2013-05-30 14:32:00, event_guestbook.php, random
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../../"); die("Access denied"); }

if (isset($eventid)) {
    $eventid = intval($eventid);
}

if ($REQUEST_METHOD == 'POST') {
/**
 * Process the POST request
 */

    if ($mode == 'guestbook') {

    // Update guest book

        if (!empty($eventid)) {
            $events_creator = func_query_first_cell("SELECT userid FROM $sql_tbl[giftreg_events] WHERE event_id='$eventid' AND (guestbook='Y' OR userid='$logged_userid')");
        }

        if (empty($events_creator))
            func_header_location('giftregs.php');

        if (!is_array($gb_details) || empty($gb_details) || empty($gb_details['name']) || empty($gb_details['subject']) || empty($gb_details['message'])) {
            $top_message = array(
                'type' => 'E',
                'content' => func_get_langvar_by_name('msg_adm_err_giftregistry')
            );

        } else {
            $moderator = (!empty($modify_mode) ? 'Y' : 'N');
            $gb_details['message'] = str_replace("\n", "<br />", $gb_details['message']);
            db_query("INSERT INTO $sql_tbl[giftreg_guestbooks] (event_id, name, subject, message, post_date, moderator) VALUES ('$eventid', '$gb_details[name]', '$gb_details[subject]', '$gb_details[message]', '".XC_TIME."', '$moderator')");
        }
    }

    if (!empty($modify_mode))
        func_header_location("giftreg_manage.php?eventid=$eventid&mode=gb#gb");
    else
        func_header_location("giftregs.php?eventid=$eventid&mode=gb#gb");
}

if ($mode == 'gb') {

    if (!empty($modify_mode) && $action == 'delete' && !empty($mesid)) {
        db_query("DELETE FROM $sql_tbl[giftreg_guestbooks] WHERE message_id='$mesid' AND event_id='$eventid'");
        func_header_location("giftreg_manage.php?eventid=$eventid&mode=gb");
    }

    $search_condition = "event_id='$eventid'";

    $total_items = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[giftreg_guestbooks] WHERE $search_condition");

    $objects_per_page = 3; //$config['Appearance']['products_per_page'];

    require $xcart_dir.'/include/navigation.php';

    $guestbook = func_query("SELECT * FROM $sql_tbl[giftreg_guestbooks] WHERE $search_condition ORDER BY post_date DESC LIMIT $first_page, $objects_per_page");

    if (!empty($modify_mode))
        $smarty->assign('navigation_script',"giftreg_manage.php?eventid=$eventid&mode=gb");
    else
        $smarty->assign('navigation_script',"giftregs.php?eventid=$eventid&mode=gb");

    $smarty->assign('guestbook', $guestbook);

}

?>
