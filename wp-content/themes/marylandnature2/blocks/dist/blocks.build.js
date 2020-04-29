/******/ (function (modules) {
  // webpackBootstrap
  /******/ // The module cache
  /******/ var installedModules = {}; // The require function
  /******/
  /******/ /******/ function __webpack_require__(moduleId) {
    /******/
    /******/ // Check if module is in cache
    /******/ if (installedModules[moduleId]) {
      /******/ return installedModules[moduleId].exports;
      /******/
    } // Create a new module (and put it into the cache)
    /******/ /******/ var module = (installedModules[moduleId] = {
      /******/ i: moduleId,
      /******/ l: false,
      /******/ exports: {},
      /******/
    }); // Execute the module function
    /******/
    /******/ /******/ modules[moduleId].call(
      module.exports,
      module,
      module.exports,
      __webpack_require__
    ); // Flag the module as loaded
    /******/
    /******/ /******/ module.l = true; // Return the exports of the module
    /******/
    /******/ /******/ return module.exports;
    /******/
  } // expose the modules object (__webpack_modules__)
  /******/
  /******/
  /******/ /******/ __webpack_require__.m = modules; // expose the module cache
  /******/
  /******/ /******/ __webpack_require__.c = installedModules; // define getter function for harmony exports
  /******/
  /******/ /******/ __webpack_require__.d = function (exports, name, getter) {
    /******/ if (!__webpack_require__.o(exports, name)) {
      /******/ Object.defineProperty(exports, name, {
        enumerable: true,
        get: getter,
      });
      /******/
    }
    /******/
  }; // define __esModule on exports
  /******/
  /******/ /******/ __webpack_require__.r = function (exports) {
    /******/ if (typeof Symbol !== "undefined" && Symbol.toStringTag) {
      /******/ Object.defineProperty(exports, Symbol.toStringTag, {
        value: "Module",
      });
      /******/
    }
    /******/ Object.defineProperty(exports, "__esModule", { value: true });
    /******/
  }; // create a fake namespace object // mode & 1: value is a module id, require it // mode & 2: merge all properties of value into the ns // mode & 4: return value when already ns object // mode & 8|1: behave like require
  /******/
  /******/ /******/ /******/ /******/ /******/ /******/ __webpack_require__.t = function (
    value,
    mode
  ) {
    /******/ if (mode & 1) value = __webpack_require__(value);
    /******/ if (mode & 8) return value;
    /******/ if (
      mode & 4 &&
      typeof value === "object" &&
      value &&
      value.__esModule
    )
      return value;
    /******/ var ns = Object.create(null);
    /******/ __webpack_require__.r(ns);
    /******/ Object.defineProperty(ns, "default", {
      enumerable: true,
      value: value,
    });
    /******/ if (mode & 2 && typeof value != "string")
      for (var key in value)
        __webpack_require__.d(
          ns,
          key,
          function (key) {
            return value[key];
          }.bind(null, key)
        );
    /******/ return ns;
    /******/
  }; // getDefaultExport function for compatibility with non-harmony modules
  /******/
  /******/ /******/ __webpack_require__.n = function (module) {
    /******/ var getter =
      module && module.__esModule
        ? /******/ function getDefault() {
            return module["default"];
          }
        : /******/ function getModuleExports() {
            return module;
          };
    /******/ __webpack_require__.d(getter, "a", getter);
    /******/ return getter;
    /******/
  }; // Object.prototype.hasOwnProperty.call
  /******/
  /******/ /******/ __webpack_require__.o = function (object, property) {
    return Object.prototype.hasOwnProperty.call(object, property);
  }; // __webpack_public_path__
  /******/
  /******/ /******/ __webpack_require__.p = ""; // Load entry module and return exports
  /******/
  /******/
  /******/ /******/ return __webpack_require__(
    (__webpack_require__.s = "./blocks/src/blocks.js")
  );
  /******/
})(
  /************************************************************************/
  /******/ {
    /***/ "./blocks/src/blocks.js":
      /*!******************************!*\
  !*** ./blocks/src/blocks.js ***!
  \******************************/
      /*! no exports provided */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _featurettes_collections_block__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
          /*! ./featurettes/collections/block */ "./blocks/src/featurettes/collections/block.js"
        );
        /* harmony import */ var _featurettes_newsletter_signup_block__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
          /*! ./featurettes/newsletter-signup/block */ "./blocks/src/featurettes/newsletter-signup/block.js"
        );
        /* harmony import */ var _widgets_collections_block__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
          /*! ./widgets/collections/block */ "./blocks/src/widgets/collections/block.js"
        );

        /***/
      },

    /***/ "./blocks/src/featurettes/collections/block.js":
      /*!*****************************************************!*\
  !*** ./blocks/src/featurettes/collections/block.js ***!
  \*****************************************************/
      /*! no exports provided */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
          /*! ./style.scss */ "./blocks/src/featurettes/collections/style.scss"
        );
        /* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/ __webpack_require__.n(
          _style_scss__WEBPACK_IMPORTED_MODULE_0__
        );
        /* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
          /*! ./editor.scss */ "./blocks/src/featurettes/collections/editor.scss"
        );
        /* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/ __webpack_require__.n(
          _editor_scss__WEBPACK_IMPORTED_MODULE_1__
        );
        function _createForOfIteratorHelper(o) {
          if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) {
            if (Array.isArray(o) || (o = _unsupportedIterableToArray(o))) {
              var i = 0;
              var F = function F() {};
              return {
                s: F,
                n: function n() {
                  if (i >= o.length) return { done: true };
                  return { done: false, value: o[i++] };
                },
                e: function e(_e) {
                  throw _e;
                },
                f: F,
              };
            }
            throw new TypeError(
              "Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."
            );
          }
          var it,
            normalCompletion = true,
            didErr = false,
            err;
          return {
            s: function s() {
              it = o[Symbol.iterator]();
            },
            n: function n() {
              var step = it.next();
              normalCompletion = step.done;
              return step;
            },
            e: function e(_e2) {
              didErr = true;
              err = _e2;
            },
            f: function f() {
              try {
                if (!normalCompletion && it["return"] != null) it["return"]();
              } finally {
                if (didErr) throw err;
              }
            },
          };
        }

        function _unsupportedIterableToArray(o, minLen) {
          if (!o) return;
          if (typeof o === "string") return _arrayLikeToArray(o, minLen);
          var n = Object.prototype.toString.call(o).slice(8, -1);
          if (n === "Object" && o.constructor) n = o.constructor.name;
          if (n === "Map" || n === "Set") return Array.from(n);
          if (
            n === "Arguments" ||
            /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)
          )
            return _arrayLikeToArray(o, minLen);
        }

        function _arrayLikeToArray(arr, len) {
          if (len == null || len > arr.length) len = arr.length;
          for (var i = 0, arr2 = new Array(len); i < len; i++) {
            arr2[i] = arr[i];
          }
          return arr2;
        }

        function ownKeys(object, enumerableOnly) {
          var keys = Object.keys(object);
          if (Object.getOwnPropertySymbols) {
            var symbols = Object.getOwnPropertySymbols(object);
            if (enumerableOnly)
              symbols = symbols.filter(function (sym) {
                return Object.getOwnPropertyDescriptor(object, sym).enumerable;
              });
            keys.push.apply(keys, symbols);
          }
          return keys;
        }

        function _objectSpread(target) {
          for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i] != null ? arguments[i] : {};
            if (i % 2) {
              ownKeys(Object(source), true).forEach(function (key) {
                _defineProperty(target, key, source[key]);
              });
            } else if (Object.getOwnPropertyDescriptors) {
              Object.defineProperties(
                target,
                Object.getOwnPropertyDescriptors(source)
              );
            } else {
              ownKeys(Object(source)).forEach(function (key) {
                Object.defineProperty(
                  target,
                  key,
                  Object.getOwnPropertyDescriptor(source, key)
                );
              });
            }
          }
          return target;
        }

        function _defineProperty(obj, key, value) {
          if (key in obj) {
            Object.defineProperty(obj, key, {
              value: value,
              enumerable: true,
              configurable: true,
              writable: true,
            });
          } else {
            obj[key] = value;
          }
          return obj;
        }

        var _wp$blockEditor = wp.blockEditor,
          InspectorControls = _wp$blockEditor.InspectorControls,
          MediaUpload = _wp$blockEditor.MediaUpload,
          PlainText = _wp$blockEditor.PlainText,
          RichText = _wp$blockEditor.RichText,
          PanelColorSettings = _wp$blockEditor.PanelColorSettings,
          InnerBlocks = _wp$blockEditor.InnerBlocks;
        var registerBlockType = wp.blocks.registerBlockType;
        var _wp$components = wp.components,
          Button = _wp$components.Button,
          Disabled = _wp$components.Disabled,
          ServerSideRender = _wp$components.ServerSideRender;

        registerBlockType("nhsm-featurettes/collections", {
          title: "Collections CTA",
          icon: "grid-view",
          category: "nhsm-featurettes",
          attributes: {
            title: {
              source: "text",
              selector: ".nhsm-cta-collections__title",
            },
            lead: {
              source: "text",
              selector: ".nhsm-cta-collections__lead",
            },
            cta: {
              type: "string",
              source: "html",
              selector: ".nhsm-cta-collections__collectionsGridTitle",
            },
            componentStyles: {
              type: "object",
              backgroundImage: {},
              backgroundColor: "",
              color: "",
            },
            bgImageID: {
              type: "integer",
            },
          },
          edit: function edit(_ref) {
            var attributes = _ref.attributes,
              className = _ref.className,
              setAttributes = _ref.setAttributes;

            var getImageButton = function getImageButton(openEvent) {
              if (attributes.bgImageID) {
                return wp.element.createElement(
                  "div",
                  {
                    className: "img-container",
                  },
                  wp.element.createElement(
                    Button,
                    {
                      onClick: openEvent,
                      className: "button button-large",
                    },
                    "Change image"
                  ),
                  wp.element.createElement(
                    Button,
                    {
                      onClick: function onClick() {
                        var styles = _objectSpread(
                          {},
                          attributes.componentStyles
                        );

                        styles.backgroundImage = null;
                        setAttributes({
                          bgImageID: 0,
                          componentStyles: styles,
                        });
                      },
                      className: "button button-large",
                    },
                    "Remove Image"
                  )
                );
              } else {
                return wp.element.createElement(
                  "div",
                  {
                    className: "img-container",
                  },
                  wp.element.createElement(
                    Button,
                    {
                      onClick: openEvent,
                      className: "button button-large",
                    },
                    "Pick an image"
                  )
                );
              }
            };

            return [
              wp.element.createElement(
                InspectorControls,
                null,
                wp.element.createElement(PanelColorSettings, {
                  title: "Color Settings",
                  colorSettings: [
                    {
                      value: attributes.componentStyles.backgroundColor,
                      onChange: function onChange(colorValue) {
                        var styles = _objectSpread(
                          {},
                          attributes.componentStyles
                        );

                        styles.backgroundColor = colorValue;
                        setAttributes({
                          componentStyles: styles,
                        });
                      },
                      label: "Background Color",
                    },
                    {
                      value: attributes.componentStyles.color,
                      onChange: function onChange(colorValue) {
                        var styles = _objectSpread(
                          {},
                          attributes.componentStyles
                        );

                        styles.color = colorValue;
                        setAttributes({
                          componentStyles: styles,
                        });
                      },
                      label: "Text Color",
                    },
                  ],
                })
              ),
              wp.element.createElement(
                "section",
                {
                  className: "container",
                },
                wp.element.createElement(
                  "div",
                  {
                    className: "nhsm-cta-collections",
                    style: attributes.componentStyles,
                  },
                  wp.element.createElement(PlainText, {
                    onChange: function onChange(content) {
                      return setAttributes({
                        title: content,
                      });
                    },
                    value: attributes.title,
                    placeholder: "Call to action title",
                    className: "nhsm-cta-collections__title",
                  }),
                  wp.element.createElement(PlainText, {
                    onChange: function onChange(content) {
                      return setAttributes({
                        lead: content,
                      });
                    },
                    value: attributes.lead,
                    placeholder: "Call to action text",
                    className: "nhsm-cta-collections__lead",
                  }),
                  wp.element.createElement(RichText, {
                    tagName: "h3",
                    className: "nhsm-cta-collections__collectionsGridTitle",
                    placeholder:
                      "The call to action (include link to destination)",
                    value: attributes.cta,
                    onChange: function onChange(content) {
                      return setAttributes({
                        cta: content,
                      });
                    },
                    multiline: false,
                    allowedFormats: ["core/link"],
                  }),
                  wp.element.createElement(ServerSideRender, {
                    block: "nhsm-widgets/collections",
                    className: "nhsm-cta-collections__collectionsGrid",
                    attributes: {
                      count: 3,
                    },
                  })
                ),
                wp.element.createElement(MediaUpload, {
                  onSelect: function onSelect(media) {
                    var styles = _objectSpread({}, attributes.componentStyles);

                    styles.backgroundImage = "url(" + media.url + ")";
                    setAttributes({
                      bgImageID: media.id,
                      componentStyles: styles,
                    });
                  },
                  type: "image",
                  value: attributes.bgImageID,
                  render: function render(_ref2) {
                    var open = _ref2.open;
                    return getImageButton(open);
                  },
                })
              ),
            ];
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
                for (_iterator.s(); !(_step = _iterator.n()).done; ) {
                  var link = _step.value;
                  link.classList.add(
                    "button",
                    "button--primary",
                    "button--prominent",
                    "nhsm-cta-collections__button"
                  );
                }
              } catch (err) {
                _iterator.e(err);
              } finally {
                _iterator.f();
              }

              return {
                __html: cta.body.innerHTML,
              };
            };

            return wp.element.createElement(
              "section",
              {
                className: "homepage-section nhsm-cta-collections",
                style: attributes.componentStyles,
              },
              wp.element.createElement(
                "div",
                {
                  className: "container nhsm-cta-collections__inner",
                },
                wp.element.createElement(
                  "h2",
                  {
                    className: "nhsm-cta-collections__title",
                  },
                  attributes.title
                ),
                wp.element.createElement(
                  "p",
                  {
                    className: "nhsm-cta-collections__lead",
                  },
                  attributes.lead
                ),
                wp.element.createElement(
                  "section",
                  {
                    className: "nhsm-cta-collections__collectionGrid",
                  },
                  wp.element.createElement("h3", {
                    className: "nhsm-cta-collections__collectionsGridTitle",
                    dangerouslySetInnerHTML: ctaMarkup(),
                  }),
                  wp.element.createElement("div", {
                    id: "collections_list",
                  })
                )
              )
            );
          },
        });

        /***/
      },

    /***/ "./blocks/src/featurettes/collections/editor.scss":
      /*!********************************************************!*\
  !*** ./blocks/src/featurettes/collections/editor.scss ***!
  \********************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        // removed by extract-text-webpack-plugin
        /***/
      },

    /***/ "./blocks/src/featurettes/collections/style.scss":
      /*!*******************************************************!*\
  !*** ./blocks/src/featurettes/collections/style.scss ***!
  \*******************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        // removed by extract-text-webpack-plugin
        /***/
      },

    /***/ "./blocks/src/featurettes/newsletter-signup/block.js":
      /*!***********************************************************!*\
  !*** ./blocks/src/featurettes/newsletter-signup/block.js ***!
  \***********************************************************/
      /*! no exports provided */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
          /*! ./style.scss */ "./blocks/src/featurettes/newsletter-signup/style.scss"
        );
        /* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/ __webpack_require__.n(
          _style_scss__WEBPACK_IMPORTED_MODULE_0__
        );
        /* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
          /*! ./editor.scss */ "./blocks/src/featurettes/newsletter-signup/editor.scss"
        );
        /* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/ __webpack_require__.n(
          _editor_scss__WEBPACK_IMPORTED_MODULE_1__
        );
        function ownKeys(object, enumerableOnly) {
          var keys = Object.keys(object);
          if (Object.getOwnPropertySymbols) {
            var symbols = Object.getOwnPropertySymbols(object);
            if (enumerableOnly)
              symbols = symbols.filter(function (sym) {
                return Object.getOwnPropertyDescriptor(object, sym).enumerable;
              });
            keys.push.apply(keys, symbols);
          }
          return keys;
        }

        function _objectSpread(target) {
          for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i] != null ? arguments[i] : {};
            if (i % 2) {
              ownKeys(Object(source), true).forEach(function (key) {
                _defineProperty(target, key, source[key]);
              });
            } else if (Object.getOwnPropertyDescriptors) {
              Object.defineProperties(
                target,
                Object.getOwnPropertyDescriptors(source)
              );
            } else {
              ownKeys(Object(source)).forEach(function (key) {
                Object.defineProperty(
                  target,
                  key,
                  Object.getOwnPropertyDescriptor(source, key)
                );
              });
            }
          }
          return target;
        }

        function _defineProperty(obj, key, value) {
          if (key in obj) {
            Object.defineProperty(obj, key, {
              value: value,
              enumerable: true,
              configurable: true,
              writable: true,
            });
          } else {
            obj[key] = value;
          }
          return obj;
        }

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
              selector: ".nhsm-cta-newsletter-signup__title",
            },
            body: {
              source: "text",
              selector: ".nhsm-cta-newsletter-signup__body",
            },
            linkText: {
              type: "string",
              source: "text",
              selector: ".nhsm-cta-newsletter-signup__buttonText",
            },
            linkURL: {
              type: "string",
              source: "attribute",
              attribute: "href",
              selector: ".nhsm-cta-newsletter-signup__button",
              default: "#",
            },
            image: {
              type: "object",
              url: {
                type: "string",
                source: "attribute",
                attribute: "src",
                selector: ".nhsm-cta-newsletter-signup__figure img",
              },
              alt: {
                type: "string",
                source: "attribute",
                attribute: "alt",
                selector: ".nhsm-cta-newsletter-signup__figure img",
                default: "",
              },
              width: {
                type: "integer",
                source: "attribute",
                attribute: "width",
                selector: ".nhsm-cta-newsletter-signup__figure img",
              },
              height: {
                type: "integer",
                source: "attribute",
                attribute: "height",
                selector: ".nhsm-cta-newsletter-signup__figure img",
              },
            },
            imageCaption: {
              type: "string",
              source: "meta",
              meta: "source_credit",
            },
            imageID: {
              type: "integer",
            },
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
                  className: "nhsm-cta-newsletter-signup__image",
                });
              } else {
                return wp.element.createElement(
                  "div",
                  {
                    className: "button-container",
                  },
                  wp.element.createElement(
                    Button,
                    {
                      onClick: openEvent,
                      className: "button button-large",
                    },
                    "Pick an image"
                  )
                );
              }
            };

            return [
              attributes.imageID &&
                wp.element.createElement(
                  InspectorControls,
                  null,
                  wp.element.createElement(
                    PanelBody,
                    {
                      title: "Image Settings",
                    },
                    wp.element.createElement(TextareaControl, {
                      label: "Alt text (alternative text)",
                      value: attributes.image.alt,
                      onChange: function onChange(alt) {
                        var image = _objectSpread({}, attributes.image);

                        image.alt = alt;
                        setAttributes({
                          image: image,
                        });
                      },
                      help: wp.element.createElement(
                        "div",
                        null,
                        wp.element.createElement(
                          ExternalLink,
                          {
                            href:
                              "https://www.w3.org/WAI/tutorials/images/decision-tree",
                          },
                          "Describe the purpose of the image"
                        ),
                        "Leave empty if the image is purely decorative."
                      ),
                    })
                  )
                ),
              wp.element.createElement(
                "div",
                {
                  className: "container nhsm-cta-newsletter-signup",
                },
                wp.element.createElement(PlainText, {
                  onChange: function onChange(content) {
                    return setAttributes({
                      title: content,
                    });
                  },
                  value: attributes.title,
                  placeholder: "Your card title",
                  className: "nhsm-cta-newsletter-signup__title",
                }),
                wp.element.createElement(PlainText, {
                  onChange: function onChange(content) {
                    return setAttributes({
                      body: content,
                    });
                  },
                  value: attributes.body,
                  placeholder: "Your card text",
                  className: "nhsm-cta-newsletter-signup__body",
                }),
                wp.element.createElement(
                  "section",
                  {
                    className: "nhsm-cta-newsletter-signup__buttonEditor",
                  },
                  wp.element.createElement(PlainText, {
                    onChange: function onChange(content) {
                      return setAttributes({
                        linkText: content,
                      });
                    },
                    value: attributes.linkText,
                    placeholder: "Button text",
                    className: "nhsm-cta-newsletter-signup__buttonText",
                  }),
                  wp.element.createElement(URLInputButton, {
                    url: attributes.linkURL,
                    onChange: function onChange(url, post) {
                      return setAttributes({
                        linkURL: url,
                      });
                    },
                  })
                ),
                wp.element.createElement(MediaUpload, {
                  onSelect: function onSelect(media) {
                    setAttributes({
                      image: {
                        url: media.sizes.nhsm_headshot.url,
                        alt: media.alt,
                        width: media.sizes.nhsm_headshot.width,
                        height: media.sizes.nhsm_headshot.height,
                      },
                      imageID: media.id,
                    });
                  },
                  type: "image",
                  value: attributes.imageID,
                  render: function render(_ref2) {
                    var open = _ref2.open;
                    return getImageButton(open);
                  },
                })
              ),
            ];
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
                  className: classList,
                });
              } // No alt set, so let's hide it from screen readers

              return wp.element.createElement("img", {
                src: _image.url,
                width: _image.width,
                height: _image.height,
                alt: "",
                "aria-hidden": "true",
                className: classList,
              });
            };

            return wp.element.createElement(
              "section",
              {
                className: "homepage-section nhsm-cta-newsletter-signup",
              },
              wp.element.createElement(
                "div",
                {
                  className: "container nhsm-cta-newsletter-signup__inner",
                },
                wp.element.createElement(
                  "h2",
                  {
                    className: "nhsm-cta-newsletter-signup__title",
                  },
                  attributes.title
                ),
                wp.element.createElement(
                  "p",
                  {
                    className: "nhsm-cta-newsletter-signup__body",
                  },
                  attributes.body
                ),
                wp.element.createElement(
                  "a",
                  {
                    href: attributes.linkURL,
                    className:
                      "button button--primary button--prominent nhsm-cta-newsletter-signup__button iconButton--iconFirst iconButton--grow",
                  },
                  wp.element.createElement("i", {
                    className: "fas fa-paper-plane",
                  }),
                  wp.element.createElement(
                    "span",
                    {
                      className: "nhsm-cta-newsletter-signup__buttonText",
                    },
                    attributes.linkText
                  )
                ),
                wp.element.createElement(
                  "div",
                  {
                    className: "nhsm-cta-newsletter-signup__figure",
                  },
                  wp.element.createElement(
                    "figure",
                    {
                      className: "figure figure--captionOverlay figure--circle",
                    },
                    image(attributes.image, attributes.imageID),
                    wp.element.createElement("figcaption", null)
                  )
                )
              )
            );
          },
        });

        /***/
      },

    /***/ "./blocks/src/featurettes/newsletter-signup/editor.scss":
      /*!**************************************************************!*\
  !*** ./blocks/src/featurettes/newsletter-signup/editor.scss ***!
  \**************************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        // removed by extract-text-webpack-plugin
        /***/
      },

    /***/ "./blocks/src/featurettes/newsletter-signup/style.scss":
      /*!*************************************************************!*\
  !*** ./blocks/src/featurettes/newsletter-signup/style.scss ***!
  \*************************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        // removed by extract-text-webpack-plugin
        /***/
      },

    /***/ "./blocks/src/widgets/collections/block.js":
      /*!*************************************************!*\
  !*** ./blocks/src/widgets/collections/block.js ***!
  \*************************************************/
      /*! no exports provided */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
          /*! ./style.scss */ "./blocks/src/widgets/collections/style.scss"
        );
        /* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/ __webpack_require__.n(
          _style_scss__WEBPACK_IMPORTED_MODULE_0__
        );
        /* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
          /*! ./editor.scss */ "./blocks/src/widgets/collections/editor.scss"
        );
        /* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/ __webpack_require__.n(
          _editor_scss__WEBPACK_IMPORTED_MODULE_1__
        );
        var InspectorControls = wp.blockEditor.InspectorControls;
        var registerBlockType = wp.blocks.registerBlockType;
        var _wp$components = wp.components,
          PanelBody = _wp$components.PanelBody,
          __experimentalNumberControl =
            _wp$components.__experimentalNumberControl,
          ServerSideRender = _wp$components.ServerSideRender;

        registerBlockType("nhsm-widgets/collections", {
          title: "Collections",
          icon: "grid-view",
          category: "widgets",
          edit: function edit(_ref) {
            var attributes = _ref.attributes,
              className = _ref.className,
              setAttributes = _ref.setAttributes;
            return wp.element.createElement(
              "div",
              {
                className: "container",
              },
              wp.element.createElement(
                InspectorControls,
                null,
                wp.element.createElement(
                  PanelBody,
                  {
                    title: "Collections Settings",
                    initialOpen: true,
                  },
                  wp.element.createElement(
                    "div",
                    null,
                    wp.element.createElement(__experimentalNumberControl, {
                      onChange: function onChange(number) {
                        return setAttributes({
                          count: number,
                        });
                      },
                      min: 1,
                      value: attributes.count,
                      isShiftStepEnabled: false,
                    })
                  )
                )
              ),
              wp.element.createElement(ServerSideRender, {
                block: "nhsm-widgets/collections",
                className: "blocks-gallery-grid",
                attributes: attributes,
              })
            );
          },
        });

        /***/
      },

    /***/ "./blocks/src/widgets/collections/editor.scss":
      /*!****************************************************!*\
  !*** ./blocks/src/widgets/collections/editor.scss ***!
  \****************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        // removed by extract-text-webpack-plugin
        /***/
      },

    /***/ "./blocks/src/widgets/collections/style.scss":
      /*!***************************************************!*\
  !*** ./blocks/src/widgets/collections/style.scss ***!
  \***************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        // removed by extract-text-webpack-plugin
        /***/
      },

    /******/
  }
);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9ibG9ja3MuanMiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9mZWF0dXJldHRlcy9jb2xsZWN0aW9ucy9ibG9jay5qcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3Mvc3JjL2ZlYXR1cmV0dGVzL2NvbGxlY3Rpb25zL2VkaXRvci5zY3NzIiwid2VicGFjazovLy8uL2Jsb2Nrcy9zcmMvZmVhdHVyZXR0ZXMvY29sbGVjdGlvbnMvc3R5bGUuc2NzcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3Mvc3JjL2ZlYXR1cmV0dGVzL25ld3NsZXR0ZXItc2lnbnVwL2Jsb2NrLmpzIiwid2VicGFjazovLy8uL2Jsb2Nrcy9zcmMvZmVhdHVyZXR0ZXMvbmV3c2xldHRlci1zaWdudXAvZWRpdG9yLnNjc3MiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy9mZWF0dXJldHRlcy9uZXdzbGV0dGVyLXNpZ251cC9zdHlsZS5zY3NzIiwid2VicGFjazovLy8uL2Jsb2Nrcy9zcmMvd2lkZ2V0cy9jb2xsZWN0aW9ucy9ibG9jay5qcyIsIndlYnBhY2s6Ly8vLi9ibG9ja3Mvc3JjL3dpZGdldHMvY29sbGVjdGlvbnMvZWRpdG9yLnNjc3MiLCJ3ZWJwYWNrOi8vLy4vYmxvY2tzL3NyYy93aWRnZXRzL2NvbGxlY3Rpb25zL3N0eWxlLnNjc3MiXSwibmFtZXMiOlsid3AiLCJibG9ja0VkaXRvciIsIkluc3BlY3RvckNvbnRyb2xzIiwiTWVkaWFVcGxvYWQiLCJQbGFpblRleHQiLCJSaWNoVGV4dCIsIlBhbmVsQ29sb3JTZXR0aW5ncyIsIklubmVyQmxvY2tzIiwicmVnaXN0ZXJCbG9ja1R5cGUiLCJibG9ja3MiLCJjb21wb25lbnRzIiwiQnV0dG9uIiwiRGlzYWJsZWQiLCJTZXJ2ZXJTaWRlUmVuZGVyIiwidGl0bGUiLCJpY29uIiwiY2F0ZWdvcnkiLCJhdHRyaWJ1dGVzIiwic291cmNlIiwic2VsZWN0b3IiLCJsZWFkIiwiY3RhIiwidHlwZSIsImNvbXBvbmVudFN0eWxlcyIsImJhY2tncm91bmRJbWFnZSIsImJhY2tncm91bmRDb2xvciIsImNvbG9yIiwiYmdJbWFnZUlEIiwiZWRpdCIsImNsYXNzTmFtZSIsInNldEF0dHJpYnV0ZXMiLCJnZXRJbWFnZUJ1dHRvbiIsIm9wZW5FdmVudCIsInN0eWxlcyIsInZhbHVlIiwib25DaGFuZ2UiLCJjb2xvclZhbHVlIiwibGFiZWwiLCJjb250ZW50IiwiY291bnQiLCJtZWRpYSIsInVybCIsImlkIiwib3BlbiIsInNhdmUiLCJjdGFNYXJrdXAiLCJkb21wYXJzZXIiLCJET01QYXJzZXIiLCJwYXJzZUZyb21TdHJpbmciLCJsaW5rcyIsImdldEVsZW1lbnRzQnlUYWdOYW1lIiwibGluayIsImNsYXNzTGlzdCIsImFkZCIsIl9faHRtbCIsImJvZHkiLCJpbm5lckhUTUwiLCJVUkxJbnB1dEJ1dHRvbiIsIlBhbmVsQm9keSIsIlRleHRhcmVhQ29udHJvbCIsIkV4dGVybmFsTGluayIsImxpbmtUZXh0IiwibGlua1VSTCIsImF0dHJpYnV0ZSIsImltYWdlIiwiYWx0Iiwid2lkdGgiLCJoZWlnaHQiLCJpbWFnZUNhcHRpb24iLCJtZXRhIiwiaW1hZ2VJRCIsInBvc3QiLCJzaXplcyIsIm5oc21faGVhZHNob3QiLCJfX2V4cGVyaW1lbnRhbE51bWJlckNvbnRyb2wiLCJudW1iZXIiXSwibWFwcGluZ3MiOiI7UUFBQTtRQUNBOztRQUVBO1FBQ0E7O1FBRUE7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7UUFDQTtRQUNBO1FBQ0E7O1FBRUE7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTs7O1FBR0E7UUFDQTs7UUFFQTtRQUNBOztRQUVBO1FBQ0E7UUFDQTtRQUNBLDBDQUEwQyxnQ0FBZ0M7UUFDMUU7UUFDQTs7UUFFQTtRQUNBO1FBQ0E7UUFDQSx3REFBd0Qsa0JBQWtCO1FBQzFFO1FBQ0EsaURBQWlELGNBQWM7UUFDL0Q7O1FBRUE7UUFDQTtRQUNB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LENBREYsRUFpQkUseUJBQUMsZ0JBQUQ7QUFDRSxXQUFLLEVBQUMsMEJBRFI7QUFFRSxlQUFTLEVBQUMscUJBRlo7QUFHRSxnQkFBVSxFQUFFdEI7QUFIZCxNQWpCRixDQURGO0FBeUJEO0FBOUIyQyxDQUE3QixDQUFqQixDOzs7Ozs7Ozs7OztBQ1hBLHlDOzs7Ozs7Ozs7OztBQ0FBLHlDIiwiZmlsZSI6ImJsb2Nrcy5idWlsZC5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIFRoZSBtb2R1bGUgY2FjaGVcbiBcdHZhciBpbnN0YWxsZWRNb2R1bGVzID0ge307XG5cbiBcdC8vIFRoZSByZXF1aXJlIGZ1bmN0aW9uXG4gXHRmdW5jdGlvbiBfX3dlYnBhY2tfcmVxdWlyZV9fKG1vZHVsZUlkKSB7XG5cbiBcdFx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG4gXHRcdGlmKGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdKSB7XG4gXHRcdFx0cmV0dXJuIGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdLmV4cG9ydHM7XG4gXHRcdH1cbiBcdFx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcbiBcdFx0dmFyIG1vZHVsZSA9IGluc3RhbGxlZE1vZHVsZXNbbW9kdWxlSWRdID0ge1xuIFx0XHRcdGk6IG1vZHVsZUlkLFxuIFx0XHRcdGw6IGZhbHNlLFxuIFx0XHRcdGV4cG9ydHM6IHt9XG4gXHRcdH07XG5cbiBcdFx0Ly8gRXhlY3V0ZSB0aGUgbW9kdWxlIGZ1bmN0aW9uXG4gXHRcdG1vZHVsZXNbbW9kdWxlSWRdLmNhbGwobW9kdWxlLmV4cG9ydHMsIG1vZHVsZSwgbW9kdWxlLmV4cG9ydHMsIF9fd2VicGFja19yZXF1aXJlX18pO1xuXG4gXHRcdC8vIEZsYWcgdGhlIG1vZHVsZSBhcyBsb2FkZWRcbiBcdFx0bW9kdWxlLmwgPSB0cnVlO1xuXG4gXHRcdC8vIFJldHVybiB0aGUgZXhwb3J0cyBvZiB0aGUgbW9kdWxlXG4gXHRcdHJldHVybiBtb2R1bGUuZXhwb3J0cztcbiBcdH1cblxuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZXMgb2JqZWN0IChfX3dlYnBhY2tfbW9kdWxlc19fKVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5tID0gbW9kdWxlcztcblxuIFx0Ly8gZXhwb3NlIHRoZSBtb2R1bGUgY2FjaGVcbiBcdF9fd2VicGFja19yZXF1aXJlX18uYyA9IGluc3RhbGxlZE1vZHVsZXM7XG5cbiBcdC8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb24gZm9yIGhhcm1vbnkgZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5kID0gZnVuY3Rpb24oZXhwb3J0cywgbmFtZSwgZ2V0dGVyKSB7XG4gXHRcdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZXhwb3J0cywgbmFtZSkpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgbmFtZSwgeyBlbnVtZXJhYmxlOiB0cnVlLCBnZXQ6IGdldHRlciB9KTtcbiBcdFx0fVxuIFx0fTtcblxuIFx0Ly8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yID0gZnVuY3Rpb24oZXhwb3J0cykge1xuIFx0XHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcbiBcdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcbiBcdFx0fVxuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xuIFx0fTtcblxuIFx0Ly8gY3JlYXRlIGEgZmFrZSBuYW1lc3BhY2Ugb2JqZWN0XG4gXHQvLyBtb2RlICYgMTogdmFsdWUgaXMgYSBtb2R1bGUgaWQsIHJlcXVpcmUgaXRcbiBcdC8vIG1vZGUgJiAyOiBtZXJnZSBhbGwgcHJvcGVydGllcyBvZiB2YWx1ZSBpbnRvIHRoZSBuc1xuIFx0Ly8gbW9kZSAmIDQ6IHJldHVybiB2YWx1ZSB3aGVuIGFscmVhZHkgbnMgb2JqZWN0XG4gXHQvLyBtb2RlICYgOHwxOiBiZWhhdmUgbGlrZSByZXF1aXJlXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnQgPSBmdW5jdGlvbih2YWx1ZSwgbW9kZSkge1xuIFx0XHRpZihtb2RlICYgMSkgdmFsdWUgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKHZhbHVlKTtcbiBcdFx0aWYobW9kZSAmIDgpIHJldHVybiB2YWx1ZTtcbiBcdFx0aWYoKG1vZGUgJiA0KSAmJiB0eXBlb2YgdmFsdWUgPT09ICdvYmplY3QnICYmIHZhbHVlICYmIHZhbHVlLl9fZXNNb2R1bGUpIHJldHVybiB2YWx1ZTtcbiBcdFx0dmFyIG5zID0gT2JqZWN0LmNyZWF0ZShudWxsKTtcbiBcdFx0X193ZWJwYWNrX3JlcXVpcmVfXy5yKG5zKTtcbiBcdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KG5zLCAnZGVmYXVsdCcsIHsgZW51bWVyYWJsZTogdHJ1ZSwgdmFsdWU6IHZhbHVlIH0pO1xuIFx0XHRpZihtb2RlICYgMiAmJiB0eXBlb2YgdmFsdWUgIT0gJ3N0cmluZycpIGZvcih2YXIga2V5IGluIHZhbHVlKSBfX3dlYnBhY2tfcmVxdWlyZV9fLmQobnMsIGtleSwgZnVuY3Rpb24oa2V5KSB7IHJldHVybiB2YWx1ZVtrZXldOyB9LmJpbmQobnVsbCwga2V5KSk7XG4gXHRcdHJldHVybiBucztcbiBcdH07XG5cbiBcdC8vIGdldERlZmF1bHRFeHBvcnQgZnVuY3Rpb24gZm9yIGNvbXBhdGliaWxpdHkgd2l0aCBub24taGFybW9ueSBtb2R1bGVzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm4gPSBmdW5jdGlvbihtb2R1bGUpIHtcbiBcdFx0dmFyIGdldHRlciA9IG1vZHVsZSAmJiBtb2R1bGUuX19lc01vZHVsZSA/XG4gXHRcdFx0ZnVuY3Rpb24gZ2V0RGVmYXVsdCgpIHsgcmV0dXJuIG1vZHVsZVsnZGVmYXVsdCddOyB9IDpcbiBcdFx0XHRmdW5jdGlvbiBnZXRNb2R1bGVFeHBvcnRzKCkgeyByZXR1cm4gbW9kdWxlOyB9O1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQoZ2V0dGVyLCAnYScsIGdldHRlcik7XG4gXHRcdHJldHVybiBnZXR0ZXI7XG4gXHR9O1xuXG4gXHQvLyBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGxcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubyA9IGZ1bmN0aW9uKG9iamVjdCwgcHJvcGVydHkpIHsgcmV0dXJuIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbChvYmplY3QsIHByb3BlcnR5KTsgfTtcblxuIFx0Ly8gX193ZWJwYWNrX3B1YmxpY19wYXRoX19cbiBcdF9fd2VicGFja19yZXF1aXJlX18ucCA9IFwiXCI7XG5cblxuIFx0Ly8gTG9hZCBlbnRyeSBtb2R1bGUgYW5kIHJldHVybiBleHBvcnRzXG4gXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhfX3dlYnBhY2tfcmVxdWlyZV9fLnMgPSBcIi4vYmxvY2tzL3NyYy9ibG9ja3MuanNcIik7XG4iLCJpbXBvcnQgXCIuL2ZlYXR1cmV0dGVzL2NvbGxlY3Rpb25zL2Jsb2NrXCI7XG5pbXBvcnQgXCIuL2ZlYXR1cmV0dGVzL25ld3NsZXR0ZXItc2lnbnVwL2Jsb2NrXCI7XG5pbXBvcnQgXCIuL3dpZGdldHMvY29sbGVjdGlvbnMvYmxvY2tcIjtcbiIsImNvbnN0IHtcbiAgSW5zcGVjdG9yQ29udHJvbHMsXG4gIE1lZGlhVXBsb2FkLFxuICBQbGFpblRleHQsXG4gIFJpY2hUZXh0LFxuICBQYW5lbENvbG9yU2V0dGluZ3MsXG4gIElubmVyQmxvY2tzLFxufSA9IHdwLmJsb2NrRWRpdG9yO1xuY29uc3QgeyByZWdpc3RlckJsb2NrVHlwZSB9ID0gd3AuYmxvY2tzO1xuY29uc3QgeyBCdXR0b24sIERpc2FibGVkLCBTZXJ2ZXJTaWRlUmVuZGVyIH0gPSB3cC5jb21wb25lbnRzO1xuXG5pbXBvcnQgXCIuL3N0eWxlLnNjc3NcIjtcbmltcG9ydCBcIi4vZWRpdG9yLnNjc3NcIjtcblxucmVnaXN0ZXJCbG9ja1R5cGUoXCJuaHNtLWZlYXR1cmV0dGVzL2NvbGxlY3Rpb25zXCIsIHtcbiAgdGl0bGU6IFwiQ29sbGVjdGlvbnMgQ1RBXCIsXG4gIGljb246IFwiZ3JpZC12aWV3XCIsXG4gIGNhdGVnb3J5OiBcIm5oc20tZmVhdHVyZXR0ZXNcIixcbiAgYXR0cmlidXRlczoge1xuICAgIHRpdGxlOiB7XG4gICAgICBzb3VyY2U6IFwidGV4dFwiLFxuICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY3RhLWNvbGxlY3Rpb25zX190aXRsZVwiLFxuICAgIH0sXG4gICAgbGVhZDoge1xuICAgICAgc291cmNlOiBcInRleHRcIixcbiAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWN0YS1jb2xsZWN0aW9uc19fbGVhZFwiLFxuICAgIH0sXG4gICAgY3RhOiB7XG4gICAgICB0eXBlOiBcInN0cmluZ1wiLFxuICAgICAgc291cmNlOiBcImh0bWxcIixcbiAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWN0YS1jb2xsZWN0aW9uc19fY29sbGVjdGlvbnNHcmlkVGl0bGVcIixcbiAgICB9LFxuICAgIGNvbXBvbmVudFN0eWxlczoge1xuICAgICAgdHlwZTogXCJvYmplY3RcIixcbiAgICAgIGJhY2tncm91bmRJbWFnZToge30sXG4gICAgICBiYWNrZ3JvdW5kQ29sb3I6IFwiXCIsXG4gICAgICBjb2xvcjogXCJcIixcbiAgICB9LFxuICAgIGJnSW1hZ2VJRDoge1xuICAgICAgdHlwZTogXCJpbnRlZ2VyXCIsXG4gICAgfSxcbiAgfSxcbiAgZWRpdCh7IGF0dHJpYnV0ZXMsIGNsYXNzTmFtZSwgc2V0QXR0cmlidXRlcyB9KSB7XG4gICAgY29uc3QgZ2V0SW1hZ2VCdXR0b24gPSAob3BlbkV2ZW50KSA9PiB7XG4gICAgICBpZiAoYXR0cmlidXRlcy5iZ0ltYWdlSUQpIHtcbiAgICAgICAgcmV0dXJuIChcbiAgICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImltZy1jb250YWluZXJcIj5cbiAgICAgICAgICAgIDxCdXR0b24gb25DbGljaz17b3BlbkV2ZW50fSBjbGFzc05hbWU9XCJidXR0b24gYnV0dG9uLWxhcmdlXCI+XG4gICAgICAgICAgICAgIENoYW5nZSBpbWFnZVxuICAgICAgICAgICAgPC9CdXR0b24+XG4gICAgICAgICAgICA8QnV0dG9uXG4gICAgICAgICAgICAgIG9uQ2xpY2s9eygpID0+IHtcbiAgICAgICAgICAgICAgICBjb25zdCBzdHlsZXMgPSB7IC4uLmF0dHJpYnV0ZXMuY29tcG9uZW50U3R5bGVzIH07XG4gICAgICAgICAgICAgICAgc3R5bGVzLmJhY2tncm91bmRJbWFnZSA9IG51bGw7XG4gICAgICAgICAgICAgICAgc2V0QXR0cmlidXRlcyh7XG4gICAgICAgICAgICAgICAgICBiZ0ltYWdlSUQ6IDAsXG4gICAgICAgICAgICAgICAgICBjb21wb25lbnRTdHlsZXM6IHN0eWxlcyxcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgfX1cbiAgICAgICAgICAgICAgY2xhc3NOYW1lPVwiYnV0dG9uIGJ1dHRvbi1sYXJnZVwiXG4gICAgICAgICAgICA+XG4gICAgICAgICAgICAgIFJlbW92ZSBJbWFnZVxuICAgICAgICAgICAgPC9CdXR0b24+XG4gICAgICAgICAgPC9kaXY+XG4gICAgICAgICk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICByZXR1cm4gKFxuICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwiaW1nLWNvbnRhaW5lclwiPlxuICAgICAgICAgICAgPEJ1dHRvbiBvbkNsaWNrPXtvcGVuRXZlbnR9IGNsYXNzTmFtZT1cImJ1dHRvbiBidXR0b24tbGFyZ2VcIj5cbiAgICAgICAgICAgICAgUGljayBhbiBpbWFnZVxuICAgICAgICAgICAgPC9CdXR0b24+XG4gICAgICAgICAgPC9kaXY+XG4gICAgICAgICk7XG4gICAgICB9XG4gICAgfTtcblxuICAgIHJldHVybiBbXG4gICAgICA8SW5zcGVjdG9yQ29udHJvbHM+XG4gICAgICAgIDxQYW5lbENvbG9yU2V0dGluZ3NcbiAgICAgICAgICB0aXRsZT1cIkNvbG9yIFNldHRpbmdzXCJcbiAgICAgICAgICBjb2xvclNldHRpbmdzPXtbXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgIHZhbHVlOiBhdHRyaWJ1dGVzLmNvbXBvbmVudFN0eWxlcy5iYWNrZ3JvdW5kQ29sb3IsXG4gICAgICAgICAgICAgIG9uQ2hhbmdlOiAoY29sb3JWYWx1ZSkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnN0IHN0eWxlcyA9IHsgLi4uYXR0cmlidXRlcy5jb21wb25lbnRTdHlsZXMgfTtcbiAgICAgICAgICAgICAgICBzdHlsZXMuYmFja2dyb3VuZENvbG9yID0gY29sb3JWYWx1ZTtcbiAgICAgICAgICAgICAgICBzZXRBdHRyaWJ1dGVzKHsgY29tcG9uZW50U3R5bGVzOiBzdHlsZXMgfSk7XG4gICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgIGxhYmVsOiBcIkJhY2tncm91bmQgQ29sb3JcIixcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICB7XG4gICAgICAgICAgICAgIHZhbHVlOiBhdHRyaWJ1dGVzLmNvbXBvbmVudFN0eWxlcy5jb2xvcixcbiAgICAgICAgICAgICAgb25DaGFuZ2U6IChjb2xvclZhbHVlKSA9PiB7XG4gICAgICAgICAgICAgICAgY29uc3Qgc3R5bGVzID0geyAuLi5hdHRyaWJ1dGVzLmNvbXBvbmVudFN0eWxlcyB9O1xuICAgICAgICAgICAgICAgIHN0eWxlcy5jb2xvciA9IGNvbG9yVmFsdWU7XG4gICAgICAgICAgICAgICAgc2V0QXR0cmlidXRlcyh7IGNvbXBvbmVudFN0eWxlczogc3R5bGVzIH0pO1xuICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICBsYWJlbDogXCJUZXh0IENvbG9yXCIsXG4gICAgICAgICAgICB9LFxuICAgICAgICAgIF19XG4gICAgICAgIC8+XG4gICAgICA8L0luc3BlY3RvckNvbnRyb2xzPixcbiAgICAgIDxzZWN0aW9uIGNsYXNzTmFtZT1cImNvbnRhaW5lclwiPlxuICAgICAgICA8ZGl2XG4gICAgICAgICAgY2xhc3NOYW1lPVwibmhzbS1jdGEtY29sbGVjdGlvbnNcIlxuICAgICAgICAgIHN0eWxlPXthdHRyaWJ1dGVzLmNvbXBvbmVudFN0eWxlc31cbiAgICAgICAgPlxuICAgICAgICAgIDxQbGFpblRleHRcbiAgICAgICAgICAgIG9uQ2hhbmdlPXsoY29udGVudCkgPT4gc2V0QXR0cmlidXRlcyh7IHRpdGxlOiBjb250ZW50IH0pfVxuICAgICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMudGl0bGV9XG4gICAgICAgICAgICBwbGFjZWhvbGRlcj1cIkNhbGwgdG8gYWN0aW9uIHRpdGxlXCJcbiAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLWNvbGxlY3Rpb25zX190aXRsZVwiXG4gICAgICAgICAgLz5cbiAgICAgICAgICA8UGxhaW5UZXh0XG4gICAgICAgICAgICBvbkNoYW5nZT17KGNvbnRlbnQpID0+IHNldEF0dHJpYnV0ZXMoeyBsZWFkOiBjb250ZW50IH0pfVxuICAgICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMubGVhZH1cbiAgICAgICAgICAgIHBsYWNlaG9sZGVyPVwiQ2FsbCB0byBhY3Rpb24gdGV4dFwiXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWN0YS1jb2xsZWN0aW9uc19fbGVhZFwiXG4gICAgICAgICAgLz5cbiAgICAgICAgICA8UmljaFRleHRcbiAgICAgICAgICAgIHRhZ05hbWU9XCJoM1wiXG4gICAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWN0YS1jb2xsZWN0aW9uc19fY29sbGVjdGlvbnNHcmlkVGl0bGVcIlxuICAgICAgICAgICAgcGxhY2Vob2xkZXI9XCJUaGUgY2FsbCB0byBhY3Rpb24gKGluY2x1ZGUgbGluayB0byBkZXN0aW5hdGlvbilcIlxuICAgICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMuY3RhfVxuICAgICAgICAgICAgb25DaGFuZ2U9eyhjb250ZW50KSA9PiBzZXRBdHRyaWJ1dGVzKHsgY3RhOiBjb250ZW50IH0pfVxuICAgICAgICAgICAgbXVsdGlsaW5lPXtmYWxzZX1cbiAgICAgICAgICAgIGFsbG93ZWRGb3JtYXRzPXtbXCJjb3JlL2xpbmtcIl19XG4gICAgICAgICAgLz5cbiAgICAgICAgICA8U2VydmVyU2lkZVJlbmRlclxuICAgICAgICAgICAgYmxvY2s9XCJuaHNtLXdpZGdldHMvY29sbGVjdGlvbnNcIlxuICAgICAgICAgICAgY2xhc3NOYW1lPVwibmhzbS1jdGEtY29sbGVjdGlvbnNfX2NvbGxlY3Rpb25zR3JpZFwiXG4gICAgICAgICAgICBhdHRyaWJ1dGVzPXt7XG4gICAgICAgICAgICAgIGNvdW50OiAzLFxuICAgICAgICAgICAgfX1cbiAgICAgICAgICAvPlxuICAgICAgICAgIHsvKjxJbm5lckJsb2NrcyBhbGxvd2VkQmxvY2tzPXtbXCJuaHNtLXdpZGdldHMvY29sbGVjdGlvbnNcIl19IC8+Ki99XG4gICAgICAgIDwvZGl2PlxuICAgICAgICA8TWVkaWFVcGxvYWRcbiAgICAgICAgICBvblNlbGVjdD17KG1lZGlhKSA9PiB7XG4gICAgICAgICAgICBjb25zdCBzdHlsZXMgPSB7IC4uLmF0dHJpYnV0ZXMuY29tcG9uZW50U3R5bGVzIH07XG4gICAgICAgICAgICBzdHlsZXMuYmFja2dyb3VuZEltYWdlID0gXCJ1cmwoXCIgKyBtZWRpYS51cmwgKyBcIilcIjtcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoe1xuICAgICAgICAgICAgICBiZ0ltYWdlSUQ6IG1lZGlhLmlkLFxuICAgICAgICAgICAgICBjb21wb25lbnRTdHlsZXM6IHN0eWxlcyxcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgIH19XG4gICAgICAgICAgdHlwZT1cImltYWdlXCJcbiAgICAgICAgICB2YWx1ZT17YXR0cmlidXRlcy5iZ0ltYWdlSUR9XG4gICAgICAgICAgcmVuZGVyPXsoeyBvcGVuIH0pID0+IGdldEltYWdlQnV0dG9uKG9wZW4pfVxuICAgICAgICAvPlxuICAgICAgPC9zZWN0aW9uPixcbiAgICBdO1xuICB9LFxuICBzYXZlKHsgYXR0cmlidXRlcyB9KSB7XG4gICAgY29uc3QgY3RhTWFya3VwID0gKCkgPT4ge1xuICAgICAgbGV0IGRvbXBhcnNlciA9IG5ldyBET01QYXJzZXIoKTtcbiAgICAgIGxldCBjdGEgPSBkb21wYXJzZXIucGFyc2VGcm9tU3RyaW5nKGF0dHJpYnV0ZXMuY3RhLCBcInRleHQvaHRtbFwiKTtcbiAgICAgIGxldCBsaW5rcyA9IGN0YS5nZXRFbGVtZW50c0J5VGFnTmFtZShcImFcIik7XG4gICAgICBmb3IgKGxldCBsaW5rIG9mIGxpbmtzKSB7XG4gICAgICAgIGxpbmsuY2xhc3NMaXN0LmFkZChcbiAgICAgICAgICBcImJ1dHRvblwiLFxuICAgICAgICAgIFwiYnV0dG9uLS1wcmltYXJ5XCIsXG4gICAgICAgICAgXCJidXR0b24tLXByb21pbmVudFwiLFxuICAgICAgICAgIFwibmhzbS1jdGEtY29sbGVjdGlvbnNfX2J1dHRvblwiXG4gICAgICAgICk7XG4gICAgICB9XG4gICAgICByZXR1cm4ge1xuICAgICAgICBfX2h0bWw6IGN0YS5ib2R5LmlubmVySFRNTCxcbiAgICAgIH07XG4gICAgfTtcblxuICAgIHJldHVybiAoXG4gICAgICA8c2VjdGlvblxuICAgICAgICBjbGFzc05hbWU9XCJob21lcGFnZS1zZWN0aW9uIG5oc20tY3RhLWNvbGxlY3Rpb25zXCJcbiAgICAgICAgc3R5bGU9e2F0dHJpYnV0ZXMuY29tcG9uZW50U3R5bGVzfVxuICAgICAgPlxuICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImNvbnRhaW5lciBuaHNtLWN0YS1jb2xsZWN0aW9uc19faW5uZXJcIj5cbiAgICAgICAgICA8aDIgY2xhc3NOYW1lPVwibmhzbS1jdGEtY29sbGVjdGlvbnNfX3RpdGxlXCI+e2F0dHJpYnV0ZXMudGl0bGV9PC9oMj5cbiAgICAgICAgICA8cCBjbGFzc05hbWU9XCJuaHNtLWN0YS1jb2xsZWN0aW9uc19fbGVhZFwiPnthdHRyaWJ1dGVzLmxlYWR9PC9wPlxuICAgICAgICAgIDxzZWN0aW9uIGNsYXNzTmFtZT1cIm5oc20tY3RhLWNvbGxlY3Rpb25zX19jb2xsZWN0aW9uR3JpZFwiPlxuICAgICAgICAgICAgPGgzXG4gICAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLWNvbGxlY3Rpb25zX19jb2xsZWN0aW9uc0dyaWRUaXRsZVwiXG4gICAgICAgICAgICAgIGRhbmdlcm91c2x5U2V0SW5uZXJIVE1MPXtjdGFNYXJrdXAoKX1cbiAgICAgICAgICAgIC8+XG4gICAgICAgICAgICA8ZGl2IGlkPVwiY29sbGVjdGlvbnNfbGlzdFwiPjwvZGl2PlxuICAgICAgICAgICAgey8qPElubmVyQmxvY2tzLkNvbnRlbnQgLz4qL31cbiAgICAgICAgICA8L3NlY3Rpb24+XG4gICAgICAgIDwvZGl2PlxuICAgICAgPC9zZWN0aW9uPlxuICAgICk7XG4gIH0sXG59KTtcbiIsIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luIiwiLy8gcmVtb3ZlZCBieSBleHRyYWN0LXRleHQtd2VicGFjay1wbHVnaW4iLCJjb25zdCB7XG4gIEluc3BlY3RvckNvbnRyb2xzLFxuICBNZWRpYVVwbG9hZCxcbiAgUGxhaW5UZXh0LFxuICBVUkxJbnB1dEJ1dHRvbixcbn0gPSB3cC5ibG9ja0VkaXRvcjtcbmNvbnN0IHsgcmVnaXN0ZXJCbG9ja1R5cGUgfSA9IHdwLmJsb2NrcztcbmNvbnN0IHsgQnV0dG9uLCBQYW5lbEJvZHksIFRleHRhcmVhQ29udHJvbCwgRXh0ZXJuYWxMaW5rIH0gPSB3cC5jb21wb25lbnRzO1xuXG5pbXBvcnQgXCIuL3N0eWxlLnNjc3NcIjtcbmltcG9ydCBcIi4vZWRpdG9yLnNjc3NcIjtcblxucmVnaXN0ZXJCbG9ja1R5cGUoXCJuaHNtLWZlYXR1cmV0dGVzL25ld3NsZXR0ZXItc2lnbnVwXCIsIHtcbiAgdGl0bGU6IFwiTmV3c2xldHRlciBTaWdudXBcIixcbiAgaWNvbjogXCJlbWFpbC1hbHRcIixcbiAgY2F0ZWdvcnk6IFwibmhzbS1mZWF0dXJldHRlc1wiLFxuICBhdHRyaWJ1dGVzOiB7XG4gICAgdGl0bGU6IHtcbiAgICAgIHNvdXJjZTogXCJ0ZXh0XCIsXG4gICAgICBzZWxlY3RvcjogXCIubmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX3RpdGxlXCIsXG4gICAgfSxcbiAgICBib2R5OiB7XG4gICAgICBzb3VyY2U6IFwidGV4dFwiLFxuICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19ib2R5XCIsXG4gICAgfSxcbiAgICBsaW5rVGV4dDoge1xuICAgICAgdHlwZTogXCJzdHJpbmdcIixcbiAgICAgIHNvdXJjZTogXCJ0ZXh0XCIsXG4gICAgICBzZWxlY3RvcjogXCIubmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2J1dHRvblRleHRcIixcbiAgICB9LFxuICAgIGxpbmtVUkw6IHtcbiAgICAgIHR5cGU6IFwic3RyaW5nXCIsXG4gICAgICBzb3VyY2U6IFwiYXR0cmlidXRlXCIsXG4gICAgICBhdHRyaWJ1dGU6IFwiaHJlZlwiLFxuICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19idXR0b25cIixcbiAgICAgIGRlZmF1bHQ6IFwiI1wiLFxuICAgIH0sXG4gICAgaW1hZ2U6IHtcbiAgICAgIHR5cGU6IFwib2JqZWN0XCIsXG4gICAgICB1cmw6IHtcbiAgICAgICAgdHlwZTogXCJzdHJpbmdcIixcbiAgICAgICAgc291cmNlOiBcImF0dHJpYnV0ZVwiLFxuICAgICAgICBhdHRyaWJ1dGU6IFwic3JjXCIsXG4gICAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9fZmlndXJlIGltZ1wiLFxuICAgICAgfSxcbiAgICAgIGFsdDoge1xuICAgICAgICB0eXBlOiBcInN0cmluZ1wiLFxuICAgICAgICBzb3VyY2U6IFwiYXR0cmlidXRlXCIsXG4gICAgICAgIGF0dHJpYnV0ZTogXCJhbHRcIixcbiAgICAgICAgc2VsZWN0b3I6IFwiLm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19maWd1cmUgaW1nXCIsXG4gICAgICAgIGRlZmF1bHQ6IFwiXCIsXG4gICAgICB9LFxuICAgICAgd2lkdGg6IHtcbiAgICAgICAgdHlwZTogXCJpbnRlZ2VyXCIsXG4gICAgICAgIHNvdXJjZTogXCJhdHRyaWJ1dGVcIixcbiAgICAgICAgYXR0cmlidXRlOiBcIndpZHRoXCIsXG4gICAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9fZmlndXJlIGltZ1wiLFxuICAgICAgfSxcbiAgICAgIGhlaWdodDoge1xuICAgICAgICB0eXBlOiBcImludGVnZXJcIixcbiAgICAgICAgc291cmNlOiBcImF0dHJpYnV0ZVwiLFxuICAgICAgICBhdHRyaWJ1dGU6IFwiaGVpZ2h0XCIsXG4gICAgICAgIHNlbGVjdG9yOiBcIi5uaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9fZmlndXJlIGltZ1wiLFxuICAgICAgfSxcbiAgICB9LFxuICAgIGltYWdlQ2FwdGlvbjoge1xuICAgICAgdHlwZTogXCJzdHJpbmdcIixcbiAgICAgIHNvdXJjZTogXCJtZXRhXCIsXG4gICAgICBtZXRhOiBcInNvdXJjZV9jcmVkaXRcIixcbiAgICB9LFxuICAgIGltYWdlSUQ6IHtcbiAgICAgIHR5cGU6IFwiaW50ZWdlclwiLFxuICAgIH0sXG4gIH0sXG4gIGVkaXQoeyBhdHRyaWJ1dGVzLCBjbGFzc05hbWUsIHNldEF0dHJpYnV0ZXMgfSkge1xuICAgIGNvbnN0IGdldEltYWdlQnV0dG9uID0gKG9wZW5FdmVudCkgPT4ge1xuICAgICAgaWYgKGF0dHJpYnV0ZXMuaW1hZ2UudXJsKSB7XG4gICAgICAgIHJldHVybiAoXG4gICAgICAgICAgPGltZ1xuICAgICAgICAgICAgc3JjPXthdHRyaWJ1dGVzLmltYWdlLnVybH1cbiAgICAgICAgICAgIG9uQ2xpY2s9e29wZW5FdmVudH1cbiAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19pbWFnZVwiXG4gICAgICAgICAgLz5cbiAgICAgICAgKTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIHJldHVybiAoXG4gICAgICAgICAgPGRpdiBjbGFzc05hbWU9XCJidXR0b24tY29udGFpbmVyXCI+XG4gICAgICAgICAgICA8QnV0dG9uIG9uQ2xpY2s9e29wZW5FdmVudH0gY2xhc3NOYW1lPVwiYnV0dG9uIGJ1dHRvbi1sYXJnZVwiPlxuICAgICAgICAgICAgICBQaWNrIGFuIGltYWdlXG4gICAgICAgICAgICA8L0J1dHRvbj5cbiAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgKTtcbiAgICAgIH1cbiAgICB9O1xuXG4gICAgcmV0dXJuIFtcbiAgICAgIGF0dHJpYnV0ZXMuaW1hZ2VJRCAmJiAoXG4gICAgICAgIDxJbnNwZWN0b3JDb250cm9scz5cbiAgICAgICAgICA8UGFuZWxCb2R5IHRpdGxlPVwiSW1hZ2UgU2V0dGluZ3NcIj5cbiAgICAgICAgICAgIDxUZXh0YXJlYUNvbnRyb2xcbiAgICAgICAgICAgICAgbGFiZWw9XCJBbHQgdGV4dCAoYWx0ZXJuYXRpdmUgdGV4dClcIlxuICAgICAgICAgICAgICB2YWx1ZT17YXR0cmlidXRlcy5pbWFnZS5hbHR9XG4gICAgICAgICAgICAgIG9uQ2hhbmdlPXsoYWx0KSA9PiB7XG4gICAgICAgICAgICAgICAgY29uc3QgaW1hZ2UgPSB7IC4uLmF0dHJpYnV0ZXMuaW1hZ2UgfTtcbiAgICAgICAgICAgICAgICBpbWFnZS5hbHQgPSBhbHQ7XG4gICAgICAgICAgICAgICAgc2V0QXR0cmlidXRlcyh7IGltYWdlOiBpbWFnZSB9KTtcbiAgICAgICAgICAgICAgfX1cbiAgICAgICAgICAgICAgaGVscD17XG4gICAgICAgICAgICAgICAgPGRpdj5cbiAgICAgICAgICAgICAgICAgIDxFeHRlcm5hbExpbmsgaHJlZj1cImh0dHBzOi8vd3d3LnczLm9yZy9XQUkvdHV0b3JpYWxzL2ltYWdlcy9kZWNpc2lvbi10cmVlXCI+XG4gICAgICAgICAgICAgICAgICAgIERlc2NyaWJlIHRoZSBwdXJwb3NlIG9mIHRoZSBpbWFnZVxuICAgICAgICAgICAgICAgICAgPC9FeHRlcm5hbExpbms+XG4gICAgICAgICAgICAgICAgICBMZWF2ZSBlbXB0eSBpZiB0aGUgaW1hZ2UgaXMgcHVyZWx5IGRlY29yYXRpdmUuXG4gICAgICAgICAgICAgICAgPC9kaXY+XG4gICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIC8+XG4gICAgICAgICAgPC9QYW5lbEJvZHk+XG4gICAgICAgIDwvSW5zcGVjdG9yQ29udHJvbHM+XG4gICAgICApLFxuICAgICAgPGRpdiBjbGFzc05hbWU9XCJjb250YWluZXIgbmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBcIj5cbiAgICAgICAgPFBsYWluVGV4dFxuICAgICAgICAgIG9uQ2hhbmdlPXsoY29udGVudCkgPT4gc2V0QXR0cmlidXRlcyh7IHRpdGxlOiBjb250ZW50IH0pfVxuICAgICAgICAgIHZhbHVlPXthdHRyaWJ1dGVzLnRpdGxlfVxuICAgICAgICAgIHBsYWNlaG9sZGVyPVwiWW91ciBjYXJkIHRpdGxlXCJcbiAgICAgICAgICBjbGFzc05hbWU9XCJuaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9fdGl0bGVcIlxuICAgICAgICAvPlxuICAgICAgICA8UGxhaW5UZXh0XG4gICAgICAgICAgb25DaGFuZ2U9eyhjb250ZW50KSA9PiBzZXRBdHRyaWJ1dGVzKHsgYm9keTogY29udGVudCB9KX1cbiAgICAgICAgICB2YWx1ZT17YXR0cmlidXRlcy5ib2R5fVxuICAgICAgICAgIHBsYWNlaG9sZGVyPVwiWW91ciBjYXJkIHRleHRcIlxuICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19ib2R5XCJcbiAgICAgICAgLz5cbiAgICAgICAgPHNlY3Rpb24gY2xhc3NOYW1lPVwibmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2J1dHRvbkVkaXRvclwiPlxuICAgICAgICAgIDxQbGFpblRleHRcbiAgICAgICAgICAgIG9uQ2hhbmdlPXsoY29udGVudCkgPT4gc2V0QXR0cmlidXRlcyh7IGxpbmtUZXh0OiBjb250ZW50IH0pfVxuICAgICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMubGlua1RleHR9XG4gICAgICAgICAgICBwbGFjZWhvbGRlcj1cIkJ1dHRvbiB0ZXh0XCJcbiAgICAgICAgICAgIGNsYXNzTmFtZT1cIm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19idXR0b25UZXh0XCJcbiAgICAgICAgICAvPlxuICAgICAgICAgIDxVUkxJbnB1dEJ1dHRvblxuICAgICAgICAgICAgdXJsPXthdHRyaWJ1dGVzLmxpbmtVUkx9XG4gICAgICAgICAgICBvbkNoYW5nZT17KHVybCwgcG9zdCkgPT4gc2V0QXR0cmlidXRlcyh7IGxpbmtVUkw6IHVybCB9KX1cbiAgICAgICAgICAvPlxuICAgICAgICA8L3NlY3Rpb24+XG4gICAgICAgIDxNZWRpYVVwbG9hZFxuICAgICAgICAgIG9uU2VsZWN0PXsobWVkaWEpID0+IHtcbiAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoe1xuICAgICAgICAgICAgICBpbWFnZToge1xuICAgICAgICAgICAgICAgIHVybDogbWVkaWEuc2l6ZXMubmhzbV9oZWFkc2hvdC51cmwsXG4gICAgICAgICAgICAgICAgYWx0OiBtZWRpYS5hbHQsXG4gICAgICAgICAgICAgICAgd2lkdGg6IG1lZGlhLnNpemVzLm5oc21faGVhZHNob3Qud2lkdGgsXG4gICAgICAgICAgICAgICAgaGVpZ2h0OiBtZWRpYS5zaXplcy5uaHNtX2hlYWRzaG90LmhlaWdodCxcbiAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgaW1hZ2VJRDogbWVkaWEuaWQsXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgICB9fVxuICAgICAgICAgIHR5cGU9XCJpbWFnZVwiXG4gICAgICAgICAgdmFsdWU9e2F0dHJpYnV0ZXMuaW1hZ2VJRH1cbiAgICAgICAgICByZW5kZXI9eyh7IG9wZW4gfSkgPT4gZ2V0SW1hZ2VCdXR0b24ob3Blbil9XG4gICAgICAgIC8+XG4gICAgICA8L2Rpdj4sXG4gICAgXTtcbiAgfSxcbiAgc2F2ZSh7IGF0dHJpYnV0ZXMgfSkge1xuICAgIGNvbnN0IGltYWdlID0gKGltYWdlLCBpbWFnZUlEKSA9PiB7XG4gICAgICBpZiAoIWltYWdlKSByZXR1cm4gbnVsbDtcbiAgICAgIGNvbnN0IGNsYXNzTGlzdCA9IFwiaW1nLXJlc3BvbnNpdmUgd3AtaW1hZ2UtXCIgKyBpbWFnZUlEO1xuXG4gICAgICBpZiAoaW1hZ2UuYWx0ICE9PSBcIlwiKSB7XG4gICAgICAgIHJldHVybiAoXG4gICAgICAgICAgPGltZ1xuICAgICAgICAgICAgc3JjPXtpbWFnZS51cmx9XG4gICAgICAgICAgICB3aWR0aD17aW1hZ2Uud2lkdGh9XG4gICAgICAgICAgICBoZWlnaHQ9e2ltYWdlLmhlaWdodH1cbiAgICAgICAgICAgIGFsdD17aW1hZ2UuYWx0fVxuICAgICAgICAgICAgY2xhc3NOYW1lPXtjbGFzc0xpc3R9XG4gICAgICAgICAgLz5cbiAgICAgICAgKTtcbiAgICAgIH1cblxuICAgICAgLy8gTm8gYWx0IHNldCwgc28gbGV0J3MgaGlkZSBpdCBmcm9tIHNjcmVlbiByZWFkZXJzXG4gICAgICByZXR1cm4gKFxuICAgICAgICA8aW1nXG4gICAgICAgICAgc3JjPXtpbWFnZS51cmx9XG4gICAgICAgICAgd2lkdGg9e2ltYWdlLndpZHRofVxuICAgICAgICAgIGhlaWdodD17aW1hZ2UuaGVpZ2h0fVxuICAgICAgICAgIGFsdD1cIlwiXG4gICAgICAgICAgYXJpYS1oaWRkZW49XCJ0cnVlXCJcbiAgICAgICAgICBjbGFzc05hbWU9e2NsYXNzTGlzdH1cbiAgICAgICAgLz5cbiAgICAgICk7XG4gICAgfTtcbiAgICByZXR1cm4gKFxuICAgICAgPHNlY3Rpb24gY2xhc3NOYW1lPVwiaG9tZXBhZ2Utc2VjdGlvbiBuaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cFwiPlxuICAgICAgICA8ZGl2IGNsYXNzTmFtZT1cImNvbnRhaW5lciBuaHNtLWN0YS1uZXdzbGV0dGVyLXNpZ251cF9faW5uZXJcIj5cbiAgICAgICAgICA8aDIgY2xhc3NOYW1lPVwibmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX3RpdGxlXCI+XG4gICAgICAgICAgICB7YXR0cmlidXRlcy50aXRsZX1cbiAgICAgICAgICA8L2gyPlxuICAgICAgICAgIDxwIGNsYXNzTmFtZT1cIm5oc20tY3RhLW5ld3NsZXR0ZXItc2lnbnVwX19ib2R5XCI+e2F0dHJpYnV0ZXMuYm9keX08L3A+XG4gICAgICAgICAgPGFcbiAgICAgICAgICAgIGhyZWY9e2F0dHJpYnV0ZXMubGlua1VSTH1cbiAgICAgICAgICAgIGNsYXNzTmFtZT1cImJ1dHRvbiBidXR0b24tLXByaW1hcnkgYnV0dG9uLS1wcm9taW5lbnQgbmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2J1dHRvbiBpY29uQnV0dG9uLS1pY29uRmlyc3QgaWNvbkJ1dHRvbi0tZ3Jvd1wiXG4gICAgICAgICAgPlxuICAgICAgICAgICAgPGkgY2xhc3NOYW1lPVwiZmFzIGZhLXBhcGVyLXBsYW5lXCI+PC9pPlxuICAgICAgICAgICAgPHNwYW4gY2xhc3NOYW1lPVwibmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2J1dHRvblRleHRcIj5cbiAgICAgICAgICAgICAge2F0dHJpYnV0ZXMubGlua1RleHR9XG4gICAgICAgICAgICA8L3NwYW4+XG4gICAgICAgICAgPC9hPlxuICAgICAgICAgIDxkaXYgY2xhc3NOYW1lPVwibmhzbS1jdGEtbmV3c2xldHRlci1zaWdudXBfX2ZpZ3VyZVwiPlxuICAgICAgICAgICAgPGZpZ3VyZSBjbGFzc05hbWU9XCJmaWd1cmUgZmlndXJlLS1jYXB0aW9uT3ZlcmxheSBmaWd1cmUtLWNpcmNsZVwiPlxuICAgICAgICAgICAgICB7aW1hZ2UoYXR0cmlidXRlcy5pbWFnZSwgYXR0cmlidXRlcy5pbWFnZUlEKX1cbiAgICAgICAgICAgICAgPGZpZ2NhcHRpb24+PC9maWdjYXB0aW9uPlxuICAgICAgICAgICAgPC9maWd1cmU+XG4gICAgICAgICAgPC9kaXY+XG4gICAgICAgIDwvZGl2PlxuICAgICAgPC9zZWN0aW9uPlxuICAgICk7XG4gIH0sXG59KTtcbiIsIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luIiwiLy8gcmVtb3ZlZCBieSBleHRyYWN0LXRleHQtd2VicGFjay1wbHVnaW4iLCJjb25zdCB7IEluc3BlY3RvckNvbnRyb2xzIH0gPSB3cC5ibG9ja0VkaXRvcjtcbmNvbnN0IHsgcmVnaXN0ZXJCbG9ja1R5cGUgfSA9IHdwLmJsb2NrcztcbmNvbnN0IHtcbiAgUGFuZWxCb2R5LFxuICBfX2V4cGVyaW1lbnRhbE51bWJlckNvbnRyb2wsXG4gIFNlcnZlclNpZGVSZW5kZXIsXG59ID0gd3AuY29tcG9uZW50cztcblxuaW1wb3J0IFwiLi9zdHlsZS5zY3NzXCI7XG5pbXBvcnQgXCIuL2VkaXRvci5zY3NzXCI7XG5cbnJlZ2lzdGVyQmxvY2tUeXBlKFwibmhzbS13aWRnZXRzL2NvbGxlY3Rpb25zXCIsIHtcbiAgdGl0bGU6IFwiQ29sbGVjdGlvbnNcIixcbiAgaWNvbjogXCJncmlkLXZpZXdcIixcbiAgY2F0ZWdvcnk6IFwid2lkZ2V0c1wiLFxuICBlZGl0KHsgYXR0cmlidXRlcywgY2xhc3NOYW1lLCBzZXRBdHRyaWJ1dGVzIH0pIHtcbiAgICByZXR1cm4gKFxuICAgICAgPGRpdiBjbGFzc05hbWU9XCJjb250YWluZXJcIj5cbiAgICAgICAgPEluc3BlY3RvckNvbnRyb2xzPlxuICAgICAgICAgIDxQYW5lbEJvZHkgdGl0bGU9XCJDb2xsZWN0aW9ucyBTZXR0aW5nc1wiIGluaXRpYWxPcGVuPXt0cnVlfT5cbiAgICAgICAgICAgIDxkaXY+XG4gICAgICAgICAgICAgIDxfX2V4cGVyaW1lbnRhbE51bWJlckNvbnRyb2xcbiAgICAgICAgICAgICAgICBvbkNoYW5nZT17KG51bWJlcikgPT5cbiAgICAgICAgICAgICAgICAgIHNldEF0dHJpYnV0ZXMoe1xuICAgICAgICAgICAgICAgICAgICBjb3VudDogbnVtYmVyLFxuICAgICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgbWluPXsxfVxuICAgICAgICAgICAgICAgIHZhbHVlPXthdHRyaWJ1dGVzLmNvdW50fVxuICAgICAgICAgICAgICAgIGlzU2hpZnRTdGVwRW5hYmxlZD17ZmFsc2V9XG4gICAgICAgICAgICAgIC8+XG4gICAgICAgICAgICA8L2Rpdj5cbiAgICAgICAgICA8L1BhbmVsQm9keT5cbiAgICAgICAgPC9JbnNwZWN0b3JDb250cm9scz5cbiAgICAgICAgPFNlcnZlclNpZGVSZW5kZXJcbiAgICAgICAgICBibG9jaz1cIm5oc20td2lkZ2V0cy9jb2xsZWN0aW9uc1wiXG4gICAgICAgICAgY2xhc3NOYW1lPVwiYmxvY2tzLWdhbGxlcnktZ3JpZFwiXG4gICAgICAgICAgYXR0cmlidXRlcz17YXR0cmlidXRlc31cbiAgICAgICAgLz5cbiAgICAgIDwvZGl2PlxuICAgICk7XG4gIH0sXG59KTtcbiIsIi8vIHJlbW92ZWQgYnkgZXh0cmFjdC10ZXh0LXdlYnBhY2stcGx1Z2luIiwiLy8gcmVtb3ZlZCBieSBleHRyYWN0LXRleHQtd2VicGFjay1wbHVnaW4iXSwic291cmNlUm9vdCI6IiJ9
