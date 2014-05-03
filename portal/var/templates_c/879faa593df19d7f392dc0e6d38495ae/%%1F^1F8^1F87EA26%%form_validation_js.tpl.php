<?php /* Smarty version 2.6.26, created on 2014-04-07 06:50:28
         compiled from form_validation_js.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'wm_remove', 'form_validation_js.tpl', 7, false),array('modifier', 'escape', 'form_validation_js.tpl', 7, false),array('modifier', 'replace', 'form_validation_js.tpl', 7, false),)), $this); ?>
<?php func_load_lang($this, "form_validation_js.tpl","txt_out_of_stock"); ?><script type="text/javascript">
//<![CDATA[
var txt_out_of_stock = "<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['lng']['txt_out_of_stock'])) ? $this->_run_mod_handler('wm_remove', true, $_tmp) : smarty_modifier_wm_remove($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')))) ? $this->_run_mod_handler('replace', true, $_tmp, "\n", "<br />") : smarty_modifier_replace($_tmp, "\n", "<br />")))) ? $this->_run_mod_handler('replace', true, $_tmp, "\r", ' ') : smarty_modifier_replace($_tmp, "\r", ' ')); ?>
";

<?php echo '
function FormValidation(form) {

  if (typeof(window.check_exceptions) != \'undefined\' && !check_exceptions()) {
    alert(exception_msg);
    return false;
  }

'; ?>

  <?php if ($this->_tpl_vars['product_options_js'] != ''): ?>
  <?php echo $this->_tpl_vars['product_options_js']; ?>

  <?php endif; ?>

<?php echo '
  var selavailObj = document.getElementById(\'product_avail\');
  var inpavailObj = document.getElementById(\'product_avail_input\');

  if ((!selavailObj || selavailObj.disabled == true) && inpavailObj && inpavailObj.disabled == false) {
      if (!check_quantity_input_box(inpavailObj))
        return false;

  } else if ((!inpavailObj || inpavailObj.disabled == true) && selavailObj && selavailObj.disabled == false && selavailObj.value == 0) {
      alert(txt_out_of_stock);
      return false;
  }

  return !ajax.widgets.add2cart || !ajax.widgets.add2cart(form);
}

// Check quantity input box
function check_quantity_input_box(inp) {
  if (isNaN(inp.minQuantity))
    inp.minQuantity = min_avail;

  if (isNaN(inp.maxQuantity))
    inp.maxQuantity = product_avail;

  if (!isNaN(inp.minQuantity) && !isNaN(inp.maxQuantity)) {
    var q = parseInt(inp.value);
    if (isNaN(q)) {
      alert(substitute(lbl_product_quantity_type_error, "min", inp.minQuantity, "max", inp.maxQuantity));
      return false;
    }

    if (q < inp.minQuantity) {
      alert(substitute(lbl_product_minquantity_error, "min", inp.minQuantity));
      return false;
    }

    if (q > inp.maxQuantity && is_limit) {
      alert(substitute(lbl_product_maxquantity_error, "max", inp.maxQuantity));
      return false;
    }

    if (typeof(window.check_wholesale) != \'undefined\')
      check_wholesale(inp.value);

  }
  return true;
}
'; ?>

//]]>
</script>