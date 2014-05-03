<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:42
         compiled from customer/main/subcategories_t.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'get_category_image_url', 'customer/main/subcategories_t.tpl', 9, false),array('modifier', 'escape', 'customer/main/subcategories_t.tpl', 9, false),array('modifier', 'substitute', 'customer/main/subcategories_t.tpl', 17, false),)), $this); ?>
<?php func_load_lang($this, "customer/main/subcategories_t.tpl","lbl_N_products,lbl_N_categories"); ?><?php $_from = $this->_tpl_vars['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['subcategory']):
?>

  <span class="subcategories" style="min-width: <?php echo $this->_tpl_vars['subcat_div_width']; ?>
px; width: <?php echo $this->_tpl_vars['subcat_div_width']; ?>
px; min-height: <?php echo $this->_tpl_vars['subcat_div_height']; ?>
px;">
    <?php if ($this->_tpl_vars['subcategory']['is_icon']): ?>
      <a href="home.php?cat=<?php echo $this->_tpl_vars['subcategory']['categoryid']; ?>
"><img src="<?php echo smarty_function_get_category_image_url(array('category' => $this->_tpl_vars['subcategory']), $this);?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['subcategory']['category'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" width="<?php echo $this->_tpl_vars['subcategory']['image_x']; ?>
" height="<?php echo $this->_tpl_vars['subcategory']['image_y']; ?>
" /></a>
    <?php else: ?>
      <img src="<?php echo $this->_tpl_vars['ImagesDir']; ?>
/spacer.gif" alt="" width="1" height="<?php echo $this->_tpl_vars['subcat_img_height']; ?>
" />
    <?php endif; ?>
    <br />
    <a href="home.php?cat=<?php echo $this->_tpl_vars['subcategory']['categoryid']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['subcategory']['category'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a><br />
    <?php if ($this->_tpl_vars['config']['Appearance']['count_products'] == 'Y'): ?>
      <?php if ($this->_tpl_vars['subcategory']['product_count']): ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_N_products'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'products', $this->_tpl_vars['subcategory']['product_count']) : smarty_modifier_substitute($_tmp, 'products', $this->_tpl_vars['subcategory']['product_count'])); ?>

      <?php elseif ($this->_tpl_vars['subcategory']['subcategory_count']): ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_N_categories'])) ? $this->_run_mod_handler('substitute', true, $_tmp, 'count', $this->_tpl_vars['subcategory']['subcategory_count']) : smarty_modifier_substitute($_tmp, 'count', $this->_tpl_vars['subcategory']['subcategory_count'])); ?>

      <?php endif; ?>
    <?php endif; ?>
  </span>

<?php endforeach; endif; unset($_from); ?>
<div class="clearing"></div>
<br />