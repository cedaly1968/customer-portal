<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/head.tpl */ ?>
<?php if (( $this->_tpl_vars['main'] != 'cart' || $this->_tpl_vars['cart_empty'] ) && $this->_tpl_vars['main'] != 'checkout'): ?>
  <div class="head-bg">
    <div class="head-bg2">

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/language_selector.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/phones.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

      <div class="logo"><a href="<?php echo $this->_tpl_vars['catalogs']['customer']; ?>
/home.php"><img src="<?php echo $this->_tpl_vars['AltImagesDir']; ?>
/vivid_dreams/logo.jpg" alt="" /></a></div>
      <div class="logo_err">
      <a href="home.php"><img src="<?php echo $this->_tpl_vars['AltImagesDir']; ?>
/vivid_dreams/logo_check.gif" alt="" /></a>
      </div>
    </div>

    <div class="cart-container">
      <div class="cart-block">



        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/authbox.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

      </div>
    </div>

    <div class="line2">
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/tabs.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>

  </div>

<?php else: ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/".($this->_tpl_vars['checkout_module'])."/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/noscript.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>