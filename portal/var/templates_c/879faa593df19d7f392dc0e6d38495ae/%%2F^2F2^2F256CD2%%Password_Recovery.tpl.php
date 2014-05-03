<?php /* Smarty version 2.6.26, created on 2014-04-18 09:32:39
         compiled from customer/help/Password_Recovery.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'customer/help/Password_Recovery.tpl', 25, false),array('modifier', 'substitute', 'customer/help/Password_Recovery.tpl', 27, false),)), $this); ?>
<?php func_load_lang($this, "customer/help/Password_Recovery.tpl","lbl_forgot_password,txt_password_recover,txt_email_not_match,lbl_forgot_password"); ?>
<h1><?php echo $this->_tpl_vars['lng']['lbl_forgot_password']; ?>
</h1>

<p class="text-block"><?php echo $this->_tpl_vars['lng']['txt_password_recover']; ?>
</p>

<?php ob_start(); ?>
  
  <?php if ($_GET['section'] == 'Password_Recovery_error' && $_GET['err_type'] == 'antibot'): ?>
    <?php $this->assign('antibot_err', true); ?>
  <?php endif; ?>

  <form action="help.php" method="post" name="processform">
    <input type="hidden" name="action" value="recover_password" />

    <table cellspacing="0" class="data-table">

      <tr> 
        <td class="data-name"><label for="username"><?php echo $this->_tpl_vars['recover_field_name']; ?>
</label></td>
        <td class="data-required">*</td>
        <td>
          <input type="text" name="username" id="username" size="30" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['username'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
" />
          <?php if ($_GET['section'] == 'Password_Recovery_error' && ! $this->_tpl_vars['antibot_err']): ?>
            <div class="error-message"><?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['txt_email_not_match'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'login_field', $this->_tpl_vars['recover_field_name']) : smarty_modifier_substitute($_tmp, 'login_field', $this->_tpl_vars['recover_field_name'])); ?>
</div>
          <?php endif; ?>
        </td>
      </tr>

      <?php ob_start();
$_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/buttons/submit.tpl", 'smarty_include_vars' => array('type' => 'input')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
$this->assign('submit_button', ob_get_contents()); ob_end_clean();
 ?>

      <?php if ($this->_tpl_vars['active_modules']['Image_Verification'] && $this->_tpl_vars['show_antibot']['on_pwd_recovery'] == 'Y'): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Image_Verification/spambot_arrest.tpl", 'smarty_include_vars' => array('mode' => "data-table",'id' => $this->_tpl_vars['antibot_sections']['on_pwd_recovery'],'antibot_err' => $this->_tpl_vars['antibot_err'],'button_code' => $this->_tpl_vars['submit_button'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php else: ?>
        <tr> 
          <td colspan="2">&nbsp;</td>
          <td class="button-row"><?php echo $this->_tpl_vars['submit_button']; ?>
</td>
        </tr>
      <?php endif; ?>

    </table>

  </form>
<?php $this->_smarty_vars['capture']['dialog'] = ob_get_contents(); ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/dialog.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['lng']['lbl_forgot_password'],'content' => $this->_smarty_vars['capture']['dialog'],'noborder' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>