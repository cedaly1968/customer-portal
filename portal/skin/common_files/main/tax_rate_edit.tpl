{*
b4bb641257c0c0ed40780e94a638e22c36e41088, v2 (xcart_4_6_0), 2013-03-14 10:45:02, tax_rate_edit.tpl, random
vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.Simple_Mode eq "Y"}
{include file="main/tax_formula_js.tpl"}
{/if}

<form action="taxes.php" method="post" name="tax_rate_edit" onsubmit="javascript: if (isFormulaEmpty('rate_formula')) return true; else return checkFormula('rate_formula');">
<input type="hidden" name="mode" value="rate_details" />
<input type="hidden" name="taxid" value="{$taxid}" />
<input type="hidden" name="rateid" value="{$rate_details.rateid|default:0}" />

<table cellpadding="3" cellspacing="1" width="100%">

<tr>
  <td class="FormButton" width="15%">{$lng.lbl_tax_rate_value}:</td>
  <td class="Star">*</td>
  <td width="85%"><input type="text" size="20" maxlength="13" name="rate_value" value="{$rate_details.rate_value|default:$zero|formatprice}" />
  <select name="rate_type" onchange="javascript: $('#box2').toggle();">
    <option value="%"{if $rate_details.rate_type|default:'' eq '%'} selected="selected"{/if}>%</option>
    <option value="$"{if $rate_details.rate_type|default:'' eq '$'} selected="selected"{/if}>{$config.General.currency_symbol}</option>
  </select>
  <br /><div id="box2"{if $rate_details.rate_type|default:'' ne '$'} style="display: none;"{/if}>{$lng.txt_tax_rates_absolute_value}</div>
  </td>
</tr>

<tr>
  <td class="FormButton">{$lng.lbl_zone}:</td>
  <td class="Star">*</td>
  <td>
  <select name="zoneid">
    <option value="0">{$lng.lbl_zone_default}</option>
{section name=zid loop=$zones}
    <option value="{$zones[zid].zoneid}"{if $rate_details.zoneid|default:0 eq $zones[zid].zoneid} selected="selected"{/if}>{$zones[zid].zone_name}</option>
{/section}
  </select>
  </td>
</tr>

<tr>
  <td class="FormButton">{$lng.lbl_membership}:</td>
  <td class="Star">*</td>
  <td>{include file="main/membership_selector.tpl" data=$rate_details}</td>
</tr>

<tr>
  <td class="FormButton">{$lng.lbl_tax_apply_to}:</td>
  <td class="Star">&nbsp;</td>
  <td class="TableSubHead">{include file="main/tax_formula.tpl" name="rate_formula" value=$rate_details.formula|default:''}</td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
  <td class="SubmitBox">
<input type="submit" value=" {if $rate_details.rateid|default:0}{$lng.lbl_save|strip_tags:false|escape}{else}{$lng.lbl_add|strip_tags:false|escape}{/if} " />
{if $rate_details.rateid|default:0}
<input type="button" value="{$lng.lbl_cancel|strip_tags:false|escape}" onclick="javascript: self.location='taxes.php?taxid={$taxid}';" />
{/if}
  </td>
</tr>

</table>
</form>

