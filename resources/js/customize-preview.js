"use strict";

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * Scripts for working with customizer preview actions
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Class for adding styles
 */
var Styles =
/*#__PURE__*/
function () {
  function Styles(data) {
    _classCallCheck(this, Styles);

    if (!data.id || !data.selector) return false;
    this.screen = data.screen;
    this.id = this.screen ? "".concat(data.id, "--").concat(data.screen) : data.id;
    this.selector = data.selector;
    this.styles = data.styles;
    this.removeStyleblock();
    this.insertStyleblock();
  }

  _createClass(Styles, [{
    key: "removeStyleblock",
    value: function removeStyleblock() {
      var oldBlock = document.getElementById(this.getHook());
      if (oldBlock !== null) oldBlock.remove();
    }
  }, {
    key: "insertStyleblock",
    value: function insertStyleblock() {
      document.head.insertBefore(this.getStyleBlock(), this.getHook());
    }
  }, {
    key: "openQuery",
    value: function openQuery() {
      if (!this.screen) return '';
      var screens = parent.rootstrapData.screens;
      var screen = screens[this.screen];
      var query = '';

      if (screen.min || screen.max) {
        query += '@media ';
        if (screen.min) query += "(min-width: ".concat(screen.min, ")");
        if (screen.max) query += ' and ';
        if (screen.max) query += "(max-width: ".concat(screen.max, ")");
        query += '{';
      }

      return query;
    }
  }, {
    key: "getStyles",
    value: function getStyles() {
      var styles = this.selector + '{';

      var _arr = Object.entries(this.styles);

      for (var _i = 0; _i < _arr.length; _i++) {
        var _arr$_i = _slicedToArray(_arr[_i], 2),
            property = _arr$_i[0],
            value = _arr$_i[1];

        if (!property || !value) continue;
        styles += "".concat(property, ": ").concat(value, ";");
      }

      styles += '}';
      return styles;
    }
  }, {
    key: "closeQuery",
    value: function closeQuery() {
      return this.screen ? '}' : '';
    }
  }, {
    key: "getStyleBlock",
    value: function getStyleBlock() {
      var styleblock = document.createElement("style");
      styleblock.setAttribute("id", this.id);
      styleblock.textContent = this.openQuery() + this.getStyles() + this.closeQuery();
      return styleblock;
    }
  }, {
    key: "getHook",
    value: function getHook() {
      return document.getElementById("rootstrap-style-hook--" + this.screen);
    }
  }]);

  return Styles;
}();
/**
 * Add style hooks on document ready
 */


document.addEventListener("DOMContentLoaded", function () {
  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = rootstrap.screens()[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var screen = _step.value;
      var hook = document.createElement("meta");
      var hookID = "rootstrap-style-hook--".concat(screen[0]);
      hook.setAttribute("id", hookID);
      hook.setAttribute("name", hookID);
      document.head.appendChild(hook);
    }
  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator.return != null) {
        _iterator.return();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }
});
/**
 * Object for interfacing with rootstrap
 */

var rootstrap = {
  screens: function screens() {
    return Object.entries(parent.rootstrapData.screens);
  },
  style: function style(data) {
    var style = new Styles(data);
  }
};