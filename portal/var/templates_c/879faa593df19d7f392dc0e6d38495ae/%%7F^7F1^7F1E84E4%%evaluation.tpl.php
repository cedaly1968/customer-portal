<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:38
         compiled from customer/evaluation.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substitute', 'customer/evaluation.tpl', 8, false),)), $this); ?>
<?php func_load_lang($this, "customer/evaluation.tpl","txt_evaluation_notice_title,txt_evaluation_notice,lbl_purchase_license,txt_evaluation_notice_warning"); ?><?php if ($this->_tpl_vars['shop_evaluation'] == 'EVALUATION' && $this->_tpl_vars['show_evaluation_notice']): ?>
<div class="evaluation-notice">
  <p class="evaluation-notice-title"><?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['txt_evaluation_notice_title'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'XC_Version', $this->_tpl_vars['shop_type']) : smarty_modifier_substitute($_tmp, 'XC_Version', $this->_tpl_vars['shop_type'])); ?>
</p>
  <p><?php echo $this->_tpl_vars['lng']['txt_evaluation_notice']; ?>
</p>
  <div class="evaluation-notice-button">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'customer/buttons/button.tpl', 'smarty_include_vars' => array('button_title' => $this->_tpl_vars['lng']['lbl_purchase_license'],'href' => 'http://www.x-cart.com/buy.html?utm_source=xcart&amp;utm_medium=licence_message_customer_link&amp;utm_campaign=licence_message_customer','target' => '_blank')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="clearing"></div>
  </div>
  <p class="license-warning"><?php echo $this->_tpl_vars['lng']['txt_evaluation_notice_warning']; ?>
</p>
</div>
<?php endif; ?>