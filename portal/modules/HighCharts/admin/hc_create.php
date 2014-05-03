<?php
if($chart_edit_id)
{
$post1 = func_query_first("select * from hc_chart where `id` = '$chart_edit_id'");
$post1[chartoptions] = unserialize($post1[chartoptions]);
$post1[plotoptions] = unserialize($post1[plotoptions]);
$post1[plot_type1] = $post1[plot_type];
$post1[plot_type] = $post1[plot_type_id].','.$post1[plot_type];
//echo "<pre>"; print_r($post1); exit;
$smarty->assign ('mode1','update_chart');
$smarty->assign ( 'chart_edit_id', $chart_edit_id );
$smarty->assign ( 'post1', $post1 );
/*echo "<pre>";
print_r($post1[chart_setting]);
exit;*/
}


function avail_check($optionid) {
	$avail_query1 = func_query_first ( "SELECT parent_id,attribute,pre_attribute,pre_attribute1,pre_attribute2 FROM  `hc_chart_common_fields` WHERE  `id` =$optionid" );
	foreach ( $avail_query1 as $aq ) {
		if ($aq != '') {
			$avail_query [] = func_query_first_cell ( "SELECT avail FROM  `hc_chart_common_fields` WHERE  `attribute` ='$aq'" );
		}
	}
	return $avail_query;
}
/**** Global set option variables ****/
$global_s_variables = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE `id` =17 OR `id` =18 AND  `avail` =  'Y'" );
foreach ( $global_s_variables as $gs => $gsv ) {
	$global_s_variables [$gs] ['set_options'] = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE  `parent_id` ='$gsv[attribute]' AND `avail` =  'Y'" ); 
	foreach ( $global_s_variables [$gs] ['set_options'] as $gcs => $gcps ) {
		$set = avail_check ( $gcps ['id'] );
		if (in_array ( "N", $set )) {
			unset ( $global_variables [$gs] ['set_options'] [$gcs] );
		}
	}
}
$smarty->assign ( 'global_s_variables', $global_s_variables );

/**** Global variables ****/
$global_variables = func_query ( "SELECT * FROM `hc_chart_common_fields` WHERE `parent_id` = '0' AND `id` !=10 AND `id` !=17 AND `id` !=18 AND `avail` = 'Y'" );
foreach ( $global_variables as $gv => $globall ) {
	$global_variables [$gv] ['chart_options'] = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE  `parent_id` ='$globall[attribute]' AND `avail` =  'Y'" );
	foreach ( $global_variables [$gv] ['chart_options'] as $gc => $gcp ) {
		$a = avail_check ( $gcp ['id'] );
		if (in_array ( "N", $a )) {
			unset ( $global_variables [$gv] ['chart_options'] [$gc] );
		}
	}
}
$smarty->assign ( 'global_variables', $global_variables );

/**** Plot type ****/
$global_v_plottype = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE  `parent_id` ='plotOptions' AND  `avail` =  'Y' " );
$smarty->assign ( 'global_v_plottype', $global_v_plottype );

/**** Customer ID ****/
$customer_id = func_query ( "SELECT id FROM  `xcart_customers`  WHERE  `status` = 'Y'" );
$smarty->assign ( 'customer_id', $customer_id );

/**** Data Series Table ****/
$select_table = func_query_column ( "SELECT table_name FROM `hc_table` where avail='Y'" );
$smarty->assign ( 'select_table', $select_table );

$smarty->assign ( 'main', 'hc_create' );

$global_variable_chart= func_query("SELECT * FROM  `hc_chart_common_fields`  WHERE  `parent_id` = 0 AND  `avail` =  'Y'");
foreach($global_variable_chart as $kchart=>$global_chart)
{ 
$glo_chart = $global_chart[attribute];
$global_variable_chart[$kchart][$glo_chart]= func_query("SELECT * FROM  `hc_chart_common_fields`  WHERE  `parent_id` = $global_chart[id]  AND  `avail` =  'Y'");
}









/*db_connect('localhost', 'root' , 'root');
db_select_db('ced1968_dfcts');*/
/*$modify_chart= func_query_first("select * from hc_chart_type where chart_id='$chart_id'");
require_once $modify_chart['chart_admin'];*/

/* $smarty->assign('modify_chart', $modify_chart); */

/*
*/
/*echo "<pre>";
print_r($global_variable_chart); exit;*/

/*


$smarty->assign('hc_admin_template',$modify_chart['chart_admin_file']);

*/

/*
if ($mode == 'edit') {
	if( $REQUEST_METHOD == 'POST' && !empty($config_data)){
	foreach($config_data as $cd => $cdata)
	{
		$cdata[chart_data_series] = array_filter(array_map('array_filter', $cdata[chart_data_series]));
	$serialize_series = serialize($cdata[chart_data_series]);
		$config_query = array (
			'chart_id' => $cd,
			'name' =>  $cdata['name'],
			'chart_title' => $cdata['chart_title'],
			'chart_sub_title' => $cdata['chart_sub_title'],
			'chart_data_series' => $serialize_series
		);
	func_array2update('hc_chart_config',$config_query, "id = '$type_id'");
	$top_message['content'] = func_get_langvar_by_name('msg_adm_hc_type_updated');
	}
	func_header_location('hc_modify.php?chart_id='.$chart_id);
	}	
$hc_config = func_query_first("SELECT * FROM hc_chart_config WHERE chart_id = $chart_id and id= $type_id");
$hc_config['unserialize'] = unserialize($hc_config['chart_data_series']);
$smarty->assign('chart_id',$chart_id);
$smarty->assign('type_id',$type_id);
$smarty->assign('mode','edit');
$smarty->assign('hc_config',$hc_config);
}

if($mode=='add')
{
	if( $REQUEST_METHOD == 'POST' && !empty($config_data)){
	foreach($config_data as $cd => $cdata)
	{
		
	$serialize_series = serialize($cdata[chart_data_series]);
		$config_query = array (
			'chart_id' => $cd,
			'name' =>  $cdata['name'],
			'chart_title' => $cdata['chart_title'],
			'chart_sub_title' => $cdata['chart_sub_title'],
			'chart_data_series' => $serialize_series
		);
	func_array2insert('hc_chart_config',$config_query,true);
	$top_message['content'] = func_get_langvar_by_name('msg_adm_hc_type_added');         
	}
	func_header_location('hc_modify.php?chart_id='.$chart_id);
	}	
$smarty->assign('chart_id',$chart_id);
$smarty->assign('type_id',$type_id);
$smarty->assign('mode','add');
}

if($mode=='delete')
{
func_query("DELETE FROM `hc_chart_config` WHERE `id` = '$type_id' and chart_id = '$chart_id'");
$top_message['content'] = func_get_langvar_by_name('msg_adm_hc_type_deleted');
func_header_location('hc_modify.php?chart_id='.$chart_id);
}

if($mode== ''){ $smarty->assign('mode','add'); $smarty->assign('chart_id',$chart_id);}
$hc_chart_type = func_query("SELECT * FROM hc_chart_config WHERE chart_id = $chart_id");
$smarty->assign('hc_chart_type',$hc_chart_type);

$hc_query = func_query_first("SELECT * FROM hc_chart_type WHERE chart_id = $chart_id");
$smarty->assign('hc_admin_template',$hc_query['chart_admin_file']);
$smarty->assign('hc_query',$hc_query);

$smarty->assign('main','hc_modify');

*/

?>