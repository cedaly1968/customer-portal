<?php
foreach($product_info['highchart'] as $ht => $hcht)
{ 
$hcquery = func_query_first("SELECT * FROM  `hc_chart` WHERE  `id` = '$hcht' AND  `avail` LIKE  'Y'");
$hcquery[dataseries] = func_query("SELECT * FROM `$hcquery[chart_Table]` where customer_id='$user_account[id]'");
$hcquery['series'] = explode(',',$hcquery['series']);

foreach($hcquery['series'] as $se=>$ses)
{
foreach($hcquery[dataseries] as $ds1=>$dseries1)
{
 $sfield .=  $dseries1[$ses].",";  
}
$sfield = rtrim($sfield, ",");
 $sries .="{name:'".$ses."',data: [".$sfield."]},";
$sfield = '';
}
foreach($hcquery[dataseries] as $ds=>$dseries)
{
$xfield .= $dseries[$hcquery['X-Axis_field']].",";
$yfield .=  "'".$dseries[$hcquery['Y-Axis_field']]."'".",";
}
$xfield = rtrim($xfield, ",");
$yfield = rtrim($xfield, ",");
$hcquery[chart_setting] .= "xAxis: {categories: [$xfield],title: {text: null}},yAxis: {min: 0,title: {text: 'Population (millions)',align: 'high'},labels: {overflow: 'justify'}},series: [$sries]";

$hcquery_chart[$ht][chart_setting] = $hcquery[chart_setting];
$hcquery[chart_setting] = '';
}
$smarty->assign('hcquery_chart', $hcquery_chart);
?>