{*
850e5138e855497e58a9e99e00c2e8e04e3f7234, v1 (xcart_4_4_0_beta_2), 2010-05-21 08:31:50, atracking_pageviews.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}
{if $statistics}

<table cellspacing="1" class="DataSheet">
<tr class="DataSheet">
  <th width="70%" align="left">{$lng.lbl_page_url}</th>
  <th width="10%">{$lng.lbl_average_time}</th>
  <th width="10%">{$lng.lbl_visits}</th>
  <th width="10%">%</th>
</tr>
{section name=num loop=$statistics}
<tr>
  <td>{inc value=$smarty.section.num.index}. <a href="{$statistics[num].page|amp}">{$statistics[num].page|truncate:70:"..."|amp}</a></td>
  <td align="center">{$statistics[num].time_avg|formatprice:false:false:0}</td>
  <td align="center">{$statistics[num].views}</td>
  <td align="center">{$statistics[num].percent|formatprice}</td>
</tr>
{/section}
</table>

<br /><br />

{$lng.txt_top_pages_views_note}

{else}

<br />
<div align="center">{$lng.txt_no_statistics}</div>

{/if}

