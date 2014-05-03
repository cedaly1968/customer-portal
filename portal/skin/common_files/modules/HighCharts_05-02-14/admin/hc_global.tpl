<div class="chart_container">
 <form id="form1" name="form1" method="post" action="highchart.php">
 	<input type="hidden" name="mode" value="global"/>
    <input type="hidden" name="operation" value="update"/>
	<div class="chart_tit">
	<table cellpadding="0" cellspacing="0" width="100%;">
	<tr>
	<td style="color:#ffffff;">
	High Chart - Global Configuration
	</td>
	<td>  
	<input type="submit" name="button" id="button" value="Save" />
	</td>
	</tr>
	</table>
	</div>
	<div class="chart_1">
	
	
	<div class="chart_tit_sub">Global Variable Assignment</div>
	
	
	<!-- Table1 Container -->
	
	<div class="chart_table_cont chart_table_cont2">
	<table class="chart_table chart_table1" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td class="sub_tit">Chart</td>
			<td class="sub_tit">Chart Options</td>
		</tr>
   
	<tr>
	<td colspan="2">
	
			<table cellpadding="0" cellspacing="0" width="100%">	
				   <tr>
					     <td>
					     <div style="width:100%;">
					     	<div class="chart_list"> 
					     
					     	{foreach from=$global_s_variables item=gs}
					     	<a style="display:block;" href="javascript:void(0);"  id="sideDiv_{$gs.id}" onclick="javascript:show_hide({$gs.id});">{$gs.attribute}</a>
					     	{/foreach}
					     	</div>
					     	{foreach from=$global_s_variables item=gs}
					     	<div style="width:45%;float:left;" class="slidingDiv list_value" id='slidingDiv_{$gs.id}'>                      
								<table width="680" border="0">
								 <tr>
								 <td colspan="2">
								 <ul>
								 {foreach from=$gs.set_options item=gsp}
								     
								    {if $gsp.name ne '' && $gsp.level eq 0}  {** level condition if starts **}
									<li>
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									<td class="list_left">
									{$gsp.name|capitalize}
									 </td>
									 <td class="list_right">
                                     <input type="text" name="posted_values[chart_options][{$gsp.id}][value]" value="{$gsp.value|escape:"html"}" onclick="javascript:show_hide_eg({$gsp.id});" />
									  <div class="sam_info" id="sam_info_{$gsp.id}">
									 <span class="sam_tit">eg:</span>{$gsp.comments|escape:"html"}
									 </div>
									 </td>
									 <td><input type="checkbox" name="posted_values[chart_options][{$gsp.id}][availability]" {if $gsp.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>
									 </tr>
									 </table>		
									 </li>	
									 {/if}
									 {if $gsp.level eq 1}
									 <li> 
									 <ul>
 									 {if $gsp.brackets ne ''&& $gsp.name eq ''}
									 <li>
                                     <table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									 <tr>
									 <td class="list_left" colspan="2">
									 <b>{$gsp.attribute|capitalize}</b>
									 </td>	
									 <td>  <input type="hidden" name="posted_values[chart_options][{$gsp.id}][value]" value="{$gsp.value|escape:"html"}"   />
									 <input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gsp.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>				
									 </tr>
									 </table>				
									</li>
									{else}
									<li>
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									<td class="list_left" colspan="3">												   
									{$gsp.name|capitalize}
									</td>
									<td class="list_right">
									<input type="text" name="posted_values[chart_options][{$gsp.id}][value]" value="{$gsp.value|escape:"html"}" onclick="javascript:show_hide_eg({$gsp.id});" />
									<div class="sam_info" id="sam_info_{$gsp.id}">
									 <span class="sam_tit">eg:</span>{$gsp.comments|escape:"html"}
									 </div>
									</td>
									<td><input type="checkbox" name="posted_values[chart_options][{$gsp.id}][availability]" {if $gsp.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									</td>
									</tr>
									</table>			   
									</li>
							        {/if}
							        </ul>
									</li>
									{/if}
								{/foreach}  
							      </ul>
	                                 </td>
	                                 </tr>
								</table>					     	
							</div>
					 {/foreach}
					     	<div style="clear:both;"></div>
					     </div>
					     </td>
				  </tr>
			  </table>	
		</td>
		</tr>
  
	
	</table>
	</div>
	
	
	
	
	<!-- Table2 Container -->
	
	
	<div class="chart_table_cont chart_table_cont2" style="border-bottom:2px solid #797979;">
	<table class="chart_table chart_table1" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td class="sub_tit">Chart</td>
			<td class="sub_tit">Chart Options</td>
		</tr>
   
	<tr>
	<td colspan="2">
	
			<table cellpadding="0" cellspacing="0" width="100%">	
				   <tr>
					     <td>
					     <div style="width:100%;">
					     	<div class="chart_list"> 
					     
					     	{foreach from=$global_variables item=gv}
					     	<a style="display:block;" href="javascript:void(0);"  id="sideDiv_{$gv.id}" onclick="javascript:show_hide({$gv.id});">{$gv.attribute}</a>
					         {/foreach}
					     	</div>
					 {foreach from=$global_variables item=gv} 
					     	<div style="width:45%;float:left;" class="slidingDiv list_value" id='slidingDiv_{$gv.id}'> 
								<table width="680" border="0">
								 <tr>
								 <td colspan="2">
								 <ul>
								 {foreach from=$gv.chart_options item=gc}
								     {if $gc.level eq 0}  {** level condition if starts **}
								     {if $gc.name ne ''}
									<li>
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									<td class="list_left">
									{$gc.name|capitalize}
									 </td>
									 <td class="list_right">
                                     <input type="text" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}" onclick="javascript:show_hide_eg({$gc.id});" />
									  <div class="sam_info" id="sam_info_{$gc.id}">
									 <span class="sam_tit">eg:</span>{$gc.comments|escape:"html"}
									 </div>
									 </td>
									 <td><input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>
									 </tr>
									 </table>		
									 </li>	
									 {else}
									 									<li>
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									<td class="list_left" colspan="2">
									{$gc.attribute|capitalize}
									 </td>
									 <td><input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>
									 </tr>
									 </table>		
									 </li>	
									 {/if}
									 {/if}
									 {if $gc.level eq 1}
									 <li> 
									 <ul>
 									 {if $gc.brackets ne ''&& $gc.name eq ''}
									 <li>
                                     <table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									 <tr>
									 <td class="list_left" colspan="2">
									 <b>{$gc.attribute|capitalize}</b>
									 </td>	
									 <td>  <input type="hidden" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}"   />
									 <input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>				
									 </tr>
									 </table>				
									</li>
									{else}
									<li>
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									<td class="list_left" colspan="3">												   
									{$gc.name|capitalize}
									</td>
									<td class="list_right">
									<input type="text" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}" onclick="javascript:show_hide_eg({$gc.id});" />
									<div class="sam_info" id="sam_info_{$gc.id}">
									 <span class="sam_tit">eg:</span>{$gc.comments|escape:"html"}
									 </div>
									</td>
									<td><input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									</td>
									</tr>
									</table>			   
									</li>
							        {/if}
							        </ul>
									</li>
									{/if}
									{if $gc.level eq 2}  
									<li>
									<ul>
									<li>
									<ul>
									{if $gc.brackets ne ''&& $gc.name eq ''}
							        <li>
		                            <table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									 <tr>
									 <td class="list_left" colspan="2">
									 <b>{$gc.attribute|capitalize}</b>
									 </td>	
									 <td><input type="hidden" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}" />
									 <input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>				
									 </tr>
									</table>				 
									</li>
							        {else}
									<li>   
		                            <table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									<td class="list_left" colspan="3">												   			
			                        {$gc.name|capitalize}
			                        </td>
									<td class="list_right">
									<input type="hidden" name="posted_values[chart_options][{$gc.id}][name]" value="{$gc.name}" />
									<input type="text" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}" onclick="javascript:show_hide_eg({$gc.id});" />
									  <div class="sam_info" id="sam_info_{$gc.id}">
									 <span class="sam_tit">eg:</span>{$gc.comments|escape:"html"}
									 </div>
									 </td>
									 <td><input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>
</tr>
</table>												   			<li>						                             
							                             {/if}  
										 </ul>
									 </li>
									 </ul>  
		                  			 </li>			   
									 {/if}
									 	{if $gc.level eq 3}  
									 
                                     <li>
									 <ul>
									 <li>
										 <ul>
										 <li> 
										    <ul> 
										      {if $gc.brackets ne ''&& $gc.name eq ''}
						                               <li>  
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									 <tr>
									 <td class="list_left" colspan="2">
									 <b>{$gc.attribute|capitalize}</b>
									 </td>	
									 <td><input type="hidden" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}" />
								        <input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>				
									 </tr>
									</table>					 
											          </li>
											        {else}
											          <li>  
                    											          
			<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
						<td class="list_left" colspan="3">							                               
											          {$gc.name|capitalize}
                        </td>
                      				 <td class="list_right">
									 									<input type="text" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}" onclick="javascript:show_hide_eg({$gc.id});" />
									 									 <div class="sam_info" id="sam_info_{$gc.id}">
									 <span class="sam_tit">eg:</span>{$gc.comments|escape:"html"}
									 </div>
									 </td>
									 <td><input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>
                        </tr>
                        </table>											   			
											   			</li>
											      {/if}
										    </ul>
										 </li>   
										 </ul>
									 </li>
									 </ul>  
		                  			 </li>	
                                      {/if}
                                     
                                     {if $gc.level eq 4}  									 
									 <li>
									 <ul>
									 <li>
										 <ul>
										 <li> 
										    <ul> 
										       <li>
												        <ul> 
												        {if $gc.brackets ne ''&& $gc.name eq ''}
						                               <li>  
										<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
										 <tr>
									 <td class="list_left" colspan="2">
									 <b>{$gc.attribute|capitalize}</b>
									 </td>	
									 <td><input type="hidden" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}" />
									<input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" />  
									 </td>				
									 </tr>
                       				</table>											 
											          </li>
											        {else}
											          <li>  
											          
					<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
						<td class="list_left" colspan="3">   
						{$gc.name|capitalize}
						</td>
								 <td class="list_right">
									 									<input type="text" name="posted_values[chart_options][{$gc.id}][value]" value="{$gc.value|escape:"html"}" onclick="javascript:show_hide_eg({$gc.id});" />
									 <div class="sam_info" id="sam_info_{$gc.id}">
									 <span class="sam_tit">eg:</span>{$gc.comments|escape:"html"}
									 </div>
									 </td>
									 <td><input type="checkbox" name="posted_values[chart_options][{$gc.id}][availability]" {if $gc.avail eq 'Y'} checked="checked"{/if} value="Y" /> 
									 </td>
						</tr>
						</table>					   
											   			</li>
											      {/if}
												    </ul>
										       </li>
										    </ul>
										 </li>   
										 </ul>
									 </li>
									 </ul>  
		                  			 </li>	
									 {/if}
									 
									 	
								{/foreach}  
							      </ul>
	                                 </td>
	                                 </tr>
								</table>					     	
							</div>
					 {/foreach}
					     	<div style="clear:both;"></div>
					     </div>
					     </td>
				  </tr>
			  </table>	
		</td>
		</tr>
	</table>
	</div>
</div>
</form>	
</div>
<script type="text/javascript" language="JavaScript">
<!--
{literal}
$(document).ready(function(){
 $(".slidingDiv").hide();
 $(".sam_info").hide();
});


function show_hide(divid)
 { 
 $(".slidingDiv").hide();
 $(".chart_list a").removeClass('active_anch');
 $("#sideDiv_"+divid).toggleClass('active_anch');
 $("#slidingDiv_"+divid).slideToggle();
 }

function show_hide_eg(divid)
 { 
 $(".sam_info").hide();
 $("#sam_info_"+divid).slideToggle();
 } 
 
function load_options(id,index){
    $("#loading").show();
    $.ajax({
        url: "highchart.php?mode=create&index="+index+"&id="+id,
        complete: function(){$("#loading").hide();},
        success: function(data) {
            $("#"+index).html(data);
        }
    })
}
{/literal}
-->
</script>