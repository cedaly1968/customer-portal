<?php /* Smarty version 2.6.26, created on 2014-04-07 13:43:08
         compiled from head_admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'getvar', 'head_admin.tpl', 17, false),array('modifier', 'default', 'head_admin.tpl', 19, false),)), $this); ?>
<?php if ($this->_tpl_vars['login'] != ""): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "quick_search.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<div id="head-admin">

  <div id="logo-gray">
    <a href="<?php echo $this->_tpl_vars['current_location']; ?>
/"><img src="<?php echo $this->_tpl_vars['ImagesDir']; ?>
/logo_gray.png" alt="" /></a>
  </div>

  <?php if ($this->_tpl_vars['login']): ?>

    <?php echo smarty_function_getvar(array('var' => 'top_news','func' => 'func_tpl_get_admin_top_news'), $this);?>

    <div class="admin-top-news">
      <?php echo ((is_array($_tmp=@$this->_tpl_vars['top_news']['description'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['top_news']['title']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['top_news']['title'])); ?>

    </div>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "authbox_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <?php endif; ?>

  <div class="clearing"></div>

  <?php if ($this->_tpl_vars['login'] && $this->_tpl_vars['menu']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['menu'])."/menu_box.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

</div>