{*
850e5138e855497e58a9e99e00c2e8e04e3f7234, v1 (xcart_4_4_0_beta_2), 2010-05-21 08:31:50, register_newslists.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.News_Management and $newslists}

{if $hide_header eq ""}
      <tr>
        <td class="register-section-title" colspan="3">
          <div>
            <label>{$lng.lbl_newsletter}</label>
          </div>
        </td>
      </tr>
{/if}

      <tr>
        <td colspan="3">{$lng.lbl_newsletter_signup_text}</td>
      </tr>

      <tr>
        <td colspan="2">&nbsp;</td>
        <td>

{foreach from=$newslists item=n}
{assign var="listid" value=$n.listid}
          <div class="news-register-item">
            <label>
              <input type="checkbox" class="exclude-style" name="subscription[{$n.listid}]"{if $subscription[$listid] ne ""} checked="checked"{/if} />
              {$n.name}
            </label>
            <br />
            <span>{$n.descr}</span>
          </div>
{/foreach}

        </td>
      </tr>

{/if}
