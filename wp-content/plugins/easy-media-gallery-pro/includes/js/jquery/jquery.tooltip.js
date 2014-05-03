/**
 * JQuery Tooltip Plugin
 *
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * Written by Shahrier Akram <shahrier.akram@gmail.com>
 *
 * Tooltip is a jQuery plugin implementing unobtrusive javascript interaction that appears
 * near DOM elements, wherever they may be, that require extra information. 
 *
 * Visit http://gdakram.github.com/JQuery-Tooltip-Plugin for demo.
 
The MIT License

Copyright (c) 2009 Shahrier Akram <shahrier.akram@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE. 
 
**/

(function($) {

   $.fn.tooltip = function(settings) {
     // Configuration setup
     config = { 
       'dialog_content_selector' : 'div.emgtooltip_description',
       'animation_distance' : 50,
       'opacity' : 0.85,
       'arrow_left_offset' : 70,
       'arrow_top_offset' : 50,
       'arrow_height' : 20,
       'arrow_width' : 20,
       'animation_duration_ms' : 100,
       'event_in':'mouseover',
       'event_out':'mouseout',
	   'event_down':'mousedown',
	   'event_up':'mouseup',	    
       'hover_delay' : 0
     }; 
     if (settings) $.extend(config, settings);

     /**
      * Apply interaction to all the matching elements
      **/
     this.each(function() {
       var hoverTimer;
       $(this).bind(config.event_in,function(){
         var ele = this;
         hoverTimer = setTimeout(function() { _show(ele); }, config.hover_delay)
       })
       .bind(config.event_out,function(){
         clearTimeout(hoverTimer);
         _hide(this);
       })
       .bind(config.event_down,function(){
		$('#g-img-wrap li img').css( 'cursor', 'move');		   
         clearTimeout(hoverTimer);
         _hide(this);
       })	   
       .bind(config.event_up,function(){
		   $('#g-img-wrap li img').css( 'cursor', 'pointer');
         clearTimeout(hoverTimer);
         _hide(this);
       })	 	   	   
     });
          
     /**
      * Positions the dialog box based on the target
      * element's location
      **/
     function _show(target_elm) {
       var dialog_content = config.dialog_content_selector;
       var dialog_box = _create(dialog_content);

       var is_top_right = $(target_elm).hasClass("tooltiptopright");
       var is_bottom_right = $(target_elm).hasClass("tooltipbottomright");
       var is_top = $(target_elm).hasClass("tooltiptop");
       var is_bottom = $(target_elm).hasClass("tooltipbottom");
       var has_position = is_top_right || is_bottom_right || is_top || is_bottom;
       var position;
       
       var target_elm_position = $(target_elm).offset();

       // coming from the top right
       if (is_top_right || !has_position && (target_elm_position.top < $(dialog_box).outerHeight() && target_elm_position.top >= config.arrow_top_offset)) {
         position = { 
           start : { 
             left : target_elm_position.left + $(target_elm).outerWidth() + config.animation_distance,
             top  : target_elm_position.top + ($(target_elm).outerHeight() / 2) - config.arrow_top_offset
           },
           end : {
             left : target_elm_position.left + $(target_elm).outerWidth(),
             top  : target_elm_position.top + ($(target_elm).outerHeight() / 2) - config.arrow_top_offset
           },
           arrow_class : "div.left_arrow"
         }
       }
       // coming from the bottom right
       else if (is_bottom_right || !has_position && (target_elm_position.left < config.arrow_left_offset + $(target_elm).outerWidth() && target_elm_position.top > $(dialog_box).outerHeight())) {
         position = { 
           start : { 
             left : target_elm_position.left + $(target_elm).outerWidth() + config.animation_distance,
             top  : target_elm_position.top + ($(target_elm).outerHeight() / 2) + config.arrow_top_offset - $(dialog_box).outerHeight() + config.arrow_height
           },
           end : {
             left : target_elm_position.left + $(target_elm).outerWidth(),
             top  : target_elm_position.top + ($(target_elm).outerHeight() / 2) + config.arrow_top_offset - $(dialog_box).outerHeight() + config.arrow_height
           },
           arrow_class : "div.left_arrow"
         }
         $(dialog_box).find("div.left_arrow").css({ top: $(dialog_box).outerHeight() - (config.arrow_top_offset * 2) + "px" });
       }
       // coming from the top
       else if (is_top || !has_position &&(target_elm_position.top + config.animation_distance > $(dialog_box).outerHeight() && target_elm_position.left >= config.arrow_left_offset)) {
         position = { 
           start : { 
             left : target_elm_position.left + ($(target_elm).outerWidth() / 2) - config.arrow_left_offset,
             top  : target_elm_position.top - config.animation_distance - $(dialog_box).outerHeight()
           },
           end : {
             left : target_elm_position.left + ($(target_elm).outerWidth() / 2) - config.arrow_left_offset,
             top  : target_elm_position.top - $(dialog_box).outerHeight() + config.arrow_height
           },
           arrow_class : "div.down_arrow"
         }
       }       
       // coming from the bottom
       else if (is_bottom || !has_position &&(target_elm_position.top + config.animation_distance < $(dialog_box).outerHeight())) {
         position = { 
           start : { 
             left : target_elm_position.left + ($(target_elm).outerWidth() / 2) - config.arrow_left_offset,
             top  : target_elm_position.top + $(target_elm).outerHeight() + config.animation_distance
           },
           end : {
             left : target_elm_position.left + ($(target_elm).outerWidth() / 2) - config.arrow_left_offset,
             top  : target_elm_position.top + $(target_elm).outerHeight()
           },
           arrow_class : "div.up_arrow"
         }
       }
        
       // position and show the box
       $(dialog_box).css({ 
         top : position.start.top + "px", 
         left : position.start.left + "px", 
         opacity : config.opacity
       });       
       $(dialog_box).find("div.arrow").hide();
       $(dialog_box).find(position.arrow_class).show();
       
       // begin animation
       $(dialog_box).animate({
         top : position.end.top,
         left: position.end.left,
         opacity : "toggle"
       }, config.animation_duration_ms);       
       
     }; // -- end _show function
     
     /**
      * Stop the animation (if any) and remove from dialog box from the DOM
      */
     function _hide(target_elm) {
       $("body").find("div.jquery-gdakram-tooltip").stop().remove();
     };
     
     /**
      * Creates the dialog box element
      * and appends it to the body
      **/
     function _create(content_elm) {
       var header = ($(content_elm).attr("title")) ? "<h1>" + $(content_elm).attr("title") + "</h1>" : '';
       return $("<div class='jquery-gdakram-tooltip'>\
         <div class='up_arrow arrow'></div>\
         <div class='left_arrow arrow'></div>\
         <div class='content'>" + header + $(content_elm).html() + "</div>\
         <div style='clear:both'></div>\
         <div class='down_arrow arrow'></div>\
       </div>").appendTo('body');
     };
          
     return this; 
   };
 
 })(jQuery);
