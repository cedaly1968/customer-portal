<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from copyright.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'copyright.tpl', 5, false),array('modifier', 'escape', 'copyright.tpl', 5, false),)), $this); ?>
<?php func_load_lang($this, "copyright.tpl","lbl_copyright"); ?><?php echo $this->_tpl_vars['lng']['lbl_copyright']; ?>
 &copy; <?php echo $this->_tpl_vars['config']['Company']['start_year']; ?>
<?php if ($this->_tpl_vars['config']['Company']['start_year'] < $this->_tpl_vars['config']['Company']['end_year']): ?>-<?php echo ((is_array($_tmp=XC_TIME)) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
<?php endif; ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['config']['Company']['company_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>


<?php if ($this->_tpl_vars['active_modules']['Socialize']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Socialize/footer_links.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>