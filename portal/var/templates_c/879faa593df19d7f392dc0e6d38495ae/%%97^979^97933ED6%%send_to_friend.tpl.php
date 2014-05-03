<?php /* Smarty version 2.6.26, created on 2014-04-07 15:00:39
         compiled from customer/main/send_to_friend.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'customer/main/send_to_friend.tpl', 10, false),)), $this); ?>
<?php func_load_lang($this, "customer/main/send_to_friend.tpl","lbl_send_to_friend,lbl_send_your_name,lbl_send_your_email,lbl_recipient_email,lbl_add_personal_message,lbl_send_to_friend,lbl_send_to_friend"); ?><?php ob_start(); ?>
<form action="product.php" method="post" name="send">
  <input type="hidden" name="mode" value="send" />
  <input type="hidden" name="productid" value="<?php echo $this->_tpl_vars['product']['productid']; ?>
" />

  <table cellspacing="0" class="data-table" summary="<?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_send_to_friend'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
    <tr>
      <td class="data-name"><label for="send_name"><?php echo $this->_tpl_vars['lng']['lbl_send_your_name']; ?>
</label>:</td>
      <td class="data-required">*</td>
      <td>
        <input class="send2friend input-required" id="send_name" type="text" name="name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['send_to_friend_info']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if ($this->_tpl_vars['send_to_friend_info']['fill_err'] && $this->_tpl_vars['send_to_friend_info']['name'] == ''): ?>
          <span class="data-required">&lt;&lt;</span>
        <?php endif; ?>
      </td>
    </tr>

    <tr>
      <td class="data-name"><label for="send_from"><?php echo $this->_tpl_vars['lng']['lbl_send_your_email']; ?>
</label>:</td>
      <td class="data-required">*</td>
      <td>
        <input class="send2friend input-required input-email" id="send_from" type="text" name="from" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['send_to_friend_info']['from'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if (( $this->_tpl_vars['send_to_friend_info']['fill_err'] && $this->_tpl_vars['send_to_friend_info']['from'] == '' ) || $this->_tpl_vars['send_to_friend_info']['from_failed'] == 'Y'): ?>
          <span class="data-required">&lt;&lt;</span>
        <?php endif; ?>
      </td>
    </tr>

    <tr>
      <td class="data-name"><label for="send_to"><?php echo $this->_tpl_vars['lng']['lbl_recipient_email']; ?>
</label>:</td>
      <td class="data-required">*</td>
      <td>
        <input class="send2friend input-required input-email" id="send_to" type="text" name="email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['send_to_friend_info']['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
        <?php if (( $this->_tpl_vars['send_to_friend_info']['fill_err'] && $this->_tpl_vars['send_to_friend_info']['email'] == '' ) || $this->_tpl_vars['send_to_friend_info']['email_failed'] == 'Y'): ?>
          <span class="data-required">&lt;&lt;</span>
        <?php endif; ?>
      </td>
    </tr> 

    <tr>
      <td colspan="3">
        <div class="data-name">
          <label for="is_msg">
            <input type="checkbox" id="is_msg" name="is_msg" onclick="javascript: $('#send_message_box').toggle();" value="Y"<?php if ($this->_tpl_vars['send_to_friend_info']['is_msg'] == 'Y'): ?> checked="checked"<?php endif; ?> />
              <?php echo $this->_tpl_vars['lng']['lbl_add_personal_message']; ?>

          </label>
        </div>
        <div id="send_message_box"<?php if ($this->_tpl_vars['send_to_friend_info']['is_msg'] != 'Y'): ?> style="display:none"<?php endif; ?>>
          <textarea class="send2friend" id="send_message" name="message" cols="40" rows="4"><?php echo $this->_tpl_vars['send_to_friend_info']['message']; ?>
</textarea>
        </div>
      </td>
    </tr> 

    <?php ob_start();
$_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/buttons/button.tpl", 'smarty_include_vars' => array('type' => 'input','button_title' => $this->_tpl_vars['lng']['lbl_send_to_friend'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
$this->assign('submit_button', ob_get_contents()); ob_end_clean();
 ?>

    <?php if ($this->_tpl_vars['active_modules']['Image_Verification'] && $this->_tpl_vars['show_antibot']['on_send_to_friend'] == 'Y'): ?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Image_Verification/spambot_arrest.tpl", 'smarty_include_vars' => array('mode' => "data-table",'id' => $this->_tpl_vars['antibot_sections']['on_send_to_friend'],'antibot_err' => $this->_tpl_vars['antibot_friend_err'],'button_code' => $this->_tpl_vars['submit_button'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php else: ?>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td class="button-row">
        <?php echo $this->_tpl_vars['submit_button']; ?>

      </td>
    </tr>
    <?php endif; ?>

  </table>

</form>

<?php $this->_smarty_vars['capture']['dialog'] = ob_get_contents(); ob_end_clean(); ?>
<?php if ($this->_tpl_vars['nodialog']): ?>
  <?php echo $this->_smarty_vars['capture']['dialog']; ?>

<?php else: ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/dialog.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['lng']['lbl_send_to_friend'],'content' => $this->_smarty_vars['capture']['dialog'],'additional_class' => "no-print send2friend-dialog")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>