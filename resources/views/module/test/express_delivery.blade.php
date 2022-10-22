<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>物流信息查询</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="shortcut icon" href="//img.cdn.hlzblog.top/favicon.ico"  />
        <link rel="stylesheet" href="/static_pc/css/express_delivery.css">
    </head>

    <body>
        <!-- 物流，开始 -->
        <div id="Express_delivery">
            <div class="g-mohe " id="mohe-kuaidi_new">
                <div id="mohe-kuaidi_new_nucom">
                    <div class="mohe-wrap mh-wrap">
                        <div class="mh-cont mh-list-wrap mh-unfold">
                            <div class="mh-list">
                                <ul>
                                    <div id="this_tpl"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 物流，结束 -->
        <!--页面模板，物流 -->
        <script type="text/yth_tpl" id="yth_express_delivery">
            <%# for(var i=0;i <d.length;i++){ %> 
                <%# if(i==0){ %> 
                    <li class="first">
                <%# }else{ %>
                    <li>
                <%# } %>
                    <p><%d[i].time%></p>
                    <p><%d[i].context%></p>
                    <span class="before"></span>
                    <span class="after"></span> <%# if(i==0){ %>
                    <i class="mh-icon mh-icon-new"></i> <%# }else{ %>
                    <i></i> <%# } %>
                </li>
            <%# } %>
        </script>
    </body>
    <!-- Sentry -->
    <script src="{{ config('static_source_cdn.sentry') }}" crossorigin="anonymous"></script>
    <script src="{{ config('static_source_cdn.jquery') }}"></script>
    <script src="/static_pc/js/global.js"></script>
    <script>
    (function($, window, undefined){
        'use strict';
        function Express(){}
        // 获取get参数
        Express.prototype.get_tracking_number  = function (par) {
            //获取当前URL
            var local_url = document.location.href;
            //获取要取得的get参数位置
            var get = local_url.indexOf(par + "=");
            if(get == -1) {
                return false;
            }
            //截取字符串
            var get_par = local_url.slice(par.length + get + 1);
            //判断截取后的字符串是否还有其他get参数
            var nextPar = get_par.indexOf("&");
            if(nextPar != -1) {
                get_par = get_par.slice(0, nextPar);
            }
            return get_par;
        };
        // 异步显示信息
        Express.prototype.show_express_info = function (no) {
            var _this = this;
            $.ajax({
                "url": api("general", "express_delivery"),
                "type": "get",
                "data": {
                    "no": no,
                },
                "dataType": "json",
                "success": function (d) {
                    if(d.code != 200) {
                        $("#this_tpl").html("<h3>" + d.message + "</h3>");
                    } else {
                        async_render("yth_express_delivery", "this_tpl", d.data.track_info);
                    }
                }
            });
        };
        Express.prototype.run = function(){
            var _this = this;
            var no = _this.get_tracking_number("no");
            _this.show_express_info(no);
        };

        var express_delivery = new Express();
        express_delivery.run();
        
    })(jQuery, window);
    </script>

</html>