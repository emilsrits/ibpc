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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/app.js":
/*!************************************!*\
  !*** ./resources/assets/js/app.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  $(document).ready(function () {
    // Hide flash message
    $('.message-close').css('display', 'inline-block').click(function () {
      $('.flash-message').fadeOut(500);
    }); // Check all checkboxes in catalog for mass action

    $('#mass-select').click(function () {
      if ($(this).is(':checked')) {
        $('.entity-select').each(function () {
          $(this).prop('checked', true);
        });
      } else {
        $('.entity-select').each(function () {
          $(this).prop('checked', false);
        });
      }
    }); // Confirm product deletion in catalog

    $('#catalog-form').submit(function () {
      var massAction = $('#mass-action').val();

      if (massAction === '3') {
        var numberOfChecked = $('.entity-select:checked').length;

        if (numberOfChecked > 0) {
          return confirm('Delete ' + numberOfChecked + ' products?');
        }
      }
    }); // Confirm entity delete

    $('#entity-delete').click(function () {
      return confirm('Delete this?');
    }); // Toggle specifications sections when creating product

    $('.content-section-toggle').click(function () {
      $('i', this).toggleClass('fa-angle-up fa-angle-down');
      $(this).parent().find('.content-container').slideToggle();
    }); // Toggle parent_id selection for category creation

    $('#category-parent').change(function () {
      if ($(this).val() === '1') {
        $('#category-parent-id').hide();
      } else {
        $('#category-parent-id').show();
      }
    }); // Confirm category deletion in categories view

    $('#categories-form').submit(function () {
      var massAction = $('#mass-action').val();

      if (massAction === '3') {
        var numberOfChecked = $('.entity-select:checked').length;

        if (numberOfChecked > 0) {
          return confirm('Delete ' + numberOfChecked + ' categories?');
        }
      }
    }); // Confirm specification deletion in specifications view

    $('#specifications-form').submit(function () {
      var massAction = $('#mass-action').val();

      if (massAction === '1') {
        var numberOfChecked = $('.entity-select:checked').length;

        if (numberOfChecked > 0) {
          return confirm('Delete ' + numberOfChecked + ' attribute groups?');
        }
      }
    }); // Confirm attribute deletion

    $('#attributes-form').submit(function () {
      var massAction = $('#mass-action').val();

      if (massAction === '1') {
        var numberOfChecked = $('.entity-select:checked').length;

        if (numberOfChecked > 0) {
          return confirm('Delete ' + numberOfChecked + ' attributes?');
        }
      }
    }); // Confirm user deletion

    $('#users-form').submit(function () {
      var massAction = $('#mass-action').val();

      if (massAction === '2') {
        var numberOfChecked = $('.entity-select:checked').length;

        if (numberOfChecked > 0) {
          return confirm('Disable ' + numberOfChecked + ' users?');
        }
      }
    }); // Uncheck other checkboxes when one of delivery options is selected

    $('.checkout-delivery-storage, .checkout-delivery-address').click(function () {
      var checkbox = $(this).find('input[type="checkbox"]');
      checkbox.prop('checked', true);
      $('input[type="checkbox"]').not(checkbox).prop('checked', false);
    }); // Disable order submit button after once click

    $('#checkout-confirm-form').one('submit', function () {
      $(this).find('#order-submit').css('opacity', '0.6').attr('onclick', 'return false;');
    }); // Clear all filters when clicked

    $('#filters-clear').click(function () {
      clearAllInputs($('#table-search'));
    }); // Clear all filters from a admin panel table

    function clearAllInputs(selector) {
      $(selector).find(':input').each(function () {
        $(this).val('');
      });
      $(selector).find('select').each(function () {
        $(this).selectedIndex = 0;
      });
    } // Toggle dropdown for category navigation


    $('.dropdown-trigger').click(function () {
      toggleDropdown($(this));
    });

    function toggleDropdown(selector) {
      $('.dropdown-content').hide();
      $(selector).find('.dropdown-content').show();
    }

    $(document).on('click', function (e) {
      if (!$(e.target).closest('.dropdown-content').length && !$(e.target).closest('.dropdown-trigger').length) {
        $('.dropdown-content').hide();
      }
    });
    /* ------AJAX------ */
    // Load category specifications when creating product

    $('#category-select').change(function () {
      $.ajax({
        type: 'GET',
        url: '/admin/product/categories',
        data: {
          selectFieldValue: $(this).val()
        },
        success: function success(data) {
          window.location.href = data.redirectUrl + data.category;
        },
        error: function error(err) {
          console.log("error: " + err);
        }
      });
    }); // Add a product to cart

    $('.product-quick-add').click(function () {
      $.ajax({
        type: 'GET',
        url: '/cart/add/' + $(this).val(),
        data: {
          productId: $(this).val()
        },
        dataType: 'json',
        success: function success(data) {
          $('#navbar-cart-items').html(data);
        },
        error: function error(err) {
          console.log("error: " + err);
        }
      });
    });
  });
})(jQuery);

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./resources/assets/sass/app.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!***************************************************************************!*\
  !*** multi ./resources/assets/js/app.js ./resources/assets/sass/app.scss ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\wamp64\www\ibpc\resources\assets\js\app.js */"./resources/assets/js/app.js");
module.exports = __webpack_require__(/*! C:\wamp64\www\ibpc\resources\assets\sass\app.scss */"./resources/assets/sass/app.scss");


/***/ })

/******/ });