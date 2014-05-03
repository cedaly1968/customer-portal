<?php

function theme_shortcode_one_half($atts, $content = null) {
   return '<div class="one-half">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_half', 'theme_shortcode_one_half');

function theme_shortcode_one_third($atts, $content = null) {
   return '<div class="one-third">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_third', 'theme_shortcode_one_third');

function theme_shortcode_one_fourth($atts, $content = null) {
   return '<div class="one-fourth">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_fourth', 'theme_shortcode_one_fourth');

function theme_shortcode_one_fifth($atts, $content = null) {
   return '<div class="one-fifth">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_fifth', 'theme_shortcode_one_fifth');

function theme_shortcode_one_sixth($atts, $content = null) {
   return '<div class="one-sixth">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_sixth', 'theme_shortcode_one_sixth');



function theme_shortcode_two_third($atts, $content = null) {
   return '<div class="two-third">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('two_third', 'theme_shortcode_two_third');

function theme_shortcode_three_fourth($atts, $content = null) {
   return '<div class="three-fourth">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('three_fourth', 'theme_shortcode_three_fourth');

function theme_shortcode_two_fifth($atts, $content = null) {
   return '<div class="two-fifth">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('two_fifth', 'theme_shortcode_two_fifth');

function theme_shortcode_three_fifth($atts, $content = null) {
   return '<div class="three-fifth">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('three_fifth', 'theme_shortcode_three_fifth');

function theme_shortcode_four_fifth($atts, $content = null) {
   return '<div class="four-fifth">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('four_fifth', 'theme_shortcode_four_fifth');

function theme_shortcode_five_sixth($atts, $content = null) {
   return '<div class="five-sixth">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('five_sixth', 'theme_shortcode_five_sixth');



function theme_shortcode_one_half_last($atts, $content = null) {
   return '<div class="one-half last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_half_last', 'theme_shortcode_one_half_last');

function theme_shortcode_one_third_last($atts, $content = null) {
   return '<div class="one-third last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_third_last', 'theme_shortcode_one_third_last');

function theme_shortcode_one_fourth_last($atts, $content = null) {
   return '<div class="one-fourth last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_fourth_last', 'theme_shortcode_one_fourth_last');

function theme_shortcode_one_fifth_last($atts, $content = null) {
   return '<div class="one-fifth last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_fifth_last', 'theme_shortcode_one_fifth_last');

function theme_shortcode_one_sixth_last($atts, $content = null) {
   return '<div class="one-sixth last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('one_sixth_last', 'theme_shortcode_one_sixth_last');



function theme_shortcode_two_third_last($atts, $content = null) {
   return '<div class="two-third last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('two_third_last', 'theme_shortcode_two_third_last');

function theme_shortcode_three_fourth_last($atts, $content = null) {
   return '<div class="three-fourth last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('three_fourth_last', 'theme_shortcode_three_fourth_last');

function theme_shortcode_two_fifth_last($atts, $content = null) {
   return '<div class="two-fifth last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('two_fifth_last', 'theme_shortcode_two_fifth_last');

function theme_shortcode_three_fifth_last($atts, $content = null) {
   return '<div class="three-fifth last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('three_fifth_last', 'theme_shortcode_three_fifth_last');

function theme_shortcode_four_fifth_last($atts, $content = null) {
   return '<div class="four-fifth last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('four_fifth_last', 'theme_shortcode_four_fifth_last');

function theme_shortcode_five_sixth_last($atts, $content = null) {
   return '<div class="five-sixth last">'. wpautop(do_shortcode(trim($content))) .'</div>';
}
add_shortcode('five_sixth_last', 'theme_shortcode_five_sixth_last');

?>