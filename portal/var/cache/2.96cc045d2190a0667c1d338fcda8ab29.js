 var lbl_added = 'Added'; var lbl_error = 'Error'; var redirect_to_cart = false; 
/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Ajax add to cart widget
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    ec2ca39cb71eff2cf859558b4f67f561a1b9efe4, v2 (xcart_4_4_0_beta_2), 2010-05-27 13:43:06, ajax.add2cart.js, igoryan
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

// Action
ajax.actions.add2cart = function(productid, quantity, options, callback) {
  if (!productid)
    return false;

  var data = {
    mode: 'add',
    productid: productid,
    amount: quantity
  };

  if (options) {
    for (var i in options) {
      if (hasOwnProperty(options, i)) {
        data['product_options[' + i + ']'] = options[i];
      }
    }
  }

  var request = {
    type: 'POST',
    url: xcart_web_dir + '/cart.php',
    data: data
  };

  if (callback) {
    request.success = function(html, i, r) {
      return callback(true, html, i, r);
    };
    request.error = function(obj, txt, err, i) {
      return callback(false, obj, txt, err, i);
    }
  }

  return ajax.query.add(request);
}

// Widget
ajax.widgets.add2cart = function(form) {
  if (!form || typeof(form.tagName) == 'undefined' || !form.tagName || form.tagName.toUpperCase() != 'FORM')
    return false;

  if (!form.add2cartWidget) {
    new ajax.widgets.add2cart.obj(form);
  }

  return form.add2cartWidget.add2cart();
}

ajax.widgets.add2cart.obj = function(form) {

  this.savedData = {};

  this.form = $(form);

  form.add2cartWidget = this;

  this._prepareWidget();

  var s = this;
  $(ajax.messages).bind(
    'updateBuyNowBlock',
    function(e, data) {
      return s._callbackUpdateBuyNowBlock(data);
    }
  );

  $(ajax.messages).bind(
    'updateProductDetailsBlock',
    function(e, data) {
      return s._callbackUpdateBuyNowBlock(data);
    }
  );

  return true;
}

// Options
ajax.widgets.add2cart.obj.prototype.ttl = 3000;

// Property
ajax.widgets.add2cart.obj.prototype.button = false;
ajax.widgets.add2cart.obj.prototype.form = false;

ajax.widgets.add2cart.obj.prototype.state = 1;
ajax.widgets.add2cart.obj.prototype.productid = false;

ajax.widgets.add2cart.obj.prototype.savedData = {};
ajax.widgets.add2cart.obj.prototype.isClicked = false;

// Widget :: check - ready widget or not
ajax.widgets.add2cart.obj.prototype.isReady = function() {
  return this.form.length > 0 && this.productid > 0 && this.box.length > 0;
}

// Widget :: add to cart
ajax.widgets.add2cart.obj.prototype.add2cart = function() {
  if (!this.isReady())
    return false;

  if (this.isClicked || this.state == 2 || this.state == 3 || this.state == 4)
    return true;

  this.isClicked = true;

  this.changeState(2);

  var s = this;

  setTimeout(
    function() {
      s.isClicked = false;
    },
    100
  );

  return ajax.query.add(
    {
      type: 'POST',
      url: xcart_web_dir + '/cart.php',
      data: this.form.serialize(),
      success: function(a, b, c, d) {
        return s.callback(true, a, b, c, d);
      },
      error: function(a, b, c, d) {
        return s.callback(false, a, b, c, d);
      }
    }
  ) !== false;
}

// Widget :: ajax callback
ajax.widgets.add2cart.obj.prototype.callback = function(state, a, b, c, d) {
  if (!this.isReady())
    return false;

  var s = false;
  if (state && c.messages) {
    for (var i = 0; i < c.messages.length; i++) {
      if (c.messages[i].name == 'cartChanged' && c.messages[i].params.status == 1 && c.messages[i].params.changes) {
        for (var p in c.messages[i].params.changes) {
          if (hasOwnProperty(c.messages[i].params.changes, p) && c.messages[i].params.changes[p].productid == this.productid && c.messages[i].params.changes[p].changed != 0)
            s = true;
        }
      }
    }
  }

  this.changeState(s ? 3 : 4);

  return true; 
}

// Widget :: check button element
ajax.widgets.add2cart.obj.prototype.checkButton = function(button) {
  if (!button)
    button = this.button;

  if (!button || typeof(button.tagName) == 'undefined')
    return false;

  var tn = button.tagName.toUpperCase();

  if (tn == 'BUTTON' && $(button).children('span.button-right').children('span.button-left').length == 1) {
    return true;

  } else if (tn == 'DIV' && $(button).children('div').length == 1) {
    return true;
  }

  return false;
}

// Widget :: changes widget status
//  1 - idle
//  2 - background request
//  3 - success message
//  4 - error message
//  5 - submit form without background request
ajax.widgets.add2cart.obj.prototype.changeState = function(s) {
  if (this.state == s)
    return true;

  var res = false;

  if (this.button.length > 0) {

    switch (this.state) {
      case 2:
        res = this.cleanWaitState(s);
        break;

      case 3:
        res = this.cleanAddedState(s);
        break;

      case 4:
        res = this.cleanErrorState(s);
        break;

      default:
        res = this.cleanIdleState(s);
    }

    if (!res)
      return false;

  } else {
    res = true;
  }

  this.state = s;
  var o = this;

  if (this.button.length > 0) {
    switch (s) {
      case 2:
        res = this.doWaitState();
        break;

      case 3:
        res = this.doAddedState();
        setTimeout(
          function() {
            return o.changeState(1);
          },
          this.ttl
        );
        break;

      case 4:
        res = this.doErrorState();
        setTimeout(
          function() {
            o.changeState(5);
            o.submitForm(true);
          },
          this.ttl
        );
        break;

      default:
        res = this.doIdleState();
    }

  }

  return res;
}

// Widget :: change state to Idle
ajax.widgets.add2cart.obj.prototype.doIdleState = function() {
  if (this.savedData) {
    switch (this.savedData.type) {
      case 'b':
        $('.button-left', this.button).html(this.savedData.html);
        break;

      case 'd':
        $('div', this.button).html(this.savedData.html);
        break;

      default:
        return false;
    }
  }

  return true;
}

// Widget :: remove Idle state
ajax.widgets.add2cart.obj.prototype.cleanIdleState = function() {
  this.savedData = {
    type: false,
    box: false,
    html: false,
    width: false,
    height: false
  };

  switch (this.button.get(0).tagName.toUpperCase()) {
    case 'BUTTON':
      this.savedData.type = 'b';
      this.savedData.box = $('.button-left', this.button);
      break;

    case 'DIV':
      this.savedData.type = 'b';
      this.savedData.box = $('div', this.button);
      break;

    default:
      return false;
  }

  this.savedData.html = this.savedData.box.html();
  this.savedData.width = this.savedData.box.width();
  this.savedData.height = this.savedData.box.height();

  return true;
}

// Widget :: change state to Wait
ajax.widgets.add2cart.obj.prototype.doWaitState = function() {
  this.button.addClass('do-add2cart-wait');

  var span = document.createElement('SPAN');
  span.className = 'progress';
  span.style.width = this.savedData.width + 'px';
  span.style.height = this.savedData.height + 'px';

  this._freezeBox();

  this.savedData.box.empty().append(span);

  return true;
}

// Widget :: remove Wait state
ajax.widgets.add2cart.obj.prototype.cleanWaitState = function() {
  this.button.removeClass('do-add2cart-wait').remove('.progress');

  this._unFreezeBox();

  return true;
}

// Widget :: change state to Added
ajax.widgets.add2cart.obj.prototype.doAddedState = function() {
  this.button.addClass('do-add2cart-success');

  this._freezeBox();

  if (this.savedData.box)
    this.savedData.box.html(lbl_added);

  return true;
}

// Widget :: remove Added state
ajax.widgets.add2cart.obj.prototype.cleanAddedState = function() {
  this.button.removeClass('do-add2cart-success');

  this._unFreezeBox();

  return true;
}

// Widget :: change state to Error
ajax.widgets.add2cart.obj.prototype.doErrorState = function() {
  this.button.addClass('do-add2cart-error');

  this._freezeBox();

  if (this.savedData.box)
    this.savedData.box.html(lbl_error);

  return true;
}

// Widget :: remove Error state
ajax.widgets.add2cart.obj.prototype.cleanErrorState = function() {
  this.button.removeClass('do-add2cart-error');

  this._unFreezeBox();

  return true;
}

// Widget :: submit form withour background request
ajax.widgets.add2cart.obj.prototype.submitForm = function(isError) {
  if (!this.isReady())
    return false;

  if (isError && !this.form.get(0).elements.namedItem('ajax_error')) {
    var inp = document.createElement('INPUT');
    inp.type = 'hidden';
    inp.name = 'ajax_error';
    inp.value = 'Y';

    this.form.append(inp);
  }

  this.form.get(0).submit();

  return true;
}

/* Private methods */

// Widget :: prepare widget
ajax.widgets.add2cart.obj.prototype._prepareWidget = function() {

  if (this.form.length == 0)
    return false;

  // Get mode: do add to cart if mode == 'add', else cancel
  var m = this.form.get(0).elements.namedItem('mode');
  if (m && m.value != 'add') {
    return false;
  }

  // Get box
  this.box = this.form.parents().filter('.details,.product-cell');

  // Get button
  this.button = $('.add-to-cart-button', this.form).eq(0);

  // Get productid
  var p = this.form.get(0).elements.namedItem('productid');
  if (p) {
    this.productid = parseInt(p.value);
    if (isNaN(this.productid) || this.productid < 1)
      this.productid = false;
  }

  return true;
}

// Widget :: updateBuyNowBlock event listener
ajax.widgets.add2cart.obj.prototype._callbackUpdateBuyNowBlock = function(data) {
  this.savedData = {};

  return true;
}

// Widget :: freeze button width
ajax.widgets.add2cart.obj.prototype._freezeBox = function() {
  if (this.savedData.box)
    this.savedData.box.width(this.savedData.width);

  return true;
}

// Widget :: unfreeze button width
ajax.widgets.add2cart.obj.prototype._unFreezeBox = function() {
  if (this.savedData.box)
    this.savedData.box.width('auto');

  return true;
}

/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Ajax product widget
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    ec2ca39cb71eff2cf859558b4f67f561a1b9efe4, v2 (xcart_4_4_0_beta_2), 2010-05-27 13:43:06, ajax.product.js, igoryan
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

// Widget :: factory
ajax.widgets.product = function(elm) {
  if (!elm)
    return false;

  if (elm.constructor == Array) {
    if (!elm[0].productWidget)
      new ajax.widgets.product.obj(elm);

  } else if (elm.tagName) {
    if (!elm.productWidget)
      new ajax.widgets.product.obj(elm);

  } else {
    return false;
  }
    
  return true;
}

// Widget :: object
ajax.widgets.product.obj = function(elm) {
  this.elm = $(elm);

  var s = this;

  this.elm.each(
    function() {
      this.productWidget = s;
    }
  );

  this._prepareElement();

  if (isNaN(this.productid) || this.productid < 1)
    this.productid = false;

  $(ajax.messages).bind(
    'cartChanged',
    function(e, data) {
      return s._add2cartListener(data);
    }
  );

  this._callbackGPI = function(state, a, b, c) {
    return s.callbackGPI(state, a, b, c);
  }
  this._callbackBNB = function(responseText, textStatus, XMLHttpRequest) {
    return s.callbackBNB(responseText, textStatus, XMLHttpRequest);
  }
  this._callbackPDB = function(responseText, textStatus, XMLHttpRequest) {
    return s.callbackPDB(responseText, textStatus, XMLHttpRequest);
  }

}

ajax.widgets.product.obj.prototype.elm = false;

ajax.widgets.product.obj.prototype.type = false;
ajax.widgets.product.obj.prototype.productid = false;

// Widget :: check object status
ajax.widgets.product.obj.prototype.isReady = function() {
  return this.type && this.productid;
}

// Widget :: update product info
ajax.widgets.product.obj.prototype.updateBuyNowBlock = function() {
  if (!this.isReady())
    return false;

  var o = this;
  var f = function() {
    return ajax.core.loadBlock(
      $('.buy-now', o.elm),
      'buy_now',
      {
        productid: o.productid,
        is_featured_product: o.is_featured_product,
        type: o.type
      },
      o._callbackBNB
    );
  }

  return this._checkBlockButton(f);
}

// Widget :: update product details block
ajax.widgets.product.obj.prototype.updateProductDetailsBlock = function() {
  if (!this.isReady())
    return false;

  data = {
    productid: this.productid
  };
  var form = $('form', this.elm).get(0);
  if (form) {
    for (var i = 0; i < form.elements.length; i++) {
      if (form.elements[i].name) {
        var m = form.elements[i].name.match(/^product_options\[(\d+)\]$/);
        if (m) {
          data['options[' + m[1] + ']'] = form.elements[i].value;
        }
      }
    }
  }

  var m = (self.location + '').match(/&wishlistid=(\d+)/);
  if (m)
    data['wishlistid'] = m[1];

  var m = (self.location + '').match(/&pconf=(\d+)/);
  if (m)
    data['pconf'] = m[1];

  var m = (self.location + '').match(/&slot=(\d+)/);
  if (m)
    data['slot'] = m[1];

  var o = this;
  var f = function() {
    ajax.core.loadBlock(
      $('.details', o.elm).eq(0),
      'product_details',
      data,
      o._callbackPDB
    );
  }

  return this._checkBlockButton(f);
}

// Widget :: ajax callback (buy now block update)
ajax.widgets.product.obj.prototype.callbackBNB = function(responseText, textStatus, XMLHttpRequest) {
  if (XMLHttpRequest.status == 200) {
    ajax.core.trigger(
      'updateBuyNowBlock',
      {
        productid: this.productid,
        element: this.elm
      }
    );

    $('div.dropout-container div.drop-out-button').not('.activated-widget').each(initDropOutButton);
  }

  return true;
}

// Widget :: ajax callback (product details block update)
ajax.widgets.product.obj.prototype.callbackPDB = function(responseText, textStatus, XMLHttpRequest) {
  if (XMLHttpRequest.status == 200) {
    ajax.core.trigger(
      'updateProductDetailsBlock',
      {
        productid: this.productid,
        element: this.elm
      }
    );

    $('div.dropout-container div.drop-out-button').not('.activated-widget').each(initDropOutButton);
  }

  return true;
}

// Widget :: prepare element
ajax.widgets.product.obj.prototype._prepareElement = function() {
  this.productid = false;
  this.type = false;
  this.is_free_product = false;
  this.is_featured_product = false;

  var form_elements = $('form', this.elm);
  if (form_elements.length > 0) {
    tmp = form_elements.get(0).elements.namedItem('productid');
    if (tmp)
      this.productid = parseInt(tmp.value);

    if (isNaN(this.productid) || this.productid < 1)
      this.productid = false;

    tmp = form_elements.get(0).elements.namedItem('is_free_product');
    if (tmp)
      this.is_free_product = parseInt(tmp.value);

    if (isNaN(this.is_free_product))
      this.is_free_product = false;

    tmp = form_elements.get(0).elements.namedItem('is_featured_product');
    if (tmp)
      this.is_featured_product = tmp.value;
  }

  if (this.elm.is('div.item')) {
    this.type = 'list';

  } else if (this.elm.filter('td').length == this.elm.length) {
    this.type = 'matrix';

  } else if (this.elm.is('.product-details')) {
    this.type = 'details';
  }

  return true;
}

/* Private */

// Widget :: add2cart message listener
ajax.widgets.product.obj.prototype._add2cartListener = function(data) {
  if (data.status == 1 && data.changes) {
    for (var i in data.changes) {
      if (hasOwnProperty(data.changes, i) && data.changes[i].productid == this.productid && data.changes[i].changed != 0) {

        switch (this.type) {
          case 'list':
          case 'matrix':
            this.updateBuyNowBlock();
            break;

          case 'details':
            this.updateProductDetailsBlock();
            break;
        }
        break;
      }
    }
  }

  return true;
}

ajax.widgets.product.obj.prototype._checkBlockButton = function(f) {
  if ($('.do-add2cart-wait, .do-add2cart-success', this.elm).length > 0) {
    var o = this;
    return setTimeout(
      function() {
        return o._checkBlockButton(f);
      },
      1000
    );

  } else {
    return f();
  }
}

/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Ajax Products list widget
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    ec2ca39cb71eff2cf859558b4f67f561a1b9efe4, v2 (xcart_4_4_0_beta_2), 2010-05-27 13:43:06, ajax.products.js, igoryan
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

ajax.widgets.products = function(elm) {
  if (!elm) {
    elm = $('.products');

  } else {
    elm = $(elm);
  }

  elm.each(
    function() {
      if (!this.productsWidget)
        new ajax.widgets.products.obj(this);
    }
  );

  return true;
}

ajax.widgets.products.obj = function(elm) {
  this.elm = elm;
  this.elm$ = $(elm);

  elm.productsWidget = this;

  this.type = false;

  if (this.elm$.hasClass('products-list')) {
    this.type = 'list';

  } else if (this.elm$.hasClass('products-table')) {
    this.type = 'matrix';

  }

  this._getProducts();
}

ajax.widgets.products.obj.prototype.elm = false;
ajax.widgets.products.obj.prototype.products = [];
ajax.widgets.products.obj.prototype.type = false;

ajax.widgets.products.obj.prototype.isReady = function() {
  return this.type && this.products.length > 0 && this.checkElement();
}

ajax.widgets.products.obj.prototype.checkElement = function(elm) {
  if (!elm)
    elm = this.elm;

  return typeof(elm) != 'undefiend' && elm.tagName && $(elm).hasClass('products');
}

/* Private */

// Widget :: get products
ajax.widgets.products.obj.prototype._getProducts = function() {
  if (!ajax.widgets.product)
    return false;

  this.products = [];

  var arr = [];

  if (this.type == 'list') {

    // Plain list
    arr = this.elm$.children('.item').get();

  } else if (this.type == 'matrix') {

    // Matrix
    var vSize = -1;
    for (var i = 1; i < this.elm.rows.length && vSize < 0; i++) {
      if ($(this.elm.rows[i]).hasClass('product-name-row'))
        vSize = i;
    }

    if (vSize < 0)
      vSize = this.elm.rows.length;

    var hSize = this.elm.rows[0].cells.length;
    var size = vSize * hSize;

    for (var r = 0; r < this.elm.rows.length; r++) {
      for (var c = 0; c < this.elm.rows[r].cells.length; c++) {
        var pn = Math.floor(r / vSize) * vSize + c;
        if (!arr[pn])
          arr[pn] = [];

        arr[pn][arr[pn].length] = this.elm.rows[r].cells[c];
      }
    } 

  }

  for (var i = 0; i < arr.length; i++) {
    var p = new ajax.widgets.product(arr[i]);
    this.products[this.products.length] = p;
  }

  return this.products.length > 0;
}


// onload handler
$(ajax).bind(
  'load',
  function() {
    return ajax.widgets.products();
  }
);

