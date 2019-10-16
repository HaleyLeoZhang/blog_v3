(function (jq, window, undefined) {
    'use strict';

    function SuperRule() {
        this.warp_class = ".content-wrapper";

        this.target_id = "lay_show"; // 点击上侧导航栏时变化
    }
    // @Action 初始化规则列表
    SuperRule.prototype.get_list = function () {
        var load_index = layer.load(0);
        $.ajax({
            "url": '/admin/auth_rule_show',
            "type": "post",
            "dataType": "json",
            "async": false,
            "cache": true,
            "success": function (res) {
                layer.close(load_index);
                var data = res.data;
                async_render('yth_t1', 'this_tpl', data.list, function () {});
            },
            error: function () {
                layer.close(load_index);
            }
        });
    };
    // @Listener 监听上面模块切换
    SuperRule.prototype.listen_button_void = function () {
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
    // @Listener 删除
    SuperRule.prototype.listen_delete = function () {
        var _this = this
        $(this.warp_class).delegate(".act_del", "click", function () {
            var id = $(this).attr('yth-data-id');
            layer.confirm('你真的要删除吗', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                var load_index = layer.load(0);
                $.ajax({
                    "url": '/admin/auth_rule_del',
                    "data": {
                        'id': id
                    },
                    "type": "post",
                    "dataType": "json",
                    "success": function () {
                        layer.close(load_index);
                        layer.msg("删除成功", {
                            "time": 2000
                        });
                        $(".td_" + id).html('&nbsp;');
                    },
                    error: function () {
                        layer.close(load_index);
                    }
                });
            });
        });

    };
    // @Listener 添加
    SuperRule.prototype.listen_sub = function () {
        var _this = this
        $(this.warp_class).delegate("#sub_new", "click", function () {
            // 防双击，多次插入，2秒后，继续添加
            var it = $(this),
                rule = $("#yth_rule_add_rule").val(), // 这是真正的规则
                title = $("#yth_rule_add_title").val(); //这是规则名
            if(!it.hasClass("yth-disabled")) {
                it.addClass("yth-disabled");
                setTimeout(function () {
                    it.removeClass("yth-disabled");
                }, 2000);

                var load_index = layer.load(0);
                $.ajax({
                    "url": '/admin/auth_rule_add',
                    "data": $("#sub_new_form").serialize(),
                    "type": "post",
                    "dataType": "json",
                    "success": function (res) {
                        layer.close(load_index);
                        if(200 == res.code) {
                            _this.get_list()
                            layer.alert('添加成功');
                        } else {
                            layer.alert(res.message);
                        }

                    },
                    error: function () {
                        layer.close(load_index);
                    }
                });
            }
        });
    };

    SuperRule.prototype.listen_checkbox = function () {
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
    // @Listener 监听指定开关
    SuperRule.prototype.listen_rule_switch = function () {
        $(this.warp_class).delegate(".layui-form-switch", "click", function () {
            var if_swich = $(this).hasClass("layui-form-onswitch") || 0,
                now;
            if(if_swich) {
                $(this).removeClass("layui-form-onswitch");
                $(this).find("em").html('冻结');
                now = 0;
            } else {
                $(this).addClass("layui-form-onswitch");
                $(this).find("em").html('正常');
                now = 1;
            }
            request_api('/admin/auth_rule_status', {
                "status": now,
                "id": $(this).attr("yth-staff-id")
            });
        });
    };

    // @Initial
    SuperRule.prototype.initial = function () {
        this.get_list();
        this.listen_button_void();
        this.listen_delete();
        this.listen_sub();
        this.listen_checkbox();
        this.listen_rule_switch();
    };

    window.super_rule = new SuperRule();
    super_rule.initial();

})(jQuery, window);