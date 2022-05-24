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
}; //コメントの新規投稿処理


var addComment = function addComment(formData, message) {
  fetch('/post/show', {
    method: 'POST',
    headers: {
      "X-CSRF-TOKEN": formData.get('_token')
    },
    body: formData
  }).then(function (res) {
    return res.text();
  }).then(function (res) {
    message.value = ''; //コメント投稿後にバリデーションメッセージを削除

    document.querySelectorAll('.validateMessage').forEach(function (item) {
      if (item) {
        item.remove();
      }
    });
    message.classList.remove('is-invalid'); //コメント成功メッセージを表示

    successMessage(); //新規投稿したコメントを挿入

    document.querySelector('.viewComments').insertAdjacentHTML('afterbegin', res);
  }) //コメントの取消ボタンを非表示
  .then(function () {
    return document.querySelector('button.commentUnlike').classList.add('d-none');
  })["catch"](function (e) {
    console.error(e);
    dangerMessage();
  });
}; //バリデーションメッセージの挿入


var addValidateMessage = function addValidateMessage(message, messagePosition) {
  var messageType = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  var validateMessage = document.createElement('p');
  validateMessage.textContent = message;
  validateMessage.classList.add('text-danger', 'validateMessage', messageType);
  messagePosition.before(validateMessage);
  messagePosition.classList.add('is-invalid');
};

window.addEventListener('DOMContentLoaded', function () {
  //コメントの新規投稿処理
  document.querySelector('#commentSubmit').onsubmit = function (e) {
    e.preventDefault();
    var formData = new FormData(document.forms.commentSubmit);
    var message = document.querySelector('textarea[name=message]');

    if (!message.value) {
      if (!document.querySelector('.blankMessage')) {
        addValidateMessage('*コメントを入力してください', message, 'blankMessage');
      }
    } else if (message.value.length >= 20) {
      if (!document.querySelector('.max20Message')) {
        addValidateMessage('*コメントは20文字以内で入力してください', message, 'max20Message');
      }
    } else {
      addComment(formData, message);
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