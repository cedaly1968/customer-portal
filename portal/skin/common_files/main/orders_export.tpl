{*
c65e333f1ad397babfb0c0c12c0d4b764081f064, v3 (xcart_4_5_0), 2012-04-25 06:54:48, orders_export.tpl, ferz
vim: set ts=2 sw=2 sts=2 et:
*}
{foreach from=$orders item=item}
{if $item.gcid eq ""}
{$item.orderid}{$delimiter}{$item.productid}{$delimiter}{$item.productcode}{$delimiter}{$item.product}{$delimiter}{$item.product_options}{$delimiter}{$item.price}{$delimiter}{$item.amount}{$delimiter}{$item.login}{$delimiter}{$item.total}{$delimiter}{$item.discount}{$delimiter}{$item.coupon}{$delimiter}{$item.coupon_discount}{$delimiter}{$item.shippingid}{$delimiter}{$item.shipping_method}{$delimiter}{$item.tracking}{$delimiter}{$item.shipping_cost}{$delimiter}{$item.tax}{$delimiter}{$item.date}{$delimiter}{$item.status}{$delimiter}{$item.payment_method}{$delimiter}{$item.flag}{$delimiter}{$item.notes}{$delimiter}{$item.customer_notes}{$delimiter}{$item.details}{$delimiter}{$item.customer}{$delimiter}{$item.title}{$delimiter}{$item.firstname}{$delimiter}{$item.lastname}{$delimiter}{$item.company}{$delimiter}{$item.b_title}{$delimiter}{$item.b_firstname}{$delimiter}{$item.b_lastname}{$delimiter}{$item.b_address}{$delimiter}{$item.b_address_2}{$delimiter}{$item.b_city}{$delimiter}{$item.b_state}{$delimiter}{$item.b_country}{$delimiter}{include file="main/zipcode.tpl" val=$item.b_zipcode zip4=$item.b_zip4 static=true is_csv_export=Y}{$delimiter}{$item.b_phone}{$delimiter}{$item.s_title}{$delimiter}{$item.s_firstname}{$delimiter}{$item.s_lastname}{$delimiter}{$item.s_address}{$delimiter}{$item.s_address_2}{$delimiter}{$item.s_city}{$delimiter}{$item.s_state}{$delimiter}{$item.s_country}{$delimiter}{include file="main/zipcode.tpl" val=$item.s_zipcode zip4=$item.s_zip4 static=true is_csv_export=Y}{$delimiter}{$item.s_phone}{$delimiter}{$item.fax}{$delimiter}{$item.url}{$delimiter}{$item.email}
{else}
{$item.orderid}{$delimiter}{$item.gcid}{$delimiter}{$item.recipient}{$delimiter}{$item.send_via}{$delimiter}{$item.recipient_email}{$delimiter}{$item.recipient_firstname}{$delimiter}{$item.recipient_lastname}{$delimiter}{$item.recipient_address}{$delimiter}{$item.recipient_address_2}{$delimiter}{$item.recipient_city}{$delimiter}{$item.recipient_state}{$delimiter}{include file="main/zipcode.tpl" val=$item.recipient_zipcode zip4=$item.recipient_zip4 static=true is_csv_export=Y}{$delimiter}{$item.recipient_country}{$delimiter}{$item.recipient_phone}{$delimiter}{$item.message}{$delimiter}{$item.amount}{$delimiter}{$item.login}{$delimiter}{$item.total}{$delimiter}{$item.discount}{$delimiter}{$item.coupon}{$delimiter}{$item.coupon_discount}{$delimiter}{$item.shippingid}{$delimiter}{$item.shipping_method}{$delimiter}{$item.tracking}{$delimiter}{$item.shipping_cost}{$delimiter}{$item.tax}{$delimiter}{$item.date}{$delimiter}{$item.status}{$delimiter}{$item.payment_method}{$delimiter}{$item.flag}{$delimiter}{$item.notes}{$delimiter}{$item.customer_notes}{$delimiter}{$item.details}{$delimiter}{$item.customer}{$delimiter}{$item.title}{$delimiter}{$item.firstname}{$delimiter}{$item.lastname}{$delimiter}{$item.company}{$delimiter}{$item.b_title}{$delimiter}{$item.b_firstname}{$delimiter}{$item.b_lastname}{$delimiter}{$item.b_address}{$delimiter}{$item.b_address_2}{$delimiter}{$item.b_city}{$delimiter}{$item.b_state}{$delimiter}{$item.b_country}{$delimiter}{include file="main/zipcode.tpl" val=$item.b_zipcode zip4=$item.b_zip4 static=true is_csv_export=Y}{$delimiter}{$item.b_phone}{$delimiter}{$item.s_title}{$delimiter}{$item.s_firstname}{$delimiter}{$item.s_lastname}{$delimiter}{$item.s_address}{$delimiter}{$item.s_address_2}{$delimiter}{$item.s_city}{$delimiter}{$item.s_state}{$delimiter}{$item.s_country}{$delimiter}{include file="main/zipcode.tpl" val=$item.s_zipcode zip4=$item.s_zip4 static=true}{$delimiter}{$item.s_phone}{$delimiter}{$item.fax}{$delimiter}{$item.url}{$delimiter}{$item.email}
{/if}
{/foreach}