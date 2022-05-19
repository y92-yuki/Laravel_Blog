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
 //非同期処理のトーストメッセージ(success)

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var successMessage = function successMessage() {
  $('.alert-success').fadeIn();
  setTimeout(function () {
    $('.alert-success').fadeOut(5000);
  }, 2000);
}; //非同期処理のトーストメッセージ(fail)


var dangerMessage = function dangerMessage() {
  $('.alert-danger').fadeIn();
  setTimeout(function () {
    $('.alert-danger').fadeOut(5000);
  }, 2000);
}; //コメントの投稿時間を取得


var getCreated_at = function getCreated_at(created_at) {
  var time = new Date(created_at);
  var year = time.getFullYear();
  var month = time.getMonth() + 1;
  var date = time.getDate();
  var hour = time.getHours();
  var min = time.getMinutes();
  var sec = time.getSeconds();

  var getPadstart = function getPadstart(num) {
    return String(num).padStart(2, '0');
  };

  return "".concat(year, "-").concat(getPadstart(month), "-").concat(getPadstart(date), " ").concat(getPadstart(hour), ":").concat(getPadstart(min), ":").concat(getPadstart(sec));
}; //コメントを挿入するためのフォーマット


var comment = function comment(userName, timed, message, comment_id, commentExistsLike, likeNum) {
  document.querySelector('.viewComments').insertAdjacentHTML('afterbegin', "\n        <div class=\"card my-2\" style=\"width: 18rem\">\n            <div class=\"card-body\">\n                <h6 class=\"card-title\">\n                    ".concat(userName, "(").concat(timed, ")\n                    <input type=\"hidden\" class=\"commentExistsLike\" value=\"").concat(commentExistsLike, "\">\n                    <button type=\"button\" id=\"commentUnlike\" class=\"float-right btn btn-success btn-sm commentLike-toggle commentUnlike\" value=\"").concat(comment_id, "\">\u53D6\u6D88</button>\n                    <button type=\"button\" class=\"float-right btn btn-primary btn-sm commentLike-toggle commentLike\" value=\"").concat(comment_id, "\"><i class=\"fa-regular fas fa-thumbs-up\"> \u3044\u3044\u306D\uFF01</i></button>\n                    <p>\u3044\u3044\u306D\u306E\u6570:<span class=\"commentLikeCount\">").concat(likeNum, "</span></p>\n                </h6>\n                <p class=\"card-text\">\n                    ").concat(message, "\n                    <a href=\"/post/show/delete/").concat(comment_id, "\" class=\"mt-1 float-right btn btn-sm btn-danger\">\u524A\u9664</a>\n                </p>\n            </div>\n        </div>\n    "));
};

window.addEventListener('DOMContentLoaded', function () {
  var post_id = document.querySelector('input[name=post_id]'); //投稿済みのコメントを取得

  fetch("/post/show/getcomment/".concat(post_id.value)).then(function (res) {
    return res.json();
  }).then(function (res) {
    var _iterator = _createForOfIteratorHelper(res),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var p = _step.value;
        comment(p.user.name, getCreated_at(p.created_at), p.message, p.id, p.is_like_by_login_user, p.likes.length);
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
  }).then(function () {
    var liked = document.querySelectorAll('.commentExistsLike');

    var _iterator2 = _createForOfIteratorHelper(liked),
        _step2;

    try {
      for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
        var p = _step2.value;

        if (JSON.parse(p.value)) {
          p.nextElementSibling.nextElementSibling.classList.add('d-none');
        } else {
          p.nextElementSibling.classList.add('d-none');
        }
      }
    } catch (err) {
      _iterator2.e(err);
    } finally {
      _iterator2.f();
    }
  })["catch"](function (e) {
    return console.log(e);
  }); //コメントの新規投稿処理

  document.querySelector('#commentSubmit').onsubmit = function (e) {
    e.preventDefault();
    var formData = new FormData(document.forms.commentSubmit);
    var token = formData.get('_token');
    formData["delete"]('_token');
    var message = document.querySelector('textarea[name=message]');

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
        message.value = '';
        document.querySelectorAll('.validateMessage').forEach(function (item) {
          if (item) {
            item.remove();
          }
        });
        message.classList.remove('is-invalid');
        successMessage();
        comment(res.userName, getCreated_at(res.created_at), res.message, res.commentId, 0, 0);
        document.querySelector('#commentUnlike').classList.add('d-none');
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