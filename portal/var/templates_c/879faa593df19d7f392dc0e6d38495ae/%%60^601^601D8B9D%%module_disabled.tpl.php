<?php /* Smarty version 2.6.26, created on 2014-04-07 13:43:08
         compiled from partner/main/module_disabled.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substitute', 'partner/main/module_disabled.tpl', 7, false),)), $this); ?>
<?php func_load_lang($this, "partner/main/module_disabled.tpl","lbl_partner_area_is_temporary_disabled,txt_partner_area_is_temporary_disabled_note"); ?><h3><font color="red"><?php echo $this->_tpl_vars['lng']['lbl_partner_area_is_temporary_disabled']; ?>
</font></h3>
<p align="justify">
<?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['txt_partner_area_is_temporary_disabled_note'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'email', $this->_tpl_vars['config']['Company']['users_department']) : smarty_modifier_substitute($_tmp, 'email', $this->_tpl_vars['config']['Company']['users_department'])); ?>

</p>