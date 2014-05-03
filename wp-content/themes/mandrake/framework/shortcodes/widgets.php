<?php

function theme_shortcode_contact_form($atts, $content = null) {
	extract(shortcode_atts(array(
		'email' => get_bloginfo('admin_email'),
	), $atts));
    $content = '';
	$output = '<div class="contact-form-wrap">
        <div class="contact-success"><p>'. __('Your message was successfully sent. <strong>Thank You!</strong>', 'mandrake_theme') .'</p></div>
        <form class="contact-form" action="'. THEME_INCLUDES .'/sendmail.php" method="post">
			<p><input type="text" id="contact-name" name="contact_name" class="contact-name" />
			<label for="contact-name">'. __('Name *', 'mandrake_theme') .'</label></p>
			<p><input type="text" id="contact-email" name="contact_email" class="contact-email" />
			<label for="contact-email">'. __('Email *', 'mandrake_theme') .'</label></p>
			<p><textarea name="contact_message" class="contact-message" cols="20" rows="5"></textarea></p>
			<p><button type="submit" class="button small active"><span>'. __('Send Message', 'mandrake_theme') .'</span></button></p>
			<input type="hidden" value="'. $email .'" name="contact_to" class="contact-to"/>
		</form></div>';
	return trim($output);
}
add_shortcode('contact_form', 'theme_shortcode_contact_form');

function theme_shortcode_contact_info($atts, $content = null) {
	extract(shortcode_atts(array(
		'name' => '',
		'phone' => '',
		'cellphone' => '',
		'email' => '',
		'address' => '',
	), $atts));
	$output = '<ul class="contact-info">';
	if(!empty($name)){
		$output .= '<li class="person">'.$name.'</li>';
	}
	if(!empty($phone)){
		$output .= '<li class="phone">'.$phone.'</li>';
	}
	if(!empty($cellphone)){
		$output .= '<li class="mobile">'.$cellphone.'</li>';
	}
	if(!empty($email)){
		$output .= '<li class="email">'.$email.'</li>';
	}
	if(!empty($address)){
		$output .= '<li class="address">'.$address.'</li>';
	}
	$output .= '</ul>';
	return trim($output);
}
add_shortcode('contact_info', 'theme_shortcode_contact_info');

?>