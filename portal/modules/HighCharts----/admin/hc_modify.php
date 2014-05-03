<?php
$que = func_query_first("select * from hc_chart where `id` = '$chart_edit_id'");
echo $que[chart_setting];
 

echo "<pre>";
print_r($que);
exit;
?>
