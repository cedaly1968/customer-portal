<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from customer/menu_dialog.tpl */ ?>
<div class="menu-dialog<?php if ($this->_tpl_vars['additional_class']): ?> <?php echo $this->_tpl_vars['additional_class']; ?>
<?php endif; ?>">
  <?php if ($this->_tpl_vars['title']): ?>
  <div class="title-bar valign-middle<?php if ($this->_tpl_vars['link_href']): ?> link-title<?php endif; ?>">
    <?php echo ''; ?><?php if ($this->_tpl_vars['link_href']): ?><?php echo '<span class="title-link"><a href="'; ?><?php echo $this->_tpl_vars['link_href']; ?><?php echo '" class="title-link"><img src="'; ?><?php echo $this->_tpl_vars['ImagesDir']; ?><?php echo '/spacer.gif" alt=""  /></a></span>'; ?><?php endif; ?><?php echo '<h2>'; ?><?php echo $this->_tpl_vars['title']; ?><?php echo '</h2>'; ?>

  </div>
  <?php endif; ?>
  <div class="content">
    <?php echo $this->_tpl_vars['content']; ?>

  </div>
</div>