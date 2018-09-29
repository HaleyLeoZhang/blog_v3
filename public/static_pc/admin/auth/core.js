//++++++++++++++++++++++++++++++++++++++++++++++++++++
//++                Ajax调试 API
//++++++++++++++++++++++++++++++++++++++++++++++++++++
/*
* 输出调试结果
*/
;function out( obj ){
    if( obj.Err ){
        console.warn('错误代码：');
        console.log( obj.Err );
    }else if( obj.status ){
        console.warn('状态信息：');
        console.log( obj.status );
        if( obj.url ){
            console.log( "跳转链接："+obj.url );
        }
    }else if( obj.out ){
        console.warn('反馈信息：');
        console.log( obj.out );
    }else if( obj.info && obj.info.length > 0 ){
    // 输出获取到的数据
        console.warn('数据列表：');
        console.table( obj.info );
    }else{
        console.warn('未知错误：');
        console.log( obj );
    }
}
/*
* 获取调试数组
* Json : 单条数据
* Int  : 数据总长度 
* Return []
*/
;function debug_data(debug_val,len = 15){
    var d=[];
    for(var i=0; i<len;i++){
        d.push(debug_val);
    }
    return d;
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++
//++                URL拼接相关
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
/*
* API地址
* String : Api_controller 控制器名
* String : Api_action     方法名
*/
function api(Api_controller='',Api_action='', protocol='http', port=80){
    var site,
        server_name     = document.domain;
    site = protocol    + '://'  +
           server_name + ':'    +
           port        + '/Api?'+
           //参数
           'con=' + Api_controller + '&act=' + Api_action;
    return site ;
}
/**
* 完整URL
* String : web_inner_site 站内绝对路径
*/
function url(web_inner_site='', protocol='http', port=80){
    var site,
        server_name     = document.domain;
    site = protocol    + '://'  +
           server_name + ':'    +
           port        + web_inner_site
    return site ;
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++
//++    Laytpl模板引擎  Link : http://laytpl.layui.com/
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
;!function(){"use strict";var f,b={open:"{{",close:"}}"},c={exp:function(a){return new RegExp(a,"g")},query:function(a,c,e){var f=["#([\\s\\S])+?","([^{#}])*?"][a||0];return d((c||"")+b.open+f+b.close+(e||""))},escape:function(a){return String(a||"").replace(/&(?!#?[a-zA-Z0-9]+;)/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/'/g,"&#39;").replace(/"/g,"&quot;")},error:function(a,b){var c="Laytpl Error：";return"object"==typeof console&&console.error(c+a+"\n"+(b||"")),c+a}},d=c.exp,e=function(a){this.tpl=a};e.pt=e.prototype,e.pt.parse=function(a,e){var f=this,g=a,h=d("^"+b.open+"#",""),i=d(b.close+"$","");a=a.replace(/[\r\t\n]/g," ").replace(d(b.open+"#"),b.open+"# ").replace(d(b.close+"}"),"} "+b.close).replace(/\\/g,"\\\\").replace(/(?="|')/g,"\\").replace(c.query(),function(a){return a=a.replace(h,"").replace(i,""),'";'+a.replace(/\\/g,"")+'; view+="'}).replace(c.query(1),function(a){var c='"+(';return a.replace(/\s/g,"")===b.open+b.close?"":(a=a.replace(d(b.open+"|"+b.close),""),/^=/.test(a)&&(a=a.replace(/^=/,""),c='"+_escape_('),c+a.replace(/\\/g,"")+')+"')}),a='"use strict";var view = "'+a+'";return view;';try{return f.cache=a=new Function("d, _escape_",a),a(e,c.escape)}catch(j){return delete f.cache,c.error(j,g)}},e.pt.render=function(a,b){var e,d=this;return a?(e=d.cache?d.cache(a,c.escape):d.parse(d.tpl,a),b?(b(e),void 0):e):c.error("no data")},f=function(a){return"string"!=typeof a?c.error("Template not found"):new e(a)},f.config=function(a){a=a||{};for(var c in a)b[c]=a[c]},f.v="1.1","function"==typeof define?define(function(){return f}):"undefined"!=typeof exports?module.exports=f:window.laytpl=f}();
laytpl.config({
  open: '<%',
  close: '%>'
});
/**
* 异步渲染 html
* String 模板id
* String 被渲染容器id
* Json 数据
* Boolean 是否异步渲染，默认是
*/
function render(tpl_id, con_id, full_data,not_async=false){
    var tpl= document.getElementById( tpl_id ).innerHTML;
    if( not_async ){ // 这种模式，不负责回调
        laytpl( tpl ).render( full_data, function(tpl_html){
            document.getElementById( con_id ).innerHTML = tpl_html;
        });
    }else{
        document.getElementById( con_id ).innerHTML = laytpl( tpl ).render( full_data );
    }
    
}

/**
* String 待渲染模板
* String 待渲染 div 的 id
* Json   待渲染数据
* function 渲染后的回调函数
*/
function async_render(tpl_id, container_id, full_data  , func = false){
  var tpl_html = $("#"+tpl_id).html(),
      tpl_container = $("#"+container_id).html();
  laytpl( tpl_html ).render( full_data, function(now_html){
        $("#"+container_id).html( now_html ) ;
        // 这里是回调函数
        if( func !=false ){
          func();
        }
  });
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++
// 异步加载js  Link : https://github.com/muicss/loadjs
//++++++++++++++++++++++++++++++++++++++++++++++++++++
/* 示例，注意函数库只能顺序加载，涉及节点渲染的，才用异步加载
    loadjs(['/path/to/foo.js', '/path/to/bar.js'], 'foobar');
    loadjs.ready('foobar', {
      success: function() { },          // foo.js & bar.js loaded
      error: function(depsNotFound) { } // foobar bundle load failed
    });
*/
loadjs=function(){function e(e,n){e=e.push?e:[e];var t,r,o,i,c=[],s=e.length,h=s;for(t=function(e,t){t.length&&c.push(e),h--,h||n(c)};s--;)r=e[s],o=u[r],o?t(r,o):(i=f[r]=f[r]||[],i.push(t))}function n(e,n){if(e){var t=f[e];if(u[e]=n,t)for(;t.length;)t[0](e,n),t.splice(0,1)}}function t(e,n,r,o){var c,u,f=document,s=r.async,h=(r.numRetries||0)+1,a=r.before||i;o=o||0,/\.css$/.test(e)?(c=!0,u=f.createElement("link"),u.rel="stylesheet",u.href=e):(u=f.createElement("script"),u.src=e,u.async=void 0===s||s),u.onload=u.onerror=u.onbeforeload=function(i){var f=i.type[0];if(c&&"hideFocus"in u)try{u.sheet.cssText.length||(f="e")}catch(e){f="e"}return"e"==f&&(o+=1,o<h)?t(e,n,r,o):void n(e,f,i.defaultPrevented)},a(e,u),f.head.appendChild(u)}function r(e,n,r){e=e.push?e:[e];var o,i,c=e.length,u=c,f=[];for(o=function(e,t,r){if("e"==t&&f.push(e),"b"==t){if(!r)return;f.push(e)}c--,c||n(f)},i=0;i<u;i++)t(e[i],o,r)}function o(e,t,o){var u,f;if(t&&t.trim&&(u=t),f=(u?o:t)||{},u){if(u in c)throw"LoadJS";c[u]=!0}r(e,function(e){e.length?(f.error||i)(e):(f.success||i)(),n(u,e)},f)}var i=function(){},c={},u={},f={};return o.ready=function(n,t){return e(n,function(e){e.length?(t.error||i)(e):(t.success||i)()}),o},o.done=function(e){n(e,[])},o.reset=function(){c={},u={},f={}},o}();

/**
* 时间戳的格式化
* String timestamp 时间戳 如 1489467563
* Return 格式化时间字符串 如 2017-03-01 00:00:00
*/
function yth_date(timestamp) {
    var newDate = new Date();
    newDate.setTime(timestamp * 1000);
    Date.prototype.format = function(format) {
        var date = {
            "M+": newDate.getMonth() + 1,
            "d+": newDate.getDate(),
            "h+": newDate.getHours(),
            "m+": newDate.getMinutes(),
            "s+": newDate.getSeconds(),
            "q+": Math.floor((newDate.getMonth() + 3) / 3),
            "S+": newDate.getMilliseconds()
        };
        if (/(y+)/i.test(format)) {
            format = format.replace(RegExp.$1, (newDate.getFullYear() + '').substr(4 - RegExp.$1.length));
        }
        for (var k in date) {
            if (new RegExp("(" + k + ")").test(format)) {
                format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? date[k] : ("00" + date[k]).substr(("" + date[k]).length));
            }
        }
        return format;
    }
    return newDate.format('yyyy-MM-dd hh:mm:ss');
}


/*
* 格式化日期，如 2016-11-25 15:15:53
* 使用  new Date().Format("yyyy年MM月dd日 hh:mm:ss");
*/
Date.prototype.Format = function (fmt) {
    var o = {
        "M+": this.getMonth() + 1,
        "d+": this.getDate(), 
        "h+": this.getHours(), 
        "m+": this.getMinutes(), 
        "s+": this.getSeconds(), 
        "q+": Math.floor((this.getMonth() + 3) / 3), 
        "S": this.getMilliseconds() 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}

/** jq.lazy.js 
****** 初始化originalSrc替代src 填入资源地址 ******
*******************配置参数如下********************
effect:
 载入使用何种效果  effect(特效),值有show(直接显示),fadeIn(淡入),slideDown(下拉)等,常用fadeIn 
threshold:
 提前开始加载 threshold,值为数字,代表页面高度.如设置为200,表示滚动条在离目标位置还有200的高度时
    就开始加载图片,可以做到不让用户察觉
failurelimit:
 图片排序混乱时 failurelimit,值为数字.lazyload默认在找到第一张不在可见区域里的图片时
 则不再继续加载,但当HTML容器混乱的时候可能出现可见区域内图片并没加载出来的情况,
 failurelimit意在加载N张可见区域外的图片,以避免出现这个问题.
*/

/*
;$(".lazy_pic").lazyload({
    effect: "fadeIn",  
    threshold: 200, 
    failurelimit : 10 
});
*/
;eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1;};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p;}(';(2($,e,S,g){9 w=$(e);$.1f.1h=2(f){9 n=d;9 c;9 1={b:0,N:0,i:"I",1a:"1g",7:e,K:"1p",16:W,l:Y,B:Y,V:"1o:17/1q;1k,1l+1m/1j"};2 y(){9 J=0;n.C(2(){9 t=$(d);3(1.16&&!t.D(":1n")){6}3($.T(d,1)||$.R(d,1)){}j 3(!$.q(d,1)&&!$.m(d,1)){t.G("l");J=0}j{3(++J>1.N){6 F}}})}3(f){3(g!==f.M){f.N=f.M;1c f.M}3(g!==f.L){f.X=f.L;1c f.L}$.1d(1,f)}c=(1.7===g||1.7===e)?w:$(1.7);3(0===1.i.12("I")){c.r(1.i,2(){6 y()})}d.C(2(){9 k=d;9 s=$(k);k.v=F;3(s.o("x")===g||s.o("x")===F){3(s.D("H")){s.o("x",1.V)}}s.1r("l",2(){3(!d.v){3(1.l){9 z=n.1b;1.l.10(k,z,1)}$("<H />").r("B",2(){9 E=s.o(1.K);s.1i();3(s.D("H")){s.o("x",E)}j{s.1s("1I-17","1G(\'"+E+"\')")}s[1.1a](1.X);k.v=W;9 13=$.1H(n,2(8){6!8.v});n=$(13);3(1.B){9 z=n.1b;1.B.10(k,z,1)}}).o("x",s.o(1.K))}});3(0!==1.i.12("I")){s.r(1.i,2(){3(!k.v){s.G("l")}})}});w.r("1F",2(){y()});3((/(?:1K|1M|1L).*1J 5/1E).1w(1v.1t)){w.r("1u",2(i){3(i.15&&i.15.1y){n.C(2(){$(d).G("l")})}})}$(S).1C(2(){y()});6 d};$.q=2(8,1){9 4;3(1.7===g||1.7===e){4=(e.18?e.18:w.O())+w.19()}j{4=$(1.7).h().u+$(1.7).O()}6 4<=$(8).h().u-1.b};$.m=2(8,1){9 4;3(1.7===g||1.7===e){4=w.Q()+w.1e()}j{4=$(1.7).h().p+$(1.7).Q()}6 4<=$(8).h().p-1.b};$.T=2(8,1){9 4;3(1.7===g||1.7===e){4=w.19()}j{4=$(1.7).h().u}6 4>=$(8).h().u+1.b+$(8).O()};$.R=2(8,1){9 4;3(1.7===g||1.7===e){4=w.1e()}j{4=$(1.7).h().p}6 4>=$(8).h().p+1.b+$(8).Q()};$.14=2(8,1){6!$.m(8,1)&&!$.R(8,1)&&!$.q(8,1)&&!$.T(8,1)};$.1d($.1D[":"],{"1B-P-4":2(a){6 $.q(a,{b:0})},"Z-P-u":2(a){6!$.q(a,{b:0})},"11-A-U":2(a){6 $.m(a,{b:0})},"p-A-U":2(a){6!$.m(a,{b:0})},"1z-1A":2(a){6 $.14(a,{b:0})},"Z-P-4":2(a){6!$.q(a,{b:0})},"11-A-4":2(a){6 $.m(a,{b:0})},"p-A-4":2(a){6!$.m(a,{b:0})}})})(1x,e,S);',62,111,'|settings|function|if|fold||return|container|element|var||threshold||this|window|options|undefined|offset|event|else|self|appear|rightoffold|elements|attr|left|belowthefold|bind|||top|loaded||src|update|elements_left|of|load|each|is|original|false|trigger|img|scroll|counter|data_attribute|effectspeed|failurelimit|failure_limit|height|the|width|leftofbegin|document|abovethetop|screen|placeholder|true|effect_speed|null|above|call|right|indexOf|temp|inviewport|originalEvent|skip_invisible|image|innerHeight|scrollTop|effect|length|delete|extend|scrollLeft|fn|show|lazyload|hide|AAffA0nNPuCLAAAAAElFTkSuQmCC|base64|iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8|PB|visible|data|originalSrc|png|one|css|appVersion|pageshow|navigator|test|jQuery|persisted|in|viewport|below|ready|expr|gi|resize|url|grep|background|os|iphone|ipad|ipod'.split('|'),0,{}));

/**
* Pjax 默认Get方法请求，基于jquery ajax
* Json   options   配置pjax  {"container_id":"容器id","callback":"带返回当前链接的jQuery对象"}
* String container_id 待渲染的容器的值
* 需要服务器返回 `html`与`title` 格式的 json字符串
- 示例：
    yth_pjax({callback:function(it){
        $(".choosen").removeClass("choosen");
        it.parent().addClass("choosen");
        }
    });
*/
function yth_pjax(options={}) {
    var opt = {
        container_id : options.container_id ? options.container_id :'#pjax-container',
        callback: options.callback ? options.callback :false, // 并且带有当前链接的jquery对象
        selector: options.selector ? options.selector :'a[data-pjax]'
    }
    $(opt.selector).on('click', function(event) {
        event.preventDefault();
        var it = $(this),
            url = it.attr("href");
        $.ajax({
            "url": url,
            "dataType": "html",
            "beforeSend": function(xhr) {
                xhr.setRequestHeader('X-Pjax', 'true');
            },
            "success": function(d) {
                eval('d = '+d+';');
                $(opt.container_id).html(d.html);
                document.title = d.title;
                history.pushState(null, null, url);
                if(opt.callback){
                    opt.callback(it);
                }
            }
        })
    });
}


/**
* String 需要替换的图片,
* Return 切换为的图片尺寸
*/
function get_pic(pic,size=100){
  var pre = pic.match(/(.*)(?=\/Up)/i),
      suf = pic.match(/\/Up(.*?)\_/i);
  return pre[0]+suf[0]+size+"x"+size+".jpg";
}

/**
* String 文字内容,
* Return 截取文字，默认前15个字
*/
function cut_name(name,len=8){
  if(name.length<len){
    return name;
  }else{
    return name.substr(0,len-1)+"...";
  }
}
/**
* 自动将对应id，保留两位小数，或者置空
* String 输入需要过滤的 jq_obj
*/

function yth_parse_float(jq_obj) {
    var this_value = jq_obj.val();
    if ( '' == this_value) { // 忽略空值
        return false;
    }
    var trans_this_num = parseFloat(this_value).toFixed(2);
    if ( 'NaN' == trans_this_num || 0==trans_this_num ) {
        trans_this_num = '';
    }
    jq_obj.val(trans_this_num);
}

/**
* String 输入需要过滤的 jq_obj,
* Return 整型数字
*/

function yth_parse_int(jq_obj) {
    var this_value = jq_obj.val();
    if ('' == this_value) { // 忽略空值
        return false;
    }
    var trans_this_num = parseInt(this_value);
    if ( 'NaN' == trans_this_num || 0==trans_this_num ) {
        trans_this_num = '';
    }
    jq_obj.val(trans_this_num);
}

/**
* 普通用户注销
*/
function user_logout(){
    $.ajax({
        "url":api("Common_user_enterence","logout"),
        "success":function(d){
            window.location.href='/User/index.html';
        }
    })
}