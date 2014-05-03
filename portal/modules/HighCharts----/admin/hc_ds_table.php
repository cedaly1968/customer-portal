<?php
if($action !='')
{
if($action == 'add')
{
$query_data = array('table_name' => $table_name, 'avail' => $avail);
$insert_table = func_array2insert ( 'hc_table', $query_data, true );
$top_message['content'] = "Table added successfully";  
}
if($action == 'update')
{
foreach($posted_values['table_options'] as $key => $tval)
{  
if($tval['availability'] == '') $tval['availability']='N';
$query_data = array ( 'table_name'=> $tval['tablename'],'avail'=> $tval['availability']);
func_array2update('hc_table', $query_data, "id='$key'");
} 
$top_message['content'] = "Table updated successfully";  
}
if($action == 'delete')
{
$delete_table = func_query ( "DELETE FROM `hc_table` WHERE `id` = $del_id");
$top_message['content'] = "Table deleted successfully";  
}
func_header_location("highchart.php?mode=ds_table");
}
$objects_per_page=10;
$total_items=func_query_first_cell("select count(*) from `hc_table`");	
if ($total_items > 0) {
require $xcart_dir."/include/navigation.php";
$table_list = func_query ( "select * from `hc_table` ORDER BY id DESC LIMIT $first_page, $objects_per_page" );
}
	$smarty->assign ("navigation_script", "highchart.php?mode=ds_table" );
	$smarty->assign ("page",$page);
	$smarty->assign ("total_items", $total_items );
	$smarty->assign ( 'table_list', $table_list );
        $smarty->assign ( 'main', 'tablelist' );
?>