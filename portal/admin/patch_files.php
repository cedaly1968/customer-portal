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
 * Apply diff patches interface
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Admin interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v38 (xcart_4_5_5), 2013-02-04 14:14:03, patch_files.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

require $xcart_dir.'/include/safe_mode.php';
func_check_perms_redirect(XCActions::PATCH_FILES);

$try_all = isset($_POST['try_all']);
$excluded_files = '';
$patched_files = '';
$failed_files = '';
$need_manual_patch = false;

foreach ($patch_files as $index => $patch_file) {

    echo $patch_file['orig_file']." ... "; flush();

    if ($patch_file['status'] != 1) {

        if (@$patch_file['testapply_failed'] != 1 || !$try_all) {

            $patch_file['need_manual_patch'] = true;
            $excluded_files[] = $patch_file;
            if (@$patch_file['testapply_failed'])
                $failed_files[] = $patch_file;

            list($patch_file['status_lbl'], $patch_file['status_txt']) = func_patch_status($patch_file['status'], $patch_file['extra']);

            func_flush(
                '<font color="blue">'
                . func_get_langvar_by_name(
                    'lbl_excluded_n',
                    array(
                        'status' => $patch_file['status_lbl']
                    ),
                    false,
                    true
                )
                . '</font><br />'
            );
            $need_manual_patch = true;
            continue;
        }
    }

    $patch_result_ = array();
    $rejects_ = false;
    $tmpfile = $patch_tmp_folder . '/' . strtr($patch_file['orig_file'], '/\\', '^^');

    $applied_successfuly = false;

    if ($patch_file['is_copy']) {
        // copy new files over

        if (
            file_exists($patch_file['real_file'])
            && !rename($patch_file['real_file'], $tmpfile)
            || !copy($patch_file['real_diff'], $patch_file['real_file'])
        ) {
            $patch_file['status'] = 10;
            $patch_errorcode = 0;
            $patch_file['need_manual_patch'] = true;
            $patch_result[] = '<font color="red">' .
                func_get_langvar_by_name(
                    'txt_patch_failed_at_file_x',
                    array(
                        'file' => $patch_file['orig_file']
                    ),
                    false,
                    true
                    )
                    . '</font>';

            $failed_files[] = $patch_file;
            $need_manual_patch = true;
        }
        else {
            $applied_successfuly = true;
        }

    }
    else {
        // apply diffs

        $patch_errorcode_ = !func_patch_apply(
            $patch_file['real_file'], $patch_file['real_diff'],
            $tmpfile.'.rej', $tmpfile,
            $patch_result_, $rejects_, false, $patch_reverse);

        if ($patch_errorcode_) {
            $__patch_result = array();
            $__rejects = false;
            $__patch_errorcode = !func_patch_apply(
                $patch_file['real_file'], $patch_file['real_diff'],
                $tmpfile.'.rej', $tmpfile,
                $__patch_result, $__rejects, true, !$patch_reverse);

            if ($__patch_errorcode==0) {
                @unlink($tmpfile);
                @unlink($tmpfile.'.rej');
                $patch_file['status'] = 9;
                $patch_files[$index]['status'] = 9;

                list($patch_file['status_lbl'], $patch_file['status_txt']) = func_patch_status($patch_file['status'], $patch_file['extra']);
                
                $excluded_files[] = $patch_file;

                func_flush(
                    '<font color="blue">'
                    . func_get_langvar_by_name(
                        'lbl_exclude_n',
                        array(
                            'status' => $patch_file['status_lbl']
                        ),
                        false,
                        true
                    )
                    . '</font><br />'
                );
                continue;
            }

            $patch_errorcode = 0;
            $patch_file['status'] = 10;
            $patch_file['need_manual_patch'] = true;
            $patch_result[] = '<font color="red">' .
                func_get_langvar_by_name(
                    'txt_patch_failed_at_file_x',
                    array(
                        'file' => $patch_file['orig_file']
                    ),
                    false,
                    true
                    )
                    . '</font>';

            $failed_files[] = $patch_file;
            $need_manual_patch = true;
        } else {
            $applied_successfuly = true;
        }
    }

    if ($applied_successfuly) {
        $patch_file['status'] = 1;
        $patch_result[] = func_get_langvar_by_name(
            'txt_file_x_successfully_patched',
            array(
                'file' => $patch_file['orig_file']
            ),
            false,
            true
        );
    }

    list($patch_file['status_lbl'], $patch_file['status_txt']) = func_patch_status($patch_file['status'], $patch_file['extra']);

    echo '<font color="' . ( $patch_file['status'] == 1 ? 'green' : ( $patch_file['status'] == 9 ? 'blue' : 'red' )) . '">'
        . $patch_file['status_lbl']
        . '</font><br />';
    
    flush();

    $patched_files[] = $patch_file;

    $patch_log = func_array_merge($patch_log, $patch_result_);
}

$phase_result['need_manual_patch'] = $need_manual_patch;
$phase_result['failed_files'] = $failed_files;

?>
