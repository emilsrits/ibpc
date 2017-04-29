/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.l = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// identity function for calling harmory imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };

/******/ 	// define getter function for harmory exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		Object.defineProperty(exports, name, {
/******/ 			configurable: false,
/******/ 			enumerable: true,
/******/ 			get: getter
/******/ 		});
/******/ 	};

/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};

/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports) {

eval("(function($) {\n\n    $(document).ready(function () {\n        // Hide flash message\n        $('.message-close').css('display', 'inline-block').click(function () {\n            $('.flash-message').fadeOut(500);\n        });\n\n        // Check all checkboxes in catalog for mass action\n        $('#mass-select').click(function () {\n            if ($(this).is(':checked')) {\n                $('.product-select').each(function () {\n                    $(this).prop('checked', true);\n                });\n            } else {\n                $('.product-select').each(function () {\n                    $(this).prop('checked', false);\n                });\n            }\n        });\n\n        // Confirm product deletion in catalog\n        $('#catalog-form').submit(function () {\n            if ($('#mass-action').val() === '4') {\n                var numberOfChecked = $('.product-select:checked').length;\n\n                return confirm('Delete ' + numberOfChecked + ' products?');\n            }\n        });\n\n        // Toggle specifications sections when creating product\n        $('.product-content-section-toggle').click(function () {\n            $('i', this).toggleClass('fa-angle-up fa-angle-down');\n            $(this).parent().find('.product-container').slideToggle();\n        });\n\n        /* ------AJAX------ */\n        // Load category specifications when creating product\n        $('#category-select').change(function () {\n            $.ajax({\n                type: 'GET',\n                url: '/admin/catalog/specifications',\n                data: {\n                    selectFieldValue: $(this).val()\n                },\n                success: function (data) {\n                    window.location.href = data.redirectUrl + data.category;\n                },\n                error: function(err) {\n                    console.log(\"error: \" + err);\n                }\n            });\n        });\n    })\n\n}(jQuery));//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiMC5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy9yZXNvdXJjZXMvYXNzZXRzL2pzL2FwcC5qcz84YjY3Il0sInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbigkKSB7XG5cbiAgICAkKGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbiAoKSB7XG4gICAgICAgIC8vIEhpZGUgZmxhc2ggbWVzc2FnZVxuICAgICAgICAkKCcubWVzc2FnZS1jbG9zZScpLmNzcygnZGlzcGxheScsICdpbmxpbmUtYmxvY2snKS5jbGljayhmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAkKCcuZmxhc2gtbWVzc2FnZScpLmZhZGVPdXQoNTAwKTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgLy8gQ2hlY2sgYWxsIGNoZWNrYm94ZXMgaW4gY2F0YWxvZyBmb3IgbWFzcyBhY3Rpb25cbiAgICAgICAgJCgnI21hc3Mtc2VsZWN0JykuY2xpY2soZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaWYgKCQodGhpcykuaXMoJzpjaGVja2VkJykpIHtcbiAgICAgICAgICAgICAgICAkKCcucHJvZHVjdC1zZWxlY3QnKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICAgICAgICAgJCh0aGlzKS5wcm9wKCdjaGVja2VkJywgdHJ1ZSk7XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICQoJy5wcm9kdWN0LXNlbGVjdCcpLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgICAgICAgICAkKHRoaXMpLnByb3AoJ2NoZWNrZWQnLCBmYWxzZSk7XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pO1xuXG4gICAgICAgIC8vIENvbmZpcm0gcHJvZHVjdCBkZWxldGlvbiBpbiBjYXRhbG9nXG4gICAgICAgICQoJyNjYXRhbG9nLWZvcm0nKS5zdWJtaXQoZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaWYgKCQoJyNtYXNzLWFjdGlvbicpLnZhbCgpID09PSAnNCcpIHtcbiAgICAgICAgICAgICAgICB2YXIgbnVtYmVyT2ZDaGVja2VkID0gJCgnLnByb2R1Y3Qtc2VsZWN0OmNoZWNrZWQnKS5sZW5ndGg7XG5cbiAgICAgICAgICAgICAgICByZXR1cm4gY29uZmlybSgnRGVsZXRlICcgKyBudW1iZXJPZkNoZWNrZWQgKyAnIHByb2R1Y3RzPycpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgICAgICAvLyBUb2dnbGUgc3BlY2lmaWNhdGlvbnMgc2VjdGlvbnMgd2hlbiBjcmVhdGluZyBwcm9kdWN0XG4gICAgICAgICQoJy5wcm9kdWN0LWNvbnRlbnQtc2VjdGlvbi10b2dnbGUnKS5jbGljayhmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAkKCdpJywgdGhpcykudG9nZ2xlQ2xhc3MoJ2ZhLWFuZ2xlLXVwIGZhLWFuZ2xlLWRvd24nKTtcbiAgICAgICAgICAgICQodGhpcykucGFyZW50KCkuZmluZCgnLnByb2R1Y3QtY29udGFpbmVyJykuc2xpZGVUb2dnbGUoKTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgLyogLS0tLS0tQUpBWC0tLS0tLSAqL1xuICAgICAgICAvLyBMb2FkIGNhdGVnb3J5IHNwZWNpZmljYXRpb25zIHdoZW4gY3JlYXRpbmcgcHJvZHVjdFxuICAgICAgICAkKCcjY2F0ZWdvcnktc2VsZWN0JykuY2hhbmdlKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgICQuYWpheCh7XG4gICAgICAgICAgICAgICAgdHlwZTogJ0dFVCcsXG4gICAgICAgICAgICAgICAgdXJsOiAnL2FkbWluL2NhdGFsb2cvc3BlY2lmaWNhdGlvbnMnLFxuICAgICAgICAgICAgICAgIGRhdGE6IHtcbiAgICAgICAgICAgICAgICAgICAgc2VsZWN0RmllbGRWYWx1ZTogJCh0aGlzKS52YWwoKVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgICAgICAgICAgICAgd2luZG93LmxvY2F0aW9uLmhyZWYgPSBkYXRhLnJlZGlyZWN0VXJsICsgZGF0YS5jYXRlZ29yeTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIGVycm9yOiBmdW5jdGlvbihlcnIpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc29sZS5sb2coXCJlcnJvcjogXCIgKyBlcnIpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9KTtcbiAgICB9KVxuXG59KGpRdWVyeSkpO1xuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyByZXNvdXJjZXMvYXNzZXRzL2pzL2FwcC5qcyJdLCJtYXBwaW5ncyI6IkFBQUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7OztBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Iiwic291cmNlUm9vdCI6IiJ9");

/***/ }
/******/ ]);