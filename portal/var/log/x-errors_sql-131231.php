<?php die(); 
// Should you require our technical assistance with the error logs troubleshooting feel free to contact us through the
// personal HelpDesk at https://secure.x-cart.com/customer.php or email us on support@x-cart.com
//
// Technical support service can be purchased at http://www.x-cart.com/technical-support.html
?>
[31-Dec-2013 00:10:26] SQL error:
    Site        : http://portal.dashfacts.com
    Remote IP   : 223.30.44.58
    Logged as   : fathima.saadhiya@mercuryminds.com
    SQL query   : DESCRIBE 
    Error code  : 1064
    Description : You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1
Request URI: /admin/highchart.php?mode=ds_table
Backtrace:
/home/ced1968/public_html/portal/include/func/func.db.php:320
/home/ced1968/public_html/portal/include/func/func.db.php:217
/home/ced1968/public_html/portal/include/func/func.db.php:600
/home/ced1968/public_html/portal/modules/HighCharts/admin/hc_ds_table.php:2
/home/ced1968/public_html/portal/admin/highchart.php:31

-------------------------------------------------
[31-Dec-2013 06:49:51] SQL error:
    Site        : http://portal.dashfacts.com
    Remote IP   : 223.30.44.58
    Logged as   : fathima.saadhiya@mercuryminds.com
    SQL query   : DESCRIBE 
    Error code  : 1064
    Description : You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1
Request URI: /admin/highchart.php?mode=table&tablename=
Backtrace:
/home/ced1968/public_html/portal/include/func/func.db.php:320
/home/ced1968/public_html/portal/include/func/func.db.php:217
/home/ced1968/public_html/portal/include/func/func.db.php:600
/home/ced1968/public_html/portal/modules/HighCharts/admin/hc_table.php:2
/home/ced1968/public_html/portal/admin/highchart.php:19

-------------------------------------------------
