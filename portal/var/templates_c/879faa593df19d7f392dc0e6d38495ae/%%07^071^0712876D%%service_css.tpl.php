<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/service_css.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_defer', 'customer/service_css.tpl', 1, false),array('function', 'getvar', 'customer/service_css.tpl', 1, false),array('modifier', 'string_format', 'customer/service_css.tpl', 1, false),)), $this); ?>
 <?php echo smarty_function_load_defer(array('file' => "css/".($this->_config[0]['vars']['CSSFilePrefix']).".css",'type' => 'css'), $this);?>
 <?php if ($this->_tpl_vars['config']['UA']['browser'] == 'MSIE'): ?>   <?php $this->assign('ie_ver', ((is_array($_tmp=$this->_tpl_vars['config']['UA']['version'])) ? $this->_run_mod_handler('string_format', true, $_tmp, '%d') : smarty_modifier_string_format($_tmp, '%d'))); ?>   <?php echo smarty_function_load_defer(array('file' => "css/".($this->_config[0]['vars']['CSSFilePrefix']).".IE".($this->_tpl_vars['ie_ver']).".css",'type' => 'css'), $this);?>
 <?php endif; ?> <?php if ($this->_tpl_vars['config']['UA']['browser'] == 'Firefox' || $this->_tpl_vars['config']['UA']['browser'] == 'Mozilla'): ?>   <?php echo smarty_function_load_defer(array('file' => "css/".($this->_config[0]['vars']['CSSFilePrefix']).".FF.css",'type' => 'css'), $this);?>
 <?php endif; ?> <?php if ($this->_tpl_vars['config']['UA']['browser'] == 'Opera'): ?>   <?php echo smarty_function_load_defer(array('file' => "css/".($this->_config[0]['vars']['CSSFilePrefix']).".Opera.css",'type' => 'css'), $this);?>
 <?php endif; ?> <?php if ($this->_tpl_vars['config']['UA']['browser'] == 'Chrome'): ?>   <?php echo smarty_function_load_defer(array('file' => "css/".($this->_config[0]['vars']['CSSFilePrefix']).".GC.css",'type' => 'css'), $this);?>
 <?php endif; ?> <?php echo smarty_function_load_defer(array('file' => "lib/cluetip/jquery.cluetip.css",'type' => 'css'), $this);?>
 <?php if ($this->_tpl_vars['main'] == 'product'): ?>   <?php echo smarty_function_getvar(array('var' => 'det_images_widget'), $this);?>
   <?php if ($this->_tpl_vars['det_images_widget'] == 'cloudzoom'): ?>     <?php echo smarty_function_load_defer(array('file' => "lib/cloud_zoom/cloud-zoom.css",'type' => 'css'), $this);?>
   <?php elseif ($this->_tpl_vars['det_images_widget'] == 'colorbox'): ?>     <?php echo smarty_function_load_defer(array('file' => "lib/colorbox/colorbox.css",'type' => 'css'), $this);?>
   <?php endif; ?> <?php endif; ?> <?php echo smarty_function_getvar(array('func' => 'func_tpl_is_jcarousel_is_needed'), $this);?>
 <?php if ($this->_tpl_vars['active_modules']['Wishlist'] != '' && $this->_tpl_vars['func_tpl_is_jcarousel_is_needed']): ?>   <?php echo smarty_function_load_defer(array('file' => "modules/Wishlist/main_carousel.css",'type' => 'css'), $this);?>
 <?php endif; ?> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'customer/service_css_modules.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php if ($this->_tpl_vars['AltSkinDir']): ?>   <?php echo smarty_function_load_defer(array('file' => "css/altskin.css",'type' => 'css'), $this);?>
   <?php if ($this->_tpl_vars['config']['UA']['browser'] == 'MSIE'): ?>     <?php echo smarty_function_load_defer(array('file' => "css/altskin.IE".($this->_tpl_vars['ie_ver']).".css",'type' => 'css'), $this);?>
   <?php endif; ?>   <?php if ($this->_tpl_vars['config']['UA']['browser'] == 'Firefox' || $this->_tpl_vars['config']['UA']['browser'] == 'Mozilla'): ?>   	<?php echo smarty_function_load_defer(array('file' => "css/altskin.FF.css",'type' => 'css'), $this);?>
   <?php endif; ?>   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'customer/service_css_modules.tpl', 'smarty_include_vars' => array('is_altskin' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <?php endif; ?> <?php if ($this->_tpl_vars['custom_styles']): ?> <?php echo smarty_function_load_defer(array('file' => "css/custom_styles",'direct_info' => $this->_tpl_vars['custom_styles'],'type' => 'css'), $this);?>
 <?php endif; ?> 