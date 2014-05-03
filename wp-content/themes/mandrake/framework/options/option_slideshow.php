<?php
$options = array(
	array(
		"name" => __("Slideshow","mandrake_theme"),
		"type" => "title"
	),
	array(
		"name" => __("Nivo Slider Settings","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Transition Effects","mandrake_theme"),
			"desc" => __("Select which effect to use on the slideshow.","mandrake_theme"),
			"id" => "nivo_effect",
			"default" => "random",
			"options" => array(
				"random" => "random",
				"sliceDown" => "sliceDown",
				"sliceDownLeft" => "sliceDownLeft",
				"sliceUp" => "sliceUp",
				"sliceUpLeft" => "sliceUpLeft",
				"sliceUpDown" => "sliceUpDown",
				"sliceUpDownLeft" => "sliceUpDownLeft",
				"fold" => "fold",
				"fade" => "fade"
			),
			"type" => "select",
		),
		array(
			"name" => __("Animation Speed","mandrake_theme"),
			"desc" => __("Insert your animation transition speed here (milliseconds).","mandrake_theme"),
			"id" => "nivo_speed",
			"default" => "500",
			"type" => "text"
		),
		array(
			"name" => __("Pause Time","mandrake_theme"),
			"desc" => __("Insert your slide pause time speed here (milliseconds).","mandrake_theme"),
			"id" => "nivo_pause",
			"default" => "4000",
			"type" => "text"
		),
		array(
			"name" => __("Next & Prev Buttons","mandrake_theme"),
			"desc" => __("If you don't want slideshow next & prev buttons, un-check the button.","mandrake_theme"),
			"id" => "nivo_buttons",
			"default" => "1",
			"type" => "toggle"
		),
	array(
		"type" => "end"
	),
	array(
		"name" => __("3D Slider Settings","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Transition Effects","mandrake_theme"),
			"desc" => __("Select which effect to use on the slideshow.","mandrake_theme"),
			"id" => "3d_effect",
			"default" => "easeInOutCubic",
			"options" => array(
				"linear" => 'linear',
				"easeInSine" => 'easeInSine',
				"easeOutSine" => 'easeOutSine',
				"easeInOutSine" => 'easeInOutSine',
				"easeInCubic" => 'easeInCubic',
				"easeOutCubic" => 'easeOutCubic',
				"easeInOutCubic" => 'easeInOutCubic',
				"easeOutInCubic" => 'easeOutInCubic',
				"easeInQuint" => 'easeInQuint',
				"easeOutQuint" => 'easeOutQuint',
				"easeInOutQuint" => 'easeInOutQuint',
				"easeOutInQuint" => 'easeOutInQuint',
				"easeInCirc" => 'easeInCirc',
				"easeOutCirc" => 'easeOutCirc',
				"easeInOutCirc" => 'easeInOutCirc',
				"easeOutInCirc" => 'easeOutInCirc',
				"easeInBack" => 'easeInBack',
				"easeOutBack" => 'easeOutBack',
				"easeInOutBack" => 'easeInOutBack',
				"easeOutInBack" => 'easeOutInBack',
				"easeInQuad" => 'easeInQuad',
				"easeOutQuad" => 'easeOutQuad',
				"easeInOutQuad" => 'easeInOutQuad',
				"easeOutInQuad" => 'easeOutInQuad',
				"easeInQuart" => 'easeInQuart',
				"easeOutQuart" => 'easeOutQuart',
				"easeInOutQuart" => 'easeInOutQuart',
				"easeOutInQuart" => 'easeOutInQuart',
				"easeInExpo" => 'easeInExpo',
				"easeOutExpo" => 'easeOutExpo',
				"easeInOutExpo" => 'easeInOutExpo',
				"easeOutInExpo" => 'easeOutInExpo',
				"easeInElastic" => 'easeInElastic',
				"easeOutElastic" => 'easeOutElastic',
				"easeInOutElastic" => 'easeInOutElastic',
				"easeOutInElastic" => 'easeOutInElastic',
				"easeInBounce" => 'easeInBounce',
				"easeOutBounce" => 'easeOutBounce',
				"easeInOutBounce" => 'easeInOutBounce',
				"easeOutInBounce" => 'easeOutInBounce',
			),
			"type" => "select",
		),
		array(
			"name" => __("Animation Speed","mandrake_theme"),
			"desc" => __("Insert your animation transition speed here (seconds).","mandrake_theme"),
			"id" => "3d_speed",
			"default" => "2",
			"type" => "text"
		),
		array(
			"name" => __("Pause Time","mandrake_theme"),
			"desc" => __("Insert your slide pause time speed here (seconds).","mandrake_theme"),
			"id" => "3d_pause",
			"default" => "4",
			"type" => "text"
		),
	array(
		"type" => "end"
	),
	array(
		"name" => __("Accordion Slider Settings","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Easing Effects","mandrake_theme"),
			"desc" => __("Select which easing to use on the slideshow.","mandrake_theme"),
			"id" => "accordion_effect",
			"default" => "swing",
			"options" => array(
				"linear" => 'linear',
				"swing" => 'swing',
				"easeInQuad" => 'easeInQuad',
				"easeOutQuad" => 'easeOutQuad',
				"easeInOutQuad" => 'easeInOutQuad',
				"easeInCubic" => 'easeInCubic',
				"easeOutCubic" => 'easeOutCubic',
				"easeInOutCubic" => 'easeInOutCubic',
				"easeInQuart" => 'easeInQuart',
				"easeOutQuart" => 'easeOutQuart',
				"easeInOutQuart" => 'easeInOutQuart',
				"easeInQuint" => 'easeInQuint',
				"easeOutQuint" => 'easeOutQuint',
				"easeInOutQuint" => 'easeInOutQuint',
				"easeInSine" => 'easeInSine',
				"easeOutSine" => 'easeOutSine',
				"easeInOutSine" => 'easeInOutSine',
				"easeInExpo" => 'easeInExpo',
				"easeOutExpo" => 'easeOutExpo',
				"easeInOutExpo" => 'easeInOutExpo',
				"easeInCirc" => 'easeInCirc',
				"easeOutCirc" => 'easeOutCirc',
				"easeInOutCirc" => 'easeInOutCirc',
				"easeInElastic" => 'easeInElastic',
				"easeOutElastic" => 'easeOutElastic',
				"easeInOutElastic" => 'easeInOutElastic',
				"easeInBack" => 'easeInBack',
				"easeOutBack" => 'easeOutBack',
				"easeInOutBack" => 'easeInOutBack',
				"easeInBounce" => 'easeInBounce',
				"easeOutBounce" => 'easeOutBounce',
				"easeInOutBounce" => 'easeInOutBounce'
			),
			"type" => "select",
		),
		array(
			"name" => __("Easing Speed","mandrake_theme"),
			"desc" => __("Insert your easing speed here (milliseconds).","mandrake_theme"),
			"id" => "accordion_speed",
			"default" => "600",
			"type" => "text"
		),
	array(
		"type" => "end"
	),
	array(
		"name" => __("Anything Slider Settings","mandrake_theme"),
		"type" => "start"
	),
		array(
			"name" => __("Caption position","mandrake_theme"),
			"desc" => __("Select which caption position to use on the slideshow.","mandrake_theme"),
			"id" => "anything_position",
			"default" => "bottom",
			"options" => array(
				"left" => __("Left","mandrake_theme"),
				"right" => __("Right","mandrake_theme"),
				"bottom" => __("Bottom","mandrake_theme"),
			),
			"type" => "select"
		),
		array(
			"name" => __("Easing Effects","mandrake_theme"),
			"desc" => __("Select which easing to use on the slideshow.","mandrake_theme"),
			"id" => "anything_effect",
			"default" => "swing",
			"options" => array(
				"linear" => 'linear',
				"swing" => 'swing',
				"easeInQuad" => 'easeInQuad',
				"easeOutQuad" => 'easeOutQuad',
				"easeInOutQuad" => 'easeInOutQuad',
				"easeInCubic" => 'easeInCubic',
				"easeOutCubic" => 'easeOutCubic',
				"easeInOutCubic" => 'easeInOutCubic',
				"easeInQuart" => 'easeInQuart',
				"easeOutQuart" => 'easeOutQuart',
				"easeInOutQuart" => 'easeInOutQuart',
				"easeInQuint" => 'easeInQuint',
				"easeOutQuint" => 'easeOutQuint',
				"easeInOutQuint" => 'easeInOutQuint',
				"easeInSine" => 'easeInSine',
				"easeOutSine" => 'easeOutSine',
				"easeInOutSine" => 'easeInOutSine',
				"easeInExpo" => 'easeInExpo',
				"easeOutExpo" => 'easeOutExpo',
				"easeInOutExpo" => 'easeInOutExpo',
				"easeInCirc" => 'easeInCirc',
				"easeOutCirc" => 'easeOutCirc',
				"easeInOutCirc" => 'easeInOutCirc',
				"easeInElastic" => 'easeInElastic',
				"easeOutElastic" => 'easeOutElastic',
				"easeInOutElastic" => 'easeInOutElastic',
				"easeInBack" => 'easeInBack',
				"easeOutBack" => 'easeOutBack',
				"easeInOutBack" => 'easeInOutBack',
				"easeInBounce" => 'easeInBounce',
				"easeOutBounce" => 'easeOutBounce',
				"easeInOutBounce" => 'easeInOutBounce'
			),
			"type" => "select",
		),
		array(
			"name" => __("Animation Speed","mandrake_theme"),
			"desc" => __("Insert your animation transition speed here (milliseconds).","mandrake_theme"),
			"id" => "anything_speed",
			"default" => "600",
			"type" => "text"
		),
		array(
			"name" => __("Pause Time","mandrake_theme"),
			"desc" => __("Insert your slide pause time speed here (milliseconds).","mandrake_theme"),
			"id" => "anything_pause",
			"default" => "3000",
			"type" => "text"
		),
		array(
			"name" => __("Slideshow Autoplay","mandrake_theme"),
			"desc" => __("If you don't want slideshow autoplay, un-check the button.","mandrake_theme"),
			"id" => "anything_autoplay",
			"default" => 1,
			"type" => "toggle"
		),
	array(
		"type" => "end"
	),
);

return array (
	"name" => "slideshow",
	"options" => $options
);

?>