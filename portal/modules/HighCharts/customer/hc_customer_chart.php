<?php
foreach($product_info['highchart'] as $ht => $hcht)
{ 
$hcquery = func_query_first("SELECT * FROM  `hc_chart` WHERE  `id` = '$hcht' AND  `avail` LIKE  'Y'");
$hcquery['dataseries'] = func_query("SELECT * FROM `$hcquery[chart_Table]` where customer_id='$user_account[id]'");
$hcquery['series'] = explode(',',$hcquery['series']);
foreach($hcquery['series'] as $se=>$ses)
{
foreach($hcquery['dataseries'] as $ds1=>$dseries1)
{
 $sfield .=  $dseries1[$ses].",";  
}
$sfield = rtrim($sfield, ",");
$search  = "name: 'null'";
$replace = "name: '".$ses."',},";
$dsearch  = "data: {}";
$dreplace = "{ data: [$sfield]";
$hc1 =str_replace($search, $replace, $hcquery['series_setting']);
$sries .=str_replace($dsearch, $dreplace, $hc1);
$sfield = '';
}

/********** xAxis and yAxis setting **********/
foreach($hcquery[dataseries] as $ds=>$dseries)
{
$xfield .= "'".$dseries[$hcquery['X-Axis_field']]."',";
$yfield .= "'".$dseries[$hcquery['Y-Axis_field']]."',";
}

$xfield = rtrim($xfield, ",");
$yfield = rtrim($yfield, ",");

$xysearch  = "categories: 'null'";
if (strpos($hcquery['xAxis_setting'],$xysearch) !== false && $hcquery['X-Axis_field'] != "None") {
$xreplace = "categories: [".$xfield."]";
$x = str_replace($xysearch, $xreplace, $hcquery['xAxis_setting']);
}else { $x = $hcquery['xAxis_setting']; }

if (strpos($hcquery['yAxis_setting'],$xysearch) !== false && $hcquery['Y-Axis_field'] != "None") { 
$yreplace = "categories: [".$yfield."]";
$y = str_replace($xysearch, $yreplace, $hcquery['yAxis_setting']);
}else { $y = $hcquery['yAxis_setting'];}

if($x)
$hcquery[chart_setting] .= "xAxis: { $x },";
if($y)
$hcquery[chart_setting] .= "yAxis:{ $y },";
if($sries)
$hcquery[chart_setting] .= "series: [$sries]";

//$hcquery[chart_setting] .= "xAxis: { $x },yAxis:{ $y },series: [$sries]";

/********** xAxis and yAxis setting **********/

$hcquery_chart[$ht]['chart_setting'] = $hcquery[chart_setting];
$hcquery_chart[$ht]['plot_type'] = $hcquery[plot_type]; ///////////// to add certain javascript files for certain charts
//$hcquery['chart_setting'] = '';
$xfield = '';
$yfield = '';
$sries ='';
}
$smarty->assign('hcquery_chart', $hcquery_chart);
?>
