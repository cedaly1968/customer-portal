<?php /* Smarty version 2.6.26, created on 2014-05-02 09:17:00
         compiled from quick_search.tpl */ ?>
<?php func_load_lang($this, "quick_search.tpl","lbl_keywords,lbl_no_results_found,lbl_quick_search_nopattern,lbl_searching"); ?><script type="text/javascript" src="<?php echo $this->_tpl_vars['SkinDir']; ?>
/js/quick_search.js"></script>
<div id="quick_search_panel" style="display:none;">
  <div class="quick-search-panel-main">

    <div class="quick-search-body" id="quick_search_body1">
      <span id="quick_search_results"><?php echo $this->_tpl_vars['lng']['lbl_keywords']; ?>
</span>
      <span id="quick_search_no_results" style="display:none;"><?php echo $this->_tpl_vars['lng']['lbl_no_results_found']; ?>
</span>
      <span id="quick_search_no_pattern" style="display:none;"><?php echo $this->_tpl_vars['lng']['lbl_quick_search_nopattern']; ?>
</span><br />
    </div>

    <div class="quick-search-body" id="quick_search_body2" style="display:none;">
      <?php echo $this->_tpl_vars['lng']['lbl_searching']; ?>
...<br /><br />
      <img src="<?php echo $this->_tpl_vars['ImagesDir']; ?>
/quick_search_searching.gif" alt="" />
    </div>

    <div class="quick-search-close" onclick="javascript:close_quick_search();"></div>

  </div>
</div>