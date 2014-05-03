<?php
$tbl_struct = func_query_column ( "DESCRIBE $tablename" );
echo "<option value=''></option>";
foreach($tbl_struct as $tb_str)
{if($tb_str != 'customer_id')
echo "<option value='".$tb_str."'>".$tb_str."</option>";
}
exit;		              
?>