<?php /* Smarty version 2.6.26, created on 2014-05-02 09:17:00
         compiled from dialog.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'dialog.tpl', 13, false),)), $this); ?>
<?php if ($this->_tpl_vars['title']): ?>
  <h2><?php echo $this->_tpl_vars['title']; ?>
</h2>
<?php endif; ?>
<table cellspacing="0" <?php echo $this->_tpl_vars['extra']; ?>
>
<tr>
  <td class="DialogBorder">
    <table cellspacing="<?php if (! $this->_tpl_vars['zero_cellspacing']): ?>1<?php else: ?>0<?php endif; ?>" class="DialogBox">
      <tr>
        <td class="DialogBox" valign="<?php echo ((is_array($_tmp=@$this->_tpl_vars['valign'])) ? $this->_run_mod_handler('default', true, $_tmp, 'top') : smarty_modifier_default($_tmp, 'top')); ?>
">
          <?php echo $this->_tpl_vars['content']; ?>
&nbsp;
        </td>
      </tr>
    </table>
  </td>
</tr>
</table>