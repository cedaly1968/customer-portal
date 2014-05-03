{*
$Id: product_details.tpl,v 1.6.2.3 2010/12/15 11:57:06 aim Exp $
vim: set ts=2 sw=2 sts=2 et:
*}

<div class="clearing"></div>
{*** Mercuryminds HighCharts Integration ***} 
{if $active_modules.HighCharts ne "" && $login ne ""}
  {include file="modules/HighCharts/customer/hc_chart.tpl" cht=$chc}
{/if}
{*** Mercuryminds HighCharts Integration ***}
  
     <div class="descr"> {$product.fulldescr|default:$product.descr} </div>
