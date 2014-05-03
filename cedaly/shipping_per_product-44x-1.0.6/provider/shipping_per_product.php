<?php

/*************************************************\
| Shipping Per Product 1.0.0                      |
|                                                 |
|                                                 |
| BCS Engineering                                 |
| Copyright (c) 2006-2009 BCS Engineering,        |
| Carrie L. Saunders <support@bcsengineering.com> |
| All rights reserved.                            |
| See http://www.bcsengineering.com/license.shtml |
| for full license                                |
| For X-cart versions 4.4.X                       |
\*************************************************/

require "./auth.php";
require $xcart_dir."/include/security.php";

if(!$single_mode)
{
	$provider_condition = " AND $sql_tbl[products].provider='$login' ";
}
else
	$provider_condition = "";

include $xcart_dir."/include/shipping_per_product.php";

# Assign the current location line
$smarty->assign("location", $location);

@include $xcart_dir."/modules/gold_display.php";
func_display("provider/home.tpl",$smarty);
?>
