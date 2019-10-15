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
    <!-- 请不要改此处的id -->
    <div id="yth_captchar"></div>
    
    <script type="text/javascript" src="{{ config('static_source_cdn.es5') }}"></script>
    <script type="text/javascript" src="{{ config('static_source_cdn.es6') }}"></script>
    <script type="text/javascript" src="//libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <script type="text/javascript" src="{{ config('static_source_cdn.load_js') }}"></script>
    <script type="text/javascript" src="{{ config('static_source_cdn.layer') }}"></script>
    <script type="text/javascript" src="/static_pc/js/hlz_rsa.js"></script>
    <script>
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
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++
    //++        URL拼接相关
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++
    loadjs(["/static_pc/plugins/verify/js/min_drag.js"], {
        success: function() {
            // 异步初始化验证码
            $.ajax({
                "url": api("Slide_Verify", "init"), // 获取初始的验证码 `css + 验证码图片` 的地址
                "success": function(html) {
                    $("#yth_captchar").html(html);
                    $(this).yth_drag({
                        "verify_url": api("Slide_Verify", "check"),
                        "source_url": api("Slide_Verify", "captchar"),
                        "auto_submit": true,
                        "submit_url": api("Slide_Verify", "demo_rsa"),
                        "form_id": "form_check",
                        "crypt_func": "rsa_encode"
                    });
                }
            });

            // 适应当前样式
            // $("#yth_captchar").css({
            //     "margin-left": "10px",
            //     "width": "280px",
            //     "margin-top": "20px"
            // });
        }

    });
    </script>

    <!-- 注：以下的，不是本次演示部分的代码 ，博主统计数据所用-->
    <script>
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
    loadjs(["{{ config('static_source_cdn.baidu_statistic') }}"], {
        success: function() {
            $.ajax({
                "url":api("Common_behaviour","user_behaviour_add"),
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