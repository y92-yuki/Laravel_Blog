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


window.addEventListener('DOMContentLoaded', function () {
  //投稿へのいいね機能
  //resourcess->views->layouts->app.blade.phpのcsrf-tokenを取得
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
    item.onclick = function (e) {
      var event = e.currentTarget;
      var post_id = {
        post_id: event.value
      };

      if (event.parentNode.classList.contains('postUnlike')) {
        fetch("/post/postUnlike", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": token,
            "Content-type": "application/json"
          },
          body: JSON.stringify(post_id)
        }).then(function () {
          postLikeCount.textContent = String(parseInt(postLikeCount.textContent) - 1);
          event.parentNode.classList.toggle('d-none');
          document.querySelector('.postLike').classList.toggle('d-none');
        })["catch"](function (e) {
          return console.log(e);
        });
      } else {
        fetch('/post/postLike', {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": token,
            "Content-type": "application/json"
          },
          body: JSON.stringify(post_id)
        }).then(function () {
          postLikeCount.textContent = String(parseInt(postLikeCount.textContent) + 1);
          event.parentNode.classList.toggle('d-none');
          document.querySelector('.postUnlike').classList.toggle('d-none');
        })["catch"](function (e) {
          return console.log(e);
        });
      }

      ;
    };
  }); //コメントへのいいね機能
  //投稿にコメントがあるか判定(戻り値:要素 or null)

  var commentNone = document.querySelector('input[name=commentNone]'); // if (!commentNone) {
  //ログイン中のユーザーがコメントへいいねしているか判定

  var commentExistsLike = document.querySelectorAll('.commentExistsLike'); //いいね・取消ボタンの取得
  // const commentLike = document.querySelectorAll('.commentlike-toggle');
  //投稿詳細へアクセス時にいいね・取消ボタンの表示を操作

  commentExistsLike.forEach(function (item) {
    if (item.value) {
      item.nextElementSibling.nextElementSibling.classList.add('d-none');
    } else {
      item.nextElementSibling.classList.add('d-none');
    }
  });
  $(document).on('click', '.commentLike-toggle', function (e) {
    var event = e.currentTarget;
    var comment_id = {
      comment_id: event.value
    };

    if (event.classList.contains('commentUnlike')) {
      fetch('/post/comment/unlike', {
        method: 'POST',
        headers: {
          "X-CSRF-TOKEN": token,
          "content-type": "application/json"
        },
        body: JSON.stringify(comment_id)
      }).then(function () {
        //コメントのいいね数を取得->更新
        event.parentNode.lastElementChild.firstElementChild.textContent = String(parseInt(event.parentNode.lastElementChild.firstElementChild.textContent) - 1);
        event.nextElementSibling.classList.toggle('d-none');
        event.classList.toggle('d-none');
      })["catch"](function (e) {
        return console.log(e);
      });
    } else {
      fetch('/post/comment/like', {
        method: 'POST',
        headers: {
          "X-CSRF-TOKEN": token,
          "content-type": "application/json"
        },
        body: JSON.stringify(comment_id)
      }).then(function () {
        //コメントのいいね数を取得->更新
        event.parentNode.lastElementChild.firstElementChild.textContent = String(parseInt(event.parentNode.lastElementChild.firstElementChild.textContent) + 1);
        event.previousElementSibling.classList.toggle('d-none');
        event.classList.toggle('d-none');
      })["catch"](function (e) {
        return console.log(e);
      });
    }

    ;
  }); // };
  // commentLike.forEach((item) => {
  //     item.onclick = (e) => {
  //         const event = e.currentTarget;
  //         const comment_id = {comment_id: event.value};
  //         if (event.classList.contains('commentUnlike')) {
  //             fetch('/post/comment/unlike',{
  //                 method: 'POST',
  //                 headers: {
  //                     "X-CSRF-TOKEN": token,
  //                     "content-type": "application/json"
  //                 },
  //                 body: JSON.stringify(comment_id)
  //             })
  //             .then(() => {
  //                 //コメントのいいね数を取得->更新
  //                 event.parentNode.lastElementChild.firstElementChild.textContent = String(parseInt(event.parentNode.lastElementChild.firstElementChild.textContent) - 1);
  //                 event.nextElementSibling.classList.toggle('d-none');
  //                 event.classList.toggle('d-none');
  //             })
  //             .catch(e => console.log(e));
  //         } else {
  //             fetch ('/post/comment/like',{
  //                 method: 'POST',
  //                 headers: {
  //                     "X-CSRF-TOKEN": token,
  //                     "content-type": "application/json"
  //                 },
  //                 body: JSON.stringify(comment_id)
  //             })
  //             .then(() => {
  //                 //コメントのいいね数を取得->更新
  //                 event.parentNode.lastElementChild.firstElementChild.textContent = String(parseInt(event.parentNode.lastElementChild.firstElementChild.textContent) + 1);
  //                 event.previousElementSibling.classList.toggle('d-none');
  //                 event.classList.toggle('d-none');
  //             })
  //             .catch(e => console.log(e));
  //         };
  //     };
  // });
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