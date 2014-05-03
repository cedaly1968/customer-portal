<?php
if($action !='')
{
if($action == 'update')
{
foreach($posted_values['chartlist'] as $key => $cval)
{  
if($cval['availability'] == '') $cval['availability']='N';
$query_data = array ( 'avail'=> $cval['availability']);
func_array2update('hc_chart', $query_data, "id='$key'");
} 
$top_message['content'] = "Chart updated successfully";  
}
if($action == 'delete')
{
$delete_table = func_query ( "DELETE FROM `hc_chart` WHERE `id` = $del_id");
$top_message['content'] = "Chart deleted successfully";  
}
func_header_location("highchart.php?mode=chart");
}
$objects_per_page=10;
$total_items=func_query_first_cell("select count(*) from `hc_chart`");	
if ($total_items > 0) {
require $xcart_dir."/include/navigation.php";
$chart_list = func_query ( "select * from `hc_chart` ORDER BY id DESC LIMIT $first_page, $objects_per_page" );
}
	$smarty->assign ("navigation_script", "highchart.php?mode=chart" );
	$smarty->assign ("page",$page);
	$smarty->assign ("total_items", $total_items );
	$smarty->assign ( 'chart_list', $chart_list );
        $smarty->assign ( 'main', 'chartlist' );
?>
