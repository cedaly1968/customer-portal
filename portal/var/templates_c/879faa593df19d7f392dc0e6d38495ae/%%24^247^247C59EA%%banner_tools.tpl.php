<?php /* Smarty version 2.6.26, created on 2014-05-02 09:16:46
         compiled from banner_tools.tpl */ ?>
<?php if ($this->_tpl_vars['banner_tools_data']): ?>
<div class="banner-tools">
  <?php $_from = $this->_tpl_vars['banner_tools_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
  <div class="banner-tools-box">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['item']['template']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  </div>
  <?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>