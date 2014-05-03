<div class="chart_container">
<div class="chart_tit">
	<table cellspacing="0" cellpadding="0" width="100%;">
<tr>
	<td style="color:#ffffff;">
		Data Series Table List 
	</td>
	
	</tr>
</table>
</div>

<div class="chart_1">

<div class="chart_table_cont">

{****add****}
         <form action="highchart.php?mode=ds_table" method="post" id="tableform"> 
         <input type="hidden" name="mode" value="ds_table" />
         <input type="hidden" name="action" value="add" />
	<table cellspacing="0" cellpadding="0" width="100%" class="chart_table">
        <tr>
       	  <td style="width:40%">Data series table name: <input type="text" name="table_name" value="" id="tablename" /> 
        <input type="hidden" name="avail" value="Y" />  </td> 
         <td style="text-align:left;width:60%;"> <input type="submit" value="Add"/>  </td>
  	</tr>
       </table>
      </form>
{****add****}
{****update****}
<form action="highchart.php" method="post"> 
<input type="hidden" name="mode" value="ds_table" />
<input type="hidden" name="action" value="update" />	
<table cellspacing="0" cellpadding="0" width="100%" class="chart_table">
    {if $table_list ne ""}
		<tr>
			<td>Table Name</td>
			<td>Avail</td>
                        <td>&nbsp;</td>
		</tr>
          {foreach from=$table_list item=tb}
        <tr>
	<td>
       <input type="text" name="posted_values[table_options][{$tb.id}][tablename]" value="{$tb.table_name}"  />
	</td>
	<td><input type="checkbox" name="posted_values[table_options][{$tb.id}][availability]" {if $tb.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
	</td>
      <td> <a href ="highchart.php?mode=ds_table&action=delete&del_id={$tb.id}" style="color:red;"> <B> X </B</a></td>

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
{****update****}
</div></div></div>

<script type="text/javascript" language="JavaScript">
<!--
{literal}
$("#tableform").submit(function() {
  var textVal = $("#tablename").val();
  if(textVal == "") {
    alert('Enter table name');
    return false;
  }
});
{/literal}
-->
</script>
