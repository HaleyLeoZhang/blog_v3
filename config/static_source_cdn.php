<?php

// ----------------------------------------------------------------------
// 前端静态资源 CDN 列表
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

return [
    // Jquery
    // "jquery" => "//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js", // 百度，2019年3月30日 10:50:59 谷歌检测到安全攻击，已弃用
    "jquery" => "https://cdn.staticfile.org/jquery/2.1.4/jquery.min.js", // 七牛
    // layer 弹出层
    "layer" => "//cdn.staticfile.org/layer/2.3/layer.js", // 七牛
    // 异步JS资源加载
    "load_js" => "//cdn.staticfile.org/loadjs/3.4.0/loadjs.min.js", // 七牛
    // WangEditor
    "wang_editor_js" => "//unpkg.com/wangeditor/release/wangEditor.min.js", // - v3
    "wang_editor_css" => "//unpkg.com/wangeditor/release/wangEditor.min.css",
    "wang_editor_js_v2" => "http://cdn.bootcss.com/wangeditor/2.1.20/js/wangEditor.min.js", // - v2
    "wang_editor_css_v2" => "http://cdn.bootcss.com/wangeditor/2.1.20/css/wangEditor.min.css",
    // ES5、ES6语法糖兼容
    "es5" => "//cdn.staticfile.org/es5-shim/4.5.9/es5-shim.min.js",
    "es6" => "//cdn.staticfile.org/es6-shim/0.35.3/es6-shim.min.js",
    // Sentry
    "sentry" => "//cdn.ravenjs.com/3.19.1/raven.min.js",
    // Font-Awesome
    "font_awesome_css" => "//cdn.staticfile.org/font-awesome/4.6.3/css/font-awesome.min.css",
    "font_awesome_svg" => "//cdn.staticfile.org/font-awesome/4.6.3/fonts/fontawesome-webfont.svg",
    // 图片懒加载
    "jquery_lazyload" => "//cdn.staticfile.org/jquery_lazyload/1.9.7/jquery.lazyload.min.js",

    // 百度统计
    "baidu_statistic" => "https://hm.baidu.com/hm.js?" . env('BAIDU_STATISTIC_HASH', ''),

];