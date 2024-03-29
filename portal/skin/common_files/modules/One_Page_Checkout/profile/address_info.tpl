{*
0cbfececc6d85ed304deef99a02e5b743bf42c0d, v4 (xcart_4_4_5), 2012-01-30 11:01:26, address_info.tpl, aim 
vim: set ts=2 sw=2 sts=2 et:
*}
{if $need_address_info}

  {if not $hide_header}
    <h3>{if $type eq 'S'}{$lng.lbl_shipping_address}{else}{$lng.lbl_billing_address}{/if}</h3>
  {/if}

  {assign var=id_prefix value="`$type`_"}
  {assign var=name_prefix value="address_book[`$type`]"}

  {if $type ne 'S'}
    {assign var=zip_section value="billing"}
  {else}
    {assign var=zip_section value="shipping"}
  {/if}

  {if $type eq 'S' and $config.Shipping.need_shipping_section eq 'Y' and $config.Shipping.enable_shipping eq 'Y' and $is_areas.B}

    <div class="optional-label">
      <label class="pointer" for="ship2diff">
        <input type="checkbox" id="ship2diff" name="ship2diff" value="Y" onclick="javascript: $('#ship_box').toggle();"{if $ship2diff} checked="checked"{/if} />
        {$lng.lbl_ship_to_different_address}
      </label>
    </div>

  {/if}

  {include file="modules/One_Page_Checkout/profile/address_fields.tpl" default_fields=$address_fields address=$userinfo.address.$type id_prefix=$id_prefix|lower name_prefix=$name_prefix zip_section=$zip_section}

{/if}
