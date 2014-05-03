<?php /* Smarty version 2.6.26, created on 2014-04-08 20:25:19
         compiled from modules/Image_Verification/spambot_arrest.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'modules/Image_Verification/spambot_arrest.tpl', 13, false),)), $this); ?>
<?php func_load_lang($this, "modules/Image_Verification/spambot_arrest.tpl","lbl_word_verification,lbl_word_verification,lbl_type_the_characters,lbl_case_sensitive_note,lbl_type_the_characters,lbl_case_sensitive_note,lbl_type_the_characters,lbl_case_sensitive_note"); ?><?php if (! $this->_tpl_vars['id']): ?>
  <?php $this->assign('id', 'image'); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['antibot_name_prefix'] != ''): ?>
  <?php $this->assign('antibot_input_str_name', ((is_array($_tmp='antibot_input_str')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['antibot_name_prefix']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['antibot_name_prefix']))); ?>
<?php else: ?>  
  <?php $this->assign('antibot_input_str_name', 'antibot_input_str'); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['mode'] == 'data-table'): ?>
<tr class="hidden"><td>
<?php endif; ?>
<label for="<?php echo $this->_tpl_vars['antibot_input_str_name']; ?>
" class="data-required hidden"><?php echo $this->_tpl_vars['lng']['lbl_word_verification']; ?>
</label>
<?php if ($this->_tpl_vars['mode'] == 'data-table'): ?>
</td></tr>
<?php endif; ?>

<?php if ($this->_tpl_vars['mode'] == 'advanced' || $this->_tpl_vars['mode'] == 'simple'): ?>

  <div class="iv-box">
    <?php if ($this->_tpl_vars['mode'] == 'advanced'): ?>
      <?php echo $this->_tpl_vars['lng']['lbl_word_verification']; ?>

      <hr />
    <?php endif; ?>
    <?php echo $this->_tpl_vars['lng']['lbl_type_the_characters']; ?>
:
    <div class="iv-row">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Image_Verification/image_block.tpl", 'smarty_include_vars' => array('nobr' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <div class="iv-input valign-middle-adv-lvl1">
        <div class="valign-middle-adv-lvl2">
          <div class="valign-middle-adv-lvl3">
            <span class="star">*</span>
            <input type="text" id="<?php echo $this->_tpl_vars['antibot_input_str_name']; ?>
" name="<?php echo $this->_tpl_vars['antibot_input_str_name']; ?>
"<?php if ($this->_tpl_vars['antibot_err']): ?> class="err"<?php endif; ?> />
            <?php if ($this->_tpl_vars['button_code']): ?>
              <div>
                <?php echo $this->_tpl_vars['button_code']; ?>

              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="clearing"></div>
  </div>

  <?php if ($this->_tpl_vars['config']['Image_Verification']['spambot_arrest_case_sensitive'] == 'Y' && $this->_tpl_vars['config']['Image_Verification']['spambot_arrest_str_generator'] != 'numbers'): ?>
    <?php echo $this->_tpl_vars['lng']['lbl_case_sensitive_note']; ?>

  <?php endif; ?>

<?php elseif ($this->_tpl_vars['mode'] == 'data-table'): ?>

  <tr>
    <td colspan="3" class="iv-box-descr"><?php echo $this->_tpl_vars['lng']['lbl_type_the_characters']; ?>
:</td>
  </tr>
  <tr>
    <td class="iv-box">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Image_Verification/image_block.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </td>
    <td class="data-required">*</td>
    <td class="iv-box">
      <input type="text" id="<?php echo $this->_tpl_vars['antibot_input_str_name']; ?>
" name="<?php echo $this->_tpl_vars['antibot_input_str_name']; ?>
"<?php if ($this->_tpl_vars['antibot_err']): ?> class="err"<?php endif; ?> />
      <?php if ($this->_tpl_vars['button_code']): ?>
        <div class="button-row">
          <?php echo $this->_tpl_vars['button_code']; ?>

        </div>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['config']['Image_Verification']['spambot_arrest_case_sensitive'] == 'Y' && $this->_tpl_vars['config']['Image_Verification']['spambot_arrest_str_generator'] != 'numbers'): ?>
        <?php echo $this->_tpl_vars['lng']['lbl_case_sensitive_note']; ?>

      <?php endif; ?>
    </td>
  </tr>

<?php elseif ($this->_tpl_vars['mode'] == 'simple_column'): ?>

  <div class="iv-box">
    <?php echo $this->_tpl_vars['lng']['lbl_type_the_characters']; ?>
:
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Image_Verification/image_block.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <div class="iv-input">
      <span class="star">*</span>
      <input type="text" id="<?php echo $this->_tpl_vars['antibot_input_str_name']; ?>
" name="<?php echo $this->_tpl_vars['antibot_input_str_name']; ?>
"<?php if ($this->_tpl_vars['antibot_err']): ?> class="err"<?php endif; ?> />
    </div>
    <div class="clearing"></div>
  </div>

  <?php if ($this->_tpl_vars['config']['Image_Verification']['spambot_arrest_case_sensitive'] == 'Y' && $this->_tpl_vars['config']['Image_Verification']['spambot_arrest_str_generator'] != 'numbers'): ?>
    <?php echo $this->_tpl_vars['lng']['lbl_case_sensitive_note']; ?>

  <?php endif; ?>

<?php endif; ?>
