// 显示所有规则

function show_rules() {
    var load_index = layer.load(0);
    $.ajax({
        "url": '/admin/auth_rule_show',
        "type": "post",
        "dataType": "json",
        "async": false,
        "cache": true,
        "success": function (_data) {
            var data = _data.data;
            layer.close(load_index);
            render('yth_t1', 'this_tpl', data.info, true); // 同步渲染
            /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~监听按钮~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
            // 开关
            yth_switch();
            // 删除
            yth_activity_del();
            /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
        },
        error: function () {
            layer.close(load_index);
        }
    });
}

// 超级管理 => 删除

function yth_activity_del() {
    $(".act_del-form-switch").unbind("click");
    $(".act_del").on("click", function () {
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
}
// 超级管理 => 添加 + 提交按钮

function yth_activity_sub() {
    $("#sub_new").on("click", function () {
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
                "success": function (_data) {
                    layer.close(load_index);
                    var msg = _data.data;
                    if(200 == _data.code) {
                        $("#yth_show_block").show();
                        layer.msg('添加成功', {
                            "time": 2000
                        });
                        // 添加成功时，显示删除按钮
                        $("#yth_rule_add_result").append('' +
                            '<div style="float:left;margin:10px 20px 10px 0px;" class=" td_' + msg.id + '"><!--删除-->' +
                            '<button class="layui-btn layui-btn-normal act_del" yth-data-id="' + msg.id + '" title="' + rule + '">' + title + '</button>' +
                            ' </div>' +
                            '');
                        // 重新监听删除
                        yth_activity_del();
                    } else {
                        layer.alert(_data.message);
                    }


                },
                error: function () {
                    layer.close(load_index);
                }
            });
        }
    });
}

// 开关

function yth_switch() {
    //监听指定开关
    $(".layui-form-switch").unbind("click");
    $(".layui-form-switch").on("click", function () {
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
}

// 复选框，将选中的组，存入一个class，提交时，提取class

function yth_check() {
    $(".yth-checkbox").unbind("click");
    $(".yth-checkbox").on("click", function () {
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
}



function handle_button_void() {
    $(".handle_button_void").on("click", function () {
        var _this = $(this);
        var target_id = _this.data('target_id');
        $(".layui-this").removeClass("layui-this");
        $(".layui-show").removeClass("layui-show");
        _this.addClass("layui-this");
        $("#" + target_id).addClass("layui-show");
    });
}