{*
$Id: signin_provider_notif.tpl,v 1.1 2010/05/31 10:35:32 igoryan Exp $
vim: set ts=2 sw=2 sts=2 et:
*}
{include file="mail/html/mail_header.tpl"}

<br />{include file="mail/salutation.tpl" title=$userinfo.title firstname=$userinfo.firstname lastname=$userinfo.lastname}

<br />{$lng.eml_signin_provider_notification}

<br />{$lng.lbl_profile_details}:

{if $config.Email.show_passwords_in_user_notificat eq 'Y'}
{include file="mail/html/profile_data.tpl" show_pwd="Y"}
{else}
{include file="mail/html/profile_data.tpl"}
{/if}

{include file="mail/html/signature.tpl"}

