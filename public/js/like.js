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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/like.js":
/*!******************************!*\
  !*** ./resources/js/like.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

window.addEventListener('DOMContentLoaded', function () {
  //いいね取り消し機能
  var unLikeExecute = function unLikeExecute(url, id, unLike, like, likeCount) {
    fetch(url, {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": token,
        "Content-type": "application/json"
      },
      body: JSON.stringify(id)
    }).then(function () {
      likeCount.textContent = String(parseInt(likeCount.textContent) - 1);
      unLike.classList.toggle('d-none');
      like.classList.toggle('d-none');
    })["catch"](function (e) {
      return console.error(e);
    });
  }; //良いね機能


  var likeExecute = function likeExecute(url, id, like, unLike, likeCount) {
    fetch(url, {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": token,
        "Content-type": "application/json"
      },
      body: JSON.stringify(id)
    }).then(function () {
      likeCount.textContent = String(parseInt(likeCount.textContent) + 1);
      like.classList.toggle('d-none');
      unLike.classList.toggle('d-none');
    })["catch"](function (e) {
      return console.error(e);
    });
  }; //投稿へのいいね機能
  //resourcess/views/layouts/app.blade.phpのcsrf-tokenを取得


  var token = document.querySelector('meta[name=csrf-token]').content; //ログイン中のユーザーがいいねをしているか判定(戻り値:0 or 1)

  var postExistsLike = document.querySelector('input[name=postExistsLike]').value; //投稿へのいいね数の要素を取得

  var postLikeCount = document.querySelector('#postLikeCount'); //いいね・取消ボタンを取得

  var postLike = document.querySelectorAll('.postLike-toggle'); //投稿詳細へアクセス時にいいね・取消ボタンの表示を操作

  if (postExistsLike) {
    document.querySelector('.postLike').classList.add('d-none');
  } else {
    document.querySelector('.postUnlike').classList.add('d-none');
  }

  postLike.forEach(function (item) {
    //いいね・取消ボタンのどちらかがクリックされたら処理開始
    item.onclick = function (e) {
      var event = e.currentTarget; //POSTで送信する値(いいね・取消共通)

      var post_id = {
        post_id: event.value
      }; //クリックされた要素がpostUnLikeクラスを持っていたら取消ボタン

      if (event.parentNode.classList.contains('postUnlike')) {
        var url = '/post/postUnlike';
        var unLike = event.parentNode;
        var like = document.querySelector('.postLike'); //いいね取消を実行

        unLikeExecute(url, post_id, unLike, like, postLikeCount);
      } else {
        var _url = '/post/postLike';
        var _like = event.parentNode;

        var _unLike = document.querySelector('.postUnlike'); //いいねを実行


        likeExecute(_url, post_id, _like, _unLike, postLikeCount);
      }

      ;
    };
  }); //コメントへのいいね機能
  // ログイン中のユーザーがコメントへいいねしているか

  var liked = document.querySelectorAll('.commentExistsLike');

  var _iterator = _createForOfIteratorHelper(liked),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var p = _step.value;

      if (p.value) {
        p.nextElementSibling.nextElementSibling.classList.add('d-none');
      } else {
        p.nextElementSibling.classList.add('d-none');
      }
    } //いいね・取消ボタンのクリックイベントを取得

  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  $(document).on('click', '.commentLike-toggle', function (e) {
    var event = e.currentTarget;
    var comment_id = {
      comment_id: event.value
    };
    var commentLikeCount = event.parentNode.lastElementChild.firstElementChild; //クリックされた要素がcommentUnlikeクラスを持っていたら取消ボタン

    if (event.classList.contains('commentUnlike')) {
      var url = '/post/comment/unlike';
      var unLike = event;
      var like = event.nextElementSibling; //いいね取消を実行

      unLikeExecute(url, comment_id, unLike, like, commentLikeCount);
    } else {
      var _url2 = '/post/comment/like';
      var _like2 = event;
      var _unLike2 = event.previousElementSibling; //いいねを実行

      likeExecute(_url2, comment_id, _like2, _unLike2, commentLikeCount);
    }

    ;
  });
});

/***/ }),

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/like.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/yamanakayuki/workspace/Blog/resources/js/like.js */"./resources/js/like.js");


/***/ })

/******/ });