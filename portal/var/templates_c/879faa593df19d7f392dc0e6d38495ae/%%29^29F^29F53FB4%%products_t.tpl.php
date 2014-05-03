<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:31
         compiled from customer/main/products_t.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'list2matrix', 'customer/main/products_t.tpl', 5, false),array('function', 'interline', 'customer/main/products_t.tpl', 15, false),array('function', 'currency', 'customer/main/products_t.tpl', 120, false),array('function', 'alter_currency', 'customer/main/products_t.tpl', 121, false),array('function', 'include_cache', 'customer/main/products_t.tpl', 148, false),array('modifier', 'escape', 'customer/main/products_t.tpl', 11, false),array('modifier', 'default', 'customer/main/products_t.tpl', 23, false),array('modifier', 'amp', 'customer/main/products_t.tpl', 23, false),array('modifier', 'cat', 'customer/main/products_t.tpl', 143, false),)), $this); ?>
<?php func_load_lang($this, "customer/main/products_t.tpl","lbl_products_list,lbl_sku,lbl_enter_your_price,lbl_enter_your_price_note,lbl_our_price,lbl_our_price,lbl_market_price,lbl_save_price"); ?><?php echo smarty_function_list2matrix(array('assign' => 'products_matrix','assign_width' => 'cell_width','list' => $this->_tpl_vars['products'],'row_length' => $this->_tpl_vars['config']['Appearance']['products_per_row']), $this);?>

<?php $this->assign('is_matrix_view', true); ?>

<?php if ($this->_tpl_vars['products_matrix']): ?>

  <?php $this->assign('cell_width', '20'); ?>
  <table cellspacing="3" class="products products-table width-100" summary="<?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_products_list'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">

    <?php $_from = $this->_tpl_vars['products_matrix']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['products_matrix'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['products_matrix']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['row']):
        $this->_foreach['products_matrix']['iteration']++;
?>

      <tr<?php echo smarty_function_interline(array('name' => 'products_matrix','skip_highlight' => true), $this);?>
>

                <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['products']['iteration']++;
?>
          <?php if ($this->_tpl_vars['product']): ?>

            <td<?php echo smarty_function_interline(array('name' => 'products','additional_class' => "product-cell"), $this);?>
>
              <div class="image">
                <a href="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['product']['alt_url'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['product']['page_url']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['product']['page_url'])))) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "product_thumbnail.tpl", 'smarty_include_vars' => array('productid' => $this->_tpl_vars['product']['productid'],'image_x' => $this->_tpl_vars['product']['tmbn_x'],'image_y' => $this->_tpl_vars['product']['tmbn_y'],'product' => $this->_tpl_vars['product']['product'],'tmbn_url' => $this->_tpl_vars['product']['tmbn_url'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></a>

                <?php if ($this->_tpl_vars['active_modules']['Special_Offers'] && $this->_tpl_vars['product']['have_offers']): ?>
                  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Special_Offers/customer/product_offer_thumb.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
              </div>
            </td>

          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

      </tr>

      <tr<?php echo smarty_function_interline(array('name' => 'products_matrix','additional_class' => "product-name-row",'skip_highlight' => true), $this);?>
>

                <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['products']['iteration']++;
?>
          <?php if ($this->_tpl_vars['product']): ?>

            <td<?php echo smarty_function_interline(array('name' => 'products','additional_class' => "product-cell"), $this);?>
 style="width: <?php echo $this->_tpl_vars['cell_width']; ?>
%;">
<script type="text/javascript">
//<![CDATA[
products_data[<?php echo $this->_tpl_vars['product']['productid']; ?>
] = {};
//]]>
</script>
              <a href="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['product']['alt_url'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['product']['page_url']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['product']['page_url'])))) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
" class="product-title"><?php echo ((is_array($_tmp=$this->_tpl_vars['product']['product'])) ? $this->_run_mod_handler('amp', true, $_tmp) : smarty_modifier_amp($_tmp)); ?>
</a>
            </td>

          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

      </tr>

            <?php if ($this->_tpl_vars['config']['Appearance']['display_productcode_in_list'] == 'Y'): ?>
        <tr<?php echo smarty_function_interline(array('name' => 'products_matrix','skip_highlight' => true), $this);?>
>

          <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['products']['iteration']++;
?>
            <?php if ($this->_tpl_vars['product']): ?>

              <td<?php echo smarty_function_interline(array('name' => 'products','additional_class' => "product-cell"), $this);?>
>
                <?php if ($this->_tpl_vars['product']['productcode']): ?>
                  <div class="sku"><?php echo $this->_tpl_vars['lng']['lbl_sku']; ?>
: <?php echo ((is_array($_tmp=$this->_tpl_vars['product']['productcode'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
                <?php else: ?>
                    &nbsp;
                <?php endif; ?>
              </td>

            <?php endif; ?>
          <?php endforeach; endif; unset($_from); ?>

        </tr>
      <?php endif; ?>

            <?php if ($this->_tpl_vars['active_modules']['Customer_Reviews'] && $this->_tpl_vars['rating_data_exists']): ?>
      <tr<?php echo smarty_function_interline(array('name' => 'products_matrix','skip_highlight' => true), $this);?>
>

        <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['products']['iteration']++;
?>
          <?php if ($this->_tpl_vars['product']): ?>

            <td<?php echo smarty_function_interline(array('name' => 'products','additional_class' => "product-cell"), $this);?>
>

              <?php if ($this->_tpl_vars['product']['rating_data']): ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Customer_Reviews/vote_bar.tpl", 'smarty_include_vars' => array('rating' => $this->_tpl_vars['product']['rating_data'],'productid' => $this->_tpl_vars['product']['productid'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
              <?php endif; ?>

            </td>
  
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </tr>
      <?php endif; ?>

      <tr<?php echo smarty_function_interline(array('name' => 'products_matrix','skip_highlight' => true), $this);?>
>

                <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['products'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['products']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['product']):
        $this->_foreach['products']['iteration']++;
?>
          <?php if ($this->_tpl_vars['product']): ?>

            <td<?php echo smarty_function_interline(array('name' => 'products','additional_class' => "product-cell product-cell-price"), $this);?>
>
              <?php if ($this->_tpl_vars['product']['product_type'] != 'C'): ?>

                <?php if ($this->_tpl_vars['active_modules']['Subscriptions'] != "" && $this->_tpl_vars['product']['catalogprice']): ?>

                  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Subscriptions/subscription_info_inlist.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                <?php elseif ($this->_tpl_vars['product']['appearance']['is_auction']): ?>

                  <span class="price"><?php echo $this->_tpl_vars['lng']['lbl_enter_your_price']; ?>
</span><br />
                  <?php echo $this->_tpl_vars['lng']['lbl_enter_your_price_note']; ?>


                <?php else: ?>

                  <?php if ($this->_tpl_vars['product']['appearance']['has_price'] && $this->_tpl_vars['is_pconf']): ?>

                    <div class="price-row">
                      <span class="price"><?php echo $this->_tpl_vars['lng']['lbl_our_price']; ?>
:</span> <span class="price-value"><?php echo smarty_function_currency(array('value' => $this->_tpl_vars['product']['taxed_price']), $this);?>
</span>
                      <span class="market-price"><?php echo smarty_function_alter_currency(array('value' => $this->_tpl_vars['product']['taxed_price']), $this);?>
</span>
                    </div>

                  <?php endif; ?>

                  <?php if ($this->_tpl_vars['active_modules']['Special_Offers'] && $this->_tpl_vars['product']['use_special_price']): ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Special_Offers/customer/product_special_price.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                  <?php endif; ?>

                <?php endif; ?>

              <?php else: ?>

                &nbsp;

              <?php endif; ?>

                <?php if ($this->_tpl_vars['active_modules']['Product_Configurator'] && $this->_tpl_vars['is_pconf'] && $this->_tpl_vars['current_product']): ?>
                  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Product_Configurator/pconf_add_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php elseif ($this->_tpl_vars['active_modules']['Product_Configurator'] && $this->_tpl_vars['product']['product_type'] == 'C'): ?>
                  <?php $this->assign('url', "product.php?productid=".($this->_tpl_vars['product']['productid'])."&amp;cat=".($this->_tpl_vars['cat'])."&amp;page=".($this->_tpl_vars['navigation_page'])); ?>
                  <?php if ($this->_tpl_vars['featured'] == 'Y'): ?>
                    <?php $this->assign('url', ((is_array($_tmp=$this->_tpl_vars['url'])) ? $this->_run_mod_handler('cat', true, $_tmp, "&amp;featured=Y") : smarty_modifier_cat($_tmp, "&amp;featured=Y"))); ?>
                  <?php endif; ?>
                  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/buttons/details.tpl", 'smarty_include_vars' => array('href' => $this->_tpl_vars['url'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php elseif ($this->_tpl_vars['config']['Appearance']['buynow_button_enabled'] == 'Y' && $this->_tpl_vars['product']['product_type'] != 'C'): ?>
                  <?php if ($this->_tpl_vars['login'] != ""): ?>
                    <?php echo smarty_function_include_cache(array('file' => "customer/main/buy_now.tpl",'product' => $this->_tpl_vars['product'],'cat' => $this->_tpl_vars['cat'],'featured' => $this->_tpl_vars['featured'],'is_matrix_view' => $this->_tpl_vars['is_matrix_view'],'login' => '1','smarty_get_cat' => $_GET['cat'],'smarty_get_page' => $_GET['page'],'smarty_get_quantity' => $_GET['quantity']), $this);?>

                  <?php else: ?>
                    <?php echo smarty_function_include_cache(array('file' => "customer/main/buy_now.tpl",'product' => $this->_tpl_vars['product'],'cat' => $this->_tpl_vars['cat'],'featured' => $this->_tpl_vars['featured'],'is_matrix_view' => $this->_tpl_vars['is_matrix_view'],'login' => "",'smarty_get_cat' => $_GET['cat'],'smarty_get_page' => $_GET['page'],'smarty_get_quantity' => $_GET['quantity']), $this);?>

                  <?php endif; ?>
                <?php else: ?>
                  <div class="prices_without_bn">
                    <strong><?php echo $this->_tpl_vars['lng']['lbl_our_price']; ?>
:</strong>
                    <span class="price"><?php echo smarty_function_currency(array('value' => $this->_tpl_vars['product']['taxed_price']), $this);?>
</span>
                    <span class="market-price"><?php echo smarty_function_alter_currency(array('value' => $this->_tpl_vars['product']['taxed_price']), $this);?>
</span>

                    <?php if ($this->_tpl_vars['product']['appearance']['has_market_price'] && $this->_tpl_vars['product']['appearance']['market_price_discount'] > 0): ?>
                      <div class="market-price">
                        <?php echo $this->_tpl_vars['lng']['lbl_market_price']; ?>
: <span class="market-price-value"><?php echo smarty_function_currency(array('value' => $this->_tpl_vars['product']['list_price']), $this);?>
</span>

                        <?php if ($this->_tpl_vars['product']['appearance']['market_price_discount'] > 0): ?>
                          <?php if ($this->_tpl_vars['config']['General']['alter_currency_symbol'] != ""): ?>, <?php endif; ?>
                          <span class="price-save"><?php echo $this->_tpl_vars['lng']['lbl_save_price']; ?>
 <?php echo $this->_tpl_vars['product']['appearance']['market_price_discount']; ?>
%</span>
                        <?php endif; ?>

                      </div>
                    <?php endif; ?>

                    <?php if ($this->_tpl_vars['product']['taxes']): ?>
                      <div class="taxes"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/main/taxed_price.tpl", 'smarty_include_vars' => array('taxes' => $this->_tpl_vars['product']['taxes'],'is_subtax' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

              <?php if ($this->_tpl_vars['active_modules']['Feature_Comparison'] && $this->_tpl_vars['product']['fclassid'] > 0): ?>
                  <div><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Feature_Comparison/compare_checkbox.tpl", 'smarty_include_vars' => array('id' => $this->_tpl_vars['product']['productid'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
              <?php endif; ?>

            </td>

          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </tr>

      <?php if (! ($this->_foreach['products_matrix']['iteration'] == $this->_foreach['products_matrix']['total'])): ?>
        <tr class="separator">
          <td colspan="<?php echo ((is_array($_tmp=@$this->_tpl_vars['config']['Appearance']['products_per_row'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1)); ?>
">&nbsp;</td>
        </tr>
      <?php endif; ?>

    <?php endforeach; endif; unset($_from); ?>

  </table>

<?php endif; ?>