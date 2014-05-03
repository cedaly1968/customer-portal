<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/main/product_details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'customer/main/product_details.tpl', 13, false),)), $this); ?>

<div class="clearing"></div>
 
<?php if ($this->_tpl_vars['active_modules']['HighCharts'] != "" && $this->_tpl_vars['login'] != ""): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/HighCharts/customer/hc_chart.tpl", 'smarty_include_vars' => array('cht' => $this->_tpl_vars['chc'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
  
     <div class="descr"> <?php echo ((is_array($_tmp=@$this->_tpl_vars['product']['fulldescr'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['product']['descr']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['product']['descr'])); ?>
 </div>