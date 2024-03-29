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
 * Recommends list
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Customer interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    e35c0c1635194b95aefbeb75012da4a044d72c54, v55 (xcart_4_6_0), 2013-05-17 11:27:46, recommends.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: home.php"); die("Access denied"); }

$config['Recommended_Products']['number_of_recommends'] = max(intval($config['Recommended_Products']['number_of_recommends']), 0);

/**
 * Defining the conditions for selecting products for the list
 */

$avail_group_by = $avail_where = $avail_join = '';

if (
    $config['General']['unlimited_products'] != 'Y'
    && $config['General']['show_outofstock_products'] != 'Y'
) {

    if (!empty($active_modules['Product_Options'])) {

        $avail_join     = XCVariantsSQL::getJoinQueryAllRows();
        $avail_where     = XCVariantsSQL::getVariantField('avail') . " > 0 AND";
        if ($config['Recommended_Products']['select_recommends_list_randomly'] == 'Y')
            $avail_group_by = "GROUP BY $sql_tbl[product_rnd_keys].productid";
        else     
            $avail_group_by = "GROUP BY $sql_tbl[products].productid";

    } else {

        $avail_where = " $sql_tbl[products].avail>'0' AND";

    }

}

$_membershipid = intval($user_account['membershipid']);
$_number_of_recommends = $config["Recommended_Products"]["number_of_recommends"];

$query_ids = array();
if (!empty($avail_group_by))
    $nr = $_number_of_recommends * XCSearchProducts::POSSIBLE_PRODUCT_DUPLICATES;
else 
    $nr = $_number_of_recommends * 2 + 1;

if ($config['Recommended_Products']['select_recommends_list_randomly'] == 'Y') {
    func_refresh_product_rnd_keys(null, intval($config['Recommended_Products']['rnd_keys_refresh_period']) * 3600);

    $max_rnd_number = func_query_first_cell("SELECT COUNT(*) FROM $sql_tbl[products]");
    $rnd = rand(1, $max_rnd_number);
    $_sort_order = $rnd % 2 ? 'DESC' : 'ASC';
    $query_ids                                                                   =  func_query_column($sql = "
      SELECT $sql_tbl[products].productid
        FROM ($sql_tbl[products], $sql_tbl[products_categories], $sql_tbl[product_rnd_keys])
        LEFT JOIN $sql_tbl[category_memberships]
          ON $sql_tbl[category_memberships].categoryid   =  $sql_tbl[products_categories].categoryid
        LEFT JOIN $sql_tbl[product_memberships]
          ON $sql_tbl[product_memberships].productid     =  $sql_tbl[products_categories].productid
          $avail_join
       WHERE $avail_where $sql_tbl[products].forsale     =  'Y'
         AND $sql_tbl[products].productid                =  $sql_tbl[products_categories].productid
         AND $sql_tbl[products_categories].main          =  'Y'
         AND $sql_tbl[products_categories].avail                  =  'Y'
         AND ($sql_tbl[category_memberships].membershipid IS NULL
          OR $sql_tbl[category_memberships].membershipid =  '$_membershipid')
         AND ($sql_tbl[product_memberships].membershipid IS NULL
          OR $sql_tbl[product_memberships].membershipid  =  '$_membershipid')
         AND $sql_tbl[products].productid                =  $sql_tbl[product_rnd_keys].productid  
         AND $sql_tbl[product_rnd_keys].rnd_key          >= $rnd
       ORDER BY $sql_tbl[product_rnd_keys].rnd_key $_sort_order LIMIT $nr");

       if (!empty($avail_group_by))
           $query_ids = array_slice(array_unique($query_ids), 0, $_number_of_recommends*2+1);


} else {

    $query_ids = func_query_column($sql
    = "
        SELECT sp2.productid
         FROM (
                SELECT DISTINCT userid
                  FROM $sql_tbl[stats_customers_products]
                WHERE productid                              =  '$productid'
              ) AS sp1
         INNER JOIN $sql_tbl[stats_customers_products] AS sp2
            ON sp1.userid                                     =  sp2.userid
           AND sp2.productid                                 != '$productid'
         INNER JOIN $sql_tbl[products_categories]
            ON sp2.productid                                 =  $sql_tbl[products_categories].productid
           AND $sql_tbl[products_categories].main            =  'Y'
           AND $sql_tbl[products_categories].avail                    =  'Y'
         INNER JOIN $sql_tbl[products]
            ON $sql_tbl[products].productid                  =  sp2.productid
           AND $sql_tbl[products].forsale                    =  'Y'
          LEFT JOIN $sql_tbl[category_memberships]
            ON $sql_tbl[category_memberships].categoryid     =  $sql_tbl[products_categories].categoryid
          LEFT JOIN $sql_tbl[product_memberships]
            ON $sql_tbl[product_memberships].productid       =  $sql_tbl[products_categories].productid 
         $avail_join
         WHERE $avail_where 1
           AND ( $sql_tbl[category_memberships].membershipid =  '$_membershipid'
            OR $sql_tbl[category_memberships].membershipid IS NULL)
           AND ( $sql_tbl[product_memberships].membershipid IS NULL
            OR $sql_tbl[product_memberships].membershipid    =  '$_membershipid') 
         LIMIT $nr");         

       if (!empty($avail_group_by))
           $query_ids = array_slice(array_unique($query_ids), 0, $_number_of_recommends*2+1);
}

if (is_array($query_ids)) {
    $_own_ind = array_search($productid, $query_ids);
    if ($_own_ind !== false)
        unset($query_ids[$_own_ind]);
}    

$_query = array();
$_query['skip_tables'] = XCSearchProducts::getSkipTablesByTemplate('modules/Recommended_Products/recommends.tpl');
$_query['query'] = " AND $sql_tbl[products].productid IN ('" . implode("','", $query_ids) . "')";
$recommends = func_search_products(
    $_query,
    (isset($user_account) && isset($user_account['membershipid']))
        ? max(intval($user_account['membershipid']), 0)
        : 0,
    false,
    $config['Recommended_Products']['number_of_recommends']
);

if (!empty($recommends)) {
    // Used also in "include/product_tabs.php:92:if (!empty($active_modules['Recommended_Products']) && !empty($recommends))"
    $smarty->assign_by_ref('recommends', $recommends);
}

?>
