<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/main/product.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'amp', 'customer/main/product.tpl', 7, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "form_validation_js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<h1><?php echo ((is_array($_tmp=$this->_tpl_vars['product']['producttitle'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
</h1>

<?php if ($this->_tpl_vars['config']['Appearance']['display_np_products'] == 'Y'): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/np_products.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['product']['product_type'] == 'C' && $this->_tpl_vars['active_modules']['Product_Configurator']): ?>

  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Product_Configurator/pconf_customer_product.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php else: ?>

  <?php if ($this->_tpl_vars['config']['General']['ajax_add2cart'] == 'Y' && $this->_tpl_vars['config']['General']['redirect_to_cart'] != 'Y' && ! ( $_COOKIE['robot'] == 'X-Cart Catalog Generator' && $_COOKIE['is_robot'] == 'Y' )): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/ajax.add2cart.tpl", 'smarty_include_vars' => array('_include_once' => 1)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
//<![CDATA[
<?php echo '
$(ajax).bind(
  \'load\',
  function() {
    var elm = $(\'.product-details\').get(0);
    return elm && ajax.widgets.product(elm);
  }
);
'; ?>

//]]>
</script>

  <?php endif; ?>

  <?php ob_start(); ?>

  <div class="product-details">

    <!--<div class="image"<?php if ($this->_tpl_vars['max_image_width'] > 0): ?> style="width: <?php echo $this->_tpl_vars['max_image_width']+12; ?>
px;"<?php endif; ?>>

      <?php if ($this->_tpl_vars['active_modules']['Detailed_Product_Images'] && $this->_tpl_vars['config']['Detailed_Product_Images']['det_image_popup'] == 'Y' && $this->_tpl_vars['images'] != ''): ?>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Detailed_Product_Images/widget.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

      <?php else: ?>

        <div class="image-box">
          <?php if ($this->_tpl_vars['active_modules']['On_Sale']): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/On_Sale/on_sale_icon.tpl", 'smarty_include_vars' => array('product' => $this->_tpl_vars['product'],'module' => 'product')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          <?php else: ?>
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "product_thumbnail.tpl", 'smarty_include_vars' => array('productid' => $this->_tpl_vars['product']['image_id'],'image_x' => $this->_tpl_vars['product']['image_x'],'image_y' => $this->_tpl_vars['product']['image_y'],'product' => $this->_tpl_vars['product']['product'],'tmbn_url' => $this->_tpl_vars['product']['image_url'],'id' => 'product_thumbnail','type' => $this->_tpl_vars['product']['image_type'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          <?php endif; ?>
        </div>

      <?php endif; ?>

      <?php if ($this->_tpl_vars['active_modules']['Magnifier'] && $this->_tpl_vars['config']['Magnifier']['magnifier_image_popup'] == 'Y' && $this->_tpl_vars['zoomer_images']): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Magnifier/popup_magnifier.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>

    </div>-->

    <div class="details"<?php if ($this->_tpl_vars['max_image_width'] > 0): ?> style="margin-left: <?php echo $this->_tpl_vars['max_image_width']+12; ?>
px;"<?php endif; ?>>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/product_details.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    </div>
    <div class="clearing"></div>

  </div>

  <?php $this->_smarty_vars['capture']['dialog'] = ob_get_contents(); ob_end_clean(); ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/dialog.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['product']['producttitle'],'content' => $this->_smarty_vars['capture']['dialog'],'noborder' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['product_tabs']): ?>
  <?php if ($this->_tpl_vars['show_as_tabs']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/ui_tabs.tpl", 'smarty_include_vars' => array('prefix' => "product-tabs-",'mode' => 'inline','tabs' => $this->_tpl_vars['product_tabs'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php else: ?>
    <?php $_from = $this->_tpl_vars['product_tabs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ind'] => $this->_tpl_vars['tab']):
?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['tab']['tpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endforeach; endif; unset($_from); ?>
  <?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['active_modules']['Product_Options'] && ( $this->_tpl_vars['product_options'] != '' || $this->_tpl_vars['product_wholesale'] != '' ) && ( $this->_tpl_vars['product']['product_type'] != 'C' || ! $this->_tpl_vars['active_modules']['Product_Configurator'] )): ?>
<script type="text/javascript">
//<![CDATA[
check_options();
//]]>
</script>
<?php endif; ?>