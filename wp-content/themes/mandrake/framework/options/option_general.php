<?php
$options = array(
	array(
		"name" => __("Settings","mandrake_theme"),
		"type" => "title"
	),
	array(
		"name" => __("General","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Theme Color","mandrake_theme"),
			"desc" => "Select which theme color to use on the web.",
			"id" => "theme_color",
			"default" => "black",
			"options" => array(
				"black" => "Black",
				"gray" => "Gray",
				"green" => "Green",
				"purple" => "Purple",
				"blue" => "Blue",
				"red" => "Red",
				"orange" => "Orange",
                                "white" => "White",
			),
			"type" => "select"
		),
		array(
			"name" => __("Website Font","mandrake_theme"),
			"desc" => "Select which font to use on the web.",
			"id" => "theme_font",
			"default" => "Maven+Pro",
			"options" => array(
				"Allerta+Stencil" => "Allerta Stencil",
				"Amaranth" => "Amaranth",
				"Anton" => "Anton",
				"Arimo" => "Arimo",
				"Arvo" => "Arvo",
				"Bentham" => "Bentham",
				"Cabin" => "Cabin",
				"Calligraffitti" => "Calligraffitti",
				"Coming+Soon" => "Coming Soon",
				"Copse" => "Copse",
				"Covered+By+Your+Grace" => "Covered By Your Grace",
				"Crafty+Girls" => "Crafty Girls",
				"Crimson+Text" => "Crimson Text",
				"Cuprum" => "Cuprum",
				"Dancing+Script" => "Dancing Script",
				"Didact+Gothic" => "Didact Gothic",
				"Droid+Sans" => "Droid Sans",
				"Droid+Serif" => "Droid Serif",
				"Gloria+Hallelujah" => "Gloria Hallelujah",
				"Inconsolata" => "Inconsolata",
				"Josefin+Slab" => "Josefin Slab",
				"Lato" => "Lato",
				"Lobster" => "Lobster",
				"Lobster+Two" => "Lobster Two",
				"Maven+Pro" => "Maven Pro",
				"Merienda+One" => "Merienda One",
				"Molengo" => "Molengo",
				"Muli" => "Muli",
				"Neuton" => "Neuton",
				"Nobile" => "Nobile",
				"Nunito" => "Nunito",
				"Old+Standard+TT" => "Old Standard TT",
				"Open+Sans" => "Open Sans",
				"Open+Sans+Condensed" => "Open Sans Condensed",
				"Orbitron" => "Orbitron",
				"Oswald" => "Oswald",
				"Pacifico" => "Pacifico",
				"Philosopher" => "Philosopher",
				"Podkova" => "Podkova",
				"PT+Sans" => "PT Sans",
				"PT+Sans+Narrow" => "PT Sans Narrow",
				"Puritan" => "Puritan",
				"Shadows+Into+Light" => "Shadows Into Light",
				"Terminal+Dosis+Light" => "Terminal Dosis Light",
				"The+Girl+Next+Door" => "The Girl Next Door",
				"Ubuntu" => "Ubuntu",
				"UnifrakturMaguntia" => "Unifraktur Maguntia",
				"Walter+Turncoat" => "Walter Turncoat",
				"Vollkorn" => "Vollkorn",
				"Yanone+Kaffeesatz" => "Yanone Kaffeesatz"
			),
			"type" => "select"
		),
		array(
			"name" => __("Website Logo","mandrake_theme"),
			"desc" => __( "Insert the full URL (include <code>http://</code>) of your logo here.","mandrake_theme"),
			"id" => "theme_logo",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Website Favicon","mandrake_theme"),
			"desc" =>__( "Insert the full URL (include <code>http://</code>) of your favicon here.","mandrake_theme"),
			"id" => "theme_favicon",
			"default" => "",
			"type" => "text"
		),
		array(
			"name" => __("Display Breadcrumbs","mandrake_theme"),
			"desc" => __("If you don't want breadcrubms, un-check the button.","mandrake_theme"),
			"id" => "display_breadcrumb",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("404 Message","mandrake_theme"),
			"desc" => __("Insert your 404 page code here.","mandrake_theme"),
			"id" => "theme_404",
			"default" => '<h2>Page not Found</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eros lorem, ultricies vel sodales sit amet, auctor nec nibh.</p><ul class="list2"><li><a href="http://www.wordpressmonsters.com/mandrake/">Home</a></li><li><a href="http://www.wordpressmonsters.com/mandrake/sitemap/">Sitemap</a></li><li><a href="http://www.wordpressmonsters.com/mandrake/contact/">Contact Us</a></li></ul>',
			"type" => "textarea"
		),
		array(
			"name" => __("Google Analytics Code","mandrake_theme"),
			"desc" => __("Insert your <a href='http://www.google.com/analytics/' target='_blank'>Google Analytics</a> tracking code here.","mandrake_theme"),
			"id" => "theme_analytics",
			"default" => "",
			"type" => "textarea"
		),
	array(
		"type" => "end"
	),
);

return array (
	'name' => "general",
	'options' => $options
);

?>