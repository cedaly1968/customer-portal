<?php
require './auth.php';
require $xcart_dir.'/include/security.php';
if($mode=='create')
{
require_once $xcart_dir.'/modules/HighCharts/admin/hc_create.php';
}
if($mode=='update')
{
require_once $xcart_dir.'/modules/HighCharts/admin/hc_update.php';
}
if($mode=='global')
{
require_once $xcart_dir.'/modules/HighCharts/admin/hc_global.php';
}
if($mode=='table')
{
require_once $xcart_dir.'/modules/HighCharts/admin/hc_table.php';
}
if($mode=='plot')
{
require_once $xcart_dir.'/modules/HighCharts/admin/hc_plot.php';
}
if($mode=='chart')
{
require_once $xcart_dir.'/modules/HighCharts/admin/hc_chart_list.php';
}
if($mode=='ds_table')
{
require_once $xcart_dir.'/modules/HighCharts/admin/hc_ds_table.php';
}
if($mode=='modify')
{
require_once $xcart_dir.'/modules/HighCharts/admin/hc_modify.php';
}
if (is_readable($xcart_dir.'/modules/gold_display.php')) {
    include $xcart_dir.'/modules/gold_display.php';
}
func_display('admin/home.tpl',$smarty);
?>
