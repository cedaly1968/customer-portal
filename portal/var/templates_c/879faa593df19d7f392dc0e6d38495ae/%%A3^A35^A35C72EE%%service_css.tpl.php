<?php /* Smarty version 2.6.26, created on 2014-04-07 13:43:08
         compiled from service_css.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'service_css.tpl', 6, false),)), $this); ?>
<?php if ($this->_tpl_vars['config']['UA']['browser'] == 'MSIE'): ?>
  <?php $this->assign('ie_ver', ((is_array($_tmp=$this->_tpl_vars['config']['UA']['version'])) ? $this->_run_mod_handler('string_format', true, $_tmp, '%d') : smarty_modifier_string_format($_tmp, '%d'))); ?>
<?php endif; ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['SkinDir']; ?>
/css/admin.css" />
<?php if ($this->_tpl_vars['ie_ver'] != ''): ?>
<style type="text/css">
<!--
<?php endif; ?>
<?php echo ''; ?><?php $_from = $this->_tpl_vars['css_files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mname'] => $this->_tpl_vars['files']):
?><?php echo ''; ?><?php $_from = $this->_tpl_vars['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f']):
?><?php echo ''; ?><?php if ($this->_tpl_vars['f']['admin']): ?><?php echo ''; ?><?php if (! $this->_tpl_vars['ie_ver']): ?><?php echo '<link rel="stylesheet" type="text/css" href="'; ?><?php echo $this->_tpl_vars['SkinDir']; ?><?php echo '/modules/'; ?><?php echo $this->_tpl_vars['mname']; ?><?php echo '/'; ?><?php echo $this->_tpl_vars['f']['subpath']; ?><?php echo 'admin'; ?><?php if ($this->_tpl_vars['f']['suffix']): ?><?php echo '.'; ?><?php echo $this->_tpl_vars['f']['suffix']; ?><?php echo ''; ?><?php endif; ?><?php echo '.css" />'; ?><?php else: ?><?php echo '@import url("'; ?><?php echo $this->_tpl_vars['SkinDir']; ?><?php echo '/modules/'; ?><?php echo $this->_tpl_vars['mname']; ?><?php echo '/'; ?><?php echo $this->_tpl_vars['f']['subpath']; ?><?php echo 'admin'; ?><?php if ($this->_tpl_vars['f']['suffix']): ?><?php echo '.'; ?><?php echo $this->_tpl_vars['f']['suffix']; ?><?php echo ''; ?><?php endif; ?><?php echo '.css");'; ?><?php endif; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?>

<?php if ($this->_tpl_vars['ie_ver'] != ''): ?>
-->
</style>
<?php endif; ?>