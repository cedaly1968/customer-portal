<?php

require_once('../../../../../wp-load.php');

$sitename = get_bloginfo('name');
$siteurl =  get_bloginfo('siteurl');

if (isset($_POST['contact_to'])) { $contact_to = trim($_POST['contact_to']); } else { $contact_to = ''; }
if (isset($_POST['contact_name'])) { $contact_name = trim($_POST['contact_name']); } else { $contact_name = ''; }
if (isset($_POST['contact_email'])) { $contact_email = trim($_POST['contact_email']); } else { $contact_email = ''; }
if (isset($_POST['contact_message'])) { $contact_message = trim($_POST['contact_message']); } else { $contact_message = ''; }

$error = false;
if($contact_to === '' || $contact_name === '' || $contact_email === '' || $contact_message === ''){ $error = true; }
if(!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $contact_to)){ $error = true; }
if(!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $contact_email)){ $error = true; }

if($error == false){
	$subject = "$sitename message from $name";
	$body = "Site: $sitename ($siteurl) \n\nName: $contact_name \n\nEmail: $contact_email \n\nMessages: $contact_message";
	$headers = "From: $sitename <$contact_to>\r\nReply-To: $contact_email\r\n";
	wp_mail($contact_to, $subject, $body, $headers);
}

?>