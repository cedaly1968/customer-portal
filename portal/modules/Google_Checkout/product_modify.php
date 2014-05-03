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
 * Update product feature: valid or non-valid for Google checkout
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v22 (xcart_4_5_5), 2013-02-04 14:14:03, product_modify.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

x_load('product');

if ($REQUEST_METHOD == 'POST' && !empty($productid)) {

    // Insert/remove selected products to the restrictions table

    if ($valid_for_gcheckout == 'Y') {

        // Product is valid for Google Checkout - need to remove it
        // from the restrictions table

        if ($geid && $fields['valid_for_gcheckout'] == 'Y') {

            // Group modifying

            while ($pid = func_ge_each($geid, 100)) {
                db_query("DELETE FROM $sql_tbl[gcheckout_restrictions] WHERE productid IN ('".implode("','", $pid)."')");
            }
        }
        else {

            // Single product modifying
            db_query("DELETE FROM $sql_tbl[gcheckout_restrictions] WHERE productid='$productid'");
        }

    } else {

        // Product is not valid for Google Checkout - need to add it
        // to the restrictions table

        if ($geid && $fields['valid_for_gcheckout'] == 'Y') {

            // Group modifying
            while ($pid = func_ge_each($geid, 100))
                for ($i = 0; $i < count($pid); $i++)
                    func_array2insert('gcheckout_restrictions', array('productid' => $pid[$i]), true);

        } else {

            // Single product modifying
            func_array2insert('gcheckout_restrictions', array('productid' => $productid), true);

        }

    }

} else {

    // Get the 'valid_for_gcheckout' field value for selected product
    // /this code is used in func_select_product()/

    $_product_in_restrictions = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[gcheckout_restrictions] WHERE productid='$product[productid]'");

    $product['valid_for_gcheckout'] = (empty($_product_in_restrictions) ? 'Y' : 'N');

}
?>
