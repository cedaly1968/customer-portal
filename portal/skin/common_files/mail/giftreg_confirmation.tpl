{*
850e5138e855497e58a9e99e00c2e8e04e3f7234, v1 (xcart_4_4_0_beta_2), 2010-05-21 08:31:50, giftreg_confirmation.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}
{include file="mail/mail_header.tpl"}


{include file="mail/salutation.tpl" salutation=$recipient_data.recipient_name}

{$lng.eml_giftreg_confirmation_msg|substitute:"sender":"`$userinfo.title` `$userinfo.firstname` `$userinfo.lastname`"}

_____________________________________________________________________

{$lng.lbl_event}: {$event_data.title}
_____________________________________________________________________

{$lng.eml_giftreg_click_to_confirm}:  {$http_customer_location}/giftregs.php?cc={$confirmation_code}

{$lng.eml_giftreg_click_to_decline}:  {$http_customer_location}/giftregs.php?cc={$decline_code}


{include file="mail/signature.tpl"}
