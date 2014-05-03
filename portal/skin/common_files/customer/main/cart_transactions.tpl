{*
dd7b9fb550ed20a7893f97e3e18cb5902800ec6e, v4 (xcart_4_4_2), 2010-12-15 11:57:04, cart_transactions.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}
<div class="transactions">
{$lng.lbl_transactions}:
<table width="100%">
{foreach from=$transactions item=t}
  {foreach from=$t item=elem}
<tr>
  <td>
    <a href="cart.php?mode=transaction_remove&amp;paymentid_return={$paymentid}&amp;paymentid={$elem.paymentid}&amp;transactionid={$elem.id}"><img class="delete-icon" src="{$ImagesDir}/spacer.gif" alt="{$lng.lbl_delete|escape}" /></a>
  </td>
  <td class="total">{$elem.payment}:</td>
  <td class="total-value">{currency value=$elem.paid_amount}</td>
  <td class="total-alt-value">{alter_currency value=$elem.paid_amount}</td>
</tr>
  {/foreach}
{/foreach}
</table>
</div>
