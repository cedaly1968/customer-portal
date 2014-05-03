<?php /* Smarty version 2.6.26, created on 2014-05-02 09:17:09
         compiled from modules/HighCharts/admin/hc_create.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'modules/HighCharts/admin/hc_create.tpl', 65, false),array('modifier', 'capitalize', 'modules/HighCharts/admin/hc_create.tpl', 231, false),)), $this); ?>
<div class="chart_container">
<form action="highchart.php" method="post" onsubmit="return form_validation();">
<?php if ($this->_tpl_vars['mode1'] == 'update_chart'): ?>
 <input type="hidden" name="mode1" value="update_chart"/>
 <input type="hidden" name="chart_edit_id" value="<?php echo $this->_tpl_vars['chart_edit_id']; ?>
"/>
<?php endif; ?>
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
			<td colspan="3">      <input type="text" name="posted_values[chart_title]" id='chart_title' size="75"  value="<?php echo $this->_tpl_vars['post1']['chart_title']; ?>
"/>
			</td>
		</tr>
	
		<tr>
			<td>Chart Sub-Title</td>
			<td colspan="3">  <input type="text" name="posted_values[chart_sub_title]" id="chart_sub_title" size="75" value="<?php echo $this->_tpl_vars['post1']['chart_sub_title']; ?>
"//></td>
		</tr>
	
		<tr>
			<td>Data Series:</td>
			<td>
		       <select name="posted_values[Table]" id="table" onchange="load_table(this.value)">
		           <option value=""></option>
		           <?php $_from = $this->_tpl_vars['select_table']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['st']):
?>
		           <?php if ($this->_tpl_vars['st']['Field'] != 'customer_id'): ?>
		           <option value="<?php echo $this->_tpl_vars['st']; ?>
" <?php if ($this->_tpl_vars['post1']['chart_Table'] == $this->_tpl_vars['st']): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['st']; ?>
</option>
		           <?php endif; ?>
		           <?php endforeach; endif; unset($_from); ?>
		         </select>
		    </td>
					</tr>
	

		<tr>
			<td>X-Axis <select name="posted_values[X-Axis][X]" id="xtable">
			 <option value=""></option>
		               </select> </td>
			<td> Label: <input type="text" name="posted_values[X-Axis][Label]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post1']['X']-$this->_tpl_vars['xis_label'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" />    </td>
			<td>Y-Axis  <select name="posted_values[Y-Axis][Y]" id="ytable">
		           <option value=""></option>
		         </select></td>
			<td>  Label: <input type="text" name="posted_values[Y-Axis][Label]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['post1']['Y']-$this->_tpl_vars['xis_label'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
"/>    </td>
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
		           <?php $_from = $this->_tpl_vars['global_v_plottype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['gv_pt']):
?>
		           <option value="<?php echo $this->_tpl_vars['gv_pt']['plot_id']; ?>
,<?php echo $this->_tpl_vars['gv_pt']['attribute']; ?>
" <?php if ($this->_tpl_vars['post1']['plot_type1'] == $this->_tpl_vars['gv_pt']['attribute']): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['gv_pt']['attribute']; ?>
</option>
		           <?php endforeach; endif; unset($_from); ?>
		         </select>
			</td>
		</tr>

	</table>
	</div>
	
	
	
	<div class="chart_tit_sub">Global Variable Assignment</div>
	
		
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
					     
					     	<?php $_from = $this->_tpl_vars['global_variables']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['gv']):
?>
					     	<a style="display:block;" href="javascript:void(0);"  id="sideDiv_<?php echo $this->_tpl_vars['gv']['id']; ?>
" onclick="javascript:show_hide(<?php echo $this->_tpl_vars['gv']['id']; ?>
);"><?php echo $this->_tpl_vars['gv']['attribute']; ?>
</a>
					         <?php endforeach; endif; unset($_from); ?>
					     	</div>
					 <?php $_from = $this->_tpl_vars['global_variables']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['gv']):
?>    
					     	<div style="width:45%;float:left;" class="slidingDiv list_value" id='slidingDiv_<?php echo $this->_tpl_vars['gv']['id']; ?>
'>                        <input type="hidden" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gv']['attribute']; ?>
][bracket]" value="<?php echo $this->_tpl_vars['gv']['brackets']; ?>
" />
								<table width="680" border="0">
								 <tr>
								 <td colspan="2">
								 <ul>
								 <?php $_from = $this->_tpl_vars['gv']['chart_options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['gc']):
?>
								     
								     <?php if ($this->_tpl_vars['gc']['name'] != '' && $this->_tpl_vars['gc']['level'] == 0): ?>  									<li>
									<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">
											<?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

									 </td>
									 <td class="list_right">		 
											<input type="text" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['name']; ?>
]" value=<?php if ($this->_tpl_vars['chart_edit_id']): ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['post1']['chartoptions'][$this->_tpl_vars['gc']['parent_id']][$this->_tpl_vars['gc']['name']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php else: ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php endif; ?>  />
									 </td>
									 </tr>
									 </table>		
									 <?php endif; ?>
									 </li>	
									 <?php if ($this->_tpl_vars['gc']['level'] == 1): ?>
									 <li> 
										 <ul>
 												   <?php if ($this->_tpl_vars['gc']['brackets'] != '' && $this->_tpl_vars['gc']['name'] == ''): ?>
													<li>
										
<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">
													<b><?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['attribute'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</b>
									 </td>					
									 <td class="list_right">								
													<input type="hidden" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['attribute']; ?>
][bracket]" value="<?php echo $this->_tpl_vars['gc']['brackets']; ?>
" />
									 </td>
									 </tr>
									 </table>				
													</li>
												   <?php else: ?>
												   <li>
<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">												   
												   <?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

									 </td>
									 <td class="list_right"> 			   
												   <input type="text" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['name']; ?>
]" value=<?php if ($this->_tpl_vars['chart_edit_id']): ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['post1']['chartoptions'][$this->_tpl_vars['gc']['parent_id']][$this->_tpl_vars['gc']['attribute']][$this->_tpl_vars['gc']['name']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php else: ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php endif; ?>/>
									</td>
									</tr>
									</table>			   
												  </li>
							                       <?php endif; ?> 										 </ul>
									 </li>
									 <?php endif; ?>
									 
									 <?php if ($this->_tpl_vars['gc']['level'] == 2): ?>  
									 <li>
									 <ul>
									 <li>
										 <ul>
										 <?php if ($this->_tpl_vars['gc']['brackets'] != '' && $this->_tpl_vars['gc']['name'] == ''): ?>
							                               <li>
		<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">												   				<b><?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['attribute'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</b>
									 </td>
								<td class="list_right">	  
												 <input type="hidden" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['attribute']; ?>
][bracket]" value="<?php echo $this->_tpl_vars['gc']['brackets']; ?>
" />
								</td>
								</tr>
								</table>				 
												          </li>
							                             <?php else: ?>
															<li>   
		<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
									 <td class="list_left">												   			
			<?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

			</td>
								 <td class="list_right">
												 <input type="text" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute1']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['name']; ?>
]" value=<?php if ($this->_tpl_vars['chart_edit_id']): ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['post1']['chartoptions'][$this->_tpl_vars['gc']['parent_id']][$this->_tpl_vars['gc']['pre_attribute1']][$this->_tpl_vars['gc']['pre_attribute']][$this->_tpl_vars['gc']['attribute']][$this->_tpl_vars['gc']['name']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php else: ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php endif; ?> />
</td>
</tr>
</table>												   			<li>						                             
							                             <?php endif; ?>  
										 </ul>
									 </li>
									 </ul>  
		                  			 </li>			   
									 <?php endif; ?>
									 	<?php if ($this->_tpl_vars['gc']['level'] == 3): ?>  
									 
                                     <li>
									 <ul>
									 <li>
										 <ul>
										 <li> 
										    <ul> 
										      <?php if ($this->_tpl_vars['gc']['brackets'] != '' && $this->_tpl_vars['gc']['name'] == ''): ?>
						                               <li>  
			<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
						<td class="list_left">							                               
						                               <b><?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['attribute'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</b>
						</td>
						<td class="list_right">						                               
											 <input type="hidden" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute1']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['attribute']; ?>
][bracket]" value="<?php echo $this->_tpl_vars['gc']['brackets']; ?>
" />
						</td>
						</tr>
						</table>					 
											          </li>
											        <?php else: ?>
											          <li>  
                    											          
			<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
						<td class="list_left">							                               
											          <?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

                        </td>
                        <td class="list_right">											          
											 <input type="text" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute1']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['name']; ?>
]"  value=<?php if ($this->_tpl_vars['chart_edit_id']): ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['post1']['chartoptions'][$this->_tpl_vars['gc']['parent_id']][$this->_tpl_vars['gc']['pre_attribute1']][$this->_tpl_vars['gc']['pre_attribute']][$this->_tpl_vars['gc']['attribute']][$this->_tpl_vars['gc']['name']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php else: ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php endif; ?> />
                        </td>
                        </tr>
                        </table>											   			
											   			</li>
											      <?php endif; ?>
										    </ul>
										 </li>   
										 </ul>
									 </li>
									 </ul>  
		                  			 </li>	
                                      <?php endif; ?>
                                     
                                     <?php if ($this->_tpl_vars['gc']['level'] == 4): ?>  									 
									 <li>
									 <ul>
									 <li>
										 <ul>
										 <li> 
										    <ul> 
										       <li>
												        <ul> 
												        <?php if ($this->_tpl_vars['gc']['brackets'] != '' && $this->_tpl_vars['gc']['name'] == ''): ?>
						                               <li>  
				<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
						<td class="list_left">							                               
						                               
						                               <b><?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['attribute'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</b>
						</td>
						<td class="list_right">
											<input type="hidden" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute2']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute1']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['attribute']; ?>
][bracket]" value="<?php echo $this->_tpl_vars['gc']['brackets']; ?>
" />
                       </td>
                       </tr>
                       </table>											 
											          </li>
											        <?php else: ?>
											          <li>  
											          
					<table cellpadding="0" cellspacing="0" width="100%" class="list_in_table">
									<tr>
						<td class="list_left">   
						<?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

						</td>
						<td class="list_right"> 
											<input type="text" name="posted_values[chart_options][<?php echo $this->_tpl_vars['gc']['parent_id']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute2']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute1']; ?>
][<?php echo $this->_tpl_vars['gc']['pre_attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['attribute']; ?>
][<?php echo $this->_tpl_vars['gc']['name']; ?>
]" value=<?php if ($this->_tpl_vars['chart_edit_id']): ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['post1']['chartoptions'][$this->_tpl_vars['gc']['parent_id']][$this->_tpl_vars['gc']['pre_attribute2']][$this->_tpl_vars['gc']['pre_attribute1']][$this->_tpl_vars['gc']['pre_attribute']][$this->_tpl_vars['gc']['attribute']][$this->_tpl_vars['gc']['name']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php else: ?> "<?php echo ((is_array($_tmp=$this->_tpl_vars['gc']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" <?php endif; ?> />
						</td>
						</tr>
						</table>					   
											   			</li>
											      <?php endif; ?>
												    </ul>
										       </li>
										    </ul>
										 </li>   
										 </ul>
									 </li>
									 </ul>  
		                  			 </li>	
									 <?php endif; ?>
									 
									 	
								<?php endforeach; endif; unset($_from); ?>  
							      </ul>
	                                 </td>
	                                 </tr>
								</table>					     	
							</div>
					 <?php endforeach; endif; unset($_from); ?>
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
<div style="text-align:center;"  id="loading">loading </div>
								<div class="chart_list plotclass" >
								<?php $_from = $this->_tpl_vars['global_v_plottype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['gv_pt']):
?>
								 <a style="display:block;" id="plotDiv_<?php echo $this->_tpl_vars['gv_pt']['attribute']; ?>
"> <?php echo $this->_tpl_vars['gv_pt']['attribute']; ?>
 </a>
								<?php endforeach; endif; unset($_from); ?>
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

$(document).ready(function(){
$(".slidingDiv").hide();
$("#loading").hide();
load_table("<?php echo $this->_tpl_vars['post1']['chart_Table']; ?>
");
load_options("<?php echo $this->_tpl_vars['post1']['plot_type']; ?>
");
});
<?php echo '
function form_validation() {
    var charttitle = document.getElementById("chart_title").value;
    var chartsubtitle = document.getElementById("chart_sub_title").value;
    var tbl = document.getElementById("table").value;
    var xtbl = document.getElementById("xtable").value;
    var ytbl = document.getElementById("ytable").value;
    var stbl = document.getElementById("stable").value;
    var ptype = document.getElementById("plottype").value;
    
    if (charttitle != "" && chartsubtitle != ""  && tbl != ""  &&  xtbl != "" && ytbl != ""  && stbl != "" && ptype != "") {
    return true;
    } 
    else 
    {
	    if(charttitle == ""){
	    alert("Chart title field is missing");
	    return false;
	    } 
	    if(chartsubtitle == ""){
	    alert("Chart sub title field is missing");
	    return false;
	    }
	    if(tbl == ""){
	    alert("Data series field is missing");
	    return false;
	    } 
	    if(xtbl == ""){
	    alert("XAxis field is missing");
	    return false;
	    }
	    if(ytbl == ""){
	    alert("YAxis field is missing");
	    return false;
	    } 
	    if(stbl == ""){
	    alert("Series field is missing");
	    return false;
	    }	
	    if(ptype == ""){
	    alert("Plot type field is missing");
	    return false;
	    }	        
	}
}
function show_hide(divid)
 { 
 $(".slidingDiv").hide();
 $(".chart_list a").removeClass(\'active_anch\');
 $("#sideDiv_"+divid).toggleClass(\'active_anch\');
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
	arry = plotname.split(\',\');
	var plot_id=arry[0] ;
	var plot_name=arry[1] ;
	$(".plotclass a").removeClass(\'active_anch\');
	$("#plotDiv_"+plot_name).toggleClass(\'active_anch\');
	$("#selected_plot_name span").text(plot_name+" Chart");
    $.ajax({
        url: "highchart.php?mode=plot&plotname="+plot_name+"&plotid="+plot_id,
        complete: function(){$("#loading").hide();},
        success: function(data) {
           document.getElementById("plot_selected_variables").innerHTML=data;
        }
    })
}
'; ?>

-->
</script>