{* 
/*************************************************\
| Shipping Per Product 1.0.0                      |
|                                                 |
|                                                 |
| BCS Engineering                                 |
| Copyright (c) 2006-2009 BCS Engineering,        |
| Carrie L. Saunders <support@bcsengineering.com> |
| All rights reserved.                            |
| See http://www.bcsengineering.com/license.shtml |
| for full license                                |
| For X-cart versions 4.4.X                       |
\*************************************************/
*}


{$lng.txt_shipping_per_product_top_text}

<BR><BR>
<h1>{$added}</h1>
<BR><BR>
{capture name=dialog}

<form action=shipping_per_product.php method=POST>
<table width=100% border=0 cellspacing=0 cellpadding=2>
	<tr>
		<td width=100%><hr></td>
	</tr>
	<tr>
		<td><h1>{$lng.lbl_add_shipping}</h1></td>
	</tr>
	<tr>
		<td>{$lng.lbl_category}: <select name=categoryid>
			{foreach from=$allcategories item=c key=catid}
			<option value="{$catid}"{if $a_catid eq $catid}selected{/if}>{$c|escape}</option>
			{/foreach}
			</select>
		</td>
	</tr>
	<tr>
		<td><input type=submit name=show_products value="Show Products">
		</td>
	</tr>
	<tr>
		<td>{$lng.lbl_products}:<BR>
			<select name=products[] multiple size=10>
			{section name=prod_num loop=$productids}
			<option value={$productids[prod_num].productid}>{$productids[prod_num].product}
			{/section}
			</select>
			<BR>Note: Hold down the CTR key to select multiple products
		</td>
	</tr>
	{if $avail_shipping and $show_shipping eq "Y"}
	<input type=hidden name="apply_to_catid" value="{$a_catid}">
	<tr>
		<td>{$lng.lbl_shipping}:<BR>
			<select name=shipping[] multiple size=10>
			{section name=shipping_num loop=$avail_shipping}
			<option value={$avail_shipping[shipping_num].shippingid}>{$avail_shipping[shipping_num].shipping|trademark}
			{/section}
			</select>
			<BR>Note: Hold down the CTR key to select multiple shipping
		</td>
	</tr>
	<tr>
		<td><input type=submit name=submit value="Submit"><br><input type=checkbox name="apply_to_cat" value="Y">&nbsp;Add Shipping Methods to all products in this category and its subcategories</td>
	</tr>
	{/if}
</table>
</form>
<BR><BR>
<form action=shipping_per_product.php method=POST name="allshippingform">
<input type=hidden name="mode" value="all_shipping">
<table width=100% border=0 cellspacing=0 cellpadding=2>
	<tr>
		<td width=100%><hr></td>
	</tr>
	<tr>
		<td><h1>{$lng.lbl_add_shipping_for_all_products}</h1></td>
	</tr>
	<tr>
		<td>{$lng.lbl_shipping}:<BR>
			<select name=all_shipping[] multiple size=10>
			{section name=shipping_num loop=$avail_shipping}
			<option value={$avail_shipping[shipping_num].shippingid}>{$avail_shipping[shipping_num].shipping|trademark}
			{/section}
			</select>
			<BR>Note: Hold down the CTR key to select multiple shipping
		</td>
	</tr>
	<tr>
		<td><input type=submit name=submit value="Submit" onclick="javascript: if(confirm('{$lng.txt_all_shipping_confirm}')) document.allshippingform.submit(); else return false;"><br><input type=checkbox name="delete_previous" value="Y">{$lng.txt_delete_previous_methods}</td>
	</tr>
	<tr>
		<td><hr></td>
	</tr>
</table>
</form>
<br>
<form action="shipping_per_product.php" method=post>
<input type=hidden name="update_config" value="update_config">
	<center><input type=checkbox name="enable_shipping" {if $product_shipping_enabled eq 'Y'}checked{/if} >Enable shipping per product<BR>
		<input type=submit name=submit value="Update Config">
	</center>
</form>
{/capture}
{include file="dialog.tpl" title=$lng.lbl_shipping_per_product content=$smarty.capture.dialog extra="width=100%"}

