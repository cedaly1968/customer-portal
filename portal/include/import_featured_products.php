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
 * Featured products import library
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v29 (xcart_4_5_5), 2013-02-04 14:14:03, import_featured_products.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

/******************************************************************************
Used cache format:
Products (by Product ID):
    data_type:     PI
    key:        <Product ID>
    value:        [<Product code> | RESERVED]
Products (by Product code):
    data_type:     PR
    key:        <Product code>
    value:        [<Product ID> | RESERVED]
Products (by Product name):
    data_type:  PN
    key:        <Product name>
    value:        [<Product ID> | RESERVED]
Categories:
    data_type:    C
    key:        <Category full path>
    value:        [<Category ID> | RESERVED]
Categories (by Category ID):
    data_type:    CI
    key:        <Category ID>
    value:        [<Category full path> | RESERVED]

Note: RESERVED is used if ID is unknown
******************************************************************************/

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

if ($import_step == 'define') {

    $import_specification['FEATURED_PRODUCTS'] = array(
        'script'        => '/include/import_featured_products.php',
        'tpl'           => array(
            'main/import_option_category_path_sep.tpl'),
        'permissions'   => 'A',
        'parent'        => 'PRODUCTS',
        'export_sql'    => "SELECT productid FROM $sql_tbl[featured_products] GROUP BY productid",
        'table'         => 'featured_products',
        'key_field'     => 'productid',
        'columns'       => array(
            'productid'     => array(
                'type'      => 'N',
                'default'   => 0),
            'productcode'   => array(),
            'product'       => array(),
            'categoryid'    => array(
                'type'      => 'N',
                'default'   => 0),
            'category'      => array(),
            'order'         => array(
                'type'      => 'N'),
            'avail'         => array(
                'type'      => 'B',
                'default'   => 'Y')
        )
    );

} elseif ($import_step == 'process_row') {
/**
 * PROCESS ROW from import file
 */

    // Check productid / productcode / product
    list($_productid, $_variantid) = func_import_detect_product($values, false);
    if (is_null($_productid) || ($action == 'do' && empty($_productid))) {
        func_import_module_error('msg_err_import_log_message_14');
        return false;
    }
    $values['productid'] = $_productid;

    // Check categoryid / category
    if (!empty($values['categoryid']) || !empty($values['category'])) {
        $_categoryid = func_import_detect_category($values);
        if (is_null($_categoryid) || ($action == 'do' && empty($_categoryid))) {
            func_import_module_error('msg_err_import_log_message_18');
            return false;
        }
        $values['categoryid'] = $_categoryid;
    }

    $data_row[] = $values;

} elseif ($import_step == 'finalize') {
/**
 * FINALIZE rows processing: update database
 */

    // Drop old data
    if (!empty($import_file['drop'][strtolower($section)])) {

        db_query("DELETE FROM $sql_tbl[featured_products]");
        $import_file['drop'][strtolower($section)] = '';
    }

    foreach ($data_row as $row) {

    // Import data...

        // Import featured products

        $data = array(
            'productid'     => $row['productid'],
            'categoryid'    => intval($row['categoryid']),
            'product_order' => $row['order'],
            'avail'         => $row['avail']
        );

        // Update featured product
        if (func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[featured_products] WHERE productid = '$data[productid]' AND categoryid = '$data[categoryid]'")) {
            func_array2update('featured_products', $data, "productid = '$data[productid]' AND categoryid = '$data[categoryid]'");
            $result[strtolower($section)]['updated']++;

        // Add featured product
        } else {
            func_array2insert('featured_products', $data, true);
            $result[strtolower($section)]['added']++;
        }

        echo ". ";
        func_flush();

    }

// Export data
} elseif ($import_step == 'export') {

    while ($id = func_export_get_row($data)) {
        if (empty($id))
            continue;

        $rows = func_query("SELECT * FROM $sql_tbl[featured_products] WHERE productid = '$id'");
        if (empty($rows))
            continue;

        foreach ($rows as $row) {
            $p_row = func_export_get_product($row['productid']);
            if (empty($p_row))
                continue;

            $row = func_array_merge($row, $p_row);

            $c_row = func_export_get_category($row['categoryid']);
            if (!empty($c_row))
                $row = func_array_merge($row, $c_row);

            $row = func_export_rename_cell($row, array('product_order' => 'order'));

            if (!func_export_write_row($row))
                break;
        }
    }

}

?>
