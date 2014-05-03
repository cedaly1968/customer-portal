<?php
// Get Data	
$name = strip_tags($_POST['name']);
$email = strip_tags($_POST['email']);
$toemail = strip_tags($_POST['toemail']);
$subject = strip_tags($_POST['subject']);
$message = strip_tags($_POST['message']);

// Send Message
mail( $toemail, $subject,
"Name: $name\n\nEmail: $email\n\nMessage: $message\n",
"From: $name <$email>" );
?>
