<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:38
         compiled from customer/special.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'customer/special.tpl', 32, false),array('modifier', 'trim', 'customer/special.tpl', 64, false),)), $this); ?>
<?php func_load_lang($this, "customer/special.tpl","lbl_manufacturers,lbl_gift_registry,lbl_friends_wish_list,lbl_subscriptions_info,lbl_special"); ?><?php ob_start(); ?>

  <?php if ($this->_tpl_vars['active_modules']['Manufacturers'] != "" && $this->_tpl_vars['config']['Manufacturers']['manufacturers_menu'] != 'Y'): ?>
    <li><a href="manufacturers.php"><?php echo $this->_tpl_vars['lng']['lbl_manufacturers']; ?>
</a></li>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Gift_Certificates'] != ""): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Gift_Certificates/gc_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Feature_Comparison'] != ""): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Feature_Comparison/customer_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Survey'] != ""): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Survey/menu_special.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Special_Offers'] != ""): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Special_Offers/menu_special.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Wishlist'] && $this->_tpl_vars['active_modules']['Gift_Registry']): ?>
    <li><a href="giftreg_manage.php"><?php echo $this->_tpl_vars['lng']['lbl_gift_registry']; ?>
</a></li>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Wishlist'] && $this->_tpl_vars['wlid'] != ""): ?>
    <li><a href="cart.php?mode=friend_wl&amp;wlid=<?php echo ((is_array($_tmp=$this->_tpl_vars['wlid'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['lng']['lbl_friends_wish_list']; ?>
</a></li>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['user_subscription'] != ""): ?>
    <li><a href="orders.php?mode=subscriptions"><?php echo $this->_tpl_vars['lng']['lbl_subscriptions_info']; ?>
</a></li>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Gift_Registry'] || $this->_tpl_vars['active_modules']['RMA'] || $this->_tpl_vars['active_modules']['Special_Offers']): ?>
    <li class="separator">&nbsp;</li>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Gift_Registry'] != ""): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Gift_Registry/giftreg_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['RMA']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/RMA/customer/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Special_Offers'] != ""): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Special_Offers/menu_cart.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Sitemap'] != ""): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Sitemap/menu_item.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['active_modules']['Products_Map'] != ""): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Products_Map/menu_item.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

<?php $this->_smarty_vars['capture']['submenu'] = ob_get_contents(); ob_end_clean(); ?>
<?php if (((is_array($_tmp=$this->_smarty_vars['capture']['submenu'])) ? $this->_run_mod_handler('trim', true, $_tmp) : trim($_tmp))): ?>
  <?php ob_start(); ?>
    <ul>
      <?php echo ((is_array($_tmp=$this->_smarty_vars['capture']['submenu'])) ? $this->_run_mod_handler('trim', true, $_tmp) : trim($_tmp)); ?>

    </ul>
  <?php $this->_smarty_vars['capture']['menu'] = ob_get_contents(); ob_end_clean(); ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/menu_dialog.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['lng']['lbl_special'],'content' => $this->_smarty_vars['capture']['menu'],'additional_class' => "menu-special")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>