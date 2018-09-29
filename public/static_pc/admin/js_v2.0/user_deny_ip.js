var g_layer_index = 0;
// 获取列表
var get_list = function () {
        yth_pageination({
            "api": api("Admin_behaviour", "user_deny_ip_info"),
            "render_tpl": "yth_logs_tpl",
            "render_html": "yth_logs",
            "pageination_id": "yth_page",
            "loading_switch": true,
        });
    }
    // 删除
    ,
    user_deny_ip_del = function (Object_this) {
        var it = $(Object_this),
            ip = it.attr("yth-id");
        yth_del(
            api('Admin_behaviour', 'user_deny_ip_del'),
            Object_this,
            ".tr_",
            function () {
                var its_selector = ".tr_" + hashCode(ip);
                $(its_selector).fadeOut('normal', function () {
                    $(its_selector).remove();
                });
            }
        );
    }
    // 修改时长
    ,
    user_deny_ip_edit = function (Object_this) {
        var it = $(Object_this),
            ip = it.attr("yth-ip");
        layer.prompt({
            title: '请重新入时长，单位秒',
            formType: 3
        }, function (text, index) {
            request_api(
                api("Admin_behaviour", "user_deny_ip_edit"), {
                    "ip": ip,
                    "expire": text
                },
                false,
                function () {
                    get_list();
                    layer.close(index);
                });
        });
    }


    // 添加
    ,
    add_layer = function () {
        // 页面模板，填写快递信息
        var tpl = '' +
            '<form class="layui-form layui-form-pane" id="form_add">' +
            '  <div class="layui-form-item">' +
            '    <label class="layui-form-label">IP</label>' +
            '    <div class="layui-input-block">' +
            '      <input type="text" name="ip" autocomplete="off" placeholder="如，222.123.212.33" class="layui-input"></div>' +
            '  </div>' +
            '  <div class="layui-form-item">' +
            '    <label class="layui-form-label">时长</label>' +
            '    <div class="layui-input-block">' +
            '      <input type="text" name="expire" autocomplete="off" placeholder="单位/秒，如，1000" class="layui-input"></div>' +
            '  </div>' +
            '</form>' +
            '<button onclick="user_deny_ip_add()" yt style="' +
            'font-family:微软雅黑;  font-weight: 700;  color: rgb(84,126,86); ' +
            'cursor: pointer; outline: none;  padding: 10px 10px; ' +
            'width: 100%; font-size: 17px;  border: none; ' +
            'background: rgb(220,250,200);margin-top:5px;" type="button">添加</button>';
        //自定页
        g_layer_index = layer.open({
            type: 1,
            title: false,
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            area: ['500px', '155px'],
            shadeClose: true, //开启遮罩关闭
            content: tpl
        });
    }

    ,
    user_deny_ip_add = function () {
        //
        request_api(api("Admin_behaviour", "user_deny_ip_add"), $("#form_add").serialize(), false, function () {
            get_list();
            layer.close(g_layer_index);
        });
    }


    ,
    hashCode = function (str) {
        var hash = 0;
        if(str.length == 0) return hash;
        for(i = 0; i < str.length; i++) {
            char = str.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash; // Convert to 32bit integer
        }
        return hash;
    }