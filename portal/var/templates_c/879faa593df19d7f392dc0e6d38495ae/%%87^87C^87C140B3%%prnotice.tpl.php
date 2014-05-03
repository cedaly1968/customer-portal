<?php /* Smarty version 2.6.26, created on 2014-04-07 13:43:08
         compiled from main/prnotice.tpl */ ?>
<?php if ($this->_tpl_vars['main'] == 'catalog' && $this->_tpl_vars['current_category']['category'] == ""): ?>
  Powered by X-Cart <a href="http://www.x-cart.com"><?php echo $this->_tpl_vars['sm_prnotice_txt']; ?>
</a>
<?php else: ?>
  Powered by X-Cart <?php echo $this->_tpl_vars['sm_prnotice_txt']; ?>

<?php endif; ?>