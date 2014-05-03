<?php
/* echo "<pre>";
print_r($posted_values); exit;

$xquery = func_query("select * from `$posted_values[Table]` where ") 
*/


foreach ( $posted_values ['chart_options'] as $kval => $cval ) {  
	if (count ( $cval ) != 1) {
		$brackts = explode ( ',', $cval ['bracket'] );
		$insert_array .= $kval . ': ' . $brackts ['0']; //// root paranthesis start
		foreach ( $cval as $cv => $cv1 ) {
			$a1 = array_keys ( $cval );
			$a = end ( $a1 );
			
			//	if($cv != 'bracket' && $cv1!='' && $cv1!='null')
			if ($cv != 'bracket' && ! is_array ( $cv1 )) {
				$insert_array .= $cv . ": '" . $cv1 . "'";
			if ($a != $cv) {
					$insert_array .= ',';
				}
			}
			if (is_array ( $cv1 )) {
				$insert_array .= insertarray ( $cv, $cv1 );
			}
		}
		$insert_array .= $brackts ['1'] . ','; //// root paranthesis ends
	}
}
if(!empty($posted_values ['plot_options']))
{
$insert_array .=  ' plotOptions: { ';
foreach ( $posted_values ['plot_options'] as $plval => $plcval ) { 
	if (count ( $cval ) != 1) {
		$brackts = explode ( ',', $plcval ['bracket'] );
		$insert_array .= $plval . ': ' . $brackts ['0']; //// root paranthesis start
		foreach ( $plcval as $pcv => $pcv1 ) {
			$pa1 = array_keys ( $plcval );
			$pa = end ( $pa1 );
			
			//	if($cv != 'bracket' && $cv1!='' && $cv1!='null')
			if ($pcv != 'bracket' && ! is_array ( $pcv1 )) {
				$insert_array .= $pcv . ": '" . $pcv1 . "'";
			if ($pa != $pcv) {
					$insert_array .= ',';
				}
			}
			if (is_array ( $pcv1 )) {
				$insert_array .= insertarray ( $pcv, $pcv1 );
			}
		}
		$insert_array .= $brackts ['1'] . ','; //// root paranthesis ends
	}
}
$insert_array .=  '},';
}
function insertarray($cvalue, $cvalue1) {
	if (count ( $cval ) != 1) {
		$brackts2 = explode ( ',', $cvalue1 ['bracket'] );
		$insert_array .= $cvalue . ': ' . $brackts2 ['0'];
		foreach ( $cvalue1 as $cvalue2 => $cvalue3 ) {
			$b1 = array_keys ( $cvalue1 );
			$b = end ( $b1 );
			if ($cvalue2 != 'bracket' && ! is_array ( $cvalue3 )) {
				$insert_array .= $cvalue2 . ": '" . $cvalue3 . "'";
				if ($b != $cvalue2) {
					$insert_array .= ',';
				}
			}
			if (is_array ( $cvalue3 )) { 
				$insert_array .= insertarray ( $cvalue2, $cvalue3 );
			}
		}
		
		
		$insert_array .= $brackts2 ['1'] . ',';
		
		return $insert_array;
	}
}
$ptype = explode(',',$posted_values ['PlotType']);
$plotyp = $ptype[1];
$insertarray = mysql_real_escape_string($insert_array);
$query_data = array ('chart_title' => $posted_values ['chart_title'], 'chart_sub_title' => $posted_values ['chart_sub_title'], 'chart_Table' => $posted_values ['Table'], 'X-Axis_field' => $posted_values ['X-Axis'] ['X'], 'X-Axis_label' => $posted_values ['X-Axis'] ['Label'], 'Y-Axis_field' => $posted_values ['Y-Axis'] ['Y'], 'Y-Axis_label' => $posted_values ['Y-Axis'] ['Label'], 'series' => $posted_values ['Y-Axis'] ['series'], 'plot_type' => $plotyp, 'chart_setting' => $insertarray , 'chartoptions' => serialize($posted_values['chart_options']),'plotoptions' => serialize($posted_values['plot_options']));

$insert_chart = func_array2insert ( 'hc_chart', $query_data, true );
$top_message['content'] = "created successfully";  
	
func_header_location("highchart.php?mode=create");

//'customer_id' => $posted_values ['customer_id'], 

/*function insert_array($kval,$cval)
	{   
		$brackts = explode(',',$cval['bracket']);
		$insert_array .= $kval.': '.$brackts['0']."<br/>";
		
		if($kval != 'bracket')
		    {    
		     if(!is_array($cval))
		    	  $insert_array .= $kval.": '".$cval."'".','."<br/>"; 
		    	 if(is_array($cval))
			     {
			     	 $brackts1 = explode(',',$cval['bracket']);
		             $insert_array .= $key1.': '.$brackts1['0']."<br/>"; 
					  foreach ($pval1 as $key2=>$pval2)
						{ 
						   if($key2 != 'bracket')
					       $insert_array .= $key2.": '".$pval2."'".','."<br/>"; 
		                }
	                $insert_array .=$brackts1['1'].','."<br/>"; 
			     }
		    }//echo $key1."*********".$pval1;  echo "<br/>"; 
		    $insert_array .=$brackts['1'].','."<br/>"."<br/>"."<br/>"; 
	}*/

//		if($kval != 'bracket')
//		    {    
//		     if(!is_array($cval))
//		    	  $insert_array .= $kval.": '".$cval."'".','."<br/>"; 
//		    	 if(is_array($cval))
//			     {
//			     	 $brackts1 = explode(',',$cval['bracket']);
//		             $insert_array .= $key1.': '.$brackts1['0']."<br/>"; 
//					  foreach ($pval1 as $key2=>$pval2)
//						{ 
//						   if($key2 != 'bracket')
//					       $insert_array .= $key2.": '".$pval2."'".','."<br/>"; 
//		                }
//	                $insert_array .=$brackts1['1'].','."<br/>"; 
//			     }
//		    }


//exit;


?>
