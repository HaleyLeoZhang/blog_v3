(function (jq, window, undefined) {
    'use strict';

    function SuperGroup() {
        this.warp_class = ".content-wrapper";

        this.target_id = "lay_show"; // 点击上侧导航栏时变化
    }
    // @Action 初始化规则列表
    SuperGroup.prototype.get_list = function () {
        var load_index = layer.load(0);
        $.ajax({
            "url": '/admin/auth_group_list',
            "type": "post",
            "dataType": "json",
            "async": false,
            "cache": true,
            "success": function (res) {
                layer.close(load_index);
                var data = res.data;
                console.debug('data');
                console.debug(data);
                async_render('yth_t2', 'xx_show', data.list, function () {});
            },
            error: function () {
                layer.close(load_index);
            }
        });
    };
    // @Listener 监听上面模块切换
    SuperGroup.prototype.listen_button_void = function () {
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
    SuperGroup.prototype.listen_delete = function () {
        var _this = this
        $(this.warp_class).delegate(".act_del", "click", function () {
            event.stopPropagation();
            var id = $(this).attr('yth-data-id');
            layer.confirm('你真的要删除吗', {
                btn: ['确认', '取消'] //按钮
            }, function () {
                request_api('/admin/auth_group_del', {
                    'id': id
                }, 'tr_' + id);
            });
        });

    };
    // @Listener 添加
    SuperGroup.prototype.listen_sub = function () {
        var _this = this
        $(this.warp_class).delegate("#sub_new", "click", function () {
            // 防双击，多次插入，2秒后，继续添加
            var it = $(this);
            var _data = {
                "rules": _this.get_rule_list_by_id("xx_rule_list_add"),
                "title": $("#xx_title").val()
            };
            if('' == _data.title){
                layer.alert('请输入组名')
                return
            }
            if(!it.hasClass("yth-disabled")) {
                request_api('/admin/auth_group_add', _data, '', function(){
                    location.reload();
                });
                it.addClass("yth-disabled");
                setTimeout(function () {
                    it.removeClass("yth-disabled");
                }, 2000);
            }
        });
    };
    // @Listener 
    SuperGroup.prototype.listen_edit = function () {
        var _this = this
        $(this.warp_class).delegate("#sub_edit", "click", function () {
            var id = $("#xxxx_rule_list_edit_id").val(),
                rules = _this.get_rule_list_by_id("xxxx_rule_list_edit");
            if('' == rules){
                layer.alert('请选择规则')
                return
            }
            request_api('/admin/auth_group_modify', {
                "option": '3',
                "value": rules,
                "id": id
            }, false, function () {
                location.reload();
            });
        });
    };

    // @Listener 
    SuperGroup.prototype.listen_edit_name = function () {
        var _this = this
        $(this.warp_class).delegate(".act_edit_name", "click", function (event) {
            event.stopPropagation();
            var id = $(this).attr("yth-data-id");
            console.log('ID:' + id);
            //prompt层
            layer.prompt({ title: '请输入新组名', formType: 0 }, function (get_new_title, index) {
                $.ajax({
                    "url": '/admin/auth_group_modify',
                    "type": "post",
                    "dataType": "json",
                    "data": {
                        "option": '2',
                        "value": get_new_title,
                        "id": id
                    },
                    "async": false,
                    "success": function (msg) {
                        // 后的操作
                        if(200 == msg.code) {
                            layer.msg('成功');
                            $("#title_" + id).html(get_new_title);
                            layer.close(index);
                        } else {
                            layer.msg('失败');
                        }
                    }
                });

            });
        });
    };

    // @Listener 
    SuperGroup.prototype.listen_switch = function () {
        $(this.warp_class).delegate(".layui-form-switch", "click", function (event) {
            event.stopPropagation();
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
            request_api('/admin/auth_group_modify', {
                "option": '1',
                "value": now,
                "id": $(this).attr("yth-data-id")
            });
        });
    };
    // @Listener 
    SuperGroup.prototype.listen_checkbox = function () {
        // 添加的时候
        $(this.warp_class).delegate(".yth-checkbox", "click", function (event) {
            event.stopPropagation();
            var if_swich = $(this).hasClass("layui-form-checked") || 0,
                id = $(this).attr("yth-data-id");
            if(if_swich) {
                $(this).removeClass("layui-form-checked");
                $(this).find("span").attr({ "style": "" });
                $("#xx_rule_list_add").removeClass(id);
            } else {
                $(this).addClass("layui-form-checked");
                $(this).find("span").attr({ "style": "background-color:black" });
                $("#xx_rule_list_add").addClass(id);
            }
        });
        // 修改的时候
        $(this.warp_class).delegate(".yth-checkbox-rule_info", "click", function (event) {
            var if_swich = $(this).hasClass("layui-form-checked") || 0,
                id = $(this).attr("yth-data-id");
            if(if_swich) {
                $(this).removeClass("layui-form-checked");
                $(this).find("span").attr({ "style": "" });
                $("#xxxx_rule_list_edit").removeClass(id);
            } else {
                $(this).addClass("layui-form-checked");
                $(this).find("span").attr({ "style": "background-color:black" });
                $("#xxxx_rule_list_edit").addClass(id);
            }
        });
    };

    SuperGroup.prototype.get_rule_list = function () {
        $.ajax({
            "url": '/admin/auth_rule_show',
            "type": "post",
            "dataType": "json",
            "success": function (_data) {
                var msg = _data.data;
                // 添加界面
                var data_1 = {
                    "list": msg.list,
                    "class_name": "yth-checkbox"
                };
                async_render('yth_t3', 'yth_t3_show', data_1, function () {});
                // 界面
                var data_2 = {
                    "list": msg.list,
                    "class_name": "yth-checkbox-rule_info"
                };
                async_render('yth_t3', 'xxxxxxxxxxxxx_eidt', data_2, function () {});
            }
        });
    };

    SuperGroup.prototype.get_rule_list_by_id = function (this_id = "") {
        var rule_list_before = $("#" + this_id).attr("class"),
            list_string = rule_list_before.split(" ").join(","); // 数据格式转化为 形如 1,2,3,5,7
        // console.log('list_string :  ' + list_string);
        return list_string;
    };


    // @Listener 
    SuperGroup.prototype.listen_show_colla = function () {
        var _this = this
        // 添加
        $(this.warp_class).delegate(".layui-colla-item", "click", function () {
            $("#current_group_rule_ids").val(''); // 清空之前的数据
            var id = $(this).attr("yth-data-id"),
                title = $("#title_" + id).html();
            $("#yth_group_name").html(title);
            $("#xxxx_rule_list_edit_id").val(id);
            $.ajax({
                "url": '/admin/auth_one_group_rule',
                "data": { "id": id },
                "dataType": "json",
                "type": "post",
                "success": function (_data) {
                    var msg = _data.data;
                    _this.clear_data();
                    var _list = msg.list;
                    render("yth_t4", "this_edit_tpl_" + id, _list);
                    // 将规则ID，存储到临时存储区
                    $("#current_group_rule_ids").val(''); // 清空之前的数据
                    // - 计算数据
                    var _current_group_rule_ids = [];
                    for(var i in _list) {
                        _current_group_rule_ids.push(_list[i].id);
                    }
                    $("#current_group_rule_ids").val(_current_group_rule_ids.join(','));
                }
            });
        });
    };

    // 显示修改界面 => 已阻止冒泡 
    SuperGroup.prototype.listen_edit_rules_button = function () {
        // 添加
        $(this.warp_class).delegate(".act_edit_rules", "click", function (event) {
            event.stopPropagation();
            // 重新显示
            $("#xx_edit").fadeIn();
        });
    };

    // 清空之前的操作以及数据 => ok 
    SuperGroup.prototype.clear_data = function () {
        $("#xx_edit").hide();
        $(".yth-checkbox-rule_info > span").attr({ "style": "" });
        $(".yth-checkbox-rule_info").removeClass("layui-form-checked");
        $("#xxxx_rule_list_edit").val('');
    };

    SuperGroup.prototype.group_rule_auto_click = function () {
        $(this.warp_class).delegate(".group_rule_auto_click", "click", function (event) {
            event.stopPropagation();
            // 清空选过的
            $(".yth-checkbox.layui-form-checked").click();
            // 获取规则数据
            var current_group_rule_ids_arr = document.getElementById("current_group_rule_ids").value.split(",");
            var rule_doms = $(".yth-checkbox-rule_info");
            var _temp_id = '';
            for(var i = 0, len = rule_doms.length; i < len; i++) {
                _temp_id = rule_doms[i].getAttribute("yth-data-id");
                for(var j = 0, j_len = current_group_rule_ids_arr.length; j < j_len; j++) {
                    if(_temp_id == current_group_rule_ids_arr[j]) {
                        rule_doms[i].click();
                    }
                }
            }
            // // 重新显示
            $("#xx_edit").fadeIn();

        });
    };

    // @Initial
    SuperGroup.prototype.initial = function () {
        this.get_list();
        this.listen_button_void();
        this.listen_delete();
        this.listen_sub();
        this.listen_edit();
        this.listen_edit_name();
        this.listen_switch();
        this.listen_checkbox();
        this.get_rule_list();
        this.listen_show_colla();
        this.listen_edit_rules_button();
        this.group_rule_auto_click();
    };

    window.super_group = new SuperGroup();
    super_group.initial();

})(jQuery, window);