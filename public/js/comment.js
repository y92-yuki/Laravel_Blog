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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/comment.js":
/*!*********************************!*\
  !*** ./resources/js/comment.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


window.addEventListener('DOMContentLoaded', function () {
  var successMessage = function successMessage() {
    $('.alert-success').fadeIn();
    setTimeout(function () {
      $('.alert-success').fadeOut(5000);
    }, 2000);
  };

  var dangerMessage = function dangerMessage() {
    $('.alert-danger').fadeIn();
    setTimeout(function () {
      $('.alert-danger').fadeOut(5000);
    }, 2000);
  };

  document.querySelector('#commentSubmit').onsubmit = function (e) {
    e.preventDefault();
    var formData = new FormData(document.forms.commentSubmit);
    var token = formData.get('_token');
    formData["delete"]('_token');
    var message = document.querySelector('textarea[name=message]');

    var newComment = function newComment(userName, year, month, date, hour, min, sec, message, comment) {
      document.querySelector('#commentArea').insertAdjacentHTML('beforeend', "\n                <div class=\"card my-2\" style=\"width: 18rem\">\n                    <div class=\"card-body\">\n                        <h6 class=\"card-title\">\n                            ".concat(userName, "(").concat(year, "-").concat(month, "-").concat(date, " ").concat(hour, ":").concat(min, ":").concat(sec, ")\n                            <input type=\"hidden\" class=\"commentExistsLike\" value=\"0\">\n                            <button type=\"button\" class=\"float-right btn btn-success btn-sm commentLike-toggle commentUnlike d-none\" value=\"").concat(comment, "\">\u53D6\u6D88</button>\n                            <button type=\"button\" class=\"float-right btn btn-primary btn-sm commentLike-toggle commentLike\" value=\"").concat(comment, "\"><i class=\"fa-regular fas fa-thumbs-up\"> \u3044\u3044\u306D\uFF01</i></button>\n                            <p>\u3044\u3044\u306D\u306E\u6570:<span class=\"commentLikeCount\">0</span></p>\n                        </h6>\n                        <p class=\"card-text\">\n                            ").concat(message, "\n                            <a href=\"/post/show/delete/").concat(comment, "\" class=\"mt-1 float-right btn btn-sm btn-danger\">\u524A\u9664</a>\n                        </p>\n                    </div>\n                </div>\n            "));
    };

    if (message.value && message.value.length <= 20) {
      fetch('/post/show', {
        method: 'POST',
        headers: {
          "X-CSRF-TOKEN": token
        },
        body: formData
      }).then(function (res) {
        return res.json();
      }).then(function (res) {
        var time = new Date(res.created_at);
        var year = time.getFullYear();
        var month = time.getMonth() + 1;
        var date = time.getDate();
        var hour = time.getHours();
        var min = time.getMinutes();
        var sec = time.getSeconds();
        message.value = '';
        document.querySelectorAll('.validateMessage').forEach(function (item) {
          if (item) {
            item.remove();
          }
        });
        message.classList.remove('is-invalid');
        newComment(res.userName, year, month, date, hour, min, sec, res.message, res.commentId);
        successMessage();
      })["catch"](function (e) {
        console.log(e);
        dangerMessage();
      });
    } else if (!message.value) {
      if (!document.querySelector('.blankMessage')) {
        var validateMessage = document.createElement('p');
        validateMessage.textContent = '*コメントを入力してください';
        validateMessage.classList.add('text-danger', 'blankMessage', 'validateMessage');
        message.before(validateMessage);
        message.classList.add('is-invalid');
      }
    } else {
      if (!document.querySelector('.max20Message')) {
        var _validateMessage = document.createElement('p');

        _validateMessage.textContent = '*コメントは20文字以内で入力してください';

        _validateMessage.classList.add('text-danger', 'max20Message', 'validateMessage');

        message.before(_validateMessage);
        message.classList.add('is-invalid');
      }
    }
  };
});

/***/ }),

/***/ 2:
/*!***************************************!*\
  !*** multi ./resources/js/comment.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/yamanakayuki/workspace/Blog/resources/js/comment.js */"./resources/js/comment.js");


/***/ })

/******/ });