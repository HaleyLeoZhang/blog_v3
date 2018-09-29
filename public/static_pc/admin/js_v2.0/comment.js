// 获取主楼列表
function get_main_list() {
    yth_pageination({
        "api": api("Admin_article", "comment_list_main"),
        "render_tpl": "comment_list_tpl",
        "render_html": "comment_list_html",
        "pageination_id": "comment_list_pagenation",
        "loading_switch": true,
    });
}

// 获取楼中楼列表
function get_inner_list() {
    yth_pageination({
        "api": api("Admin_article", "comment_list_inner"),
        "render_tpl": "comment_inner_list_tpl",
        "render_html": "comment_inner_list_html",
        "pageination_id": "comment_inner_list_pagenation",
        "loading_switch": true,
    });
}

// 回复为楼中楼
function reply_common(this_obj) {
    var it = $(this_obj),
        id = it.attr('yth-id');
    //prompt层
    var layer_index = layer.prompt({
        title: '请输入回复内容',
        formType: 2
    }, function (get_new_attr, index) {
        request_api(api('Common_reply', 'reply_add'), {
            "floor_id": id,
            "content": get_new_attr
        }, false, function () {
            layer.close(layer_index);
        });
    });
}