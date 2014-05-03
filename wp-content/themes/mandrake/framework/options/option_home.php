<?php
$options = array(
	array(
		"name" => __("Homepage","mandrake_theme"),
		"type" => "title"
	),
	array(
		"name" => __("General","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Layout","mandrake_theme"),
			"desc" => "Select which layout to use on the home page.",
			"id" => "theme_layout",
			"default" => "full",
			"options" => array(
				"full" => __("Full Width","mandrake_theme"),
				"right" => __("Right Sidebar","mandrake_theme"),
				"left" => __("Left Sidebar","mandrake_theme"),
			),
			"type" => "select"
		),
		array(
			"name" => __("Display Slide Show","mandrake_theme"),
			"desc" => __("If you don't want a homepage slide show, un-check the button.","mandrake_theme"),
			"id" => "display_slideshow",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Display Portfolio Slider","mandrake_theme"),
			"desc" => __("If you don't want a home page portfolio slider, un-check the button.","mandrake_theme"),
			"id" => "display_slider",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Portfolio Slider Category","mandrake_theme"),
			"desc" => __("Select which portfolio category to use on the portfolio slider.","mandrake_theme"),
			"id" => "portfolio_category",
			"default" => "",
			"type" => "portfolio_category"
		),
		array(
			"name" => __("Display Teaser","mandrake_theme"),
			"desc" => __("If you don't want a home page teaser, un-check the button.","mandrake_theme"),
			"id" => "display_teaser",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Teaser Text","mandrake_theme"),
			"desc" => __("Insert your teaser text here.","mandrake_theme"),
			"id" => "teaser_text",
			"default" => "<h2>Mandrake premium is perfect for corporate or business.</h2><h5>A Premium Wordpress solution with a friendly structure, customizable and extensible.</h5>",
			"type" => "textarea"
		),
		array(
			"name" => __("Teaser Button Text","mandrake_theme"),
			"desc" =>__("Insert your teaser button text here.","mandrake_theme"),
			"id" => "teaser_button",
			"default" => "Buy Now",
			"type" => "text"
		),
		array(
			"name" => __("Teaser Button ULR","mandrake_theme"),
			"desc" =>__( "Insert the full URL (include <code>http://</code>) of your teaser button here.","mandrake_theme"),
			"id" => "teaser_url",
			"default" => "http://www.mojo-themes.com/item/mandrake-premium-wordpress-theme/",
			"type" => "text"
		),
	array(
		"type" => "end"
	),
);

return array (
	'name' => "homepage",
	'options' => $options
);

?>