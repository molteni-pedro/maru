!function(){var t={63166:function(t,e,n){"use strict";n.d(e,{EJ:function(){return r}});let o="";function r(t){if("https://subscribe.wordpress.com"===t.origin&&t.data){const e=JSON.parse(t.data);e&&e.result&&e.result.jwt_token&&(o=e.result.jwt_token,i(o)),e&&"close"===e.action&&o?window.location.reload():e&&"close"===e.action&&(window.removeEventListener("message",r),tb_remove&&tb_remove())}}const i=function(t){const e=new Date;e.setTime(e.getTime()+31536e6),document.cookie="jp-premium-content-session="+t+"; expires="+e.toGMTString()+"; path=/"}},80425:function(t,e,n){"object"==typeof window&&window.Jetpack_Block_Assets_Base_Url&&window.Jetpack_Block_Assets_Base_Url.url&&(n.p=window.Jetpack_Block_Assets_Base_Url.url)}},e={};function n(o){var r=e[o];if(void 0!==r)return r.exports;var i=e[o]={exports:{}};return t[o](i,i.exports,n),i.exports}n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,{a:e}),e},n.d=function(t,e){for(var o in e)n.o(e,o)&&!n.o(t,o)&&Object.defineProperty(t,o,{enumerable:!0,get:e[o]})},n.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"==typeof window)return window}}(),n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},function(){var t;n.g.importScripts&&(t=n.g.location+"");var e=n.g.document;if(!t&&e&&(e.currentScript&&(t=e.currentScript.src),!t)){var o=e.getElementsByTagName("script");o.length&&(t=o[o.length-1].src)}if(!t)throw new Error("Automatic publicPath is not supported in this browser");t=t.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),n.p=t+"../"}(),function(){"use strict";n(80425)}(),function(){"use strict";var t=n(63166);document.addEventListener("DOMContentLoaded",(function(){"undefined"!=typeof window&&window.addEventListener("message",t.EJ,!1)}))}()}();