<?php
//array_shift($product_info['highchart']);
//array_pop($product_info['highchart']);  /******** to remove zero from "highchart field" in product table**********/
//$ac=0;

foreach($product_info['highchart'] as $ht => $hcht)
{ 
$hcquery = func_query_first("SELECT * FROM  `hc_chart` WHERE  `id` = '$hcht' AND  `avail` LIKE  'Y'");
$hcquery['dataseries'] = func_query("SELECT * FROM `$hcquery[chart_Table]` where customer_id='$user_account[id]'");
//if(!empty($hcquery['dataseries'])){
//$ac++;
//}
$hcquery['series'] = explode(',',$hcquery['series']);
//echo $hcquery['series_setting'];
//$search  = "data:{";
//$replace = "data:{$sfield}";
//$new     = str_replace($search, $replace, $hcquery['series_setting']);
//
echo "<pre>";

print_r($hcquery); 
echo "<br/>";
//echo "*****************************************";
foreach($hcquery['series'] as $se=>$ses)
{
foreach($hcquery['dataseries'] as $ds1=>$dseries1)
{
 $sfield .=  $dseries1[$ses].",";  
}
$sfield = rtrim($sfield, ",");

$search  = "name: 'null'";
$replace = "name: '".$ses."'";
$sries .=str_replace($search, $replace, $hcquery['series_setting']);

$search  = "name: 'null'";
$replace = "name: '".$ses."'";
$sries .=str_replace($search, $replace, $hcquery['series_setting']);
//echo $new; echo "<br/>";
//  $sries .="{name:'".$ses."',data: [".$sfield."]},";
$sfield = '';
}

//echo $sries; exit;
foreach($hcquery[dataseries] as $ds=>$dseries)
{
$xfield .= $dseries[$hcquery['X-Axis_field']].",";
$yfield .=  "'".$dseries[$hcquery['Y-Axis_field']]."'".",";
}
$xfield = rtrim($xfield, ",");
$yfield = rtrim($xfield, ",");

$xsearch  = "categories: 'null'";
$xreplace = "categories: ['".$xfield."']";
$x = str_replace($xsearch, $xreplace, $hcquery['xAxis__setting']);


$hcquery[chart_setting] .= "xAxis: { $x },yAxis: {min: 0,title: {text: 'Population (millions)',align: 'high'},labels: {overflow: 'justify'}},series: [$sries]";

$hcquery_chart[$ht][chart_setting] = $hcquery[chart_setting];
$hcquery[chart_setting] = '';
}
$smarty->assign('ac', $ac);/**** customer with no charts  ****/



$smarty->assign('hcquery_chart', $hcquery_chart);
?>
