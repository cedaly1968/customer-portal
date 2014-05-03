<div class="chart_container">
 <form id="form1" name="form1" method="post" action="highchart.php" onsubmit="form_validation()">
   <input type="hidden" name="mode" value="update"/>
	<div class="chart_tit">
	<table cellpadding="0" cellspacing="0" width="100%;">
	<tr>
	<td style="color:#ffffff;">
	High Chart - Create New Chart
	</td>
	<td>  
	<input type="submit" name="button" id="button" value="Save chart" />
	</td>
	</tr>
	</table>
	</div>
	<div class="chart_1">
	<div class="chart_table_cont chart_table_cont1">
	<table class="chart_table" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td>Chart Title</td>
			<td colspan="3">      <input type="text" name="posted_values[chart_title]" id='chart_title' size="75"  value="{$post1.chart_title}"/>
			</td>
		</tr>
	
		<tr>
			<td>Chart Sub-Title</td>
			<td colspan="3">  <input type="text" name="posted_values[chart_sub_title]" id="chart_sub_title" size="75" value="{$post1.chart_sub_title}"//></td>
		</tr>
	
		<tr>
			<td>Data Series:</td>
			<td>
		       <select name="posted_values[Table]" id="table" onchange="load_table(this.value)">
		           <option value=""></option>
		           {foreach from=$select_table item=st}
		           {if $st.Field ne 'customer_id'}
		           <option value="{$st}">{$st}</option>
		           {/if}
		           {/foreach}
		         </select>
		    </td>
			{*<td>Customer Id:</td>
			<td>
		       <select name="posted_values[customer_id]">
		           <option value=""></option>
		           {foreach from=$customer_id item=cid}
		           <option value="{$cid.id}">{$cid.id}</option>
		           {/foreach}
		         </select>
			</td>*}
		</tr>
	

		<tr>
			<td>X-Axis <select name="posted_values[X-Axis][X]" id="xtable">
			 <option value=""></option>
		               </select> </td>
			<td> Label: <input type="text" name="posted_values[X-Axis][Label]" />    </td>
			<td>Y-Axis  <select name="posted_values[Y-Axis][Y]" id="ytable">
		           <option value=""></option>
		         </select></td>
			<td>  Label: <input type="text" name="posted_values[Y-Axis][Label]"/>    </td>
		</tr>

		<tr>
			<td>Series</td>
			<td>
		       <select name="posted_values[Series][]" multiple id="stable">
		           <option value=""></option>
		       		         </select>
		    </td>
			<td>Plot Type</td>
			<td>
		         <select name="posted_values[PlotType]" id="plottype" onchange="load_options(this.value)">
		            <option value=""></option>
		           {foreach from=$global_v_plottype item=gv_pt}
		           <option value="{$gv_pt.plot_id},{$gv_pt.attribute}">{$gv_pt.attribute}</option>
		           {/foreach}
		         </select>
			</td>
		</tr>

	</table>
	</div>
	
	
	
	<div class="chart_tit_sub">Global Variable Assignment</div>
	
	{* <!-- Table1 Container -->
	
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
					     	<div style="width:45%;float:left;" class="slidingDiv list_value" id='slidingDiv_{$gs.id}'>                      <input type="hidden" name="posted_values[set_options][{$gs.attribute}][bracket]" value="{$gs.brackets}" />
								<table width="680" border="0">
								 <tr>
								 <td colspan="2">
								 <ul>
								 {foreach from=$gs.set_options item=gsp}
								     
								    {if $gsp.name ne '' && $gsp.level eq 0} 
									<li>
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									<td class="list_left">
									{$gsp.name|capitalize}
									 </td>
									 <td class="list_right">
                                     <input type="text" name="posted_values[set_options][{$gsp.parent_id}][{$gsp.name}]" value="{$gsp.value|escape:"html"}" />
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
									 <td>  <input type="hidden" name="posted_values[set_options][{$gsp.parent_id}][{$gsp.attribute}]" value="{$gsp.value|escape:"html"}"   />
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
									<input type="text" name="posted_values[set_options][{$gsp.parent_id}][{$gsp.attribute}]" value="{$gsp.value|escape:"html"}" onclick="javascript:show_hide_eg({$gsp.id});" />
									</td>
									<td>
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
	</div>  *}
	
		<!-- Table2 Container -->
	
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
					     
					     	{foreach from=$global_variables item=gv}
					     	<a style="display:block;" href="javascript:void(0);"  id="sideDiv_{$gv.id}" onclick="javascript:show_hide({$gv.id});">{$gv.attribute}</a>
					         {/foreach}
					     	</div>
					 {foreach from=$global_variables item=gv}    
					     	<div style="width:45%;float:left;" class="slidingDiv list_value" id='slidingDiv_{$gv.id}'>                        <input type="hidden" name="posted_values[chart_options][{$gv.attribute}][bracket]" value="{$gv.brackets}" />
								<table width="680" border="0">
								 <tr>
								 <td colspan="2">
								 <ul>
								 {foreach from=$gv.chart_options item=gc}
								     
								     {if $gc.name ne '' && $gc.level eq 0}  {** level condition if starts **}
									<li>
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">
											{$gc.name|capitalize}
									 </td>
									 <td class="list_right">		 
											<input type="text" name="posted_values[chart_options][{$gc.parent_id}][{$gc.name}]" value={if $chart_edit_id} "{$post1.chartoptions[$gc.parent_id][$gc.name]|escape:"html"}" {else} "{$gc.value|escape:"html"}" {/if}  />
									 </td>
									 </tr>
									 </table>		
									 {/if}
									 </li>	
									 {if $gc.level eq 1}
									 <li> 
										 <ul>
 												   {if $gc.brackets ne ''&& $gc.name eq ''}
													<li>
										
<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">
													<b>{$gc.attribute|capitalize}</b>
									 </td>					
									 <td class="list_right">								
													<input type="hidden" name="posted_values[chart_options][{$gc.parent_id}][{$gc.attribute}][bracket]" value="{$gc.brackets}" />
									 </td>
									 </tr>
									 </table>				
													</li>
												   {else}
												   <li>
<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">												   
												   {$gc.name|capitalize}
									 </td>
									 <td class="list_right"> 			   
												   <input type="text" name="posted_values[chart_options][{$gc.parent_id}][{$gc.attribute}][{$gc.name}]" value={if $chart_edit_id} "{$post1.chartoptions[$gc.parent_id][$gc.attribute][$gc.name]|escape:"html"}" {else} "{$gc.value|escape:"html"}" {/if}/>
									</td>
									</tr>
									</table>			   
												  </li>
							                       {/if} 										 </ul>
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
									 <td class="list_left">												   				<b>{$gc.attribute|capitalize}</b>
									 </td>
								<td class="list_right">	  
												 <input type="hidden" name="posted_values[chart_options][{$gc.parent_id}][{$gc.pre_attribute}][{$gc.attribute}][bracket]" value="{$gc.brackets}" />
								</td>
								</tr>
								</table>				 
												          </li>
							                             {else}
															<li>   
		<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">												   			
			{$gc.name|capitalize}
			</td>
								 <td class="list_right">
												 <input type="text" name="posted_values[chart_options][{$gc.parent_id}][{$gc.pre_attribute1}][{$gc.pre_attribute}][{$gc.attribute}][{$gc.name}]" value={if $chart_edit_id} "{$post1.chartoptions[$gc.parent_id][$gc.pre_attribute1][$gc.pre_attribute][$gc.attribute][$gc.name]|escape:"html"}" {else} "{$gc.value|escape:"html"}" {/if} />
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
						<td class="list_left">							                               
						                               <b>{$gc.attribute|capitalize}</b>
						</td>
						<td class="list_right">						                               
											 <input type="hidden" name="posted_values[chart_options][{$gc.parent_id}][{$gc.pre_attribute1}][{$gc.pre_attribute}][{$gc.attribute}][bracket]" value="{$gc.brackets}" />
						</td>
						</tr>
						</table>					 
											          </li>
											        {else}
											          <li>  
                    											          
			<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
						<td class="list_left">							                               
											          {$gc.name|capitalize}
                        </td>
                        <td class="list_right">											          
											 <input type="text" name="posted_values[chart_options][{$gc.parent_id}][{$gc.pre_attribute1}][{$gc.pre_attribute}][{$gc.attribute}][{$gc.name}]"  value={if $chart_edit_id} "{$post1.chartoptions[$gc.parent_id][$gc.pre_attribute1][$gc.pre_attribute][$gc.attribute][$gc.name]|escape:"html"}" {else} "{$gc.value|escape:"html"}" {/if} />
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
						<td class="list_left">							                               
						                               
						                               <b>{$gc.attribute|capitalize}</b>
						</td>
						<td class="list_right">
											<input type="hidden" name="posted_values[chart_options][{$gc.parent_id}][{$gc.pre_attribute2}][{$gc.pre_attribute1}][{$gc.pre_attribute}][{$gc.attribute}][bracket]" value="{$gc.brackets}" />
                       </td>
                       </tr>
                       </table>											 
											          </li>
											        {else}
											          <li>  
											          
					<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
						<td class="list_left">   
						{$gc.name|capitalize}
						</td>
						<td class="list_right"> 
											<input type="text" name="posted_values[chart_options][{$gc.parent_id}][{$gc.pre_attribute2}][{$gc.pre_attribute1}][{$gc.pre_attribute}][{$gc.attribute}][{$gc.name}]" value={if $chart_edit_id} "{$post1.chartoptions[$gc.parent_id][$gc.pre_attribute2][$gc.pre_attribute1][$gc.pre_attribute][$gc.attribute][$gc.name]|escape:"html"}" {else} "{$gc.value|escape:"html"}" {/if} />
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
	
	<!-- Table3Container -->
	<div class="chart_tit_sub" >Plot Variable Assignment </div>
	<div class="chart_table_cont chart_table_cont2" style="border-bottom:2px solid #797979;">
	<table class="chart_table chart_table1" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td colspan="2">
	
			<table cellpadding="0" cellspacing="0" width="100%">	
				   <tr>
					     <td>
					     <div style="width:100%;">
<div id="selected_plot_name" style="margin: 10px 0;font: bold 14px arial;color: green;text-transform: capitalize;"> <span></span> 
</div>
<div style="text-align:center;"  id="loading"><img src="/skin/common_files/css/images/loading.gif" /> </div>
								<div class="chart_list plotclass" >
								{foreach from=$global_v_plottype item=gv_pt}
								 <a style="display:block;" id="plotDiv_{$gv_pt.attribute}"> {$gv_pt.attribute} </a>
								{/foreach}
								</div>
								
								
								<div style="width:45%;float:left;" class="list_value" id="plot_selected_variables">  </div>
								
         				</div>
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
 $("#loading").hide();
});
/*function form_validation()
{
var error=0;
if(document.getElementById("chart_title").value=='')
{
error=1;
alert('Invalid Chart Title');
return false;
}
else if(document.getElementById("chart_sub_title").value=='')
{
alert('Invalid Chart Sub Title');
error=1;
return false;
}
else if(document.getElementById("table").value=='')
{
alert('Invalid data series');
error=1;
return false;
}
else if(document.getElementById("xtable").value=='')
{
alert('Invalid XAxis');
error=1;
return false;
}
else if(document.getElementById("ytable").value=='')
{
alert('Invalid YAxis');
error=1;
return false;
}
else if(document.getElementById("stable").value=='')
{
alert('Invalid Series');
error=1;
return false;
}
else if(document.getElementById("plottype").value=='')
{
alert('Invalid Plot type');
error=1;
return false;
}
}*/
function show_hide(divid)
 { 
 $(".slidingDiv").hide();
 $(".chart_list a").removeClass('active_anch');
 $("#sideDiv_"+divid).toggleClass('active_anch');
 $("#slidingDiv_"+divid).slideToggle();
 }
function load_table(tablename){
    $("#loading").show();
    $.ajax({
        url: "highchart.php?mode=table&tablename="+tablename,
        complete: function(){$("#loading").hide();},
        success: function(data) {
           document.getElementById("xtable").innerHTML=data;
		   document.getElementById("ytable").innerHTML=data;
		   document.getElementById("stable").innerHTML=data;
        }
    })
} 
function load_options(plotname){
    $("#loading").show();
	arry = plotname.split(',');
	var plot_id=arry[0] ;
	var plot_name=arry[1] ;
	$(".plotclass a").removeClass('active_anch');
	$("#plotDiv_"+plot_name).toggleClass('active_anch');
	$("#selected_plot_name span").text(plot_name+" Chart");
    $.ajax({
        url: "highchart.php?mode=plot&plotname="+plot_name+"&plotid="+plot_id,
        complete: function(){$("#loading").hide();},
        success: function(data) {
           document.getElementById("plot_selected_variables").innerHTML=data;
        }
    })
}
{/literal}
-->
</script>
