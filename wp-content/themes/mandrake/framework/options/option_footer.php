<?php

$options = array(
	array(
		"name" => __("Footer","mandrake_theme"),
		"type" => "title"
	),
	array(
		"name" => __("Twitter","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Display Twitter Bar","mandrake_theme"),
			"desc" => __("If you don't want a twitter bar, un-check the button.","mandrake_theme"),
			"id" => "display_twitter",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Twitter Username","mandrake_theme"),
			"desc" => __("Insert your twitter username here.","mandrake_theme"),
			"id" => "twitter_username",
			"default" => "mojo_themes",
			"type" => "text"
		),
		array(
			"name" => __("Twitter Tweets Count","mandrake_theme"),
			"desc" => __("Insert your twitter tweets count here.","mandrake_theme"),
			"id" => "twitter_count",
			"default" => "5",
			"type" => "text"
		),
		array(
			"name" => __("Display Footer","mandrake_theme"),
			"desc" => __("If you don't want a footer, un-check the button.","mandrake_theme"),
			"id" => "display_footer",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Display Sub Footer","mandrake_theme"),
			"desc" => __("If you don't want a sub footer, un-check the button.","mandrake_theme"),
			"id" => "display_sub_footer",
			"default" => 1,
			"type" => "toggle"
		),
		array(
			"name" => __("Footer Column Layout","mandrake_theme"),
			"desc" => __("Select which layout to use on the footer.","mandrake_theme"),
			"id" => "footer_layout",
			"default" => "4",
			"options" => array(
				"2" => "Two Column",
				"3" => "Three Column",
				"4" => "Four Column",
				"5" => "Five Column",
				"6" => "Six Column",
			),
			"type" => "select"
		),
		array(
			"name" => __("Footer Copyright Text","mandrake_theme"),
			"desc" => __("Insert your copyright text here.","mandrake_theme"),
			"id" => "footer_copyright",
			"default" => 'Copyright &copy; 2011 <a href="http://www.wordpressmonsters.com/">Wordpressmonsters.com</a>. All Rights Reserved.',
			"type" => "textarea"
		),
	array(
		"type" => "end"
	),
);

return array (
	'name' => "footer",
	'options' => $options
);

?>