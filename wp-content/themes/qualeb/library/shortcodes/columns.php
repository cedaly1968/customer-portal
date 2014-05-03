<?php
/**
 * Columns Shortcodes
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
 
function column_one_half($atts, $content = null){
	return '<div class="one_half">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_half", "column_one_half");		

function column_one_third($atts, $content = null){
	return '<div class="one_third">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_third", "column_one_third");		

function column_two_third($atts, $content = null){
	return '<div class="two_third">' . do_shortcode($content) . '</div>';
	}
add_shortcode("two_third", "column_two_third");	
	
function column_one_fourth($atts, $content = null){
	return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_fourth", "column_one_fourth");		

function column_three_fourth($atts, $content = null){
	return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
	}
add_shortcode("three_fourth", "column_three_fourth");		

function column_one_fifth($atts, $content = null){
	return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_fifth", "column_one_fifth");		

function column_two_fifth($atts, $content = null){
	return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
	}
add_shortcode("two_fifth", "column_two_fifth");	
	
function column_three_fifth($atts, $content = null){
	return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
	}
add_shortcode("three_fifth", "column_three_fifth");		

function column_four_fifth($atts, $content = null){
	return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
	}
add_shortcode("four_fifth", "column_four_fifth");		

function column_one_sixth($atts, $content = null){
	return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_sixth", "column_one_sixth");		

function column_five_sixth($atts, $content = null){
	return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
	}
add_shortcode("five_sixth", "column_five_sixth");		

function column_one_half_last($atts, $content = null){
	return '<div class="one_half last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_half_last", "column_one_half_last");		

function column_one_third_last($atts, $content = null){
	return '<div class="one_third last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_third_last", "column_one_third_last");		

function column_two_third_last($atts, $content = null){
	return '<div class="two_third last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("two_third_last", "column_two_third_last");	
	
function column_one_fourth_last($atts, $content = null){
	return '<div class="one_fourth last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_fourth_last", "column_one_fourth_last");		

function column_three_fourth_last($atts, $content = null){
	return '<div class="three_fourth last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("three_fourth_last", "column_three_fourth_last");		

function column_one_fifth_last($atts, $content = null){
	return '<div class="one_fifth last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_fifth_last", "column_one_fifth_last");		

function column_two_fifth_last($atts, $content = null){
	return '<div class="two_fifth last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("two_fifth_last", "column_two_fifth_last");	
	
function column_three_fifth_last($atts, $content = null){
	return '<div class="three_fifth last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("three_fifth_last", "column_three_fifth_last");		

function column_four_fifth_last($atts, $content = null){
	return '<div class="four_fifth last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("four_fifth_last", "column_four_fifth_last");		

function column_one_sixth_last($atts, $content = null){
	return '<div class="one_sixth last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("one_sixth_last", "column_one_sixth_last");		

function column_five_sixth_last($atts, $content = null){
	return '<div class="five_sixth last">' . do_shortcode($content) . '</div>';
	}
add_shortcode("five_sixth_last", "column_five_sixth_last");		


?>