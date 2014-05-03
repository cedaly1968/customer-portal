<div class="chart_container">
<div class="chart_tit">
	<table cellspacing="0" cellpadding="0" width="100%;">
<tr>
	<td style="color:#ffffff;">
		Chart List 
	</td>
	
	</tr>
</table>
</div>

<div class="chart_1">
	<div class="chart_table_cont">
<form action="highchart.php" method="post"> 
<input type="hidden" name="mode" value="chart" />
<input type="hidden" name="action" value="update" />	
	<table cellspacing="0" cellpadding="0" width="100%" class="chart_table">
    {if $chart_list ne ""}
		<tr>
			<td>Chart Name</td>
			<td>Avail</td>
                        <td>&nbsp;</td>
		</tr>
          {foreach from=$chart_list item=cl}
        <tr>
	<td>
	<a href="highchart.php?mode=create&chart_edit_id={$cl.id}">{$cl.chart_title}</a>
       <input type="hidden" name="posted_values[chartlist][{$cl.id}][name]" value="{$cl.chart_title}"  />
	</td>
	<td><input type="checkbox" name="posted_values[chartlist][{$cl.id}][availability]" {if $cl.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
	</td>
      <td> <a href ="highchart.php?mode=chart&action=delete&del_id={$cl.id}" style="color:red;"> <B> X </B</a></td>

	</tr>
        {/foreach} 
<tr>
<td colspan="3">{include file="main/navigation.tpl"}
  </td>
</tr> 
<tr>
<td colspan="3" style="text-align:left;width:60%;"> <input type="submit" value="Update"/>  </td>
</tr> 
{else}
<tr>
<td colspan="3" style="text-align:center;width:60%;"> No records found  </td>
</tr> 
{/if}

</table>
</form>
</div>	
</div></div>