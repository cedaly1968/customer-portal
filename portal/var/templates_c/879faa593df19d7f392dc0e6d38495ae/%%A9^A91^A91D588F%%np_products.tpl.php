<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/main/np_products.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_defer', 'customer/main/np_products.tpl', 43, false),)), $this); ?>
<?php func_load_lang($this, "customer/main/np_products.tpl","lbl_previous_product,lbl_next_product"); ?><?php if ($this->_tpl_vars['next_product'] || $this->_tpl_vars['prev_product']): ?>
<?php echo '<div class="np-products"><ul>'; ?><?php if ($this->_tpl_vars['prev_product']): ?><?php echo '<li><a href="product.php?productid='; ?><?php echo $this->_tpl_vars['prev_product']['productid']; ?><?php echo '&amp;cat='; ?><?php echo $this->_tpl_vars['cat']; ?><?php echo '" class="prev"><span class="arrow">&larr;</span>&nbsp;'; ?><?php echo $this->_tpl_vars['lng']['lbl_previous_product']; ?><?php echo '</a>'; ?><?php if ($this->_tpl_vars['next_product']): ?><?php echo '<span class="sep"></span>'; ?><?php endif; ?><?php echo '<div class="popup" id="np-popup-prev"><img src="'; ?><?php echo $this->_tpl_vars['ImagesDir']; ?><?php echo '/loading.gif" alt="" /></div></li>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['next_product']): ?><?php echo '<li class="last"><a href="product.php?productid='; ?><?php echo $this->_tpl_vars['next_product']['productid']; ?><?php echo '&amp;cat='; ?><?php echo $this->_tpl_vars['cat']; ?><?php echo '" class="next">'; ?><?php echo $this->_tpl_vars['lng']['lbl_next_product']; ?><?php echo '&nbsp;<span class="arrow">&rarr;</span></a><div class="popup" id="np-popup-next"><img src="'; ?><?php echo $this->_tpl_vars['ImagesDir']; ?><?php echo '/loading.gif" alt="" /></div></li>'; ?><?php endif; ?><?php echo '</ul></div>'; ?>

<?php endif; ?>
<script type="text/javascript">
//<![CDATA[
  var npProducts = [];
  <?php if ($this->_tpl_vars['prev_product']): ?>
    npProducts['prev'] = [];
    npProducts['prev']['id'] = <?php echo $this->_tpl_vars['prev_product']['productid']; ?>
;
    npProducts['prev']['loaded'] = false;
  <?php endif; ?>
  <?php if ($this->_tpl_vars['next_product']): ?>
    npProducts['next'] = [];
    npProducts['next']['id'] = <?php echo $this->_tpl_vars['next_product']['productid']; ?>
;
    npProducts['next']['loaded'] = false;
  <?php endif; ?>
//]]>
</script>
<?php echo smarty_function_load_defer(array('file' => "js/np_products.js",'type' => 'js'), $this);?>
