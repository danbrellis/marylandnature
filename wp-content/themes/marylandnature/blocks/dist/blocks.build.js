/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./blocks/src/blocks.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./blocks/src/blocks.js":
/*!******************************!*\
  !*** ./blocks/src/blocks.js ***!
  \******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _common_contact_block__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./common/contact/block */ "./blocks/src/common/contact/block.js");
/* harmony import */ var _featurettes_collections_block__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./featurettes/collections/block */ "./blocks/src/featurettes/collections/block.js");
/* harmony import */ var _featurettes_newsletter_signup_block__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./featurettes/newsletter-signup/block */ "./blocks/src/featurettes/newsletter-signup/block.js");
/* harmony import */ var _widgets_collections_block__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./widgets/collections/block */ "./blocks/src/widgets/collections/block.js");
/* harmony import */ var _widgets_team_list_block__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./widgets/team-list/block */ "./blocks/src/widgets/team-list/block.js");






/***/ }),

/***/ "./blocks/src/common/contact/block.js":
/*!********************************************!*\
  !*** ./blocks/src/common/contact/block.js ***!
  \********************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./style.scss */ "./blocks/src/common/contact/style.scss");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./blocks/src/common/contact/editor.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_editor_scss__WEBPACK_IMPORTED_MODULE_1__);
var _wp$blockEditor = wp.blockEditor,
    PlainText = _wp$blockEditor.PlainText,
    URLInput = _wp$blockEditor.URLInput,
    URLInputButton = _wp$blockEditor.URLInputButton;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$components = wp.components,
    Button = _wp$components.Button,
    PanelBody = _wp$components.PanelBody,
    TextControl = _wp$components.TextControl;


registerBlockType("nhsm-common/contact", {
  title: "Contact Details",
  icon: "phone",
  category: "common",
  attributes: {
    email: {
      source: "text",
      type: "string",
      selector: ".nhsm-contact__email"
    },
    emailLink: {
      source: "attribute",
      attribute: "href",
      type: "string",
      selector: ".nhsm-contact__email"
    },
    phone: {
      source: "text",
      type: "string",
      selector: ".nhsm-contact__phone"
    },
    phoneLink: {
      source: "attribute",
      attribute: "href",
      type: "string",
      selector: ".nhsm-contact__phone"
    },
    address: {
      source: "text",
      type: "string",
      selector: ".nhsm-contact__address"
    },
    addressLink: {
      source: "attribute",
      attribute: "href",
      type: "string",
      selector: ".nhsm-contact__address"
    }
  },
  edit: function edit(_ref) {
    var attributes = _ref.attributes,
        className = _ref.className,
        setAttributes = _ref.setAttributes;
    return wp.element.createElement("div", {
      className: "container nhsm-contact"
    }, wp.element.createElement("div", {
      className: "nhsm-contact__group"
    }, wp.element.createElement(PlainText, {
      className: "nhsm-contact__email",
      value: attributes.email,
      onChange: function onChange(content) {
        return setAttributes({
          email: content
        });
      },
      placeholder: "Email Address"
    }), attributes.email && wp.element.createElement(URLInputButton, {
      url: attributes.emailLink,
      onChange: function onChange(url) {
        return setAttributes({
          emailLink: url
        });
      },
      disableSuggestions: true
    })), wp.element.createElement("div", {
      className: "nhsm-contact__group"
    }, wp.element.createElement(PlainText, {
      className: "nhsm-contact__phone",
      value: attributes.phone,
      onChange: function onChange(content) {
        return setAttributes({
          phone: content
        });
      },
      placeholder: "Phone"
    }), attributes.phone && wp.element.createElement(URLInputButton, {
      url: attributes.phoneLink,
      onChange: function onChange(url) {
        return setAttributes({
          phoneLink: url
        });
      },
      disableSuggestions: true
    })), wp.element.createElement("div", {
      className: "nhsm-contact__group"
    }, wp.element.createElement(PlainText, {
      className: "nhsm-contact__address",
      value: attributes.address,
      onChange: function onChange(content) {
        return setAttributes({
          address: content
        });
      },
      placeholder: "Address"
    }), attributes.address && wp.element.createElement(URLInputButton, {
      url: attributes.addressLink,
      onChange: function onChange(url) {
        return setAttributes({
          addressLink: url
        });
      },
      disableSuggestions: true
    })));
  },
  save: function save(_ref2) {
    var attributes = _ref2.attributes;

    var icon = function icon(iconClass) {
      return wp.element.createElement("span", {
        className: "icon-round"
      }, wp.element.createElement("i", {
        className: iconClass
      }));
    };

    return wp.element.createElement("ul", {
      className: "flex-list flex-list--wrap contact-details"
    }, wp.element.createElement("li", {
      className: "flex-list__item"
    }, wp.element.createElement("a", {
      href: attributes.emailLink,
      className: "nhsm-contact__email icon-with-text"
    }, icon("fas fa-envelope"), attributes.email)), wp.element.createElement("li", {
      className: "flex-list__item"
    }, wp.element.createElement("a", {
      href: attributes.phoneLink,
      className: "nhsm-contact__phone icon-with-text"
    }, icon("fas fa-phone"), attributes.phone)), wp.element.createElement("li", {
      className: "flex-list__item"
    }, wp.element.createElement("a", {
      href: attributes.addressLink,
      className: "nhsm-contact__address icon-with-text"
    }, icon("fas fa-map-pin"), attributes.address)));
  }
});

/***/ }),

/***/ "./blocks/src/common/contact/editor.scss":
/*!***********************************************!*\
  !*** ./blocks/src/common/contact/editor.scss ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./blocks/src/common/contact/style.scss":
/*!**********************************************!*\
  !*** ./blocks/src/common/contact/style.scss ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./blocks/src/featurettes/collections/block.js":
/*!*****************************************************!*\
  !*** ./blocks/src/featurettes/collections/block.js ***!
  \*****************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./style.scss */ "./blocks/src/featurettes/collections/style.scss");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./blocks/src/featurettes/collections/editor.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_editor_scss__WEBPACK_IMPORTED_MODULE_1__);
function _createForOfIteratorHelper(o) { if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) { var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var it, normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(n); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var _wp$blockEditor = wp.blockEditor,
    InspectorControls = _wp$blockEditor.InspectorControls,
    MediaUpload = _wp$blockEditor.MediaUpload,
    PlainText = _wp$blockEditor.PlainText,
    RichText = _wp$blockEditor.RichText,
    PanelColorSettings = _wp$blockEditor.PanelColorSettings;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$components = wp.components,
    Button = _wp$components.Button,
    ServerSideRender = _wp$components.ServerSideRender;


registerBlockType("nhsm-featurettes/collections", {
  title: "Collections CTA",
  icon: "grid-view",
  category: "nhsm-featurettes",
  attributes: {
    title: {
      source: "text",
      type: "string",
      selector: ".nhsm-cta-collections__title"
    },
    lead: {
      source: "text",
      type: "string",
      selector: ".nhsm-cta-collections__lead"
    },
    cta: {
      type: "string",
      source: "html",
      selector: ".nhsm-cta-collections__collectionsGridTitle"
    },
    componentStyles: {
      type: "object",
      backgroundImage: {
        type: "string"
      },
      backgroundColor: {
        type: "string"
      },
      color: {
        type: "string"
      }
    },
    bgImageID: {
      type: "integer"
    }
  },
  edit: function edit(_ref) {
    var attributes = _ref.attributes,
        className = _ref.className,
        setAttributes = _ref.setAttributes;

    var getImageButton = function getImageButton(openEvent) {
      if (attributes.bgImageID) {
        return wp.element.createElement("div", {
          className: "img-container"
        }, wp.element.createElement(Button, {
          onClick: openEvent,
          className: "button button-large"
        }, "Change image"), wp.element.createElement(Button, {
          onClick: function onClick() {
            var styles = _objectSpread({}, attributes.componentStyles);

            styles.backgroundImage = null;
            setAttributes({
              bgImageID: 0,
              componentStyles: styles
            });
          },
          className: "button button-large"
        }, "Remove Image"));
      } else {
        return wp.element.createElement("div", {
          className: "img-container"
        }, wp.element.createElement(Button, {
          onClick: openEvent,
          className: "button button-large"
        }, "Pick an image"));
      }
    };

    return [wp.element.createElement(InspectorControls, null, wp.element.createElement(PanelColorSettings, {
      title: "Color Settings",
      colorSettings: [{
        value: attributes.componentStyles.backgroundColor,
        onChange: function onChange(colorValue) {
          var styles = _objectSpread({}, attributes.componentStyles);

          styles.backgroundColor = colorValue;
          setAttributes({
            componentStyles: styles
          });
        },
        label: "Background Color"
      }, {
        value: attributes.componentStyles.color,
        onChange: function onChange(colorValue) {
          var styles = _objectSpread({}, attributes.componentStyles);

          styles.color = colorValue;
          setAttributes({
            componentStyles: styles
          });
        },
        label: "Text Color"
      }]
    })), wp.element.createElement("section", {
      className: "container"
    }, wp.element.createElement("div", {
      className: "nhsm-cta-collections",
      style: attributes.componentStyles
    }, wp.element.createElement(PlainText, {
      onChange: function onChange(content) {
        return setAttributes({
          title: content
        });
      },
      value: attributes.title,
      placeholder: "Call to action title",
      className: "nhsm-cta-collections__title"
    }), wp.element.createElement(PlainText, {
      onChange: function onChange(content) {
        return setAttributes({
          lead: content
        });
      },
      value: attributes.lead,
      placeholder: "Call to action text",
      className: "nhsm-cta-collections__lead"
    }), wp.element.createElement(RichText, {
      tagName: "h3",
      className: "nhsm-cta-collections__collectionsGridTitle",
      placeholder: "The call to action (include link to destination)",
      value: attributes.cta,
      onChange: function onChange(content) {
        return setAttributes({
          cta: content
        });
      },
      multiline: false,
      allowedFormats: ["core/link"]
    }), wp.element.createElement(ServerSideRender, {
      block: "nhsm-widgets/collections",
      className: "nhsm-cta-collections__collectionsGrid",
      attributes: {
        count: 3,
        order: "rand",
        format: "stamp",
        wrapGrid: false
      }
    })), wp.element.createElement(MediaUpload, {
      onSelect: function onSelect(media) {
        var styles = _objectSpread({}, attributes.componentStyles);

        styles.backgroundImage = "url(" + media.url + ")";
        setAttributes({
          bgImageID: media.id,
          componentStyles: styles
        });
      },
      type: "image",
      value: attributes.bgImageID,
      render: function render(_ref2) {
        var open = _ref2.open;
        return getImageButton(open);
      }
    }))];
  },
  save: function save(_ref3) {
    var attributes = _ref3.attributes;

    var ctaMarkup = function ctaMarkup() {
      var domparser = new DOMParser();
      var cta = domparser.parseFromString(attributes.cta, "text/html");
      var links = cta.getElementsByTagName("a");

      var _iterator = _createForOfIteratorHelper(links),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var link = _step.value;
          link.classList.add("button", "button--primary", "button--prominent", "nhsm-cta-collections__button");
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }

      return {
        __html: cta.body.innerHTML
      };
    };

    return wp.element.createElement("section", {
      className: "homepage-section nhsm-cta-collections",
      style: attributes.componentStyles
    }, wp.element.createElement("div", {
      className: "container nhsm-cta-collections__inner"
    }, wp.element.createElement("h2", {
      className: "nhsm-cta-collections__title"
    }, attributes.title), wp.element.createElement("p", {
      className: "nhsm-cta-collections__lead"
    }, attributes.lead), wp.element.createElement("section", {
      className: "nhsm-cta-collections__collectionGrid"
    }, wp.element.createElement("h3", {
      className: "nhsm-cta-collections__collectionsGridTitle",
      dangerouslySetInnerHTML: ctaMarkup()
    }), wp.element.createElement("div", {
      id: "collections_list"
    }))));
  }
});

/***/ }),

/***/ "./blocks/src/featurettes/collections/editor.scss":
/*!********************************************************!*\
  !*** ./blocks/src/featurettes/collections/editor.scss ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./blocks/src/featurettes/collections/style.scss":
/*!*******************************************************!*\
  !*** ./blocks/src/featurettes/collections/style.scss ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./blocks/src/featurettes/newsletter-signup/block.js":
/*!***********************************************************!*\
  !*** ./blocks/src/featurettes/newsletter-signup/block.js ***!
  \***********************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./style.scss */ "./blocks/src/featurettes/newsletter-signup/style.scss");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_style_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./editor.scss */ "./blocks/src/featurettes/newsletter-signup/editor.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_editor_scss__WEBPACK_IMPORTED_MODULE_1__);
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

var _wp$blockEditor = wp.blockEditor,
    InspectorControls = _wp$blockEditor.InspectorControls,
    MediaUpload = _wp$blockEditor.MediaUpload,
    PlainText = _wp$blockEditor.PlainText,
    URLInputButton = _wp$blockEditor.URLInputButton;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$components = wp.components,
    Button = _wp$components.Button,
    PanelBody = _wp$components.PanelBody,
    TextareaControl = _wp$components.TextareaControl,
    ExternalLink = _wp$components.ExternalLink;


registerBlockType("nhsm-featurettes/newsletter-signup", {
  title: "Newsletter Signup",
  icon: "email-alt",
  category: "nhsm-featurettes",
  attributes: {
    title: {
      source: "text",
      selector: ".nhsm-cta-newsletter-signup__title"
    },
    body: {
      source: "text",
      selector: ".nhsm-cta-newsletter-signup__body"
    },
    linkText: {
      type: "string",
      source: "text",
      selector: ".nhsm-cta-newsletter-signup__buttonText"
    },
    linkURL: {
      type: "string",
      source: "attribute",
      attribute: "href",
      selector: ".nhsm-cta-newsletter-signup__button",
      "default": "#"
    },
    image: {
      type: "object",
      url: {
        type: "string",
        source: "attribute",
        attribute: "src",
        selector: ".nhsm-cta-newsletter-signup__figure img"
      },
      alt: {
        type: "string",
        source: "attribute",
        attribute: "alt",
        selector: ".nhsm-cta-newsletter-signup__figure img",
        "default": ""
      },
      width: {
        type: "integer",
        source: "attribute",
        attribute: "width",
        selector: ".nhsm-cta-newsletter-signup__figure img"
      },
      height: {
        type: "integer",
        source: "attribute",
        attribute: "height",
        selector: ".nhsm-cta-newsletter-signup__figure img"
      }
    },
    imageCaption: {
      type: "string",
      source: "meta",
      meta: "source_credit"
    },
    imageID: {
      type: "integer"
    }
  },
  edit: function edit(_ref) {
    var attributes = _ref.attributes,
        className = _ref.className,
        setAttributes = _ref.setAttributes;

    var getImageButton = function getImageButton(openEvent) {
      if (attributes.image.url) {
        return wp.element.createElement("img", {
          src: attributes.image.url,
          onClick: openEvent,
          className: "nhsm-cta-newsletter-signup__image"
        });
      } else {
        return wp.element.createElement("div", {
          className: "button-container"
        }, wp.element.createElement(Button, {
          onClick: openEvent,
          className: "button button-large"
        }, "Pick an image"));
      }
    };

    return [attributes.imageID && wp.element.createElement(InspectorControls, null, wp.element.createElement(PanelBody, {
      title: "Image Settings"
    }, wp.element.createElement(TextareaControl, {
      label: "Alt text (alternative text)",
      value: attributes.image.alt,
      onChange: function onChange(alt) {
        var image = _objectSpread({}, attributes.image);

        image.alt = alt;
        setAttributes({
          image: image
        });
      },
      help: wp.element.createElement("div", null, wp.element.createElement(ExternalLink, {
        href: "https://www.w3.org/WAI/tutorials/images/decision-tree"
      }, "Describe the purpose of the image"), "Leave empty if the image is purely decorative.")
    }))), wp.element.createElement("div", {
      className: "container nhsm-cta-newsletter-signup"
    }, wp.element.createElement(PlainText, {
      onChange: function onChange(content) {
        return setAttributes({
          title: content
        });
      },
      value: attributes.title,
      placeholder: "Your card title",
      className: "nhsm-cta-newsletter-signup__title"
    }), wp.element.createElement(PlainText, {
      onChange: function onChange(content) {
        return setAttributes({
          body: content
        });
      },
      value: attributes.body,
      placeholder: "Your card text",
      className: "nhsm-cta-newsletter-signup__body"
    }), wp.element.createElement("section", {
      className: "nhsm-cta-newsletter-signup__buttonEditor"
    }, wp.element.createElement(PlainText, {
      onChange: function onChange(content) {
        return setAttributes({
          linkText: content
        });
      },
      value: attributes.linkText,
      placeholder: "Button text",
      className: "nhsm-cta-newsletter-signup__buttonText"
    }), wp.element.createElement(URLInputButton, {
      url: attributes.linkURL,
      onChange: function onChange(url, post) {
        return setAttributes({
          linkURL: url
        });
      }
    })), wp.element.createElement(MediaUpload, {
      onSelect: function onSelect(media) {
        setAttributes({
          image: {
            url: media.sizes.nhsm_headshot.url,
            alt: media.alt,
            width: media.sizes.nhsm_headshot.width,
            height: media.sizes.nhsm_headshot.height
          },
          imageID: media.id
        });
      },
      type: "image",
      value: attributes.imageID,
      render: function render(_ref2) {
        var open = _ref2.open;
        return getImageButton(open);
      }
    }))];
  },
  save: function save(_ref3) {
    var attributes = _ref3.attributes;

    var image = function image(_image, imageID) {
      if (!_image) return null;
      var classList = "img-responsive wp-image-" + imageID;

      if (_image.alt !== "") {
        return wp.element.createElement("img", {
          src: _image.url,
          width: _image.width,
          height: _image.height,
          alt: _image.alt,
          className: classList
        });
      } // No alt set, so let's hide it from screen readers


      return wp.element.createElement("img", {
        src: _image.url,
        width: _image.width,
        height: _image.height,
        alt: "",
        "aria-hidden": "true",
        className: classList
      });
    };

    return wp.element.createElement("section", {
      className: "homepage-section nhsm-cta-newsletter-signup"
    }, wp.element.createElement("div", {
      className: "container nhsm-cta-newsletter-signup__inner"
    }, wp.element.createElement("h2", {
      className: "nhsm-cta-newsletter-signup__title"
    }, attributes.title), wp.element.createElement("p", {
      className: "nhsm-cta-newsletter-signup__body"
    }, attributes.body), wp.element.createElement("a", {
      href: attributes.linkURL,
      className: "button button--primary button--prominent nhsm-cta-newsletter-signup__button iconButton--iconFirst iconButton--grow"
    }, wp.element.createElement("i", {
      className: "fas fa-paper-plane"
    }), wp.element.createElement("span", {
      className: "nhsm-cta-newsletter-signup__buttonText"
    }, attributes.linkText)), wp.element.createElement("div", {
      className: "nhsm-cta-newsletter-signup__figure"
    }, wp.element.createElement("figure", {
      className: "figure figure--captionOverlay figure--circle"
    }, image(attributes.image, attributes.imageID), wp.element.createElement("figcaption", null)))));
  }
});

/***/ }),

/***/ "./blocks/src/featurettes/newsletter-signup/editor.scss":
/*!**************************************************************!*\
  !*** ./blocks/src/featurettes/newsletter-signup/editor.scss ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./blocks/src/featurettes/newsletter-signup/style.scss":
/*!*************************************************************!*\
  !*** ./blocks/src/featurettes/newsletter-signup/style.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./blocks/src/widgets/collections/block.js":
/*!*************************************************!*\
  !*** ./blocks/src/widgets/collections/block.js ***!
  \*************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./editor.scss */ "./blocks/src/widgets/collections/editor.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_editor_scss__WEBPACK_IMPORTED_MODULE_0__);
var InspectorControls = wp.blockEditor.InspectorControls;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    TextControl = _wp$components.TextControl,
    SelectControl = _wp$components.SelectControl,
    ToggleControl = _wp$components.ToggleControl,
    ServerSideRender = _wp$components.ServerSideRender;

registerBlockType("nhsm-widgets/collections", {
  title: "Collections",
  icon: "grid-view",
  category: "widgets",
  edit: function edit(_ref) {
    var attributes = _ref.attributes,
        className = _ref.className,
        setAttributes = _ref.setAttributes;
    return wp.element.createElement("div", {
      className: "container"
    }, wp.element.createElement(InspectorControls, null, wp.element.createElement(PanelBody, {
      title: "Collections Settings",
      initialOpen: true
    }, wp.element.createElement(TextControl, {
      onChange: function onChange(value) {
        return setAttributes({
          count: value
        });
      },
      label: "Number of results to display",
      value: attributes.count
    }), wp.element.createElement(SelectControl, {
      label: "Display Format",
      value: attributes.format,
      options: [{
        label: "Condensed",
        value: "stamp"
      }, {
        label: "Card",
        value: "card"
      }],
      onChange: function onChange(value) {
        return setAttributes({
          format: value
        });
      }
    }), wp.element.createElement(SelectControl, {
      label: "Order By",
      value: attributes.order,
      options: [{
        label: "Alphabetically",
        value: "title"
      }, {
        label: "Randomly",
        value: "rand"
      }],
      onChange: function onChange(value) {
        return setAttributes({
          order: value
        });
      }
    }), wp.element.createElement(ToggleControl, {
      label: "Wrap for Grid",
      checked: attributes.wrapGrid,
      onChange: function onChange() {
        return setAttributes({
          wrapGrid: !attributes.wrapGrid
        });
      }
    }))), wp.element.createElement(ServerSideRender, {
      block: "nhsm-widgets/collections",
      className: "nhsm-widget-collections nhsm-widget-collections--".concat(attributes.wrapGrid ? "grid" : "list"),
      attributes: attributes
    }));
  }
});

/***/ }),

/***/ "./blocks/src/widgets/collections/editor.scss":
/*!****************************************************!*\
  !*** ./blocks/src/widgets/collections/editor.scss ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./blocks/src/widgets/team-list/block.js":
/*!***********************************************!*\
  !*** ./blocks/src/widgets/team-list/block.js ***!
  \***********************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./editor.scss */ "./blocks/src/widgets/team-list/editor.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_editor_scss__WEBPACK_IMPORTED_MODULE_0__);
var InspectorControls = wp.blockEditor.InspectorControls;
var registerBlockType = wp.blocks.registerBlockType;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    SelectControl = _wp$components.SelectControl,
    ServerSideRender = _wp$components.ServerSideRender;
var _wp$data = wp.data,
    withSelect = _wp$data.withSelect,
    withDispatch = _wp$data.withDispatch; //import "./style.scss";


registerBlockType("nhsm-widgets/team-list", {
  title: "Team List",
  icon: "groups",
  category: "widgets",
  edit: function edit(_ref) {
    var attributes = _ref.attributes,
        className = _ref.className,
        setAttributes = _ref.setAttributes;

    function SelectControlGen(_ref2) {
      var roles = _ref2.roles;
      var options = [];

      if (roles) {
        options = roles.map(function (role) {
          return {
            label: role.name.replace(/&amp;/g, "&"),
            value: role.slug
          };
        });
        options.unshift({
          value: 0,
          label: "Please select one"
        });
      } else {
        options.push({
          value: 0,
          label: "Loading..."
        });
      }

      return wp.element.createElement(SelectControl, {
        label: "Select role to display",
        value: attributes.role,
        options: options,
        onChange: function onChange(role) {
          setAttributes({
            role: role
          });
        }
      });
    }

    var TaxSelectControl = withSelect(function (select) {
      return {
        roles: select("core").getEntityRecords("taxonomy", "nhsm_role", {
          per_page: -1
        })
      };
    })(SelectControlGen);
    return wp.element.createElement("div", {
      className: "container nhsm_widgets_team_list"
    }, wp.element.createElement(InspectorControls, null, wp.element.createElement(PanelBody, {
      title: "Team List Settings",
      initialOpen: true
    }, wp.element.createElement(TaxSelectControl, null))), wp.element.createElement(ServerSideRender, {
      block: "nhsm-widgets/team-list",
      className: "nhsm_widgets_team_list_grid",
      attributes: attributes
    }));
  }
});

/***/ }),

/***/ "./blocks/src/widgets/team-list/editor.scss":
/*!**************************************************!*\
  !*** ./blocks/src/widgets/team-list/editor.scss ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9ibG9ja3MuanMiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9jb21tb24vY29udGFjdC9ibG9jay5qcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3Mvc3JjL2NvbW1vbi9jb250YWN0L2VkaXRvci5zY3NzIiwid2VicGFjazovLy8uL2Jsb2Nrcy9zcmMvY29tbW9uL2NvbnRhY3Qvc3R5bGUuc2NzcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3Mvc3JjL2ZlYXR1cmV0dGVzL2NvbGxlY3Rpb25zL2Jsb2NrLmpzIiwid2VicGFjazovLy8uL2Jsb2Nrcy9zcmMvZmVhdHVyZXR0ZXMvY29sbGVjdGlvbnMvZWRpdG9yLnNjc3MiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9mZWF0dXJldHRlcy9jb2xsZWN0aW9ucy9zdHlsZS5zY3NzIiwid2VicGFjazovLy8uL2Jsb2Nrcy9zcmMvZmVhdHVyZXR0ZXMvbmV3c2xldHRlci1zaWdudXAvYmxvY2suanMiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9mZWF0dXJldHRlcy9uZXdzbGV0dGVyLXNpZ251cC9lZGl0b3Iuc2NzcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3Mvc3JjL2ZlYXR1cmV0dGVzL25ld3NsZXR0ZXItc2lnbnVwL3N0eWxlLnNjc3MiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy93aWRnZXRzL2NvbGxlY3Rpb25zL2Jsb2NrLmpzIiwid2VicGFjazovLy8uL2Jsb2Nrcy9zcmMvd2lkZ2V0cy9jb2xsZWN0aW9ucy9lZGl0b3Iuc2NzcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3Mvc3JjL3dpZGdldHMvdGVhbS1saXN0L2Jsb2NrLmpzIiwid2VicGFjazovLy8uL2Jsb2Nrcy9zcmMvd2lkZ2V0cy90ZWFtLWxpc3QvZWRpdG9yLnNjc3MiXSwibmFtZXMiOlsid3AiLCJibG9ja0VkaXRvciIsIlBsYWluVGV4dCIsIlVSTElucHV0IiwiVVJMSW5wdXRCdXR0b24iLCJyZWdpc3RlckJsb2NrVHlwZSIsImJsb2NrcyIsImNvbXBvbmVudHMiLCJCdXR0b24iLCJQYW5lbEJvZHkiLCJUZXh0Q29udHJvbCIsInRpdGxlIiwiaWNvbiIsImNhdGVnb3J5IiwiYXR0cmlidXRlcyIsImVtYWlsIiwic291cmNlIiwidHlwZSIsInNlbGVjdG9yIiwiZW1haWxMaW5rIiwiYXR0cmlidXRlIiwicGhvbmUiLCJwaG9uZUxpbmsiLCJhZGRyZXNzIiwiYWRkcmVzc0xpbmsiLCJlZGl0IiwiY2xhc3NOYW1lIiwic2V0QXR0cmlidXRlcyIsImNvbnRlbnQiLCJ1cmwiLCJzYXZlIiwiaWNvbkNsYXNzIiwiSW5zcGVjdG9yQ29udHJvbHMiLCJNZWRpYVVwbG9hZCIsIlJpY2hUZXh0IiwiUGFuZWxDb2xvclNldHRpbmdzIiwiU2VydmVyU2lkZVJlbmRlciIsImxlYWQiLCJjdGEiLCJjb21wb25lbnRTdHlsZXMiLCJiYWNrZ3JvdW5kSW1hZ2UiLCJiYWNrZ3JvdW5kQ29sb3IiLCJjb2xvciIsImJnSW1hZ2VJRCIsImdldEltYWdlQnV0dG9uIiwib3BlbkV2ZW50Iiwic3R5bGVzIiwidmFsdWUiLCJvbkNoYW5nZSIsImNvbG9yVmFsdWUiLCJsYWJlbCIsImNvdW50Iiwib3JkZXIiLCJmb3JtYXQiLCJ3cmFwR3JpZCIsIm1lZGlhIiwiaWQiLCJvcGVuIiwiY3RhTWFya3VwIiwiZG9tcGFyc2VyIiwiRE9NUGFyc2VyIiwicGFyc2VGcm9tU3RyaW5nIiwibGlua3MiLCJnZXRFbGVtZW50c0J5VGFnTmFtZSIsImxpbmsiLCJjbGFzc0xpc3QiLCJhZGQiLCJfX2h0bWwiLCJib2R5IiwiaW5uZXJIVE1MIiwiVGV4dGFyZWFDb250cm9sIiwiRXh0ZXJuYWxMaW5rIiwibGlua1RleHQiLCJsaW5rVVJMIiwiaW1hZ2UiLCJhbHQiLCJ3aWR0aCIsImhlaWdodCIsImltYWdlQ2FwdGlvbiIsIm1ldGEiLCJpbWFnZUlEIiwicG9zdCIsInNpemVzIiwibmhzbV9oZWFkc2hvdCIsIlNlbGVjdENvbnRyb2wiLCJUb2dnbGVDb250cm9sIiwiZGF0YSIsIndpdGhTZWxlY3QiLCJ3aXRoRGlzcGF0Y2giLCJTZWxlY3RDb250cm9sR2VuIiwicm9sZXMiLCJvcHRpb25zIiwibWFwIiwicm9sZSIsIm5hbWUiLCJyZXBsYWNlIiwic2x1ZyIsInVuc2hpZnQiLCJwdXNoIiwiVGF4U2VsZWN0Q29udHJvbCIsInNlbGVjdCIsImdldEVudGl0eVJlY29yZHMiLCJwZXJfcGFnZSJdLCJtYXBwaW5ncyI6IjtRQUFBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBOzs7UUFHQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0EsMENBQTBDLGdDQUFnQztRQUMxRTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLHdEQUF3RCxrQkFBa0I7UUFDMUU7UUFDQSxpREFBaUQsY0FBYztRQUMvRDs7UUFFQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0EseUNBQXlDLGlDQUFpQztRQUMxRSxnSEFBZ0gsbUJBQW1CLEVBQUU7UUFDckk7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSwyQkFBMkIsMEJBQTBCLEVBQUU7UUFDdkQsaUNBQWlDLGVBQWU7UUFDaEQ7UUFDQTtRQUNBOztRQUVBO1FBQ0Esc0RBQXNELCtEQUErRDs7UUFFckg7UUFDQTs7O1FBR0E7UUFDQTs7Ozs7Ozs7Ozs7OztBQ2xGQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7Ozs7Ozs7O3NCQ0hnREEsRUFBRSxDQUFDQyxXO0lBQTNDQyxTLG1CQUFBQSxTO0lBQVdDLFEsbUJBQUFBLFE7SUFBVUMsYyxtQkFBQUEsYztJQUNyQkMsaUIsR0FBc0JMLEVBQUUsQ0FBQ00sTSxDQUF6QkQsaUI7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Q29udGVudCI6WyIgXHQvLyBUaGUgbW9kdWxlIGNhY2hlXG4gXHR2YXIgaW5zdGFsbGVkTW9kdWxlcyA9IHt9O1xuXG4gXHQvLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuIFx0ZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXG4gXHRcdC8vIENoZWNrIGlmIG1vZHVsZSBpcyBpbiBjYWNoZVxuIFx0XHRpZihpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSkge1xuIFx0XHRcdHJldHVybiBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXS5leHBvcnRzO1xuIFx0XHR9XG4gXHRcdC8vIENyZWF0ZSBhIG5ldyBtb2R1bGUgKGFuZCBwdXQgaXQgaW50byB0aGUgY2FjaGUpXG4gXHRcdHZhciBtb2R1bGUgPSBpbnN0YWxsZWRNb2R1bGVzW21vZHVsZUlkXSA9IHtcbiBcdFx0XHRpOiBtb2R1bGVJZCxcbiBcdFx0XHRsOiBmYWxzZSxcbiBcdFx0XHRleHBvcnRzOiB7fVxuIFx0XHR9O1xuXG4gXHRcdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuIFx0XHRtb2R1bGVzW21vZHVsZUlkXS5jYWxsKG1vZHVsZS5leHBvcnRzLCBtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuIFx0XHQvLyBGbGFnIHRoZSBtb2R1bGUgYXMgbG9hZGVkXG4gXHRcdG1vZHVsZS5sID0gdHJ1ZTtcblxuIFx0XHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuIFx0XHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG4gXHR9XG5cblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGVzIG9iamVjdCAoX193ZWJwYWNrX21vZHVsZXNfXylcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubSA9IG1vZHVsZXM7XG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlIGNhY2hlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmMgPSBpbnN0YWxsZWRNb2R1bGVzO1xuXG4gXHQvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9uIGZvciBoYXJtb255IGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uZCA9IGZ1bmN0aW9uKGV4cG9ydHMsIG5hbWUsIGdldHRlcikge1xuIFx0XHRpZighX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIG5hbWUpKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIG5hbWUsIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBnZXR0ZXIgfSk7XG4gXHRcdH1cbiBcdH07XG5cbiBcdC8vIGRlZmluZSBfX2VzTW9kdWxlIG9uIGV4cG9ydHNcbiBcdF9fd2VicGFja19yZXF1aXJlX18uciA9IGZ1bmN0aW9uKGV4cG9ydHMpIHtcbiBcdFx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG4gXHRcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG4gXHRcdH1cbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbiBcdH07XG5cbiBcdC8vIGNyZWF0ZSBhIGZha2UgbmFtZXNwYWNlIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDE6IHZhbHVlIGlzIGEgbW9kdWxlIGlkLCByZXF1aXJlIGl0XG4gXHQvLyBtb2RlICYgMjogbWVyZ2UgYWxsIHByb3BlcnRpZXMgb2YgdmFsdWUgaW50byB0aGUgbnNcbiBcdC8vIG1vZGUgJiA0OiByZXR1cm4gdmFsdWUgd2hlbiBhbHJlYWR5IG5zIG9iamVjdFxuIFx0Ly8gbW9kZSAmIDh8MTogYmVoYXZlIGxpa2UgcmVxdWlyZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy50ID0gZnVuY3Rpb24odmFsdWUsIG1vZGUpIHtcbiBcdFx0aWYobW9kZSAmIDEpIHZhbHVlID0gX193ZWJwYWNrX3JlcXVpcmVfXyh2YWx1ZSk7XG4gXHRcdGlmKG1vZGUgJiA4KSByZXR1cm4gdmFsdWU7XG4gXHRcdGlmKChtb2RlICYgNCkgJiYgdHlwZW9mIHZhbHVlID09PSAnb2JqZWN0JyAmJiB2YWx1ZSAmJiB2YWx1ZS5fX2VzTW9kdWxlKSByZXR1cm4gdmFsdWU7XG4gXHRcdHZhciBucyA9IE9iamVjdC5jcmVhdGUobnVsbCk7XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18ucihucyk7XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShucywgJ2RlZmF1bHQnLCB7IGVudW1lcmFibGU6IHRydWUsIHZhbHVlOiB2YWx1ZSB9KTtcbiBcdFx0aWYobW9kZSAmIDIgJiYgdHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSBmb3IodmFyIGtleSBpbiB2YWx1ZSkgX193ZWJwYWNrX3JlcXVpcmVfXy5kKG5zLCBrZXksIGZ1bmN0aW9uKGtleSkgeyByZXR1cm4gdmFsdWVba2V5XTsgfS5iaW5kKG51bGwsIGtleSkpO1xuIFx0XHRyZXR1cm4gbnM7XG4gXHR9O1xuXG4gXHQvLyBnZXREZWZhdWx0RXhwb3J0IGZ1bmN0aW9uIGZvciBjb21wYXRpYmlsaXR5IHdpdGggbm9uLWhhcm1vbnkgbW9kdWxlc1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5uID0gZnVuY3Rpb24obW9kdWxlKSB7XG4gXHRcdHZhciBnZXR0ZXIgPSBtb2R1bGUgJiYgbW9kdWxlLl9fZXNNb2R1bGUgP1xuIFx0XHRcdGZ1bmN0aW9uIGdldERlZmF1bHQoKSB7IHJldHVybiBtb2R1bGVbJ2RlZmF1bHQnXTsgfSA6XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0TW9kdWxlRXhwb3J0cygpIHsgcmV0dXJuIG1vZHVsZTsgfTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kKGdldHRlciwgJ2EnLCBnZXR0ZXIpO1xuIFx0XHRyZXR1cm4gZ2V0dGVyO1xuIFx0fTtcblxuIFx0Ly8gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSBmdW5jdGlvbihvYmplY3QsIHByb3BlcnR5KSB7IHJldHVybiBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqZWN0LCBwcm9wZXJ0eSk7IH07XG5cbiBcdC8vIF9fd2VicGFja19wdWJsaWNfcGF0aF9fXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnAgPSBcIlwiO1xuXG5cbiBcdC8vIExvYWQgZW50cnkgbW9kdWxlIGFuZCByZXR1cm4gZXhwb3J0c1xuIFx0cmV0dXJuIF9fd2VicGFja19yZXF1aXJlX18oX193ZWJwYWNrX3JlcXVpcmVfXy5zID0gXCIuL2Jsb2Nrcy9zcmMvYmxvY2tzLmpzXCIpO1xuIiwiaW1wb3J0IFwiLi9jb21tb24vY29udGFjdC9ibG9ja1wiO1xyXG5pbXBvcnQgXCIuL2ZlYXR1cmV0dGVzL2NvbGxlY3Rpb25zL2Jsb2NrXCI7XHJcbmltcG9ydCBcIi4vZmVhdHVyZXR0ZXMvbmV3c2xldHRlci1zaWdudXAvYmxvY2tcIjtcclxuaW1wb3J0IFwiLi93aWRnZXRzL2NvbGxlY3Rpb25zL2Jsb2NrXCI7XHJcbmltcG9ydCBcIi4vd2lkZ2V0cy90ZWFtLWxpc3QvYmxvY2tcIjtcclxuIiwiY29uc3QgeyBQbGFpblRleHQsIFVSTElucHV0LCBVUkxJbnB1dEJ1dHRvbiB9ID0gd3AuYmxvY2tFZGl0b3I7XHJcbmNvbnN0IHsgcmVnaXN0ZXJCbG9ja1R5cGUgfSA9IHdwLmJsb2NrcztcclxuY29uc3QgeyBCdXR0b24sIFBhbmVsQm9keSwgVGV4dENvbnRyb2wgfSA9IHdwLmNvbXBvbmVudHM7XHJcblxyXG5pbXBvcnQgXCIuL3N0eWxlLnNjc3NcIjtcclxuaW1wb3J0IFwiLi9lZGl0b3Iuc2Nzc1wiO1xyXG5cclxucmVnaXN0ZXJCbG9ja1R5cGUoXCJuaHNtLWNvbW1vbi9jb250YWN0XCIsIHtcclxuICB0aXRsZTogXCJDb250YWN0IERldGFpbHNcIixcclxuICBpY29uOiBcInBob25lXCIsXHJcbiAgY2F0ZWdvcnk6IFwiY29tbW9uXCIsXHJcbiAgYXR0cmlidXRlczoge1xyXG4gICAgZW1haWw6IHtcclxuICAgICAgc291cmNlOiBcInRleHRcIixcclxuICAgICAgdHlwZTogXCJzdHJpbmdcIixcclxuICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY29udGFjdF9fZW1haWxcIixcclxuICAgIH0sXHJcbiAgICBlbWFpbExpbms6IHtcclxuICAgICAgc291cmNlOiBcImF0dHJpYnV0ZVwiLFxyXG4gICAgICBhdHRyaWJ1dGU6IFwiaHJlZlwiLFxyXG4gICAgICB0eXBlOiBcInN0cmluZ1wiLFxyXG4gICAgICBzZWxlY3RvcjogXCIubmhzbS1jb250YWN0X19lbWFpbFwiLFxyXG4gICAgfSxcclxuICAgIHBob25lOiB7XHJcbiAgICAgIHNvdXJjZTogXCJ0ZXh0XCIsXHJcbiAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWNvbnRhY3RfX3Bob25lXCIsXHJcbiAgICB9LFxyXG4gICAgcGhvbmVMaW5rOiB7XHJcbiAgICAgIHNvdXJjZTogXCJhdHRyaWJ1dGVcIixcclxuICAgICAgYXR0cmlidXRlOiBcImhyZWZcIixcclxuICAgICAgdHlwZTogXCJzdHJpbmdcIixcclxuICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY29udGFjdF9fcGhvbmVcIixcclxuICAgIH0sXHJcbiAgICBhZGRyZXNzOiB7XHJcbiAgICAgIHNvdXJjZTogXCJ0ZXh0XCIsXHJcbiAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWNvbnRhY3RfX2FkZHJlc3NcIixcclxuICAgIH0sXHJcbiAgICBhZGRyZXNzTGluazoge1xyXG4gICAgICBzb3VyY2U6IFwiYXR0cmlidXRlXCIsXHJcbiAgICAgIGF0dHJpYnV0ZTogXCJocmVmXCIsXHJcbiAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWNvbnRhY3RfX2FkZHJlc3NcIixcclxuICAgIH0sXHJcbiAgfSxcclxuICBlZGl0KHsgYXR0cmlidXRlcywgY2xhc3NOYW1lLCBzZXRBdHRyaWJ1dGVzIH0pIHtcclxuICAgIHJldHVybiAoXHJcbiAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29udGFpbmVyIG5oc20tY29udGFjdFwiPlxyXG4gICAgICAgIDxkaXYgY2xhc3NOYW1lPVwibmhzbS1jb250YWN0X19ncm91cFwiPlxyXG4gICAgICAgICAgPFBsYWluVGV4dFxyXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWNvbnRhY3RfX2VtYWlsXCJcclxuICAgICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMuZW1haWx9XHJcbiAgICAgICAgICAgIG9uQ2hhbmdlPXsoY29udGVudCkgPT4gc2V0QXR0cmlidXRlcyh7IGVtYWlsOiBjb250ZW50IH0pfVxyXG4gICAgICAgICAgICBwbGFjZWhvbGRlcj1cIkVtYWlsIEFkZHJlc3NcIlxyXG4gICAgICAgICAgLz5cclxuICAgICAgICAgIHthdHRyaWJ1dGVzLmVtYWlsICYmIChcclxuICAgICAgICAgICAgPFVSTElucHV0QnV0dG9uXHJcbiAgICAgICAgICAgICAgdXJsPXthdHRyaWJ1dGVzLmVtYWlsTGlua31cclxuICAgICAgICAgICAgICBvbkNoYW5nZT17KHVybCkgPT4gc2V0QXR0cmlidXRlcyh7IGVtYWlsTGluazogdXJsIH0pfVxyXG4gICAgICAgICAgICAgIGRpc2FibGVTdWdnZXN0aW9ucz17dHJ1ZX1cclxuICAgICAgICAgICAgLz5cclxuICAgICAgICAgICl9XHJcbiAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJuaHNtLWNvbnRhY3RfX2dyb3VwXCI+XHJcbiAgICAgICAgICA8UGxhaW5UZXh0XHJcbiAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY29udGFjdF9fcGhvbmVcIlxyXG4gICAgICAgICAgICB2YWx1ZT17YXR0cmlidXRlcy5waG9uZX1cclxuICAgICAgICAgICAgb25DaGFuZ2U9eyhjb250ZW50KSA9PiBzZXRBdHRyaWJ1dGVzKHsgcGhvbmU6IGNvbnRlbnQgfSl9XHJcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyPVwiUGhvbmVcIlxyXG4gICAgICAgICAgLz5cclxuICAgICAgICAgIHthdHRyaWJ1dGVzLnBob25lICYmIChcclxuICAgICAgICAgICAgPFVSTElucHV0QnV0dG9uXHJcbiAgICAgICAgICAgICAgdXJsPXthdHRyaWJ1dGVzLnBob25lTGlua31cclxuICAgICAgICAgICAgICBvbkNoYW5nZT17KHVybCkgPT4gc2V0QXR0cmlidXRlcyh7IHBob25lTGluazogdXJsIH0pfVxyXG4gICAgICAgICAgICAgIGRpc2FibGVTdWdnZXN0aW9ucz17dHJ1ZX1cclxuICAgICAgICAgICAgLz5cclxuICAgICAgICAgICl9XHJcbiAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJuaHNtLWNvbnRhY3RfX2dyb3VwXCI+XHJcbiAgICAgICAgICA8UGxhaW5UZXh0XHJcbiAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY29udGFjdF9fYWRkcmVzc1wiXHJcbiAgICAgICAgICAgIHZhbHVlPXthdHRyaWJ1dGVzLmFkZHJlc3N9XHJcbiAgICAgICAgICAgIG9uQ2hhbmdlPXsoY29udGVudCkgPT4gc2V0QXR0cmlidXRlcyh7IGFkZHJlc3M6IGNvbnRlbnQgfSl9XHJcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyPVwiQWRkcmVzc1wiXHJcbiAgICAgICAgICAvPlxyXG4gICAgICAgICAge2F0dHJpYnV0ZXMuYWRkcmVzcyAmJiAoXHJcbiAgICAgICAgICAgIDxVUkxJbnB1dEJ1dHRvblxyXG4gICAgICAgICAgICAgIHVybD17YXR0cmlidXRlcy5hZGRyZXNzTGlua31cclxuICAgICAgICAgICAgICBvbkNoYW5nZT17KHVybCkgPT4gc2V0QXR0cmlidXRlcyh7IGFkZHJlc3NMaW5rOiB1cmwgfSl9XHJcbiAgICAgICAgICAgICAgZGlzYWJsZVN1Z2dlc3Rpb25zPXt0cnVlfVxyXG4gICAgICAgICAgICAvPlxyXG4gICAgICAgICAgKX1cclxuICAgICAgICA8L2Rpdj5cclxuICAgICAgPC9kaXY+XHJcbiAgICApO1xyXG4gIH0sXHJcbiAgc2F2ZSh7IGF0dHJpYnV0ZXMgfSkge1xyXG4gICAgY29uc3QgaWNvbiA9IChpY29uQ2xhc3MpID0+IHtcclxuICAgICAgcmV0dXJuIChcclxuICAgICAgICA8c3BhbiBjbGFzc05hbWU9e1wiaWNvbi1yb3VuZFwifT5cclxuICAgICAgICAgIDxpIGNsYXNzTmFtZT17aWNvbkNsYXNzfT48L2k+XHJcbiAgICAgICAgPC9zcGFuPlxyXG4gICAgICApO1xyXG4gICAgfTtcclxuICAgIHJldHVybiAoXHJcbiAgICAgIDx1bCBjbGFzc05hbWU9XCJmbGV4LWxpc3QgZmxleC1saXN0LS13cmFwIGNvbnRhY3QtZGV0YWlsc1wiPlxyXG4gICAgICAgIDxsaSBjbGFzc05hbWU9XCJmbGV4LWxpc3RfX2l0ZW1cIj5cclxuICAgICAgICAgIDxhXHJcbiAgICAgICAgICAgIGhyZWY9e2F0dHJpYnV0ZXMuZW1haWxMaW5rfVxyXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWNvbnRhY3RfX2VtYWlsIGljb24td2l0aC10ZXh0XCJcclxuICAgICAgICAgID5cclxuICAgICAgICAgICAge2ljb24oXCJmYXMgZmEtZW52ZWxvcGVcIil9XHJcbiAgICAgICAgICAgIHthdHRyaWJ1dGVzLmVtYWlsfVxyXG4gICAgICAgICAgPC9hPlxyXG4gICAgICAgIDwvbGk+XHJcbiAgICAgICAgPGxpIGNsYXNzTmFtZT1cImZsZXgtbGlzdF9faXRlbVwiPlxyXG4gICAgICAgICAgPGFcclxuICAgICAgICAgICAgaHJlZj17YXR0cmlidXRlcy5waG9uZUxpbmt9XHJcbiAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY29udGFjdF9fcGhvbmUgaWNvbi13aXRoLXRleHRcIlxyXG4gICAgICAgICAgPlxyXG4gICAgICAgICAgICB7aWNvbihcImZhcyBmYS1waG9uZVwiKX1cclxuICAgICAgICAgICAge2F0dHJpYnV0ZXMucGhvbmV9XHJcbiAgICAgICAgICA8L2E+XHJcbiAgICAgICAgPC9saT5cclxuICAgICAgICA8bGkgY2xhc3NOYW1lPVwiZmxleC1saXN0X19pdGVtXCI+XHJcbiAgICAgICAgICA8YVxyXG4gICAgICAgICAgICBocmVmPXthdHRyaWJ1dGVzLmFkZHJlc3NMaW5rfVxyXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWNvbnRhY3RfX2FkZHJlc3MgaWNvbi13aXRoLXRleHRcIlxyXG4gICAgICAgICAgPlxyXG4gICAgICAgICAgICB7aWNvbihcImZhcyBmYS1tYXAtcGluXCIpfVxyXG4gICAgICAgICAgICB7YXR0cmlidXRlcy5hZGRyZXNzfVxyXG4gICAgICAgICAgPC9hPlxyXG4gICAgICAgIDwvbGk+XHJcbiAgICAgIDwvdWw+XHJcbiAgICApO1xyXG4gIH0sXHJcbn0pO1xyXG4iLCIvLyByZW1vdmVkIGJ5IGV4dHJhY3QtdGV4dC13ZWJwYWNrLXBsdWdpbiIsIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luIiwiY29uc3Qge1xyXG4gIEluc3BlY3RvckNvbnRyb2xzLFxyXG4gIE1lZGlhVXBsb2FkLFxyXG4gIFBsYWluVGV4dCxcclxuICBSaWNoVGV4dCxcclxuICBQYW5lbENvbG9yU2V0dGluZ3MsXHJcbn0gPSB3cC5ibG9ja0VkaXRvcjtcclxuY29uc3QgeyByZWdpc3RlckJsb2NrVHlwZSB9ID0gd3AuYmxvY2tzO1xyXG5jb25zdCB7IEJ1dHRvbiwgU2VydmVyU2lkZVJlbmRlciB9ID0gd3AuY29tcG9uZW50cztcclxuXHJcbmltcG9ydCBcIi4vc3R5bGUuc2Nzc1wiO1xyXG5pbXBvcnQgXCIuL2VkaXRvci5zY3NzXCI7XHJcblxyXG5yZWdpc3RlckJsb2NrVHlwZShcIm5oc20tZmVhdHVyZXR0ZXMvY29sbGVjdGlvbnNcIiwge1xyXG4gIHRpdGxlOiBcIkNvbGxlY3Rpb25zIENUQVwiLFxyXG4gIGljb246IFwiZ3JpZC12aWV3XCIsXHJcbiAgY2F0ZWdvcnk6IFwibmhzbS1mZWF0dXJldHRlc1wiLFxyXG4gIGF0dHJpYnV0ZXM6IHtcclxuICAgIHRpdGxlOiB7XHJcbiAgICAgIHNvdXJjZTogXCJ0ZXh0XCIsXHJcbiAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWN0YS1jb2xsZWN0aW9uc19fdGl0bGVcIixcclxuICAgIH0sXHJcbiAgICBsZWFkOiB7XHJcbiAgICAgIHNvdXJjZTogXCJ0ZXh0XCIsXHJcbiAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWN0YS1jb2xsZWN0aW9uc19fbGVhZFwiLFxyXG4gICAgfSxcclxuICAgIGN0YToge1xyXG4gICAgICB0eXBlOiBcInN0cmluZ1wiLFxyXG4gICAgICBzb3VyY2U6IFwiaHRtbFwiLFxyXG4gICAgICBzZWxlY3RvcjogXCIubmhzbS1jdGEtY29sbGVjdGlvbnNfX2NvbGxlY3Rpb25zR3JpZFRpdGxlXCIsXHJcbiAgICB9LFxyXG4gICAgY29tcG9uZW50U3R5bGVzOiB7XHJcbiAgICAgIHR5cGU6IFwib2JqZWN0XCIsXHJcbiAgICAgIGJhY2tncm91bmRJbWFnZToge1xyXG4gICAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIH0sXHJcbiAgICAgIGJhY2tncm91bmRDb2xvcjoge1xyXG4gICAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIH0sXHJcbiAgICAgIGNvbG9yOiB7XHJcbiAgICAgICAgdHlwZTogXCJzdHJpbmdcIixcclxuICAgICAgfSxcclxuICAgIH0sXHJcbiAgICBiZ0ltYWdlSUQ6IHtcclxuICAgICAgdHlwZTogXCJpbnRlZ2VyXCIsXHJcbiAgICB9LFxyXG4gIH0sXHJcbiAgZWRpdCh7IGF0dHJpYnV0ZXMsIGNsYXNzTmFtZSwgc2V0QXR0cmlidXRlcyB9KSB7XHJcbiAgICBjb25zdCBnZXRJbWFnZUJ1dHRvbiA9IChvcGVuRXZlbnQpID0+IHtcclxuICAgICAgaWYgKGF0dHJpYnV0ZXMuYmdJbWFnZUlEKSB7XHJcbiAgICAgICAgcmV0dXJuIChcclxuICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiaW1nLWNvbnRhaW5lclwiPlxyXG4gICAgICAgICAgICA8QnV0dG9uIG9uQ2xpY2s9e29wZW5FdmVudH0gY2xhc3NOYW1lPVwiYnV0dG9uIGJ1dHRvbi1sYXJnZVwiPlxyXG4gICAgICAgICAgICAgIENoYW5nZSBpbWFnZVxyXG4gICAgICAgICAgICA8L0J1dHRvbj5cclxuICAgICAgICAgICAgPEJ1dHRvblxyXG4gICAgICAgICAgICAgIG9uQ2xpY2s9eygpID0+IHtcclxuICAgICAgICAgICAgICAgIGNvbnN0IHN0eWxlcyA9IHsgLi4uYXR0cmlidXRlcy5jb21wb25lbnRTdHlsZXMgfTtcclxuICAgICAgICAgICAgICAgIHN0eWxlcy5iYWNrZ3JvdW5kSW1hZ2UgPSBudWxsO1xyXG4gICAgICAgICAgICAgICAgc2V0QXR0cmlidXRlcyh7XHJcbiAgICAgICAgICAgICAgICAgIGJnSW1hZ2VJRDogMCxcclxuICAgICAgICAgICAgICAgICAgY29tcG9uZW50U3R5bGVzOiBzdHlsZXMsXHJcbiAgICAgICAgICAgICAgICB9KTtcclxuICAgICAgICAgICAgICB9fVxyXG4gICAgICAgICAgICAgIGNsYXNzTmFtZT1cImJ1dHRvbiBidXR0b24tbGFyZ2VcIlxyXG4gICAgICAgICAgICA+XHJcbiAgICAgICAgICAgICAgUmVtb3ZlIEltYWdlXHJcbiAgICAgICAgICAgIDwvQnV0dG9uPlxyXG4gICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgKTtcclxuICAgICAgfSBlbHNlIHtcclxuICAgICAgICByZXR1cm4gKFxyXG4gICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJpbWctY29udGFpbmVyXCI+XHJcbiAgICAgICAgICAgIDxCdXR0b24gb25DbGljaz17b3BlbkV2ZW50fSBjbGFzc05hbWU9XCJidXR0b24gYnV0dG9uLWxhcmdlXCI+XHJcbiAgICAgICAgICAgICAgUGljayBhbiBpbWFnZVxyXG4gICAgICAgICAgICA8L0J1dHRvbj5cclxuICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgICk7XHJcbiAgICAgIH1cclxuICAgIH07XHJcblxyXG4gICAgcmV0dXJuIFtcclxuICAgICAgPEluc3BlY3RvckNvbnRyb2xzPlxyXG4gICAgICAgIDxQYW5lbENvbG9yU2V0dGluZ3NcclxuICAgICAgICAgIHRpdGxlPVwiQ29sb3IgU2V0dGluZ3NcIlxyXG4gICAgICAgICAgY29sb3JTZXR0aW5ncz17W1xyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgdmFsdWU6IGF0dHJpYnV0ZXMuY29tcG9uZW50U3R5bGVzLmJhY2tncm91bmRDb2xvcixcclxuICAgICAgICAgICAgICBvbkNoYW5nZTogKGNvbG9yVmFsdWUpID0+IHtcclxuICAgICAgICAgICAgICAgIGNvbnN0IHN0eWxlcyA9IHsgLi4uYXR0cmlidXRlcy5jb21wb25lbnRTdHlsZXMgfTtcclxuICAgICAgICAgICAgICAgIHN0eWxlcy5iYWNrZ3JvdW5kQ29sb3IgPSBjb2xvclZhbHVlO1xyXG4gICAgICAgICAgICAgICAgc2V0QXR0cmlidXRlcyh7IGNvbXBvbmVudFN0eWxlczogc3R5bGVzIH0pO1xyXG4gICAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgICAgbGFiZWw6IFwiQmFja2dyb3VuZCBDb2xvclwiLFxyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICB7XHJcbiAgICAgICAgICAgICAgdmFsdWU6IGF0dHJpYnV0ZXMuY29tcG9uZW50U3R5bGVzLmNvbG9yLFxyXG4gICAgICAgICAgICAgIG9uQ2hhbmdlOiAoY29sb3JWYWx1ZSkgPT4ge1xyXG4gICAgICAgICAgICAgICAgY29uc3Qgc3R5bGVzID0geyAuLi5hdHRyaWJ1dGVzLmNvbXBvbmVudFN0eWxlcyB9O1xyXG4gICAgICAgICAgICAgICAgc3R5bGVzLmNvbG9yID0gY29sb3JWYWx1ZTtcclxuICAgICAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoeyBjb21wb25lbnRTdHlsZXM6IHN0eWxlcyB9KTtcclxuICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgIGxhYmVsOiBcIlRleHQgQ29sb3JcIixcclxuICAgICAgICAgICAgfSxcclxuICAgICAgICAgIF19XHJcbiAgICAgICAgLz5cclxuICAgICAgPC9JbnNwZWN0b3JDb250cm9scz4sXHJcbiAgICAgIDxzZWN0aW9uIGNsYXNzTmFtZT1cImNvbnRhaW5lclwiPlxyXG4gICAgICAgIDxkaXZcclxuICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLWNvbGxlY3Rpb25zXCJcclxuICAgICAgICAgIHN0eWxlPXthdHRyaWJ1dGVzLmNvbXBvbmVudFN0eWxlc31cclxuICAgICAgICA+XHJcbiAgICAgICAgICA8UGxhaW5UZXh0XHJcbiAgICAgICAgICAgIG9uQ2hhbmdlPXsoY29udGVudCkgPT4gc2V0QXR0cmlidXRlcyh7IHRpdGxlOiBjb250ZW50IH0pfVxyXG4gICAgICAgICAgICB2YWx1ZT17YXR0cmlidXRlcy50aXRsZX1cclxuICAgICAgICAgICAgcGxhY2Vob2xkZXI9XCJDYWxsIHRvIGFjdGlvbiB0aXRsZVwiXHJcbiAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLWNvbGxlY3Rpb25zX190aXRsZVwiXHJcbiAgICAgICAgICAvPlxyXG4gICAgICAgICAgPFBsYWluVGV4dFxyXG4gICAgICAgICAgICBvbkNoYW5nZT17KGNvbnRlbnQpID0+IHNldEF0dHJpYnV0ZXMoeyBsZWFkOiBjb250ZW50IH0pfVxyXG4gICAgICAgICAgICB2YWx1ZT17YXR0cmlidXRlcy5sZWFkfVxyXG4gICAgICAgICAgICBwbGFjZWhvbGRlcj1cIkNhbGwgdG8gYWN0aW9uIHRleHRcIlxyXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWN0YS1jb2xsZWN0aW9uc19fbGVhZFwiXHJcbiAgICAgICAgICAvPlxyXG4gICAgICAgICAgPFJpY2hUZXh0XHJcbiAgICAgICAgICAgIHRhZ05hbWU9XCJoM1wiXHJcbiAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLWNvbGxlY3Rpb25zX19jb2xsZWN0aW9uc0dyaWRUaXRsZVwiXHJcbiAgICAgICAgICAgIHBsYWNlaG9sZGVyPVwiVGhlIGNhbGwgdG8gYWN0aW9uIChpbmNsdWRlIGxpbmsgdG8gZGVzdGluYXRpb24pXCJcclxuICAgICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMuY3RhfVxyXG4gICAgICAgICAgICBvbkNoYW5nZT17KGNvbnRlbnQpID0+IHNldEF0dHJpYnV0ZXMoeyBjdGE6IGNvbnRlbnQgfSl9XHJcbiAgICAgICAgICAgIG11bHRpbGluZT17ZmFsc2V9XHJcbiAgICAgICAgICAgIGFsbG93ZWRGb3JtYXRzPXtbXCJjb3JlL2xpbmtcIl19XHJcbiAgICAgICAgICAvPlxyXG4gICAgICAgICAgPFNlcnZlclNpZGVSZW5kZXJcclxuICAgICAgICAgICAgYmxvY2s9XCJuaHNtLXdpZGdldHMvY29sbGVjdGlvbnNcIlxyXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWN0YS1jb2xsZWN0aW9uc19fY29sbGVjdGlvbnNHcmlkXCJcclxuICAgICAgICAgICAgYXR0cmlidXRlcz17e1xyXG4gICAgICAgICAgICAgIGNvdW50OiAzLFxyXG4gICAgICAgICAgICAgIG9yZGVyOiBcInJhbmRcIixcclxuICAgICAgICAgICAgICBmb3JtYXQ6IFwic3RhbXBcIixcclxuICAgICAgICAgICAgICB3cmFwR3JpZDogZmFsc2UsXHJcbiAgICAgICAgICAgIH19XHJcbiAgICAgICAgICAvPlxyXG4gICAgICAgIDwvZGl2PlxyXG4gICAgICAgIDxNZWRpYVVwbG9hZFxyXG4gICAgICAgICAgb25TZWxlY3Q9eyhtZWRpYSkgPT4ge1xyXG4gICAgICAgICAgICBjb25zdCBzdHlsZXMgPSB7IC4uLmF0dHJpYnV0ZXMuY29tcG9uZW50U3R5bGVzIH07XHJcbiAgICAgICAgICAgIHN0eWxlcy5iYWNrZ3JvdW5kSW1hZ2UgPSBcInVybChcIiArIG1lZGlhLnVybCArIFwiKVwiO1xyXG4gICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKHtcclxuICAgICAgICAgICAgICBiZ0ltYWdlSUQ6IG1lZGlhLmlkLFxyXG4gICAgICAgICAgICAgIGNvbXBvbmVudFN0eWxlczogc3R5bGVzLFxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgIH19XHJcbiAgICAgICAgICB0eXBlPVwiaW1hZ2VcIlxyXG4gICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMuYmdJbWFnZUlEfVxyXG4gICAgICAgICAgcmVuZGVyPXsoeyBvcGVuIH0pID0+IGdldEltYWdlQnV0dG9uKG9wZW4pfVxyXG4gICAgICAgIC8+XHJcbiAgICAgIDwvc2VjdGlvbj4sXHJcbiAgICBdO1xyXG4gIH0sXHJcbiAgc2F2ZSh7IGF0dHJpYnV0ZXMgfSkge1xyXG4gICAgY29uc3QgY3RhTWFya3VwID0gKCkgPT4ge1xyXG4gICAgICBsZXQgZG9tcGFyc2VyID0gbmV3IERPTVBhcnNlcigpO1xyXG4gICAgICBsZXQgY3RhID0gZG9tcGFyc2VyLnBhcnNlRnJvbVN0cmluZyhhdHRyaWJ1dGVzLmN0YSwgXCJ0ZXh0L2h0bWxcIik7XHJcbiAgICAgIGxldCBsaW5rcyA9IGN0YS5nZXRFbGVtZW50c0J5VGFnTmFtZShcImFcIik7XHJcbiAgICAgIGZvciAobGV0IGxpbmsgb2YgbGlua3MpIHtcclxuICAgICAgICBsaW5rLmNsYXNzTGlzdC5hZGQoXHJcbiAgICAgICAgICBcImJ1dHRvblwiLFxyXG4gICAgICAgICAgXCJidXR0b24tLXByaW1hcnlcIixcclxuICAgICAgICAgIFwiYnV0dG9uLS1wcm9taW5lbnRcIixcclxuICAgICAgICAgIFwibmhzbS1jdGEtY29sbGVjdGlvbnNfX2J1dHRvblwiXHJcbiAgICAgICAgKTtcclxuICAgICAgfVxyXG4gICAgICByZXR1cm4ge1xyXG4gICAgICAgIF9faHRtbDogY3RhLmJvZHkuaW5uZXJIVE1MLFxyXG4gICAgICB9O1xyXG4gICAgfTtcclxuXHJcbiAgICByZXR1cm4gKFxyXG4gICAgICA8c2VjdGlvblxyXG4gICAgICAgIGNsYXNzTmFtZT1cImhvbWVwYWdlLXNlY3Rpb24gbmhzbS1jdGEtY29sbGVjdGlvbnNcIlxyXG4gICAgICAgIHN0eWxlPXthdHRyaWJ1dGVzLmNvbXBvbmVudFN0eWxlc31cclxuICAgICAgPlxyXG4gICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29udGFpbmVyIG5oc20tY3RhLWNvbGxlY3Rpb25zX19pbm5lclwiPlxyXG4gICAgICAgICAgPGgyIGNsYXNzTmFtZT1cIm5oc20tY3RhLWNvbGxlY3Rpb25zX190aXRsZVwiPnthdHRyaWJ1dGVzLnRpdGxlfTwvaDI+XHJcbiAgICAgICAgICA8cCBjbGFzc05hbWU9XCJuaHNtLWN0YS1jb2xsZWN0aW9uc19fbGVhZFwiPnthdHRyaWJ1dGVzLmxlYWR9PC9wPlxyXG4gICAgICAgICAgPHNlY3Rpb24gY2xhc3NOYW1lPVwibmhzbS1jdGEtY29sbGVjdGlvbnNfX2NvbGxlY3Rpb25HcmlkXCI+XHJcbiAgICAgICAgICAgIDxoM1xyXG4gICAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLWNvbGxlY3Rpb25zX19jb2xsZWN0aW9uc0dyaWRUaXRsZVwiXHJcbiAgICAgICAgICAgICAgZGFuZ2Vyb3VzbHlTZXRJbm5lckhUTUw9e2N0YU1hcmt1cCgpfVxyXG4gICAgICAgICAgICAvPlxyXG4gICAgICAgICAgICA8ZGl2IGlkPVwiY29sbGVjdGlvbnNfbGlzdFwiPjwvZGl2PlxyXG4gICAgICAgICAgPC9zZWN0aW9uPlxyXG4gICAgICAgIDwvZGl2PlxyXG4gICAgICA8L3NlY3Rpb24+XHJcbiAgICApO1xyXG4gIH0sXHJcbn0pO1xyXG4iLCIvLyByZW1vdmVkIGJ5IGV4dHJhY3QtdGV4dC13ZWJwYWNrLXBsdWdpbiIsIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luIiwiY29uc3Qge1xyXG4gIEluc3BlY3RvckNvbnRyb2xzLFxyXG4gIE1lZGlhVXBsb2FkLFxyXG4gIFBsYWluVGV4dCxcclxuICBVUkxJbnB1dEJ1dHRvbixcclxufSA9IHdwLmJsb2NrRWRpdG9yO1xyXG5jb25zdCB7IHJlZ2lzdGVyQmxvY2tUeXBlIH0gPSB3cC5ibG9ja3M7XHJcbmNvbnN0IHsgQnV0dG9uLCBQYW5lbEJvZHksIFRleHRhcmVhQ29udHJvbCwgRXh0ZXJuYWxMaW5rIH0gPSB3cC5jb21wb25lbnRzO1xyXG5cclxuaW1wb3J0IFwiLi9zdHlsZS5zY3NzXCI7XHJcbmltcG9ydCBcIi4vZWRpdG9yLnNjc3NcIjtcclxuXHJcbnJlZ2lzdGVyQmxvY2tUeXBlKFwibmhzbS1mZWF0dXJldHRlcy9uZXdzbGV0dGVyLXNpZ251cFwiLCB7XHJcbiAgdGl0bGU6IFwiTmV3c2xldHRlciBTaWdudXBcIixcclxuICBpY29uOiBcImVtYWlsLWFsdFwiLFxyXG4gIGNhdGVnb3J5OiBcIm5oc20tZmVhdHVyZXR0ZXNcIixcclxuICBhdHRyaWJ1dGVzOiB7XHJcbiAgICB0aXRsZToge1xyXG4gICAgICBzb3VyY2U6IFwidGV4dFwiLFxyXG4gICAgICBzZWxlY3RvcjogXCIubmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX3RpdGxlXCIsXHJcbiAgICB9LFxyXG4gICAgYm9keToge1xyXG4gICAgICBzb3VyY2U6IFwidGV4dFwiLFxyXG4gICAgICBzZWxlY3RvcjogXCIubmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2JvZHlcIixcclxuICAgIH0sXHJcbiAgICBsaW5rVGV4dDoge1xyXG4gICAgICB0eXBlOiBcInN0cmluZ1wiLFxyXG4gICAgICBzb3VyY2U6IFwidGV4dFwiLFxyXG4gICAgICBzZWxlY3RvcjogXCIubmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2J1dHRvblRleHRcIixcclxuICAgIH0sXHJcbiAgICBsaW5rVVJMOiB7XHJcbiAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIHNvdXJjZTogXCJhdHRyaWJ1dGVcIixcclxuICAgICAgYXR0cmlidXRlOiBcImhyZWZcIixcclxuICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19idXR0b25cIixcclxuICAgICAgZGVmYXVsdDogXCIjXCIsXHJcbiAgICB9LFxyXG4gICAgaW1hZ2U6IHtcclxuICAgICAgdHlwZTogXCJvYmplY3RcIixcclxuICAgICAgdXJsOiB7XHJcbiAgICAgICAgdHlwZTogXCJzdHJpbmdcIixcclxuICAgICAgICBzb3VyY2U6IFwiYXR0cmlidXRlXCIsXHJcbiAgICAgICAgYXR0cmlidXRlOiBcInNyY1wiLFxyXG4gICAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9fZmlndXJlIGltZ1wiLFxyXG4gICAgICB9LFxyXG4gICAgICBhbHQ6IHtcclxuICAgICAgICB0eXBlOiBcInN0cmluZ1wiLFxyXG4gICAgICAgIHNvdXJjZTogXCJhdHRyaWJ1dGVcIixcclxuICAgICAgICBhdHRyaWJ1dGU6IFwiYWx0XCIsXHJcbiAgICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19maWd1cmUgaW1nXCIsXHJcbiAgICAgICAgZGVmYXVsdDogXCJcIixcclxuICAgICAgfSxcclxuICAgICAgd2lkdGg6IHtcclxuICAgICAgICB0eXBlOiBcImludGVnZXJcIixcclxuICAgICAgICBzb3VyY2U6IFwiYXR0cmlidXRlXCIsXHJcbiAgICAgICAgYXR0cmlidXRlOiBcIndpZHRoXCIsXHJcbiAgICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19maWd1cmUgaW1nXCIsXHJcbiAgICAgIH0sXHJcbiAgICAgIGhlaWdodDoge1xyXG4gICAgICAgIHR5cGU6IFwiaW50ZWdlclwiLFxyXG4gICAgICAgIHNvdXJjZTogXCJhdHRyaWJ1dGVcIixcclxuICAgICAgICBhdHRyaWJ1dGU6IFwiaGVpZ2h0XCIsXHJcbiAgICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19maWd1cmUgaW1nXCIsXHJcbiAgICAgIH0sXHJcbiAgICB9LFxyXG4gICAgaW1hZ2VDYXB0aW9uOiB7XHJcbiAgICAgIHR5cGU6IFwic3RyaW5nXCIsXHJcbiAgICAgIHNvdXJjZTogXCJtZXRhXCIsXHJcbiAgICAgIG1ldGE6IFwic291cmNlX2NyZWRpdFwiLFxyXG4gICAgfSxcclxuICAgIGltYWdlSUQ6IHtcclxuICAgICAgdHlwZTogXCJpbnRlZ2VyXCIsXHJcbiAgICB9LFxyXG4gIH0sXHJcbiAgZWRpdCh7IGF0dHJpYnV0ZXMsIGNsYXNzTmFtZSwgc2V0QXR0cmlidXRlcyB9KSB7XHJcbiAgICBjb25zdCBnZXRJbWFnZUJ1dHRvbiA9IChvcGVuRXZlbnQpID0+IHtcclxuICAgICAgaWYgKGF0dHJpYnV0ZXMuaW1hZ2UudXJsKSB7XHJcbiAgICAgICAgcmV0dXJuIChcclxuICAgICAgICAgIDxpbWdcclxuICAgICAgICAgICAgc3JjPXthdHRyaWJ1dGVzLmltYWdlLnVybH1cclxuICAgICAgICAgICAgb25DbGljaz17b3BlbkV2ZW50fVxyXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9faW1hZ2VcIlxyXG4gICAgICAgICAgLz5cclxuICAgICAgICApO1xyXG4gICAgICB9IGVsc2Uge1xyXG4gICAgICAgIHJldHVybiAoXHJcbiAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImJ1dHRvbi1jb250YWluZXJcIj5cclxuICAgICAgICAgICAgPEJ1dHRvbiBvbkNsaWNrPXtvcGVuRXZlbnR9IGNsYXNzTmFtZT1cImJ1dHRvbiBidXR0b24tbGFyZ2VcIj5cclxuICAgICAgICAgICAgICBQaWNrIGFuIGltYWdlXHJcbiAgICAgICAgICAgIDwvQnV0dG9uPlxyXG4gICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgKTtcclxuICAgICAgfVxyXG4gICAgfTtcclxuXHJcbiAgICByZXR1cm4gW1xyXG4gICAgICBhdHRyaWJ1dGVzLmltYWdlSUQgJiYgKFxyXG4gICAgICAgIDxJbnNwZWN0b3JDb250cm9scz5cclxuICAgICAgICAgIDxQYW5lbEJvZHkgdGl0bGU9XCJJbWFnZSBTZXR0aW5nc1wiPlxyXG4gICAgICAgICAgICA8VGV4dGFyZWFDb250cm9sXHJcbiAgICAgICAgICAgICAgbGFiZWw9XCJBbHQgdGV4dCAoYWx0ZXJuYXRpdmUgdGV4dClcIlxyXG4gICAgICAgICAgICAgIHZhbHVlPXthdHRyaWJ1dGVzLmltYWdlLmFsdH1cclxuICAgICAgICAgICAgICBvbkNoYW5nZT17KGFsdCkgPT4ge1xyXG4gICAgICAgICAgICAgICAgY29uc3QgaW1hZ2UgPSB7IC4uLmF0dHJpYnV0ZXMuaW1hZ2UgfTtcclxuICAgICAgICAgICAgICAgIGltYWdlLmFsdCA9IGFsdDtcclxuICAgICAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoeyBpbWFnZTogaW1hZ2UgfSk7XHJcbiAgICAgICAgICAgICAgfX1cclxuICAgICAgICAgICAgICBoZWxwPXtcclxuICAgICAgICAgICAgICAgIDxkaXY+XHJcbiAgICAgICAgICAgICAgICAgIDxFeHRlcm5hbExpbmsgaHJlZj1cImh0dHBzOi8vd3d3LnczLm9yZy9XQUkvdHV0b3JpYWxzL2ltYWdlcy9kZWNpc2lvbi10cmVlXCI+XHJcbiAgICAgICAgICAgICAgICAgICAgRGVzY3JpYmUgdGhlIHB1cnBvc2Ugb2YgdGhlIGltYWdlXHJcbiAgICAgICAgICAgICAgICAgIDwvRXh0ZXJuYWxMaW5rPlxyXG4gICAgICAgICAgICAgICAgICBMZWF2ZSBlbXB0eSBpZiB0aGUgaW1hZ2UgaXMgcHVyZWx5IGRlY29yYXRpdmUuXHJcbiAgICAgICAgICAgICAgICA8L2Rpdj5cclxuICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIC8+XHJcbiAgICAgICAgICA8L1BhbmVsQm9keT5cclxuICAgICAgICA8L0luc3BlY3RvckNvbnRyb2xzPlxyXG4gICAgICApLFxyXG4gICAgICA8ZGl2IGNsYXNzTmFtZT1cImNvbnRhaW5lciBuaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cFwiPlxyXG4gICAgICAgIDxQbGFpblRleHRcclxuICAgICAgICAgIG9uQ2hhbmdlPXsoY29udGVudCkgPT4gc2V0QXR0cmlidXRlcyh7IHRpdGxlOiBjb250ZW50IH0pfVxyXG4gICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMudGl0bGV9XHJcbiAgICAgICAgICBwbGFjZWhvbGRlcj1cIllvdXIgY2FyZCB0aXRsZVwiXHJcbiAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9fdGl0bGVcIlxyXG4gICAgICAgIC8+XHJcbiAgICAgICAgPFBsYWluVGV4dFxyXG4gICAgICAgICAgb25DaGFuZ2U9eyhjb250ZW50KSA9PiBzZXRBdHRyaWJ1dGVzKHsgYm9keTogY29udGVudCB9KX1cclxuICAgICAgICAgIHZhbHVlPXthdHRyaWJ1dGVzLmJvZHl9XHJcbiAgICAgICAgICBwbGFjZWhvbGRlcj1cIllvdXIgY2FyZCB0ZXh0XCJcclxuICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19ib2R5XCJcclxuICAgICAgICAvPlxyXG4gICAgICAgIDxzZWN0aW9uIGNsYXNzTmFtZT1cIm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19idXR0b25FZGl0b3JcIj5cclxuICAgICAgICAgIDxQbGFpblRleHRcclxuICAgICAgICAgICAgb25DaGFuZ2U9eyhjb250ZW50KSA9PiBzZXRBdHRyaWJ1dGVzKHsgbGlua1RleHQ6IGNvbnRlbnQgfSl9XHJcbiAgICAgICAgICAgIHZhbHVlPXthdHRyaWJ1dGVzLmxpbmtUZXh0fVxyXG4gICAgICAgICAgICBwbGFjZWhvbGRlcj1cIkJ1dHRvbiB0ZXh0XCJcclxuICAgICAgICAgICAgY2xhc3NOYW1lPVwibmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2J1dHRvblRleHRcIlxyXG4gICAgICAgICAgLz5cclxuICAgICAgICAgIDxVUkxJbnB1dEJ1dHRvblxyXG4gICAgICAgICAgICB1cmw9e2F0dHJpYnV0ZXMubGlua1VSTH1cclxuICAgICAgICAgICAgb25DaGFuZ2U9eyh1cmwsIHBvc3QpID0+IHNldEF0dHJpYnV0ZXMoeyBsaW5rVVJMOiB1cmwgfSl9XHJcbiAgICAgICAgICAvPlxyXG4gICAgICAgIDwvc2VjdGlvbj5cclxuICAgICAgICA8TWVkaWFVcGxvYWRcclxuICAgICAgICAgIG9uU2VsZWN0PXsobWVkaWEpID0+IHtcclxuICAgICAgICAgICAgc2V0QXR0cmlidXRlcyh7XHJcbiAgICAgICAgICAgICAgaW1hZ2U6IHtcclxuICAgICAgICAgICAgICAgIHVybDogbWVkaWEuc2l6ZXMubmhzbV9oZWFkc2hvdC51cmwsXHJcbiAgICAgICAgICAgICAgICBhbHQ6IG1lZGlhLmFsdCxcclxuICAgICAgICAgICAgICAgIHdpZHRoOiBtZWRpYS5zaXplcy5uaHNtX2hlYWRzaG90LndpZHRoLFxyXG4gICAgICAgICAgICAgICAgaGVpZ2h0OiBtZWRpYS5zaXplcy5uaHNtX2hlYWRzaG90LmhlaWdodCxcclxuICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgIGltYWdlSUQ6IG1lZGlhLmlkLFxyXG4gICAgICAgICAgICB9KTtcclxuICAgICAgICAgIH19XHJcbiAgICAgICAgICB0eXBlPVwiaW1hZ2VcIlxyXG4gICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMuaW1hZ2VJRH1cclxuICAgICAgICAgIHJlbmRlcj17KHsgb3BlbiB9KSA9PiBnZXRJbWFnZUJ1dHRvbihvcGVuKX1cclxuICAgICAgICAvPlxyXG4gICAgICA8L2Rpdj4sXHJcbiAgICBdO1xyXG4gIH0sXHJcbiAgc2F2ZSh7IGF0dHJpYnV0ZXMgfSkge1xyXG4gICAgY29uc3QgaW1hZ2UgPSAoaW1hZ2UsIGltYWdlSUQpID0+IHtcclxuICAgICAgaWYgKCFpbWFnZSkgcmV0dXJuIG51bGw7XHJcbiAgICAgIGNvbnN0IGNsYXNzTGlzdCA9IFwiaW1nLXJlc3BvbnNpdmUgd3AtaW1hZ2UtXCIgKyBpbWFnZUlEO1xyXG5cclxuICAgICAgaWYgKGltYWdlLmFsdCAhPT0gXCJcIikge1xyXG4gICAgICAgIHJldHVybiAoXHJcbiAgICAgICAgICA8aW1nXHJcbiAgICAgICAgICAgIHNyYz17aW1hZ2UudXJsfVxyXG4gICAgICAgICAgICB3aWR0aD17aW1hZ2Uud2lkdGh9XHJcbiAgICAgICAgICAgIGhlaWdodD17aW1hZ2UuaGVpZ2h0fVxyXG4gICAgICAgICAgICBhbHQ9e2ltYWdlLmFsdH1cclxuICAgICAgICAgICAgY2xhc3NOYW1lPXtjbGFzc0xpc3R9XHJcbiAgICAgICAgICAvPlxyXG4gICAgICAgICk7XHJcbiAgICAgIH1cclxuXHJcbiAgICAgIC8vIE5vIGFsdCBzZXQsIHNvIGxldCdzIGhpZGUgaXQgZnJvbSBzY3JlZW4gcmVhZGVyc1xyXG4gICAgICByZXR1cm4gKFxyXG4gICAgICAgIDxpbWdcclxuICAgICAgICAgIHNyYz17aW1hZ2UudXJsfVxyXG4gICAgICAgICAgd2lkdGg9e2ltYWdlLndpZHRofVxyXG4gICAgICAgICAgaGVpZ2h0PXtpbWFnZS5oZWlnaHR9XHJcbiAgICAgICAgICBhbHQ9XCJcIlxyXG4gICAgICAgICAgYXJpYS1oaWRkZW49XCJ0cnVlXCJcclxuICAgICAgICAgIGNsYXNzTmFtZT17Y2xhc3NMaXN0fVxyXG4gICAgICAgIC8+XHJcbiAgICAgICk7XHJcbiAgICB9O1xyXG4gICAgcmV0dXJuIChcclxuICAgICAgPHNlY3Rpb24gY2xhc3NOYW1lPVwiaG9tZXBhZ2Utc2VjdGlvbiBuaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cFwiPlxyXG4gICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29udGFpbmVyIG5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19pbm5lclwiPlxyXG4gICAgICAgICAgPGgyIGNsYXNzTmFtZT1cIm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX190aXRsZVwiPlxyXG4gICAgICAgICAgICB7YXR0cmlidXRlcy50aXRsZX1cclxuICAgICAgICAgIDwvaDI+XHJcbiAgICAgICAgICA8cCBjbGFzc05hbWU9XCJuaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9fYm9keVwiPnthdHRyaWJ1dGVzLmJvZHl9PC9wPlxyXG4gICAgICAgICAgPGFcclxuICAgICAgICAgICAgaHJlZj17YXR0cmlidXRlcy5saW5rVVJMfVxyXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJidXR0b24gYnV0dG9uLS1wcmltYXJ5IGJ1dHRvbi0tcHJvbWluZW50IG5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19idXR0b24gaWNvbkJ1dHRvbi0taWNvbkZpcnN0IGljb25CdXR0b24tLWdyb3dcIlxyXG4gICAgICAgICAgPlxyXG4gICAgICAgICAgICA8aSBjbGFzc05hbWU9XCJmYXMgZmEtcGFwZXItcGxhbmVcIj48L2k+XHJcbiAgICAgICAgICAgIDxzcGFuIGNsYXNzTmFtZT1cIm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19idXR0b25UZXh0XCI+XHJcbiAgICAgICAgICAgICAge2F0dHJpYnV0ZXMubGlua1RleHR9XHJcbiAgICAgICAgICAgIDwvc3Bhbj5cclxuICAgICAgICAgIDwvYT5cclxuICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwibmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2ZpZ3VyZVwiPlxyXG4gICAgICAgICAgICA8ZmlndXJlIGNsYXNzTmFtZT1cImZpZ3VyZSBmaWd1cmUtLWNhcHRpb25PdmVybGF5IGZpZ3VyZS0tY2lyY2xlXCI+XHJcbiAgICAgICAgICAgICAge2ltYWdlKGF0dHJpYnV0ZXMuaW1hZ2UsIGF0dHJpYnV0ZXMuaW1hZ2VJRCl9XHJcbiAgICAgICAgICAgICAgPGZpZ2NhcHRpb24+PC9maWdjYXB0aW9uPlxyXG4gICAgICAgICAgICA8L2ZpZ3VyZT5cclxuICAgICAgICAgIDwvZGl2PlxyXG4gICAgICAgIDwvZGl2PlxyXG4gICAgICA8L3NlY3Rpb24+XHJcbiAgICApO1xyXG4gIH0sXHJcbn0pO1xyXG4iLCIvLyByZW1vdmVkIGJ5IGV4dHJhY3QtdGV4dC13ZWJwYWNrLXBsdWdpbiIsIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luIiwiY29uc3QgeyBJbnNwZWN0b3JDb250cm9scyB9ID0gd3AuYmxvY2tFZGl0b3I7XHJcbmNvbnN0IHsgcmVnaXN0ZXJCbG9ja1R5cGUgfSA9IHdwLmJsb2NrcztcclxuY29uc3Qge1xyXG4gIFBhbmVsQm9keSxcclxuICBUZXh0Q29udHJvbCxcclxuICBTZWxlY3RDb250cm9sLFxyXG4gIFRvZ2dsZUNvbnRyb2wsXHJcbiAgU2VydmVyU2lkZVJlbmRlcixcclxufSA9IHdwLmNvbXBvbmVudHM7XHJcblxyXG5pbXBvcnQgXCIuL2VkaXRvci5zY3NzXCI7XHJcblxyXG5yZWdpc3RlckJsb2NrVHlwZShcIm5oc20td2lkZ2V0cy9jb2xsZWN0aW9uc1wiLCB7XHJcbiAgdGl0bGU6IFwiQ29sbGVjdGlvbnNcIixcclxuICBpY29uOiBcImdyaWQtdmlld1wiLFxyXG4gIGNhdGVnb3J5OiBcIndpZGdldHNcIixcclxuICBlZGl0KHsgYXR0cmlidXRlcywgY2xhc3NOYW1lLCBzZXRBdHRyaWJ1dGVzIH0pIHtcclxuICAgIHJldHVybiAoXHJcbiAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29udGFpbmVyXCI+XHJcbiAgICAgICAgPEluc3BlY3RvckNvbnRyb2xzPlxyXG4gICAgICAgICAgPFBhbmVsQm9keSB0aXRsZT1cIkNvbGxlY3Rpb25zIFNldHRpbmdzXCIgaW5pdGlhbE9wZW49e3RydWV9PlxyXG4gICAgICAgICAgICA8VGV4dENvbnRyb2xcclxuICAgICAgICAgICAgICBvbkNoYW5nZT17KHZhbHVlKSA9PlxyXG4gICAgICAgICAgICAgICAgc2V0QXR0cmlidXRlcyh7XHJcbiAgICAgICAgICAgICAgICAgIGNvdW50OiB2YWx1ZSxcclxuICAgICAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgIGxhYmVsPVwiTnVtYmVyIG9mIHJlc3VsdHMgdG8gZGlzcGxheVwiXHJcbiAgICAgICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMuY291bnR9XHJcbiAgICAgICAgICAgIC8+XHJcbiAgICAgICAgICAgIDxTZWxlY3RDb250cm9sXHJcbiAgICAgICAgICAgICAgbGFiZWw9XCJEaXNwbGF5IEZvcm1hdFwiXHJcbiAgICAgICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMuZm9ybWF0fVxyXG4gICAgICAgICAgICAgIG9wdGlvbnM9e1tcclxuICAgICAgICAgICAgICAgIHsgbGFiZWw6IFwiQ29uZGVuc2VkXCIsIHZhbHVlOiBcInN0YW1wXCIgfSxcclxuICAgICAgICAgICAgICAgIHsgbGFiZWw6IFwiQ2FyZFwiLCB2YWx1ZTogXCJjYXJkXCIgfSxcclxuICAgICAgICAgICAgICBdfVxyXG4gICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsdWUpID0+XHJcbiAgICAgICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKHtcclxuICAgICAgICAgICAgICAgICAgZm9ybWF0OiB2YWx1ZSxcclxuICAgICAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAvPlxyXG4gICAgICAgICAgICA8U2VsZWN0Q29udHJvbFxyXG4gICAgICAgICAgICAgIGxhYmVsPVwiT3JkZXIgQnlcIlxyXG4gICAgICAgICAgICAgIHZhbHVlPXthdHRyaWJ1dGVzLm9yZGVyfVxyXG4gICAgICAgICAgICAgIG9wdGlvbnM9e1tcclxuICAgICAgICAgICAgICAgIHsgbGFiZWw6IFwiQWxwaGFiZXRpY2FsbHlcIiwgdmFsdWU6IFwidGl0bGVcIiB9LFxyXG4gICAgICAgICAgICAgICAgeyBsYWJlbDogXCJSYW5kb21seVwiLCB2YWx1ZTogXCJyYW5kXCIgfSxcclxuICAgICAgICAgICAgICBdfVxyXG4gICAgICAgICAgICAgIG9uQ2hhbmdlPXsodmFsdWUpID0+XHJcbiAgICAgICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKHtcclxuICAgICAgICAgICAgICAgICAgb3JkZXI6IHZhbHVlLFxyXG4gICAgICAgICAgICAgICAgfSlcclxuICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIC8+XHJcbiAgICAgICAgICAgIDxUb2dnbGVDb250cm9sXHJcbiAgICAgICAgICAgICAgbGFiZWw9XCJXcmFwIGZvciBHcmlkXCJcclxuICAgICAgICAgICAgICBjaGVja2VkPXthdHRyaWJ1dGVzLndyYXBHcmlkfVxyXG4gICAgICAgICAgICAgIG9uQ2hhbmdlPXsoKSA9PlxyXG4gICAgICAgICAgICAgICAgc2V0QXR0cmlidXRlcyh7XHJcbiAgICAgICAgICAgICAgICAgIHdyYXBHcmlkOiAhYXR0cmlidXRlcy53cmFwR3JpZCxcclxuICAgICAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAvPlxyXG4gICAgICAgICAgPC9QYW5lbEJvZHk+XHJcbiAgICAgICAgPC9JbnNwZWN0b3JDb250cm9scz5cclxuICAgICAgICA8U2VydmVyU2lkZVJlbmRlclxyXG4gICAgICAgICAgYmxvY2s9XCJuaHNtLXdpZGdldHMvY29sbGVjdGlvbnNcIlxyXG4gICAgICAgICAgY2xhc3NOYW1lPXtgbmhzbS13aWRnZXQtY29sbGVjdGlvbnMgbmhzbS13aWRnZXQtY29sbGVjdGlvbnMtLSR7XHJcbiAgICAgICAgICAgIGF0dHJpYnV0ZXMud3JhcEdyaWQgPyBcImdyaWRcIiA6IFwibGlzdFwiXHJcbiAgICAgICAgICB9YH1cclxuICAgICAgICAgIGF0dHJpYnV0ZXM9e2F0dHJpYnV0ZXN9XHJcbiAgICAgICAgLz5cclxuICAgICAgPC9kaXY+XHJcbiAgICApO1xyXG4gIH0sXHJcbn0pO1xyXG4iLCIvLyByZW1vdmVkIGJ5IGV4dHJhY3QtdGV4dC13ZWJwYWNrLXBsdWdpbiIsImNvbnN0IHsgSW5zcGVjdG9yQ29udHJvbHMgfSA9IHdwLmJsb2NrRWRpdG9yO1xyXG5jb25zdCB7IHJlZ2lzdGVyQmxvY2tUeXBlIH0gPSB3cC5ibG9ja3M7XHJcbmNvbnN0IHsgUGFuZWxCb2R5LCBTZWxlY3RDb250cm9sLCBTZXJ2ZXJTaWRlUmVuZGVyIH0gPSB3cC5jb21wb25lbnRzO1xyXG5jb25zdCB7IHdpdGhTZWxlY3QsIHdpdGhEaXNwYXRjaCB9ID0gd3AuZGF0YTtcclxuXHJcbi8vaW1wb3J0IFwiLi9zdHlsZS5zY3NzXCI7XHJcbmltcG9ydCBcIi4vZWRpdG9yLnNjc3NcIjtcclxuXHJcbnJlZ2lzdGVyQmxvY2tUeXBlKFwibmhzbS13aWRnZXRzL3RlYW0tbGlzdFwiLCB7XHJcbiAgdGl0bGU6IFwiVGVhbSBMaXN0XCIsXHJcbiAgaWNvbjogXCJncm91cHNcIixcclxuICBjYXRlZ29yeTogXCJ3aWRnZXRzXCIsXHJcbiAgZWRpdCh7IGF0dHJpYnV0ZXMsIGNsYXNzTmFtZSwgc2V0QXR0cmlidXRlcyB9KSB7XHJcbiAgICBmdW5jdGlvbiBTZWxlY3RDb250cm9sR2VuKHsgcm9sZXMgfSkge1xyXG4gICAgICBsZXQgb3B0aW9ucyA9IFtdO1xyXG4gICAgICBpZiAocm9sZXMpIHtcclxuICAgICAgICBvcHRpb25zID0gcm9sZXMubWFwKChyb2xlKSA9PiB7XHJcbiAgICAgICAgICByZXR1cm4ge1xyXG4gICAgICAgICAgICBsYWJlbDogcm9sZS5uYW1lLnJlcGxhY2UoLyZhbXA7L2csIFwiJlwiKSxcclxuICAgICAgICAgICAgdmFsdWU6IHJvbGUuc2x1ZyxcclxuICAgICAgICAgIH07XHJcbiAgICAgICAgfSk7XHJcbiAgICAgICAgb3B0aW9ucy51bnNoaWZ0KHsgdmFsdWU6IDAsIGxhYmVsOiBcIlBsZWFzZSBzZWxlY3Qgb25lXCIgfSk7XHJcbiAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgb3B0aW9ucy5wdXNoKHsgdmFsdWU6IDAsIGxhYmVsOiBcIkxvYWRpbmcuLi5cIiB9KTtcclxuICAgICAgfVxyXG5cclxuICAgICAgcmV0dXJuIChcclxuICAgICAgICA8U2VsZWN0Q29udHJvbFxyXG4gICAgICAgICAgbGFiZWw9XCJTZWxlY3Qgcm9sZSB0byBkaXNwbGF5XCJcclxuICAgICAgICAgIHZhbHVlPXthdHRyaWJ1dGVzLnJvbGV9XHJcbiAgICAgICAgICBvcHRpb25zPXtvcHRpb25zfVxyXG4gICAgICAgICAgb25DaGFuZ2U9eyhyb2xlKSA9PiB7XHJcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoeyByb2xlIH0pO1xyXG4gICAgICAgICAgfX1cclxuICAgICAgICAvPlxyXG4gICAgICApO1xyXG4gICAgfVxyXG4gICAgY29uc3QgVGF4U2VsZWN0Q29udHJvbCA9IHdpdGhTZWxlY3QoKHNlbGVjdCkgPT4gKHtcclxuICAgICAgcm9sZXM6IHNlbGVjdChcImNvcmVcIikuZ2V0RW50aXR5UmVjb3JkcyhcInRheG9ub215XCIsIFwibmhzbV9yb2xlXCIsIHtcclxuICAgICAgICBwZXJfcGFnZTogLTEsXHJcbiAgICAgIH0pLFxyXG4gICAgfSkpKFNlbGVjdENvbnRyb2xHZW4pO1xyXG5cclxuICAgIHJldHVybiAoXHJcbiAgICAgIDxkaXYgY2xhc3NOYW1lPVwiY29udGFpbmVyIG5oc21fd2lkZ2V0c190ZWFtX2xpc3RcIj5cclxuICAgICAgICA8SW5zcGVjdG9yQ29udHJvbHM+XHJcbiAgICAgICAgICA8UGFuZWxCb2R5IHRpdGxlPVwiVGVhbSBMaXN0IFNldHRpbmdzXCIgaW5pdGlhbE9wZW49e3RydWV9PlxyXG4gICAgICAgICAgICA8VGF4U2VsZWN0Q29udHJvbCAvPlxyXG4gICAgICAgICAgPC9QYW5lbEJvZHk+XHJcbiAgICAgICAgPC9JbnNwZWN0b3JDb250cm9scz5cclxuICAgICAgICA8U2VydmVyU2lkZVJlbmRlclxyXG4gICAgICAgICAgYmxvY2s9XCJuaHNtLXdpZGdldHMvdGVhbS1saXN0XCJcclxuICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc21fd2lkZ2V0c190ZWFtX2xpc3RfZ3JpZFwiXHJcbiAgICAgICAgICBhdHRyaWJ1dGVzPXthdHRyaWJ1dGVzfVxyXG4gICAgICAgIC8+XHJcbiAgICAgIDwvZGl2PlxyXG4gICAgKTtcclxuICB9LFxyXG59KTtcclxuIiwiLy8gcmVtb3ZlZCBieSBleHRyYWN0LXRleHQtd2VicGFjay1wbHVnaW4iXSwic291cmNlUm9vdCI6IiJ9