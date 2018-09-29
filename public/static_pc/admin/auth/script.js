/**
 * 请求Api 【分页不能用】
 * String url 接口地址
 * Json   post数据  | String JQ来serialize的数据
 * String 删除时，淡出的id，默认不启用
 * String 回调函数
 */
function request_api(url, json_data, fadeOut_id = false, func = false) {
    // 耗时较长的，用加载层动画
    var shadow_index = layer.load(0, {
        shade: [0.1, 'none'] // 遮盖 透明度、背景
    });
    $.ajax({
        "url": url,
        "type": "post",
        "data": json_data,
        "dataType": "json",
        "success": function (this_data) {
            layer.close(shadow_index);
            layui.use('layer', function () {
                var layer = layui.layer;
                if(this_data.code == 200) {
                    layer.msg('操作成功');
                    if(fadeOut_id) {
                        $("#" + fadeOut_id).fadeOut();
                    }
                    if(func) {
                        func();
                    }
                } else {
                    layer.alert(this_data.message);
                }
            });
        }
    });
}

// 
/**
 * 通用 监听.act_del tr_id 
 * 删除 yth-data-id 中的数据
 * 请求数据样式 {"id": 某个数据}
 * String url 接口地址
 * String 选择器前缀
 */
function yth_tr_del(url, selector_prefix = "#tr_", listen_selector = ".act_del") {
    $(listen_selector).unbind("click"); // 解绑之前的
    $(listen_selector).on("click",
        function () {
            var id = $(this).attr('yth-data-id');
            var confirm_index = layer.confirm('你真的要删除吗', {
                btn: ['是的', '不了'] // 按钮
            }, function () {
                layer.close(confirm_index);
                // 耗时较长的，用加载层动画
                var shadow_index = layer.load(0, {
                    shade: [0.1, 'none'] // 遮盖 透明度、背景
                });
                $.ajax({
                    "url": url,
                    "type": "post",
                    "dataType": "json",
                    "data": {
                        "id": id
                    },
                    "success": function (this_data) {
                        layer.close(shadow_index);
                        if(this_data.code == 200) {
                            $(selector_prefix + id).fadeOut();
                        } else {
                            layer.alert(this_data.message);
                        }
                    }
                });
            });
        });
}


/**
 * 主要解决  直接显示 与 搜索  的冲突 => [方案1]刷新方式
 * 只需要在选择栏目上 加上  id="remove_search_content"
 */
function remove_conflict() {
    $("#remove_search_content").on("click", function () {
        // 耗时较长的，用加载层动画
        layer.msg('正在刷新，请稍候');
        window.location.reload();
    });
}

/**
 * 获取 GET 参数
 * @param string 待获取的某个 GET 参数的值
 */
function method_get_param(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for(var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable) { return pair[1]; }
    }
    return(false);
}