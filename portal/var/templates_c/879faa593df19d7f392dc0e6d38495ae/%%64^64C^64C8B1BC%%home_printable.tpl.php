<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/home_printable.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'customer/home_printable.tpl', 6, false),array('function', 'config_load', 'customer/home_printable.tpl', 9, false),array('function', 'load_defer', 'customer/home_printable.tpl', 74, false),array('function', 'load_defer_code', 'customer/home_printable.tpl', 76, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="<?php echo ((is_array($_tmp=@$this->_tpl_vars['default_charset'])) ? $this->_run_mod_handler('default', true, $_tmp, "utf-8") : smarty_modifier_default($_tmp, "utf-8")); ?>
"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['skin_config'])), $this);?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/service_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


</head>
<body<?php echo $this->_tpl_vars['reading_direction_tag']; ?>
<?php if ($this->_tpl_vars['body_onload'] != ''): ?> onload="javascript: <?php echo $this->_tpl_vars['body_onload']; ?>
"<?php endif; ?> class="printable<?php $_from = $this->_tpl_vars['container_classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?> <?php echo $this->_tpl_vars['c']; ?>
<?php endforeach; endif; unset($_from); ?>">
<div id="page-container">
  <div id="page-container2">

    <div id="header">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>

    <div id="content-container">
      <div id="content-container2">
        <div id="center">
          <div id="center-main">
            <?php if ($this->_tpl_vars['main'] == 'cart' || $this->_tpl_vars['main'] == 'checkout' || $this->_tpl_vars['main'] == 'order_message' || $this->_tpl_vars['main'] == 'order_message_widget'): ?>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/evaluation.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
<!-- central space -->

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/bread_crumbs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

            <?php if ($this->_tpl_vars['main'] != 'cart' && $this->_tpl_vars['main'] != 'checkout' && $this->_tpl_vars['main'] != 'order_message' && $this->_tpl_vars['main'] != 'order_message_widget'): ?>
              <?php if ($this->_tpl_vars['gcheckout_enabled']): ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Google_Checkout/gcheckout_top_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <?php endif; ?>
              <?php if ($this->_tpl_vars['amazon_enabled']): ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Amazon_Checkout/amazon_top_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['page_title']): ?>
              <h1><?php echo $this->_tpl_vars['page_title']; ?>
</h1>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['active_modules']['Special_Offers'] != ""): ?>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Special_Offers/customer/new_offers_message.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/home_main.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<!-- /central space -->

          </div>
        </div>
      </div>

    </div>

    <div id="footer">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/bottom.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>

  </div>
</div>

<?php ob_start(); ?>
$(document).ready(function(){
  window.print();
});
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('printing_code', ob_get_contents());ob_end_clean(); ?>
<?php echo smarty_function_load_defer(array('file' => 'printing_code','direct_info' => $this->_tpl_vars['printing_code'],'type' => 'js'), $this);?>


<?php echo smarty_function_load_defer_code(array('type' => 'css'), $this);?>

<?php echo smarty_function_load_defer_code(array('type' => 'js'), $this);?>

</body>
</html>