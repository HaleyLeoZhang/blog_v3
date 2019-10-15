(function (jq, window, undefined) {
    'use strict';

    function Huamn() {
        this.warp_class = ".content-wrapper";

        this.target_id = "lay_show"; // 点击上侧导航栏时变化
    }
    // @Action 初始化人员列表
    Huamn.prototype.get_list = function () {
        var page_load_index = layer.load(0, { shade: false }); // 加载层 开启
        var to_page = method_get_param('to_page'); // 分页信息
        $.ajax({
            "url": "/admin/admin_user_show",
            "type": "post",
            "data": {
                "to_page": to_page ? to_page : 1,
            },
            "dataType": "json",
            "success": function (_data) {
                var data = _data.data;
                $("#this_page").html(data.render);
                async_render('yth_t1', 'this_tpl', data.info, function () {
                    layer.close(page_load_index); // 加载层 关闭
                });
            }
        });
    };
    // @Listener 监听指定开关
    Huamn.prototype.listen_switch = function () {
        $(this.warp_class).delegate(".layui-form-switch", "click", function () {
            var if_swich = $(this).hasClass("layui-form-onswitch") || 0,
                now;
            if(if_swich) {
                $(this).removeClass("layui-form-onswitch");
                $(this).find("em").html('冻结');
                now = -1;
            } else {
                $(this).addClass("layui-form-onswitch");
                $(this).find("em").html('正常');
                now = 0;
            }
            request_api('/admin/admin_user_status', {
                "status": now,
                "admin_id": $(this).attr("yth-staff-id")
            });
        });
    };

    // @Listener 监听上面模块切换
    Huamn.prototype.listen_button_void = function () {
        var _this = this
        $(this.warp_class).delegate(".handle_button_void", "click", function () {
            var it = $(this);
            _this.target_id = it.data('target_id');
            console.log('_this.target_id');
            console.log(_this.target_id);
            $(".layui-this").removeClass("layui-this");
            $(".layui-show").removeClass("layui-show");
            it.addClass("layui-this");
            $("#" + _this.target_id).addClass("layui-show");
        });
    };

    // @Listener 监听删除按钮
    Huamn.prototype.listen_delete = function () {
        $(this.warp_class).delegate(".act_del", "click", function () {
            var id = $(this).attr('yth-data-id');
            layer.confirm('你真的要删除吗', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                request_api('/admin/admin_user_del', {
                    'admin_id': id
                }, 'tr_' + id);
            });
        });
    };

    // @Listener 监听修改按钮
    Huamn.prototype.listen_edit = function () {
        var _this = this
        $(this.warp_class).delegate(".act_edit", "click", function () {
            var id = $(this).attr('yth-data-id');
            $(".yth-checking").attr({
                "style": ""
            });
            $(".yth-checking").removeClass("yth-checking");
            $("#tr_" + id).attr({
                "style": "background-color:#EED2EE"
            });
            $("#tr_" + id).addClass("yth-checking");


            $.ajax({
                "url": "/admin/group_list",
                "data": {
                    "admin_id": id
                },
                "type": "post",
                "dataType": "json",
                "success": function (_data) {
                    var msg = _data.data;
                    msg.info.staff_id = id;
                    var tpl_id = '';
                    if('lay_show' == _this.target_id) {
                        tpl_id = 'this_edit_tpl';
                    } else if('lay_search' == _this.target_id) {
                        tpl_id = 'yth_search_res_tpl';
                    }
                    $("#" + tpl_id).html('');
                    async_render('yth_t2', tpl_id, msg.info, function () {});

                    // // 复选框
                    // _this.listen_checkbox();
                    // 确认修改
                    // yth_activity_edit_sub();
                }
            });
        });
    };
    Huamn.prototype.listen_checkbox = function () {
        var _this = this
        $(this.warp_class).delegate(".yth-checkbox", "click", function () {
            console.log("s");
            var if_swich = $(this).hasClass("layui-form-checked") || 0,
                id = $(this).attr("yth-data-id");
            if(if_swich) {
                $(this).removeClass("layui-form-checked");
                $("#group_id").removeClass(id);
            } else {
                $(this).addClass("layui-form-checked");
                $("#group_id").addClass(id);
            }
        });
    };
    Huamn.prototype.listen_sub = function () {
        var _this = this

        $(this.warp_class).delegate("#sub_edit", "click", function () { // 监听修改按钮
            var it = $(this),
                id = it.attr("yth-data-id"),
                group_id_before = $("#group_id").attr("class"),
                group_id = group_id_before.split(" ").join(","); // 数据格式转化
            $.ajax({
                "url": '/admin/group_edit',
                "data": {
                    "admin_id": id,
                    "group_id": group_id
                },
                "type": "post",
                "dataType": "json",
                "success": function (msg) {
                    if(200 == msg.code) {
                        layer.msg("修改成功", {
                            time: 2000
                        });
                    } else {
                        layer.msg(msg.message, {
                            time: 2000
                        });
                    }
                    $("#this_edit_tpl").html('');
                    $(".yth-checking").attr({
                        "style": ""
                    });
                    $(".yth-checking").removeClass("yth-checking");
                }
            });
        });
    };
    // @Listen 搜索按钮
    Huamn.prototype.listen_search = function () {
        var _this = this
        $(this.warp_class).delegate("#search_sub", "click", function () {
            $("#yth_search_tpl").html('');
            var data = $("#search_title").val();
            if('' == data) {
                layer.alert('请输入管理员帐号');
                return;
            }
            var load_index = layer.load(0);
            $.ajax({
                "url": '/admin/auth_find_admin',
                "data": {
                    "email": data
                },
                "type": "post",
                "dataType": "json",
                "async": true,
                "success": function (res) {
                    layer.close(load_index);
                    if(200 != res.code) {
                        layer.msg(res.message);
                        return;
                    }
                    var _data = res.data;
                    if(_data.list.length) {
                        render("yth_t1", "yth_search_tpl", _data.list);
                    } else {
                        layer.msg('未查询到帐号', {
                            "time": 2000
                        });
                    }

                },
                error: function () {
                    layer.close(load_index);
                }
            });
        });
    };
    // @Listen 添加人员按钮
    Huamn.prototype.listen_add_admin = function () {
        var _this = this
        $(this.warp_class).delegate("#sub_new", "click", function () {
            //             // 检验数据是否有空的
            var validate_data = {
                'email': document.forms.sub_new_form.email.value,
                'truename': document.forms.sub_new_form.truename.value,
                'password': document.forms.sub_new_form.password.value,
                're_password': document.forms.sub_new_form.re_password.value,
            };
            for(var i in validate_data) {
                if(validate_data[i] == '') {
                    layer.alert('您还有未填项');
                    return;
                }
            }
            // 防双击，多次插入，2秒后，继续添加
            var it = $(this);
            if(!it.hasClass("yth-disabled")) {
                it.addClass("yth-disabled");
                request_api('/admin/auth_user_register', $("#sub_new_form").serialize(),'', function(){
                    _this.get_list();
                });
                setTimeout(function () {
                    it.removeClass("yth-disabled");
                }, 2000);
            }
        });
    };

    // @Initial
    Huamn.prototype.initial = function () {
        this.get_list();
        this.listen_switch();
        this.listen_button_void();
        this.listen_delete();
        this.listen_edit();
        this.listen_checkbox();
        this.listen_sub();
        this.listen_search();
        this.listen_add_admin();
    };

    window.huamn = new Huamn();
    huamn.initial();

})(jQuery, window);