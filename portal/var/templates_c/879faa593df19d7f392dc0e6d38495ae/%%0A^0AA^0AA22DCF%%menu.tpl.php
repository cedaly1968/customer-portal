<?php /* Smarty version 2.6.26, created on 2014-05-02 09:17:00
         compiled from modules/HighCharts/admin/menu.tpl */ ?>
<?php func_load_lang($this, "modules/HighCharts/admin/menu.tpl","lbl_highcharts,lbl_create_chart,lbl_global_variable_config"); ?><li>
  <a href="highchart.php?mode=create" target="_blank"><?php echo $this->_tpl_vars['lng']['lbl_highcharts']; ?>
</a>
  <div>
    <a href="highchart.php?mode=create" class="external-link-menu"><?php echo $this->_tpl_vars['lng']['lbl_create_chart']; ?>
</a>
    <a href="highchart.php?mode=global" class="external-link-menu"><?php echo $this->_tpl_vars['lng']['lbl_global_variable_config']; ?>
  </a>
	<a href="highchart.php?mode=chart" class="external-link-menu">Chart List</a>
	<a href="highchart.php?mode=ds_table" class="external-link-menu">Data series Table </a>
  </div>
</li>

