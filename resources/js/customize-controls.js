"use strict";

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/**
 * Scripts for working with customizer control actions
 *
 * @package   Rootstrap
 * @author    Sky Shabatura
 * @copyright Copyright (c) 2018, Sky Shabatura
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/*
 * Main Rootstrap Class
 */
var Rootstrap =
/*#__PURE__*/
function () {
  function Rootstrap() {
    _classCallCheck(this, Rootstrap);

    // define api attribute
    this.api = wp.customize; // if wp.customize is not defined, return

    if (!this.api) return false; // define registered devices

    this.devices = rootstrapData.devices; // do our thang

    this.init();
  }
  /*
   * Let's get to it
   */


  _createClass(Rootstrap, [{
    key: "init",
    value: function init() {
      // initialize tab functionality
      this.initializeNavLink(); // setup device data

      this.setDeviceData();
    }
    /*
     * Get list of device names
     */

  }, {
    key: "getDeviceList",
    value: function getDeviceList() {
      return Object.keys(this.devices);
    }
    /*
     * Get a device id from a specified width
     */

  }, {
    key: "getDevice",
    value: function getDevice(width) {
      var device = false;

      var _arr = Object.entries(this.devices);

      for (var _i = 0; _i < _arr.length; _i++) {
        var _arr$_i = _slicedToArray(_arr[_i], 2),
            name = _arr$_i[0],
            data = _arr$_i[1];

        if (!name || !data) continue;
        var min = parseInt(data.min, 10) ? parseInt(data.min, 10) : 0;
        var max = parseInt(data.max, 10) ? parseInt(data.max, 10) : 9999;
        if (width >= min && width <= max) device = name;
        return false;
      }

      return device;
    }
    /*
     * Get the device id that matches the current preview screen width
     */

  }, {
    key: "getCurrentDevice",
    value: function getCurrentDevice() {
      return getDevice(this.getPreviewWidth());
    }
    /*
     * Get the current preview screen width
     */

  }, {
    key: "getPreviewWidth",
    value: function getPreviewWidth() {
      var iframe = document.querySelector("#customize-preview iframe");
      var iframeDoc = iframe.contentDocument ? iframe.contentDocument : iframe.contentWindow.document;
      return iframeDoc.body.offsetWidth();
    }
    /*
     * When opening a section, open the associated device in preview.This requires 
     * the section "type" to be set to a specific value, which is then used to determine 
     * the device by its class name. This is sloppy. We need to figure out how to add 
     * a data value on sections of any type. 
     */

  }, {
    key: "setDeviceData",
    value: function setDeviceData() {
      var api = this.api;
      document.querySelectorAll('.accordion-section-title').forEach(function (title) {
        title.addEventListener("click", function (e) {
          var classNames = e.target.parentElement.classList;
          var _iteratorNormalCompletion = true;
          var _didIteratorError = false;
          var _iteratorError = undefined;

          try {
            for (var _iterator = classNames[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
              var className = _step.value;
              if (className.indexOf('rootstrap-device--') !== -1) api.previewedDevice.set(className.replace('control-section-rootstrap-device--', ''));
              return false;
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
      });
    }
    /*
     * Add click handler to rootstrap tabs controls in the customizer
     */

  }, {
    key: "initializeNavLink",
    value: function initializeNavLink() {
      var api = this.api;
      document.querySelectorAll('.rootstrap-nav-link').forEach(function (elem) {
        var section = elem.dataset.section;
        var device = elem.dataset.device;
        elem.addEventListener("click", function (e) {
          if (api.section(section)) api.section(section).activate();
          api.section(section).focus();
          if (device) api.previewedDevice.set(device);else var type = api.section(section).params.type;
          if (type && type.indexOf('rootstrap-device--') !== -1) api.previewedDevice.set(type.replace('rootstrap-device--', ''));
        });
      });
    }
  }]);

  return Rootstrap;
}();
/*
 * Create our Rootstrap Instance on document ready
 */


document.addEventListener("DOMContentLoaded", function () {
  var rootstrap = new Rootstrap();
});