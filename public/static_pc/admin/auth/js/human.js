// 人事管理 -> 初始化
function yth_hr_init() {
    var page_load_index = layer.load(0, { shade: false }); // 加载层 开启
    var to_page = method_get_param('to_page'); // 分页信息
    $.ajax({
        "url": "/admin/admin_user_show",
        "type": "post",
        "data": {
            "to_page": to_page ? to_page : 1,
        },
        "dataType": "json",
        "async": false,
        "success": function (_data) {
            var data = _data.data;
            $("#this_page").html(data.render);
            render('yth_t1', 'this_tpl', data.info, true); // 同步渲染
            /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~监听按钮~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
            layer.close(page_load_index); // 加载层 关闭
            // 开关
            yth_switch();
            // 删除
            yth_activity_del();
            // 修改
            yth_activity_edit();
            // 重置
            reset_pwd();
            /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
        }
    });
}

// 人事管理 => 删除

function yth_activity_del() {
    $(".act_del").on("click", function () {
        var id = $(this).attr('yth-data-id');
        layer.confirm('你真的要删除吗', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            request_api('/admin/admin_user_del', {
                'admin_id': id
            }, 'tr_' + id);
        });
    });
}
// 人事管理 => 添加 + 提交按钮

function yth_activity_sub() {
    $("#sub_new").on("click", function () {
        // 检验数据是否有空的
        var validate_data = {
            'email': document.forms.sub_new_form.email.value,
            'truename': document.forms.sub_new_form.truename.value,
            'password': document.forms.sub_new_form.password.value,
            're_password': document.forms.sub_new_form.re_password.value,
        };
        for(var i in validate_data){
            if( validate_data[i] == '' ){
                layer.alert('您还有未填项');
                return;
            }
        }
        // 防双击，多次插入，2秒后，继续添加
        var it = $(this);
        if(!it.hasClass("yth-disabled")) {
            request_api('/admin/auth_user_register', $("#sub_new_form").serialize());
            it.addClass("yth-disabled");
            setTimeout(function () {
                it.removeClass("yth-disabled");
            }, 2000);
        }
    });
}
// 人事管理 => 修改

function yth_activity_edit(render_id = 'this_edit_tpl') {
    $(".act_edit").on("click", function () {
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
                render('yth_t2', render_id, msg.info, true); // 同步渲染
                // 复选框
                yth_check();
                // 确认修改
                yth_activity_edit_sub();
            }
        });
    });
}
// 人事管理 => 修改 => 提交按钮

function yth_activity_edit_sub() {
    $("#sub_edit").on("click", function () { // 监听修改按钮
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
}

// 开关
function yth_switch() {
    //监听指定开关
    $(".layui-form-switch").on("click", function () {
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
}

// 重置密码 - TODO 发送邮件以重置

function reset_pwd() {
    $(".reset_pwd").on("click", function () {
        var it = $(this),
            id = it.attr('yth-data-id');
        layer.confirm('真的要重置TA的密码?', {
            btn: ['是的', '不了'] //按钮
        }, function () {
            // request_api('help_account_edit', {
            //     "admin_id": id
            // });
        });
    });
}
// 复选框，将选中的组，存入一个class，提交时，提取class

function yth_check() {
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

// 搜索功能

function yth_search() {
    $("#search_sub").on("click", function () {
        $("#yth_search_tpl").html('');
        var data = $("#search_title").val();
        if( '' == data ){
            layer.alert('请输入管理员帐号');
            return ;
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
            "success": function (_data) {
                var msg = _data.data;
                layer.close(load_index);
                if(msg.info) {
                    render("yth_t1", "yth_search_tpl", msg.info);
                    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~监听按钮~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
                    // 开关
                    yth_switch();
                    // 删除
                    yth_activity_del();
                    // 修改
                    yth_activity_edit('yth_search_tpl');
                    // 重置
                    reset_pwd();
                    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
                } else {
                    layer.msg('未查询到帐号', {
                        "time": 2000
                    });
                }

            },error:function(){
                layer.close(load_index);
            }
        });
    });
}

function handle_button_void(){
    $(".handle_button_void").on("click", function(){
        var _this = $(this);
        var target_id = _this.data('target_id');
        $(".layui-this").removeClass("layui-this");
        $(".layui-show").removeClass("layui-show");
        _this.addClass("layui-this");
        $("#" + target_id).addClass("layui-show");
    });
}