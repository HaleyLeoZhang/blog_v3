/**
 * 请求Api [修改、删除]
 * String url 接口地址
 * Json   post数据  | String JQ来serialize的数据
 * String 删除时，淡出的id，默认不启用
 * String 回调函数 [成功时才可调用]
 */
function request_api(url, json_data, fadeOut_Selector, func) {
    fadeOut_Selector = fadeOut_Selector || false;
    func = func || false;
    // 耗时较长的，用加载层动画
    var shadow_index = layer.load(4, {
        shade: [0, 'none'] // 遮盖 透明度、背景
    });
    $.ajax({
        "url": url,
        "type": "post",
        "data": json_data,
        "dataType": "json",
        "success": function (d) {
            layer.close(shadow_index);
            if(200 == d.code) {
                layer.msg('操作成功', {
                    time: 2000
                });
                if(fadeOut_Selector) {
                    $(fadeOut_Selector).fadeOut('normal', function () {
                        $(fadeOut_Selector).remove();
                    });
                }
                if(func) {
                    func();
                }
            } else {
                layer.msg(d.message);
            }
        }
    });
}
/**
 * 删除 yth-id 中的数据
 * String  接口地址
 * Obejcet 当前this对象
 * String  选择器前缀
 * Func   回调函数，成功后可使用
 */
function yth_del(url, obj, selector_prefix, func) {
    selector_prefix = selector_prefix | ".tr_";
    func = func | false;
    var id = $(obj).attr('yth-id');
    var confirm_index = layer.confirm('你真的要删除吗', {
        btn: ['是的', '不了'] // 按钮
    }, function () {
        layer.close(confirm_index);
        var shadow_index = layer.load(0, {
            shade: [0, 'none'] // 遮盖 透明度、背景
        });
        $.ajax({
            "url": url,
            "type": "post",
            "dataType": "json",
            "data": {
                "id": id
            },
            "success": function (msg) {
                layer.close(shadow_index);
                if(200 == msg.code) {
                    var its_selector = selector_prefix + id;
                    $(its_selector).fadeOut('normal', function () {
                        $(its_selector).remove();
                    });
                    if(false != func) {
                        func();
                    }
                } else {
                    layer.msg("删除失败");
                }
            }
        });
    });
}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++
//++ UMEditor Link : http://ueditor.baidu.com/website/
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
/** 富文本编辑器相关 
 * Boolean  false=>实例化编译器 true=>获取编译内容结果
 * Boolean  false=>设置默认id为Editor实例化 true=>设置对应id为Editor实例化
 * Array    设置菜单显示列表
 */
function editor(if_get_content, set_container_id, set_menu) {
    if_get_content = if_get_content || false;
    set_container_id = set_container_id || "um_editor";
    set_menu = set_menu || false;
    if(if_get_content) {
        return $("#" + set_container_id).html();
    } else {
        UM.getEditor(set_container_id);
    }
}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++
// Editor.md Link: https://github.com/pandao/editor.md/
//+++++++++++++++++++++++++++++++++++++++++++++++++++++
function markdown_editor() {
    var editor = editormd({
        width: "100%",
        height: 900,
        id: "markdown",
        path: "/static_pc/plugins/editor_md/lib/",
        toolbarIcons: function () {
            // Or return editormd.toolbarModes[name]; // full, simple, mini
            // Using "||" set icons align right.
            return [
                "search",
                "preformatted-text",
                "||",
                "help",
                "watch",
                "image",
                "preview",
            ];
        },
        editorTheme: "tomorrow-night-eighties",
        htmlDecode: "", // 上传时，不解析为html代码
        imageUpload: true,
        imageFormats: ["jpg", "jpeg", "gif", "png"],
        // imageUploadURL: "/Api?con=Editor&act=pic&editor_type=0",
        imageUploadURL: "/admin/upload/markdown", // 图片上传
    });

    // editor.getMarkdown();       // 获取 Markdown 源码
    // editor.getHTML();           // 获取 Textarea 保存的 HTML 源码
    // editor.getPreviewedHTML();  // 获取预览窗口里的 HTML，在开启 watch 且没有开启 saveHTMLToTextarea 时使用

    return editor;
}

/**
 * 滑动开关逻辑
 * String   当前id名
 */
function yth_check_box_click(this_obj) {
    var it = $(this_obj).find("input"),
        status = parseInt(it.val()),
        now_class = 'layui-form-onswitch';
    status = (status + 1) % 2;
    // 切换样式
    if(1 == status) {
        $(this_obj).addClass(now_class);
    } else {
        $(this_obj).removeClass(now_class);
    }
    // 切换数据
    it.val(status);
    // 切换名字
    var btn_name = $(this_obj).attr("yth-check_box"),
        btn = btn_name.split('|');
    $(this_obj).find("em").html(btn[status]);
}

/**
 * 滑动开关，初始化
 * Boolean  true => 开启  false => 状态为关闭  
 * String   input 字段名
 * String   按钮名字
 */
function yth_check_box_html(status, input_name, btn_name, func) {
    status = status || 0;
    input_name = input_namee || '';
    btn_name = btn_name || '关闭|开启';
    func = func || false;
    var btn = btn_name.split('|'),
        str = '',
        switch_div = [
            '',
            ' layui-form-onswitch '
        ];
    if(func) {
        func = func + '(this);';
    } else {
        func = '';
    }
    // 预留切换数据
    str = `
        <div class="layui-unselect layui-form-switch ${switch_div[status]}"
            lay-skin="switch" yth-check_box="${btn_name}" 
            onclick="yth_check_box_click(this);${func}"> 
            <input type="hidden" id="${input_name}" value="${status}">
            <em>${btn[status]}</em> <i></i>
        </div>`;
    return str;
}

/**
 * Radio选择逻辑，初始化
 * Object  this对象，放于input上
 * String  id_name 对应存数据的input的 ID名
 */
function yth_radio_logic(this_obj, id_name) {
    var it = $(this_obj),
        parent = it.parent();
    this_val = it.attr("yth-id");
    // Radio 动画设置
    parent.find(".layui-form-radioed").removeClass("layui-form-radioed");
    parent.find(".layui-anim-scaleSpring").removeClass("layui-anim-scaleSpring");
    parent.find(".layui-form-radio i").html(''); // 变动前
    it.find("i").html(''); // 变动后
    it.addClass("layui-form-radioed");
    it.find("i").addClass("layui-anim-scaleSpring");
    // 数据设置
    $("#" + id_name).val(this_val);
}

/**
 * 询问后，ajax请求
 * - 请求方式固定：POST
 */
function confirm_ajax(init) {
    var need_confirm = init.need_confirm === undefined ? true: init.need_confirm; // true->需要确认，false->不需要确认
    var title = init.title || '';
    var need_load = init.need_load === undefined ?  true : init.need_load;
    var api_url = init.api_url; // 必填，请求地址 string
    var api_data = init.data; // 必填，请求数据 array
    var res_text = init.res_text; // 必填， 成功时，弹出的文案

    var do_request = function(){
        layer.close(confirm_index);
        var shadow_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
        $.ajax({
            "url": api_url,
            "type": "post",
            "dataType": "json",
            "data": api_data,
            "success": function (res) {
                layer.close(shadow_index);
                if(200 == res.code) {
                    layer.msg(res_text);
                    location.reload();
                } else {
                    layer.msg(res.message);
                }
            },
            "error": function () {
                layer.close(shadow_index);
            }
        });
    };

    if( need_confirm ){
        var confirm_index = layer.confirm(title, {
            btn: ['是的', '不了'] // 按钮
        }, function () {
            do_request();
        });
    }else{
        do_request();
    }





}