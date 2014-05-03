<?php /* Smarty version 2.6.26, created on 2014-04-07 11:59:31
         compiled from customer/main/home_page_banner.tpl */ ?>
<?php if ($this->_tpl_vars['active_modules']['Banner_System'] && $this->_tpl_vars['top_banners'] != ''): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Banner_System/banner_rotator.tpl", 'smarty_include_vars' => array('banners' => $this->_tpl_vars['top_banners'],'banner_location' => 'T')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php elseif ($this->_tpl_vars['active_modules']['Demo_Mode'] && $this->_tpl_vars['active_modules']['Banner_System']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Demo_Mode/banners.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>