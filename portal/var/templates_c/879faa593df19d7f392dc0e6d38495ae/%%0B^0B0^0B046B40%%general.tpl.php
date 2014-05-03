<?php /* Smarty version 2.6.26, created on 2014-04-18 22:44:05
         compiled from customer/help/general.tpl */ ?>
<?php func_load_lang($this, "customer/help/general.tpl","lbl_help_zone,txt_help_zone_title,lbl_recover_password,lbl_contact_us"); ?>
<h1><?php echo $this->_tpl_vars['lng']['lbl_help_zone']; ?>
</h1>

<p class="text-block"><?php echo $this->_tpl_vars['lng']['txt_help_zone_title']; ?>
</p>


  <ul class="help-index">

    <li class="first-item"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/buttons/button.tpl", 'smarty_include_vars' => array('button_title' => $this->_tpl_vars['lng']['lbl_recover_password'],'href' => "help.php?section=Password_Recovery",'style' => 'link')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></li>
    <li><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/buttons/button.tpl", 'smarty_include_vars' => array('button_title' => $this->_tpl_vars['lng']['lbl_contact_us'],'href' => "help.php?section=contactus&mode=update",'style' => 'link')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></li>

    <?php $_from = $this->_tpl_vars['pages_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pages'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pages']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['p']):
        $this->_foreach['pages']['iteration']++;
?>
      <li><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/buttons/button.tpl", 'smarty_include_vars' => array('button_title' => $this->_tpl_vars['p']['title'],'href' => "pages.php?pageid=".($this->_tpl_vars['p']['pageid']),'style' => 'link')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></li>
    <?php endforeach; endif; unset($_from); ?>

  </ul>
