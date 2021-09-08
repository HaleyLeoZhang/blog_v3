// It is a Pjax Page
// JS function should be bind in html form for better control of JS event
var first_flag = true;

function show_render_container(get_module) {
    // To make sure it is not the first time to open this page
    if(first_flag) {
        first_flag = false;
        yth_pjax({
            selector: ".yth-pjax"
        });
    }
}

// ----------------------------------------------------------------------
//                             Module - Field
// ----------------------------------------------------------------------
// Link  : http://www.hlzblog.top/
// GITHUB: https://github.com/HaleyLeoZhang
// ----------------------------------------------------------------------

// 首页
(function ($, window, undefined) {
    'use strict';

    function BlogText() {}
    window.blog_text = new BlogText();

    BlogText.prototype.banner_compute = function () {
        /* Compute banner Location */
        var _w = parseInt($("body").width()),
            _mid;
        _mid = Math.abs((_w - 1920) / 2);
        if(_w < 1920) {
            _mid = '-' + _mid;
        }
        $("#hide_box img").attr({ "style": "left:" + _mid + "px" });
        // Show Banner
        $(".banner").fadeIn();
        // console.log("_mid " + _mid);
    };

    // 显示 banner，
    // - 要求窗口大小变化时重新计算
    BlogText.prototype.show_banner = function () {
        var _this = this;
        _this.banner_compute();
        console.log(1);
        $(window).resize(_this.banner_compute);
    };
})(jQuery, window);

// 文章
(function ($, window, undefined) {
    'use strict';

    var SWITCH_OFF = false;
    var SWITCH_ON = true;

    function Article() {
        this.container_id = "markdown_container";
        this.article_id = $("#markdown_container").attr("yth-article_id");
        this.loading_index = 0;
    }
    window.article = new Article();

    // - 初始化评论
    Article.prototype.get_comments_main = function () {
        var _this = this;
        // 子楼评论
        function callback_func(d) {
            var data = d.data.info;
            for(var i = 0, len = data.length; i < len; i++) {
                yth_pageination({
                    "api": api("comment", "info"), // API的url
                    "send_other_data": { "location": _this.article_id, "parent_id": data[i].id }, // 发送其他 Get 数据
                    "render_tpl": "article_comment_reply_tpl", // 渲染前的html模板id
                    "render_html": "floor_id_" + data[i].id, // 目标渲染位置
                    "pageination_id": "reply_his_pagination_" + data[i].id, // 分页条的id
                    "loading_switch": false, // 是否显示加载特效
                });
            }
        }
        // 主楼评论 
        yth_pageination({
            "api": api("comment", "info"), // API的url
            "send_other_data": { "location": _this.article_id, "parent_id": 0 }, // 发送其他 Get 数据
            "render_tpl": "article_comment_tpl", // 渲染前的html模板id
            "render_html": "article_comment", // 目标渲染位置
            "pageination_id": "article_comment_pagenation", // 分页条的id
            "callback": callback_func, // 回调函数，根据callback_data 来判断是否获取回调数据
            "callback_data": true, // 是否传入API的数据到回调函数参数中
            "loading_switch": false, // 是否显示加载特效
        });
    };
    // 初始化文章信息
    // - 背景图
    Article.prototype.change_bg = function (pic_url) {
        if("" != pic_url) {
            $(".show_container").css({
                "background": "none"
            });
            $("body").css({
                "background-image": "url(" + pic_url + ")",
                "background-attachment": "fixed",
                "background-size": "100% 100%",
                "background-repeat": "no-repeat"
            });
        }
    };
    // - 创作源标注
    Article.prototype.if_original = function () {
        // IF `original` eq 1  => it is an original pieces 
        var if_original = parseInt($("#yth_original").attr("yth_original"));
        if(!if_original) {
            var tmp_html = $("#yth_original").html(),
                from_others_logo = '[转载] ';
            $("#yth_original").html(from_others_logo + tmp_html);
        }
    };
    // - 创建右侧文章概览
    Article.prototype.create_catalog = function () {
        var _this = this;
        var h2_count = 0,
            h3_count = 0,
            h4_count = 0,
            i = 0,
            j = 0,
            content = document.getElementById(_this.container_id).innerHTML
            // Get All title
            ,
            titles = content.match(/\<h[\d](?:.*?)\>(.*?)\<\/h[\d]\>/ig) || [],
            titles_len = titles.length,
            temp_data, new_arr = [],
            now_index;
        // Set its index
        for(; i < titles_len; i++) {
            temp_data = titles[i].match(/\<h(\d)(?:.*?)\>(.*?)\<\/h[\d]\>/i);
            // Set index
            if(temp_data[1] < 2 || temp_data[1] > 4) {
                continue;
            }
            eval("now_index = " + "h" + temp_data[1] + "_count;");
            // Push handled data in a new array
            new_arr.push(
                '<h' + temp_data[1] + ' yth_index=' + now_index + ' onclick="article.go_to_this_title(this)">' +
                temp_data[2] +
                '</h' + temp_data[1] + '>');
            // Tag ++ 
            eval("h" + temp_data[1] + "_count++;");
        }
        // Push Array into html
        if(new_arr.length) {
            var render_html = new_arr.join('');
            $("#catalog").html(render_html);
            // Show
            $(".catalog").fadeIn();
        }
    };
    Article.prototype.go_to_this_title = function (this_obj) {
        var _this = this;
        var this_tag = this_obj.tagName.toLowerCase(),
            this_index = this_obj.getAttribute("yth_index"),
            selector = "#" + _this.container_id + " " + this_tag
            // Get position in this html
            ,
            offset = $(selector).eq(this_index).offset().top;
        // Go there
        $("html,body").scrollTop(offset);
    };
    // - 点击文章图片，跳转原图地址 - 触发设置
    Article.prototype.create_open_img_page_event = function () {
        $("#markdown_container img").attr({
            "onclick": "article.open_img_page_action(this)",
            "title": "查看原图"
        });
    };
    // - 点击文章图片，跳转原图地址 - 功能
    Article.prototype.open_img_page_action = function (this_obj) {
        window.open(this_obj.getAttribute("src"));
    };
    // - 点击文章链接，新页面打开
    Article.prototype.open_href_in_new_window = function () {
        $("#markdown_container a").attr({ "target": "_blank" });
    };
    // --- 初始化触发功能
    Article.prototype.set_open_event = function () {
        this.create_open_img_page_event();
        this.open_href_in_new_window();
        this.create_catalog();
        this.if_original();
    };

    // 事件
    // - 回复主楼
    Article.prototype.reply_floor = function (this_obj) {
        var _this = this;
        _this.check_login(function () {
            layer.prompt({
                title: "请输入回复内容",
                formType: 2
            }, function (content, layer_index) {
                var page_load_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
                $.ajax({
                    "url": api("comment", "reply_add"),
                    "type": "post",
                    "dataType": "json",
                    "data": {
                        "content": content,
                        "location": _this.article_id,
                        "parent_id": 0
                    },
                    "success": function (res) {
                        layer.close(layer_index);
                        layer.close(page_load_index);
                        if(res.code == 401) {
                            hlz_alert.open("请在页面顶部右侧，点击图标登陆");
                        } else if(res.code == 200) {
                            _this.get_comments_main();
                            layer.msg("评论成功！");
                        } else {
                            layer.msg(res.message);
                        }
                    },
                    "error": function () {
                        layer.close(layer_index);
                        layer.close(page_load_index);
                    }
                });
            });
        });
    };
    // - 回复子楼
    Article.prototype.reply_main_floor = function (this_obj) {
        var _this = this;
        var id = $(this_obj).attr("yth_main_floor"),
            name = $(this_obj).attr("yth_name");
        _this.check_login(function () {
            layer.prompt({
                title: '请输入回复 <span style="color: #ba55d3;">@' + name + '</span> 的内容',
                formType: 2
            }, function (content, layer_index) {
                $.ajax({
                    "url": api("comment", "reply_add"),
                    "type": "post",
                    "dataType": "json",
                    "data": {
                        "content": content,
                        "location": _this.article_id,
                        "parent_id": id
                    },
                    "success": function (res) {
                        layer.close(layer_index);
                        if(res.code == 401) {
                            hlz_alert.open("请在页面顶部右侧，点击图标登陆");
                        } else if(res.code == 200) {
                            // Get this floor's list
                            yth_pageination({
                                "api": api("comment", "info"),
                                "send_other_data": { "location": _this.article_id, "parent_id": id }, // 发送其他 Get 数据
                                "render_tpl": "article_comment_reply_tpl",
                                "render_html": "floor_id_" + id,
                                "pageination_id": "reply_his_pagination_" + id,
                                "loading_switch": false
                            });
                            layer.msg("回复成功！");
                        } else {
                            hlz_alert.open(res.message);
                        }
                    },
                    "error": function () {
                        layer.close(layer_index);
                    }
                });
            });
        });
    };
    Article.prototype.check_login = function (callback) {
        var _this = this
        _this.loading(SWITCH_ON)
        $.ajax({
            "url": api("comment", "check_login"),
            "dataType": "json",
            "success": function (res) {
                _this.loading(SWITCH_OFF)
                if(res.code == 401) {
                    layer.alert('请在页面顶部右侧，点击图标登陆')
                } else if(res.code == 200) {
                    callback();
                }
            },
            "error": function () {
                _this.loading(SWITCH_OFF)
            }
        });
    };
    Article.prototype.loading = function (_switch) {
        var _this = this;
        if(SWITCH_ON === _switch) {
            _this.loading_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
        } else {
            layer.close(_this.loading_index)
        }
    };

})(jQuery, window);

// - 留言板
(function ($, window, undefined) {
    'use strict';

    var SWITCH_OFF = false;
    var SWITCH_ON = true;

    function Board() {
        this.message_list_lock = false; // 请求成功后解锁，防止快速重复请求
        this.loading_index = 0;
    }
    window.board = new Board();
    Board.prototype.message_list = function () {
        var _this = this;
        // Judge By page_count 
        var page_count = parseInt($("#message_list").attr("yth_page_count")),
            total = parseInt($("#message_list").attr("yth_total")),
            to_page = parseInt($("#message_list").attr("yth_to_page"));
        if(to_page < page_count) {
            // console.log(to_page);
            if(_this.message_list_lock) {
                return;
            }
            to_page++;
            _this.message_list_lock = true;
            $.ajax({
                "url": api("comment", "info"),
                "type": "get",
                "dataType": "json",
                "data": {
                    "location": 0,
                    "parent_id": 0,
                    "to_page": to_page
                },
                "success": function (d) {
                    var tpl = $("#message_list_tpl").html(),
                        full_data = d.data.info;
                    laytpl(tpl).render(full_data, function (tpl_html) {
                        $("#message_list").append(tpl_html);
                    });
                    $("#message_list").attr({ "yth_to_page": to_page });
                    _this.message_list_lock = false;
                },
                "error": function () {
                    layer.close(layer_index);
                    _this.message_list_lock = false;
                }
            });
        }
    };
    Board.prototype.reply_floor = function () {
        var _this = this
        _this.check_login(function () {
            layer.prompt({
                title: "请留言内容",
                formType: 2
            }, function (content, layer_index) {
                _this.loading(SWITCH_ON)
                $.ajax({
                    "url": api("comment", "reply_add"),
                    "type": "post",
                    "dataType": "json",
                    "data": {
                        "content": content,
                        "location": 0,
                        "parent_id": 0
                    },
                    "success": function (res) {
                        _this.loading(SWITCH_OFF)
                        layer.close(layer_index);
                        if(res.code == 401) {
                            layer.alert('请在页面顶部右侧，点击图标登陆')
                        } else if(res.code == 200) {
                            layer.alert('评论成功~！')
                            location.reload()
                        }
                    },
                    "error": function () {
                        _this.loading(SWITCH_OFF)
                        layer.close(layer_index);
                    }
                });
            });
        });
    };
    Board.prototype.check_login = function (callback) {
        var _this = this
        _this.loading(SWITCH_ON)
        $.ajax({
            "url": api("comment", "check_login"),
            "dataType": "json",
            "success": function (res) {
                _this.loading(SWITCH_OFF)
                if(res.code == 401) {
                    layer.alert('请在页面顶部右侧，点击图标登陆')
                } else if(res.code == 200) {
                    callback();
                }
            },
            "error": function () {
                _this.loading(SWITCH_OFF)
            }
        });
    };
    Board.prototype.loading = function (_switch) {
        var _this = this;
        if(SWITCH_ON === _switch) {
            _this.loading_index = layer.load(0, { shade: [0.5, '#fff'] }); // 加载层 开启
        } else {
            layer.close(_this.loading_index)
        }
    };
    // - 如果到页面底部了
    Board.prototype.is_page_bottom = function () {
        var _this = this;
        $(window).scroll(function () {
            var tolerant = 5; // 容差值
            var scroll = parseInt(document.documentElement.scrollTop || document.body.scrollTop);
            // - 计算当前页面高度
            var tag_position = document.body.scrollHeight;
            var now = scroll + document.documentElement.clientHeight + tolerant;
            var is_reach = 'testing';
            if(now >= tag_position) {
                _this.message_list();
                is_reach = 'reach';
            }
        });
    };
})(jQuery, window);
