<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>RSA版 | 滑动验证码</title>
    <style>
    a{
        cursor: pointer;
        color: #666;
        text-decoration: none;
        transition: color 0.2s linear;
    }
    a:hover{
         color: #00c3f5;
        -webkit-transition: color 0.2s linear;
        -moz-transition: color 0.2s linear;
        -ms-transition: color 0.2s linear;
        -o-transition: color 0.2s linear;
        transition: color 0.2s linear;
    }
    .input-text{
        display: block;
        margin: 10px 0 10px 20px;
        padding: 10px;
    }
    </style>
</head>
<body>
    <h1><a href="https://github.com/HaleyLeoZhang/slide-verify"  target="_blank">滑动验证码 - RSA版</a></h1>
    <form id="form_check" >
        <input type="text"     class="input-text" name='name' size="30" placeholder="用户名，测试帐号：admin"  />
        <input type="password" class="input-text" name='pwd'  size="30" placeholder="密码，测试密码：123123"   />
        
    </form>
    <!-- 请不要改此处的id，它是 yth_drag.js 中所需 -->
    <div id="yth_captchar"></div>
    
    <!-- 第三方支持库  -->
    <script type="text/javascript" src="{{ config('static_source_cdn.es5') }}"></script>
    <script type="text/javascript" src="{{ config('static_source_cdn.es6') }}"></script>
    <script type="text/javascript" src="//libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <script type="text/javascript" src="{{ config('static_source_cdn.load_js') }}"></script>
    <script type="text/javascript" src="{{ config('static_source_cdn.layer') }}"></script>
    <!-- 你可以去看看我js层 rsa 怎么加密，后端怎么解密的 https://github.com/HaleyLeoZhang/rsa-js-php  -->
    <script type="text/javascript" src="/static_pc/js/hlz_rsa.js"></script>
    <script>

    /**
     * 获取随机字符串
     * @return string
     */
    function mess() {
        var words = "zxcvbnmasdfghjklqwertyuiop1234567890";
        var _shuff = '';
        var arr = words.split('');
        var _floor = Math.floor,
            _random = Math.random,
            len = arr.length,
            i, j, arri,
            n = _floor(len / 2) + 1;
        while(n--) {
            i = _floor(_random() * len);
            j = _floor(_random() * len);
            if(i !== j) {
                arri = arr[i];
                arr[i] = arr[j];
                arr[j] = arri;
            }
        }
        _shuff = arr.join('');
        return _shuff;
    }

    // - 滑动唯一凭证
    // --- 服务器依据这个凭证，生成对应的验证图片
    if(!localStorage.yth_drag_passsport) {
        localStorage.setItem('yth_drag_passsport', mess() ); // 用户滑动验证码 唯一凭证。请不要修改 yth_drag_passsport 这个名称，此次滑动验证码内部模块需要
    }

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


    // 加载验证码
    loadjs(["/static_pc/plugins/verify/js/yth_drag.js"], {
        success: function() {
            $.ajax({
                "url": api("slide_verify", "init"), // 获取初始的验证码 `css + 验证码图片` 的地址
                "dataType": "html",
                "type": "get",
                "beforeSend": function (xhr) {
                    xhr.setRequestHeader("Passport", localStorage.yth_drag_passsport); // 把凭证放到请求头里
                },
                "success": function(html) {
                    $("#yth_captchar").html(html);
                    $(this).yth_drag({ // 各个字段意思，可以打开 /static_pc/plugins/verify/js/yth_drag.js 去看看
                        "verify_url": api("slide_verify", "check"),
                        "source_url": api("slide_verify", "captchar"),
                        "auto_submit": true,
                        "submit_url": api("slide_verify", "demo_rsa"),
                        "form_id": "form_check",
                        "crypt_func": "rsa_encode",
                        "call_back":function(res, reload_verify_function){
                            if(200 == res.code){
                                location.href = res.data.url;
                            }else{
                                layer.msg(res.message);
                                reload_verify_function(); // 重置当前验证码的函数
                            }
                        },
                    });
                },
            });
            // 适应当前样式
            $("#yth_captchar").css({
                "margin-left": "10px",
                "width": "280px",
                "margin-top": "20px"
            });
        }
    });


    // -------------------------------- 下面代码为信息统计与此次 Demo 无关， 请忽略 -------------------------------

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
    loadjs(["{{ config('static_source_cdn.baidu_statistic') }}"], {
        success: function() {

            // 用户足迹
            $.ajax({
                "url":api("behaviour","foot_mark"),
                "type":"post",
                "data":{
                    "url" : url(window.location.pathname + window.location.search)
                }
            });
        }
    });
    </script>
</body>
</html>