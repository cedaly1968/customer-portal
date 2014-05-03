<?php
ini_set('max_execution_time', 300);
/**** Global set option variables ****/
$global_s_variables = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE `id` =17 OR `id` =18" );
foreach ( $global_s_variables as $gs => $gsv ) {
	$global_s_variables [$gs] ['set_options'] = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE  `parent_id` ='$gsv[attribute]'");
}
$smarty->assign ( 'global_s_variables', $global_s_variables );

/***************** Global variables **********************/
$global_variables = func_query ( "SELECT * FROM `hc_chart_common_fields` WHERE `parent_id` = '0' AND `id` !=17 AND `id` !=18" );
foreach ( $global_variables as $gv => $globall ) {
	$global_variables [$gv] ['chart_options'] = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE  `parent_id` ='$globall[attribute]'" );
}
$smarty->assign ( 'global_variables', $global_variables );

///***************** Plot type **********************/
//$global_v_plottype = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE  `cat_id` =10 " );
//$smarty->assign ( 'global_v_plottype', $global_v_plottype );
//
//$global_v_plottype = func_query ( "SELECT * FROM  `hc_chart_common_fields` WHERE  `cat_id` =10 " );
//$smarty->assign ( 'global_v_plottype', $global_v_plottype );
//
//$chart_values = func_query ( "SELECT * FROM `hc_chart_fields` WHERE `chart_id` LIKE '%,$chart_id,%'" );
//$smarty->assign ( 'chart_values', $chart_values );


if($operation == 'update')
{ 

	foreach($posted_values['chart_options'] as $key => $cval)
	{  if($cval['availability'] == '') $cval['availability']='N';
		$query_data = array ( 'value' => $cval['value'], 'avail'=> $cval['availability']);

		func_array2update('hc_chart_common_fields', $query_data, "id='$key'");

	} 
//            $top_message['content'] = func_get_langvar_by_name('msg_adm_featproducts_upd');
          $top_message['content'] = "Updated successfully";  
	
  func_header_location("highchart.php?mode=global");
  
} 

$smarty->assign ( 'main', 'hc_global' );

?>












