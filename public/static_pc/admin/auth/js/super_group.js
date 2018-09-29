//因为手风琴，所以：修改组名、修改规则、删除、状态。都得阻止冒泡


// 删除按钮 => ok =>已阻止冒泡

function yth_activity_del() {
    $(".act_del").unbind("click");
    $(".act_del").on("click", function (event) {
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
}
// 添加按钮 => ok

function yth_activity_sub() {
    $("#sub_new").on("click", function () {
        // 防双击，多次插入，2秒后，继续添加
        var it = $(this);
        if(!it.hasClass("yth-disabled")) {
            request_api('/admin/auth_group_add', {
                "rules": get_rule_list_by_id("xx_rule_list_add"),
                "title": $("#xx_title").val()
            });
            it.addClass("yth-disabled");
            setTimeout(function () {
                it.removeClass("yth-disabled");
            }, 2000);
        }
    });
}
//修改 => 提交按钮 =>ok

function yth_activity_edit_sub() {
    $("#sub_edit").on("click", function () { // 监听修改按钮
        var id = $("#xxxx_rule_list_edit_id").val(),
            rules = get_rule_list_by_id("xxxx_rule_list_edit");
        request_api('/admin/auth_group_modify', {
            "option": '3',
            "value": rules,
            "id": id
        },false,function(){
            location.reload();
        });
    });
}

// 修改组名 => ok =>已阻止冒泡
function yth_edit_group() {
    $(".act_edit_name").unbind("click");
    $(".act_edit_name").on("click", function (event) {
        event.stopPropagation();
        var id = $(this).attr("yth-data-id");
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
                    // 修改后的操作
                    if(200 == msg.code) {
                        layer.msg('修改成功');
                        $("#title_" + id).html(get_new_title);
                        layer.close(index);
                    } else {
                        layer.msg('修改失败');
                    }
                }
            });

        });
    });
}
// 状态开关 => ok =>已阻止冒泡

function yth_switch() {
    //监听指定开关
    $(".layui-form-switch").unbind("click");
    $(".layui-form-switch").on("click", function (event) {
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
}

// 复选框，将选中的组，存入一个class，提交时，提取class，yth_rule_list已监听 => ok 

function yth_check() {
    // 添加的时候
    $(".yth-checkbox").unbind("click");
    $(".yth-checkbox").on("click", function (event) {
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
    $(".yth-checkbox-rule_info").unbind("click");
    $(".yth-checkbox-rule_info").on("click", function () {
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
}

// 显示规则列表 可设置类名 => ok 
function yth_rule_list() {
    $.ajax({
        "url": '/admin/auth_rule_show',
        "type": "post",
        "dataType": "json",
        "success": function (_data) {
            var msg = _data.data;
            // 添加界面
            var data_1 = {
                "list": msg.info,
                "class_name": "yth-checkbox"
            };
            render('yth_t3', 'yth_t3_show', data_1, true); // 同步渲染
            // 修改界面
            var data_2 = {
                "list": msg.info,
                "class_name": "yth-checkbox-rule_info"
            };
            render('yth_t3', 'xxxxxxxxxxxxx_eidt', data_2, true);
            yth_check();
        }
    });
}

// 通过id获取规则 => ok 
function get_rule_list_by_id(this_id = "") {
    var rule_list_before = $("#" + this_id).attr("class"),
        list_string = rule_list_before.split(" ").join(","); // 数据格式转化为 形如 1,2,3,5,7
        // console.log('list_string :  ' + list_string);
    return list_string;
}

// 查看某组，手风琴效果 => ok 
function yth_listen_show() {
    $(".layui-colla-item").unbind("click");
    $(".layui-colla-item").on("click", function () {
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
                yth_clear_data();
                render("yth_t4", "this_edit_tpl_" + id, msg.info);
                // 将规则ID，存储到临时存储区
                $("#current_group_rule_ids").val(''); // 清空之前的数据
                // - 计算数据
                var _current_group_rule_ids = [];
                var _info = msg.info;
                for(var i in _info){
                    _current_group_rule_ids.push( _info[i].id );
                }
                $("#current_group_rule_ids").val(_current_group_rule_ids.join(','));
            }
        });
    });
}

// 显示修改界面 => 已阻止冒泡 => ok 
function yth_edit_rules_button() {
    $(".act_edit_rules").unbind("click");
    $(".act_edit_rules").on("click", function (event) { // 监听修改按钮
        event.stopPropagation();
        // 重新显示
        $("#xx_edit").fadeIn();
    });
}
// 清空之前的操作以及数据 => ok 
function yth_clear_data() {
    $("#xx_edit").hide();
    $(".yth-checkbox-rule_info > span").attr({ "style": "" });
    $(".yth-checkbox-rule_info").removeClass("layui-form-checked");
    $("#xxxx_rule_list_edit").val('');
}

// 增量规则
function yth_group_rule_auto_click(){
    $(".group_rule_auto_click").unbind("click");
    $(".group_rule_auto_click").on("click", function (event) { // 监听修改按钮
        event.stopPropagation();
        // 清空选过的
        $(".yth-checkbox.layui-form-checked").click();
        // 获取规则数据
        var current_group_rule_ids_arr = document.getElementById("current_group_rule_ids").value.split(",");
        var rule_doms = $(".yth-checkbox-rule_info");
        var _temp_id = '';
        for(var i = 0,len = rule_doms.length; i < len ; i++){
            _temp_id = rule_doms[i].getAttribute("yth-data-id");
            for(var j=0, j_len = current_group_rule_ids_arr.length; j<j_len ;j++){
                if( _temp_id == current_group_rule_ids_arr[j] ){
                    rule_doms[i].click();
                }
            }    
        }
        // // 重新显示
        $("#xx_edit").fadeIn();

    });
}