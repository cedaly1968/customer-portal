/*global jQuery */
/*!	
* Responsive-Portfolio-Gallery
*
* Copyright 2011, http://www.freshdesignweb.com/
* Released under the WTFPL license 
*
*/
jQuery(document).ready(function($) {
	jQuery( fend[1] ).ajaxSuccess(function() {setTimeout(emgdelay, 100);});function emgdelay() {
(function( $, undefined ) {$.HoverDir=function(e,t){this.$el=$(t);this._init(e)};$.HoverDir.defaults={hoverDelay:0,reverse:false};$.HoverDir.prototype={_init:function(e){this.options=$.extend(true,{},$.HoverDir.defaults,e);this._loadEvents()},_loadEvents:function(){var e=this;this.$el.bind("mouseenter.hoverdir, mouseleave.hoverdir",function(t){var n=$(this),r=t.type,i=n.find("article"),s=e._getDir(n,{x:t.pageX,y:t.pageY}),o=e._getClasses(s);i.removeClass();if(r==="mouseenter"){i.hide().addClass(o.from);clearTimeout(e.tmhover);e.tmhover=setTimeout(function(){i.show(0,function(){$(this).addClass("da-animate").addClass(o.to)})},e.options.hoverDelay)}else{i.addClass("da-animate");clearTimeout(e.tmhover);i.addClass(o.from)}})},_getDir:function(e,t){var n=e.width(),r=e.height(),i=(t.x-e.offset().left-n/2)*(n>r?r/n:1),s=(t.y-e.offset().top-r/2)*(r>n?n/r:1),o=Math.round((Math.atan2(s,i)*(180/Math.PI)+180)/90+3)%4;return o},_getClasses:function(e){var t,n;switch(e){case 0:!this.options.reverse?t="da-slideFromTop":t="da-slideFromBottom";n="da-slideTop";break;case 1:!this.options.reverse?t="da-slideFromRight":t="da-slideFromLeft";n="da-slideLeft";break;case 2:!this.options.reverse?t="da-slideFromBottom":t="da-slideFromTop";n="da-slideTop";break;case 3:!this.options.reverse?t="da-slideFromLeft":t="da-slideFromRight";n="da-slideLeft";break}return{from:t,to:n}}};var logError=function(e){if(this.console){console.error(e)}};$.fn.hoverdir=function(e){if(typeof e==="string"){var t=Array.prototype.slice.call(arguments,1);this.each(function(){var n=$.data(this,"hoverdir");if(!n){logError("cannot call methods on hoverdir prior to initialization; "+"attempted to call method '"+e+"'");return}if(!$.isFunction(n[e])||e.charAt(0)==="_"){logError("no such method '"+e+"' for hoverdir instance");return}n[e].apply(n,t)})}else{this.each(function(){var t=$.data(this,"hoverdir");if(!t){$.data(this,"hoverdir",new $.HoverDir(e,this))}})}return this}})( jQuery );

jQuery(function(){jQuery(window).scroll(function(){if(jQuery("#mbCenter").size()>0){var e=parseInt(jQuery(document).scrollTop());var t=jQuery("#mbCenter").offset();var n=parseInt(t.top+jQuery("#mbCenter").height()+90-e);var r=jQuery(window).height()-n;if(e<t.top-90){setTimeout(function(){jQuery("#mbCenter").stop().animate({top:jQuery(window).scrollTop()+340},500)},150)}if(r>1&&jQuery(window).height()<jQuery("#mbCenter").height()-90){setTimeout(function(){jQuery("#mbCenter").stop().animate({top:t.top+340},500)},150)}else if(r>1&&jQuery(window).height()>jQuery("#mbCenter").height()+90){setTimeout(function(){jQuery("#mbCenter").stop().animate({top:jQuery(window).scrollTop()+340},500)},150)}}})})


/*! waitForImages jQuery Plugin - v1.4.2 - 2013-01-19
* https://github.com/alexanderdickson/waitForImages
* Copyright (c) 2013 Alex Dickson; Licensed MIT */

jQuery(function(e){var t="waitForImages";e.waitForImages={hasImageProperties:["backgroundImage","listStyleImage","borderImage","borderCornerImage"]};e.expr[":"].uncached=function(t){if(!e(t).is('img[src!=""]')){return false}var n=new Image;n.src=t.src;return!n.complete};e.fn.waitForImages=function(n,r,i){var s=0;var o=0;if(e.isPlainObject(arguments[0])){i=arguments[0].waitForAll;r=arguments[0].each;n=arguments[0].finished}n=n||e.noop;r=r||e.noop;i=!!i;if(!e.isFunction(n)||!e.isFunction(r)){throw new TypeError("An invalid callback was supplied.")}return this.each(function(){var u=e(this);var a=[];var f=e.waitForImages.hasImageProperties||[];var l=/url\(\s*(['"]?)(.*?)\1\s*\)/g;if(i){u.find("*").andSelf().each(function(){var t=e(this);if(t.is("img:uncached")){a.push({src:t.attr("src"),element:t[0]})}e.each(f,function(e,n){var r=t.css(n);var i;if(!r){return true}while(i=l.exec(r)){a.push({src:i[2],element:t[0]})}})})}else{u.find("img:uncached").each(function(){a.push({src:this.src,element:this})})}s=a.length;o=0;if(s===0){n.call(u[0])}e.each(a,function(i,a){var f=new Image;e(f).bind("load."+t+" error."+t,function(e){o++;r.call(a.element,o,s,e.type=="load");if(o==s){n.call(u[0]);return false}});f.src=a.src})})}})


/* Image pre-loader and hover */
jQuery(function($){$(".iehand").waitForImages({finished:function(){var e=1;var t=$("div.iehand img").length;var n=setInterval(function(){if(e>=t)clearInterval(n);$("div.view").eq(e-1).removeClass('preloaderview');$("div.iehand img:hidden").eq(0).fadeIn(500);e++},200)},each:function(){},waitForAll:true});$("div.da-thumbs").hoverdir(); $(".emgfittext").fitText(1.2,{ maxFontSize: "12px" });});


/* ISOTOPE */
jQuery(function(e){e.Isotope.prototype._getCenteredMasonryColumns=function(){this.width=this.element.width();var e=this.element.parent().width();var t=this.options.masonry&&this.options.masonry.columnWidth||this.$filteredAtoms.outerWidth(true)||e;var n=Math.floor(e/t);n=Math.max(n,1);this.masonry.cols=n;this.masonry.columnWidth=t};e.Isotope.prototype._masonryReset=function(){this.masonry={};this._getCenteredMasonryColumns();var e=this.masonry.cols;this.masonry.colYs=[];while(e--){this.masonry.colYs.push(0)}};e.Isotope.prototype._masonryResizeChanged=function(){var e=this.masonry.cols;this._getCenteredMasonryColumns();return this.masonry.cols!==e};e.Isotope.prototype._masonryGetContainerSize=function(){var e=0,t=this.masonry.cols;while(--t){if(this.masonry.colYs[t]!==0){break}e++}return{height:Math.max.apply(Math,this.masonry.colYs),width:(this.masonry.cols-e)*this.masonry.columnWidth}};var t=e(".easycontainer");t.isotope({itemSelector:".easyitem",transformsEnabled:true});var n=e("#emgoptions .emgoption-set"),r=n.find("a");r.click(function(){var n=e(this);if(n.hasClass("selected")){return false}var r=n.parents(".emgoption-set");r.find(".selected").removeClass("selected");n.addClass("selected");var i={},s=r.attr("data-option-key"),o=n.attr("data-option-value");o=o==="false"?false:o;i[s]=o;if(s==="layoutMode"&&typeof changeLayoutMode==="function"){changeLayoutMode(n,i)}else{t.isotope(i)}return false})})
	  
window.addEvent('domready', function() {
    Easymedia.scanPage();});
		}
});		  