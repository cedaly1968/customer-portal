<?php
/**
 * Function swpt_testimonial_shortcode()  is used to create shortcode for plugin.
 * @param array $atts is to pass attributes to the function. 
*/
function swpt_testimonial_shortcode($atts){
	extract(shortcode_atts(array(
   		'testimonials' => '',
   		'order' => '',  
      'orderby' => '',      
      'effects' => '',
      'time' => '',
      ), $atts));
 
  $shortcodeData = swpt_widget_shortcode_output($testimonials, $order, $orderby);
  ob_start();
  ?>
	<script type="text/javascript">  
       (function(){           
            var strEffect = '<?php echo $effects; ?>';
            if(strEffect != 'none')
            {
              jQuery('.data_display').cycle({ 
                  fx: strEffect, 
                  timeout: '<?php echo $time; ?>'                
              }); 
            }
        })(jQuery);
    </script>
    <div class='data_display'>
      <?php
        echo $shortcodeData;
      ?>
		</div>
		<?php
      $shortcodeData = ob_get_contents();	
      ob_end_clean();
     return $shortcodeData;
}

/**
 * Function swpt_register_shortcodes()  is used to register shortcode.
*/
function swpt_register_shortcodes(){
	add_shortcode('swp-testimonial', 'swpt_testimonial_shortcode');
}
add_action( 'init', 'swpt_register_shortcodes');
?>