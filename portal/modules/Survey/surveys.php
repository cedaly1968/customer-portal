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
 * Survey related operations processor
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v19 (xcart_4_5_5), 2013-02-04 14:14:03, surveys.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

x_load('backoffice');

$location[] = array(func_get_langvar_by_name('lbl_survey_surveys'), '');

if ($REQUEST_METHOD == 'POST' && $mode == 'update') {

    // Update surveys list

    if (empty($data)) {

        // POST data is empty
        $top_message = array(
            'type' => 'E',
            'content' => func_get_langvar_by_name('txt_survey_list_is_empty')
        );
        func_header_location('surveys.php');
    }

    foreach ($data as $sid => $row) {
        func_array2update('surveys', $row, "surveyid = '$sid'");
    }

    $top_message = array(
        'content' => func_get_langvar_by_name('txt_survey_list_successfull_updated')
    );

    func_header_location('surveys.php');

} elseif ($REQUEST_METHOD == 'POST' && $mode == 'delete') {

    // Delete survey or surveys list

    if (isset($check) && !empty($check)) {
        func_delete_survey($check);
        $top_message = array(
            'content' => func_get_langvar_by_name(count($check) > 1 ? 'txt_survey_surveys_are_deleted' : 'txt_survey_is_deleted')
        );

    } elseif (!empty($surveyid)) {
        func_delete_survey($surveyid);
        $top_message = array(
            'content' => func_get_langvar_by_name('txt_survey_is_deleted')
        );

    }

    func_header_location('surveys.php');

} elseif ($REQUEST_METHOD == 'POST' && $mode == 'send') {

    // Send invitations

    if (isset($check) && !empty($check)) {
        if (func_send_survey_invitations_list($check)) {
            $top_message = array(
                'content' => func_get_langvar_by_name('lbl_survey_invitations_are_sent')
            );
        } else {
            $top_message = array(
                'content' => func_get_langvar_by_name('lbl_survey_invitations_are_not_sent'),
                'type' => 'W'
            );
        }
    }

    func_header_location('surveys.php');

} elseif ($REQUEST_METHOD == 'POST' && $mode == 'clone') {

    // Clone survey(s)

    if (isset($check) && !empty($check)) {
        if (func_clone_survey($check) > 0) {
            $top_message = array(
                'content' => func_get_langvar_by_name('txt_surveys_are_cloned')
            );
        }
    }

    func_header_location('surveys.php');

} elseif ($REQUEST_METHOD == 'GET' && $mode == 'finish') {

    $top_message = array(
        'content' => func_get_langvar_by_name('lbl_survey_successfull_updated')
    );
    func_header_location('surveys.php');
}

// Get surveys list
$surveys = func_query_hash("SELECT $sql_tbl[surveys].*, COUNT($sql_tbl[survey_maillist].email) as count_maillist, SUM(IF($sql_tbl[survey_maillist].sent_date > '0', '1', '0')) as count_sent FROM $sql_tbl[surveys] LEFT JOIN $sql_tbl[survey_maillist] ON $sql_tbl[surveys].surveyid = $sql_tbl[survey_maillist].surveyid GROUP BY $sql_tbl[surveys].surveyid ORDER BY $sql_tbl[surveys].orderby", "surveyid", false);

if (!empty($surveys)) {
    $surveys_completed = func_query_hash("SELECT surveyid, COUNT(sresultid) as count_completed, MAX(date) as max_completed, MAX(CONCAT(date,'_',sresultid)) as code FROM $sql_tbl[survey_results] GROUP BY surveyid", "surveyid", false);
    foreach ($surveys as $sid => $s) {
        $surveys[$sid]['survey'] = func_get_languages_alt("survey_name_".$sid, false, true);
        if (isset($surveys_completed[$sid])) {
            $surveys[$sid]['max_completed'] = $surveys_completed[$sid]['max_completed'];
            $surveys[$sid]['count_completed'] = $surveys_completed[$sid]['count_completed'];
            $surveys[$sid]['last_sresultid'] = intval(preg_replace("/^\d+_/S", "", $surveys_completed[$sid]['code']));
        }
    }
    unset($surveys_completed);

    $smarty->assign('surveys', $surveys);
}

$dialog_tools_data['left'][] = array(
    'link' => 'surveys.php',
    'title' => func_get_langvar_by_name('lbl_survey_surveys')
);
$dialog_tools_data['left'][] = array(
    'link' => "survey.php?mode=create",
    'title' => func_get_langvar_by_name('lbl_survey_add_survey')
);
$dialog_tools_data['right'][] = array(
    'link' => "configuration.php?option=Survey",
    'title' => func_get_langvar_by_name('lbl_survey_general_settings')
);

$smarty->assign('dialog_tools_data', $dialog_tools_data);

$smarty->assign('survey_types', func_get_survey_types());
?>
