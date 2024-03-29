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
 * "X-Cart TEST" payment module (credit card processor)
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Payment interface
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-2013 Qualiteam software Ltd <info@x-cart.com>
 * @license    http://www.x-cart.com/license.php X-Cart license agreement
 * @version    536d95e589c24076e32b35967cd3b39d91407507, v45 (xcart_4_5_5), 2013-02-04 14:14:03, cc_test.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['process']) && isset($_POST['status'])) {
    require './auth.php';

    if (!func_is_active_payment('cc_test.php'))
        exit;

    $module_params = func_get_pm_params('cc_test.php');
    $sessid = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref='".$oid."'");

    srand();
    $txnid = md5(XC_TIME . rand(0, time()));

    $bill_output['code'] = intval($_POST['status']);
    $bill_output['billmes'] = ($reason ? $reason : "Reason did not set") . ' (TransactionID: ' . $txnid.')';
    $bill_output['sessid'] = $sessid;

    if ($bill_output['code'] == 0) {
        $bill_output['code'] = 2;
        $bill_output['billmes'] = 'Internal error. ' . $bill_output["billmes"];
    }

    if ($bill_output['code'] == 1) {
        if ($module_params['use_preauth'] == 'Y')
            $bill_output['is_preauth'] = true;

        $extra_order_data = array(
            'txnid' => $txnid,
            'capture_status' => $module_params['use_preauth'] == 'Y' ? 'A' : ''
        );

    }

    require('payment_ccend.php');

} else {

    if (!defined('XCART_START')) { header("Location: ../"); die("Access denied"); }

    $_orderids = $module_params['param02'].join("-", $secure_oid);
    if (!$duplicate)
        db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref,sessid) VALUES ('".addslashes($_orderids)."','".$XCARTSESSID."')");

?>
<form method="post" action="cc_test.php" name="process">
  <input type="hidden" name="process" value="xcarttest" />
  <input type="hidden" name="oid" value="<?php echo htmlspecialchars($_orderids); ?>" />

  Please select desire result...<br />
  <br />
  <table cellspacing="0" cellpadding="3">
    <tr>
      <td>MerchantID:</td>
      <td><?php echo htmlspecialchars($module_params['param01']); ?></td>
    </tr>
    <tr>
      <td>OrderID:</td>
      <td><?php echo htmlspecialchars($_orderids); ?></td>
    </tr>
    <tr>
      <td>Amount:</td>
      <td><?php echo htmlspecialchars($cart['total_cost']); ?></td>
    </tr>
    <tr>
      <td>Status:</td>
      <td>
        <select name="status">
          <option value="0">Error</option>
          <option value="1" selected="selected">Approved</option>
          <option value="2">Declined</option>
          <option value="3">Queued</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Reason:</td>
      <td><textarea name="reason" cols="40" rows="4"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" /></td>
    </tr>
  </table>

</form>
<?php
}
exit;
?>
