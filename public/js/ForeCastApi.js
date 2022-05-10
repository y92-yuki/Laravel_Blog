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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/ForeCastApi.js":
/*!*************************************!*\
  !*** ./resources/js/ForeCastApi.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


window.addEventListener('DOMContentLoaded', function () {
  //CSRFトークン
  var token = document.querySelector('meta[name=csrf-token]').content; //ログインユーザーの都道府県名

  var pref = document.querySelector('input[name=pref]').value; //県庁所在地

  var prefofficeLocation = document.querySelector('input[name=prefofficeLocation]').value;
  var data = {
    locations: prefofficeLocation
  };
  fetch('/getForeCast', {
    method: "POST",
    headers: {
      "Content-type": "application/json",
      "X-CSRF-TOKEN": token
    },
    body: JSON.stringify(data)
  }).then(function (res) {
    return res.json();
  }).then(function (res) {
    //天気データを取得した時間
    var time = new Date(res.dt * 1000);
    var week = ['日', '月', '火', '水', '木', '金', '土'];
    var currentTime = {
      month: time.getMonth() + 1,
      date: time.getDate(),
      day: week[time.getDay()],
      hour: time.getHours(),
      min: String(time.getMinutes()).padStart(2, '0')
    }; //成型した時間データを挿入

    document.querySelector('.weatherTime').textContent = "".concat(currentTime.month, "\u6708").concat(currentTime.date, "\u65E5(").concat(currentTime.day, ")").concat(currentTime.hour, "\u6642").concat(currentTime.min, "\u5206\u73FE\u5728\uFF1A").concat(pref, "\u306E\u5929\u6C17"); //天気アイコン

    var weatherIcon = document.querySelector('.weatherIcon');
    weatherIcon.src = "weatherIcons/".concat(res.weather[0].icon, ".svg");
    weatherIcon.style.width = '45px'; //天気の説明

    document.querySelector('.description').textContent = res.weather[0].description;
    var tempIcon = document.querySelector('.tempIcon'); //気温アイコン

    tempIcon.src = 'weatherIcons/thermometer.svg';
    tempIcon.style.width = '30px'; //最高温度

    document.querySelector('.tempMax').textContent = "".concat(Math.round(res.main.temp_max), "\u2103"); //最低温度

    document.querySelector('.tempMin').textContent = "".concat(Math.round(res.main.temp_min), "\u2103");
  })["catch"](function (e) {
    console.error(e);
    var weatherInfo = document.querySelector('.weatherInfo');
    weatherInfo.textContent = '*天気データの取得に失敗しました';
    weatherInfo.classList.add('h5', 'text-danger');
  });
});

/***/ }),

/***/ 4:
/*!*******************************************!*\
  !*** multi ./resources/js/ForeCastApi.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/yamanakayuki/workspace/Blog/resources/js/ForeCastApi.js */"./resources/js/ForeCastApi.js");


/***/ })

/******/ });