<?php /* Smarty version 2.6.26, created on 2014-04-07 13:43:08
         compiled from location.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'amp', 'location.tpl', 11, false),array('modifier', 'default', 'location.tpl', 36, false),)), $this); ?>
<?php func_load_lang($this, "location.tpl","txt_noscript_warning"); ?><?php if ($this->_tpl_vars['location'] != ""): ?>

<div id="location">
<?php echo ''; ?><?php unset($this->_sections['position']);
$this->_sections['position']['name'] = 'position';
$this->_sections['position']['loop'] = is_array($_loop=$this->_tpl_vars['location']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['position']['show'] = true;
$this->_sections['position']['max'] = $this->_sections['position']['loop'];
$this->_sections['position']['step'] = 1;
$this->_sections['position']['start'] = $this->_sections['position']['step'] > 0 ? 0 : $this->_sections['position']['loop']-1;
if ($this->_sections['position']['show']) {
    $this->_sections['position']['total'] = $this->_sections['position']['loop'];
    if ($this->_sections['position']['total'] == 0)
        $this->_sections['position']['show'] = false;
} else
    $this->_sections['position']['total'] = 0;
if ($this->_sections['position']['show']):

            for ($this->_sections['position']['index'] = $this->_sections['position']['start'], $this->_sections['position']['iteration'] = 1;
                 $this->_sections['position']['iteration'] <= $this->_sections['position']['total'];
                 $this->_sections['position']['index'] += $this->_sections['position']['step'], $this->_sections['position']['iteration']++):
$this->_sections['position']['rownum'] = $this->_sections['position']['iteration'];
$this->_sections['position']['index_prev'] = $this->_sections['position']['index'] - $this->_sections['position']['step'];
$this->_sections['position']['index_next'] = $this->_sections['position']['index'] + $this->_sections['position']['step'];
$this->_sections['position']['first']      = ($this->_sections['position']['iteration'] == 1);
$this->_sections['position']['last']       = ($this->_sections['position']['iteration'] == $this->_sections['position']['total']);
?><?php echo ''; ?><?php if ($this->_tpl_vars['location'][$this->_sections['position']['index']]['1'] != ""): ?><?php echo '<a href="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['location'][$this->_sections['position']['index']]['1'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?><?php echo '">'; ?><?php endif; ?><?php echo '<span>'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['location'][$this->_sections['position']['index']]['0'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?><?php echo '</span>'; ?><?php if ($this->_tpl_vars['location'][$this->_sections['position']['index']]['1'] != ""): ?><?php echo '</a>'; ?><?php endif; ?><?php echo ''; ?><?php if (! $this->_sections['position']['last']): ?><?php echo '&nbsp;'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['config']['Appearance']['breadcrumbs_separator'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?><?php echo '&nbsp;'; ?><?php endif; ?><?php echo ''; ?><?php endfor; endif; ?><?php echo ''; ?>

</div>

<?php endif; ?>

<!-- check javascript availability -->
<noscript>
  <table width="500" cellpadding="2" cellspacing="0" align="center">
  <tr>
    <td align="center" class="ErrorMessage"><?php echo $this->_tpl_vars['lng']['txt_noscript_warning']; ?>
</td>
  </tr>
  </table>
</noscript>

<?php if ($this->_tpl_vars['alt_content']): ?>
<table id="<?php echo ((is_array($_tmp=@$this->_tpl_vars['newid'])) ? $this->_run_mod_handler('default', true, $_tmp, "dialog-message") : smarty_modifier_default($_tmp, "dialog-message")); ?>
" width="100%">
<tr>
  <td>
    <div class="dialog-message">
      <div class="box message-<?php echo ((is_array($_tmp=@$this->_tpl_vars['alt_type'])) ? $this->_run_mod_handler('default', true, $_tmp, 'I') : smarty_modifier_default($_tmp, 'I')); ?>
">

        <table width="100%">
        <tr>
<?php if ($this->_tpl_vars['image_none'] != 'Y'): ?>
          <td width="50" valign="top">
            <img class="dialog-img" src="<?php echo $this->_tpl_vars['ImagesDir']; ?>
/spacer.gif" alt="" />
          </td>
<?php endif; ?>
          <td align="left" valign="top">
            <?php echo $this->_tpl_vars['alt_content']; ?>

          </td>
        </tr>
        </table>
      </div>
    </div>
  </td>
</tr>
</table>
<?php elseif ($this->_tpl_vars['top_message']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/top_message.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>