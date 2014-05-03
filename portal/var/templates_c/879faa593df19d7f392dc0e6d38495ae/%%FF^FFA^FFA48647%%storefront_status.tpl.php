<?php /* Smarty version 2.6.26, created on 2014-05-02 09:16:46
         compiled from storefront_status.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substitute', 'storefront_status.tpl', 10, false),array('modifier', 'amp', 'storefront_status.tpl', 10, false),array('modifier', 'wm_remove', 'storefront_status.tpl', 12, false),array('modifier', 'escape', 'storefront_status.tpl', 12, false),)), $this); ?>
<?php func_load_lang($this, "storefront_status.tpl","lbl_close_storefront,lbl_open,lbl_open_storefront,lbl_open_storefront_warning,lbl_close"); ?><?php if ($this->_tpl_vars['login']): ?>
  <?php if (! $this->_tpl_vars['no_container']): ?>
    <div class="storefront-status">
  <?php endif; ?>
  <?php if ($this->_tpl_vars['config']['General']['shop_closed'] == 'Y'): ?>
    <div class="closed-store"><?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_close_storefront'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'STOREFRONT', $this->_tpl_vars['http_location'], 'SHOPKEY', $this->_tpl_vars['config']['General']['shop_closed_key']) : smarty_modifier_substitute($_tmp, 'STOREFRONT', $this->_tpl_vars['http_location'], 'SHOPKEY', $this->_tpl_vars['config']['General']['shop_closed_key'])); ?>
<?php if ($this->_tpl_vars['need_storefront_link']): ?> [ <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['storefront_link'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
"><?php echo $this->_tpl_vars['lng']['lbl_open']; ?>
</a> ]<?php endif; ?></div>
  <?php else: ?>
    <div class="open-store"><?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_open_storefront'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'STOREFRONT', $this->_tpl_vars['http_location']) : smarty_modifier_substitute($_tmp, 'STOREFRONT', $this->_tpl_vars['http_location'])); ?>
<?php if ($this->_tpl_vars['need_storefront_link']): ?> [ <a href="javascript:void(0);" onclick="javascript:if(confirm('<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['lng']['lbl_open_storefront_warning'])) ? $this->_run_mod_handler('wm_remove', true, $_tmp) : smarty_modifier_wm_remove($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
'))window.location='<?php echo ((is_array($_tmp=$this->_tpl_vars['storefront_link'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
';"><?php echo $this->_tpl_vars['lng']['lbl_close']; ?>
</a> ]<?php endif; ?></div>
  <?php endif; ?>
  <?php if (! $this->_tpl_vars['no_container']): ?>
    </div>
  <?php endif; ?>
<?php endif; ?>