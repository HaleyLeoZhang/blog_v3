'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

// 长按时间计算，单位毫秒
var press_timestamp_start = void 0; // 开始按的时间

var tools = function () {
  function tools() {
    _classCallCheck(this, tools);
  }

  _createClass(tools, null, [{
    key: 'sub_str',

    /**
     * 超出长度则省略
     * @param string str 字符串
     * @param int len 字符串长度限制
     * @return string
     */
    value: function sub_str(str, len) {

      if (str.length > len) {
        return str.substring(0, len) + '...';
      } else {
        return str;
      }
    }
    /**
     * 封装 ajax，要求有异步回调
     * @param json data
     * 示例参数：
     * {
     *   "url":"",
     *   "get":{},
     *   "post":{},
     *   "callback":function(d){...},
     *   "need":"", // 不输入 -> 获取json || html -> 获取 纯文本
     * }
     */

  }, {
    key: 'ajax',
    value: function ajax(data) {
      // 过滤
      switch (true) {
        case undefined === data.url:
          // case undefined === data.callback :
          console.error("未填写ajax地址");
          return;
        default:
          break;
      }
      // 合并 get参数
      var get_url = function get_url(json) {
        if (null === json.url.match(/\?/)) {
          return json.url + '?' + package_params(json.get);
        } else {
          return json.url + '&' + package_params(json.get);
        }
      };
      // 打包参数
      var package_params = function package_params(json_data) {
        var body = '';
        if (undefined !== json_data) {
          for (var i in json_data) {
            body += encodeURIComponent(i) + '=' + encodeURIComponent(json_data[i]) + '&';
          }
        }
        return body;
      };
      var xhr = new XMLHttpRequest();
      var method = undefined === data.post ? 'get' : 'post';
      var send_data = undefined === data.post ? null : package_params(data.post);
      xhr.open(method, get_url(data));
      // 设置请求头
      if (undefined !== data.post) {
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
      }
      // 设置回调解析
      if (undefined !== data.callback) {
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4 && xhr.status == 200) {
            if ("" == xhr.responseText) {
              console.warn('ajax返回值为空');
              return;
            }
            if (undefined === data.need) {
              data.callback(JSON.parse(xhr.responseText));
            } else {
              data.callback(xhr.responseText);
            }
          }
        };
      }
      xhr.send(send_data);
    }
    /**
     * 如果要把个位数变成两位数的字符串
     * @param int|string 一个数字或者带数字的字符串
     * @return string
     */

  }, {
    key: 'need_zero',
    value: function need_zero(d) {
      d = parseInt(d);
      if (d < 10) {
        return "0" + d;
      }
      return "" + d;
    }
    /**
     * 监听长按开始
     */

  }, {
    key: 'long_press_start',
    value: function long_press_start() {
      press_timestamp_start = new Date().getTime();
      console.log("touch开始");
    }
    /**
     * 监听长按结束，超过1秒就长按，否则就是点击事件
     * @param json {"longpress":function(){...},"click":function(){}}
     */

  }, {
    key: 'long_press_end',
    value: function long_press_end(_ini) {
      var dis_time = new Date().getTime() - press_timestamp_start;
      console.log("触摸时间： " + dis_time);
      if (dis_time >= 1000) {
        console.log("触摸事件");
        if (undefined !== _ini.click) {
          _ini.longpress();
        }
      } else {
        console.log("点击事件");
        if (undefined !== _ini.click) {
          _ini.click();
        }
      }
      console.log("touch结束");
    }
  }]);

  return tools;
}();

exports.default = tools;