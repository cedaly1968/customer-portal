{*
d535dcb897b6742472d0812607fe010967b7655e, v10 (xcart_4_4_4), 2011-09-19 11:43:35, vote_reviews.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}
{if $printable ne 'Y' or $reviews}

  {capture name=dialog}

    {if $active_modules.Socialize && $config.Socialize.soc_fb_comments_enabled eq "Y"}

      {include file="customer/subheader.tpl" title=$lng.lbl_customers_rating}
       <script type="text/javascript">
        //<![CDATA[
          document.write('<fb:like href="{$current_location}/{$canonical_url}" layout="standard" send="false" width="" show_faces="true" font=""></fb:like>');
        //]]>
      </script>
      <div class="top-margin-15">
        {include file="customer/subheader.tpl" title=$lng.lbl_customer_reviews}
        <script type="text/javascript">
        //<![CDATA[
          document.write('<fb:comments href="{$current_location}/{$canonical_url}" num_posts="5" width=""></fb:comments>');
        //]]>
        </script>
      </div>

    {else}

    {if $product.rating_data}
      {include file="customer/subheader.tpl" title=$lng.lbl_customers_rating}

      {if $active_modules.Customer_Reviews and $config.Customer_Reviews.ajax_rating eq 'Y'}
        {include file="modules/Customer_Reviews/ajax.rating.tpl" _include_once=1}
      {/if}

      {include file="modules/Customer_Reviews/vote_bar.tpl" productid=$product.productid rating=$product.rating_data}
    {/if}

    {if $config.Customer_Reviews.customer_reviews eq 'Y'}

      {include file="customer/subheader.tpl" title=$lng.lbl_customer_reviews}

      {if $reviews}

        <ul class="creviews-reviews-list">
          {foreach from=$reviews item=r}
            <li>
              {$lng.lbl_author}: <strong>{$r.email|default:$lng.lbl_unknown}</strong><br />
              {$r.message|nl2br|amp}
            </li>
          {/foreach}
        </ul>

      {else}

        <div class="creviews-reviews-list">{$lng.txt_no_customer_reviews}</div>

      {/if}

    {/if}

    {if $printable ne 'Y' and $allow_review}

      {include file="customer/subheader.tpl" title=$lng.lbl_add_your_review}

      {if $allow_add_review}

        <form method="post" action="product.php">
          <input type="hidden" name="mode" value="add_review" />
          <input type="hidden" name="productid" value='{$product.productid}' />

          <table cellspacing="1" class="data-table" summary="{$lng.lbl_add_your_review|escape}">

            <tr>
              <td class="data-name"><label for="review_author">{$lng.lbl_your_name}</label>:</td>
              <td class="data-required">*</td>
              <td>
                <input type="text" size="24" maxlength="128" name="review_author" id="review_author" value="{$review.author|amp}" />
                {if $review.author eq "" and $review.error}
                  <span class="data-required">&lt;&lt;</span>
                {/if}
              </td>
            </tr>

            <tr>
              <td class="data-name"><label for="review_message">{$lng.lbl_your_message}</label>:</td>
              <td class="data-required">*</td>
              <td>
                <textarea cols="40" rows="4" name="review_message" id="review_message">{$review.message|amp}</textarea>
                {if $review.message eq "" and $review.error}
                  <span class="data-required">&lt;&lt;</span>
                {/if}
              </td>
            </tr>

            {include file="customer/buttons/button.tpl" button_title=$lng.lbl_add_review type="input" assign="submit_button"}

            {if $active_modules.Image_Verification and $show_antibot.on_reviews eq 'Y'}
              {include file="modules/Image_Verification/spambot_arrest.tpl" mode="data-table" id=$antibot_sections.on_reviews antibot_err=$review.antibot_err button_code=$submit_button antibot_name_prefix='_on_reviews'}
            {else}
            <tr>
              <td colspan="2">&nbsp;</td>
              <td class="button-row">
                  {$submit_button}
              </td>
            </tr>
            {/if}

          </table>

        </form>

      {else}

        {$lng.txt_you_already_voted}

      {/if}

    {/if}

    {/if}

  {/capture}

  {if $nodialog}
    {$smarty.capture.dialog}
  {else}
    {include file="customer/dialog.tpl" content=$smarty.capture.dialog title=$lng.lbl_customers_feedback additional_class="creviews-dialog"}
  {/if}

{/if}
