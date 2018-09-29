"use strict";

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

//+++++++++++++++++++++++++++++++++++++++++++++++++++++
//++    Laytpl模板引擎  Link : http://laytpl.layui.com/
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
!function () {
    "use strict";
    var f,
        b = { open: "{{", close: "}}" },
        c = { exp: function exp(a) {
            return new RegExp(a, "g");
        }, query: function query(a, c, e) {
            var f = ["#([\\s\\S])+?", "([^{#}])*?"][a || 0];return d((c || "") + b.open + f + b.close + (e || ""));
        }, escape: function escape(a) {
            return String(a || "").replace(/&(?!#?[a-zA-Z0-9]+;)/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&#39;").replace(/"/g, "&quot;");
        }, error: function error(a, b) {
            var c = "Laytpl Error：";return "object" == (typeof console === "undefined" ? "undefined" : _typeof(console)) && console.error(c + a + "\n" + (b || "")), c + a;
        } },
        d = c.exp,
        e = function e(a) {
        this.tpl = a;
    };e.pt = e.prototype, e.pt.parse = function (a, e) {
        var f = this,
            g = a,
            h = d("^" + b.open + "#", ""),
            i = d(b.close + "$", "");a = a.replace(/[\r\t\n]/g, " ").replace(d(b.open + "#"), b.open + "# ").replace(d(b.close + "}"), "} " + b.close).replace(/\\/g, "\\\\").replace(/(?="|')/g, "\\").replace(c.query(), function (a) {
            return a = a.replace(h, "").replace(i, ""), '";' + a.replace(/\\/g, "") + '; view+="';
        }).replace(c.query(1), function (a) {
            var c = '"+(';return a.replace(/\s/g, "") === b.open + b.close ? "" : (a = a.replace(d(b.open + "|" + b.close), ""), /^=/.test(a) && (a = a.replace(/^=/, ""), c = '"+_escape_('), c + a.replace(/\\/g, "") + ')+"');
        }), a = '"use strict";var view = "' + a + '";return view;';try {
            return f.cache = a = new Function("d, _escape_", a), a(e, c.escape);
        } catch (j) {
            return delete f.cache, c.error(j, g);
        }
    }, e.pt.render = function (a, b) {
        var e,
            d = this;return a ? (e = d.cache ? d.cache(a, c.escape) : d.parse(d.tpl, a), b ? (b(e), void 0) : e) : c.error("no data");
    }, f = function f(a) {
        return "string" != typeof a ? c.error("Template not found") : new e(a);
    }, f.config = function (a) {
        a = a || {};for (var c in a) {
            b[c] = a[c];
        }
    }, f.v = "1.1", "function" == typeof define ? define(function () {
        return f;
    }) : "undefined" != typeof exports ? module.exports = f : window.laytpl = f;
}();

// ---------------------------------------------------------------------------
//    自定义使用方法
// ---------------------------------------------------------------------------

/**
* 异步渲染 html
* String 模板id
* String 被渲染容器id
* Json 数据
* Boolean 是否异步渲染，默认是
*/
function render(tpl_id, con_id, full_data) {
    var not_async = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;

    var tpl = document.getElementById(tpl_id).innerHTML;
    if (not_async) {
        // 这种模式，不负责回调
        laytpl(tpl).render(full_data, function (tpl_html) {
            document.getElementById(con_id).innerHTML = tpl_html;
        });
    } else {
        document.getElementById(con_id).innerHTML = laytpl(tpl).render(full_data);
    }
}

/**
* String 待渲染模板
* String 待渲染 div 的 id
* Json   待渲染数据
* function 渲染后的回调函数
*/
function async_render(tpl_id, container_id, full_data) {
    var func = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;

    var tpl_html = $("#" + tpl_id).html(),
        tpl_container = $("#" + container_id).html();
    laytpl(tpl_html).render(full_data, function (now_html) {
        $("#" + container_id).html(now_html);
        // 这里是回调函数
        if (func != false) {
            func();
        }
    });
}