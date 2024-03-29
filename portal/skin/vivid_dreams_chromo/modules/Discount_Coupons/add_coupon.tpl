{*
f692fbcbac0fb74b8e6d23053dfca2f9a5120c1b, v4 (xcart_4_6_1), 2013-09-16 12:17:51, add_coupon.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}

{capture name=dialog}
  <p class="text-block">{$lng.txt_add_coupon_header}</p>
  {if $gcheckout_enabled and $main ne 'checkout'}
    <p class="text-block">{$lng.txt_gcheckout_add_coupon_note}</p>
  {/if}

  <a name='check_coupon'></a>
  <form action="cart.php" name="couponform">
    <input type="hidden" name="mode" value="add_coupon" />

    <table cellspacing="0" class="data-table" summary="{$lng.lbl_redeem_discount_coupon|escape}">
      <tr>
        <td class="data-name">{$lng.lbl_coupon_code}</td>
        <td><input type="text" size="32" name="coupon" /></td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td class="button-row">{include file="customer/buttons/submit.tpl" type="input"}</td>
      </tr>
    </table>

  </form>

{/capture}
{include file="customer/dialog.tpl" title=$lng.lbl_redeem_discount_coupon content=$smarty.capture.dialog additional_class='small_title'}
