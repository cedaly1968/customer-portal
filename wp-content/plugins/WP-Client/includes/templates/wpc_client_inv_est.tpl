<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td width="50%" valign="top" style="padding-bottom:6px; font-size: xx-small;">
                <img src="{business_logo_url}" width="290" height="110" />
            </td>
            <td valign="top" align="right" style="line-height:14px; padding-bottom:16px; font-size: xx-small;">
                <b>{business_name}</b>
                <font size="1">
                    {business_address}<br />
                    {business_mailing_address}<br />
                    Website: {business_website}<br />
                    Email: {business_email}<br />
                    Phone: {business_phone}<br />
                    Fax: {business_fax}<br />
                </font>
            </td>
        </tr>
        <tr height="20" valign="top">
            <td colspan="2">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="border-bottom: 3px solid #000; width: 45%;">&nbsp;</td>
                            <td rowspan="2" valign="middle" align="center" style="padding: 0px 15px; width: 10%; font-size: large; font-weight: bold; font-style: italic;">
                                ESTIMATE
                            </td>
                            <td style="border-bottom: 3px solid #000; width: 45%;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr valign="top">
            <td colspan="2" align="right" style="padding-right:26px; font-size: x-small; font-weight: bold;">
                ESTIMATE# {$InvoiceNumber}
            </td>
        </tr>
        <tr>
            <td colspan="2" valign="top" style="padding:16px 0px 26px 0px;">
                <table width="38%" border="1" cellspacing="0" cellpadding="2" frame="border" bordercolor="#000000" style="padding-bottom: 20px;">
                    <tbody>
                        <tr>
                            <td bgcolor="#e8e8e8" style="border-bottom:1px solid #000; font-size: xx-small;">
                                Bill To:
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="padding:6px 3px 10px 3px;line-height:16px; font-size: xx-small;">
                                {client_name}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" style="padding-bottom:20px;">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="text-align:center; font-size: xx-small;" frame="border" bordercolor="#000000">
                    <tbody>
                        <tr bgcolor="#c0c0c0" height="20">
                            <td valign="bottom">
                                DATE
                            </td>
                            <td valign="bottom">
                                DUE DATE
                            </td>
                            <td valign="bottom">
                                P.O.#
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%; padding: 5px 0;">
                                {$InvoiceDate}
                            </td>
                            <td style="width:25%; padding: 5px 0;">
                                {$DueDate}
                            </td>
                            <td style="width:25%; padding: 5px 0;">
                                {$PONumber}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border:1px solid #000; font-size: xx-small;">
                    <thead>
                        <tr bgcolor="#e8e8e8" height="20" style="font-weight: bold;">
                            <td valign="bottom" style="width: 20%;padding:0px 0px 1px 3px;">
                                Item
                            </td>
                            <td valign="bottom" style="width: 35%; padding:0px 0px 1px 3px;">
                                Description
                            </td>
                            <td valign="bottom" style="width: 11%; padding:0px 3px 1px 0px;" align="right">
                                Price
                            </td>
                        </tr>
                    </thead>
                    <tbody id="lineItem">

                    {if isset($items)}
                        {foreach $items as $item}
                            <tr height="20">
                                <td valign="top" style="padding:4px 3px;">
                                    {$item.ItemName}
                                </td>
                                <td valign="top" style="padding:4px 3px;">
                                    {$item.ItemDescription}
                                </td>
                                <td valign="top" style="padding:4px 3px;" align="right">
                                    {$item.ItemRate}
                                </td>
                            </tr>
                        {/foreach}
                    {else}
                        <tr height="20">
                            <td valign="top" style="padding:4px 3px;">
                            </td>
                            <td valign="top" style="padding:4px 3px;">
                            </td>
                            <td valign="top" style="padding:4px 3px;" align="right">
                            </td>
                        </tr>
                    {/if}

                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td height="20">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top:16px; font-size: xx-small;">
                    <tbody>
                        <tr>
                            <td valign="top" width="50%">
                                <font style="background-color: rgb(255, 255, 0);">
                                    {$Notes}
                                </font>
                            </td>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td  width="120">&nbsp;</td>
                                            <td align="right" style="padding:4px;">
                                                Sub Total:
                                            </td>
                                            <td align="right" width="30%" style="padding:4px 0px 4px 4px;">
                                                {$InvoiceSubTotal}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  width="120">&nbsp;</td>
                                            <td align="right" style="padding:4px;">
                                                Discount({$DiscountRate}%):
                                            </td>
                                            <td align="right" width="30%" style="padding:4px 0px 4px 4px;">
                                                {$TotalDiscount}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" style="padding:6px 4px 4px 4px;">
                                                Tax:
                                            </td>
                                            <td align="right" style="padding:6px 0px 4px 4px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" style="padding:6px 4px 4px 4px;">
                                                {$TaxName}({$TaxRate}%)
                                            </td>
                                            <td align="right" style="padding:6px 0px 4px 4px;">
                                                {$TotalTax}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" style="padding:6px 4px 4px 4px;border-top:1px solid black; font-weight: bold;">
                                                Total:
                                            </td>
                                            <td align="right" style="padding:6px 0px 4px 4px;border-top:1px solid black;">
                                                {$InvoiceTotal}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" style="padding:6px 4px 4px 4px;">
                                                Late Fee:
                                            </td>
                                            <td align="right" style="padding:6px 0px 4px 4px;">
                                                {$LateFee}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="right" style="padding:6px 4px 4px 4px;">
                                                Payment Made:
                                            </td>
                                            <td align="right" style="padding:6px 0px 4px 4px;">
                                                {$PaymentMade}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top:20px; font-size: xx-small;">
                <span style="background-color: rgb(255, 255, 255);">
                    {$TermsAndCondition}
                </span>
            </td>
        </tr>
    </tbody>
</table>