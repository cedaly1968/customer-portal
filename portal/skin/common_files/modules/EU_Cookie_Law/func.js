/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Functions for EU Cookie Law module
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    9b4e5c5f0193bbef4827afbf0bdb2698c3a3ded2, v2 (xcart_4_5_1), 2012-06-06 10:32:13, func.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

var panel_timer = null;
var countdown_timer = null;
var countdown_sec = 60;
 
$(document).ready(function(){
    if ($("div#eucl_panel")) {
      $("div#eucl_panel").hide();

      panel_timer = setTimeout(
        function () {
          if ($("td#eucl_panel_countdown")) {
            $("td#eucl_panel_countdown").html(countdown_sec + lbl_sec);
            countdown_timer = setTimeout(
              function () {
                func_down_timer();
              }, 1000);
          }
          $("div#eucl_panel").slideDown("slow");
          panel_timer = setTimeout(
            function () { 
              func_down_eucl_panel();
            }, countdown_sec * 1000);
          }, 3000);
    }
    setTimeout(
      function () {
        func_reset_unallowed_cookies();
        }, 
        5000);

    jQuery.xc_cookie = function (key, value, options) {
      if (func_is_allowed_cookie(key)) {
        $.cookie(key, value, options);
      } else {
        $.cookie(key, null);
      }
    }

});

function func_down_timer() {
  if ($("td#eucl_panel_countdown")) {
    countdown_sec--;
    $("td#eucl_panel_countdown").html(countdown_sec + lbl_sec);
    countdown_timer = setTimeout(
        function () {
          func_down_timer();
        }, 1000);
  }
}
 
function func_down_eucl_panel() {
  if ($("div#eucl_panel")) {
    $("div#eucl_panel").slideUp("slow"); 
  }

  if (panel_timer) {
    clearTimeout(panel_timer);
  }
  panel_timer = null;

  if (countdown_timer) {
    clearTimeout(countdown_timer);
  }
  countdown_timer = null;
}
 
function func_change_cookie_settings() {
  popupOpen('popup_cookie_settings.php', '', {width: 600, height: 480});
  func_down_eucl_panel();
}

function func_is_allowed_cookie(name) {

  if (!allowed_cookies || allowed_cookies.length == 0) {
    return true;
  }

  for (var i=0; i < allowed_cookies.length; i++) {
    if (name == allowed_cookies[i]) {
      return true;
    }
  }

  return false;

}

function func_reset_unallowed_cookies() {
  var cookies = func_get_all_cookies();

  for(var name in cookies) {
    if (!func_is_allowed_cookie(name)) {
      deleteCookie(name);
    }
  }  
}

function func_get_all_cookies() {

  var cookies = { };
  if (document.cookie && document.cookie != '') {
    var split = document.cookie.split(';');
    for (var i = 0; i < split.length; i++) {
      var name_value = split[i].split("=");
      name_value[0] = name_value[0].replace(/^ /, '');
      cookies[decodeURIComponent(name_value[0])] = decodeURIComponent(name_value[1]);
    }
  }

  return cookies;
}

