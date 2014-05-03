<?php /* Smarty version 2.6.26, created on 2014-05-02 09:17:00
         compiled from single/menu_box.tpl */ ?>
<?php func_load_lang($this, "single/menu_box.tpl","lbl_dashboard,lbl_orders,lbl_this_month_orders,lbl_search_orders_menu,lbl_create_order,lbl_returns,lbl_gift_certificates,lbl_abcr_abandoned_carts,lbl_abcr_order_statistic,lbl_catalog,lbl_add_new_product,lbl_products,lbl_edit_ratings,lbl_extra_fields,lbl_categories,lbl_manufacturers,lbl_prod_notif_adm,lbl_discounts,lbl_coupons,lbl_customer_reviews,lbl_rf_manage_filters,lbl_rf_custom_classes,lbl_users,lbl_users,lbl_wish_lists,lbl_membership_levels,lbl_titles,lbl_stop_list,lbl_shipping_and_taxes,lbl_shipping_and_taxes,lbl_countries,lbl_states,lbl_destination_zones,lbl_taxing_system,lbl_menu_shipping_options,lbl_shipping_methods,lbl_shipping_charges,lbl_shipping_markups,lbl_ups_online_tools,lbl_tools,lbl_import_export,lbl_update_inventory,lbl_summary,lbl_statistics,lbl_db_backup_restore,lbl_webmaster_mode,lbl_patch_upgrade,lbl_change_mpassword,lbl_maintenance,lbl_settings,lbl_general_settings,lbl_payment_methods,lbl_modules,lbl_images_location,lbl_order_statuses,module_name_XPayments_Connector,mc_lbl_multicurrency_menu,lbl_content,lbl_languages,lbl_static_pages,lbl_speed_bar,lbl_banner_system,lbl_html_catalog,lbl_news_management,lbl_mailchimp_news_management,lbl_edit_templates,lbl_files,lbl_survey_surveys"); ?><ul id="horizontal-menu">

<li>
<a href="home.php"><?php echo $this->_tpl_vars['lng']['lbl_dashboard']; ?>
</a>
</li>

<li>

<a href='<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/orders.php?date=M'><?php echo $this->_tpl_vars['lng']['lbl_orders']; ?>
</a>

<div>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/orders.php?date=M"><?php echo $this->_tpl_vars['lng']['lbl_this_month_orders']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/orders.php"><?php echo $this->_tpl_vars['lng']['lbl_search_orders_menu']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Advanced_Order_Management'] != ""): ?>
  <a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/create_order.php"><?php echo $this->_tpl_vars['lng']['lbl_create_order']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['RMA'] != ""): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/returns.php"><?php echo $this->_tpl_vars['lng']['lbl_returns']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Gift_Certificates']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/giftcerts.php"><?php echo $this->_tpl_vars['lng']['lbl_gift_certificates']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Abandoned_Cart_Reminder']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/abandoned_carts.php"><?php echo $this->_tpl_vars['lng']['lbl_abcr_abandoned_carts']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/abandoned_carts_statistic.php"><?php echo $this->_tpl_vars['lng']['lbl_abcr_order_statistic']; ?>
</a>
<?php endif; ?>
</div>
</li>

<li>

<a href='<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/search.php'><?php echo $this->_tpl_vars['lng']['lbl_catalog']; ?>
</a>

<div>
<a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/product_modify.php"><?php echo $this->_tpl_vars['lng']['lbl_add_new_product']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/search.php"><?php echo $this->_tpl_vars['lng']['lbl_products']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Customer_Reviews']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/ratings_edit.php"><?php echo $this->_tpl_vars['lng']['lbl_edit_ratings']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Extra_Fields']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/extra_fields.php"><?php echo $this->_tpl_vars['lng']['lbl_extra_fields']; ?>
</a>
<?php endif; ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/categories.php"><?php echo $this->_tpl_vars['lng']['lbl_categories']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Manufacturers']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/manufacturers.php"><?php echo $this->_tpl_vars['lng']['lbl_manufacturers']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Product_Configurator']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Product_Configurator/pconf_menu_provider.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Feature_Comparison']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Feature_Comparison/admin_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Product_Notifications'] != ""): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/product_notifications.php"><?php echo $this->_tpl_vars['lng']['lbl_prod_notif_adm']; ?>
</a>
<?php endif; ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/discounts.php"><?php echo $this->_tpl_vars['lng']['lbl_discounts']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Discount_Coupons']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/coupons.php"><?php echo $this->_tpl_vars['lng']['lbl_coupons']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Special_Offers']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Special_Offers/menu_provider.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Advanced_Customer_Reviews'] != ""): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/reviews.php"><?php echo $this->_tpl_vars['lng']['lbl_customer_reviews']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Refine_Filters']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/manage_filters.php"><?php echo $this->_tpl_vars['lng']['lbl_rf_manage_filters']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/rf_classes.php"><?php echo $this->_tpl_vars['lng']['lbl_rf_custom_classes']; ?>
</a>
<?php endif; ?>
</div>
</li>

<li>

<a href='<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/users.php'><?php echo $this->_tpl_vars['lng']['lbl_users']; ?>
</a>

<div>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/users.php"><?php echo $this->_tpl_vars['lng']['lbl_users']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Wishlist']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/wishlists.php"><?php echo $this->_tpl_vars['lng']['lbl_wish_lists']; ?>
</a>
<?php endif; ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/memberships.php"><?php echo $this->_tpl_vars['lng']['lbl_membership_levels']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/titles.php"><?php echo $this->_tpl_vars['lng']['lbl_titles']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Stop_List']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/stop_list.php"><?php echo $this->_tpl_vars['lng']['lbl_stop_list']; ?>
</a>
<?php endif; ?>
</div>
</li>

<li>

<?php if ($this->_tpl_vars['config']['Shipping']['enable_shipping'] == 'Y'): ?>
  <a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/shipping_rates.php"><?php echo $this->_tpl_vars['lng']['lbl_shipping_and_taxes']; ?>
</a>
<?php else: ?>
  <a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/taxes.php"><?php echo $this->_tpl_vars['lng']['lbl_shipping_and_taxes']; ?>
</a>
<?php endif; ?>

<div>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/countries.php"><?php echo $this->_tpl_vars['lng']['lbl_countries']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/states.php"><?php echo $this->_tpl_vars['lng']['lbl_states']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/zones.php"><?php echo $this->_tpl_vars['lng']['lbl_destination_zones']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/taxes.php"><?php echo $this->_tpl_vars['lng']['lbl_taxing_system']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/configuration.php?option=Shipping"><?php echo $this->_tpl_vars['lng']['lbl_menu_shipping_options']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/shipping.php"><?php echo $this->_tpl_vars['lng']['lbl_shipping_methods']; ?>
</a>
<?php if ($this->_tpl_vars['config']['Shipping']['enable_shipping'] == 'Y'): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/shipping_rates.php"><?php echo $this->_tpl_vars['lng']['lbl_shipping_charges']; ?>
</a>
<?php if ($this->_tpl_vars['config']['Shipping']['realtime_shipping'] == 'Y'): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/shipping_rates.php?type=R"><?php echo $this->_tpl_vars['lng']['lbl_shipping_markups']; ?>
</a>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['UPS_OnLine_Tools']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/ups.php"><?php echo $this->_tpl_vars['lng']['lbl_ups_online_tools']; ?>
</a>
<?php endif; ?>
</div>
</li>

<li>

<a href='<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/tools.php'><?php echo $this->_tpl_vars['lng']['lbl_tools']; ?>
</a>

<div>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/import.php"><?php echo $this->_tpl_vars['lng']['lbl_import_export']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['provider']; ?>
/inv_update.php"><?php echo $this->_tpl_vars['lng']['lbl_update_inventory']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/general.php"><?php echo $this->_tpl_vars['lng']['lbl_summary']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/statistics.php"><?php echo $this->_tpl_vars['lng']['lbl_statistics']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/db_backup.php"><?php echo $this->_tpl_vars['lng']['lbl_db_backup_restore']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/editor_mode.php"><?php echo $this->_tpl_vars['lng']['lbl_webmaster_mode']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/patch.php"><?php echo $this->_tpl_vars['lng']['lbl_patch_upgrade']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/change_mpassword.php"><?php echo $this->_tpl_vars['lng']['lbl_change_mpassword']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/tools.php"><?php echo $this->_tpl_vars['lng']['lbl_maintenance']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Lexity']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Lexity/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['XMonitoring']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/XMonitoring/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['XBackup']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/XBackup/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
</div>
</li>

<li>

<a href='<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/configuration.php'><?php echo $this->_tpl_vars['lng']['lbl_settings']; ?>
</a>

<div>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/configuration.php"><?php echo $this->_tpl_vars['lng']['lbl_general_settings']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/payment_methods.php"><?php echo $this->_tpl_vars['lng']['lbl_payment_methods']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/modules.php"><?php echo $this->_tpl_vars['lng']['lbl_modules']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/images_location.php"><?php echo $this->_tpl_vars['lng']['lbl_images_location']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['XOrder_Statuses']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/order_statuses.php"><?php echo $this->_tpl_vars['lng']['lbl_order_statuses']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['XPayments_Connector']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/configuration.php?option=XPayments_Connector"><?php echo $this->_tpl_vars['lng']['module_name_XPayments_Connector']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['XMultiCurrency'] != ""): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/currencies.php"><?php echo $this->_tpl_vars['lng']['mc_lbl_multicurrency_menu']; ?>
</a>
<?php endif; ?>
</div>
</li>

<li>

<a href='<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/languages.php'><?php echo $this->_tpl_vars['lng']['lbl_content']; ?>
</a>

<div>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/languages.php"><?php echo $this->_tpl_vars['lng']['lbl_languages']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/pages.php"><?php echo $this->_tpl_vars['lng']['lbl_static_pages']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/speed_bar.php"><?php echo $this->_tpl_vars['lng']['lbl_speed_bar']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Banner_System']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/banner_system.php"><?php echo $this->_tpl_vars['lng']['lbl_banner_system']; ?>
</a>
<?php endif; ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/html_catalog.php"><?php echo $this->_tpl_vars['lng']['lbl_html_catalog']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['News_Management']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/news.php"><?php echo $this->_tpl_vars['lng']['lbl_news_management']; ?>
</a>
<?php endif; ?>
<?php if ($this->_tpl_vars['active_modules']['Adv_Mailchimp_Subscription']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/mailchimp_news.php"><?php echo $this->_tpl_vars['lng']['lbl_mailchimp_news_management']; ?>
</a>
<?php endif; ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/file_edit.php"><?php echo $this->_tpl_vars['lng']['lbl_edit_templates']; ?>
</a>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/file_manage.php"><?php echo $this->_tpl_vars['lng']['lbl_files']; ?>
</a>
<?php if ($this->_tpl_vars['active_modules']['Survey']): ?>
<a href="<?php echo $this->_tpl_vars['catalogs']['admin']; ?>
/surveys.php"><?php echo $this->_tpl_vars['lng']['lbl_survey_surveys']; ?>
</a>
<?php endif; ?>
</div>
</li>

<?php if ($this->_tpl_vars['active_modules']['XAffiliate']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/menu_affiliate.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['active_modules']['Kayako_Connector'] != ""): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Kayako_Connector/admin/menu_kayako.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/help.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/goodies.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['active_modules']['HighCharts'] != ""): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/HighCharts/admin/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

</ul>