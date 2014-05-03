<?php /* Smarty version 2.6.26, created on 2014-04-07 11:59:31
         compiled from customer/main/welcome.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substitute', 'customer/main/welcome.tpl', 7, false),array('modifier', 'amp', 'customer/main/welcome.tpl', 11, false),)), $this); ?>
<?php func_load_lang($this, "customer/main/welcome.tpl","lbl_welcome_back,lbl_site_title,lbl_welcome_to,lbl_site_title,lbl_site_title,lbl_welcome_to,txt_welcome"); ?><?php if ($this->_tpl_vars['display_greet_visitor_name']): ?>

  <h1><?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_welcome_back'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'name', $this->_tpl_vars['display_greet_visitor_name']) : smarty_modifier_substitute($_tmp, 'name', $this->_tpl_vars['display_greet_visitor_name'])); ?>
 </h1>

<?php elseif ($this->_tpl_vars['lng']['lbl_site_title']): ?>

  <h1><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['lng']['lbl_welcome_to'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'company', $this->_tpl_vars['lng']['lbl_site_title']) : smarty_modifier_substitute($_tmp, 'company', $this->_tpl_vars['lng']['lbl_site_title'])))) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
</h1>

<?php else: ?>

  <h1><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['lng']['lbl_welcome_to'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'company', $this->_tpl_vars['config']['Company']['company_name']) : smarty_modifier_substitute($_tmp, 'company', $this->_tpl_vars['config']['Company']['company_name'])))) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
</h1>

<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/home_page_banner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo $this->_tpl_vars['lng']['txt_welcome']; ?>
<br />

<?php if ($this->_tpl_vars['active_modules']['Bestsellers'] && $this->_tpl_vars['config']['Bestsellers']['bestsellers_menu'] != 'Y'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Bestsellers/bestsellers.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><br />
<?php endif; ?>

<?php if ($this->_tpl_vars['active_modules']['New_Arrivals']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/New_Arrivals/new_arrivals.tpl", 'smarty_include_vars' => array('is_home_page' => 'Y')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
 
<?php if ($this->_tpl_vars['active_modules']['On_Sale']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/On_Sale/on_sale.tpl", 'smarty_include_vars' => array('is_home_page' => 'Y')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/featured.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>