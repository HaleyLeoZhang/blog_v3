//++++++++++++++++++++++++++++++++++++++++++++++++++++
// 异步加载js   http://www.bootcdn.cn/loadjs/readme/
//++++++++++++++++++++++++++++++++++++++++++++++++++++
/* 示例，注意函数库只能顺序加载，涉及节点渲染的，才用异步加载
    loadjs(['/path/to/foo.js', '/path/to/bar.js'], 'foobar');
    loadjs.ready('foobar', {
      success: function() { },          // foo.js & bar.js loaded
      error: function(depsNotFound) { } // foobar bundle load failed
    });
*/

// - Sentry
if( undefined != Raven){
    Raven.config('http://51ead30b25094535a3ab950116a91262@sentry.ops.hlzblog.top/4').install();
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++
//++                Ajax调试 API
//++++++++++++++++++++++++++++++++++++++++++++++++++++
/*
* 输出调试结果
*/
function out( obj ){
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
function debug_data(debug_val,len = 15){
    var d = [];
    for(var i=0; i<len;i++){
        d.push(debug_val);
    }
    return d;
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++
//++                URL拼接相关
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
/**
* API地址
* String : Api_controller 控制器名
* String : Api_action     方法名
*/
function api(api_module, api_action){
    var route  = '/api';
    var site =   route + '/' + api_module + '/' + api_action;
    return site ;
}
/**
* 后台API地址
* String : Api_controller 控制器名
* String : Api_action     方法名
*/
function admin_api(api_module, api_action){
    var route  = '/admin';
    var site =   route + '/' + api_module + '/' + api_action;
    return site ;
}

/**
* 完整URL
* String : web_inner_site 站内绝对路径
*/
function url(web_inner_site){
    var site,
        server_name  = document.domain,
        protocol = location.protocol,
        port = location.port;
    site = protocol  + '//' + server_name ;
    if( port != '' ){
        console.log(site);
        site +=  ':' +  port;
    }

    site += web_inner_site;
    return site ;
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
//++    Laytpl模板引擎  Link : http://laytpl.layui.com/
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
!function(){"use strict";var f,b={open:"{{",close:"}}"},c={exp:function(a){return new RegExp(a,"g")},query:function(a,c,e){var f=["#([\\s\\S])+?","([^{#}])*?"][a||0];return d((c||"")+b.open+f+b.close+(e||""))},escape:function(a){return String(a||"").replace(/&(?!#?[a-zA-Z0-9]+;)/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/'/g,"&#39;").replace(/"/g,"&quot;")},error:function(a,b){var c="Laytpl Error：";return"object"==typeof console&&console.error(c+a+"\n"+(b||"")),c+a}},d=c.exp,e=function(a){this.tpl=a};e.pt=e.prototype,e.pt.parse=function(a,e){var f=this,g=a,h=d("^"+b.open+"#",""),i=d(b.close+"$","");a=a.replace(/[\r\t\n]/g," ").replace(d(b.open+"#"),b.open+"# ").replace(d(b.close+"}"),"} "+b.close).replace(/\\/g,"\\\\").replace(/(?="|')/g,"\\").replace(c.query(),function(a){return a=a.replace(h,"").replace(i,""),'";'+a.replace(/\\/g,"")+'; view+="'}).replace(c.query(1),function(a){var c='"+(';return a.replace(/\s/g,"")===b.open+b.close?"":(a=a.replace(d(b.open+"|"+b.close),""),/^=/.test(a)&&(a=a.replace(/^=/,""),c='"+_escape_('),c+a.replace(/\\/g,"")+')+"')}),a='"use strict";var view = "'+a+'";return view;';try{return f.cache=a=new Function("d, _escape_",a),a(e,c.escape)}catch(j){return delete f.cache,c.error(j,g)}},e.pt.render=function(a,b){var e,d=this;return a?(e=d.cache?d.cache(a,c.escape):d.parse(d.tpl,a),b?(b(e),void 0):e):c.error("no data")},f=function(a){return"string"!=typeof a?c.error("Template not found"):new e(a)},f.config=function(a){a=a||{};for(var c in a)b[c]=a[c]},f.v="1.1","function"==typeof define?define(function(){return f}):"undefined"!=typeof exports?module.exports=f:window.laytpl=f}();
// 模板配置
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


  /**
  * 获取格式化后的时间
  *    如： format_time("Y-m-d h:i:s") 输出 2017-12-11 22:46:11
  * @param string str 待格式化的时间
  * @param int timestamp 时间戳， 0为不处理
  * @return string 
  */
  function format_time(str, timestamp=0){
    function add_zero( num ){
        if( num<9 ){
            return  "0" + num;
        }else{
            return "" + num + "";
        }
    }
    timestamp = parseInt(timestamp) * 1000;
    var date = timestamp === 0 ?　new Date() : new Date(timestamp);
    var Y = date.getFullYear(),
        m = add_zero( date.getMonth() + 1 ),
        d = add_zero( date.getDate() ),
        h = add_zero( date.getHours() ),
        i = add_zero( date.getMinutes() ),
        s = add_zero( date.getSeconds() );
    str = str.replace("Y", Y);
    str = str.replace("m", m);
    str = str.replace("d", d);
    str = str.replace("h", h);
    str = str.replace("i", i);
    str = str.replace("s", s);
    return str;
  }



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
                xhr.setRequestHeader('X-PJAX', 'true');
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


/*  Ajax版 分页，初始配置示例  需要加载 layPage
var init = {
    "api" : api("Admin_article","blog_text_info"),  // API的url
    "send_other_data": {"article_id":22},   // 发送其他 Get 数据
    "render_tpl"  : "blog_text_tpl",        // 渲染前的html模板id
    "render_html" : "pagenation_html",      // 目标渲染位置
    "pageination_id": "yth_page",           // 分页条的id
    "callback":false,           // 回调函数，根据callback_data 来判断是否获取回调数据
    "callback_data" :false,     // 传入API的数据到回调函数参数中？
    "loading_switch":true,      // 显示加载特效？  需要 加载layer
}
yth_pageination(init);
*/
function yth_pageination(init) {
    // 分页 Step 1: 数据拉取
    var get_list = function (to_page = 1) {
            var ordinary_data = {
                    "to_page": to_page
                },
                data;
            if(init.send_other_data) {
                data = init.send_other_data;
                data.to_page = ordinary_data.to_page;
            } else {
                data = ordinary_data;
            }
            if(true == init.loading_switch) {
                var page_load_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
            }
            $.ajax({
                "url": init.api,
                "data": data,
                "dataType": "json",
                "success": function (d) {
                    if(true == init.loading_switch) {
                        layer.close(page_load_index); // 加载层 关闭
                    }

                    $("#" + init.render_html).html(''); // 置空html
                    if(d.data.info && d.data.info.length > 0) {
                        async_render(init.render_tpl, init.render_html, d.data.info, function () {
                            // 分页条
                            page_handle(to_page, d.data.page_count, d.data.total);
                        });
                    }
                    // 回调函数
                    if(init.callback) {
                        if(init.callback_data) {
                            init.callback(d);
                        } else {
                            init.callback();
                        }
                    }

                },
                "error":function(){
                    if(true == init.loading_switch) {
                        layer.close(page_load_index); // 加载层 关闭
                    }
                }
            });
        }
        // 分页 Step 2: 数据输出
        ,
        page_handle = function (to_page, page_count, total) {
            laypage({
                cont: init.pageination_id, // 分页条的ID
                pages: page_count, // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~【后端】传入总页数~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
                skin: 'yahei', // 加载内置皮肤，也可以直接赋值16进制颜色值，如:#c00
                // 下面几个就是 都是 false=>不显示，设为字符串=>设置为对应按钮的名称
                prev: false, // 上一页
                next: false, // 下一页
                skip: true, // 开启跳页
                first: false, // 数字1,
                last: false, // 总页数。
                curr: to_page,
                jump: function (e, first) {
                    page_info = document.createElement('span');
                    page_info.style = 'font-size:12px;';
                    page_info.innerHTML = '总计 <b>' + total + '</b> 条记录，共 <b>' + this.pages + '</b> 页';
                    // console.log(this);
                    if(this.pages > 1) {
                        //用于一个页面多个page的情况
                        $("#" + this.cont + " .laypage_total").append(page_info);
                    }
                    if(!first) { // 因为一开始就响应该函数，所以用该参数判断是否第一次刷新。
                        get_list(e.curr);
                    }
                },
                groups: 7 // 每次显示的码数数
            });
        };
    // 初始化
    get_list();
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

// 用户足迹
function footmark(){
    $.ajax({
        "url":api("behaviour","foot_mark"),
        "type":"post",
        "data":{
            "url" : url(window.location.pathname + window.location.search)
        }
    });
}

// 移动端判断
(function(){
    if(navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i)) {
        // 映射文章页，路由到移动端
        var res_artcile = location.pathname.match(/article.*?(\d+)/);
        var redirect = '/mobile/#/';
        if( res_artcile ){
            var article_id = res_artcile[1];
            redirect += 'article/' + article_id;
            location.href = redirect;
        }
        // 映射首页
        if( '' == location.pathname  ){
            location.href = redirect;
        }
    }
})();



// Return an icon of login method
function login_method_icon_src(this_type) {
    var pic_src, title, pic;
    switch(parseInt(this_type)) {
    case 0: // Blog owner
        pic_src = "/static_pc/img/default/icon_v_yellow.png";
        title = "博主";
        pic = '<img class="login_method_icon"  src="' + pic_src + '" title="' + title + '">';
        break;
    case 1: // Sina
        title = "Sina 用户";
        pic = '<i class="fa fa-weibo" title="' + title + '"></i>';
        break;
    case 2: // QQ
        title = "QQ 用户";
        pic = '<i class="fa fa-qq" title="' + title + '"></i>';
        break;
    case 3: // Github
        title = "Github 用户";
        pic = '<i class="fa fa-github" title="' + title + '"></i>';
        break;
    }
    return pic;
}