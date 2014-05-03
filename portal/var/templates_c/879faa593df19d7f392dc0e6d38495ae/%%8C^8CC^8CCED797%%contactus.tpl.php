<?php /* Smarty version 2.6.26, created on 2014-04-12 00:34:55
         compiled from customer/help/contactus.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'customer/help/contactus.tpl', 26, false),array('modifier', 'default', 'customer/help/contactus.tpl', 123, false),)), $this); ?>
<?php func_load_lang($this, "customer/help/contactus.tpl","lbl_contact_us,txt_contact_us_header,txt_contact_us_sent,lbl_contact_us,lbl_title,lbl_first_name,lbl_last_name,lbl_company,lbl_address,lbl_address_2,lbl_city,lbl_county,lbl_state,lbl_country,lbl_zip_code,lbl_phone,lbl_email,lbl_fax,lbl_web_site,lbl_department,lbl_all,lbl_partners,lbl_marketing_publicity,lbl_web_design,lbl_sales_department,lbl_subject,lbl_message,lbl_contact_us"); ?>
<h1><?php echo $this->_tpl_vars['lng']['lbl_contact_us']; ?>
</h1>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "check_required_fields_js.tpl", 'smarty_include_vars' => array('fillerror' => $this->_tpl_vars['fillerror'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "check_email_script.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "check_zipcode_js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "change_states_js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($_GET['mode'] == 'update' || $_GET['mode'] == ""): ?>
  <p class="text-block"><?php echo $this->_tpl_vars['lng']['txt_contact_us_header']; ?>
</p>
<?php endif; ?>

<?php ob_start(); ?>

  <?php if ($_GET['mode'] == 'sent'): ?>

    <?php echo $this->_tpl_vars['lng']['txt_contact_us_sent']; ?>


  <?php elseif ($_GET['mode'] == 'update' || $_GET['mode'] == ""): ?>

    <form action="help.php?section=contactus&amp;mode=update&amp;action=contactus" method="post" name="registerform" onsubmit="javascript: return check_zip_code(this);">
      <input type="hidden" name="usertype" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['usertype'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />

      <table cellspacing="0" class="data-table" summary="<?php echo ((is_array($_tmp=$this->_tpl_vars['lng']['lbl_contact_us'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">

        <?php if ($this->_tpl_vars['config']['email_as_login'] != 'Y' && $this->_tpl_vars['default_fields']['username']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="username"><?php echo $this->_tpl_vars['login_field_name']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['username']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td><input type="text" id="username" name="username" size="32" maxlength="32" value="<?php if ($this->_tpl_vars['userinfo']['username'] != ''): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['login'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>" /></td>
          </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['default_fields']['title']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="title"><?php echo $this->_tpl_vars['lng']['lbl_title']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['title']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/title_selector.tpl", 'smarty_include_vars' => array('val' => $this->_tpl_vars['userinfo']['titleid'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['default_fields']['firstname']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="firstname"><?php echo $this->_tpl_vars['lng']['lbl_first_name']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['firstname']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="firstname" name="firstname" size="32" maxlength="32" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['firstname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            </td>
          </tr>
        <?php endif; ?>
 
        <?php if ($this->_tpl_vars['default_fields']['lastname']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="lastname"><?php echo $this->_tpl_vars['lng']['lbl_last_name']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['lastname']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="lastname" name="lastname" size="32" maxlength="32" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['lastname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['default_fields']['company']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="company"><?php echo $this->_tpl_vars['lng']['lbl_company']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['company']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="company" name="company" size="32" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['company'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            </td>
          </tr>
        <?php endif; ?>
 
        <?php if ($this->_tpl_vars['default_fields']['b_address']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="b_address"><?php echo $this->_tpl_vars['lng']['lbl_address']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['b_address']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="b_address" name="b_address" size="32" maxlength="64" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['b_address'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            </td>
          </tr>
        <?php endif; ?>
 
        <?php if ($this->_tpl_vars['default_fields']['b_address_2']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="b_address_2"><?php echo $this->_tpl_vars['lng']['lbl_address_2']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['b_address_2']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="b_address_2" name="b_address_2" size="32" maxlength="64" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['b_address_2'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            </td>
          </tr>
        <?php endif; ?>
 
        <?php if ($this->_tpl_vars['default_fields']['b_city']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="b_city"><?php echo $this->_tpl_vars['lng']['lbl_city']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['b_city']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="b_city" name="b_city" size="32" maxlength="64" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['b_city'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            </td>
          </tr>
        <?php endif; ?>
 
        <?php if ($this->_tpl_vars['default_fields']['b_county']['avail'] == 'Y' && $this->_tpl_vars['config']['General']['use_counties'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="b_county"><?php echo $this->_tpl_vars['lng']['lbl_county']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['b_county']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/counties.tpl", 'smarty_include_vars' => array('counties' => $this->_tpl_vars['counties'],'name' => 'b_county','default' => $this->_tpl_vars['userinfo']['b_county'],'stateid' => $this->_tpl_vars['userinfo']['b_stateid'],'country_name' => 'b_country')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['default_fields']['b_state']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="b_state"><?php echo $this->_tpl_vars['lng']['lbl_state']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['b_state']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/states.tpl", 'smarty_include_vars' => array('states' => $this->_tpl_vars['states'],'name' => 'b_state','default' => ((is_array($_tmp=@$this->_tpl_vars['userinfo']['b_state'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['config']['General']['default_state']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['config']['General']['default_state'])),'default_country' => ((is_array($_tmp=@$this->_tpl_vars['userinfo']['b_country'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['config']['General']['default_country']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['config']['General']['default_country'])),'country_name' => 'b_country')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
          </tr>
        <?php endif; ?>
 
        <?php if ($this->_tpl_vars['default_fields']['b_country']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="b_country"><?php echo $this->_tpl_vars['lng']['lbl_country']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['b_country']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <select id="b_country" name="b_country" onchange="javascript: check_zip_code_field(this, $('#b_zipcode'));">
                <?php $_from = $this->_tpl_vars['countries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                  <option value="<?php echo $this->_tpl_vars['c']['country_code']; ?>
"<?php if (( $this->_tpl_vars['userinfo']['b_country'] == $this->_tpl_vars['c']['country_code'] ) || ( $this->_tpl_vars['c']['country_code'] == $this->_tpl_vars['config']['General']['default_country'] && $this->_tpl_vars['userinfo']['b_country'] == "" )): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['c']['country']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
              </select>
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['default_fields']['b_zipcode']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="b_zipcode"><?php echo $this->_tpl_vars['lng']['lbl_zip_code']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['b_zipcode']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/zipcode.tpl", 'smarty_include_vars' => array('val' => $this->_tpl_vars['userinfo']['b_zipcode'],'zip4' => $this->_tpl_vars['userinfo']['b_zip4'],'id' => 'b_zipcode','name' => 'b_zipcode')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['default_fields']['b_state']['avail'] == 'Y' && $this->_tpl_vars['default_fields']['b_country']['avail'] == 'Y'): ?>
          <tr style="display: none;">
            <td>
              <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "main/register_states.tpl", 'smarty_include_vars' => array('state_name' => 'b_state','country_name' => 'b_country','county_name' => 'b_county','state_value' => ((is_array($_tmp=@$this->_tpl_vars['userinfo']['b_state'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['config']['General']['default_state']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['config']['General']['default_state'])),'county_value' => $this->_tpl_vars['userinfo']['b_county'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['default_fields']['phone']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="phone"><?php echo $this->_tpl_vars['lng']['lbl_phone']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['phone']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="phone" name="phone" size="32" maxlength="32" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['phone'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
            </td>
          </tr>
        <?php endif; ?>
 
        <?php if ($this->_tpl_vars['default_fields']['email']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="email"><?php echo $this->_tpl_vars['lng']['lbl_email']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['email']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="email" name="email" class="input-email" size="32" maxlength="128" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" onchange="javascript: checkEmailAddress(this);" />
            </td>
          </tr>
        <?php endif; ?>

        <?php if ($this->_tpl_vars['default_fields']['fax']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="fax"><?php echo $this->_tpl_vars['lng']['lbl_fax']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['fax']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td><input type="text" id="fax" name="fax" size="32" maxlength="128" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['fax'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" /></td>
          </tr>
        <?php endif; ?>
 
        <?php if ($this->_tpl_vars['default_fields']['url']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="url"><?php echo $this->_tpl_vars['lng']['lbl_web_site']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['url']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>
              <input type="text" id="url" name="url" size="32" maxlength="128" value="<?php if ($this->_tpl_vars['userinfo']['url'] == ""): ?>http://<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>" />
            </td>
          </tr>
        <?php endif; ?>

        <?php $_from = $this->_tpl_vars['additional_fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
          <?php if ($this->_tpl_vars['v']['avail'] == 'Y'): ?>
            <tr>
              <td class="data-name"><label for="additional_values_<?php echo $this->_tpl_vars['k']; ?>
"><?php echo ((is_array($_tmp=@$this->_tpl_vars['v']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['v']['field']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['v']['field'])); ?>
</label></td>
              <td<?php if ($this->_tpl_vars['v']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
              <td>

                <?php if ($this->_tpl_vars['v']['type'] == 'T'): ?>
                  <input type="text" id="additional_values_<?php echo $this->_tpl_vars['k']; ?>
" name="additional_values[<?php echo $this->_tpl_vars['k']; ?>
]" size="32" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['additional_values'][$this->_tpl_vars['k']])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />

                <?php elseif ($this->_tpl_vars['v']['type'] == 'C'): ?>
                  <input type="checkbox" id="additional_values_<?php echo $this->_tpl_vars['k']; ?>
" name="additional_values[<?php echo $this->_tpl_vars['k']; ?>
]" value="Y"<?php if ($this->_tpl_vars['userinfo']['additional_values'][$this->_tpl_vars['k']] == 'Y'): ?> checked="checked"<?php endif; ?> />

                <?php elseif ($this->_tpl_vars['v']['type'] == 'S'): ?>

                  <select id="additional_values_<?php echo $this->_tpl_vars['k']; ?>
" name="additional_values[<?php echo $this->_tpl_vars['k']; ?>
]">
                    <?php $_from = $this->_tpl_vars['v']['variants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['o']):
?>
                      <option value='<?php echo ((is_array($_tmp=$this->_tpl_vars['o'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'<?php if ($this->_tpl_vars['userinfo']['additional_values'][$this->_tpl_vars['k']] == $this->_tpl_vars['o']): ?> selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['o'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</option>
                    <?php endforeach; endif; unset($_from); ?>
                  </select>
                <?php endif; ?>

              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>

        <?php if ($this->_tpl_vars['default_fields']['department']['avail'] == 'Y'): ?>
          <tr>
            <td class="data-name"><label for="department"><?php echo $this->_tpl_vars['lng']['lbl_department']; ?>
</label></td>
            <td<?php if ($this->_tpl_vars['default_fields']['department']['required'] == 'Y'): ?> class="data-required">*<?php else: ?>>&nbsp;<?php endif; ?></td>
            <td>

              <select id="department" name="department">
                <option value="All" <?php if ($this->_tpl_vars['userinfo']['department'] == 'All' || $this->_tpl_vars['userinfo']['department'] == ""): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lng']['lbl_all']; ?>
</option>
                <option value="Partners" <?php if ($this->_tpl_vars['userinfo']['department'] == 'Partners'): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lng']['lbl_partners']; ?>
</option>
                <option value="Marketing / publicity" <?php if ($this->_tpl_vars['userinfo']['department'] == "Marketing / publicity"): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lng']['lbl_marketing_publicity']; ?>
</option>
                <option value="Webdesign" <?php if ($this->_tpl_vars['userinfo']['department'] == 'Webdesign'): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lng']['lbl_web_design']; ?>
</option>
                <option value="Sales" <?php if ($this->_tpl_vars['userinfo']['department'] == 'Sales'): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['lng']['lbl_sales_department']; ?>
</option>
              </select>

            </td>
          </tr>
        <?php endif; ?>

        <tr>
          <td class="data-name"><label for="subject"><?php echo $this->_tpl_vars['lng']['lbl_subject']; ?>
</label></td>
          <td class="data-required">*</td>
          <td class="data-width-100">
            <input type="text" id="subject" name="subject" size="32" maxlength="128" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['userinfo']['subject'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
          </td>
        </tr>

        <tr>
          <td class="data-name"><label for="message_body"><?php echo $this->_tpl_vars['lng']['lbl_message']; ?>
</label></td>
          <td class="data-required">*</td>
          <td>
            <textarea cols="48" id="message_body" rows="12" name="body"><?php echo $this->_tpl_vars['userinfo']['body']; ?>
</textarea>
          </td>
        </tr>

        <?php ob_start();
$_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/buttons/submit.tpl", 'smarty_include_vars' => array('type' => 'input','additional_button_class' => "main-button")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
$this->assign('submit_button', ob_get_contents()); ob_end_clean();
 ?>

        <?php if ($this->_tpl_vars['active_modules']['Image_Verification'] && $this->_tpl_vars['show_antibot']['on_contact_us'] == 'Y'): ?>
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Image_Verification/spambot_arrest.tpl", 'smarty_include_vars' => array('mode' => "data-table",'id' => $this->_tpl_vars['antibot_sections']['on_contact_us'],'antibot_err' => $this->_tpl_vars['antibot_contactus_err'],'button_code' => $this->_tpl_vars['submit_button'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php else: ?>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td class="button-row">
              <?php echo $this->_tpl_vars['submit_button']; ?>

          </td>
        </tr>
        <?php endif; ?>

      </table>

    </form>

  <?php endif; ?>

<?php $this->_smarty_vars['capture']['dialog'] = ob_get_contents(); ob_end_clean(); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "customer/dialog.tpl", 'smarty_include_vars' => array('title' => $this->_tpl_vars['lng']['lbl_contact_us'],'content' => $this->_smarty_vars['capture']['dialog'],'noborder' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>