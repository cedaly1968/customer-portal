{*
$Id: service_head.tpl,v 1.1 2010/05/21 08:32:02 joy Exp $
vim: set ts=2 sw=2 sts=2 et:
*}
{get_title page_type=$meta_page_type page_id=$meta_page_id}
{include file="customer/meta.tpl"}
{include file="customer/service_js.tpl"}
{include file="customer/service_css.tpl"}
{if $canonical_url}
  <link rel="canonical" href="{$current_location}/{$canonical_url}" />
{/if}
{if $config.SEO.clean_urls_enabled eq "Y"}
  <base href="{$catalogs.customer}/" />
{/if}
{load_defer_code type="css"}
{load_defer_code type="js"}
<script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7/prototype.js"></script>
<script src="http://code.highcharts.com/adapters/prototype-adapter.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>