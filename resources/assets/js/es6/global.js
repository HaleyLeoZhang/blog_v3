// 请先cdn引入 jquery
import './global/laytpl'; // 模板引擎
// import './global/lazy_pic'; // 图片懒加载 => 已用CDN

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
function url(web_inner_site='', protocol='http', port='80'){
    var site,
        server_name  = document.domain;

    port =    '80'==port ?   ''   :   ':' + port  ;

    site = protocol  + '://'
           + server_name 
           + port
           + web_inner_site
    return site ;
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
function yth_pageination (init){
    // 分页 Step 1: 数据拉取
    var get_list =  function (to_page=1){
        var ordinary_data = {
                "to_page": to_page
            }, 
            data;
        if( init.send_other_data ){
            data = init.send_other_data;
            data.to_page = ordinary_data.to_page;
        }else{
            data = ordinary_data;
        }
        if( true==init.loading_switch ){
            var page_load_index = layer.load(0, {shade: false}); // 加载层 开启
        }
        $.ajax({
            "url": init.api,
            "data":data,
            "dataType":"json",
            "success":function(d){
              if( true == init.loading_switch ){
                    layer.close(page_load_index); // 加载层 关闭
                }

              $("#" + init.render_html).html(''); // 置空html
              if (d.info && d.info.length > 0) {
                async_render(init.render_tpl, init.render_html, d.info, function() {
                  // 分页条
                  page_handle(to_page, d.page_count, d.total);
                });
              }
              // 回调函数
              if (init.callback) {
                if (init.callback_data) {
                  init.callback(d);
                } else {
                  init.callback();
                }
              }

            }
        });
    }
    // 分页 Step 2: 数据输出
    , page_handle =  function (to_page,page_count, total) {
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
            curr:to_page,
            jump: function(e, first) {
                page_info = document.createElement('span');
                page_info.style = 'font-size:12px;';
                page_info.innerHTML = '总计 <b>' + total + '</b> 条记录，共 <b>' + this.pages + '</b> 页';
                // console.log(this);
                if (this.pages > 1) {
                    //用于一个页面多个page的情况
                    $("#"+ this.cont +" .laypage_total").append(page_info);
                }
                if (!first) { // 因为一开始就响应该函数，所以用该参数判断是否第一次刷新。
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
        "url":api("Common_behaviour","user_behaviour_add"),
        "type":"post",
        "data":{
            "url" : url(window.location.pathname + window.location.search)
        }
    });
}
