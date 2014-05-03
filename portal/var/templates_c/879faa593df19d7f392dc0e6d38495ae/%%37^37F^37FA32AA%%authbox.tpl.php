<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/authbox.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'customer/authbox.tpl', 11, false),array('modifier', 'escape', 'customer/authbox.tpl', 11, false),)), $this); ?>
<?php func_load_lang($this, "customer/authbox.tpl","lbl_my_account,lbl_logoff,lbl_register,lbl_register,lbl_forgot_password,lbl_forgot_password,lbl_authentication"); ?><?php ob_start(); ?>

<div class="login-text item">

<?php if ($this->_tpl_vars['login'] != ''): ?>

  <strong><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['fullname'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['login']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['login'])))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</strong>
  <hr class="minicart" />
  <ul>
    <li class="modify-profile-link"><a href="register.php?mode=update"><?php echo $this->_tpl_vars['lng']['lbl_my_account']; ?>
</a></li>
    <li class="logout-link">
      <form action="login.php?mode=logout" method="post" name="loginform">
        <input type="hidden" name="mode" value="logout" />
        <a href="javascript:void(0);" onclick="javascript: setTimeout(function() {document.loginform.submit();}, 100);"><?php echo $this->_tpl_vars['lng']['lbl_logoff']; ?>
</a>
      </form>
    </li>
  </ul>

<?php else: ?>
  
  <ul>
    <li><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/login_link.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></li>
    <li><a href="register.php" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_register'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['lng']['lbl_register']; ?>
</a></li>
    <li><a href="help.php?section=Password_Recovery" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_forgot_password'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['lng']['lbl_forgot_password']; ?>
</a></li>
  </ul>

<?php endif; ?>

</div>

<?php $this->_smarty_vars['capture']['menu'] = ob_get_contents(); ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/menu_dialog.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['lng']['lbl_authentication'],'content' => $this->_smarty_vars['capture']['menu'],'additional_class' => "menu-auth")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>