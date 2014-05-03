<?php /* Smarty version 2.6.26, created on 2014-04-08 20:25:15
         compiled from customer/main/authentication.tpl */ ?>
<?php func_load_lang($this, "customer/main/authentication.tpl","lbl_secure_login_form,txt_secure_login_form,lbl_authentication,txt_new_account_msg,lbl_authentication"); ?><?php if ($this->_tpl_vars['is_https_zone']): ?>
  <h1><?php echo $this->_tpl_vars['lng']['lbl_secure_login_form']; ?>
</h1>
  <p class="text-block"><?php echo $this->_tpl_vars['lng']['txt_secure_login_form']; ?>
</p>
<?php else: ?>
  <h1><?php echo $this->_tpl_vars['lng']['lbl_authentication']; ?>
</h1>
<?php endif; ?>

<?php ob_start(); ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/login_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <?php if (! $this->_tpl_vars['is_flc']): ?>
    <br />
    <?php echo $this->_tpl_vars['lng']['txt_new_account_msg']; ?>

  <?php endif; ?>

<?php $this->_smarty_vars['capture']['dialog'] = ob_get_contents(); ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/dialog.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['lng']['lbl_authentication'],'content' => $this->_smarty_vars['capture']['dialog'],'noborder' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>