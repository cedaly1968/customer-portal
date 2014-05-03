<?php die(); 
// Should you require our technical assistance with the error logs troubleshooting feel free to contact us through the
// personal HelpDesk at https://secure.x-cart.com/customer.php or email us on support@x-cart.com
//
// Technical support service can be purchased at http://www.x-cart.com/technical-support.html
?>
[03-Feb-2014 23:55:46] SQL error:
    Site        : http://portal.dashfacts.com
    Remote IP   : 24.95.51.173
    Logged as   : cedaly@brydenroad.com
    SQL query   : SELECT * FROM `` where customer_id='7'
    Error code  : 1103
    Description : Incorrect table name ''
Request URI: //product.php?productid=4
Backtrace:
/home/ced1968/public_html/portal/include/func/func.db.php:320
/home/ced1968/public_html/portal/include/func/func.db.php:217
/home/ced1968/public_html/portal/include/func/func.db.php:516
/home/ced1968/public_html/portal/modules/HighCharts/customer/hc_customer_chart.php:5
/home/ced1968/public_html/portal/product.php:101
/home/ced1968/public_html/portal/dispatcher.php:153

-------------------------------------------------
