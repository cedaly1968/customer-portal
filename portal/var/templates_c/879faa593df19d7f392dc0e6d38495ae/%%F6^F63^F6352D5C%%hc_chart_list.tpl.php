<?php /* Smarty version 2.6.26, created on 2014-05-02 09:17:07
         compiled from modules/HighCharts/admin/hc_chart_list.tpl */ ?>
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
    <?php if ($this->_tpl_vars['chart_list'] != ""): ?>
		<tr>
			<td>Chart Name</td>
			<td>Avail</td>
                        <td>&nbsp;</td>
		</tr>
          <?php $_from = $this->_tpl_vars['chart_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cl']):
?>
        <tr>
	<td>
	<a href="highchart.php?mode=create&chart_edit_id=<?php echo $this->_tpl_vars['cl']['id']; ?>
"><?php echo $this->_tpl_vars['cl']['chart_title']; ?>
</a>
       <input type="hidden" name="posted_values[chartlist][<?php echo $this->_tpl_vars['cl']['id']; ?>
][name]" value="<?php echo $this->_tpl_vars['cl']['chart_title']; ?>
"  />
	</td>
	<td><input type="checkbox" name="posted_values[chartlist][<?php echo $this->_tpl_vars['cl']['id']; ?>
][availability]" <?php if ($this->_tpl_vars['cl']['avail'] == 'Y'): ?> checked="checked"<?php endif; ?> value="Y" /> 
	</td>
      <td> <a href ="highchart.php?mode=chart&action=delete&del_id=<?php echo $this->_tpl_vars['cl']['id']; ?>
" style="color:red;"> <B> X </B</a></td>

	</tr>
        <?php endforeach; endif; unset($_from); ?> 
<tr>
<td colspan="3"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/navigation.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  </td>
</tr> 
<tr>
<td colspan="3" style="text-align:left;width:60%;"> <input type="submit" value="Update"/>  </td>
</tr> 
<?php else: ?>
<tr>
<td colspan="3" style="text-align:center;width:60%;"> No records found  </td>
</tr> 
<?php endif; ?>

</table>
</form>
</div>	
</div></div>