{*
850e5138e855497e58a9e99e00c2e8e04e3f7234, v1 (xcart_4_4_0_beta_2), 2010-05-21 08:31:50, menu.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}
<table cellspacing="0" cellpadding="0" width="100%" class="VertMenuBorder">
  <tr>
    <td class="VertMenuTitleBox">
      <table cellspacing="0" cellpadding="0" width="100%">
        <tr>
          <td>{$link_begin}<img src="{$ImagesDir}/{if $dingbats ne ''}{$dingbats}{else}spacer.gif{/if}" class="VertMenuTitleIcon" alt="{$menu_title|escape}" />{$link_end}</td>
          <td width="100%"><font class="VertMenuTitle">{$menu_title}</font></td>
          {if $link_href}
            <td style="padding-right: 7px;"><a href="{$link_href}"><img src="{$ImagesDir}/menu_arrow.gif" alt="" /></a></td>
          {/if}
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td class="VertMenuBox">
      <table cellpadding="{$cellpadding|default:"5"}" cellspacing="0" width="100%">
        <tr>
          <td>{$menu_content}<br /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
