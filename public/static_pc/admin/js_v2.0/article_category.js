// 读取列表
function get_list() {
    var page_load_index = layer.load(0, { shade: false }); // 加载层 开启
    $.ajax({
        "url": admin_api("article", "category_info"),
        "type": "get",
        "dataType": "json",
        "success": function (msg) {
            async_render("yth_t1", "yth_show_list", msg.data.info, function () {
                layer.close(page_load_index); // 加载层 关闭
                // 删除
                del_categroy();
                // 修改
                modify_categroy();
                // 添加
                add_categroy();
            });
        },
        "error": function () {
            layer.close(page_load_index); // 加载层 关闭
        }

    });
}

// 删除分类
function del_categroy() {
    $(".act_del").on("click", function () {
        var it = $(this),
            id = it.attr('yth-data-id'),
            fid = it.attr('yth-data-fid');
        layer.confirm('你真的要删除吗', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            var page_load_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
            $.ajax({
                "url": admin_api('article', 'category_del'),
                "data": {
                    "id": id
                },
                "type": "post",
                "dataType": "json",
                "success": function (msg) {
                    layer.close(page_load_index); // 加载层 关闭
                    if(200 == msg.code) {
                        layer.msg('删除成功', {
                            "time": 2000
                        });
                        $(".tr_fid_" + id).fadeOut();
                        $(".tr_" + id).fadeOut();
                    } else {
                        layer.alert(msg.message);
                    }
                },
                "error": function () {
                    layer.close(page_load_index); // 加载层 关闭
                }
            });
        });
    });
}

// 修改分类
function modify_categroy() {
    $(".act_edit").on("click", function () {
        var it = $(this),
            id = it.attr('yth-data-id');
        layer.prompt({
            title: '请重新入新的分类名',
            formType: 3
        }, function (text, index) {
            layer.close(index); // 关闭输入层
            var page_load_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
            $.ajax({
                "url": admin_api("article", "category_edit"),
                "type": "post",
                "dataType": "json",
                "data": {
                    "title": text,
                    "id": id
                },
                "success": function (msg) {
                    layer.close(page_load_index); // 加载层 关闭
                    if(200 == msg.code) {
                        layer.msg('修改成功', {
                            "time": 2000
                        });
                        window.location.reload();
                    } else {
                        layer.alert(msg.message);
                    }
                },
                "error": function () {
                    layer.close(page_load_index); // 加载层 关闭
                }
            });


        });
    });
}

// 添加分类
function add_categroy() {
    $(".act_add").on("click", function () {
        var it = $(this),
            fid = it.attr('yth-data-fid');
        layer.prompt({
            title: '请输入分类名',
            formType: 3
        }, function (text, index) {
            layer.close(index); // 关闭输入层
            var page_load_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
            $.ajax({
                "url": admin_api("article", "category_add"),
                "type": "post",
                "dataType": "json",
                "data": {
                    "title": text
                },
                "success": function (msg) {
                    layer.close(page_load_index); // 加载层 关闭
                    if(200 == msg.code) {
                        layer.msg('添加成功', {
                            "time": 2000
                        });
                        window.location.reload();
                    } else {
                        layer.alert(msg.message);
                    }
                },
                "error": function () {
                    layer.close(page_load_index); // 加载层 关闭
                }
            });


        });
    });
}