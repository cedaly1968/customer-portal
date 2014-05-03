<?php /* Smarty version 2.6.26, created on 2014-05-02 09:17:00
         compiled from authbox_top.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'authbox_top.tpl', 28, false),)), $this); ?>
<?php func_load_lang($this, "authbox_top.tpl","lbl_your_partner_id,lbl_logoff,lbl_keywords,lbl_search,txt_how_quick_search_works"); ?><table cellpadding="2" cellspacing="0" border="0">
<tr>

  <?php if ($this->_tpl_vars['login'] != '' && $this->_tpl_vars['usertype'] == 'B'): ?>
    <td nowrap="nowrap" height="20" valign="top" class="partnerid-info">
      <?php echo $this->_tpl_vars['lng']['lbl_your_partner_id']; ?>
: <strong><?php echo $this->_tpl_vars['logged_userid']; ?>
</strong>
    </td>
  <?php endif; ?>

  <td class="AuthText" height="20" valign="top">
    <a href="<?php echo $this->_tpl_vars['current_area']; ?>
/register.php?mode=update"><?php echo $this->_tpl_vars['fullname']; ?>
</a>
  </td>

  <td valign="top" class="auth-text-wrapper">
    [ <a href="login.php?mode=logout" class="AuthText"><?php echo $this->_tpl_vars['lng']['lbl_logoff']; ?>
</a> ]
  </td>

  <?php if ($this->_tpl_vars['need_quick_search'] == 'Y'): ?>

    <td width="50">&nbsp;</td>

    <td class="quick-search-form" valign="top">
      <form name="qsform" action="" onsubmit="javascript: quick_search($('#quick_search_query').val()); return false;">
        <input type="text" class="default-value" id="quick_search_query" onkeypress="javascript:$('#quick_search_panel').hide();" onclick="javascript:$('#quick_search_panel').hide();" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_keywords'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
      </form>
    </td>

    <td class="main-button" nowrap="nowrap">
      <button class="quick-search-button" onclick="javascript:quick_search($('#quick_search_query').val());return false;"><?php echo $this->_tpl_vars['lng']['lbl_search']; ?>
</button>

      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/tooltip_js.tpl", 'smarty_include_vars' => array('text' => $this->_tpl_vars['lng']['txt_how_quick_search_works'],'id' => 'qs_help','type' => 'img','sticky' => true,'alt_image' => "question_gray.png",'wrapper_tag' => 'div')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </td>
<?php endif; ?>

</tr>
</table>