<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/tabs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'interline', 'customer/tabs.tpl', 10, false),array('modifier', 'amp', 'customer/tabs.tpl', 10, false),array('modifier', 'escape', 'customer/tabs.tpl', 10, false),)), $this); ?>
<?php if ($this->_tpl_vars['speed_bar']): ?>
  <div class="tabs<?php if ($this->_tpl_vars['all_languages_cnt'] > 1): ?> with_languages<?php endif; ?>">
    <ul>

      <?php $_from = $this->_tpl_vars['speed_bar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tabs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tabs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sb']):
        $this->_foreach['tabs']['iteration']++;
?>
        <li<?php echo smarty_function_interline(array('name' => 'tabs'), $this);?>
><a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['sb']['link'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['sb']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></li>
      <?php endforeach; endif; unset($_from); ?>

    </ul>
  </div>
<?php endif; ?>