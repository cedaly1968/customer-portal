<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/printable_link.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'customer/printable_link.tpl', 7, false),)), $this); ?>
<?php func_load_lang($this, "customer/printable_link.tpl","lbl_printable_version"); ?><?php if ($this->_tpl_vars['printable_link_visible']): ?>
  <div class="printable-bar">
    <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['php_url']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
?printable=Y<?php if ($this->_tpl_vars['php_url']['query_string'] != ''): ?>&amp;<?php echo ((is_array($_tmp=$this->_tpl_vars['php_url']['query_string'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['lng']['lbl_printable_version']; ?>
</a>
  </div>
<?php endif; ?>