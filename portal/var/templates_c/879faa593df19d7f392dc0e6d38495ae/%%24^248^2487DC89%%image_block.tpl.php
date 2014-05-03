<?php /* Smarty version 2.6.26, created on 2014-04-08 20:25:19
         compiled from modules/Image_Verification/image_block.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'mt_rand', 'modules/Image_Verification/image_block.tpl', 6, false),array('modifier', 'wm_remove', 'modules/Image_Verification/image_block.tpl', 8, false),array('modifier', 'escape', 'modules/Image_Verification/image_block.tpl', 8, false),)), $this); ?>
<?php func_load_lang($this, "modules/Image_Verification/image_block.tpl","lbl_get_a_different_code,lbl_get_a_different_code"); ?><div class="iv-img">
	<img src="<?php echo $this->_tpl_vars['xcart_web_dir']; ?>
/antibot_image.php?section=<?php echo $this->_tpl_vars['id']; ?>
&amp;rnd=<?php echo ((is_array($_tmp='1')) ? $this->_run_mod_handler('mt_rand', true, $_tmp, 10000) : mt_rand($_tmp, 10000)); ?>
" id="<?php echo $this->_tpl_vars['id']; ?>
" alt="" /><br />
<?php if ($this->_tpl_vars['is_ajax_request'] == 'Y'): ?>
<a href="javascript:void(0);" onclick="javascript: change_antibot_image('<?php echo $this->_tpl_vars['id']; ?>
');"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['lng']['lbl_get_a_different_code'])) ? $this->_run_mod_handler('wm_remove', true, $_tmp) : smarty_modifier_wm_remove($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
</a>
<?php else: ?>
<script type="text/javascript">
//<![CDATA[
document.write('<'+'a href="javascript:void(0);" onclick="javascript: change_antibot_image(\'<?php echo $this->_tpl_vars['id']; ?>
\');"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['lng']['lbl_get_a_different_code'])) ? $this->_run_mod_handler('wm_remove', true, $_tmp) : smarty_modifier_wm_remove($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp, 'javascript') : smarty_modifier_escape($_tmp, 'javascript')); ?>
<'+'/a>');
//]]>
</script>
<?php endif; ?>
</div>
<?php if (! $this->_tpl_vars['nobr']): ?><br /><?php endif; ?>