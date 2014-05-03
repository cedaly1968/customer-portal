<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:31
         compiled from customer/main/subcategories.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'amp', 'customer/main/subcategories.tpl', 13, false),array('modifier', 'escape', 'customer/main/subcategories.tpl', 27, false),array('modifier', 'default', 'customer/main/subcategories.tpl', 28, false),array('function', 'get_category_image_url', 'customer/main/subcategories.tpl', 27, false),array('function', 'inc', 'customer/main/subcategories.tpl', 28, false),)), $this); ?>
<?php func_load_lang($this, "customer/main/subcategories.tpl","lbl_products,txt_no_products_in_cat"); ?><?php if ($this->_tpl_vars['active_modules']['Bestsellers'] && $this->_tpl_vars['config']['Bestsellers']['bestsellers_menu'] != 'Y'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Bestsellers/bestsellers.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['active_modules']['Special_Offers']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Special_Offers/customer/category_offers_short_list.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['current_category']['category'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
</h1>

<?php if ($this->_tpl_vars['config']['Appearance']['subcategories_per_row'] == 'Y'): ?>

  <?php if ($this->_tpl_vars['current_category']['description'] != ""): ?>
    <div class="subcategory-descr"><?php echo ((is_array($_tmp=$this->_tpl_vars['current_category']['description'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
</div>
  <?php endif; ?>

  <?php if ($this->_tpl_vars['categories']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/subcategories_t.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>

<?php else: ?>

  <img class="subcategory-image" src="<?php echo smarty_function_get_category_image_url(array('category' => $this->_tpl_vars['current_category']), $this);?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['current_category']['category'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php if ($this->_tpl_vars['current_category']['image_x']): ?> width="<?php echo $this->_tpl_vars['current_category']['image_x']; ?>
"<?php endif; ?><?php if ($this->_tpl_vars['current_category']['image_y']): ?> height="<?php echo $this->_tpl_vars['current_category']['image_y']; ?>
"<?php endif; ?> />
  <?php echo smarty_function_inc(array('assign' => 'standoff','value' => ((is_array($_tmp=@$this->_tpl_vars['current_category']['image_x'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'inc' => 15), $this);?>

  <div style="margin-left: <?php echo $this->_tpl_vars['standoff']; ?>
px;">
<!--    <?php if ($this->_tpl_vars['current_category']['description'] != ""): ?>
      <div class="subcategory-descr"><?php echo $this->_tpl_vars['current_category']['description']; ?>
</div>
    <?php endif; ?>-->

    <?php if ($this->_tpl_vars['categories']): ?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/subcategories_list.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
  </div>
  <div class="clearing"></div>

<?php endif; ?>

<?php if ($this->_tpl_vars['f_products']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/featured.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['cat_products']): ?>

  <?php ob_start(); ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/navigation.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/products.tpl", 'smarty_include_vars' => array('products' => $this->_tpl_vars['cat_products'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/navigation.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

  <?php $this->_smarty_vars['capture']['dialog'] = ob_get_contents(); ob_end_clean(); ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/dialog.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['lng']['lbl_products'],'content' => ($this->_smarty_vars['capture']['dialog']),'products_sort_url' => "home.php?cat=".($this->_tpl_vars['cat'])."&",'sort' => true,'additional_class' => "products-dialog dialog-category-products-list",'title_page' => 'category')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php elseif (! $this->_tpl_vars['cat_products'] && ! $this->_tpl_vars['categories']): ?>

  <?php echo $this->_tpl_vars['lng']['txt_no_products_in_cat']; ?>


<?php endif; ?>