{*
850e5138e855497e58a9e99e00c2e8e04e3f7234, v1 (xcart_4_4_0_beta_2), 2010-05-21 08:31:50, ask_question.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}
{include file="mail/html/mail_header.tpl"}

<br /><br />{$lng.eml_someone_ask_question|substitute:"STOREFRONT":$current_location:"productid":$productid:"product_name":$product}:

<br /><b>{$lng.lbl_customer_info}:</b>

<hr size="1" noshade="noshade" />

<table cellpadding="2" cellspacing="0">

<tr>
<td><b>{$lng.lbl_username}:</b></td>
<td>&nbsp;</td>
<td>{$uname|escape}</td>
</tr>

<tr>
<td><b>{$lng.lbl_email}:</b></td>
<td>&nbsp;</td>
<td>{$email|escape}</td>
</tr>

{if $phone}
<tr>
<td><b>{$lng.lbl_phone}:</b></td>
<td>&nbsp;</td>
<td>{$phone|escape}</td>
</tr>
{/if}

<tr>
<td colspan="3"><b>{$lng.lbl_message}:</b><br /><hr size="1" noshade="noshade" color="#DDDDDD" align="left" /></td>
</tr>
<tr>
<td colspan="3">{$question|escape}</td>
</tr>
</table>

{include file="mail/html/signature.tpl"}
