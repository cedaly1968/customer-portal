{*
2a30536f400a253c86be1a18eb00603b4ad45f18, v2 (xcart_4_5_1), 2012-06-22 11:52:57, search.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}
<div class="search">
  <div class="valign-middle">
    <form method="post" action="search.php" name="productsearchform">

      <input type="hidden" name="simple_search" value="Y" />
      <input type="hidden" name="mode" value="search" />
      <input type="hidden" name="posted_data[by_title]" value="Y" />
      <input type="hidden" name="posted_data[by_descr]" value="Y" />
      <input type="hidden" name="posted_data[by_sku]" value="Y" />
      <input type="hidden" name="posted_data[search_in_subcategories]" value="Y" />
      <input type="hidden" name="posted_data[including]" value="all" />

      {strip}

        <input type="text" name="posted_data[substring]" class="text{if not $search_prefilled.substring} default-value{/if}" value="{$search_prefilled.substring|default:$lng.lbl_enter_keyword|escape}" />
        <input type="image" src="{$ImagesDir}/spacer.gif" class="search-button" />
        <a href="search.php" class="search" rel="nofollow">{$lng.lbl_advanced_search}</a>
      {/strip}

    </form>

  </div>
</div>
