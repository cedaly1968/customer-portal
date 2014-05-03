<?php /* Smarty version 2.6.26, created on 2014-04-18 06:47:05
         compiled from mark_required_fields_js.tpl */ ?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){

  markEmptyFields($('form[name=<?php echo $this->_tpl_vars['form']; ?>
]'));
  
  <?php if ($this->_tpl_vars['errfields'] != ''): ?>
    <?php $_from = $this->_tpl_vars['errfields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['f'] => $this->_tpl_vars['v']):
?>
      $('#<?php echo $this->_tpl_vars['f']; ?>
').addClass('err');
    <?php endforeach; endif; unset($_from); ?>
  <?php endif; ?>
});
//]]>
</script>